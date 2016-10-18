<?php

if (isset($_GET["controller"])) {
    $controller_to_run = $_GET["controller"];
} else {
    $controller_to_run = "Home";
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "index";
}

$controller_file_name = "Controller/".$controller_to_run.'.php';

if (file_exists($controller_file_name)){
    require_once($controller_file_name);

    $controller_class_name = $controller_to_run;
    if (class_exists($controller_class_name)) {
        $controller = new $controller_class_name();

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            die("<b>### Erreur : la methode '$action' du controleur '$controller_class_name' du fichier '$controller_file_name' n'existe pas</b>
            </br>Conseil : verifiez l'orthographe du nom de cette methode dans le fichier $controller_file_name.");
        }
    } else {
        die("<b>### Erreur : la classe du controleur '$controller_class_name' du fichier $controller_file_name n'existe pas</b>
          </br>Conseil : verifiez l'orthographe du nom de cette classe dans le fichier $controller_file_name.");
    }
} else{
    die("<b>### Erreur : le fichier $controller_file_name est absent</b>
        </br>Conseil : il faut creer ce fichier, verifier son nom ou verifier le lien du bouton
        en particulier la valeur de la variable 'controller' dans l'URL.");
}