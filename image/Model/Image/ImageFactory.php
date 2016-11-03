<?php

class ImageFactory
{
    # !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    # A MODIFIER EN FONCTION DE VOTRE INSTALLATION
    # !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    const URL_IMAGE_PATH = "http://localhost:63342/image/Model/IMG/";

    private $image_dao;

    public function __construct(ImageDAO $image_dao)
    {
        $this->image_dao = $image_dao;
    }

    public function getImageById($id)
    {
        return $this->image_dao->getImage($id);
    }

    # Retourne une image au hazard
    public function getRandomImage()
    {
        return $this->image_dao->getImage(rand($this->getFirstId(), $this->getLastId()));
    }

    # Retourne l'objet de la premiere image
    function getFirstImage()
    {
        return $this->image_dao->getImage($this->getFirstId());
    }

    public function getLastImage()
    {
        return $this->image_dao->getImage($this->getLastId());
    }

    private function getFirstId()
    {
        return 1;
    }

    private function getLastId()
    {
        return $this->image_dao->size();
    }
    /**
     * @return Image
     */
    public function getNextImageById($id)
    {
        if ($id < $this->image_dao->size()) {
            $image = $this->image_dao->getImage($id + 1);
        } else {
            $image = $this->image_dao->getImage($id);
        }
        return $image;
    }
    /**
     * @return Image
     */
    public function getPreviousImageById($id)
    {
        if ($id > 1) {
            $image = $this->image_dao->getImage($id - 1);
        } else {
            $image = $this->image_dao->getImage($id);
        }
        return $image;
    }
    public function jumpToImage(image $img, $nb)
    {
        $id = $img->getId();
        $nextId = $id + $nb;
        if ($nextId >= 1 && $nextId <= $this->image_dao->size()) {
            $img = $this->image_dao->getImage($nextId);
        }
        return $img;
    }
    # Retourne la liste des images consécutives à partir d'une image
//    public function getImageList(image $img, $nb)
//    {
//        # Verifie que le nombre d'image est non nul
//        if (!$nb > 0) {
//            debug_print_backtrace();
//            trigger_error("Erreur dans ImageDAO.getImageList: nombre d'images nul");
//        }
//        $id = $img->getId();
//        $max = $id + $nb;
//        while ($id < $this->image_dao->size() && $id < $max) {
//            $res[] = $this->getImageById($id);
//            $id++;
//        }
//        return $res;
//    }

}