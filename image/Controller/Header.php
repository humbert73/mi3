<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 07/11/16
 * Time: 19:24
 */
require_once('Controller/Home.php');
require_once('Controller/SignUp.php');

class Header {

    /**
     * @var Singleton
     * @access private
     * @static
     */
    private static $_instance = null;

    const VIEW = 'View/headerView.php';

    private function __construct() {
    }

    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return Header
     */
    public static function Instance() {

        if(is_null(self::$_instance)) {
            self::$_instance = new Header();
        }

        return self::$_instance;
    }

    public function getView()
    {
        return self::VIEW;
    }

    public function getSignUpUrl()
    {
        return Home::URL_PATH.'?'.http_build_query(array(
            'controller' => SignUp::CONTROLLER_NAME
        ));
    }
}
