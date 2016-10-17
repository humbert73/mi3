<?php

class Home
{
    private $view;
    private $menu;

    public function display()
    {
        $this->view = "View/viewHome.php";
        $this->menu = $this->buildMenu();

        $this->includeMainView();
    }

    public function displayAPropos()
    {
        $this->view = "View/viewAPropos.php";
        $this->menu = $this->buildMenu();

        $this->includeMainView();
    }

    private function includeMainView()
    {
        include("View/viewMain.php");
    }

    private function buildMenu()
    {
        return array(
            'Home'        => 'index.php',
            'A propos'    => 'index.php?action=displayAPropos',
            'Voir photos' => 'index.php?controller=Photo'
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