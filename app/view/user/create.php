<div class="container">
  <form class="row">
    <div class="col">
      <div class="form-group">
        <label for="email">Email <span class="required">*</span></label>
        <input type="email" name="email" class="form-control" placeholder="<?php t('Email principale'); ?>">
      </div>
      <div class="form-group">
        <label for="secondary_email">Email Secondaria<span class="required">*</span></label>
        <input type="email" name="secondary_email" class="form-control" placeholder="<?php t('Email secondaria'); ?>">
      </div>
      <div class="form-group">
        <label for="username">Nome Utente <span class="required">*</span></label>
        <input type="username" class="form-control" placeholder="<?php t('Nome utente...'); ?>">
      </div>
      <div class="form-group">
        <label for="pwd">Password <span class="required">*</span></label>
        <input type="password" name="pwd" class="form-control" placeholder="<?php t('Password...'); ?>">
      </div>
      <div class="form-group">
        <label for="c_pwd">Conferma password <span class="required">*</span></label>
        <input type="password" name="c_pwd" class="form-control" placeholder="<?php t('Conferma password...'); ?>">
      </div>
      <div class="form-group">
        <label for="email">Ruolo <span class="required">*</span></label>
        <select class="form-control pck" name="role">
          <option value="3">Reporter</option>
          <option value="2">Editor</option>
          <option value="1">Admin</option>
        </select>
      </div>

    </div>
    <div class="col"></div>
    <div class="col"></div>

  </form>
