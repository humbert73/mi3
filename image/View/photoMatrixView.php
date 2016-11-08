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
    <div style="margin-top : 20px; border: 1px solid #cecece; border-radius: 5px; width:30%; padding:5px; background-color: #337ab7;">
        <form style="display:flex; width: 80%; margin-left: 20px;" method="post" enctype="multipart/form-data" action="index.php?controller=PhotoMatrix&action=displayByCategory">
            <select style="border-color:#000; cursor:pointer; display:inline;" class="form-control" id="category">
                <option value="default" selected>Choose category</option>
                <?php foreach ($this->getCategory() as $id => $category) {
                    echo '<option name="choiceCategory" value="'.$id.'">'.$category.'</option>';
                }?>
            </select>
            <input style="display:block; margin-left:2%;" name="submitChoiceCategory" type="submit" value="Go"/>
        </form>
    </div>
    <p></p>
    <?php
        foreach($this->images_urls as $image_url){
            echo '<a style=" display:inline-block; margin-bottom:3px;" href="' . $image_url . '"><img src="' . $image_url . '" height="' . $this->data->size . '" width="' . $this->data->size . '"></a>' . PHP_EOL;
        }
    ?>
</div>
