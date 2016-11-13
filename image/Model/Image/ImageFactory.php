<?php


class ImageFactory
{
    # !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    # A MODIFIER EN FONCTION DE VOTRE INSTALLATION
    # !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    const URL_IMAGE_PATH = Home::MY_PATH . '/Model/IMG/';

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
        return $this->getLastId() - $nb_image + 1;
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
            $id = $this->image_dao->size() - $nb_image + 1;
        }

        return $id;
    }

    private function getPreviousImageId($id, $nb_image = 1)
    {
        if ($id - $nb_image >= 1) {
            $id -= $nb_image;
        }

        return $id;
    }

    /**
     * @return Image
     */
    public function getNextImageById($id, $nb_image = 0)
    {
        if ($nb_image === 0) {
            $id = $this->getNextImageId($id);
        } else {
            $id = $this->getNextImageId($id, $nb_image);
        }

        return $this->image_dao->getImage($id);
    }

    /**
     * @return Image
     */
    public function getPreviousImageById($id, $nb_image = 0)
    {
        if ($nb_image === 0) {
            $id = $this->getPreviousImageId($id);
        } else {
            $id = $this->getPreviousImageId($id, $nb_image);
        }

        return $this->image_dao->getImage($id);
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

    // Retourne les images appartenant à une catégorie
    public function getImagesByCategory($category, $nb_image = 1)
    {
        $dar                = $this->image_dao->searchImagesByCategory($category);
        $images_by_category = array();
        $images             = array();

        if ($dar) {
            foreach ($dar as $row) {
                $images_by_category[] = $this->image_dao->createImageFromRow($row);
            }
        } else {
            print "Error in getImageByCategory category = " . $category . "<br/>";
            $err = $this->image_dao->db->errorInfo();
            print $err[2] . "<br/>";
        }

        $size = sizeof($images_by_category);

        for ($i = 0; $i <= $size - 1 && $i < $nb_image; $i++) {
            $images[] = $this->image_dao->getImage($images_by_category[$i]->getId());
        }

        return $images;
    }

    public function getCategories()
    {
        $dar        = $this->image_dao->searchCategories();
        $categories = array();
        foreach ($dar as $row) {
            $categories[] = $row['category'];
        }

        return $categories;
    }

    public function getFirstImageByCategory($category, $nb_image)
    {
        return $this->getImagesByCategory($category, $nb_image)[0];
    }

    public function getLastImageByCategory($category, $nb_image)
    {
        $images = $this->getImagesByCategory($category, $nb_image);

        return $images[sizeof($images) - $nb_image];
    }

    public function addImage($link, $category, $comment)
    {
        return $this->image_dao->createImage($link, $category, $comment);

    }
}