<p>
    <?php
        echo '<a href="'.$this->getLinkPreviousImage().'">Prev</a>'.PHP_EOL;
        echo '<a href="'.$this->getLinkNextImage().'"">Next</a>'.PHP_EOL;
    ?>
</p>
<?php
    var_dump("image url : ".$this->data->image_url.PHP_EOL);
    var_dump("image id : ".$this->data->image_id.PHP_EOL);
    var_dump("image size : ".$this->data->size.PHP_EOL);
    var_dump("image zoom : ".$this->data->zoom.PHP_EOL);
?>
<?php echo '<a href="'.$this->data->image_url.'"><img src="'.$this->data->image_url.'" width="'.$this->data->size.'"></a>'.PHP_EOL; ?>