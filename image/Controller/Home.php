<?php

require_once('Model/Data.php');

class Home
{
    public $data;

    public function __construct()
    {
        $this->data = new Data();
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