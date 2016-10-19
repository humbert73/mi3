<?php

require_once("Model/Image/image.php");
require_once("Model/Image/imageDAO.php");
require_once("Model/Data.php");

class Photo
{
    private $image_dao;
    private $view;
    private $menu;
    private $image;
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
        $this->data->image_url = $this->image_dao->getFirstImage()->getURL();
        $this->data->content   = "photoView.php";
        $this->data->menu      = $this->buildMenu();

        $this->includeMainView();
    }

    public function next(){

        $this->data->image_id = $this->image_dao->getNextImage()->getId();

        $this->data->image_url = $this->image_dao->getImage($this->data->image_id-1)->getURL();
        $this->data->content   = "photoView.php";
        $this->data->menu      = $this->buildMenu();

        $this->includeMainView();

    }

    public function previous(){

        $this->data->image_id = $this->image_dao->getPrevImage()->getId();


             if ($this->data->image_id == NULL) {
                $this->data->image_url = $this->image_dao->getImage(1)->getURL();
            } else {
                $this->data->image_url = $this->image_dao->getImage($this->data->image_id+1)->getURL();
            }

        $this->data->content   = "photoView.php";
        $this->data->menu      = $this->buildMenu();

        $this->includeMainView();

    }

    public function random()
    {
        if (isset($_GET["size"])) {
            $this->size = $_GET["size"];
        } else {
            $this->size = 480;
        }

        $this->data->image_url = $this->image_dao->getRandomImage()->getURL();
        $this->data->content   = "photoView.php";
        $this->data->menu      = $this->buildMenu();
        $this->data->image_id  = $this->image_dao->getRandomImage()->getId();

        $this->includeMainView();
    }

    public function buildId(){

        $imageId = $this->image->getId();

        return $imageId;
    }

    public function buildMenu()
    {
//        $random_image_id = $this->imgDAO->getRandomImage()->getId();
//        $first_image_id  = $this->imgDAO->getFirstImage()->getId();
//        $image_id        = $this->image->getId();

        $menu = array(
            'Home'     => 'index.php',
            'A propos' => 'index.php?action=displayAPropos',
            'First'    => 'index.php?id=1&controller=Photo&action=first',
            'Random'   => 'index.php?id='.$this->image_dao->getRandomImage()->getId().'&controller=Photo&action=random',
            'Zoom +'   => 'index.php?controller=Photo&action=zoomplus',
            'Zoom -'   => 'index.php?controller=Photo&action=zoomminus'
        );
//        $menu['More']     = "viewPhotoMatrix.php?imgId=$image_id"; # Pour afficher plus d'image passe à une autre page
//        $menu['Zoom +']   = "zoom.php?zoom=1.25&imgId=$image_id&size=$this->size"; // Demande à calculer un zoom sur l'image
//        $menu['Zoom -']   = "zoom.php?zoom=0.75&imgId=$image_id&size=$this->size"; // Demande à calculer un zoom sur l'image

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
        return  $this->image_dao->getPrevImage($img)->getId();
    }

    private function includeMainView()
    {
        include("View/mainView.php");
    }

    public function getLinkNextImage()
    {

        return 'index.php?id='.$this->image_dao->getNextImage()->getId().'&controller=Photo&action=next';
    }

    public function getLinkPreviousImage()
    {
        //$prev_image_id = $this->image_dao->getNextImage(    $this->image)->getId();

        //return "index.php?controller=Photo&imgId=$prev_image_id&size=$this->size";
        return 'index.php?id='.$this->image_dao->getPrevImage()->getId().'&controller=Photo&action=previous';
    }

    public function getLinkImage()
    {
//        $image_id = $this->image->getId();
//        return "zoom.php?zoom=1.25&imgId=$image_id&size=$this->size";

            return $this->data->image_url;
    }
}