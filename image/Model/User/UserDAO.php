<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 08/11/16
 * Time: 11:01
 */

require_once("User.php");

class UserDAO
{

    function __construct()
    {
        $dsn  = 'sqlite:DB/image.db';
        $user = '';
        $pass = '';

        try {
            $this->db = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            die ("Erreur : ".$e->getMessage());
        }
    }

    public function addUser(User $user)
    {
        $name     = $user->getName();
        $password = $user->getPassword();

        $stmt = $this->db->prepare("INSERT INTO user (name, password) VALUES (:name, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            return true;
        } else {
            var_dump($stmt->errorInfo()); die();
        }
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM image WHERE id = $id";
        $res = $this->db->query($sql);
        if ($res) {
            return $this->createImageFromRow($this->getFirstRow($res));
        } else {
            print "Error in getImage. id=".$id."<br/>";
            $err = $this->db->errorInfo();
            print $err[2]."<br/>";
        }
    }
}