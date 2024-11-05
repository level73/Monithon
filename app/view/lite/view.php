<?php function t_report($str){ echo $str; } ?>
<div class="container-fluid" id="report-page">

    <section class="row">

        <header class="col-md-8 offset-md-3">
            <h1>
                <span class="title-label"><small>REPORT DI MONITORAGGIO CIVICO</small><br /></span><?php echo $report->titolo; ?><br />

            </h1>
            <span class="report-date"><?php t_report('Inviato il'); ?> <?php  echo strftime('%e/%m/%Y', strtotime($report->created_at)); ?> | <?php t_report('di'); ?> <a href="/profile/view/<?php echo $author->idauth; ?>"><?php echo  $author->username; //$author->username; ?></a>
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


                <h4><?php t_report('GIUDIZIO DI EFFICACIA'); ?></h4>

                <div class="row">
                    <div class="col">
                        <span class=" giudizio-sintetico <?php echo 'gde_'.$report->giudizio_sintetico; ?>"><?php t_report(generateGDELabel($report->giudizio_sintetico, $report->stato_di_avanzamento, 'main', false)); ?></span>
                        <span class="gde_sub_label  <?php echo 'gde_sub_'.$report->giudizio_sintetico; ?>"><?php t_report(generateGDELabel($report->giudizio_sintetico, $report->stato_di_avanzamento, 'sub',false)); ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col">

                        <span class="sda_title"><?php t_report('Stato di Avanzamento al Monitoraggio'); ?></span>

                        <span class="sda_label"><?php t_report(SDA_LABELS[$report->stato_di_avanzamento]); ?></span>
                    </div>

                </div>

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
                <div class="report-section">
                    <h1><?php t_report('Cosa abbiamo scoperto'); ?></h1>
                    <?php if(!empty($report->obiettivi_del_progetto)): ?>
                        <h2><?php t_report('Obiettivi del Progetto'); ?> <span class="float-right"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></span></h2>
                        <p><?php echo nl2br($report->obiettivi_del_progetto); ?></p>
                    <?php endif; ?>
                    <?php if(!empty($report->giudizio)){ ?>
                        <h2><?php t_report('Giudizio'); ?> </h2>
                        <p>
                            <img class="report-main-image" src="<?php echo image($images[0]); ?>" alt="">
                            <?php echo nl2br($report->giudizio); ?>
                        </p>
                    <?php } ?>
                    <?php if(!empty($report->origine)){ ?>
                        <h2><?php t_report('Origine del progetto'); ?></h2>
                        <p> <?php echo nl2br($report->origine); ?></p>
                    <?php } ?>
                    <div class="row">
                        <div class="col">
                            <h2><?php t_report('Punti di debolezza'); ?></h2>
                            <p><?php echo nl2br($report->punti_di_debolezza); ?></p>
                        </div>
                        <div class="col">
                            <h2><?php t_report('Punti di forza'); ?></h2>
                            <p><?php echo nl2br($report->punti_di_forza); ?></p>
                        </div>
                    </div>
                    <h2><?php t_report('Suggerimenti'); ?></h2>
                    <p><?php echo nl2br($report->suggerimenti); ?></p>
                </div>


                <?php if($report->status_impact == PUBLISHED): ?>
                <h1><?php t_report('Impatto & Risultati'); ?></h1>
                <div class="row">
                    <?php if(   checkDiffusione($report) ): ?>
                        <div class="col-md-6">
                        <h2><?php t_report('Diffusione'); ?></h2>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_twitter == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Twitter</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_facebook == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Facebook</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_instagram == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Instagram</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_eventi == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Eventi territoriali organizzati dai team</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_open_admin == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Settimana dell'Amministrazione Aperta</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_blog == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Blog/Sito web del Team</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_offline == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Volantinaggio o altri metodi off-line (non via Internet)</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_incontri == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Richiesta di audizioni o incontri a porte chiuse</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->diffusione_interviste == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Interviste ai media</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if(!empty($report->diffusione_altro)): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Altro: <?php echo $report->diffusione_altro; ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($report->connections)): ?>
                    <div class="col-md-6">
                        <h2>Connessioni</h2>
                        <?php foreach($report->connections as $connection): ?>
                        <div class="connection">
                            <div class="connection-details">
                                <div class="connection-type"><?php echo $connection->connection_type; ?></div>
                                <div class="subject"><?php echo $connection->subject . ' (' . $connection->role . ')' . ' - ' . $connection->organisation; ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if($report->media_connection == 1): ?>
                    <div class="col-md-6">
                        <h2>Copertura dei Media</h2>
                        <div class="checker">
                            <div class="checker-flag <?php if($report->tv_locali == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">TV Locali</div>
                        </div>
                        <div class="checker">
                            <div class="checker-flag <?php if($report->tv_nazionali == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">TV Nazionali</div>
                        </div>
                        <div class="checker">
                            <div class="checker-flag <?php if($report->giornali_locali == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Giornali Locali</div>
                        </div>
                        <div class="checker">
                            <div class="checker-flag <?php if($report->giornali_nazionali == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Giornali Nazionali</div>
                        </div>
                        <div class="checker">
                            <div class="checker-flag <?php if($report->blog_online == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Blog o altre news outlet online</div>
                        </div>
                        <div class="checker">
                            <div class="checker-flag <?php if($report->media_other == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Altro</div>
                        </div>
                    </div>

                    <?php endif; ?>


                    <?php if($report->admin_connection == 1): ?>
                        <div class="col-md-6">
                            <h2>Risposte dalla Pubblica Amministrazione</h2>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->admin_no == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Non ci hanno risposto</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->admin_response_some == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Abbiamo ottenuto solo risposte parziali</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->admin_response_formal == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Ci hanno dato solo risposte formali o generiche</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->admin_response_promises == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Almeno una tra quelle contattate ci ha fatto promesse concrete</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->admin_response_unlocked == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Hanno messo in pratica i nostri suggerimenti e il progetto ora è "sbloccato" o piùù efficace</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if($report->admin_response_flagged == 1): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Avevamo segnalato un problema che ora è stato risolto</div>
                            </div>
                            <div class="checker">
                                <div class="checker-flag <?php if(!empty($report->admin_altro)): echo "checker-flag-active"; endif; ?>"></div> <div class="checker-label">Altro: <?php echo $report->admin_altro; ?></div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if(!empty($report->impact_description)): ?>
                    <div class="col-md-12">
                        <h2>Descrizione dell'impatto del monitoraggio</h2>
                        <?php echo $report->impact_description; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php endif; ?>
            </div>

        </section>



</div>


