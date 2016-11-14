# Galerie d'image

##### A MODIFIER EN FONCTION DE VOTRE INSTALLATION ET DE VOTRE CONFIGURATION
Dans `/image/Controller/Home.php`
```PHP
const MY_ PATH = ``;
```
exemple : `const MY_ PATH =  `/mi3/image/`;

const URL_PATH = ``;

exemple : `const URL_PATH = `htpp://localhost/`.self::MY_PATH;

##### Pour ajouter de nouvelles photos
Pour avoir la possibilité d'importer de nouvelles photos, il faut être connecté.

##### En cas d'erreur de lecture avec la DB
faire `chmod o+wx` sur le dossier `BD`, `Model/IMG` et le fichier `image.db`
