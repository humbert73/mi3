<p>
    <?php
    echo '<a href="'.$this->getLinkForAction("first").'">First</a>'.PHP_EOL;
    echo '<a href="'.$this->getLinkForAction("previous").'">Prev</a>'.PHP_EOL;
    echo '<a href="'.$this->getLinkForAction("next").'"">Next</a>'.PHP_EOL;
    echo '<a href="'.$this->getLinkForAction("last").'"">Last</a>'.PHP_EOL;
    ?>
</p>
<?php echo '<a href="'.$this->data->image_url.'"><img src="'.$this->data->image_url.'" width="'.$this->data->size.'"></a>'.PHP_EOL; ?>