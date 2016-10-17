<?php


class ImageFactory
{

    const urlPath = "http://localhost/mi3/image/Model/IMG/";

    public function __construct()
    {
    }

    public function createImage($row)
    {
        return new Image($row['id'], self::urlPath . $row['path']);
    }

}