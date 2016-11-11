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

        if ($this->checkAttributesImageDownload()) {
            $this->checkUpload();
        }

        if($this->checkAttributesImageUrl()){
            $this->checkUrl();
        }
    }

    public function checkAttributesImageDownload()
    {
        return isset($_FILES['upload']) && isset($_POST['category']) && isset($_POST['comment']) && isset($_POST['submitUpload']);
    }

    public function checkAttributesImageUrl()
    {
        return isset($_POST['url']) && isset($_POST['category']) && isset($_POST['comment']) && isset($_POST['submitUpload']);
    }

    public function checkUrl(){

        $url = trim($_POST['url']); //retire les espaces au copier/coller
        $category = $_POST['category'];
        $comment = $_POST['comment'];
        $maxsize = 200000;


        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/mi3/image/Model/IMG/upload/';

        if(preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $url, $url_ary) == 1){

            $base_get = '/' . $url_ary[4];
            $port = ( !empty($url_ary[3]) ) ? $url_ary[3] : 80;

            $base_filename = substr($url_ary[4],strrpos($url_ary[4],"/")+1); // on récupère le nom de l'image

            $filename = $upload_dir.$base_filename;

            $fsock = fsockopen($url_ary[2], $port, $errno, $errstr);

            fputs($fsock, "GET $base_get HTTP/1.1\r\n");
            fputs($fsock, "Host: " . $url_ary[2] . "\r\n");
            fputs($fsock, "Accept-Language: fr\r\n");
            fputs($fsock, "Accept-Encoding: none\r\n");
            fputs($fsock, "User-Agent: PHP\r\n");
            fputs($fsock, "Connection: close\r\n\r\n");

            unset($data);
            while( !feof($fsock) )
            {
                $data = fread($fsock, $maxsize);
            }
            fclose($fsock);

            preg_match('#Content-Length\: ([0-9]+)[^ /][\s]+#i', $data, $file_data1) || !preg_match('#Content-Type\: image/[x\-]*([a-z]+)[\s]+#i', $data, $file_data2);

            $filesize = $file_data1[1];

            $data = substr($data, strlen($data) - $filesize, $filesize);

            $fptr = fopen($filename, 'wb');
            fwrite($fptr, $data, $filesize);
            fclose($fptr);

                $this->insertUploadImage($base_filename, $category, $comment);

                echo "<p>".$base_filename." enregistré avec succès ! </p>";

        } else {
            echo 'Vérifiez votre url';
        }
    }

    public function checkUpload()
    {

        $category = $_POST['category'];
        $comment = $_POST['comment'];
        $files = $_FILES['upload'];

        foreach ($files ['tmp_name'] as $id_image => $tmp_name) {

            $name = $files ['name'][$id_image];
            $type = $files ['type'][$id_image];
            $error = $files ['error'][$id_image];
            $extension_autorisees = array('jpg', 'jpeg', 'png', 'gif');
            $extension = basename($type);
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/mi3/image/Model/IMG/upload';

            // test pas d'erreur
            if ($error < 1) {

                if ($this->checkExtension($extension, $extension_autorisees)) {

                    if ($this->checkSize($tmp_name)) {

                        if ($this->checkDir($upload_dir)) {

                            if ($this->moveImage($tmp_name, $upload_dir, $name)){

                                $this->insertUploadImage($name,$category,$comment);

                            }
                        }
                    }
                }
            } else {
                echo 'Les dimensions de l\'image sont trop grandes.';
            }
        }
    }


    public function checkExtension($extension, $extension_autorisees)
    {
        if (in_array($extension, $extension_autorisees)) {
           return true;
        } else {
            echo 'Seules les images en .jpg et .png sont acceptées.';
        }
    }

    public function checkSize ($tmp_name)
    {
            $images_size = getimagesize($tmp_name);

            if (($images_size[0] <= ($this::MAX_WIDTH)) AND ($images_size[1] <= ($this::MAX_HEIGHT))) {
                //test dimensions images
               return true;
            } else {
                echo 'Les dimensions de l\'image sont trop grandes.';
            }
    }


    public function checkDir($upload_dir)
    {
        //creation du répertoire upload s'il n'existe pas
        if (is_dir($upload_dir) === true) {
            /*mkdir($upload_dir);*/
            return true;
        } else {
            echo 'L\'image n\'a pas pu être téléchargée.';
        }
    }

    public function moveImage($tmp_name, $upload_dir, $name)
    {
        $moveImage = move_uploaded_file($tmp_name, $upload_dir . $name);

        if ($moveImage === true) {
            return true;
        } else {
            echo 'L\'image n\'a pas pu être enregistrée sur le serveur.';
        }
    }

    public function insertUploadImage($name, $category, $comment)
    {

        $insertImage = $this->image_factory->addImage(self::IMAGE_DIR_NAME . $name, $category, $comment);
        if ($insertImage === true) {
            echo 'Image insérée';
        } else {
            echo 'L\'image n\'a pas pu être enregistrée dans la base.';
        }
    }

}