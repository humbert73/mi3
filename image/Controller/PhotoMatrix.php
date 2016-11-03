<?php

/**
 * Created by PhpStorm.
 * User: gonzalal
 * Date: 20/10/16
 * Time: 09:48
 */
require_once ('Photo.php');

class PhotoMatrix extends Photo {

    protected $nbImg = 1;

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
        $image_infoMatrix = $this->buildAdditionalUrlImageInfo();
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

    protected function buildAdditionalUrlImageInfo()
    {
        return '&id='.$this->data->image_id.'&size='.$this->data->size.'&nbImg='.$this->data->nbImg;
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

    /*protected function buildDataImage(Image $image)
    {
        parent::buildDataImage($image);
        $this->data->nbImg = $this->nbImg;

    }*/

    public function more()
    {
        $this->imageId = 1;

        $image = $this->image_dao->getImage($this->imageId);

        print_r('id :'.$this->imageId);
        $nbImg=$this->nbImg;

        $nbImg = $this->moreNbImg($nbImg);
        print_r('nbImg après fonction more : '.$nbImg);

        $this->buildDataImage($image);

        $id = $this->data->image_id;

        // construit un tableau avec les id des images affichées
        $imgLst = $this->image_dao->getImageList($id, $nbImg);

        var_dump($imgLst[1]->getURL());

        foreach ($imgLst as $key => $image){

            $imgMatrixURL = $image[$key]->getURL();

        }

        return $imgMatrixURL;

    }

}