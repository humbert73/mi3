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

        return $stmt->execute();
    }

    public function getUser($name, $password)
    {
        $sql = 'SELECT name, password
                FROM user
                WHERE name = :name AND password = :password';

        $sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':name' => $name, ':password' => $password));
        $res = $sth->fetch();

        if ($res) {
            return new User($res['name'], $res['password']);
        } else {
            print "Error with user: ".$name."<br/>";
            $err = $this->db->errorInfo();
            print $err[2]."<br/>";
        }
    }
}