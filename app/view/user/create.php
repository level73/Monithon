<div class="container">
  <div class="row">
    <div class="col">
      <h1>Crea un nuovo Profilo</h1>
    </div>
  </div>
  <form method="post" action="/user/create">
    <div class="row">
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
          <input type="text" class="form-control" placeholder="<?php t('Nome utente...'); ?>" name="username" id="username">
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
          <label for="role">Ruolo <span class="required">*</span></label>
          <select class="form-control pck" name="role" id="role">
            <option value="3">Reporter</option>
            <option value="2">Editor</option>
            <option value="1">Admin</option>
            <option value="4">ASOC 19/20</option>
          </select>
        </div>

      </div>
      <div class="col">
        <div class="form-group">
          <label>Selezionare i permessi per questo utente</label>
          <?php foreach($permissions as $p) {  ?>
          <div class="custom-control custom-checkbox">
            <input
              class="custom-control-input"
              type="checkbox"
              value="<?php echo $p->idpermission; ?>"
              id="permission-<?php echo $p->idpermission; ?>"
              name="permissions[]">
            <label class="custom-control-label" for="permission-<?php echo $p->idpermission; ?>"><?php echo $p->permission; ?></label>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="row d-none" id="asoc">

      <div class="col">
        <div class="form-group">
          <label for="istituto">Istituto</label>
          <input type="text" class="form-control" placeholder="<?php t('Nome dell\'Istituto'); ?>" name="istituto" id="istituto">
        </div>
        <div class="form-group">
          <label for="tipo_istituto">Tipo d'Istituto</label>
          <input type="text" class="form-control" placeholder="<?php t('Tipo d \'istituto...'); ?>" name="tipo_istituto" id="tipo_istituto">
        </div>
        <div class="form-group">
          <label for="provincia">Provincia dell'Istituto</label>
          <select class="form-control pck" name="provincia" id="provincia" data-live-search="true">

            <?php foreach($province as $label => $r){ ?>
            <optgroup label="<?php echo $label; ?>">
              <?php foreach($r as $p){ ?>
              <option value="<?php echo $p->idprovincia; ?>" data-subtext="<?php echo $p->shorthand; ?>"><?php echo $p->provincia; ?></option>
              <?php } ?>
            </optgroup>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="comune">Comune dell'Istituto</label>
          <input type="text" class="form-control" placeholder="<?php t('Comune dell\'Istituto...'); ?>" name="comune" id="comune">
        </div>
      </div>


      <div class="col">

        <div class="form-group">
          <label for="remote_id">ID ASOC <span class="required">*</span></label>
          <input type="text" class="form-control" placeholder="<?php t('ID della piattaforma ASOC'); ?>" name="remote_id" id="remote_id">
        </div>
        <div class="form-group">
          <label for="link_blog">Link al Blog</label>
          <input type="text" class="form-control" placeholder="<?php t('Link alla pagina del blog del team...'); ?>" name="link_blog" id="link_blog">
        </div>
        <div class="form-group">
          <label for="link_elaborato">Link all'Elaborato</label>
          <input type="text" class="form-control" placeholder="<?php t('Link alla pagina dell\'elaborato del team...'); ?>" name="link_elaborato" id="link_elaborato">
        </div>
      </div>


    </div>
    <div class="row"><div class="col"><button class="btn btn-primary" type="submit"><i class="fal fa-user"></i> Registra utenza</button></div></div>

  </form>
</div>
