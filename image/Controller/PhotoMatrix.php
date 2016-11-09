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

    public function displayByCategory(){

        if(isset ($_POST['submitChoiceCategory'])){

            if (isset ($_POST['choice_category']) && $_POST['choice_category'] != 'default'){

                $category = $_POST['choice_category'];

                $images     = $this->image_factory->getImageByCategory($category);

                $images_url = array();

                foreach ($images as $image) {

                    $images_url[] = $image->getURL();
                }

                $this->images_urls = $images_url;

            }

            $this->data->content = "photoMatrixView.php";
            $this->data->menu    = $this->buildMenu();
            $this->includeMainView();

        }


    }

    public function last()
    {
        $this->recupUrlData();
        $this->data->image_id = $this->image_factory->getLastImageId($this->data->nb_image);
        $this->buildView();
    }

    public function less()
    {
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
        $params = array(
            'nbImg' => $this->data->nb_image
        );
        if (isset($this->data->image_category)) {
            $params[] = $this->data->image_category;
        }
        return parent::buildAdditionalUrlImageInfo().'&'.http_build_query($params);
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

    protected function recupUrlData()
    {
        parent::recupUrlData();
        if (isset($_GET["nbImg"])) {
            $nb_image             = $_GET["nbImg"];
            $this->data->nb_image = $nb_image;
        }
        if (isset($_POST["choiceCategory"])) {
            $image_category             = $_POST["choiceCategory"];
            $this->data->image_category = $image_category;
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
        if ($this->hasCategorySelected()) {
            $images = $this->image_factory->getImagesByCategory($this->data->image_category);
        } else {
            $images = $this->image_factory->getImagesByNbImage($this->data->image_id, $this->data->nb_image);
        }

        $images_url = array();

        foreach ($images as $image) {
            $images_url[] = $image->getURL();
        }
        $this->data->image_id = $images[0]->getId();
        $this->images_urls    = $images_url;
    }

    private function hasCategorySelected()
    {
        return isset($this->data->image_category);
    }

    protected function getLinkForAction($action)
    {
        $params = [
            "nbImg" => $this->data->nb_image,
        ];

        return parent::getLinkForAction($action).'&'.http_build_query($params);
    }

}