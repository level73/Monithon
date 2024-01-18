<div class="container-fluid" id="report-page">

    <section class="row">

            <header class="col-md-8 offset-md-3">
                <h1>
                    <span class="title-label"><small><?php t_report('REPORT DI MONITORAGGIO CIVICO'); ?></small> <?php AsocExp($report); ?><br /></span><?php echo $report->titolo; ?><br />

                </h1>
                <span class="report-date"><?php t_report('Inviato il'); ?> <?php  echo strftime('%e/%m/%Y', strtotime($report->created_at)); ?> | <?php t_report('di'); ?> <a href="/profile/view/<?php echo $author->idauth; ?>"><?php echo $author->role==4 ? $author->username: $report->autore; //$author->username; ?></a>
                <?php if(!empty($author->twitter)) { ?> | <a href="https://twitter.com/<?php echo str_replace('@', '', $author->twitter); ?>" target="_blank"><i class="fab fa-twitter"></i> @<?php echo str_replace('@', '', $author->twitter); ?></a><?php } ?>

            </span>
            </header>

        <aside class=" col-sm-12 float-sm-left float-xs-left col-md-3">
            <span class="invisible" id="lat"><?php echo $report->lat_; ?></span>
            <span class="invisible" id="lon"><?php echo $report->lon_; ?></span>
            <div id="report-map"></div>
            <span class="report-side-detail"><?php echo $report->indirizzo . ' (' . $report->cap . ')';?></span>
            <?php if(!empty($oc)){ ?>
            <h4><?php t_report('Titolo del Progetto'); ?></h4>
            <?php echo $oc->oc_titolo_progetto; ?>
            <?php } ?>

            <?php if($report->step_1_only == 0){ ?>
            <h4><?php t_report('GIUDIZIO DI EFFICACIA'); ?></h4>

            <div class="row">
                <div class="col">
                    <span class=" giudizio-sintetico <?php echo 'gde_'.$report->gs; ?>"><?php t_report(generateGDELabel($report->gs, $report->stato_di_avanzamento, 'main', false)); ?></span>
                    <span class="gde_sub_label  <?php echo 'gde_sub_'.$report->gs; ?>"><?php t_report(generateGDELabel($report->gs, $report->stato_di_avanzamento, 'sub',false)); ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <span class="sda_title"><?php t_report('Stato di Avanzamento al Monitoraggio'); ?></span>
                    <?php if(!empty($report->stato_di_avanzamento_infrastrutturale)){ ?>
                        <span class="sda_label_infr"><?php t_report(SDAI_LABELS[$report->stato_di_avanzamento_infrastrutturale]); ?></span>
                    <?php } ?>
                    <span class="sda_label"><?php t_report(SDA_LABELS[$report->stato_di_avanzamento]); ?></span>
                </div>

            </div>
            <?php } ?>
            <?php /*
            <div class="row">
                <div class="col-12">
                    <ul class="report-in-short report-in-short-efficacia">
                        <?php
                        foreach($efficacia as $label => $value){
                            if($value > 0){
                                ?>
                                <li><?php t_report($label); ?></li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
            </div>
 */ ?>
            <?php if($report->status_tab_3 == PUBLISHED){ ?>
            <h4><?php t_report('IMPATTO'); ?></h4>

            <?php if($report->media_connection > 0){ ?>
            <div class="row report-impact">
                <div class="col text-center"><h5><?php t_report('Report Ripreso dai Media'); ?></h5></div>
            </div>
            <?php } ?>
            <?php if($report->admin_connection > 0){ ?>
                <div class="row report-impact">
                    <div class="col-5"><span class="report-side-title"><?php t_report('Contatti con le Amministrazioni'); ?></span></div>
                    <div class="col">
                    <?php
                        echo ($report->admin_response_no == 1 ? t_report('Nessuna risposta', false) . '<br />' : '');
                        echo ($report->admin_response_formal == 1 ? t_report('Risposte generiche', false) . '<br />' : '');
                        echo ($report->admin_response_some == 1 ? t_report('Risposta parziale', false) . '<br />' : '');
                        echo ($report->admin_response_promises == 1 ? t_report('Promesse concrete', false) . '<br />' : '');
                        echo ($report->admin_response_unlocked == 1 ? t_report('Progetto più efficace', false) . '<br />' : '');
                        echo ($report->admin_response_flagged == 1 ? t_report('Problema risolto', false) . '<br />' : '');
                    ?>
                    </div>
                </div>
            <?php } ?>
            <?php } ?>
            <?php if(!empty($oc)){ ?>


            <h4><?php t_report('Informazioni ufficiali al momento del monitoraggio'); ?></h4>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title"><?php t_report('Tema'); ?></span></div>
                <div class="col"><span class="report-side-value"><?php echo $oc->oc_tema_sintetico; ?></div>
            </div>
            <?php if(isset($oc->oc_data_inizio_progetto) && !empty($oc->oc_data_inizio_progetto) ){ ?>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title"><?php t_report('Data inizio'); ?></span></div>
                <div class="col"><span class="report-side-value"><?php echo ocDateFormatter($oc->oc_data_inizio_progetto); ?></div>
            </div>
            <?php } ?>
            <?php if(isset($oc->oc_data_fine_progetto_prevista) && !empty($oc->oc_data_fine_progetto_prevista) ){ ?>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title"><?php t_report('Data fine'); ?></span></div>
                <div class="col"><span class="report-side-value"><?php echo ocDateFormatter($oc->oc_data_fine_progetto_prevista); ?></div>
            </div>
            <?php } ?>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title"><?php t_report('Stato del progetto'); ?></span></div>
                <div class="col"><span class="report-side-value"><?php echo strtoupper($oc->oc_stato_progetto); ?></div>
            </div>
            <div class="row report-side-oc">
                <div class="col-5"><span class="report-side-title"><?php t_report('Costo totale'); ?></span></div>
                <div class="col"><span class="report-side-value"><?php echo $oc->finanz_totale_pubblico; ?> €</div>
            </div>

            <?php if(isset($oc->programmi)){ ?>
            <div class="row programmi report-side-oc">
                <div class="col-5"><span class="report-side-title"><?php t_report('Progetto finanziato da'); ?></span></div>
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
                <div class="col-5"><span class="report-side-title"><?php t_report('Nel ciclo'); ?></span></div>
                <div class="col"><span class="report-side-value"><?php echo $oc->oc_descr_ciclo; ?></div>
            </div>
            <?php $oc_link = (empty($oc->oc_link) || !isset($oc->oc_link) ?  str_replace('www.', '', $report->id_open_coesione) :  str_replace('www.', '', $oc->oc_link)); ?>
            <a href="https://<?php echo $oc_link; ?>" class="" target="_blank">
                <?php t_report('Accedi alle informazioni aggiornate sul portale governativo OpenCoesione'); ?>
            </a>
            <?php } ?>


            <?php if(!empty($soggetti)){ ?>
            <h4><?php t_report('Soggetti'); ?></h4>
            <?php foreach($soggetti as $ruolo => $sg){ ?>

                <h5><?php t_report($ruolo); ?></h5>
                <?php if(count($sg) < 5) { ?>
                <?php foreach($sg as $soggetto){ ?>
                    <?php if(isset($soggetto->url)){ ?>
                    <a href="<?php echo str_replace('it/api/', '', $soggetto->url); ?>" target="_blank" class="report-subject"><?php echo $soggetto->denominazione; ?></a>
                    <?php } else { echo "<a class=\"report-subject\">" . $soggetto->denominazione . "</a>"; } ?>
                <?php } ?>
                <?php } else { ?>

                <?php for($i = 0; $i < 4; $i++){ ?>
                    <?php $soggetto = $sg[$i]; ?>
                        <?php if(isset($soggetto->url)){ ?>
                            <a href="<?php echo str_replace('it/api/', '', $soggetto->url); ?>" target="_blank" class="report-subject"><?php echo $soggetto->denominazione; ?></a>
                        <?php } else { echo "<a class=\"report-subject\">" . $soggetto->denominazione . "</a>"; } ?>
                        <?php } ?>
                    <p class="text-center">
                        <small>
                            Visualizzati 4 soggetti di <?php echo count($sg); ?><br />
                            <a href="https://<?php echo $oc_link; ?>" class="" target="_blank">Altri dettagli su OpenCoesione.gov.it</a>
                        </small>
                    </p>
                <?php } ?>

            <?php } ?>
            <?php } ?>


            <h4><?php t_report('MATERIALI'); ?></h4>
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

            <?php if(!empty($report->immagine_monitoraggio_daASOC)){ ?>
            <div class="img">
                <img src="<?php echo $report->immagine_monitoraggio_daASOC; ?>" alt="Immagine Monitoraggio" class="img-fluid">
            </div>
            <?php } ?>
            <?php if(!empty($report->immagine_team1_daASOC)){ ?>
            <div class="img">
                <img src="<?php echo $report->immagine_team1_daASOC; ?>" alt="Immagine Monitoraggio" class="img-fluid">
            </div>
            <?php } ?>
            <?php if(!empty($report->immagine_team2_daASOC)){ ?>
            <div class="img">
                <img src="<?php echo $report->immagine_team2_daASOC; ?>" alt="Immagine Monitoraggio" class="img-fluid">
            </div>
            <?php } ?>
            <?php if(!empty($report->immagine_team3_daASOC)){ ?>
            <div class="img">
                <img src="<?php echo $report->immagine_team3_daASOC; ?>" alt="Immagine Monitoraggio" class="img-fluid">
            </div>
            <?php } ?>

            <?php if(!empty($report->video_daASOC)){ ?>
            <a href="<?php echo $report->video_daASOC; ?>" target="_blank">Video per <strong>A Scuola di Open Coesione</strong></a>
            <?php } ?>

            <?php if(!empty($report->links)){ ?>
                <h5><?php t_report('Sorgenti & Links'); ?></h5>
                <ul id="report-sources">
                    <?php foreach($report->links as $l){ ?>
                        <li><a href="<?php echo $l->URL; ?>" target="_blank"><?php echo $l->URL; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>


        </aside>

        <section class="col-sm-12 col-md-8" id="report-view">

            <div class="report-body">

                <?php if($report->step_1_only == ONLY_STEP_ONE ){ ?>
                    <h1><?php t_report('Cosa abbiamo scoperto'); ?></h1>
                    <?php if(!empty($report->obiettivi)){ ?>
                    <h2><?php t_report('Obiettivi del progetto'); ?> <span class="float-right"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></span></h2>
                    <p> <?php echo nl2br($report->obiettivi); ?></p>
                    <?php } ?>
                    <?php if(!empty($report->attivita)){ ?>
                    <h2><?php t_report('Attività previste'); ?></h2>
                    <p> <?php echo nl2br($report->attivita); ?></p>
                    <?php } ?>
                <?php if(!empty($report->origine)){ ?>
                    <h2><?php t_report('Origine del progetto'); ?></h2>
                    <p> <?php echo nl2br($report->origine); ?></p>
                <?php } ?>
                <?php if(!empty($report->soggetti_beneficiari)){ ?>
                    <h2><?php t_report('Soggetti Beneficiari'); ?></h2>
                    <p> <?php echo nl2br($report->soggetti_beneficiari); ?></p>
                <?php } ?>
                <?php if(!empty($report->contesto)){ ?>
                    <h2><?php t_report('Contesto'); ?></h2>
                    <p> <?php echo nl2br($report->contesto); ?></p>
                <?php } ?>
<?php /*
                    <?php if($report->is_gender_topic == 1){ ?>
                    <h1><?php t_report('Parità di genere'); ?></h1>
                    <small><?php t_report('Nel progetto è coinvolta direttamente o indirettamente la parità di genere'); ?></small>




                    <?php } ?>
<img class="report-main-image" src="<?php echo image($images[0]); ?>" alt="">
                            <?php echo nl2br($report->descrizione); ?>
*/ ?>
                <?php } else { ?>

                <div class="report-section">
                    <?php if(!empty($report->descrizione)): ?>
                        <h1><?php t_report('Descrizione'); ?></h1>
                        <p><?php echo nl2br($report->descrizione); ?></p>
                    <?php endif; ?>

                    <h1><?php t_report('Cosa abbiamo scoperto'); ?></h1>
                    <?php if(!empty($report->obiettivi)){ ?>
                        <h2><?php t_report('Obiettivi del progetto'); ?> <span class="float-right"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></span></h2>
                        <p>
                            <img class="report-main-image" src="<?php echo image($images[0]); ?>" alt="">
                            <?php echo nl2br($report->obiettivi); ?>
                        </p>
                    <?php } ?>
                    <?php if(!empty($report->attivita)){ ?>
                        <h2><?php t_report('Attività previste'); ?></h2>
                        <p> <?php echo nl2br($report->attivita); ?></p>
                    <?php } ?>
                    <?php if(!empty($report->origine)){ ?>
                        <h2><?php t_report('Origine del progetto'); ?></h2>
                        <p> <?php echo nl2br($report->origine); ?></p>
                    <?php } ?>
                    <?php if(!empty($report->soggetti_beneficiari)){ ?>
                        <h2><?php t_report('Soggetti Beneficiari'); ?></h2>
                        <p> <?php echo nl2br($report->soggetti_beneficiari); ?></p>
                    <?php } ?>
                    <?php if(!empty($report->contesto)){ ?>
                        <h2><?php t_report('Contesto'); ?></h2>
                        <p> <?php echo nl2br($report->contesto); ?></p>
                    <?php } ?>

                        <h2><?php t_report('Avanzamento'); ?></h2>
                        <p><?php echo nl2br($report->avanzamento); ?></p>
                        <h2><?php t_report('Risultati'); ?></h2>
                    <?php if(!empty($valutazione)) : ?>
                        <span class="report-ev-hilite"><?php t_report($valutazione); ?></span>
                    <?php endif; ?>
                        <p><?php echo nl2br($report->risultato_progetto); ?></p>
                        <div class="row">
                            <div class="col">
                                <h2><?php t_report('Punti di debolezza'); ?></h2>
                                <p><?php echo nl2br($report->punti_deboli); ?></p>
                            </div>
                            <div class="col">
                                <h2><?php t_report('Punti di forza'); ?></h2>
                                <p><?php echo nl2br($report->punti_di_forza); ?></p>
                            </div>
                        </div>

                         <h2><?php t_report('Rischi'); ?></h2>
                         <p><?php echo nl2br($report->rischi); ?></p>

                        <div class="report-solutions">
                            <h2><?php t_report("Soluzioni e Idee"); ?></h2>
                            <p><?php echo nl2br($report->soluzioni_progetto); ?></p>
                        </div>

                    <?php
                    /** CHECK FOR GENDER EQUALITY INFO BOXES */
                    if($report->is_gender_topic > 0):
                    ?>
                    <div class="report-gender-box">
                        <h3><?php t_report("Parità di Genere"); ?></h3>
                        


                    </div>


                    <?php
                    endif;
                    ?>
                </div>

                <?php if($report->status_tab_3 == PUBLISHED ){ ?>
                <div class="report-section">
                        <h1><?php t_report('Risultati e impatto del monitoraggio'); ?></h1>
                    <div class="row">
                        <div class="col">
                            <h2><?php t_report('Diffusione dei risultati'); ?></h2>
                            <ul>
                                <?php
                                echo $report->diffusione_twitter > 0 ? '<li>Twitter</li>' : '';
                                echo $report->diffusione_facebook > 0 ? '<li>Facebook</li>' : '';
                                echo $report->diffusione_instagram > 0 ? '<li>Instagram</li>' : '';
                               echo  ($report->diffusione_eventi > 0 ?  '<li>' . t_report('Eventi territoriali organizzati dai team', false) : '' ) . '</li>';
                               echo  ($report->diffusione_open_admin > 0 ? '<li>' . t_report('Settimana dell\'Amministrazione Aperta', false)  : '') . '</li>';
                               echo  ($report->diffusione_blog > 0 ? '<li>' . t_report('Blog/Sito web del Team', false) : '') . '</li>';
                               echo  ($report->diffusione_offline > 0 ? '<li>' . t_report('Volantinaggio o altri metodi off-line (non via Internet)', false)  : '').  '</li>';
                               echo  ($report->diffusione_incontri > 0 ? '<li>' . t_report('Richiesta di audizioni o incontri a porte chiuse', false)  : '') . '</li>';
                               echo  ($report->diffusione_interviste > 0 ? '<li>' . t_report('Interviste ai media', false)  : '') . '</li>';
                               echo  ($report->diffusione_altro > 0 ? '<li>' . $report->diffusione_altro : '') . '</li>';
                                ?>
                            </ul>
                        </div>
                        <div class="col">
                            <h2><?php t_report('connessioni'); ?></h2>
                            <ul>
                                <?php
                                if(!empty($connections)){
                                    foreach($connections as $c){
                                        ?>
                                        <li><?php echo $c->role.', ' . $c->organisation; ?></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h2><?php t_report('contatti con i media'); ?></h2>
                            <ul>
                                <?php
                                echo $report->tv_locali  > 0 ? '<li>' . t_report('TV Locali', false) . '</li>' : '';
                                echo $report->tv_nazionali  > 0 ? '<li>' . t_report('TV Nazionali', false) . '</li>' : '';
                                echo $report->giornali_locali  > 0 ? '<li>' . t_report('Giornali Locali', false) . '</li>' : '';
                                echo $report->giornali_nazionali  > 0 ? '<li>' . t_report('Giornali Nazionali', false) . '</li>' : '';
                                echo $report->blog_online  > 0 ? '<li>' . t_report('Blog o altre news outlet online', false) . '</li>' : '';
                                echo $report->media_other > 0 ? '<li>' . t_report('Altro', false) . '</li>' : '';
                                ?>
                            </ul>
                        </div>
                        <div class="col">
                            <h2><?php t_report('Contatti con le Pubbliche Amministrazioni per discutere i risultati del Monitoraggio'); ?></h2>
                            <?php
                            if($report->admin_connection < 1){ ?>
                                <p><?php t_report('Non le abbiamo contattate'); ?></p>
                            <?php } else { ?>
                                <ul>
                                    <?php
                                    echo($report->admin_response_no == 1 ? '<li>' .t_report('Nessuna risposta', false) . '</li>' : '');
                                    echo($report->admin_response_formal == 1 ? '<li>' .  t_report('Risposte generiche', false) . '</li>' : '');
                                    echo($report->admin_response_some == 1 ? '<li>' .  t_report('Risposta parziale', false) . '</li>' : '');
                                    echo($report->admin_response_promises == 1 ? '<li>' .  t_report('Promesse concrete', false) . '</li>' : '');
                                    echo($report->admin_response_unlocked == 1 ? '<li>' .  t_report('Progetto più efficace', false) . '</li>' : '');
                                    echo($report->admin_response_flagged == 1 ? '<li>' .  t_report('Problema risolto', false) . '</li>' : '');
                                    echo $report->admin_altro  > 0 ? '<li>' . $report->admin_altro . '</li>' : '';
                                    ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>




                        <?php if(!empty($report->impact_description)){ ?>
                        <div class="report-solutions">
                            <h2><?php t_report('Descrizione del caso'); ?></h2>
                            <p><?php echo nl2br( $report->impact_description); ?>
                        </div>
                         <?php } ?>
                        </div>
                <?php } ?>

                <div class="report-section">
                        <h1><?php t_report("Metodo di indagine"); ?></h1>
                        <h2><?php t_report('Come sono state raccolte le informazioni?'); ?></h2>
                        <ul>
                            <?php foreach($raccolta as $label => $v){ ?>
                                <li><?php t_report( $label ); ?></li>
                            <?php } ?>
                        </ul>
                        <p><?php echo nl2br($report->intervista_intervistati); ?></p>

                        <h2><?php t_report('Domande principali'); ?></h2>
                        <p><?php echo nl2br($report->intervista_domande); ?></p>

                        <h2><?php t_report('Risposte principali'); ?></h2>
                        <p><?php echo nl2br($report->intervista_risposte); ?></p>


                </div>

            </div>
            <?php } ?>
    </section>
</div>


