<div class="container">
  <div class="row">
    <div class="col">
      <h1>MONITHON v3.0</h1>
      <h2>Benvenuto!</h2>

        <p>Questa è la piattaforma di lavoro di Monithon per la creazione e l’invio dei report di monitoraggio civico.</p>
        <p>Vai su “<a href="/report/create">Nuovo Report</a>” per creare un report di monitoraggio. Per attivare la guida MoniTutor, incolla la URL della pagina del progetto che hai scelto su OpenCoesione nel primo campo.<p>
        <p>Per leggere i report già pubblicati, vai su “<a href="/report">Report</a>”.<p>
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
    <!--
    <hr / >
    <section class="row">
        <div class="col">
            <h1>Mappa dei Report</h1>
            <div id="report-map" style="height: 600px;"></div>


        </div>
    </section>
    -->
</div>
