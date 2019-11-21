<div class="container">

  <div class="row">
    <div class="col">
      <h1>
         <small class="text-muted">
           <img src="/resources/90x90_<?php echo $Profile->avatar->file_path; ?>" alt="<?php echo $Profile->avatar->title; ?>" class="avatar img-responsive"> <?php echo $Profile->username; ?>
         </small><br />
        <?php echo $title; ?>
      </h1>

    </div>
  </div>
  <form class="row" id="" method="post" action="/user/edit" enctype="multipart/form-data">
    <?php //dbga($Profile); ?>


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
        <input type="text" name="twitter" class="form-control" placeholder="<?php t('Handle di Twitter...'); ?>" value="<?php echo $Profile->twitter; ?>">
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
      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> <?php t('Salva'); ?></button>
    </div>

  </form>
  <hr />
  <?php if( count($reports) > 0){ ?>
  <section class="row" id="my-reports">
    <div class="col">
      <h1>I Miei Report</h1>

      <table class="table table-hover table-sm">
        <thead class="thead-dark">
          <tr>
            <th>Titolo</th>
            <th>Creato</th>
            <th>Ultima Modifica</th>
            <th class="text-center">Stato</th>
            <th class="text-center">Modifica</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($reports as $r){ ?>
          <tr>
            <td><?php echo $r->titolo; ?></td>
            <td><?php echo $r->created_at; ?></td>
            <td><?php echo $r->modified_at; ?></td>
            <td class="text-center"><?php status($r->status); ?></td>
            <td class="text-center">
              <?php if($r->status == 1){ ?>
              <a href="/report/edit/<?php echo $r->idreport_basic; ?>" class="btn btn-default btn-sm"><i class="far fa-pencil"></i></a>
              <?php } else { ?>
              <button type="button" disabled class="btn btn-default btn-sm"><i class="far fa-lock-alt"></i></button>
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
