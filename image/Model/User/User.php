<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 08/11/16
 * Time: 11:00
 */
class User
{

    private $name;
    private $password;

    function __construct($name, $password)
    {
        $this->name     = $name;
        $this->password = $password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }


}