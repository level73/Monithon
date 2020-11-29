<div class="container">
  <div class="row">
    <div class="col">
      <h1>MONITHON v3.0<br /><small>BETA</small></h1>
      <?php if(!$logged){ ?>
      <div class="row">
        <div class="col"><a href="/user/register" class="btn btn-primary btn-block">REGISTRATI</a></div>
        <div class="col"><a href="/user/login" class="btn btn-primary btn-block">ACCEDI</a></div>
      </div>
    <?php } else { ?>
      <div class="row">
        <div class="col">
          <a href="/report/create" class="btn btn-primary"><i class="fal fa-plus"></i> Crea un nuovo Report</a>
        </div>
      </div>
    <?php }?>
    </div>

  </div>
    <hr / >
    <section class="row">
        <div class="col">
            <h1>Mappa dei Report</h1>
            <div id="report-map" style="height: 600px;"></div>


        </div>
    </section>
</div>
