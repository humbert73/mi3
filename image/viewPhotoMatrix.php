<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="fr" >
    <head>
        <title>Site SIL3</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="View/css/style.css" media="screen" title="Normal" />
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
                    require_once("model/image.php");
                    require_once("model/imageDAO.php");
                    // Débute l'acces aux images
                    $imgDAO = new ImageDAO();

                    // Construit l'image courante
                    // et l'ID courant 
                    if (isset($_GET["imgId"])) {
                        $imgId = $_GET["imgId"];
                        $img = $imgDAO->getImage($imgId);
                    } else {
                        // Pas d'image, se positionne sur la première
                        $img = $imgDAO->getFirstImage();
                        // Conserve son id pour définir l'état de l'interface
                        $imgId = $img->getId();
                    }

                    // Récupère le nombre d'images à afficher
                    if (isset($_GET["nbImg"])) {
                        $nbImg = $_GET["nbImg"];
                    } else {
                        # sinon débute avec 2 images
                        $nbImg = 2;
                    }
                    // Regarde si une taille pour l'image est connue
                    if (isset($_GET["size"])) {
                        $size = $_GET["size"];
                    } else {
                        # sinon place une valeur de taille par défaut
                        $size = 480;
                    }	

                    # Calcul la liste des images à afficher
                    $imgLst= $imgDAO->getImageList($img,$nbImg);

                    # Transforme cette liste en liste de couples (tableau a deux valeurs)
                    # contenant l'URL de l'image et l'URL de l'action sur cette image
                    foreach ($imgLst as $i) {
                        # l'identifiant de cette image $i
                        $iId=$i->getId();
                        # Ajoute à imgMatrixURL 
                        #  0 : l'URL de l'image
                        #  1 : l'URL de l'action lorsqu'on clique sur l'image : la visualiser seul
                        $imgMatrixURL[] = array($i->getURL(),"viewPhoto.php?imgId=$iId");
                    }

                    # Mise en place du menu
                    
                    $random_image    = $imgDAO->getRandomImage();
                    $random_image_id = $random_image->getId();
                    $menu['Home']="viewHome.php";
                    $menu['A propos']="viewAPropos.php";
                    // Pre-calcule la première image
                    $newImg = $imgDAO->getFirstImage();     
                    # Change l'etat pour indiquer que cette image est la nouvelle
                    $newImgId=$newImg->getId(); 
                    $menu['First']="viewPhotoMatrix.php?imgId=$newImgId&nbImg=$nbImg";
                    # Pre-calcule une image au hasard
                    $menu['Random']= "viewPhoto.php?imgId=$random_image_id&size=$size";
                    # Pré-calcule le nouveau nombre d'images à afficher si on en veux plus
                    $newMoreNbImg = $nbImg * 2;
                    $newLessNbImg = $nbImg / 2;
                    $menu['More']="viewPhotoMatrix.php?imgId=$imgId&nbImg=$newMoreNbImg";  
                    # Pré-calcule le nouveau nombre d'images à afficher si on en veux moins
                    $menu['Less']="viewPhotoMatrix.php?imgId=$imgId&nbImg=$newLessNbImg";
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
                // pre-calcul de la page d'images précedente
                $newPrevImg = $imgDAO->jumpToImage($img, -$nbImg);
                $newPrevImgId = $newPrevImg->getId();
                print "<a href=\"viewPhotoMatrix.php?imgId=$newPrevImgId&nbImg=$nbImg\">Prev</a> ";
                // pre-calcul de la page d'images suivante
                $newNextImg   = $imgDAO->jumpToImage($img, $nbImg);
                $newNextImgId = $newNextImg->getId();
                print "<a href=\"viewPhotoMatrix.php?imgId=$newNextImgId&nbImg=$nbImg\">Next</a>\n";
                print "</p>\n";
                # Affiche de la matrice d'image avec une reaction au click
                print "<a href=\"zoom.php?zoom=1.25&imgId=$newImgId&size=$size\">\n";
                // Réalise l'affichage de l'image
                # Adapte la taille des images au nombre d'images présentes
                $size = 480 / sqrt(count($imgMatrixURL));
                # Affiche les images
                foreach ($imgMatrixURL as $i) {
                        print "<a href=\"".$i[1]."\"><img src=\"".$i[0]."\" width=\"".$size."\" height=\"".$size."\"></a>\n";
                };
            ?>		
        </div>

        <div id="pied_de_page"></div>	   	   	
    </body>
</html>




