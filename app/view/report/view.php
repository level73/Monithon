<div class="container-fluid" id="report-page">
    <section class="row">
        <aside class=" col-sm-12 float-sm-left col-md-3">
            <span class="invisible" id="lat"><?php echo $report->lat_; ?></span>
            <span class="invisible" id="lon"><?php echo $report->lon_; ?></span>
            <div id="report-map"></div>
            <span class="report-side-detail"><?php echo $report->indirizzo . ' (' . $report->cap . ')';?></span>
            <h4>Titolo del Progetto</h4>
            <?php echo $oc->oc_titolo_progetto; ?>
            <h4>IN BREVE</h4>
            <div class="row">
                <div class="col"><span class=" giudizio-sintetico <?php echo cssify($report->giudizio_sintetico); ?>"><?php echo $report->giudizio_sintetico; ?></span></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="report-in-short report-in-short-efficacia">
                        <?php
                        foreach($efficacia as $label => $value){
                            if($value > 0){
                                ?>
                                <li><?php echo $label; ?></li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
            </div>


            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title">Tema</span></div>
                <div class="col"><span class="report-side-value"><?php echo $oc->oc_tema_sintetico; ?></div>
            </div>

            <h4>Informazioni ufficiali al momento del monitoraggio</h4>
            <?php if(isset($oc->oc_data_inizio_progetto) && !empty($oc->oc_data_inizio_progetto) ){ ?>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title">Data inizio</span></div>
                <div class="col"><span class="report-side-value"><?php echo ocDateFormatter($oc->oc_data_inizio_progetto); ?></div>
            </div>
            <?php } ?>
            <?php if(isset($oc->oc_data_fine_progetto_prevista) && !empty($oc->oc_data_fine_progetto_prevista) ){ ?>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title">Data fine</span></div>
                <div class="col"><span class="report-side-value"><?php echo ocDateFormatter($oc->oc_data_fine_progetto_prevista); ?></div>
            </div>
            <?php } ?>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title">Stato del progetto</span></div>
                <div class="col"><span class="report-side-value"><?php echo strtoupper($oc->oc_stato_progetto); ?></div>
            </div>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title">Costo totale</span></div>
                <div class="col"><span class="report-side-value"><?php echo $oc->finanz_totale_pubblico; ?> €</div>
            </div>

            <?php if(isset($oc->programmi)){ ?>
            <div class="row programmi report-side-oc">
                <div class="col-5"><span class="report-side-title">Progetto finanziato da</span></div>
                <div class="col">
                    <span class="report-side-value">
                    <?php foreach($oc->programmi as $p){
                        echo $p->oc_descrizione_programma;
                    } ?>
                    </span>
                </div>

            </div>
            <?php } ?>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title">Nel ciclo</span></div>
                <div class="col"><span class="report-side-value"><?php echo $oc->oc_descr_ciclo; ?></div>
            </div>
            <a href="https://<?php echo str_replace('www.', '', $oc->oc_link); ?>" class="" target="_blank">
                Accedi alle informazioni aggiornate sul portale governativo OpenCoesione
            </a>

            <h4>Soggetti</h4>
            <?php foreach($soggetti as $ruolo => $sg){ ?>
                <h5><?php echo $ruolo; ?></h5>
                <?php foreach($sg as $soggetto){ ?>
                    <a href="<?php echo str_replace('it/api/', '', $soggetto->url); ?>" target="_blank" class="report-subject"><?php echo $soggetto->denominazione; ?></a>
                <?php } ?>
            <?php } ?>


            <h4>RISORSE</h4>
            <?php
            foreach($report->videos as $video){
                ?>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="<?php echo $video->embed; ?>" allowfullscreen></iframe>
                </div>
            <?php } ?>
            <?php foreach($images as $image){ ?>
                <div class="img">
                    <img src="<?php echo image($image); ?>" class="img-fluid">
                </div>
            <?php } ?>
            <?php if(!empty($resources)){ ?>
                <ul>
                    <?php foreach($resources as $i => $resource){ ?>

                        <li><a href="<?php echo URL_REPO . $resource->file_path; ?>" target="_blank">Allegato [n. <?php echo $i+1; ?>]</a></li>
                    <?php } ?>
                </ul>

            <?php } ?>
            <?php if(!empty($report->links)){ ?>
                <h5>Sorgenti & Links</h5>
                <ul id="report-sources">
                    <?php foreach($report->links as $l){ ?>
                        <li><a href="<?php echo $l->URL; ?>" target="_blank"><?php echo $l->URL; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>


        </aside>

        <article class="col-sm-12 col-md-8" id="report-view">

            <h1>
                <span class="title-label"><small>REPORT DI MONITORAGGIO CIVICO</small><br /></span><?php echo $report->titolo; ?><br />

            </h1>

            <span class="report-date">Inviato il <?php  echo strftime('%e/%m/%Y', strtotime($report->modified_at)); ?> | di <?php echo $author->username; ?>
                <?php if(!empty($author->twitter)) { ?> | <a href="https://twitter.com/<?php echo str_replace('@', '', $author->twitter); ?>" target="_blank"><i class="fab fa-twitter"></i> @<?php echo str_replace('@', '', $author->twitter); ?></a><?php } ?>
            </span>

            <div class="report-body">
                <h2>Descrizione <span class="float-right"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></span></h2>
                <p>
                    <img class="report-main-image" src="<?php echo image($images[0]); ?>" alt="">
                    <?php echo nl2br($report->descrizione); ?>
                </p>

                <p><?php echo nl2br($report->parte_di_piano); ?></p>

                <h2>Avanzamento</h2>
                <p><?php echo nl2br($report->avanzamento); ?></p>
                <h2>Risultati</h2>
                <span class="report-ev-hilite"><?php echo $valutazione; ?></span>
                <p><?php echo nl2br($report->risultato_progetto); ?></p>
                <div class="row">
                    <div class="col">
                        <h2>Punti di debolezza</h2>
                        <p><?php echo nl2br($report->punti_deboli); ?></p>
                    </div>
                    <div class="col">
                        <h2>Punti di forza</h2>
                        <p><?php echo nl2br($report->punti_di_forza); ?></p>
                    </div>
                </div>

                 <h2>Rischi</h2>
                 <p><?php echo nl2br($report->rischi); ?></p>

                <div class="report-solutions">
                    <h2>Soluzioni e Idee</h2>
                    <p><?php echo nl2br($report->soluzioni_progetto); ?></p>
                </div>

                <h1>L'INDAGINE</h1>
                <h2>Come sono state raccolte le informazioni?</h2>
                <ul>
                    <?php foreach($raccolta as $label => $v){ ?>
                        <li><?php echo $label; ?></li>
                    <?php } ?>
                </ul>
                <p><?php echo nl2br($report->intervista_intervistati); ?></p>

                <h2>Domande principali</h2>
                <p><?php echo nl2br($report->intervista_domande); ?></p>

                <h2>Risposte principali</h2>
                <p><?php echo nl2br($report->intervista_risposte); ?></p>

            </div>

        </article>
    </section>
</div>


