<?php


class ImageFactory
{
    # !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    # A MODIFIER EN FONCTION DE VOTRE INSTALLATION
    # !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    const URL_IMAGE_PATH = "http://localhost/mi3/image/Model/IMG/";

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
        return $this->image_dao->getImage($this->getLastImageId());
    }

    public function getLastImageId($nb_image = 1)
    {
        return $this->getLastId()-$nb_image+1;
    }

    private function getFirstId()
    {
        return 1;
    }

    private function getLastId()
    {
        return $this->image_dao->size();
    }

    public function getNextImageId($id, $nb_image = 1)
    {
        if ($id + $nb_image <= $this->image_dao->size()) {
            $id += $nb_image;
        } else {
            $id = $this->image_dao->size()-$nb_image+1;
        }

        return $id;
    }

    public function getPreviousImageId($id, $nb_image = 1)
    {
        if ($id - $nb_image >= 1) {
            $id -= $nb_image;
        }

        return $id;
    }

    /**
     * @return Image
     */
    public function getNextImageById($id)
    {
        return $this->image_dao->getImage($this->getNextImageId($id));
    }

    /**
     * @return Image
     */
    public function getPreviousImageById($id)
    {
        return $this->image_dao->getImage($this->getPreviousImageId($id));
    }

    public function jumpToImage(image $img, $nb)
    {
        $id     = $img->getId();
        $nextId = $id + $nb;
        if ($nextId >= 1 && $nextId <= $this->image_dao->size()) {
            $img = $this->image_dao->getImage($nextId);
        }

        return $img;
    }

    public function getImagesByNbImage($image_id, $nb_image)
    {
        # Verifie que le nombre d'image est non nul
        if (! $nb_image > 0) {
            debug_print_backtrace();
            trigger_error("Erreur dans ImageDAO.getImageList: nombre d'images nul");
        }

        $max_id = $image_id + $nb_image;
        $images = array();

        while ($image_id <= $this->image_dao->size() && $image_id < $max_id) {
            $images[] = $this->image_dao->getImage($image_id);
            $image_id++;
        }

        return $images;
    }
}