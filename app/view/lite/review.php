<div class="container">
    <div class="row">
        <div class="col">
            <h1>Revisiona il Report<br /><small><?php echo $data->titolo; ?></small>
            </h1>

            <form class="  edit-lite-report" method="post" enctype="multipart/form-data" action="/lite/review/<?php echo $data->idreport_lite; ?>">
                <input type="hidden" name="id" value="<?php echo $data->idreport_lite; ?>">

                <fieldset>
                    <legend><span>DATI SUL PROGETTO</span></legend>

                    <div class="form-group">
                        <label for="oc_api_code">URL del progetto monitorato:</label>
                        <small class="form-text text-muted">Per agganciare i dati aperti del progetto, incolla qui l'indirizzo (URL) della pagina di OpenCoesione dedicata al singolo progetto che hai scelto di monitorare. Esempio: https://opencoesione.gov.it/it/progetti/1ca1c272007it161po009/</small>
                        <small class="form-text text-muted">Se il progetto che vuoi monitorare non è su OpenCoesione, inserisci il link della pagina di progetto (se disponibile). Ad esempio, OpenCUP. <br /></small>
                        <div class="input-group">
                            <?php
                            if(isset($pfurl)){
                                if(isset($ref) && $ref == 's24'){
                                    ?>
                                    <input type="text" name="project_url" id="opencup" placeholder="URL del progetto scelto..." class="form-control pfurl" value="https://opencup.gov.it/portale/progetto/-/cup/<?php echo $pfurl; ?>">
                                    <?php
                                } else {
                                    ?>
                                    <input type="text" name="project_url" id="oc_api_code" placeholder="URL del progetto scelto..." class="form-control pfurl" value="<?php echo $pfurl; ?>">
                                    <?php
                                }
                            } else {
                                ?>
                                <input type="text" name="project_url" id="oc_api_code" placeholder="URL del progetto scelto..." class="form-control" value="<?php echo ckv_object($data, 'project_url'); ?>">
                            <?php } ?>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="oc_api_code_lookup" type="button"><i class="fal fa-search"></i></button>
                            </div>
                            <input type="hidden" name="api_data" id="api_data" value="">
                            <input type="hidden" name="project_code" id="project_code" value="">
                        </div>
                        <div class="d-none lite-report" id="oc_api_content">
                            <i class="fal fa-sync fa-spin" id="oc-api-spinner"></i>
                            <h2 id="oc_api_project_title"></h2>
                            <p id="oc_api_project_synth"></p>
                            <h3>Beneficiari</h3>
                            <ul id="oc_api_project_beneficiaries"></ul>
                        </div>

                    </div>
                </fieldset>
                <fieldset>
                    <legend>Il Titolo del Progetto</legend>
                    <div class="form-group">
                        <label for="titolo">Titolo del progetto:</label>
                        <div class="input-group">
                            <input type="text" name="titolo" class="form-control" id="titolo" value="<?php echo ckv_object($data, 'titolo'); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary comment" data-field="titolo" id="comment[titolo]" type="button"><i class="fal fa-comment"></i></button>
                            </div>
                        </div>
                        <?php showComment($comments, 'titolo'); ?>
                    </div>
                </fieldset>
                <fieldset>
                    <legend><span>La Posizione del Progetto</span></legend>

                    <!-- Mappa -->
                    <div class="form-group">
                        <label for="indirizzo">Luogo di riferimento del progetto monitorato:</label>
                        <small class="form-text text-muted">Ingrandisci la mappa per trovare con precisione il luogo in cui si svolge il progetto. Clicca sulla mappa per posizionare il marker (freccetta) e spostalo se necessario.</small>
                        <br />
                        <div class="input-group">
                            <input type="text" name="indirizzo" id="indirizzo" placeholder="Indirizzo..." class="form-control" value="<?php echo ckv_object($data, 'indirizzo'); ?>">
                            <input type="text" name="cap" id="cap" placeholder="CAP..." class="form-control"  value="<?php echo ckv_object($data, 'cap'); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="indirizzo_lookup" type="button"><i class="fal fa-search"></i></button>
                            </div>
                        </div>

                        <div id="location_map"></div>
                        <div class="input-group">
                            <input name="lat_" id="lat" class="form-control" readonly placeholder="Latitudine..." value="<?php echo ckv_object($data, 'lat_'); ?>">
                            <input name="lon_" id="lon" class="form-control" readonly placeholder="Longitudine..." value="<?php echo ckv_object($data, 'lon_'); ?>">
                        </div>
                    </div>
                    <!-- Fine Mappa -->

                </fieldset>

                <fieldset>
                    <legend><span>Le Tue Osservazioni</span></legend>
                    <div class="form-group">
                        <label for="obiettivi_del_progetto">Obiettivi del progetto monitorato:</label>
                        <div class="input-group">
                            <textarea name="obiettivi_del_progetto" class="form-control" rows="8" id="obiettivi_del_progetto"><?php echo ckv_object($data, 'obiettivi_del_progetto'); ?></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-primary comment" data-field="obiettivi_del_progetto" id="comment[obiettivi_del_progetto]" type="button"><i class="fal fa-comment"></i></button>
                            </div>
                        </div>
                        <?php showComment($comments, 'obiettivi_del_progetto'); ?>
                    </div>

                    <div class="form-group">


                        <label>Stato di avanzamento del progetto monitorato:</label>



                        <small class="form-text text-muted">Indipendentemente dalle tempistiche dichiarate, qual è il reale avanzamento del progetto monitorato?</small>
                        <div><div class=""><button class="btn btn-primary comment" data-field="stato_di_avanzamento" id="comment[stato_di_avanzamento]" type="button"><i class="fal fa-comment"></i></button></div></div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_1" name="stato_di_avanzamento" class=" custom-control-input" value="1"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_1">Appena avviato <small>Il progetto è stato appena selezionato o è nelle fasi preliminari di realizzazione (es. progettazione preliminare)</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_2" name="stato_di_avanzamento" class="check-eval custom-control-input " value="2"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 2 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_2">Mai partito <small>Il progetto è stato selezionato da almeno un anno ma non è mai stato avviato e risulta quindi bloccato all’avvio</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_3" name="stato_di_avanzamento" class=" custom-control-input" value="3"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 3 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_3">In corso senza particolari intoppi <small>Il progetto è in corso di realizzazione (es. il cantiere è aperto) e segue le tappe prefissate; i ritardi sono limitati</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_4" name="stato_di_avanzamento" class="check-eval custom-control-input " value="4"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 4 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_4">In corso con problemi di realizzazione <small>Il progetto è in corso di realizzazione ma presenta problemi sostanziali (amministrativi, tecnici, etc.) oppure ritardi significativi</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_5" name="stato_di_avanzamento" class="check-eval custom-control-input " value="5"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 5 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_5">Bloccato <small>Il progetto è fermo da almeno un anno per problemi in fase di realizzazione</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_6" name="stato_di_avanzamento" class=" custom-control-input" value="6" <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 6 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_6">Concluso <small>Tutte le attività sono state completate</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_7" name="stato_di_avanzamento" class=" custom-control-input" value="7" <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 7 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_7">Non è stato possibile verificare l’avanzamento <small>Le informazioni disponibili non sono sufficienti</small></label>
                        </div>

                        <?php showComment($comments, 'stato_di_avanzamento'); ?>
                    </div>


                    <!-- Giudizio Sintetico -->
                    <div class="form-group">
                        <label for="gs">Giudizio di efficacia (anche potenziale) sul progetto monitorato: </label>
                        <small class="form-text form-muted">Come giudichi l’efficacia del progetto monitorato?</small>
                        <div><div class=""><button class="btn btn-primary comment" data-field="giudizio_sintetico" id="comment[giudizio_sintetico]" type="button"><i class="fal fa-comment"></i></button></div></div>

                        <div class="custom-control custom-radio">
                            <input type="radio" id="giudizio_sintetico_1" name="giudizio_sintetico" class="custom-control-input" value="1"  <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label gsl" for="giudizio_sintetico_1"></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="giudizio_sintetico_2" name="giudizio_sintetico" class="custom-control-input check-eval" value="2" <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico == 2 ? 'checked' : ''); ?>>
                            <label class="custom-control-label gsl" for="giudizio_sintetico_2"></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="giudizio_sintetico_3" name="giudizio_sintetico" class="custom-control-input check-eval" value="3" <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico == 3 ? 'checked' : ''); ?>>
                            <label class="custom-control-label gsl" for="giudizio_sintetico_3"></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="giudizio_sintetico_4" name="giudizio_sintetico" class="custom-control-input" value="4" <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico == 4 ? 'checked' : ''); ?>>
                            <label class="custom-control-label gsl" for="giudizio_sintetico_4"></label>
                        </div>
                        <?php showComment($comments, 'giudizio_sintetico'); ?>
                    </div>

                    <!-- EOF Giudizio Sintetico -->

                    <div class="form-group">
                        <label for="giudizio">Giudizio:</label>
                        <div class="input-group">
                            <textarea name="giudizio" class="form-control" rows="8" id="giudizio"><?php echo ckv_object($data, 'giudizio'); ?></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-primary comment" data-field="giudizio" id="comment[giudizio]" type="button"><i class="fal fa-comment"></i></button>
                            </div>
                        </div>
                        <?php showComment($comments, 'giudizio'); ?>
                    </div>

                    <div class="form-group">
                        <label for="punti_di_forza">Punti di forza del progetto monitorato:</label>
                        <div class="input-group">
                        <textarea name="punti_di_forza" class="form-control" rows="8" id="punti_di_forza"><?php echo ckv_object($data, 'punti_di_forza'); ?></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary comment" data-field="punti_di_forza" id="comment[punti_di_forza]" type="button"><i class="fal fa-comment"></i></button>
                        </div>
                    </div>
                        <?php showComment($comments, 'punti_di_forza'); ?>
                    </div>

                    <div class="form-group">
                        <label for="punti_di_debolezza">Punti di debolezza del progetto monitorato:</label>
                        <div class="input-group">
                        <textarea name="punti_di_debolezza" class="form-control" rows="8" id="punti_di_debolezza"><?php echo ckv_object($data, 'punti_di_debolezza'); ?></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary comment" data-field="punti_di_debolezza" id="comment[punti_di_debolezza]" type="button"><i class="fal fa-comment"></i></button>
                        </div>
                    </div>
                        <?php showComment($comments, 'punti_di_debolezza'); ?>
                    </div>

                    <div class="form-group">
                        <label for="suggerimenti">Soluzioni e idee da proporre per il progetto monitorato:</label>
                        <div class="input-group">
                        <textarea name="suggerimenti" class="form-control" rows="8" id="suggerimenti"><?php echo ckv_object($data, 'suggerimenti'); ?></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary comment" data-field="suggerimenti" id="comment[suggerimenti]" type="button"><i class="fal fa-comment"></i></button>
                        </div>
                    </div>
                        <?php showComment($comments, 'suggerimenti'); ?>
                    </div>
                </fieldset>

                <fieldset>
                    <legend><span>Link, Video, Allegati</span></legend>
                    <div class="alert alert-info" role="alert"><i class="fas fa-exclamation-triangle"></i> <strong>Il peso complessivo dei file che si vogliono caricare non deve eccedere gli 8mb per invio.</strong></div>
                    <small class="form-text">Aggiungi almeno un’immagine per la copertina del report. Inserisci le foto che hai fatto durante la visita di monitoraggio o durante le interviste, o qualunque altra immagine che documenti il tuo monitoraggio civico.</small>
                    <small class="form-text">Se hai somministrato un questionario, carica, in formato PDF, i principali risultati dell’indagine che hai realizzato, con il dettaglio delle risposte ottenute e un tuo commento.</small>
                    <small class="form-text">Se hai fatto interviste, inserisci, in formato PDF, una sintesi più estesa delle domande e delle risposte.</small>
                    <small class="form-text">Attenzione: Il peso complessivo dei file che si vogliono caricare non deve eccedere gli 8mb ogni volta in cui si salva.</small>

                    <div class="form-group">
                        <div class="input-group-append">
                            <button class="btn btn-primary comment" data-field="attachments" id="comment[attachments]" type="button"><i class="fal fa-comment"></i></button>
                        </div>
                        <label>Carica immagini o documenti<br /><small><i class="fas fa-exclamation-triangle"></i> Sono ammessi solo immagini (jpg, gif, png) o file documentali (doc, docx, xls, xlsx, pdf)</small></label>
                        <div class="custom-file file-grouper origin">
                            <input type="file" class="custom-file-input" id="file-attachment[0]" name="file-attachment[0]">
                            <label class="custom-file-label" for="file-attachment[0]">Scegli il file da caricare...</label>
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm file-duplicator" data-duplicate=".file-grouper"><i class="fal fa-plus"></i> Aggiungi altri allegati</button>
                    </div>
                    <div class="files">
                        <h3>Risorse Caricate</h3>
                        <?php foreach($data->files as $file){ ?>
                            <div class="file">
                                <?php if(typeOfFile($file->info) == 'image'){ ?>
                                    <img src="/public/resources/<?php echo $file->file_path;?>" class="img-fluid">
                                <?php } elseif(typeOfFile($file->info) == 'spreadsheet'){  ?>
                                    <a href="/public/resources/<?php echo $file->file_path;?>" class="text-center align-middle"><i class="fal fa-file-spreadsheet fa-8x"></i></a>
                                <?php } elseif(typeOfFile($file->info) == 'document'){  ?>
                                    <a href="/public/resources/<?php echo $file->file_path;?>" class="text-center align-middle"><i class="fal fa-file-word fa-8x"></i></a>
                                <?php } elseif(typeOfFile($file->info) == 'pdf'){  ?>
                                    <a href="/public/resources/<?php echo $file->file_path;?>" class="text-center align-middle"><i class="fal fa-file-pdf fa-8x"></i></a>
                                <?php } ?>
                                <button class="btn btn-sm btn-block btn-danger ajx-delete-repo" type="button" data-type="file" data-id="<?php echo $file->idfile_repository; ?>"><i class="fal fa-trash-alt"></i> Rimuovi Risorsa</button>
                            </div>

                        <?php } ?>
                    </div>


                    <div class="form-group">
                        <label>Aggiungi link alla documentazione ed alle fonti</label>
                        <small class="form-text text-muted">Inserisci il link agli articoli, ai siti web o ai documenti che hai consultato.</small>
                        <div class="link-grouper origin">
                            <input type="text" class="form-control" id="link-attachment[0]" name="link-attachment[0]" placeholder="Inserisci URL della fonte...">
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm link-duplicator" data-duplicate=".link-grouper"><i class="fal fa-plus"></i> Aggiungi altri link alle fonti</button>
                    </div>
                    <div class="files">
                        <h3>Link Caricati</h3>
                        <ul class="links">
                            <?php foreach($data->links as $l){ ?>
                                <li><a href="<?php echo $l->URL; ?>"><?php echo $l->URL; ?></a> <button class="btn btn-sm btn-danger ajx-delete-repo" type="button" data-type="link" data-id="<?php echo $l->idlink_repository; ?>"><i class="fal fa-trash-alt"></i></button></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label>Aggiungi link a Video (YouTube o Vimeo)</label>
                        <small class="form-text text-muted">Carica i video della visita o delle interviste su YouTube o Vimeo e inserisci qui il link al video pubblicato. Non inserire link a video su Facebook, Instagram o altro: non saranno visualizzati.</small>
                        <div class="video-grouper origin">
                            <input type="text" class="form-control" id="video-attachment[0]" name="video-attachment[0]" placeholder="Inserisci URL del video...">
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm video-duplicator" data-duplicate=".video-grouper"><i class="fal fa-plus"></i> Aggiungi altri link a video</button>
                    </div>
                    <div class="files">
                        <h3>Video Caricati</h3>
                        <?php foreach($data->videos as $v){ ?>
                            <div class="video">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="<?php echo $v->embed; ?>" allowfullscreen></iframe>
                                </div>
                                <button class="btn btn-sm btn-block btn-danger ajx-delete-repo" type="button" data-type="video" data-id="<?php echo $v->idvideo_repository; ?>"><i class="fal fa-trash-alt"></i> Rimuovi Video</button>
                            </div>
                        <?php } ?>
                        </ul>
                    </div>
                    <?php showComment($comments, 'attachments'); ?>
                </fieldset>


                <!-- STEP 3 Placeholder -->
                <h2>Impatto & Risultati</h2>
                <fieldset>
                    <legend><span>Le nuove connessioni che hai generato</span></legend>
                    <div class="form-group">
                        <label for="nuove-connessioni">Come hai diffuso o stai diffondendo i risultati del vostro monitoraggio civico?</label>
                        <div><div class=""><button class="btn btn-primary comment" data-field="diffusione" id="comment[diffusione]" type="button"><i class="fal fa-comment"></i></button></div></div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_twitter" name="diffusione_twitter" <?php echo (isset($data->diffusione_twitter) && $data->diffusione_twitter == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_twitter">Twitter</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_facebook" name="diffusione_facebook" <?php echo (isset($data->diffusione_facebook) && $data->diffusione_facebook == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_facebook">Facebook</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_instagram" name="diffusione_instagram" <?php echo (isset($data->diffusione_instagram) && $data->diffusione_instagram == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_instagram">Instagram</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_eventi" name="diffusione_eventi" <?php echo (isset($data->diffusione_eventi) && $data->diffusione_eventi == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_eventi">Eventi territoriali organizzati dai team</label>
                        </div>


                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_open_admin" name="diffusione_open_admin" <?php echo (isset($data->diffusione_open_admin) && $data->diffusione_open_admin == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_open_admin">Settimana dell'Amministrazione Aperta</label>
                        </div>


                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_blog" name="diffusione_blog" <?php echo (isset($data->diffusione_blog) && $data->diffusione_blog == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_blog">Blog/Sito web del Team</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_offline" name="diffusione_offline" <?php echo (isset($data->diffusione_offline) && $data->diffusione_offline == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_offline">Volantinaggio o altri metodi off-line (non via Internet)</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_incontri" name="diffusione_incontri" <?php echo (isset($data->diffusione_incontri) && $data->diffusione_incontri == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_incontri">Richiesta di audizioni o incontri a porte chiuse</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="diffusione_interviste" name="diffusione_interviste" <?php echo (isset($data->diffusione_interviste) && $data->diffusione_interviste == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="diffusione_interviste">Interviste ai media</label>
                        </div>
                        <div class="form-group">
                            <label class="" for="diffusione_altro">Altro</label>
                            <input class="form-control" type="text" id="diffusione_altro" name="diffusione_altro" value="<?php echo ckv_object($data, 'diffusione_altro'); ?>">

                        </div>

                        <?php showComment($comments, 'diffusione'); ?>
                    </div>

                    <div class="form-group">
                        <label>Con quali soggetti hai creato delle connessioni per discutere dei risultati del vostro monitoraggio?</label>
                        <div><div class=""><button class="btn btn-primary comment" data-field="connessioni" id="comment[connessioni]" type="button"><i class="fal fa-comment"></i></button></div></div>
                        <small class="text-muted form-text">
                            <strong>RUOLO:</strong> Elenca i soggetti con cui hai avuto dei contatti per diffondere o discutere i risultati del tuo monitoraggio.
                            Ad esempio: Sindaco, Presidente, Funzionario pubblico, giornalista, amministratore delegato di azienda, etc.<br /><br />

                            <strong>ORGANIZZAZIONE:</strong> Ad esempio: Città di Roma, Provincia di Chieti, Regione Calabria, Il Corriere della Sera, Buitoni, etc.

                        </small>

                        <table id="subjects-table">
                            <thead>
                            <tr>
                                <th width="25%">SOGGETTO</th>
                                <th width="25%">RUOLO</th>
                                <th width="25%">ORGANIZZAZIONE</th>
                                <th width="25%">TIPO DI CONNESSIONE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="connection-0">
                                <td><input type="text" name="connection[0][subject]" placeholder="Soggetto..." class="form-control c-subject"></td>
                                <td><input type="text" name="connection[0][role]" placeholder="Ruolo..." class="form-control c-role"></td>
                                <td><input type="text" name="connection[0][organisation]" placeholder="Organizzazione..." class="form-control c-org"></td>
                                <td>
                                    <select name="connection[0][connection_type]" id="connection[0][connection_type]" class="form-control c-type">
                                        <option></option>
                                        <?php foreach($connection_type as $c){ ?>
                                            <option value="<?php echo $c->idconnection_type; ?>"><?php echo $c->connection_type; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            </tbody>

                        </table>
                        <button type="button" class="btn btn-primary" id="subject-button-add"><i class="fal fa-plus"></i> AGGIUNGI SOGGETTO</button>
                        <?php showComment($comments, 'connessioni'); ?>
                    </div>
                    <div class="form-group">
                        <label>I media hanno parlato del tuo monitoraggio?</label>
                        <div><div class=""><button class="btn btn-primary comment" data-field="media" id="comment[media]" type="button"><i class="fal fa-comment"></i></button></div></div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="media_connection_yes" name="media_connection" class="custom-control-input" value="1"  <?php echo (isset($data->media_connection) && $data->media_connection == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="media_connection_yes">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="media_connection_no" name="media_connection" class="custom-control-input" value="0"  <?php echo (isset($data->media_connection) && $data->media_connection == 0 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="media_connection_no">No</label>
                        </div>
                        <?php showComment($comments, 'media'); ?>
                    </div>


                    <div class="form-group">
                        <label>Se sì, i risultati del monitoraggio sono stati ripresi dai seguenti media:</label>
                        <div><div class=""><button class="btn btn-primary comment" data-field="media_types" id="comment[media_types]" type="button"><i class="fal fa-comment"></i></button></div></div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="tv_locali" name="tv_locali" <?php echo (isset($data->tv_locali) && $data->tv_locali == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="tv_locali">TV Locali</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="tv_nazionali" name="tv_nazionali" <?php echo (isset($data->tv_nazionali) && $data->tv_nazionali == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="tv_nazionali">TV Nazionali</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="giornali_locali" name="giornali_locali" <?php echo (isset($data->giornali_locali) && $data->giornali_locali == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="giornali_locali">Giornali Locali</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="giornali_nazionali" name="giornali_nazionali" <?php echo (isset($data->giornali_nazionali) && $data->giornali_nazionali == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="giornali_nazionali">Giornali Nazionali</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="blog_online" name="blog_online" <?php echo (isset($data->blog_online) && $data->blog_online == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="blog_online">Blog o altre news outlet online</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="media_other" name="media_other" <?php echo (isset($data->media_other) && $data->media_other == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="media_other">Altro</label>
                        </div>
                        <?php showComment($comments, 'media_types'); ?>
                    </div>

                    <div class="form-group">
                        <label>Dopo aver svolto la ricerca di monitoraggio, hai provato a contattare le Amministrazioni responsabili per presentare o discutere con loro i risultati del tuo monitoraggio?                    </label>
                        <div><div class=""><button class="btn btn-primary comment" data-field="admin_connection" id="comment[admin_connection]" type="button"><i class="fal fa-comment"></i></button></div></div>
                        <small class="form-text text-muted">Non sono da considerare le interviste allo scopo solamente di raccogliere informazioni sul progetto.</small>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="admin_connection_yes" name="admin_connection" class="custom-control-input" value="1"  <?php echo (isset($data->admin_connection) && $data->admin_connection == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_connection_yes">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="admin_connection_no" name="admin_connection" class="custom-control-input" value="0"  <?php echo (isset($data->admin_connection) && $data->admin_connection == 0 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_connection_no">No</label>
                        </div>
                        <?php showComment($comments, 'admin_connection'); ?>
                    </div>

                    <div class="form-group">
                        <label>In che modo le Pubbliche Amministrazioni hanno risposto alle tue sollecitazioni o ai problemi che hai sollevato?</label>
                        <div><div class=""><button class="btn btn-primary comment" data-field="admin" id="comment[admin]" type="button"><i class="fal fa-comment"></i></button></div></div>
                        <small class="form-text text-muted">Non sono da considerare le interviste allo scopo solamente di raccogliere informazioni sul progetto.</small>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="admin_response_no" name="admin_response_no" <?php echo (isset($data->admin_response_no) && $data->admin_response_no == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_response_no">Non ci hanno risposto</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="admin_response_some" name="admin_response_some" <?php echo (isset($data->admin_response_some) && $data->admin_response_some == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_response_some">Abbiamo ottenuto solo risposte parziali</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="admin_response_formal" name="admin_response_formal" <?php echo (isset($data->admin_response_formal) && $data->admin_response_formal == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_response_formal">Ci hanno dato risposte formali o generiche</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="admin_response_promises" name="admin_response_promises" <?php echo (isset($data->admin_response_promises) && $data->admin_response_promises == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_response_promises">Almeno una tra quelle contattate ci ha fatto promesse concrete</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="admin_response_unlocked" name="admin_response_unlocked" <?php echo (isset($data->admin_response_unlocked) && $data->admin_response_unlocked == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_response_unlocked">Hanno messo in pratica i nostri suggerimenti e il progetto ora è "sbloccato" o più efficace</label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="1" id="admin_response_flagged" name="admin_response_flagged" <?php echo (isset($data->admin_response_flagged) && $data->admin_response_flagged == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="admin_response_flagged">Avevamo segnalato un problema che ora è stato risolto</label>
                        </div>

                        <div class="form-group">
                            <label class="" for="admin_altro">Altro</label>
                            <input class="form-control" type="text" id="admin_altro" name="admin_altro" value="<?php echo ckv_object($data, 'admin_altro'); ?>">

                        </div>
                        <?php showComment($comments, 'admin'); ?>
                    </div>

                    <div class="form-group">
                        <label for="impact_description">Descrivici il tuo caso. Quali fatti o episodi concreti ti portano a pensare che il tuo monitoraggio civico abbia avuto (o non abbia avuto) impatto tra i soggetti che gestiscono o attuano il progetto che hai monitorato?</label>
                        <div><div class=""><button class="btn btn-primary comment" data-field="impact_description" id="comment[impact_description]" type="button"><i class="fal fa-comment"></i></button></div></div>

                        <textarea name="impact_description" id="impact_description" class="form-control"><?php echo ckv_object($data, 'impact_description'); ?></textarea>
                        <?php showComment($comments, 'impact_description'); ?>
                    </div>

                </fieldset>

                <div class="">
                    <h3>IMPOSTA LO STATO DEL REPORT</h3>
                    <input type="hidden" name="current_status" value="<?php echo $data->status; ?>">
                    <input type="hidden" name="created_by" value="<?php echo $data->created_by; ?>">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="<?php echo DRAFT; ?>" id="status-1" name="status" <?php echo ($data->status == DRAFT ? 'checked' : ""); ?>>
                            <label class="custom-control-label" for="status-1">Riporta il report in <strong>BOZZA</strong>, per permettere ai reporter di modificarlo</label>
                        </div>

                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="<?php echo PENDING_REVIEW; ?>" id="status-3" name="status" <?php echo ($data->status == PENDING_REVIEW ? 'checked' : ""); ?>>
                            <label class="custom-control-label" for="status-3">Riporta il report in <strong>ATTESA DI REVISIONE</strong></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="<?php echo IN_REVIEW; ?>" id="status-5" name="status" <?php echo ($data->status == IN_REVIEW ? 'checked' : ""); ?>>
                            <label class="custom-control-label" for="status-5">Mantieni il report <strong>IN REVISIONE</strong></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="<?php echo PUBLISHED; ?>" id="status-7" name="status" <?php echo ($data->status == PUBLISHED ? 'checked' : ""); ?>>
                            <label class="custom-control-label" for="status-7">Imposta il report come <strong>APPROVATO</strong> </label>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" value="<?php echo PUBLISHED; ?>" id="status_impact" name="status_impact" <?php echo ($data->status_impact == PUBLISHED ? 'checked' : ""); ?>>
                            <label class="custom-control-label" for="status_impact">Pubblica <strong>ANCHE L'IMPATTO</strong> del Report</label>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg" type="submit" ><i class="fal fa-save"></i> Salva Report</button>
                </div>

            </form>

        </div>
    </div>
</div>