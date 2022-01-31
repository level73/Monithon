<div class="dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="user-profile-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fal fa-user"></i>
  </a>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-profile-dropdown">
    <a class="dropdown-item" href="/user/edit#my-reports"><?php t('I Miei Report'); ?></a>
    <a class="dropdown-item" href="/user/edit"><?php t('Modifica Profilo'); ?></a>
    <div class="dropdown-divider"></div>
    <?php if(isset($user) && hasPermission($user, P_CREATE_USER)){  ?>
    <a  class="dropdown-item" href="/user/create"><?php t('Crea Nuovo Utente'); ?></a>
    <a  class="dropdown-item" href="/user/list"><?php t('Lista Utenti'); ?></a>
    <div class="dropdown-divider"></div>
    <?php } ?>
    <?php if(isset($user) && hasPermission($user, P_APPROVE_REPORT)){ ?>
        <a  class="dropdown-item" href="/backend"><?php t('Data Backend'); ?></a>
        <div class="dropdown-divider"></div>
    <?php } ?>
    <a href="/user/logout" class="dropdown-item"><i class="fal fa-sign-out"></i> <?php t('Logout'); ?></a>
  </div>
</div>

<!--
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown
  </a>
  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</li>
-->
