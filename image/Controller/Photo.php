<?php

require_once("Model/Image/Image.php");
require_once("Model/Image/ImageDAO.php");
require_once("Model/Data.php");

class Photo
{
    const ZOOM = 0.25;
    private $image_dao;
    private $menu;
    public  $size;
    public  $image_url;
    public  $data;
    public  $imageId;

    public function __construct()
    {
        $this->image_dao = new ImageDAO();
        $this->data      = new Data();
    }

    public function index()
    {
        $this->first();
    }

    public function first()
    {
        $this->buildDataImage($this->image_dao->getFirstImage());
        $this->data->content = "photoView.php";
        $this->data->menu    = $this->buildMenu();

        $this->includeMainView();
    }

    public function next()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        } else {
            $id = 1;
        }
        $this->buildDataImage($this->image_dao->getNextImage($this->image_dao->getImage($id)));
        $this->data->content = "photoView.php";
        $this->data->menu    = $this->buildMenu();

        $this->includeMainView();
    }

    public function previous()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        } else {
            $id = 1;
        }
        $this->buildDataImage($this->image_dao->getPreviousImage($this->image_dao->getImage($id)));
        $this->data->content = "photoView.php";
        $this->data->menu    = $this->buildMenu();

        $this->includeMainView();
    }

    public function random()
    {
        $this->recupUrlData();
        $this->buildDataImage($this->image_dao->getRandomImage());
        $this->data->content = "photoView.php";
        $this->data->menu    = $this->buildMenu();

        $this->includeMainView();
    }

    public function zoomPlus()
    {
        $this->recupUrlData();
        $this->data->zoom   += self::ZOOM;
        $this->data->content = "photoView.php";
        $this->data->menu    = $this->buildMenu();

        $this->includeMainView();
    }

    public function zoomMinus()
    {
        $this->recupUrlData();
        $this->data->zoom   -= self::ZOOM;
        $this->data->content = "photoView.php";
        $this->data->menu    = $this->buildMenu();

        $this->includeMainView();
    }

    private function buildDataImage(Image $image)
    {
        $this->recupUrlData();
        $this->data->image_url = $image->getURL();
        $this->data->image_id  = $image->getId();
    }

    private function recupUrlData()
    {
        if (isset($_GET["id"])) {
            $image_id              = $_GET["id"];
            $this->data->image_id  = $image_id;
            $this->data->image_url = $this->image_dao->getImage($image_id)->getURL();
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

    private function buildAdditionalUrlImageInfo()
    {
        return '&id='.$this->data->image_id.'&size='.$this->data->size * $this->data->zoom;
    }

    public function buildMenu()
    {
        $index            = 'index.php';
        $controller_photo = '?controller=Photo';
        $image_info       = $this->buildAdditionalUrlImageInfo();
        $menu             = array(
            'Home'     => $index,
            'A propos' => $index.'?action=displayAPropos',
            'First'    => $index.$controller_photo.'&action=first'.$image_info,
            'Random'   => $index.$controller_photo.'&action=random'.$image_info,
            'Zoom +'   => $index.$controller_photo.'&action=zoomPlus'.$image_info,
            'Zoom -'   => $index.$controller_photo.'&action=zoomMinus'.$image_info
        );

        return $menu;
    }

    private function includeMainView()
    {
        include("View/mainView.php");
    }

    public function getLinkNextImage()
    {
        return 'index.php?controller=Photo&action=next&id='.$this->data->image_id.'&size='.$this->data->size;
    }

    public function getLinkPreviousImage()
    {
        return 'index.php?controller=Photo&action=previous&id='.$this->data->image_id.'&size='.$this->data->size;
    }
}