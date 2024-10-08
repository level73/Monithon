<div class="container">
  <div class="row">
    <div class="col">
        <div clasS="main-box-wrap">
            <h1 class="mt-0">Benvenuto!</h1>
            <p>Questa è la piattaforma di lavoro di Monithon per la creazione e l’invio dei report di monitoraggio civico.</p>

            <p>Per creare un report ti devi registrare - ci basta una tua mail. Ti guideremo passo dopo passo sulle cose da fare. Ricorda che:</p>
            <ul>
                <li>Tutti i nostri strumenti sono gratuiti</li>
                <li>Non ti disturberemo in alcun modo con mail non necessarie alla pubblicazione del report</li>
                <li>Per effettuare il monitoraggio devi essere un soggetto non direttamente coinvolto nel progetto da monitorare</li>
            </ul>
            <hr />
            <p>Se sei già registrato, clicca su <a href="/user/login" >ACCEDI</a>.</p>

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
    <div class="main-box-wrap">
        <div class="row">

            <div class="col-12"><h2>Ultimi Report</h2></div>
            <?php foreach($reports as $report){ ?>
            <div class="col-3">
                <small>
                    <span class="report-date"><?php echo strftime('%d/%m/%Y', $report->create_date);?></span>
                </small>
                <h3><?php echo $report->titolo; ?></h3>
                <span class=" giudizio-sintetico <?php echo 'gde_'.$report->gs; ?>"><?php generateGDELabel($report->gs, $report->stato_di_avanzamento, 'main'); ?></span>
                <a class="btn btn-primary btn-block btn-sm mt-2" href="/report/view/<?php echo $report->id; ?>">LEGGI IL REPORT</a>
            </div>
            <?php } ?>
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
