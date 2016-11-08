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
    public $data;
    public $header;
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
        $user = $this->addImage();
        if (isset($user)) {
            $_SESSION['user']               = $user;
            $this->data->sign_up_has_succed = true;
        }
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
        if (isset($_POST['name']) && isset($_POST['pwd'])) {
            return $this->user_dao->getUser($_POST['name'], $_POST['pwd']);
        } else {
            return false;
        }
    }
}