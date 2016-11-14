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


    public function first()
    {
        $this->recupUrlData();
        $this->buildFirstImageId();
        $this->buildView();
    }

    public function last()
    {
        $this->recupUrlData();
        $this->buildLastImageId();
        $this->buildView();
    }

    public function next()
    {
        $this->recupUrlData();
        $this->buildDataImage($this->image_factory->getNextImageById($this->data->image_id, $this->data->nb_image));
        $this->buildView();
    }

    public function previous()
    {
        $this->recupUrlData();
        $this->buildDataImage($this->image_factory->getPreviousImageById($this->data->image_id, $this->data->nb_image));
        $this->buildView();
    }

    public function displayByCategory()
    {
        $this->recupUrlData();
        $this->buildDataImage($this->image_factory->getFirstImageByCategory($this->data->choose_category, $this->data->nb_image));
        $this->buildView();
    }

    protected function getController()
    {
        return self::CONTROLLER_NAME;
    }

    protected function buildView()
    {
        $this->data->content    = "photoMatrixView.php";
        $this->data->menu       = $this->buildMenu();
        $this->data->categories = $this->image_factory->getCategories();
        $this->buildImagesUrls();
        $this->includeMainView();
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
        $images_url = array();
        if ($this->hasCategorySelected()) {
            $images = $this->image_factory->getImagesByCategory($this->data->choose_category, $this->data->nb_image);
        } else {
            $images = $this->image_factory->getImagesByNbImage($this->data->image_id, $this->data->nb_image);
        }
        foreach ($images as $image) {
            $images_url[] = $image->getURL();
        }
        $this->data->image_id = $images[0]->getId();
        $this->images_urls    = $images_url;
    }

    private function hasCategorySelected()
    {
        return isset($this->data->choose_category);
    }

    private function buildFirstImageId()
    {
        if (!empty($_GET['choose-category'])) {
            $category             = $_GET['choose-category'];
            $image = $this->image_factory->getFirstImageByCategory($category, $this->data->nb_image);
        } else {
            $image = $this->image_factory->getFirstImage();
        }
        $this->buildDataImage($image);
    }

    private function buildLastImageId()
    {
        if (!empty($_GET['choose-category'])) {
            $category             = $_GET['choose-category'];
            $this->data->image_id = $this->image_factory->getLastImageByCategory($category, $this->data->nb_image)->getId();
        } else {
            $this->data->image_id = $this->image_factory->getLastImageId($this->data->nb_image);
        }
    }

    protected function recupUrlData()
    {
        parent::recupUrlData();

        if (!empty($_GET["nbImg"])) {
            $this->data->nb_image = $_GET["nbImg"];
        }
        if (!empty($_GET['choose-category'])) {
           $this->data->choose_category = $_GET['choose-category'];
           // $this->data->nb_image = sizeof($this->image_factory->getImagesByCategory($_GET['choose-category']));
        }

        if (!empty($_POST["choiceCategory"])) {
            $this->data->choose_category = $_POST["choiceCategory"];
        }

    }

    //Pour générer les liens des actions pour les formulaires
    protected function getLinkForAction($action)
    {
        $params = [
            "nbImg" => $this->data->nb_image
        ];

        if ($this->hasCategorySelected()) {
            $params['choose-category'] = $this->data->choose_category;
        }

        return parent::getLinkForAction($action) . '&' . http_build_query($params);
    }

    // Poug générer les url des menus
    protected function buildAdditionalUrlImageInfo()
    {
        $params = [
            "nbImg" => $this->data->nb_image
        ];

        if ($this->hasCategorySelected()) {
            $params['nbImg'] = sizeof($this->image_factory->getImagesByCategory($this->data->choose_category));
            $params['choose-category'] = $this->data->choose_category;
        }

        return parent::buildAdditionalUrlImageInfo() . '&' . http_build_query($params);
    }
}