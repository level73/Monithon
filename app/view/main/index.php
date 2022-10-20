<div class="container">
  <div class="row">
    <div class="col">
        <div clasS="main-box-wrap">
      <h1>Benvenuto!</h1>

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
  </div>
    <div class="row">
        <div class="col">
            <br />
            <hr />
            <p>La metodologia, gli strumenti e i dati prodotti da Monithon sono pubblicati con licenza aperta <a href="https://creativecommons.org/licenses/by-sa/4.0">Creative Commons BY SA 4.0</a>. E’ possibile riutilizzarli e distribuirli liberamente citando Monithon come fonte, inserendo il link al contenuto e indicando eventuali modifiche effettuate. Si applica la stessa licenza in caso di riutilizzo: se si remixano e trasformano i metodi, i dati, gli strumenti o i materiali, vanno distribuiti con la stessa licenza CC BY SA.</p>

            <a href="https://creativecommons.org/licenses/by-sa/4.0" target="_blank"><img src="https://licensebuttons.net/l/by-sa/3.0/88x31.png" width="120"></a>
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
