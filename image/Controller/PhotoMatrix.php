<?php

/**
 * Created by PhpStorm.
 * User: gonzalal
 * Date: 20/10/16
 * Time: 09:48
 */
require_once ('Photo.php');

class PhotoMatrix extends Photo {

    protected $nbImg;

    public function __construct()
    {
        parent::__construct();
    }

    public function buildMenu()
    {
        $index            = 'index.php';
        $controller_photo = '?controller=Photo';
        $controller_photoMatrix = '?controller=PhotoMatrix';
        $image_info       = $this->buildAdditionalUrlImageInfo();
        $image_infoMatrix = $this->buildAdditionalUrlImageMatrixInfo();
        $menu             = array(
            'Home'     => $index,
            'A propos' => $index.'?action=displayAPropos',
            'First'    => $index.$controller_photo.'&action=first'.$image_info,
            'Random'   => $index.$controller_photo.'&action=random'.$image_info,
            'Zoom +'   => $index.$controller_photo.'&action=zoomPlus'.$image_info,
            'Zoom -'   => $index.$controller_photo.'&action=zoomMinus'.$image_info,
            'More' => $index.$controller_photoMatrix.'&action=more'.$image_infoMatrix,
            'Less' => $index.$controller_photoMatrix.'&action=less'.$image_infoMatrix,
        );

             return $menu;
    }

    protected function buildAdditionalUrlImageMatrixInfo()
    {
        return '&id='.$this->data->image_id.'&size='.$this->data->size.'&nbImg='.$this->data->nbImg;
    }

    protected function getImageNbImgFromUrl()
    {

        if (isset($_GET["nbImg"])) {
            $nbImg = $_GET["nbImg"];
        }

        return $nbImg;
    }

    protected function moreNbImg($nbImg)
    {
        $newMoreNbImg = $nbImg * 2;
        return $newMoreNbImg;
    }

    protected function lessNbImg($nbImg)
    {
        $newLessNbImg = $nbImg / 2;
        return $newLessNbImg;
    }

    public function buildMatrixViewPhoto()
    {
        $this->data->content = "photoMatrixView.php";
        $this->data->menu = $this->buildMenu();

        $this->includeMainView();
    }

    public function more()
    {

        $imageDAO = new ImageDAO();

        //Extrait l'id de l'image en cours à partir de son URL
        $id = $this->getImageIdFromUrl();

        //Extrait le nombre d'image affiché
        $this->nbImg = $this->getImageNbImgFromUrl();

        //affecte le nouveau nombre d'images à $nbImg
        $this->data->nbImg = $this->nbImg;
        $this->data->image_id = $id;

        // multiplie par 2 le nombre d'images
        $nbImg = $this->moreNbImg($this->nbImg);

        print_r($nbImg);
        //Tableau des URLs des images à afficher à partir de leur id
        $imgLst = $imageDAO->getImageList($id, $nbImg);

        $this->buildMatrixViewPhoto();

        //construit un tableau des URLs des images à afficher
        foreach ($imgLst as $key => $image){

            $imgMatrixURL [] = $imgLst[$key]->getURL();
        }
        
        return $imgMatrixURL;

    }

}