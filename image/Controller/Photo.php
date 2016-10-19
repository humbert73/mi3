<?php

require_once("Model/Image/image.php");
require_once("Model/Image/imageDAO.php");
require_once("Model/Data.php");

class Photo
{
    const ZOOM = 0.25;
    private $image_dao;
    private $view;
    private $menu;
    private $image;
    public  $size;
    public  $image_url;
    public  $data;

    public function __construct()
    {
        $this->image_dao = new ImageDAO();
        $this->data      = new Data();
    }

    public function index()
    {
        $this->first();
//        if (isset($_GET["imgId"])) {
//            $this->image = $this->image_dao->getImage($_GET["imgId"]);
//        } else {
//            $this->image = $this->image_dao->getFirstImage();
//        }
//        $this->data->image_url = $this->image->getURL();
//
//        if (isset($_GET["size"])) {
//            $this->size = $_GET["size"];
//        } else {
//            $this->size = 480;
//        }
//
//        $this->data->content = "photoView.php";
//        $this->data->menu    = $this->buildMenu();
//
//        $this->includeMainView();
    }

    public function first()
    {
        $this->buildDataImage($this->image_dao->getFirstImage());
        $this->data->content   = "photoView.php";
        $this->data->menu      = $this->buildMenu();

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

    private function buildUrlData()
    {
        $_GET["image_id"] = $this->data->image_id;
        $_GET["size"] = $this->data->size;
        $_GET["zoom"]= $this->data->zoom;
    }

    private function recupUrlData()
    {
        if (isset($_GET["image_id"])) {
            $image_id              = $_GET["image_id"];
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
        return '&image_id='.$this->data->image_id.'&zoom='.$this->data->zoom.'&size='.$this->data->size*$this->data->zoom;
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

    public function getView()
    {
        return $this->view;
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function getPrevImageId()
    {
        return $this->image_dao->getPrevImage($img)->getId();
    }

    private function includeMainView()
    {
        include("View/mainView.php");
    }

    public function getLinkNextImage()
    {
        //$next_image_id = $this->image_dao->getNextImage($this->image)->getId();

        // return "index.php?controller=Photo&imgId=$next_image_id&size=$this->size";
        return "index.php?controller=Photo&action=next";
    }

    public function getLinkPreviousImage()
    {
        //$prev_image_id = $this->image_dao->getNextImage(    $this->image)->getId();

        //return "index.php?controller=Photo&imgId=$prev_image_id&size=$this->size";
        return "index.php?controller=Photo&action=previous";
    }

    public function getLinkImage()
    {
//        $image_id = $this->image->getId();
//        return "zoom.php?zoom=1.25&imgId=$image_id&size=$this->size";

        return $this->data->image_url;
    }
}