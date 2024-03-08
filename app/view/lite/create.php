<div class="container">
    <div class="row">
        <div class="col">
            <h1>Nuovo Report
                <a class="btn btn-primary float-right" target="_blank" href="https://www.monithon.eu/blog/2024/03/07/guida-al-monitoraggio-civico-semplificato/"><i class="fas fa-info-square"></i> GUIDA ALLA COMPILAZIONE</a>
            </h1>

            <form class="" method="post" enctype="multipart/form-data" action="/lite/create">
                <fieldset>
                    <legend>DATI SUL PROGETTO</legend>

                    <div class="form-group">
                        <label for="oc_api_code">URL del progetto monitorato:</label>
                        <small class="form-text text-muted">Per agganciare i dati aperti del progetto, incolla qui l'indirizzo (URL) della pagina di OpenCoesione dedicata al singolo progetto che hai scelto di monitorare. Esempio: https://opencoesione.gov.it/it/progetti/1ca1c272007it161po009/</small>
                        <small class="form-text text-muted">Se il progetto che vuoi monitorare non è su OpenCoesione, inserisci il link della pagina di progetto (se disponibile). Ad esempio, OpenCUP. <br /></small>
                        <div class="input-group">
                            <?php
                            if(isset($pfurl)){
                                if(isset($ref) && $ref == 's24'){
                                    ?>
                                    <input type="text" name="project_url" id="opencup" placeholder="URL del progetto scelto..." class="form-control pfurl apicall" value="https://opencup.gov.it/portale/progetto/-/cup/<?php echo $pfurl; ?>">
                                    <?php
                                } else {
                                    ?>
                                    <input type="text" name="project_url" id="oc_api_code" placeholder="URL del progetto scelto..." class="form-control pfurl apicall" value="<?php echo $pfurl; ?>">
                                    <?php
                                }
                            } else {
                                ?>
                                <input type="text" name="project_url" id="oc_api_code" placeholder="URL del progetto scelto..." class="form-control apicall" value="<?php echo ckv($data, 'project_url'); ?>">
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
                        <input type="text" name="titolo" class="form-control" id="titolo"><?php echo ckv($data, 'titolo'); ?></input>
                    </div>
                    <?php if($user->role !== 13): ?>
                        <div class="form-group">
                            <label for="referrer_motivazione">Come sei venuto a conoscenza del progetto e perché ti interessa?</label>
                            <textarea name="referrer_motivazione" class="form-control" rows="8" id="referrer_motivazione"><?php echo ckv($data, 'referrer_motivazione'); ?></textarea>
                        </div>
                    <?php endif; ?>
                </fieldset>
                <fieldset>
                    <legend>La Posizione del Progetto</legend>

                    <!-- Mappa -->
                    <div class="form-group">
                        <label for="indirizzo">Luogo di riferimento del progetto monitorato:</label>
                        <small class="form-text text-muted">Ingrandisci la mappa per trovare con precisione il luogo in cui si svolge il progetto. Clicca sulla mappa per posizionare il marker (freccetta) e spostalo se necessario.</small>
                        <br />
                        <div class="input-group">
                            <input type="text" name="indirizzo" id="indirizzo" placeholder="Indirizzo..." class="form-control" value="<?php echo ckv($data, 'indirizzo'); ?>">
                            <input type="text" name="cap" id="cap" placeholder="CAP..." class="form-control"  value="<?php echo ckv($data, 'cap'); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="indirizzo_lookup" type="button"><i class="fal fa-search"></i></button>
                            </div>
                        </div>

                        <div id="location_map"></div>
                        <div class="input-group">
                            <input name="lat_" id="lat" class="form-control" readonly placeholder="Latitudine..." value="<?php echo ckv($data, 'lat_'); ?>">
                            <input name="lon_" id="lon" class="form-control" readonly placeholder="Longitudine..." value="<?php echo ckv($data, 'lon_'); ?>">
                        </div>
                    </div>
                    <!-- Fine Mappa -->

                </fieldset>

                <fieldset>
                    <legend>Le Tue Osservazioni</legend>
                    <?php if($user->role == 13): ?>
                    <div class="form-group">
                        <label for="obiettivi_del_progetto">Obiettivi del progetto monitorato:</label>
                        <textarea name="obiettivi_del_progetto" class="form-control" rows="8" id="q1"><?php echo ckv($data, 'obiettivi_del_progetto'); ?></textarea>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Stato di avanzamento del progetto monitorato:</label>
                        <small class="form-text text-muted">Indipendentemente dalle tempistiche dichiarate, qual è il reale avanzamento del progetto monitorato?</small>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_1" name="stato_di_avanzamento" class=" custom-control-input" value="1"  <?php echo (isset($data['stato_di_avanzamento']) && $data['stato_di_avanzamento'] == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_1">Appena avviato <small>Il progetto è stato appena selezionato o è nelle fasi preliminari di realizzazione (es. progettazione preliminare)</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_2" name="stato_di_avanzamento" class="check-eval custom-control-input " value="2"  <?php echo (isset($data['stato_di_avanzamento']) && $data['stato_di_avanzamento'] == 2 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_2">Mai partito <small>Il progetto è stato selezionato da almeno un anno ma non è mai stato avviato e risulta quindi bloccato all’avvio</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_3" name="stato_di_avanzamento" class=" custom-control-input" value="3"  <?php echo (isset($data['stato_di_avanzamento']) && $data['stato_di_avanzamento'] == 3 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_3">In corso senza particolari intoppi <small>Il progetto è in corso di realizzazione (es. il cantiere è aperto) e segue le tappe prefissate; i ritardi sono limitati</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_4" name="stato_di_avanzamento" class="check-eval custom-control-input " value="4"  <?php echo (isset($data['stato_di_avanzamento']) && $data['stato_di_avanzamento'] == 4 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_4">In corso con problemi di realizzazione <small>Il progetto è in corso di realizzazione ma presenta problemi sostanziali (amministrativi, tecnici, etc.) oppure ritardi significativi</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_5" name="stato_di_avanzamento" class="check-eval custom-control-input " value="5"  <?php echo (isset($data['stato_di_avanzamento']) && $data['stato_di_avanzamento'] == 5 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_5">Bloccato <small>Il progetto è fermo da almeno un anno per problemi in fase di realizzazione</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_6" name="stato_di_avanzamento" class=" custom-control-input" value="6"  <?php echo (isset($data['stato_di_avanzamento']) && $data['stato_di_avanzamento'] == 6 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_6">Concluso <small>Tutte le attività sono state completate</small></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sda_7" name="stato_di_avanzamento" class=" custom-control-input" value="7"  <?php echo (isset($data['stato_di_avanzamento']) && $data['stato_di_avanzamento'] == 7 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="sda_7">Non è stato possibile verificare l’avanzamento <small>Le informazioni disponibili non sono sufficienti</small></label>
                        </div>


                    </div>


                    <!-- Giudizio Sintetico -->
                    <div class="form-group">
                        <label for="gs">Giudizio di efficacia (anche potenziale) sul progetto monitorato: </label>
                        <small class="form-text form-muted">Come giudichi l’efficacia del progetto monitorato?</small>

                        <div class="custom-control custom-radio">
                            <input type="radio" id="giudizio_sintetico_1" name="giudizio_sintetico" class="custom-control-input" value="1"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label gsl" for="giudizio_sintetico_1"></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="giudizio_sintetico_2" name="giudizio_sintetico" class="custom-control-input check-eval" value="2"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 2 ? 'checked' : ''); ?>>
                            <label class="custom-control-label gsl" for="giudizio_sintetico_2"></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="giudizio_sintetico_3" name="giudizio_sintetico" class="custom-control-input check-eval" value="3"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 3 ? 'checked' : ''); ?>>
                            <label class="custom-control-label gsl" for="giudizio_sintetico_3"></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="giudizio_sintetico_4" name="giudizio_sintetico" class="custom-control-input" value="4"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 4 ? 'checked' : ''); ?>>
                            <label class="custom-control-label gsl" for="giudizio_sintetico_4"></label>
                        </div>

                    </div>

                    <!-- EOF Giudizio Sintetico -->

                    <div class="form-group">
                        <label for="giudizio">Giudizio:</label>
                        <textarea name="giudizio" class="form-control" rows="8" id="giudizio"><?php echo ckv($data, 'giudizio'); ?></textarea>
                    </div>
                    <?php if($user->role == 13): ?>
                    <div class="form-group">
                        <label for="punti_di_forza">Punti di forza del progetto monitorato:</label>
                        <textarea name="punti_di_forza" class="form-control" rows="8" id="punti_di_forza"><?php echo ckv($data, 'punti_di_forza'); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="punti_di_debolezza">Punti di debolezza del progetto monitorato:</label>
                        <textarea name="punti_di_debolezza" class="form-control" rows="8" id="punti_di_debolezza"><?php echo ckv($data, 'punti_di_debolezza'); ?></textarea>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="suggerimenti">Soluzioni e idee da proporre per il progetto monitorato:</label>
                        <textarea name="suggerimenti" class="form-control" rows="8" id="suggerimenti"><?php echo ckv($data, 'suggerimenti'); ?></textarea>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Link, Video, Allegati</legend>
                    <div class="alert alert-info" role="alert"><i class="fas fa-exclamation-triangle"></i> <strong>Il peso complessivo dei file che si vogliono caricare non deve eccedere gli 8mb per invio.</strong></div>
                    <small class="form-text">Aggiungi almeno un’immagine per la copertina del report. Inserisci le foto che hai fatto durante la visita di monitoraggio o durante le interviste, o qualunque altra immagine che documenti il tuo monitoraggio civico.</small>
                    <small class="form-text">Se hai somministrato un questionario, carica, in formato PDF, i principali risultati dell’indagine che hai realizzato, con il dettaglio delle risposte ottenute e un tuo commento.</small>
                    <small class="form-text">Se hai fatto interviste, inserisci, in formato PDF, una sintesi più estesa delle domande e delle risposte.</small>
                    <small class="form-text">Attenzione: Il peso complessivo dei file che si vogliono caricare non deve eccedere gli 8mb ogni volta in cui si salva.</small>

                    <div class="form-group">
                        <label>Carica immagini o documenti<br /><small><i class="fas fa-exclamation-triangle"></i> Sono ammessi solo immagini (jpg, gif, png) o file documentali (doc, docx, xls, xlsx, pdf)</small></label>
                        <div class="custom-file file-grouper origin">
                            <input type="file" class="custom-file-input" id="file-attachment[0]" name="file-attachment[0]">
                            <label class="custom-file-label" for="file-attachment[0]">Scegli il file da caricare...</label>
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm file-duplicator" data-duplicate=".file-grouper"><i class="fal fa-plus"></i> Aggiungi altri allegati</button>
                    </div>

                    <div class="form-group">
                        <label>Aggiungi link alla documentazione ed alle fonti</label>
                        <small class="form-text text-muted">Inserisci il link agli articoli, ai siti web o ai documenti che hai consultato.</small>
                        <div class="link-grouper origin">
                            <input type="text" class="form-control" id="link-attachment[0]" name="link-attachment[0]" placeholder="Inserisci URL della fonte...">
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm link-duplicator" data-duplicate=".link-grouper"><i class="fal fa-plus"></i> Aggiungi altri link alle fonti</button>
                    </div>

                    <div class="form-group">
                        <label>Aggiungi link a Video (YouTube o Vimeo)</label>
                        <small class="form-text text-muted">Carica i video della visita o delle interviste su YouTube o Vimeo e inserisci qui il link al video pubblicato. Non inserire link a video su Facebook, Instagram o altro: non saranno visualizzati.</small>
                        <div class="video-grouper origin">
                            <input type="text" class="form-control" id="video-attachment[0]" name="video-attachment[0]" placeholder="Inserisci URL del video...">
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm video-duplicator" data-duplicate=".video-grouper"><i class="fal fa-plus"></i> Aggiungi altri link a video</button>
                    </div>

                </fieldset>

                <div class="form-group">
                    <div class="alert alert-primary"><i class="fa fa-exclamation-circle"></i> Il tuo report è pronto? Puoi inviarlo alla nostra Redazione! Clicca sulla spunta, salva il report, aspetta alcuni giorni e controlla <strong>l’email che hai usato per registrarti</strong>: riceverai i nostri commenti e le istruzioni per effettuare eventuali correzioni.<br />Se invece vuoi poterlo ancora modificare e controllare, puoi salvarlo in bozza. In questo caso <strong>non</strong> cliccare sulla spunta!</strong></div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="<?php echo PENDING_REVIEW; ?>" id="status" name="status">
                        <label class="custom-control-label" for="status">Si, il mio report è pronto e voglio inviarlo alla Redazione!</label>
                    </div>

                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg" type="submit" ><i class="fal fa-save"></i> Salva Report</button>
                </div>

            </form>

        </div>
    </div>
</div>