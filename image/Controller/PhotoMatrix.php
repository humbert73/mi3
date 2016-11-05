<?php

/**
 * Created by PhpStorm.
 * User: gonzalal
 * Date: 20/10/16
 * Time: 09:48
 */
require_once('Photo.php');

class PhotoMatrix extends Photo
{
    public $images_urls;

    public function __construct()
    {
        parent::__construct();
    }

    protected function buildAdditionalUrlImageInfo()
    {
        return parent::buildAdditionalUrlImageInfo().'&nbImg='.$this->data->nb_image;
    }

    protected function getController()
    {
        return 'PhotoMatrix';
    }

    protected function buildView()
    {
        $this->data->content = "photoMatrixView.php";
        $this->data->menu    = $this->buildMenu();
        $this->buildImagesUrls();

        $this->includeMainView();
    }

    public function more()
    {
        $this->recupUrlData();
        $this->data->nb_image = $this->moreNbImage($this->data->nb_image);
        $this->buildView();
    }

    public function less()
    {
        $this->recupUrlData();
        $this->data->nb_image = $this->lessNbImage($this->data->nb_image);
        $this->buildView();
    }

    protected function recupUrlData()
    {
        parent::recupUrlData();
        if (isset($_GET["nbImg"])) {
            $nb_image = $_GET["nbImg"];
            $this->data->nb_image = $nb_image;
        }
    }

    private function moreNbImage($nb_image)
    {
        return $nb_image * 2;
    }

    private function lessNbImage($nb_image)
    {
        if ($nb_image > 1) {
            $nb_image = $nb_image / 2;
        }

        return $nb_image;
    }

    private function buildImagesUrls()
    {
        $images     = $this->image_factory->getImagesByNbImage($this->data->image_id, $this->data->nb_image);
        $images_url = array();

        foreach ($images as $image) {
            $images_url[] = $image->getURL();
        }
        $this->images_urls = $images_url;
    }
}