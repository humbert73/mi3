<p>
    <?php
        echo '<a href="'.$this->getLinkPreviousImage().'">Prev</a>'.PHP_EOL;
        echo '<a href="'.$this->getLinkNextImage().'"">Next</a>'.PHP_EOL;
    ?>
</p>
<?php
var_dump("image url : ".$this->data->image_url);
echo("</br>");
var_dump("image id : ".$this->data->image_id);
echo("</br>");
var_dump("image size : ".$this->data->size);
echo("</br>");
var_dump("image zoom : ".$this->data->zoom);
echo("</br>");
?>
<?php echo '<a href="'.$this->data->image_url.'"><img src="'.$this->data->image_url.'" width="'.$this->data->size.'"></a>'.PHP_EOL; ?>