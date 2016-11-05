<?php

require_once("Model/Image/Image.php");
require_once("Model/Image/ImageDAO.php");
require_once("Model/Data.php");

class Photo
{
    const ZOOM = 0.25;
    public $image_factory;
    public $data;

    public function __construct()
    {
        $this->image_factory = new ImageFactory(new ImageDAO());
        $this->data          = new Data();
    }

    public function index()
    {
        $this->first();
    }

    public function random()
    {
        $this->recupUrlData();
        $this->buildDataImage($this->image_factory->getRandomImage());
        $this->buildView();
    }

    public function zoomPlus()
    {
        $this->data->zoom += self::ZOOM;
        $this->recupUrlData();
        $this->buildView();
    }

    public function zoomMinus()
    {
        $this->data->zoom -= self::ZOOM;
        $this->recupUrlData();
        $this->buildView();
    }

    public function first()
    {
        $this->buildDataImage($this->image_factory->getFirstImage());
        $this->buildView();
    }

    public function last()
    {
        $this->buildDataImage($this->image_factory->getLastImage());
        $this->buildView();
    }

    public function next()
    {
        $id = $this->getImageIdFromUrl();
        $this->buildDataImage($this->image_factory->getNextImageById($id));
        $this->buildView();
    }

    public function previous()
    {
        $id = $this->getImageIdFromUrl();
        $this->buildDataImage($this->image_factory->getPreviousImageById($id));
        $this->buildView();
    }

    protected function getImageIdFromUrl()
    {
        $id = 1;
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        return $id;
    }

    protected function buildDataImage(Image $image)
    {
        $this->recupUrlData();
        $this->data->image_url = $image->getURL();
        $this->data->image_id  = $image->getId();
    }

    protected function buildView()
    {
        $this->data->content = "photoView.php";
        $this->data->menu    = $this->buildMenu();

        $this->includeMainView();
    }

    protected function buildMenu()
    {
        $index      = 'index.php';
        $controller = '?controller='.$this->getController();
        $image_info = $this->buildAdditionalUrlImageInfo();
        $menu       = array(
            'Home'     => $index,
            'A propos' => $index.'?action=apropos',
            'Random'   => $index.$controller.'&action=random'.$image_info,
            'Zoom +'   => $index.$controller.'&action=zoomPlus'.$image_info,
            'Zoom -'   => $index.$controller.'&action=zoomMinus'.$image_info,
        );
        if ($this->getController() === 'Photo') {
            $controller = $controller.'Matrix';
        }
        $menu['More'] = $index.$controller.'&action=more'.$image_info;
        $menu['Less'] = $index.$controller.'&action=less'.$image_info;

        return $menu;
    }

    protected function getController()
    {
        return 'Photo';
    }

    protected function buildAdditionalUrlImageInfo()
    {
        return '&id='.$this->data->image_id.'&size='.$this->data->size;
    }

    protected function recupUrlData()
    {
        if (isset($_GET["id"])) {
            $image_id              = $_GET["id"];
            $this->data->image_id  = $image_id;
            $this->data->image_url = $this->image_factory->getImageById($image_id)->getURL();
        }
        if (isset($_GET["zoom"])) {
            $zoom             = $_GET["zoom"];
            $this->data->zoom = $zoom;
        }
        if (isset($_GET["size"])) {
            $size             = $_GET["size"];
            $this->data->size = $size * $this->data->zoom;
        }
    }

    protected function includeMainView()
    {
        include("View/mainView.php");
    }

    private function getLinkForAction($action)
    {
        $params = [
            "controller" => "Photo",
            "action"     => $action,
            "id"         => $this->data->image_id,
            "size"       => $this->data->size
        ];

        return 'index.php?'.http_build_query($params);
    }
}