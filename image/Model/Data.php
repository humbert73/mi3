<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 18/10/16
 * Time: 08:27
 */
class Data
{
    public $menu;
    public $content;

    //IMAGE
    public $image_url;
    public $image_id;
    public $image_comment;
    public $image_category;


    //IMAGE FOR URLs
    public $size     = 480;
    public $zoom     = 1;
    public $nb_image = 1;
    public $images_urls;
    public $image_cat;
    public $categories;
    public $choose_category;

    //HEADER
    public $header;
    public $sign_up_url;
    public $sign_up_has_succeed;
    public $log_in_url;

    //FEEDBACK
    public $success;
}