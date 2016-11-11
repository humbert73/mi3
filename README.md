# Galerie d'image

##### A MODIFIER EN FONCTION DE VOTRE INSTALLATION
Dans `/image/Controller/Home.php`
```PHP
const PATH = "http://MON_ADRESSE_URL/image/"
```
exemple : `const PATH = "http://localhost/image/"`

##### Pour ajouter de nouvelles photos
Pour avoir la possibilité d'importer de nouvelles photos, il faut être connecté.

##### En cas d'erreur de lecture avec la DB
faire `chmod o+wx` sur le dossier `BD`, `Model/IMG` et le fichier `image.db`
