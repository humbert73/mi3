<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 07/11/16
 * Time: 20:02
 */
require_once('Model/Data.php');
require_once('Controller/Header.php');


class SignUp
{
    const CONTROLLER_NAME = 'SignUp';
    const URL_PATH        = "http://localhost/mi3/image/index.php";
    public $data;

    public function __construct()
    {
        $this->data   = new Data();
        $this->header = new Header($this->data);
    }

    public function index()
    {
        $this->buildView("SignUpView.php");
    }

    public function signUp()
    {
        $this->data->sign_up_has_succed = true;
        $this->buildView("SignUpView.php");
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
}