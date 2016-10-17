<?php

require_once("Model/Image/image.php");
require_once("Model/Image/imageDAO.php");

class Photo
{
    private $imgDAO;
    private $view;
    private $menu;
    private $image;
    public $size;
    public $image_url;

    public function __construct()
    {
        $this->imgDAO = new ImageDAO();
    }

    public function display()
    {
        if (isset($_GET["imgId"])) {
            $this->image = $this->imgDAO->getImage($_GET["imgId"]);
        } else {
            $this->image = $this->imgDAO->getFirstImage();
        }
        $this->image_url = $this->image->getURL();

        if (isset($_GET["size"])) {
            $this->size = $_GET["size"];
        } else {
            $this->size = 480;
        }

        $this->imgDAO = new ImageDAO();

        $this->view = "View/viewPhoto.php";
        $this->menu = $this->buildMenu();

        $this->includeMainView();
    }

    public function random()
    {
        if (isset($_GET["size"])) {
            $this->size = $_GET["size"];
        } else {
            $this->size = 480;
        }

        $this->imgDAO = new ImageDAO();

        $this->image = $this->imgDAO->getRandomImage();
        $this->image_url = $this->image->getURL();

        $this->view = "View/viewPhoto.php";
        $this->menu = $this->buildMenu();

        $this->includeMainView();
    }

    public function buildMenu()
    {
//        $random_image_id = $this->imgDAO->getRandomImage()->getId();
//        $first_image_id  = $this->imgDAO->getFirstImage()->getId();
//        $image_id        = $this->image->getId();

        $menu = array(
            'Home'     => 'index.php',
            'A propos' => 'index.php?action=displayAPropos',
            'First'    => 'index.php?controller=Photo&action=first',
            'Random'    => 'index.php?controller=Photo&action=random',
            'Zoom +'    => 'index.php?controller=Photo&action=zoomplus',
            'Zoom -'    => 'index.php?controller=Photo&action=zoomminus'
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
        return  $this->imgDAO->getPrevImage($img)->getId();
    }

    private function includeMainView()
    {
        include("View/viewMain.php");
    }

    public function getLinkNextImage()
    {
        $next_image_id = $this->imgDAO->getNextImage($this->image)->getId();

        return "index.php?controller=Photo&imgId=$next_image_id&size=$this->size";
    }

    public function getLinkPrevImage()
    {
        $prev_image_id = $this->imgDAO->getNextImage($this->image)->getId();

        return "index.php?controller=Photo&imgId=$prev_image_id&size=$this->size";
    }

    public function getLinkImage()
    {
        $image_id = $this->image->getId();
        return "zoom.php?zoom=1.25&imgId=$image_id&size=$this->size";
    }
}