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
        <form style="display: inline-block; margin-left: 20px;" method="post" action="index.php?controller=PhotoMatrix&action=displayByCategory">
            <select name="choiceCategory" style="border-color:#000; cursor:pointer;" class="form-control" id="category">
                <option value="default" selected>Choose category</option>
                <?php foreach ($this->data->categories as $category) {
                    echo '<option value="'.$category.'">'.$category.'</option>';
                }?>
            </select>
            <button type="submit" class="btn btn-default">Go</button>
        </form>
    </div>
    <p></p>
    <?php
        foreach($this->images_urls as $image_url){
            echo '<a style=" display:inline-block; margin-bottom:3px;" href="' . $image_url . '"><img src="' . $image_url . '" width="' . $this->data->size . '" height="' . $this->data->size . '"></a>' . PHP_EOL;
        }
    ?>
</div>
