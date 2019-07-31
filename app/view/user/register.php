<div class="container">
  <div class="row justify-content-center">
    <div class="col-8">
      <h1><?php t('Registrati'); ?></h1>
    </div>
  </div>
  <form action="/user/register" method="post">
    <div class="row justify-content-center" >
      <div class="col-4">
        <div class="form-group">
          <label for="email">Email <span class="required">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="<?php t('Email principale'); ?>">
        </div>
        <div class="form-group">
          <label for="username">Nome Utente <span class="required">*</span></label>
          <input type="username" class="form-control" placeholder="<?php t('Nome utente...'); ?>">
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label for="pwd">Password <span class="required">*</span></label>
          <input type="password" name="pwd" class="form-control" placeholder="<?php t('Password...'); ?>">
        </div>
        <div class="form-group">
          <label for="c_pwd">Conferma password <span class="required">*</span></label>
          <input type="password" name="c_pwd" class="form-control" placeholder="<?php t('Conferma password...'); ?>">
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <button type="submit" class="btn btn-primary"><i class="fal fa-user-plus"></i> <?php t('Registrati'); ?></button>
      </div>
      <div class="col-4">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="customCheck1">
          <label class="custom-control-label" for="customCheck1">Accetto la <a href="/main/privacy">Privacy Policy</a></label>
        </div>
      </div>
    </div>
  </form>
</div>
