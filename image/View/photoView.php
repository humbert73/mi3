<div class="panel-heading">
    <h2 class="panel-title">Galerie photos - <?php echo $this->data->image_category ?></h2>
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
    <div>
        <?php
            echo '<p><a href="' . $this->data->image_url . '"><img class="img-thumbnail" src="' . $this->data->image_url . '" width="' . $this->data->size . '"></a></p>' . PHP_EOL;
            echo '<h3>'.$this->data->image_comment.'<h3>';
        ?>
    </div>
</div>
