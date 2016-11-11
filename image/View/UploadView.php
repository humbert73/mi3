<div class="panel-heading">
  <h2 class="panel-title">Upload</h2>
</div>
<div class="panel-body">
  <div class="container-fluid">
<?php if (isset($this->data->upload_has_succed)) { ?>
  <div class="alert alert-success">
    <strong>Connexion réussite</strong>
  </div>
<?php } else { ?>
  <form class="form-horizontal" action="index.php?controller=Upload&action=upload" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label class="col-sm-3 control-label" for="link">Ajouter des images</label>
        <div class="col-sm-4">
            <input class="form-control" type="file" value="Téléchargez votre image" id="upload" name="upload[]" multiple/>
            </div>
          <div class="col-sm-4">
            <input class="form-control" name="url" type="text" placeholder="Coller ici l'URL de votre image"/>
          </div>
      </div>
      <div class="form-group">
            <p style="margin-left : 280px;">[images autorisées : .jpg, .png, .gif - taille max : 600x450px, 2Mo max]</p>
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
          <button name="submitUpload" type="submit" class="btn btn-default">Importer</button>
        </div>
      </div>
    </form>
<?php } ?>
  </div>
</div>