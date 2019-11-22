<div class="container">



<?php if( count($list) > 0){ ?>
<section class="row" id="user-list">
  <div class="col">
    <h1><?php t('Lista degli Utenti'); ?></h1>
  </div>
</section>
    <table
      class="table table-hover table-sm"
      data-toggle="table"
      data-pagination="true"
      data-search="true"
      style="width:100%">
      <thead class="thead-dark">
        <tr>
          <th data-sortable="true" data-field="username"><?php t('Username'); ?></th>
          <th data-sortable="true" data-field="email"><?php t('Email'); ?></th>
          <th data-sortable="true" data-field="role"><?php t('Ruolo'); ?></th>
          <th data-sortable="true" data-field="active"><?php t('Attivo?'); ?></th>
          <th data-sortable="true" data-field="privacy"><?php t('Privacy'); ?></th>
          <th data-sortable="true" data-field="last_login"><?php t('Ultimo Login'); ?></th>
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
          <td><?php echo user_status($u->active); ?></td>
          <td><?php echo ($u->privacy == 1 ? 'SI' : 'NO'); ?></td>
          <td><?php echo strftime('%d/%m/%Y %H:%M', $u->last_login); ?></td>
          <td><a href="/user/update/<?php echo $u->id; ?>"><i class="fal fa-edit"></i></a></td>
          <td><a href="/user/ban/<?php echo $u->id; ?>"><i class="fal fa-ban"></i></a></td>

        </tr>
        <?php } ?>
      </tbody>
    </table>

<?php } ?>
</div>
