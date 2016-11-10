<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 07/11/16
 * Time: 20:02
 */
require_once('Model/Data.php');
require_once('Model/User/User.php');
require_once('Model/User/UserDAO.php');
require_once('Controller/Header.php');


class LogIn
{
    const CONTROLLER_NAME = 'LogIn';
    public $data;
    public $user;

    public function __construct()
    {
        $this->data     = new Data();
        $this->header   = new Header($this->data);
        $this->user_dao = new UserDAO();
    }

    public function index()
    {
        $this->buildView("LogInView.php");
    }

    public function LogIn()
    {
        $user = $this->getUser();
        if (isset($user)) {
            $_SESSION['user']=$user;
            $this->data->sign_up_has_succeed = true;
        }
        $this->buildView("LogInView.php");
    }

    public function LogOut()
    {
        session_destroy();
        $this->data->success = true;
        $this->buildView("LogInView.php");
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

    private function getUser()
    {
        if (isset($_POST['name']) && isset($_POST['pwd'])) {
            return $this->user_dao->getUser($_POST['name'], $_POST['pwd']);
        } else {
            return false;
        }
    }
}