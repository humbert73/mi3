<p>
    <?php
        echo '<a href="'.$this->getLinkPreviousImage().'">Prev</a>'.PHP_EOL;
        echo '<a href="'.$this->getLinkNextImage().'"">Next</a>'.PHP_EOL;
    ?>
</p>

<?php echo '<a href="'.$this->data->image_url.'"><img src="'.$this->data->image_url.'" width="'.$this->data->size.'"></a>'.PHP_EOL; ?>