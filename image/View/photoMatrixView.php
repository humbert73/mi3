<p>
    <?php
    echo '<a href="'.$this->getLinkPreviousImage().'">Prev</a>'.PHP_EOL;
    echo '<a href="'.$this->getLinkNextImage().'"">Next</a>'.PHP_EOL;
    ?>
</p>

<?php

    foreach($this->PhotoMatrix->more() as $i_Url){

        ?><a href="<?php echo $i_Url ?>"><img src="<?php echo $i_Url ?>" width="'.$this->data->size.'"></a>
        <?php

    }
?>





