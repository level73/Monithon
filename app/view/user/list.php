<div class="container">



<?php if( count($list) > 0){ ?>
<section class="row" id="user-list">
  <div class="col">
    <h1><?php t('Lista degli Utenti'); ?></h1>
  </div>
</section>
    <table  class="table table-striped dtable" style="width:100%">
      <thead>
        <tr>
          <th><?php t('Username'); ?></th>
          <th><?php t('Email'); ?></th>
          <th><?php t('Ruolo'); ?></th>
          <th><?php t('Attivo?'); ?></th>
          <th><?php t('Privacy'); ?></th>
          <th><?php t('Ultimo Login'); ?></th>
          <th></th>
          <th></th>

        </tr>
      </thead>
      <tbody>
        <?php foreach($list as $u){ ?>
        <tr>
          <td><?php echo $u->username; ?></td>
          <td><?php echo $u->email; ?></td>
          <td><?php echo $u->role; ?></td>
          <td><?php echo $u->active; ?></td>
          <td><?php echo $u->privacy; ?></td>
          <td><?php echo strftime('%d/%m/%Y %H:%M', $u->last_login); ?></td>
          <td><a href="/user/update/<?php echo $u->id; ?>"><i class="fal fa-edit"></i></a></td>
          <td><a href="/user/ban/<?php echo $u->id; ?>"><i class="fal fa-ban"></i></a></td>

        </tr>
        <?php } ?>
      </tbody>
    </table>

<?php } ?>
</div>
