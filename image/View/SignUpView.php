<div class="panel-heading">
  <h2 class="panel-title">Inscription</h2>
</div>
<div class="panel-body">
  <div class="container">
<?php if (isset($this->data->sign_up_has_succed)) { ?>
  <div class="alert alert-success">
    <strong>Inscription réussite</strong>
  </div>
<?php } else { ?>
  <form class="form-horizontal" action="index.php?controller=SignUp&action=signUp" method="post">
      <div class="form-group">
        <label class="col-sm-2 control-label" for="email">Address mail :</label>
        <div class="col-sm-4">
          <input name="email" type="email" class="form-control" id="email">
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
          <button type="submit" class="btn btn-default">S'inscrire</button>
        </div>
      </div>
    </form>
<?php } ?>
  </div>
</div>