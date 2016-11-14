<?php

require_once('Model/Data.php');
require_once('Controller/Header.php');


class Home
{
    // Chemin d'accès au site par rapport au serveur
    const MY_PATH = '/mi3/image';
    const URL_PATH = "http://localhost".self::MY_PATH;
    const URL_PATH_INDEX = self::URL_PATH.'/index.php';
    public $data;
    public $header;

    public function __construct()
    {
        $this->data   = new Data();
        $this->header = new Header($this->data);
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
