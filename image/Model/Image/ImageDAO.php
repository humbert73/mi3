<?php

require_once("Image.php");
require_once("ImageFactory.php");

# Le 'Data Access Object' d'un ensemble images
class ImageDAO
{

    function __construct()
    {
        $dsn = 'sqlite:DB/image.db';
        $user = '';
        $pass = '';

        try {
            $this->db = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            die ("Erreur : " . $e->getMessage());
        }
    }

    # Retourne le nombre d'images référencées dans le DAO
    public function size()
    {
        $sql = "SELECT count(*) as size FROM image";
        $res = $this->db->query($sql);
        if ($res) {
            $row = $this->getFirstRow($res);
        }

        return $row['size'];
    }

    // Retourne les images appartenant à une catégorie
    public function getImageByCategory ($category){

        $sql = "SELECT * FROM image WHERE category = $category";

        $res = $this->db->query($sql);

        if ($res) {

            return $this->createImageFromRow($this->getFirstRow($res));

        } else {
            print "Error in getImageByCategory category = " . $category. "<br/>";
            $err = $this->db->errorInfo();
            print $err[2] . "<br/>";
        }

    }

    /*public function getCategory(){

        $sql = "SELECT DISTINCT category FROM image ";

        $res = $this->db->query($sql);

        $categories = array();
        while ($row = $res->fetch()) {
            $categories = $row['category'];
        }

        return $categories;

    }*/

    # Retourne un objet image correspondant à l'identifiant
    public function getImage($id)
    {
        $sql = "SELECT * FROM image WHERE id = $id";
        $res = $this->db->query($sql);
        if ($res) {
            return $this->createImageFromRow($this->getFirstRow($res));
        } else {
            print "Error in getImage. id=" . $id . "<br/>";
            $err = $this->db->errorInfo();
            print $err[2] . "<br/>";
        }
    }

    // Retourne une ligne
    private function getFirstRow($res)
    {
        return $res->fetch();
    }

    private function createImageFromRow($row)
    {
        return new Image($row['id'], ImageFactory::URL_IMAGE_PATH . $row['path']);
    }

    # Retourne la liste des images consécutives à partir d'une image
    public function getImageList($id,$nb) {
        # Verifie que le nombre d'image est non nul
        if (!$nb > 0) {
            debug_print_backtrace();
            trigger_error("Erreur dans ImageDAO.getImageList: nombre d'images nul");
        }

        $max = $id+$nb;

        while ($id < $this->size() && $id < $max) {

            $res[] = $this->getImage($id);

            $id++;
        }
        return $res;
    }

    public function searchCategory()
    {
        $sql = "SELECT DISTINCT(category) FROM image ";


        return $this->db->query($sql);
    }
}




