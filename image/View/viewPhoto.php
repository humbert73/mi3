<p>
    <?php
        echo '<a href="'.$this->getLinkPrevImage().'">Prev</a>'.PHP_EOL;
        echo '<a href="'.$this->getLinkNextImage().'"">Next</a>'.PHP_EOL;
    ?>
</p>
<?php echo '<a href="'.$this->getLinkImage().'"><img src="'.$this->image_url.'" width="'.$this->size.'"></a>'.PHP_EOL; ?>