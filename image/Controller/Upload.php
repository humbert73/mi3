<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 08/11/16
 * Time: 16:34
 */

require_once("Model/Image/Image.php");
require_once("Model/Image/ImageDAO.php");
require_once("Model/Data.php");
require_once('Controller/Header.php');


class Upload
{
    const CONTROLLER_NAME = 'Upload';
    const IMAGE_DIR_NAME = '/upload/';
    const MAX_WIDTH = 600;
    const MAX_HEIGHT = 450;
    public  $data;
    public  $header;
    private $image_factory;

    public function __construct()
    {
        $this->data          = new Data();
        $this->header        = new Header($this->data);
        $this->image_factory = new ImageFactory(new ImageDAO());
    }

    public function index()
    {
        $this->buildView("UploadView.php");
    }

    public function upload()
    {
        $this->addImage();
        $this->buildView("UploadView.php");
    }

    public function buildView($name_view)
    {
        $this->data->content = $name_view;
        $this->data->menu    = $this->buildMenu();
        $this->includeMainView();
    }

    private function includeMainView()
    {
        include("View/mainView.php");
    }

    private function buildMenu()
    {
        return array(
            'Home'        => 'index.php',
            'A propos'    => 'index.php?action=apropos',
            'Voir photos' => 'index.php?id=1&controller=Photo'
        );
    }

    private function addImage()
    {

        if ($this->checkAttributesImageDownload()) {
            $this->checkUpload();
        } else if ($this->checkAttributesImageUrl()) {
            $this->checkUrl();
        }else {
            echo 'Veuillez remplir tous les champs SVP';
        }
    }

    private function checkAttributesImageDownload()
    {
        return (($_FILES['upload']['error'][0]) != 4 && !empty($_POST['category']) && !empty($_POST['comment']) && isset($_POST['submitUpload']));
    }

    private function checkAttributesImageUrl()
    {
        return (!empty($_POST['url'])) && !empty($_POST['category']) && !empty($_POST['comment']) && !empty($_POST['submitUpload']);
    }

    private function checkUrl()
    {

        $url        = trim($_POST['url']); //retire les espaces au copier/coller
        $category   = $_POST['category'];
        $comment    = $_POST['comment'];
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . Home::MY_PATH . '/Model/IMG'.self::IMAGE_DIR_NAME;

        if (preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $url, $url_ary) == 1) {
            $base_filename = substr($url_ary[4], strrpos($url_ary[4], "/") + 1); // on récupère le nom de l'image
            $filename      = $upload_dir . $base_filename;
            $content       = file_get_contents($url);
            $fp            = fopen($filename, 'wb');

            fwrite($fp, $content);
            fclose($fp);

            $this->insertUploadImage($base_filename, $category, $comment);
        } else {
            echo 'Vérifiez votre url';
        }
    }

    public function checkUpload()
    {
        $category = $_POST['category'];
        $comment  = $_POST['comment'];
        $files    = $_FILES['upload'];

        foreach ($files['tmp_name'] as $id_image => $tmp_name) {
            $name  = $files ['name'][$id_image];
            $error = $files ['error'][$id_image];

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . Home::MY_PATH . '/Model/IMG'.self::IMAGE_DIR_NAME;

            // test pas d'erreur
            if ($error < 1) {
                if ($this->isValidImage($files, $id_image)) {
                    if ($this->checkDir($upload_dir)) {
                        if ($this->moveImage($tmp_name, $upload_dir, $name)) {
                            $this->insertUploadImage($name, $category, $comment);
                        }
                    }
                }
            } else {
                echo 'La taille de l\'image est supérieure à 2Mo.';
            }
        }
    }

    private function isValidImage($files, $id_image)
    {
        $extension_autorisees = array('jpg', 'jpeg', 'png', 'gif');
        $extension            = basename($files['type'][$id_image]);

        return $this->checkExtension($extension,
            $extension_autorisees) && $this->checkSize($files['tmp_name'][$id_image]);
    }


    private function checkExtension($extension, $extension_autorisees)
    {
        if (in_array($extension, $extension_autorisees)) {
            return true;
        } else {
            echo 'Seules les images en .jpg et .png sont acceptées.';
        }
    }

    private function checkSize($tmp_name)
    {
        $images_size = getimagesize($tmp_name);

        if (($images_size[0] <= ($this::MAX_WIDTH)) AND ($images_size[1] <= ($this::MAX_HEIGHT))) {
            //test dimensions images
            return true;
        } else {
            echo 'Les dimensions de l\'image sont trop grandes.';
        }
    }


    private function checkDir($upload_dir)
    {
        //creation du répertoire upload s'il n'existe pas
        if (is_dir($upload_dir) === true) {
            
            return true;
            
        } else {
			
            mkdir($upload_dir);
            
				if (is_dir($upload_dir) === true){
				
					return true;
					
				} else {

                    echo 'Le répertoire n\'a pas pu être créé';
					
				}
    }
    
}

    private function moveImage($tmp_name, $upload_dir, $name)
    {
        $moveImage = move_uploaded_file($tmp_name, $upload_dir . $name);

        if ($moveImage === true) {
            return true;
        } else {
           echo 'L\'image n\'a pas pu être enregistrée sur le serveur.';
        }
    }

    private function insertUploadImage($name, $category, $comment)
    {

        $insertImage = $this->image_factory->addImage(self::IMAGE_DIR_NAME . $name, $category, $comment);

        if ($insertImage === true) {
          echo 'Image insérée ';
        } else {
            echo 'L\'image n\'a pas pu être enregistrée dans la base.';
        }
    }

}
