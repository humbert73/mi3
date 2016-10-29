<div class="panel-heading">
    <h2 class="panel-title">Galerie photos</h2>
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
    <p>
        <?php echo '<a href="' . $this->data->image_url . '"><img class="img-thumbnail" src="' . $this->data->image_url . '" width="' . $this->data->size . '"></a>' . PHP_EOL; ?>
    </p>
</div>
