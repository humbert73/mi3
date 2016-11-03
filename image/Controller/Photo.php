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
        $this->data = new Data();
    }

    public function index()
    {
        $this->first();
    }

    public function first()
    {
        $this->buildDataImage($this->image_factory->getFirstImage());
        $this->buildViewPhoto();
    }

    public function last()
    {
        $this->buildDataImage($this->image_factory->getLastImage());
        $this->buildViewPhoto();
    }

    public function next()
    {
        $id = $this->getImageIdFromUrl();
        $this->buildDataImage($this->image_factory->getNextImageById($id));
        $this->buildViewPhoto();
    }

    public function previous()
    {
        $id = $this->getImageIdFromUrl();
        $this->buildDataImage($this->image_factory->getPreviousImageById($id));
        $this->buildViewPhoto();
    }

    protected function getImageIdFromUrl()
    {
        $id = 1;
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        return $id;
    }

    public function random()
    {
        $this->recupUrlData();
        $this->buildDataImage($this->image_factory->getRandomImage());
        $this->buildViewPhoto();
    }

    public function zoomPlus()
    {
        $this->data->zoom += self::ZOOM;
        $this->recupUrlData();
        $this->buildViewPhoto();
    }

    public function zoomMinus()
    {
        $this->data->zoom -= self::ZOOM;
        $this->recupUrlData();
        $this->buildViewPhoto();
    }

    protected function buildDataImage(Image $image)
    {
        $this->recupUrlData();
        $this->data->image_url = $image->getURL();
        $this->data->image_id = $image->getId();
    }

    public function buildViewPhoto()
    {
        $this->data->content = "photoView.php";
        $this->data->menu = $this->buildMenu();

        $this->includeMainView();
    }

    public function buildMenu()
    {
        $index = 'index.php';
        $controller_photo = '?controller=Photo';
        $controller_photoMatrix = '?controller=PhotoMatrix';
        $image_info = $this->buildAdditionalUrlImageInfo();
        $menu = array(
            'Home' => $index,
            'A propos' => $index . '?action=apropos',
            'Random' => $index . $controller_photo . '&action=random' . $image_info,
            'More'   => $index . $controller_photoMatrix .'&action=more'.$image_info.'&nbImg=1',
            'Zoom +' => $index . $controller_photo . '&action=zoomPlus' . $image_info,
            'Zoom -' => $index . $controller_photo . '&action=zoomMinus' . $image_info
        );

        return $menu;
    }

    protected function buildAdditionalUrlImageInfo()
    {
        return '&id=' . $this->data->image_id . '&size=' . $this->data->size;
    }

    protected function recupUrlData()
    {
        if (isset($_GET["id"])) {
            $image_id = $_GET["id"];
            $this->data->image_id = $image_id;
            $this->data->image_url = $this->image_factory->getImageById($image_id)->getURL();
        }
        if (isset($_GET["zoom"])) {
            $zoom = $_GET["zoom"];
            $this->data->zoom = $zoom;
        }
        if (isset($_GET["size"])) {
            $size = $_GET["size"];
            $this->data->size = $size * $this->data->zoom;
        }
    }

    protected function includeMainView()
    {
        include("View/mainView.php");
    }

    public function getLinkForAction($action)
    {
        $params = [
            "controller" => "Photo",
            "action" => $action,
            "id" => $this->data->image_id,
            "size" => $this->data->size
        ];

        return 'index.php?' . http_build_query($params);
    }
}