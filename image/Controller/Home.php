<?php

require_once('Model/Data.php');
require_once('Controller/Header.php');


class Home
{

    const URL_PATH = "http://localhost/mi3/image/index.php";
    public $data;

    public function __construct()
    {
        $this->header = Header::Instance();
        $this->data   = new Data();
    }

    public function index()
    {
        $this->buildView("homeView.php");
    }

    public function apropos()
    {
        $this->buildView("aproposView.php");
    }

    public function buildView($name_view)
    {
        $this->data->header  = $this->header->getView();
        $this->data->content = $name_view;
        $this->data->menu    = $this->buildMenu();
        $this->includeMainView();
    }

    public function getHeaderView()
    {
        return "headerView.php";
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