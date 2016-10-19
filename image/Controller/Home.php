<?php

require_once('Model/Data.php');

class Home
{
    private $view;
    private $menu;
    public $data;

    public function __construct()
    {
        $this->data = new Data();
    }

    public function index()
    {
        $this->data->content="homeView.php";
        $this->data->menu=$this->buildMenu();
//        $this->view = "View/homeView.php";
//        $this->menu = $this->buildMenu();

        $this->includeMainView();
    }

    public function apropos()
    {
        $this->data->content="aproposView.php";
        $this->data->menu=$this->buildMenu();
//        $this->view = "View/aproposView.php";
//        $this->menu = $this->buildMenu();

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

    public function getView()
    {
        return $this->view;
    }

    public function getMenu()
    {
        return $this->menu;
    }
}