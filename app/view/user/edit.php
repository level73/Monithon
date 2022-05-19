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
  <form  id="" method="post" action="/user/edit" enctype="multipart/form-data">
    <div class="row">
    <input type="hidden" name="id" value="<?php echo $user->id; ?>">
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
    </div>
    <div class="col">
      <div class="form-group">
        <label for="bio">Bio</label>
        <textarea name="bio" rows="8" class="form-control"  placeholder="<?php t('Un piccolo paragrafo introduttivo...'); ?>"><?php echo $Profile->bio; ?></textarea>
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
                                <option value="<?php echo $p->idprovincia; ?>" data-subtext="<?php echo $p->shorthand; ?>" <?php echo (isset($ASOC_Profile) && $p->idprovincia == $UNI_Profile->provincia ? 'selected': ''); ?>><?php echo $p->provincia; ?></option>
                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="comune">Comune dell'Universtà</label>
                <input type="text" class="form-control" placeholder="<?php t('Comune dell\'Istituto...'); ?>" name="comune" id="comune" value="<?php echo ckv_object($UNI_Profile, 'comune'); ?>">
            </div>
        </div>

    </div>
    <?php } ?>
    <?php if($Profile->role > 3 && $Profile->role < 11 ){ ?>
    <div class="row" id="asoc">
      <div class="col-12">
        <h2>PROFILO ASOC</h2>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label for="istituto">Istituto</label>
          <input type="text" class="form-control" placeholder="<?php t('Nome dell\'Istituto'); ?>" name="istituto" id="istituto" value="<?php echo ckv_object($ASOC_Profile, 'istituto'); ?>">
        </div>
        <div class="form-group">
          <label for="tipo_istituto">Tipo d'Istituto</label>
          <input type="text" class="form-control" placeholder="<?php t('Tipo d \'istituto...'); ?>" name="tipo_istituto" id="tipo_istituto" value="<?php echo ckv_object($ASOC_Profile,'tipo_istituto'); ?>">
        </div>
        <div class="form-group">
          <label for="provincia">Provincia dell'Istituto</label>
          <select class="form-control pck" name="provincia" id="provincia" data-live-search="true">

            <?php foreach($province as $label => $r){ ?>
            <optgroup label="<?php echo $label; ?>">->
              <?php foreach($r as $p){ ?>
              <option value="<?php echo $p->idprovincia; ?>" data-subtext="<?php echo $p->shorthand; ?>" <?php echo (isset($ASOC_Profile) && $p->idprovincia == $ASOC_Profile->provincia ? 'selected': ''); ?>><?php echo $p->provincia; ?></option>
              <?php } ?>
            </optgroup>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="comune">Comune dell'Istituto</label>
          <input type="text" class="form-control" placeholder="<?php t('Comune dell\'Istituto...'); ?>" name="comune" id="comune" value="<?php echo ckv_object($ASOC_Profile, 'comune'); ?>">
        </div>
      </div>


      <div class="col-6">

        <div class="form-group">
          <label for="remote_id">ID ASOC <span class="required">*</span></label>
          <input type="text" class="form-control" placeholder="<?php t('ID della piattaforma ASOC'); ?>" value="<?php echo ckv_object($ASOC_Profile, 'remote_id'); ?>" name="remote_id" id="remote_id">
        </div>
        <div class="form-group">
          <label for="link_blog">Link alla pagina del team sul sito di ASOC</label>
          <input type="text" class="form-control" placeholder="<?php t('Link alla pagina del blog del team...'); ?>" value="<?php echo ckv_object($ASOC_Profile,'link_blog'); ?>" name="link_blog" id="link_blog">
        </div>
        <?php /*
        <div class="form-group">
          <label for="link_elaborato">Link all'Elaborato Creativo</label>
          <input type="text" class="form-control" placeholder="<?php t('Link alla pagina dell\'elaborato del team...'); ?>" value="<?php echo ckv_object($ASOC_Profile, 'link_elaborato'); ?>" name="link_elaborato" id="link_elaborato">
        </div>
        */ ?>
      </div>


    </div>
  <?php } ?>

  <div class="row">
    <div class="col">
      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> <?php t('Salva'); ?></button>
    </div>
</div>
  </form>
  <hr />
  <?php if( count($reports) > 0){ ?>
  <section class="row" id="my-reports">
    <div class="col">

      <h1>I Miei Report</h1>

      <table class="table table-hover table-sm"
        data-toggle="table"
        data-pagination="true"
        data-search="true"
      >
        <thead class="thead-dark">
          <tr>
            <th data-sortable="true" data-field="titolo">Titolo</th>
            <?php if($Profile->role < 3){ ?>
            <th data-sortable="true" data-field="team">Team</th>
            <?php } ?>
            <th data-sortable="true" data-field="created_at">Creato</th>
            <th data-sortable="true" data-field="modified_at">Ultima Modifica</th>
            <th data-sortable="true" data-field="status"class="text-center">Stato</th>
            <th data-sortable="true" data-field="status_tab_3"class="text-center">Stato (Step 3)</th>
            <th data-field="edit" class="text-center">Modifica</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($reports as $r){ ?>
          <tr>
            <td>
                <?php
                echo ($r->status == 7) ? '<a href="/report/view/' . $r->idreport_basic . '">' . $r->titolo . '</a>' : $r->titolo;
                ?>
            </td>
            <?php if($Profile->role < 3){ ?>
            <td><a href="mailto:<?php echo $r->email; ?>"><?php echo $r->username; ?></a></td>
            <?php } ?>
            <td><?php echo $r->created_at; ?></td>
            <td><?php echo $r->modified_at; ?></td>
            <td class="text-center"><?php status($r->status); ?></td>
            <td class="text-center"><?php status($r->status_tab_3); ?></td>
            <td class="text-center">
            <?php
            // CONDITION 1: (user is at least an editor OR user has permission OR is reviewer) AND (report in pending review)
            if( ( $user->role <= 2 || hasPermission($user, array(P_EDIT_REPORT, P_ASSIGN_REPORT, P_BOUNCE_REPORT, P_COMMENT_REPORT, P_MANAGE_REPORT_CARD) ) || $r->reviewed_by == $user->id) && ($r->status == 3 || $r->status_tab_3 == 3) ){
            ?>
                <a href="/report/review/<?php echo $r->idreport_basic; ?>" class="btn btn-default btn-sm"><i class="far fa-pencil"></i></a>
            <?php

            } else {
                
              if($r->status == 1 || $r->status_tab_3 == 1){ ?>
              <a href="/report/edit/<?php echo $r->idreport_basic; ?>" class="btn btn-default btn-sm"><i class="far fa-pencil"></i></a>
              <?php
              } else { ?>
                 <button type="button" disabled class="btn btn-default btn-sm"><i class="far fa-lock-alt"></i></button>
              <?php } ?>

            <?php } ?>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </section>

  <?php } ?>


</div>
