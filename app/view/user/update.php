<div class="container">
  <div class="row">
    <div class="col">
      <h1>
         <small class="text-muted">
           <?php avatar($Profile); ?> <?php echo $Profile->username; ?>
         </small><br />
        <?php echo $title; ?>
      </h1>

    </div>
  </div>

  <form  id="" method="post" action="/user/update/<?php echo $Profile->idauth; ?>" enctype="multipart/form-data">
    <div class="row">
      <input type="hidden" name="id" value="<?php echo $Profile->idauth; ?>">
      <div class="col">
        <div class="form-group">
          <label for="email">Email <span class="required">*</span></label>
          <input type="email" name="email" class="form-control" disabled placeholder="<?php t('Email principale'); ?>" value="<?php echo $Profile->email; ?>">
        </div>
        <div class="form-group">
          <label for="username">Nome Utente <span class="required">*</span></label>
          <input type="text" id="username" name="username" class="form-control" placeholder="<?php t('Nome utente...'); ?>" value="<?php echo $Profile->username; ?>" disabled>
        </div>
        <div class="form-group">
          <label for="secondary_email"><?php t('Email secondaria'); ?><span class="required">*</span></label>
          <input type="email" name="secondary_email" class="form-control" placeholder="<?php t('Email secondaria'); ?>" value="<?php echo $Profile->secondary_email; ?>">
        </div>
        <div class="form-group">
          <label for="role">Ruolo <span class="required">*</span></label>
          <select class="form-control pck" name="role" id="role">
            <?php foreach($roles as $role){ ?>
            <option value="<?php echo $role->idrole; ?>" <?php echo ($role->idrole == $Profile->role ? 'selected': ''); ?>><?php echo $role->role; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label for="city">Città</label>
          <input type="text" name="city" id="city" class="form-control" placeholder="<?php t('La città in cui vivi...'); ?>" value="<?php echo $Profile->city; ?>" >
        </div>
        <div class="form-group">
          <label for="twitter"><?php t('Twitter'); ?></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">@</div>
            </div>
            <input type="text" name="twitter" class="form-control" placeholder="<?php t('Handle di Twitter...'); ?>" value="<?php echo $Profile->twitter; ?>">
          </div>
        </div>

        <div class="form-group">
          <label>Carica il tuo Avatar</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="avatar">
            <label class="custom-file-label" for="customFile">Scegli Avatar...</label>
          </div>
        </div>
        <div class="form-group">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="active" value="2" id="activate-switch" <?php echo ($Profile->active == 2 ? 'checked' : ''); ?>>
            <label class="custom-control-label" for="activate-switch">Account Attivo</label>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label for="bio">Bio</label>
          <textarea name="bio" style="height: 144px" class="form-control"  placeholder="<?php t('Un piccolo paragrafo introduttivo...'); ?>"><?php echo $Profile->bio; ?></textarea>
        </div>
          <div class="form-group">
              <label for="url">URL</label>
              <input type="text" name="url" class="form-control" placeholder="<?php t('Indirizzo del tuo sito internet...'); ?>" value="<?php echo $Profile->url; ?>">
          </div>

      </div>


    </div>

      <?php if($Profile->role == 11){ ?>
          <div class="row" id="university">
              <div class="col-12">
                  <h2>PROFILO ISTITUTO UNIVERSITARIO</h2>
              </div>
              <div class="col-6">
                  <div class="form-group">
                      <label for="istituto">Nome Università</label>
                      <input type="text" class="form-control" placeholder="<?php t('Nome dell\'Università'); ?>" name="university" id="university" value="<?php echo ckv_object($UNI_Profile, 'university'); ?>">
                  </div>
                  <div class="form-group">
                      <label for="tipo_istituto">Corso di Laurea/Master/Dottorato</label>
                      <input type="text" class="form-control" placeholder="<?php t('Corso di laurea...'); ?>" name="degree" id="degree" value="<?php echo ckv_object($UNI_Profile,'degree'); ?>">
                  </div>
                  <div class="form-group">
                      <label for="tipo_istituto">Nome del Corso/Insegnamento/Laboratorio</label>
                      <input type="text" class="form-control" placeholder="<?php t('Nome del corso...'); ?>" name="class" id="class" value="<?php echo ckv_object($UNI_Profile,'class'); ?>">
                  </div>
              </div>
              <div class="col-6">
                  <div class="form-group">
                      <label for="provincia">Provincia dell'Università</label>
                      <select class="form-control pck" name="provincia" id="provincia" data-live-search="true">

                          <?php foreach($province as $label => $r){ ?>
                              <optgroup label="<?php echo $label; ?>">->
                                  <?php foreach($r as $p){ ?>
                                      <option value="<?php echo $p->idprovincia; ?>" data-subtext="<?php echo $p->shorthand; ?>" <?php echo (isset($UNI_Profile) && $p->idprovincia == $UNI_Profile->provincia ? 'selected': ''); ?>><?php echo $p->provincia; ?></option>
                                  <?php } ?>
                              </optgroup>
                          <?php } ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="comune">Comune dell'Università</label>
                      <input type="text" class="form-control" placeholder="<?php t('Comune dell\'Istituto...'); ?>" name="comune" id="comune" value="<?php echo ckv_object($UNI_Profile, 'comune'); ?>">
                  </div>
              </div>

          </div>
      <?php } ?>
      <?php if($Profile->role > 3 && $Profile->role < 11 ){ ?>
      <div class="row" id="asoc">
        <div class="col-12">
          <hr />
          <h2>PROFILO ASOC</h2>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="istituto">Istituto</label>
            <input type="text" class="form-control" placeholder="<?php t('Nome dell\'Istituto'); ?>" name="istituto" id="istituto" value="<?php echo $ASOC_Profile->istituto; ?>">
          </div>
          <div class="form-group">
            <label for="tipo_istituto">Tipo d'Istituto</label>
            <input type="text" class="form-control" placeholder="<?php t('Tipo d \'istituto...'); ?>" name="tipo_istituto" id="tipo_istituto" value="<?php echo $ASOC_Profile->istituto; ?>">
          </div>
          <div class="form-group">
            <label for="provincia">Provincia dell'Istituto</label>
            <select class="form-control pck" name="provincia" id="provincia" data-live-search="true">

              <?php foreach($province as $label => $r){ ?>
              <optgroup label="<?php echo $label; ?>">
                <?php foreach($r as $p){ ?>
                <option value="<?php echo $p->idprovincia; ?>" data-subtext="<?php echo $p->shorthand; ?>" <?php echo ($p->idprovincia == $ASOC_Profile->provincia ? 'selected': ''); ?>><?php echo $p->provincia; ?></option>
                <?php } ?>
              </optgroup>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="comune">Comune dell'Istituto</label>
            <input type="text" class="form-control" placeholder="<?php t('Comune dell\'Istituto...'); ?>" name="comune" id="comune" value="<?php echo $ASOC_Profile->comune; ?>">
          </div>
        </div>


        <div class="col-6">

          <div class="form-group">
            <label for="remote_id">ID ASOC <span class="required">*</span></label>
            <input type="text" class="form-control" placeholder="<?php t('ID della piattaforma ASOC'); ?>" value="<?php echo $ASOC_Profile->remote_id; ?>" name="remote_id" id="remote_id">
          </div>
          <div class="form-group">
            <label for="link_blog">Link al Blog</label>
            <input type="text" class="form-control" placeholder="<?php t('Link alla pagina del blog del team...'); ?>" value="<?php echo $ASOC_Profile->link_blog; ?>" name="link_blog" id="link_blog">
          </div>
          <div class="form-group">
            <label for="link_elaborato">Link all'Elaborato Creativo</label>
            <input type="text" class="form-control" placeholder="<?php t('Link alla pagina dell\'elaborato del team...'); ?>" value="<?php echo $ASOC_Profile->link_elaborato; ?>" name="link_elaborato" id="link_elaborato">
          </div>
        </div>


      </div>
    <?php } ?>

    <div class="row">
      <div class="col">
        <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> <?php t('Salva'); ?></button>
      </div>
    </div>
  </form>
</div>
