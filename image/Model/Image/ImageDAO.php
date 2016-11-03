<?php

require_once("Image.php");
require_once("ImageFactory.php");

# Le 'Data Access Object' d'un ensemble images
class ImageDAO
{

    # !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    # A MODIFIER EN FONCTION DE VOTRE INSTALLATION
    # !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    # Chemin LOCAL où se trouvent les images
    private $path = "/home/moreauhu/sites/image/Model/IMG/jons/external";
    # Chemin URL où se trouvent les images
    const urlPath = "http://localhost/mi3/image/Model/IMG/";

    # Tableau pour stocker tous les chemins des images
    private $imgEntry;

    private $image_factory;


    function __construct()
    {

        $dsn  = 'sqlite:DB/image.db'; // Data source name
        $user = ''; // Utilisateur
        $pass = ''; // Mot de passe
        try {
            $this->db = new PDO($dsn, $user, $pass); //$db est un attribut privé d'ImageDAO
        } catch (PDOException $e) {
            die ("Erreur : " . $e->getMessage());
        }
    }

    # Retourne le nombre d'images référencées dans le DAO
    function size()
    {
        $sql = "SELECT count(*) as size FROM image";
        $res = $this->db->query($sql);

        if ($res) {
            $row = $this->getFirstRow($res);
        }

        return $row['size'];
    }

    # Retourne un objet image correspondant à l'identifiant
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

    private function getFirstRow($res)
    {
        return $res->fetch();
    }

    # Retourne une image au hazard
    function getRandomImage()
    {
        $imgId = rand(1, $this->size());
        return $this->getImage($imgId);
    }

    # Retourne l'objet de la premiere image
    function getFirstImage()
    {
        return $this->getImage(1);
    }

    function getNextImage(Image $image)
    {
        $id = $image->getId();
        if ($id < $this->size()) {
            $image = $this->getImage($id + 1);
        }
        return $image;
    }

    # Retourne l'image précédente d'une image
    function getPreviousImage(Image $image)
    {
        $id = $image->getId();
        if ($id > 1) {
            $image = $this->getImage($id - 1);
        }
        return $image;
    }

    # saute en avant ou en arrière de $nb images
    # Retourne la nouvelle image
    function jumpToImage(image $img, $nb)
    {
        $id     = $img->getId();
        $nextId = $id + $nb;
        if ($nextId >= 1 && $nextId <= $this->size()) {
            $img = $this->getImage($nextId);
        }
        return $img;
    }

    # Retourne la liste des images consécutives à partir d'une image
    function getImageList($id, $nb)
    {
        # Verifie que le nombre d'image est non nul
        if (!$nb > 0) {
            debug_print_backtrace();
            trigger_error("Erreur dans ImageDAO.getImageList: nombre d'images nul");
        }

        $max = $id + $nb;

        while ($id < $this->size() && $id < $max) {

            $images[] = $this->getImage($id);
            $id++;
        }
        return $images;

    }

    private function createImageFromRow($row)
    {
    return new Image($row['id'], ImageFactory::URL_IMAGE_PATH . $row['path']);
    }
}

# Test unitaire
# Appeler le code PHP depuis le navigateur avec la variable test
# Exemple : http://localhost/image/model/imageDAO.php?test
if (isset($_GET["test"])) {
    echo "<H1>Test de la classe ImageDAO</H1>";
    $imgDAO = new ImageDAO();
    echo "<p>Creation de l'objet ImageDAO.</p>\n";
    echo "<p>La base contient " . $imgDAO->size() . " images.</p>\n";
    $img = $imgDAO->getFirstImage();
    echo "La premiere image est : " . $img->getURL() . "</p>\n";
    # Affiche l'image
    echo "<img src=\"" . $img->getURL() . "\"/>\n";
}
