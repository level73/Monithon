<div class="container">
  <div class="row justify-content-center">
    <div class="col-8">
      <h1><?php t('Registrati'); ?></h1>
    </div>
  </div>
  <form action="/user/register" method="post" class="needs-validation" oninput="c_pwd.setCustomValidity(c_pwd.value != pwd.value ? 'Le Password non combaciano!' : '')">
    <div class="row justify-content-center" >
      <div class="col-4">
        <div class="form-group">
          <label for="email">Email <span class="required">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="<?php t('Email principale...'); ?>" required>
        </div>
        <div class="form-group">
          <label for="username">Nome Utente <span class="required">*</span></label>
          <input type="text" name="username" class="form-control" placeholder="<?php t('Nome utente...'); ?>" required>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label for="pwd">Password <span class="required">*</span></label>
          <input type="password" name="pwd" id="pwd" class="form-control" placeholder="<?php t('Password...'); ?>" required>
        </div>
        <div class="form-group">
          <label for="c_pwd">Conferma password <span class="required">*</span></label>
          <input type="password" name="c_pwd" id="c_pwd" class="form-control" placeholder="<?php t('Conferma password...'); ?>" required>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-4">
        <button type="submit" class="btn btn-primary"><i class="fal fa-user-plus"></i> <?php t('Registrati'); ?></button>
      </div>
      <div class="col-4">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" name="privacy-check" id="privacy-check" required>
          <label class="custom-control-label" for="privacy-check">Accetto la <a href="/main/privacy">Privacy Policy</a></label>
        </div>
      </div>
    </div>
  </form>
</div>
