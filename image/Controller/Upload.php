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
    public $data;
    public $header;
    private $image_factory;


    public function __construct()
    {
        $this->data = new Data();
        $this->header = new Header($this->data);
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
        $this->data->menu = $this->buildMenu();
        $this->includeMainView();
    }

    private function includeMainView()
    {
        include("View/mainView.php");
    }

    private function buildMenu()
    {
        return array(
            'Home' => 'index.php',
            'A propos' => 'index.php?action=apropos',
            'Voir photos' => 'index.php?id=1&controller=Photo'
        );
    }

    private function addImage()
    {
        if ($this->checkAttributes()) {

            $category = $_POST['category'];
            $comment = $_POST['comment'];
            $files = $_FILES['upload'];

            foreach ($files ['tmp_name'] as $key => $tmp_name) {
                $name = $files ['name'][$key];
                $type = $files ['type'][$key];
                $error = $files ['error'][$key];
                $extension_autorisees = array('jpg', 'jpeg', 'png');
                $extension = basename($type);
                // test pas d'erreur
                if ($error < 1) {
                    //test extension
                    if (in_array($extension, $extension_autorisees)) {
                        //test dimensions images
                        $images_size = getimagesize($tmp_name);
                        if (($images_size[0] <= ($this::MAX_WIDTH)) AND ($images_size[1] <= ($this::MAX_HEIGHT))) {
                            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/mi3/image/Model/IMG/upload/';
                            //creation du répertoire upload s'il n'existe pas
                            if (is_dir($upload_dir) === false) {
                                mkdir($upload_dir);
                            }
                            $moveImage = move_uploaded_file($tmp_name, $upload_dir . $name);
                            if ($moveImage === true) {
                                $insertImage = $this->image_factory->addImage(self::IMAGE_DIR_NAME . $name, $category, $comment);
                                if ($insertImage === true) {
                                    echo 'Image insérée';
                                    continue;
                                } else {
                                    echo 'L\'image n\'a pas pu être enregistrée.';
                                    continue;
                                }
                            } else {
                                echo 'L\'image n\'a pas pu être téléchargée.';
                                continue;
                            }
                        } else {
                            echo 'Les dimensions de l\'image sont trop grandes.';
                            continue;
                        }
                    } else {
                        echo 'Seules les images en .jpg et .png sont acceptées.';
                        continue;
                    }
                } else {
                    echo 'Vérifiez que l\'une des images ne dépasse pas 300Ko.';
                    continue;
                }
            }
        }
    }

    public function checkAttributes()
    {
        return isset($_FILES['upload']) && isset($_POST['category']) && isset($_POST['comment']) && isset($_POST['submitUpload']);
    }
}