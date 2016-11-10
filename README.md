# mi3
## Galerie d'image

##### A MODIFIER EN FONCTION DE VOTRE INSTALLATION
Dans `mi3/image/Model/Image/ImageFactory.php`
```PHP
const URL_IMAGE_PATH = "http://MON_ADRESSE_URL/image/Model/IMG/
```
exemple : `const URL_IMAGE_PATH = "http://localhost/image/Model/IMG/"`

##### Pour ajouter de nouvelles photos
Ajoutez vos photo dans le dossier IMG dans `Modal/IMG`.
Inscrivez vous si ce n'est pas déjà fait puis après s'être connecté cliquez sur Upload dans le menu. 
Renseigner :
* Le chemin d'accès de l'image
* Sa catégorie
* Un commentaire descriptif

Exemple de chemin d'accès à l'image :
Je crée un dossier `MON_NOM` dans le dossier `IMG` prévut à cet effet dans lequel je dépose l'image `image.jpg`.
Chemin d'accès : `MON_NOM/image.jpg`

##### En cas d'erreur de lecture avec la DB
faire `chmod o+w` sur le dossider `BD` et le fichier `image.db`
