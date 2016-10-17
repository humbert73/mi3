<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="fr" >
    <head>
        <title>Site SIL3</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css" media="screen" title="Normal" />
    </head>
    <body>
        <div id="entete">
            <h1>Site SIL3</h1>
        </div>
        <div id="menu">		
            <h3>Menu</h3>
            <ul>
                <?php 
                    # Utilisation du modèle
                    require_once("Model/image.php");
                    require_once("Model/imageDAO.php");
                    // Débute l'acces aux images
                    $imgDAO = new ImageDAO();

                    // Construit l'image courante
                    // et l'ID courant 
                    // NB un id peut être toute chaine de caractère !!
                    if (isset($_GET["imgId"])) {
                        $imgId = $_GET["imgId"];
                        $img   = $imgDAO->getImage($imgId);
                    } else {
                        // Pas d'image, se positionne sur la première
                        $img   = $imgDAO->getFirstImage();
                        // Conserve son id pour définir l'état de l'interface
                        $imgId = $img->getId();
                    }

                    // Regarde si une taille pour l'image est connue
                    if (isset($_GET["size"])) {
                        $size = $_GET["size"];
                    } else {
                        # sinon place une valeur de taille par défaut
                        $size = 480;
                    }


                    # Mise en place du menu
                    $newImg           = $imgDAO->getFirstImage(); // Pre-calcule la première image     
                    $newImgId         = $newImg->getId(); # Change l'etat pour indiquer que cette image est la nouvelle
                    $random_image     = $imgDAO->getRandomImage();
                    $random_image_id  = $random_image->getId();
                    $menu['Home']     = "index.php";
                    $menu['A propos'] = "aPropos.php";
                    $menu['First']    = "viewPhoto.php?imgId=$newImgId&size=$size";
                    $menu['Random']   = "viewPhoto.php?imgId=$random_image_id&size=$size"; # Pre-calcule une image au hasard
                    $menu['More']     = "viewPhotoMatrix.php?imgId=$imgId"; # Pour afficher plus d'image passe à une autre page
                    $menu['Zoom +']   = "zoom.php?zoom=1.25&imgId=$imgId&size=$size"; // Demande à calculer un zoom sur l'image
                    $menu['Zoom -']   = "zoom.php?zoom=0.75&imgId=$imgId&size=$size"; // Demande à calculer un zoom sur l'image
                    // Affichage du menu
                    foreach ($menu as $item => $act) {
                        print "<li><a href=\"$act\">$item</a></li>\n";
                    }
                ?>
            </ul>
        </div>

        <div id="corps">
            <?php # mise en place de la vue partielle : le contenu central de la page  
                # Mise en place des deux boutons
                print "<p>\n";
                // pre-calcul de l'image précedente
                $newImg   = $imgDAO->getPrevImage($img);
                $newImgId = $newImg->getId(); 
                print "<a href=\"viewPhoto.php?imgId=$newImgId&size=$size\">Prev</a>\n";
                // pre-calcul de l'image suivante
                $newImg   = $imgDAO->getNextImage($img);
                $newImgId = $newImg->getId(); 
                print "<a href=\"viewPhoto.php?imgId=$newImgId&size=$size\">Next</a>\n";
                print "</p>\n";
                # Affiche l'image avec une reaction au click
                print "<a href=\"zoom.php?zoom=1.25&imgId=$imgId&size=$size\">\n";
                // Réalise l'affichage de l'image
                $imgURL = $img->getURL();
                print "<img src=\"$imgURL\" width=\"$size\">\n";
                print "</a>\n";
            ?>		
        </div>

        <div id="pied_de_page"></div>	   	   	
    </body>
</html>




