<div class="panel-heading">
    <h2 class="panel-title">Galerie photos Matrix</h2>
</div>
<div class="panel-body">
    <div class="btn-group">
        <?php
        echo '<a href="' . $this->getLinkForAction("first") . '" class="btn btn-primary"><span class="glyphicon glyphicon-backward"></span> First</a>' . PHP_EOL;
        echo '<a href="' . $this->getLinkForAction("previous") . '" class="btn btn-primary"><span class="glyphicon glyphicon-triangle-left"></span> Prev</a>' . PHP_EOL;
        echo '<a href="' . $this->getLinkForAction("next") . '" class="btn btn-primary">Next <span class="glyphicon glyphicon-triangle-right"></span></a>' . PHP_EOL;
        echo '<a href="' . $this->getLinkForAction("last") . '" class="btn btn-primary">Last <span class="glyphicon glyphicon-forward"></span></a>' . PHP_EOL;
        ?>
    </div>
    <p></p>
    <?php

        foreach($this->more() as $i_Url){

            var_dump ('url Matrix '.$i_Url);
            ?><a href="<?php echo $i_Url ?>"><img src="<?php echo $i_Url ?>" width="<?php echo $this->data->size ?>"></a>
            <?php

        }
    ?>
</div>




