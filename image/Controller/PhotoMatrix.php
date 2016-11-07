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
    const CONTROLLER_NAME = 'PhotoMatrix';
    public $images_urls;
    public $category;

    public function __construct()
    {
        parent::__construct();
    }

    public function more()
    {
        $this->data->zoom -= self::ZOOM;
        $this->recupUrlData();
        $this->data->nb_image = $this->moreNbImage($this->data->nb_image);
        $this->buildView();
    }

    public function byCategory(){

        $this->recupUrlData();
        $this->buildView();
    }

    public function last()
    {
        $this->recupUrlData();
        $this->data->image_id =  $this->image_factory->getLastImageId($this->data->nb_image);
        $this->buildView();
    }

    public function less()
    {
        $this->data->zoom += self::ZOOM;
        $this->recupUrlData();
        $this->data->nb_image = $this->lessNbImage($this->data->nb_image);
        $this->buildView();
    }

    public function next()
    {
        $this->recupUrlData();
        $this->data->image_id = $this->image_factory->getNextImageId($this->data->image_id, $this->data->nb_image);
        $this->buildView();
    }

    public function previous()
    {
        $this->recupUrlData();
        $this->data->image_id = $this->image_factory->getPreviousImageId($this->data->image_id, $this->data->nb_image);
        $this->buildView();
    }

    protected function buildAdditionalUrlImageInfo()
    {
        return parent::buildAdditionalUrlImageInfo().'&nbImg='.$this->data->nb_image;
    }

    protected function getController()
    {
        return self::CONTROLLER_NAME;
    }

    protected function buildView()
    {
        $this->data->content = "photoMatrixView.php";
        $this->data->menu    = $this->buildMenu();
        $this->buildImagesUrls();

        $this->includeMainView();
    }

    protected function recupUrlData()
    {
        parent::recupUrlData();
        if (isset($_GET["nbImg"])) {
            $nb_image = $_GET["nbImg"];
            $this->data->nb_image = $nb_image;
        }
        if (isset($_GET["cat"])) {
            $image_cat = $_GET["cat"];
            $this->data->image_cat = $image_cat;
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

    protected function getLinkForAction($action)
    {
        $params = [
            "nbImg"         => $this->data->nb_image,
        ];

        return parent::getLinkForAction($action).'&'.http_build_query($params);
    }
}