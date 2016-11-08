<div class="panel-heading">
  <h2 class="panel-title">Connexion</h2>
</div>
<div class="panel-body">
  <div class="container">
<?php if (isset($this->data->log_in_has_succed)) { ?>
  <div class="alert alert-success">
    <strong>Connexion réussite</strong>
  </div>
<?php } else { ?>
  <form class="form-horizontal" action="index.php?controller=Upload&action=upload" method="post">
      <div class="form-group">
        <label class="col-sm-3 control-label" for="link">Chemin d'accès à l'image</label>
        <div class="col-sm-8">
          <input name="link" type="text" class="form-control" id="link">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="category">Catégorie de l'image</label>
        <div class="col-sm-3">
          <input name="category" type="text" class="form-control" id="category">
        </div>
      </div>
      <div class="form-group">
          <label class="col-sm-3 control-label" for="comment">Commentaire</label>
          <div class="col-sm-8">
              <input name="comment" type="text" class="form-control" id="comment">
          </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-8">
          <button type="submit" class="btn btn-default">Uploader</button>
        </div>
      </div>
    </form>
<?php } ?>
  </div>
</div>