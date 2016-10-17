<?php
  
    # Notion d'image
    class Image {
        private $id  = 0;
        private $url = "";

        function __construct($id, $url) {
            $this->id  = $id;
            $this->url = $url;

        }

        # Retourne l'URL de cette image
        function getURL() {
            return $this->url;
        }

        function getId() {
            return $this->id;
        }
    }
  
  
?>