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

    private function createImageFromRow($row)
    {
        return new Image($row['id'], ImageFactory::URL_IMAGE_PATH . $row['path']);
    }
}


# Test unitaire
# Appeler le code PHP depuis le navigateur avec la variable test
# Exemple : http://localhost/image/Model/Image/ImageDAO.php?test
//if (isset($_GET["test"])) {
//    echo "<H1>Test de la classe ImageDAO</H1>";
//    $imgDAO = new ImageDAO();
//    echo "<p>Creation de l'objet ImageDAO.</p>\n";
//    echo "<p>La base contient " . $imgDAO->size() . " images.</p>\n";
//    echo "<p>Test de getImageId :";
//    echo "La premiere image est : " . $imgDAO->getImage(1)->getURL() . "</p>\n";
//    # Affiche l'image
//    echo "<img src=\"" . $img->getURL() . "\"/>\n";
//}

