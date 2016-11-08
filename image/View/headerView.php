<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">Site SIL3</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION['user'])){ ?>
                    <li><a href="<?php echo $this->data->log_in_url.'&action=LogOut' ?>"><span class="glyphicon glyphicon-log-out"></span> Se déconnecter</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo $this->data->sign_up_url; ?>"><span class="glyphicon glyphicon-user"></span> S'inscrire</a></li>
                    <li><a href="<?php echo $this->data->log_in_url; ?>"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>