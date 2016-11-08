<?php

# Notion d'image
class Image
{
    private $id       = 0;
    private $url      = "";
    private $comment  = "";
    private $category = "";

    function __construct($id, $url, $comment, $category)
    {
        $this->id       = $id;
        $this->url      = $url;
        $this->comment  = $comment;
        $this->category = $category;
    }

    function getURL()
    {
        return $this->url;
    }

    function getId()
    {
        return $this->id;
    }

    function getComment()
    {
        return $this->comment;
    }

    function getCategory()
    {
        return $this->category;
    }
}
  
