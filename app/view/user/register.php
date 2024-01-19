<div class="container">
  <div class="row justify-content-center">
    <div class="col-8">
      <h1><?php t('Registrati'); ?></h1>
    </div>
  </div>
  <form action="/user/register" method="post" class="needs-validation" oninput="c_pwd.setCustomValidity(c_pwd.value != pwd.value ? 'Le Password non combaciano!' : '')">
      <div class="row justify-content-center">
          <div class="col-8">
              <div class="form-group">
                  <label>In che qualità vuoi registrarti su Monithon?</label>
                   <br />
                  <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="utype-1" value="10" name="role" class="custom-control-input">
                      <label class="custom-control-label" for="utype-1">Partecipante ASOC</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="utype-4" value="13" name="role" class="custom-control-input">
                      <label class="custom-control-label" for="utype-4">ASOC Medie</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="utype-2" value="11" name="role" class="custom-control-input">
                      <label class="custom-control-label" for="utype-2">Studente Universitario</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="utype-3" value="3" name="role" class="custom-control-input">
                      <label class="custom-control-label" for="utype-3">Società Civile</label>
                  </div>
              </div>
          </div>
      </div>
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
