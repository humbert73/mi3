<?php

require_once("image.php");
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

    # Lecture récursive d'un répertoire d'images
    # Ce ne sont pas des objets qui sont stockes mais juste
    # des chemins vers les images.
    private function readDir($dir)
    {
        # build the full path using location of the image base
        $fdir = $this->path . $dir;
        if (is_dir($fdir)) {
            $d = opendir($fdir);
            while (($file = readdir($d)) !== false) {
                if (is_dir($fdir . "/" . $file)) {
                    # This entry is a directory, just have to avoid . and .. or anything starts with '.'
                    if ($file[0] != '.') {
                        # a recursive call
                        $this->readDir($dir . "/" . $file);
                    }
                } else {
                    # a simple file, store it in the file list
                    if ($file[0] != '.') {
                        $this->imgEntry[] = "$dir/$file";
                    }
                }
            }
        }
    }

    function __construct()
    {
        $this->image_factory = new ImageFactory();

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
    function getImage($id)
    {
        $sql = "SELECT * FROM image WHERE id = $id";
        $res = $this->db->query($sql);
        if ($res) {
            $row = $this->getFirstRow($res);

            return $this->image_factory->createImage($row);
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

    # Retourne l'image suivante d'une image
    function getNextImage(image $img)
    {
        $id = $img->getId();
        if ($id < $this->size()) {
            $img = $this->getImage($id + 1);
        }
        return $img;
    }

    # Retourne l'image précédente d'une image
    function getPrevImage(image $img)
    {
        $id = $img->getId();
        if ($id > 1) {
            $img = $this->getImage($id - 1);
        }
        return $img;
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
    function getImageList(image $img, $nb)
    {
        # Verifie que le nombre d'image est non nul
        if (!$nb > 0) {
            debug_print_backtrace();
            trigger_error("Erreur dans ImageDAO.getImageList: nombre d'images nul");
        }
        $id  = $img->getId();
        $max = $id + $nb;
        while ($id < $this->size() && $id < $max) {
            $res[] = $this->getImage($id);
            $id++;
        }
        return $res;
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
