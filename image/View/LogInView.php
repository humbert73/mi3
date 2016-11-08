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
  <form class="form-horizontal" action="index.php?controller=LogIn&action=logIn" method="post">
      <div class="form-group">
        <label class="col-sm-2 control-label" for="name">Nom :</label>
        <div class="col-sm-4">
          <input name="name" type="text" class="form-control" id="name">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="pwd">Mot de passe :</label>
        <div class="col-sm-4">
          <input name="pwd" type="password" class="form-control" id="pwd">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Se connecter</button>
        </div>
      </div>
    </form>
<?php } ?>
  </div>
</div>