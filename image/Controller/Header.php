<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 07/11/16
 * Time: 19:24
 */
require_once('Controller/Home.php');
require_once('Controller/SignUp.php');
require_once('Controller/LogIn.php');
require_once('Model/Data.php');

class Header
{
    const VIEW = 'View/headerView.php';
    private $data;

    function __construct(Data $data)
    {
        $this->data = $data;
        $this->initData();
        session_start();
    }

    private function initData()
    {
        $this->data->header      = self::VIEW;
        $this->data->sign_up_url = $this->getSignUpUrl();
        $this->data->log_in_url  = $this->getLogInUrl();
    }

    public function getView()
    {
        return self::VIEW;
    }

    private function getSignUpUrl()
    {
        return Home::URL_PATH.'?'.http_build_query(array('controller' => SignUp::CONTROLLER_NAME));
    }

    private function getLogInUrl()
    {
        return Home::URL_PATH.'?'.http_build_query(array('controller' => LogIn::CONTROLLER_NAME));
    }
}
