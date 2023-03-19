<div class="container">
  <div class="row">
    <div class="col">




        <?php include('_partial/welcome_modal.php'); ?>








      <h1>Nuovo Report
          <a class="btn btn-primary float-right" target="_blank" href="https://www.monithon.it/blog/2020/04/24/come-inviare-il-report-di-monitoraggio-tutti-i-nostri-suggerimenti/"><i class="fas fa-info-square"></i> GUIDA ALLA COMPILAZIONE</a></h1>

      <form class="" method="post" enctype="multipart/form-data" action="/report/create">

      <ul class="nav nav-tabs nav-fill" id="report-tablist" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="step-1-tab" data-toggle="tab" href="#step-1" role="tab" aria-controls="step-1" aria-selected="true">Step 1: Desk Analysis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="step-2-tab" data-toggle="tab" href="#step-2" role="tab" aria-controls="step-2" aria-selected="false">Step 2: Valutazione</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" id="step-3-tab" data-toggle="tab" href="#step-3" role="tab" aria-controls="step-3" aria-selected="false">Step 3: Risultati e Impatto</a>
        </li> -->
      </ul>


      <div class="tab-content" id="report-tab-content">
        <div class="tab-pane fade show active" id="step-1" role="tabpanel" aria-labelledby="step-1">
          <div class="alert alert-danger alert-dismissible"><strong>Attenzione:</strong> Non accedere da più dispositivi contemporaneamente!</div>
            <p>Raccogli tutti i documenti rilevanti sul progetto che hai deciso di monitorare, e descrivi sinteticamente il progetto.</p>
          <fieldset>
              <legend>Informazioni di Base</legend>

              <!-- Codice OpenCoesione -->
              <div class="form-group">
                  <label for="oc_api_code">URL del progetto monitorato su OpenCoesione:</label>
                  <small class="form-text text-muted">Per generare la MoniTutor, incolla qui l'indirizzo (URL) della pagina di OpenCoesione dedicata al singolo progetto che hai scelto di monitorare. Esempio: https://opencoesione.gov.it/it/progetti/1ca1c272007it161po009/</small>
                    <small class="form-text text-muted">Se il progetto che vuoi monitorare non è su OpenCoesione, inserisci il link della pagina di progetto (se disponibile). Ad esempio, OpenCUP. N.B. Questo non genererà la MoniTutor.</small>
                  <!-- <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Incolla qui l\'indirizzo (URL) della pagina di OpenCoesione dedicata al progetto che hai scelto di monitorare. Lo trovi nella barra degli indirizzi del tuo browser. Esempio: https://opencoesione.gov.it/it/progetti/1ca1c272007it161po009/">Che cos'è?</span> -->
                  <div class="input-group">
                      <?php if(isset($pfurl)){ ?>
                      <input type="text" name="id_open_coesione" id="oc_api_code" placeholder="URL del progetto scelto..." class="form-control pfurl" value="<?php echo $pfurl; ?>">
                      <?php } else { ?>
                      <input type="text" name="id_open_coesione" id="oc_api_code" placeholder="URL del progetto scelto..." class="form-control" value="<?php echo ckv($data, 'id_open_coesione'); ?>">
                      <?php } ?>
                      <div class="input-group-append">
                      <button class="btn btn-primary" id="oc_api_code_lookup" type="button"><i class="fal fa-search"></i></button>
                    </div>
                    <input type="hidden" name="api_data" id="oc_data" value="">
                  </div>
                  <div class="d-none" id="oc_api_content_s1">
                    <i class="fal fa-sync fa-spin"></i>
                  </div>

              </div>


              <div class="form-group">
                <label for="titolo">Titolo del progetto monitorato:</label>
                <input type="text" name="titolo" id="titolo" class="form-control" value="<?php echo ckv($data, 'titolo'); ?>">
              </div>
              <div class="form-group">
                <label for="autore">Autore del Report:</label>
                <input type="text" name="autore" id="autore" class="form-control" value="<?php echo ckv($data, 'autore'); ?>">
              </div>

              <?php /*
              <div class="form-group">
                <label for="descrizione">Descrizione del progetto monitorato:</label>
                  <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Descrivere brevemente il progetto che avete scelto di monitorare in modo da attrarre l'attenzione del lettore del vostro report. Spiegate in poche frasi perché è importante monitorarlo, i suoi obiettivi e come intende raggiungerli">Cosa devo fare qui?</span>
                <textarea name="descrizione" id="descrizione" class="form-control"><?php echo ckv($data, 'descrizione'); ?></textarea>
              </div>
              <div class="form-group">
                <label for="parte_di_piano"><?php t('Il progetto fa parte di un piano di interventi più ampio? Se sì, qual è l’obiettivo complessivo di questo piano?'); ?></label>
                <textarea name="parte_di_piano" id="parte_di_piano" class="form-control"><?php echo ckv($data, 'parte_di_piano'); ?></textarea>
              </div>
              */ ?>

              <div class="form-group">
                  <label for="obiettivi">Obiettivi del progetto monitorato:</label>
                  <small class="form-text text-muted">Descrivi brevemente il progetto monitorato. Perché è importante? Quali sono i suoi obiettivi principali? Vedi qui i nostri <a href="https://www.monithon.eu/blog/2021/07/01/come-inviare-il-report-di-monitoraggio-tutti-i-nostri-suggerimenti/" target="_blank">consigli per la scrittura</a>.</small>
                  <textarea name="obiettivi" id="obiettivi" class="form-control"><?php echo ckv($data, 'obiettivi'); ?></textarea>

              </div>

              <div class="form-group">
                  <label for="attivita">Attività previste dal progetto monitorato :</label>
                  <small class="form-text text-muted">Quali sono le specifiche attività previste e quali tempi sono previsti?</small>
                  <textarea name="attivita" id="attivita" class="form-control"><?php echo ckv($data, 'attivita'); ?></textarea>

              </div>

              <div class="form-group">
                  <label for="origine">Origine del progetto monitorato:</label>
                  <small class="form-text text-muted">Quali decisioni pubbliche e procedure amministrative hanno dato origine al progetto (es. quale atto amministrativo? quale bando pubblico)? Quali soggetti sono stati coinvolti nella definizione a monte del progetto e in che modo (es. organizzazione eventi di presentazione, momenti di consultazione pubblica, incontri di coprogettazione, ecc.)? Alcune tipologie di persone impattate dal progetto sono rimaste escluse dalla sua definizione?</small>
                  <textarea name="origine" id="origine" class="form-control"><?php echo ckv($data, 'origine'); ?></textarea>

              </div>

              <div class="form-group">
                  <label for="soggetti_beneficiari">Beneficiari finali del progetto monitorato:</label>
                  <small class="form-text text-muted">Quali soggetti possono trarre un vantaggio dagli esiti del progetto o subirne le conseguenze? Es. cittadinanza in generale, utenti di un servizio, gruppi di persone (donne, giovani, migranti). Alcune tipologie di persone rimangono escluse?</small>
                  <textarea name="soggetti_beneficiari" id="soggetti_beneficiari" class="form-control"><?php echo ckv($data, 'soggetti_beneficiari'); ?></textarea>

              </div>

              <div class="form-group">
                  <label for="contesto">Il contesto in cui opera il progetto monitorato:</label>

                  <small class="form-text text-muted">Descrivi brevemente i bisogni del territorio in cui agisce il progetto e che giustificano il suo finanziamento. Menziona eventuali altri progetti simili o complementari, citando, se presenti, piani o strategie pubbliche locali di cui il progetto fa parte (es. Piano Urbano della Mobilità Sostenibile, Strategia per le Aree Interne, etc.)</small>
                  <textarea name="contesto" id="contesto" class="form-control"><?php echo ckv($data, 'contesto'); ?></textarea>

              </div>

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
          </fieldset>
            <fieldset>
                <div class="alert alert-innerbox">
                    <h3 class="alert-heading">Parità di Genere</h3>
                    <hr />
                    <p>Nel progetto è coinvolta direttamente o indirettamente la parità di genere?</p>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="is_gender_topic_yes" name="is_gender_topic" class="check-eval custom-control-input gender_equality_trigger" data-target=".gender-equality-box" value="1" <?php echo (isset($data['is_gender_topic']) && $data['is_gender_topic'] ==  1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="is_gender_topic_yes">SI</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="is_gender_topic_no" name="is_gender_topic" class="check-eval custom-control-input gender_equality_trigger" data-target=".gender-equality-box" value="0" <?php echo (isset($data['is_gender_topic']) && $data['is_gender_topic'] ==  0 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="is_gender_topic_no">NO</label>
                        </div>
                    </div>
                </div>


            </fieldset>
            <!-- button class="btn btn-outline-primary btn-lg showhide" type="button" id="gender-equality-button" data-target=".gender-equality-box">compila la sezione sulla parità di genere</button> -->
              <fieldset class="gender-equality-box d-none">
                  <h3>Parità di Genere</h3>

                  <div class="form-group">
                      <label for="gender-objectives">Nel progetto è coinvolta direttamente o indirettamente la parità di genere? </label>

                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_objectives_yes_direct" name="gender_objectives" class="trigger-desc check-eval custom-control-input" data-group="go" data-target="#goydd" value="1" <?php echo (isset($data['gender_objectives']) && $data['gender_objectives'] ==  1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_objectives_yes_direct">Si, impatto di genere <em>diretto</em> (ad es. progetti che hanno le donne esplicitamente come destinatarie) </label>
                      </div>
                      <div class="form-group d-none trigger-desc-wrapper" id="goydd">
                          <label>Puoi indicarci questi obiettivi e descriverli brevemente?</label>
                          <textarea id="gender_objectives_yes_direct_desc" name="gender_objectives_yes_direct_desc"  class="form-control"><?php echo ckv($data, 'gender_objectives_yes_direct_desc'); ?></textarea>
                      </div>

                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_objectives_yes_indirect" name="gender_objectives" class="trigger-desc check-eval custom-control-input" data-group="go" data-target="#goyid" value="2" <?php echo (isset($data['gender_objectives']) && $data['gender_objectives'] ==  2 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_objectives_yes_indirect">Si, impatto di genere <em>indiretto</em> (ad es. le spese relative a interventi di sostegno verso persone anziane, non autosufficienti, con disabilità o minori ecc., la cui cura è largamente sostenuta dalle donne)</label>
                      </div>
                      <div class="form-group d-none trigger-desc-wrapper" id="goyid">
                        <label>Puoi indicarci questi obiettivi e descriverli brevemente?</label>
                        <textarea id="gender_objectives_yes_indirect_desc" name="gender_objectives_yes_indirect_desc"  class="form-control"><?php echo ckv($data, 'gender_objectives_yes_indirect_desc'); ?></textarea>
                      </div>


                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_objectives_no" name="gender_objectives" class="trigger-desc check-eval custom-control-input"  data-group="go" value="3" <?php echo (isset($data['gender_objectives']) && $data['gender_objectives'] ==  3 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_objectives_no">No</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_objectives_unknow" name="gender_objectives" class="trigger-desc check-eval custom-control-input"  data-group="go" value="4" <?php echo (isset($data['gender_objectives']) && $data['gender_objectives'] ==  4 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_objectives_unknow">Non saprei</label>
                      </div>
                  </div>

                  <div class="form-group">
                      <label>Nel progetto i partecipanti (a volte chiamati beneficiari) sono distinti per genere (donne, uomini, altri), utilizzando - per esempio -parole come donne, bambine, anziane, studentesse, lavoratrici, etc.</label>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_language_yes" name="gender_language" class="trigger-desc custom-control-input" data-group="gl" data-target="#glid" value="1" <?php echo (isset($data['gender_language']) && $data['gender_language'] ==  1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_language_yes">Si</label>
                      </div>
                      <div class="form-group d-none trigger-desc-wrapper" id="glid">
                          <label>Puoi indicarci quali termini sono stati utilizzati?</label>
                          <textarea id="gender_language_desc" name="gender_language_desc"  class="form-control"><?php echo ckv($data, 'gender_language_desc'); ?></textarea>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_language_no" name="gender_language" class="trigger-desc custom-control-input"  data-group="gl" value="2" <?php echo (isset($data['gender_language']) && $data['gender_language'] ==  2 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_language_no">No</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_language_nok" name="gender_language" class="trigger-desc custom-control-input" data-group="gl" value="3" <?php echo (isset($data['gender_language']) && $data['gender_language'] ==  3 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_language_nok">Non saprei</label>
                      </div>
                  </div>

                  <div class="form-group">
                      <label>Il progetto stanzia risorse finanziarie esplicitamente destinate ad azioni che promuovono la parità di genere?</label>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_finance_yes" name="gender_finance" class="trigger-desc custom-control-input" data-group="gf" data-target="#gfy" value="1" <?php echo (isset($data['gender_finance']) && $data['gender_finance'] ==  1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_finance_yes">Si</label>
                      </div>

                      <div class="form-group d-none trigger-desc-wrapper" id="gfy">
                          <label>In che percentuale rispetto al budget totale?</label>
                          <input id="gender_finance_desc" name="gender_finance_desc"  class="form-control" value="<?php echo ckv($data, 'gender_finance_desc'); ?>" />
                      </div>

                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_finance_no" name="gender_finance" class="trigger-desc custom-control-input"  data-group="gf"  value="2" <?php echo (isset($data['gender_finance']) && $data['gender_finance'] ==  2 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_finance_no">No</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_finance_nok" name="gender_finance" class="trigger-desc custom-control-input"  data-group="gf"  value="2" <?php echo (isset($data['gender_finance']) && $data['gender_finance'] ==  3 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_finance_nok">Non saprei</label>
                      </div>
                  </div>

                  <div class="form-group">
                      <label>Sono stati indicati esplicitamente indicatori (es. numero di operatrici formate o percentuale di aumento delle studentesse iscritte a corsi STEM) per monitorare e valutare l’impatto del progetto in termini di promozione della parità di genere?</label>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_indicators_yes" name="gender_indicators" class="trigger-desc custom-control-input" data-group="gi" data-target="#giy" value="1" <?php echo (isset($data['gender_indicators']) && $data['gender_indicators'] ==  1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_indicators_yes">Si</label>
                      </div>

                      <div class="form-group d-none trigger-desc-wrapper" id="giy">
                          <label>Quali indicatori sono stati menzionati?</label>
                          <input id="gender_indicators_desc" name="gender_indicators_desc"  class="form-control" value="<?php echo ckv($data, 'gender_indicators_desc'); ?>" />
                      </div>

                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_indicators_no" name="gender_indicators" class="trigger-desc custom-control-input"  data-group="gi"  value="2" <?php echo (isset($data['gender_indicators']) && $data['gender_indicators'] ==  2 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_indicators_no">No</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_indicators_nok" name="gender_indicators" class="trigger-desc custom-control-input"  data-group="gi"  value="3" <?php echo (isset($data['gender_indicators']) && $data['gender_indicators'] ==  3 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_indicators_nok">Non saprei</label>
                      </div>
                  </div>

              </fieldset>


            <button id="tab-2-nav" class="tab-subnav btn btn-primary btn-lg btn-block" data-step="#step-2" type="button">VAI ALLO STEP 2: VALUTAZIONE</button><br /><br />
        </div>

        <div class="tab-pane fade" id="step-2" role="tabpanel" aria-labelledby="step-2">
            <p>Raccogli ulteriori informazioni sul progetto che hai deciso di monitorare, e descrivi sinteticamente i risultati delle tue ricerche.</p>
          <div class="d-none" id="oc_api_content_s2">
            <i class="fal fa-sync fa-spin"></i>
          </div>

          <fieldset>
            <legend>Valutazione</legend>


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

              <div class="form-group d-none" id="sda_infrastrutturale">
                  <input type="hidden" name="cup_descr_natura" id="cup_descr_natura" value="">
                  <label>Stato avanzamento lavori:</label>

                  <div class="custom-control custom-radio">
                      <input type="radio" id="sdai_1" name="stato_di_avanzamento_infrastrutturale" class=" custom-control-input" value="1"  <?php echo (isset($data['stato_di_avanzamento_infrastrutturale']) && $data['stato_di_avanzamento_infrastrutturale'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="sdai_1">Non avviato</label>
                  </div>
                  <div class="custom-control custom-radio">
                      <input type="radio" id="sdai_2" name="stato_di_avanzamento_infrastrutturale" class=" custom-control-input" value="2"  <?php echo (isset($data['stato_di_avanzamento_infrastrutturale']) && $data['stato_di_avanzamento_infrastrutturale'] == 2 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="sdai_2">In avvio di progettazione <small>Studio di fattibilità</small></label>
                  </div>

                  <div class="custom-control custom-radio">
                      <input type="radio" id="sdai_3" name="stato_di_avanzamento_infrastrutturale" class=" custom-control-input" value="3"  <?php echo (isset($data['stato_di_avanzamento_infrastrutturale']) && $data['stato_di_avanzamento_infrastrutturale'] == 3 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="sdai_3">In corso di progettazione <small>Progettazione esecutiva</small></label>
                  </div>
                  <div class="custom-control custom-radio">
                      <input type="radio" id="sdai_4" name="stato_di_avanzamento_infrastrutturale" class=" custom-control-input" value="4"  <?php echo (isset($data['stato_di_avanzamento_infrastrutturale']) && $data['stato_di_avanzamento_infrastrutturale'] == 4 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="sdai_4">In affidamento <small>Affidamento gara in corso</small></label>
                  </div>
                  <div class="custom-control custom-radio">
                      <input type="radio" id="sdai_5" name="stato_di_avanzamento_infrastrutturale" class=" custom-control-input" value="5"  <?php echo (isset($data['stato_di_avanzamento_infrastrutturale']) && $data['stato_di_avanzamento_infrastrutturale'] == 5 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="sdai_5">In esecuzione <small>Lavori iniziati</small></label>
                  </div>
                  <div class="custom-control custom-radio">
                      <input type="radio" id="sdai_6" name="stato_di_avanzamento_infrastrutturale" class=" custom-control-input" value="6"  <?php echo (isset($data['stato_di_avanzamento_infrastrutturale']) && $data['stato_di_avanzamento_infrastrutturale'] == 6 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="sdai_6">Eseguito <small>Conclusa la fase di esecuzione</small></label>
                  </div>
              </div>

            <div class="form-group">
              <label for="avanzamento">Descrizione dello stato di avanzamento del progetto monitorato:</label>
                <small clasS="form-text text-muted">Descrivi lo stato del progetto sulla base delle informazioni raccolte, specificando la fonte delle informazioni (es. quali documenti, quali interviste, visita di monitoraggio).</small>
              <textarea name="avanzamento" id="avanzamento" class="form-control"><?php echo ckv($data, 'avanzamento'); ?></textarea>
            </div>


              <!-- Giudizio Sintetico -->
              <div class="form-group">
                  <label for="gs">Giudizio di efficacia (anche potenziale) sul progetto monitorato: </label>
                  <small class="form-text form-muted">Come giudichi l’efficacia del progetto monitorato?</small>

                  <div class="custom-control custom-radio">
                      <input type="radio" id="giudizio_sintetico_1" name="gs" class="custom-control-input" value="1"  <?php echo (isset($data['gs']) && $data['gs'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label gsl" for="giudizio_sintetico_1"></label>
                  </div>
                  <div class="custom-control custom-radio">
                      <input type="radio" id="giudizio_sintetico_2" name="gs" class="custom-control-input check-eval" value="2"  <?php echo (isset($data['gs']) && $data['gs'] == 2 ? 'checked' : ''); ?>>
                      <label class="custom-control-label gsl" for="giudizio_sintetico_2"></label>
                  </div>
                  <div class="custom-control custom-radio">
                      <input type="radio" id="giudizio_sintetico_3" name="gs" class="custom-control-input check-eval" value="3"  <?php echo (isset($data['gs']) && $data['gs'] == 3 ? 'checked' : ''); ?>>
                      <label class="custom-control-label gsl" for="giudizio_sintetico_3"></label>
                  </div>
                  <div class="custom-control custom-radio">
                      <input type="radio" id="giudizio_sintetico_4" name="gs" class="custom-control-input" value="4"  <?php echo (isset($data['gs']) && $data['gs'] == 4 ? 'checked' : ''); ?>>
                      <label class="custom-control-label gsl" for="giudizio_sintetico_4"></label>
                  </div>

              </div>

              <!-- EOF Giudizio Sintetico -->

            <div class="form-group">
              <label for="risultato_progetto">Risultato del progetto monitorato:</label>
                <small class="text-muted form-text">Descrivi più in dettaglio i risultati ottenuti del progetto. Concentrati in particolare sull’utilità ed efficacia dei risultati, dal tuo punto di vista. Se il progetto è ancora in corso, prova a descrivere, se possibile, i suoi risultati parziali. Cita sempre le fonti delle tue affermazioni (es. documenti, visita di monitoragggio, interviste, etc.)</small>
              <textarea name="risultato_progetto" id="risultato_progetto" class="form-control"><?php echo ckv($data, 'risultato_progetto'); ?></textarea>
            </div>



              <div class="form-group d-none" id="cause_inefficacia_wrapper">
                  <label>Quali sono i problemi che hai rilevato?</label>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" value="1" id="problemi_amministrativi" name="problemi_amministrativi" <?php echo (isset($data['problemi_amministrativi']) && $data['problemi_amministrativi'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="problemi_amministrativi">Realizzazione ha mostrato problemi di natura amministrativa</label>
                  </div>

                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" value="1" id="problemi_tecnici" name="problemi_tecnici" <?php echo (isset($data['problemi_tecnici']) && $data['problemi_tecnici'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="problemi_tecnici">Realizzazione ha mostrato problemi di natura tecnica</label>
                  </div>

                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" value="1" id="risultato_insoddisfacente" name="risultato_insoddisfacente" <?php echo (isset($data['risultato_insoddisfacente']) && $data['risultato_insoddisfacente'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="risultato_insoddisfacente">Il risultato del progetto non è soddisfacente</label>
                  </div>

                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" value="1" id="non_efficace" name="non_efficace" <?php echo (isset($data['non_efficace']) && $data['non_efficace'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="non_efficace">Intervento complessivamente ben realizzato ma non rispondente ai bisogni degli utenti finali (non efficace)</label>
                  </div>

                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" value="1" id="non_sufficiente" name="non_sufficiente" <?php echo (isset($data['non_sufficiente']) && $data['non_sufficiente'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="non_sufficiente">Intervento utile ma non sufficiente per rispondere al fabbisogno (“ne serve di più”, es. più investimenti nello stesso progetto o in progetti simili)</label>
                  </div>

                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" value="1" id="necessita_interventi_extra" name="necessita_interventi_extra" <?php echo (isset($data['necessita_interventi_extra']) && $data['necessita_interventi_extra'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="necessita_interventi_extra">Intervento di per sè utile ma sono necessari altri interventi complementari</label>
                  </div>
              </div>

<?php /*
              <div class="form-group" id="problems_found">
                  <label for="valutazione_risultati"><?php t('Quali sono i problemi che hai rilevato?'); ?></label>
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="problema_rilevato_1" name="problema_rilevato_1" class="check-eval custom-control-input" value="1"  <?php echo (isset($data['problema_rilevato_1']) && $data['problema_rilevato_1'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="problema_rilevato_1">Realizzazione ha mostrato problemi di natura amministrativa</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="problema_rilevato_2" name="problema_rilevato_2" class="check-eval custom-control-input" value="1"  <?php echo (isset($data['problema_rilevato_2']) && $data['problema_rilevato_2'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="problema_rilevato_2">Realizzazione ha mostrato problemi di natura tecnica</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="problema_rilevato_3" name="problema_rilevato_3" class="check-eval custom-control-input" value="1"  <?php echo (isset($data['problema_rilevato_3']) && $data['problema_rilevato_3'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="problema_rilevato_3">Il risultato del progetto non è soddisfacente</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="problema_rilevato_4" name="problema_rilevato_4" class="check-eval custom-control-input" value="1"  <?php echo (isset($data['problema_rilevato_4']) && $data['problema_rilevato_4'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="problema_rilevato_4">Intervento complessivamente ben realizzato ma non rispondente ai bisogni degli utenti finali (non efficace)</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="problema_rilevato_5" name="problema_rilevato_5" class="check-eval custom-control-input" value="1"  <?php echo (isset($data['problema_rilevato_5']) && $data['problema_rilevato_5'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="problema_rilevato_5">Intervento utile ma non sufficiente per rispondere al fabbisogno (“ne serve di più”, es. più investimenti nello stesso progetto o in progetti simili)</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="problema_rilevato_6" name="problema_rilevato_6" class="check-eval custom-control-input" value="1"  <?php echo (isset($data['problema_rilevato_6']) && $data['problema_rilevato_6'] == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="problema_rilevato_6">Intervento di per sé utile ma sono necessari altri interventi complementari</label>
                  </div>
              </div> */ ?>

            <?php /** REMOVED
                    11/10/2022 - Big Overhaul of Stuff
            <div class="form-group">
              <label for="valutazione_risultati"><?php t('Se il progetto è concluso o sei stato comunque in grado di valutare alcuni dei suoi risultati qual è il tuo giudizio sull’efficacia del progetto che hai monitorato?'); ?></label>
              <div class="custom-control custom-radio">
                <input type="radio" id="valutazione_risultati_1" name="valutazione_risultati" class="check-eval custom-control-input" value="1"  <?php echo (isset($data['valutazione_risultati']) && $data['valutazione_risultati'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="valutazione_risultati_1">Intervento dannoso - Era meglio non farlo perché ha provocato conseguenze negative </label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="valutazione_risultati_2" name="valutazione_risultati" class="check-eval custom-control-input" value="2" <?php echo (isset($data['valutazione_risultati']) && $data['valutazione_risultati'] ==  2 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="valutazione_risultati_2">Intervento inutile - Non ha cambiato la situazione, soldi sprecati</label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="valutazione_risultati_3" name="valutazione_risultati" class="check-eval custom-control-input" value="3"  <?php echo (isset($data['valutazione_risultati']) && $data['valutazione_risultati'] ==  3 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="valutazione_risultati_3">Intervento utile ma presenta problemi - Ha avuto alcuni risultati positivi ed è tutto sommato utile, anche se presenta anche aspetti negativi</label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="valutazione_risultati_4" name="valutazione_risultati" class="check-eval custom-control-input" value="4"  <?php echo (isset($data['valutazione_risultati']) && $data['valutazione_risultati'] ==  4 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="valutazione_risultati_4">Intervento molto utile ed efficace - Gli aspetti positivi prevalgono ed è giudicato complessivamente efficace dal punto di vista dell'utente finale </label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="valutazione_risultati_5" name="valutazione_risultati" class="check-eval custom-control-input" value="5"  <?php echo (isset($data['valutazione_risultati']) && $data['valutazione_risultati'] ==  5 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="valutazione_risultati_5">Non è stato possibile valutare l’efficacia dell’intervento - Es. il progetto non ha ancora prodotto risultati valutabili </label>
              </div>
            </div>
*/ ?>
            <div class="form-group">
              <label for="punti_di_forza">Punti di forza del progetto monitorato:</label>
                <small class="text-muted form-text">Cosa ti è piaciuto della progettazione/attuazione/realizzazione del progetto che hai monitorato? Quali aspetti puoi valutare come positivi?</small>
              <textarea name="punti_di_forza" id="punti_di_forza" class="form-control"><?php echo ckv($data, 'punti_di_forza'); ?></textarea>
            </div>


            <div class="form-group">
              <label for="punti_deboli">Punti di debolezza del progetto monitorato:</label>
                <small class="text-muted form-text">Cosa non ti è piaciuto della progettazione/attuazione/realizzazione del progetto monitorato? Quali aspetti puoi valutare come negativi?<br />
                    NB: Occorre specificare gli aspetti negativi del progetto monitorato, non della ricerca di monitoraggio civico. Se hai avuto problemi a fare le interviste o a trovare informazioni, puoi utilizzare le domande della sessione successiva “Metodi di indagine”.
                </small>
              <textarea name="punti_deboli" id="punti_deboli" class="form-control"><?php echo ckv($data, 'punti_deboli'); ?></textarea>
            </div>

            <div class="form-group">
              <label for="rischi">Rischi futuri per il progetto monitorato:</label>
                <small class="form-text text-muted">Cosa potrebbe mettere in pericolo l’efficacia del progetto monitorato? Quali aspetti potrebbero rivelarsi problematici, dato il contesto in cui il progetto opera?</small>
              <textarea name="rischi" id="rischi" class="form-control"><?php echo ckv($data, 'rischi'); ?></textarea>
            </div>


            <div class="form-group">
              <label for="soluzioni_progetto">Soluzioni ed idee da proporre per il progetto monitorato:</label>
                <small class="text-muted form-text">Quali azioni o condizioni potrebbero aumentare l’efficacia del progetto monitorato, inclusi eventuali progetti/opere/servizi/interventi di varia natura complementari che sarebbe necessario implementare per un adeguato perseguimento degli obiettivi finali del progetto? Questi suggerimenti sono importanti per comunicare ai decisori pubblici come il progetto può essere reso più efficace.</small>
              <textarea name="soluzioni_progetto" id="soluzioni_progetto" class="form-control"><?php echo ckv($data, 'soluzioni_progetto'); ?></textarea>
            </div>



          </fieldset>

          <fieldset>
            <legend>Metodi di Indagine</legend>
            <!-- Raccolta Info -->
            <div class="form-group">
              <label for="">Raccolta Informazioni</label>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_web" name="raccolta_info_web" <?php echo (isset($data['raccolta_info_web']) && $data['raccolta_info_web'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="raccolta_info_web">Raccolta di informazioni via web o altre fonti</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="visita_diretta" name="visita_diretta" <?php echo (isset($data['visita_diretta']) && $data['visita_diretta'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="visita_diretta">Visita diretta documentata da foto e video</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="intervista_autorita_gestione" name="intervista_autorita_gestione" <?php echo (isset($data['intervista_autorita_gestione']) && $data['intervista_autorita_gestione'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="intervista_autorita_gestione">Intervista con l'Autorità di Gestione del Programma</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="intervista_soggetto_programmatore" name="intervista_soggetto_programmatore" <?php echo (isset($data['intervista_soggetto_programmatore']) && $data['intervista_soggetto_programmatore'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="intervista_soggetto_programmatore">Intervista con i soggetti che hanno programmato l'intervento (soggetto programmatore)</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="intervista_utenti_beneficiari" name="intervista_utenti_beneficiari" <?php echo (isset($data['intervista_utenti_beneficiari']) && $data['intervista_utenti_beneficiari'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="intervista_utenti_beneficiari">Intervista con gli utenti/beneficiari finali dell'intervento</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="intervista_altri_utenti" name="intervista_altri_utenti" <?php echo (isset($data['intervista_altri_utenti']) && $data['intervista_altri_utenti'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="intervista_altri_utenti">Intervista con altre tipologie di persone</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_attuatore" name="raccolta_info_attuatore" <?php echo (isset($data['raccolta_info_attuatore']) && $data['raccolta_info_attuatore'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="raccolta_info_attuatore">Intervista con i soggetti che hanno o stanno attuando l'intervento (attuatore o realizzatore)</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="referenti_politici" name="referenti_politici" <?php echo (isset($data['referenti_politici']) && $data['referenti_politici'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="referenti_politici">Intervista con i referenti politici</label>
              </div>

                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" value="1" id="questionario_utenti" name="questionario_utenti" <?php echo (isset($data['questionario_utenti']) && $data['questionario_utenti'] == 1 ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="questionario_utenti">Questionario inviato a utenti/beneficiari finali dell'intervento</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" value="1" id="questionario_altri" name="questionario_altri" <?php echo (isset($data['questionario_altri']) && $data['questionario_altri'] == 1 ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="questionario_altri">Questionario inviato a altre tipologie di persone</label>
                </div>
            </div>

            <div class="form-group">
                <label>Facilità di accesso alle informazioni pubbliche</label>
                <div class="custom-control custom-radio">
                    <input type="radio" id="faip_1" name="facilita_accesso_informazioni" class=" custom-control-input" value="1"  <?php echo (isset($data['facilita_accesso_informazioni']) && $data['facilita_accesso_informazioni'] == 1 ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="faip_1">Facile <small>(es. ho trovato tutte le informazioni di cui avevo bisogno sui siti ufficiali delle amministrazioni; le amministrazioni contattate mi hanno risposto rapidamente e sono state disponibili a farsi intervistare)</small></label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="faip_2" name="facilita_accesso_informazioni" class=" custom-control-input" value="2"  <?php echo (isset($data['facilita_accesso_informazioni']) && $data['facilita_accesso_informazioni'] == 2 ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="faip_2">Con qualche difficiltà <small>(es. ho trovato alcune delle informazioni di cui avevo bisogno sui siti ufficiali delle amministrazioni, ma ho dovuto richiedere alcune informazioni o documenti ai soggetti coinvolti; non tutte le amministrazioni contattate mi hanno risposto rapidamente o non hanno risposto)</small></label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="faip_3" name="facilita_accesso_informazioni" class=" custom-control-input" value="3"  <?php echo (isset($data['facilita_accesso_informazioni']) && $data['facilita_accesso_informazioni'] == 3 ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="faip_3">Difficoltoso <small>(es. ho trovato poche informazioni sui siti ufficiali delle amministrazioni; ho dovuto richiedere alle amministrazioni i documenti progettuali che mi servivano; è stato difficoltoso mettersi in contatto con le amministrazioni e avere disponibilità per interviste)</small></label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="faip_4" name="facilita_accesso_informazioni" class=" custom-control-input" value="4"  <?php echo (isset($data['facilita_accesso_informazioni']) && $data['facilita_accesso_informazioni'] == 4 ? 'checked' : ''); ?>>
                    <label class="custom-control-label" for="faip_4">Impossibile <small>(es. non ho trovato nessun documento disponibile in rete, le amministrazioni contattate non hanno risposto alle mie richieste, non sono riuscito a intervistare nessuno)</small></label>
                </div>
            </div>

            <div class="form-group">
              <label for="intervista_intervistati">Chi sono e che ruolo hanno nel progetto le persone che hai contattato e/o intervistato? A quale organizzazione appartengono? </label>
                <small class="form-text text-muted">Riporta i ruoli di tutte le persone contattate e/o intervistate. Se le interviste non sono andate a buon fine, raccontaci perché. Specifica anche il ruolo e l’organizzazione di appartenenza delle persone che avete provato a intervistare ma che non hanno risposto, e quando.</small>
              <textarea name="intervista_intervistati" id="intervista_intervistati" class="form-control"><?php echo ckv($data, 'intervista_intervistati'); ?></textarea>
            </div>

            <div class="form-group">
              <label for="intervista_domande">Principali due domande poste agli intervistati:</label>
                <small class="form-text text-muted">Specifica, tra parentesi dopo ogni domanda, a chi è stata rivolta (ruolo e organizzazione di appartenenza). Se hai fatto una sbobinatura integrale dell’intervista, allegala come PDF nella successiva sezione “Link, Video, Allegati”.</small>
              <textarea name="intervista_domande" id="intervista_domande" class="form-control"><?php echo ckv($data, 'intervista_domande'); ?></textarea>
            </div>

            <div class="form-group">
              <label for="intervista_risposte">Principali due risposte degli intervistati:</label>
                <small class="form-text text-muted">Riporta le risposte integrali o, se troppo lunghe, una loro sintesi dettagliata (es. le riposte “Sì” o “No” non sono sufficienti).</small>
              <textarea name="intervista_risposte" id="intervista_risposte" class="form-control"><?php echo ckv($data, 'intervista_risposte'); ?></textarea>
            </div>

              <div class="form-group qe_w d-none" >
                  <label for="questionario_extra">Se hai somministrato un questionario, quali tipologie di persone sono state coinvolte e quale è stato il tasso di risposta?</label>
                  <small class="form-text text-muted">Specifica a chi hai mandato il questionario (es. utenti di un servizio, beneficiari finali di un investimento), quanti questionari hai inviato e quante risposte hai ottenuto.</small>
                  <textarea name="questionario_extra" id="questionario_extra" class="form-control"><?php echo ckv($data, 'questionario_extra'); ?></textarea>
              </div>


          </fieldset>

          <fieldset>
            <legend>Link, Video, Allegati</legend>
              <div class="alert alert-info" role="alert"><i class="fas fa-exclamation-triangle"></i> <strong>Il peso complessivo dei file che si vogliono caricare non deve eccedere gli 8mb per invio.</strong></div>
              <p class="form-text">Aggiungi almeno un’immagine per la copertina del report. Inserisci le foto che hai fatto durante la visita di monitoraggio o durante le interviste, o qualunque altra immagine che documenti il tuo monitoraggio civico.</p>
              <p class="form-text">Se hai somministrato un questionario, carica, in formato PDF, i principali risultati dell’indagine che hai realizzato, con il dettaglio delle risposte ottenute e un tuo commento.</p>
              <p class="form-text">Se hai fatto interviste, inserisci, in formato PDF, una sintesi più estesa delle domande e delle risposte.</p>
              <p class="form-text">Attenzione: Il peso complessivo dei file che si vogliono caricare non deve eccedere gli 8mb ogni volta in cui si salva.</p>

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
           <!--  <button id="tab-3-nav" class="tab-subnav btn btn-primary btn-lg btn-block" data-step="#step-3" type="button">VAI ALLO STEP 3: RISULTATI E IMPATTO</button><br /><br /> -->
        </div>


<?php  // step 3 - hidden on create ?>
        <div class="tab-pane fade" id="step-3" role="tabpanel" aria-labelledby="step-3">

            <fieldset>
                <legend>Le nuove connessioni che hai generato</legend>
                <div class="form-group">
                    <label for="nuove-connessioni">Come hai diffuso o stai diffondendo i risultati del vostro monitoraggio civico?</label>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_twitter" name="diffusione_twitter" <?php echo (isset($data['diffusione_twitter']) && $data['diffusione_twitter'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_twitter">Twitter</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_facebook" name="diffusione_facebook" <?php echo (isset($data['diffusione_facebook']) && $data['diffusione_facebook'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_facebook">Facebook</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_instagram" name="diffusione_instagram" <?php echo (isset($data['diffusione_instagram']) && $data['diffusione_instagram'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_instagram">Instagram</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_eventi" name="diffusione_eventi" <?php echo (isset($data['diffusione_eventi']) && $data['diffusione_eventi'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_eventi">Eventi territoriali organizzati dai team</label>
                    </div>


                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_open_admin" name="diffusione_open_admin" <?php echo (isset($data['diffusione_open_admin']) && $data['diffusione_open_admin'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_open_admin">Settimana dell'Amministrazione Aperta</label>
                    </div>


                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_blog" name="diffusione_blog" <?php echo (isset($data['diffusione_blog']) && $data['diffusione_blog'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_blog">Blog/Sito web del Team</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_offline" name="diffusione_offline" <?php echo (isset($data['diffusione_offline']) && $data['diffusione_offline'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_offline">Volantinaggio o altri metodi off-line (non via Internet)</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_incontri" name="diffusione_incontri" <?php echo (isset($data['diffusione_incontri']) && $data['diffusione_incontri'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_incontri">Richiesta di audizioni o incontri a porte chiuse</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="diffusione_interviste" name="diffusione_interviste" <?php echo (isset($data['diffusione_interviste']) && $data['diffusione_interviste'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="diffusione_interviste">Interviste ai media</label>
                    </div>
                    <div class="form-group">
                        <label class="" for="diffusione_altro">Altro</label>
                        <input class="form-control" type="text" id="diffusione_altro" name="diffusione_altro" value="<?php echo ckv($data, 'diffusione_altro'); ?>">

                    </div>


                </div>

                <div class="form-group">
                    <label>Con quali soggetti hai creato delle connessioni per discutere dei risultati del vostro monitoraggio?</label>
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
                            <tr>
                                <td><input type="text" name="connection[1][subject]" placeholder="Soggetto..." class="form-control c-subject"></td>
                                <td><input type="text" name="connection[1][role]" placeholder="Ruolo..." class="form-control"></td>
                                <td><input type="text" name="connection[1][organisation]" placeholder="Organizzazione..." class="form-control"></td>
                                <td>
                                    <select name="connection[1][connection_type]" id="connection[1][connection_type]" class="form-control pck">
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

                </div>
                <?php /*
                <div class="form-group" id="connection-relationships">
                    <button type="button" class="btn btn-secondary btn-sm" id="aggiorna-soggetti">Aggiorna la Matrice delle Connessioni con i Soggetti inseriti</button>
                    <table id="connection-relationships-table" class="table table-condensed table-borderless table-sm table-hover ">
                        <thead>
                            <tr>
                                <th></th>
                                <th id="c2"></th>
                                <th id="c3"></th>
                                <th id="c4"></th>
                                <th id="c5"></th>
                                <th id="c6"></th>
                                <th id="c7"></th>
                                <th id="c8"></th>
                                <th id="c9"></th>
                                <th id="c10"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="r1" class="connection-rel-namecell"></td>
                                <td><input type="hidden" id="crt_r1_c2_names" class="crt-name" data-row="1" data-col="2" name="crt[r1_c2][names]"><div class="form-check"><input name="crt[r1_c2][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r1_c3_names" class="crt-name" data-row="1" data-col="3" name="crt[r1_c3][names]"><div class="form-check"><input name="crt[r1_c3][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r1_c4_names" class="crt-name" data-row="1" data-col="4" name="crt[r1_c4][names]"><div class="form-check"><input name="crt[r1_c4][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r1_c5_names" class="crt-name" data-row="1" data-col="5" name="crt[r1_c5][names]"><div class="form-check"><input name="crt[r1_c5][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r1_c6_names" class="crt-name" data-row="1" data-col="6" name="crt[r1_c6][names]"><div class="form-check"><input name="crt[r1_c6][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r1_c7_names" class="crt-name" data-row="1" data-col="7" name="crt[r1_c7][names]"><div class="form-check"><input name="crt[r1_c7][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r1_c8_names" class="crt-name" data-row="1" data-col="8" name="crt[r1_c8][names]"><div class="form-check"><input name="crt[r1_c8][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r1_c9_names" class="crt-name" data-row="1" data-col="9" name="crt[r1_c9][names]"><div class="form-check"><input name="crt[r1_c9][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r1_c10_names" class="crt-name" data-row="1" data-col="10" name="crt[r1_c10][names]"><div class="form-check"><input name="crt[r1_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>

                            </tr>
                            <tr>
                                <td id="r2" class="connection-rel-namecell"></td>
                                <td></td>
                                <td><input type="hidden" id="crt_r2_c3_names" class="crt-name" data-row="2" data-col="3" name="crt[r2_c3][names]"><div class="form-check"><input name="crt[r2_c3][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r2_c4_names" class="crt-name" data-row="2" data-col="4" name="crt[r2_c4][names]"><div class="form-check"><input name="crt[r2_c4][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r2_c5_names" class="crt-name" data-row="2" data-col="5" name="crt[r2_c5][names]"><div class="form-check"><input name="crt[r2_c5][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r2_c6_names" class="crt-name" data-row="2" data-col="6" name="crt[r2_c6][names]"><div class="form-check"><input name="crt[r2_c6][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r2_c7_names" class="crt-name" data-row="2" data-col="7" name="crt[r2_c7][names]"><div class="form-check"><input name="crt[r2_c7][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r2_c8_names" class="crt-name" data-row="2" data-col="8" name="crt[r2_c8][names]"><div class="form-check"><input name="crt[r2_c8][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r2_c9_names" class="crt-name" data-row="2" data-col="9" name="crt[r2_c9][names]"><div class="form-check"><input name="crt[r2_c9][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r2_c10_names" class="crt-name" data-row="2" data-col="10" name="crt[r2_c10][names]"><div class="form-check"><input name="crt[r2_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>


                            </tr>
                            <tr>
                                <td id="r3" class="connection-rel-namecell"></td>
                                <td></td>
                                <td></td>
                                <td><input type="hidden" id="crt_r3_c4_names" class="crt-name" data-row="3" data-col="4" name="crt[r3_c4][names]"><div class="form-check"><input name="crt[r3_c4][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r3_c5_names" class="crt-name" data-row="3" data-col="5" name="crt[r3_c5][names]"><div class="form-check"><input name="crt[r3_c5][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r3_c6_names" class="crt-name" data-row="3" data-col="6" name="crt[r3_c6][names]"><div class="form-check"><input name="crt[r3_c6][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r3_c7_names" class="crt-name" data-row="3" data-col="7" name="crt[r3_c7][names]"><div class="form-check"><input name="crt[r3_c7][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r3_c7_names" class="crt-name" data-row="3" data-col="8" name="crt[r3_c8][names]"><div class="form-check"><input name="crt[r3_c8][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r3_c9_names" class="crt-name" data-row="3" data-col="9" name="crt[r3_c9][names]"><div class="form-check"><input name="crt[r3_c9][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r3_c10_names" class="crt-name" data-row="3" data-col="10" name="crt[r3_c10][names]"><div class="form-check"><input name="crt[r3_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>


                            </tr>
                            <tr>
                                <td id="r4" class="connection-rel-namecell"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="hidden" id="crt_r4_c5_names" class="crt-name" data-row="4" data-col="5" name="crt[r4_c5][names]"><div class="form-check"><input name="crt[r4_c5][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r4_c6_names" class="crt-name" data-row="4" data-col="6" name="crt[r4_c6][names]"><div class="form-check"><input name="crt[r4_c6][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r4_c7_names" class="crt-name" data-row="4" data-col="7" name="crt[r4_c7][names]"><div class="form-check"><input name="crt[r4_c7][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r4_c8_names" class="crt-name" data-row="4" data-col="8" name="crt[r4_c8][names]"><div class="form-check"><input name="crt[r4_c8][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r4_c9_names" class="crt-name" data-row="4" data-col="9" name="crt[r4_c9][names]"><div class="form-check"><input name="crt[r4_c9][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r4_c10_names" class="crt-name" data-row="4" data-col="10" name="crt[r4_c10][names]"><div class="form-check"><input name="crt[r4_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>


                            </tr>
                            <tr>
                                <td id="r5" class="connection-rel-namecell"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="hidden" id="crt_r5_c6_names" class="crt-name" data-row="5" data-col="6" name="crt[r5_c6][names]"><div class="form-check"><input name="crt[r5_c6][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r5_c7_names" class="crt-name" data-row="5" data-col="7" name="crt[r5_c7][names]"><div class="form-check"><input name="crt[r5_c7][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r5_c8_names" class="crt-name" data-row="5" data-col="8" name="crt[r5_c8][names]"><div class="form-check"><input name="crt[r5_c8][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r5_c9_names" class="crt-name" data-row="5" data-col="9" name="crt[r5_c9][names]"><div class="form-check"><input name="crt[r5_c9][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r5_c10_names" class="crt-name" data-row="5" data-col="10" name="crt[r5_c10][names]"><div class="form-check"><input name="crt[r5_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>

                            </tr>
                            <tr>
                                <td id="r6" class="connection-rel-namecell"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="hidden" id="crt_r6_c7_names" class="crt-name" data-row="6" data-col="7" name="crt[r6_c7][names]"><div class="form-check"><input name="crt[r6_c7][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r6_c8_names" class="crt-name" data-row="6" data-col="8" name="crt[r6_c8][names]"><div class="form-check"><input name="crt[r6_c8][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r6_c9_names" class="crt-name" data-row="6" data-col="9" name="crt[r6_c9][names]"><div class="form-check"><input name="crt[r6_c9][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r6_c10_names" class="crt-name" data-row="6" data-col="10" name="crt[r6_c10][names]"><div class="form-check"><input name="crt[r6_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>

                            </tr>
                            <tr>
                                <td id="r7" class="connection-rel-namecell"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="hidden" id="crt_r7_c8_names" class="crt-name" data-row="7" data-col="8" name="crt[r7_c8][names]"><div class="form-check"><input name="crt[r7_c8][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r7_c9_names" class="crt-name" data-row="7" data-col="9" name="crt[r7_c9][names]"><div class="form-check"><input name="crt[r7_c9][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r7_c10_names" class="crt-name" data-row="7" data-col="10" name="crt[r7_c10][names]"><div class="form-check"><input name="crt[r7_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>

                            </tr>
                            <tr>
                                <td id="r8" class="connection-rel-namecell"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="hidden" id="crt_r8_c9_names" class="crt-name" data-row="8" data-col="9" name="crt[r8_c9][names]"><div class="form-check"><input name="crt[r8_c9][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                                <td><input type="hidden" id="crt_r8_c10_names" class="crt-name" data-row="8" data-col="10" name="crt[r8_c10][names]"><div class="form-check"><input name="crt[r8_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                            </tr>
                            <tr>
                                <td id="r9" class="connection-rel-namecell"></td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="hidden" id="crt_r9_c10_names" class="crt-name" data-row="9" data-col="10" name="crt[r9_c10][names]"><div class="form-check"><input name="crt[r9_c10][value]" type="checkbox" value="1" class="form-check-input position-static"></div></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
  */ ?>

                <div class="form-group">
                    <label>I media hanno parlato del tuo monitoraggio?</label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="media_connection_yes" name="media_connection" class="custom-control-input" value="1"  <?php echo (isset($data['media_connection']) && $data['media_connection'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="media_connection_yes">Si</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="media_connection_no" name="media_connection" class="custom-control-input" value="0"  <?php echo (isset($data['media_connection']) && $data['media_connection'] == 0 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="media_connection_no">No</label>
                    </div>
                </div>


                <div class="form-group">
                    <label>Se sì, i risultati del monitoraggio sono stati ripresi dai seguenti media:</label>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="tv_locali" name="tv_locali" <?php echo (isset($data['tv_locali']) && $data['tv_locali'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="tv_locali">TV Locali</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="tv_nazionali" name="tv_nazionali" <?php echo (isset($data['tv_nazionali']) && $data['tv_nazionali'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="tv_nazionali">TV Nazionali</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="giornali_locali" name="giornali_locali" <?php echo (isset($data['giornali_locali']) && $data['giornali_locali'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="giornali_locali">Giornali Locali</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="giornali_nazionali" name="giornali_nazionali" <?php echo (isset($data['giornali_nazionali']) && $data['giornali_nazionali'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="giornali_nazionali">Giornali Nazionali</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="blog_online" name="blog_online" <?php echo (isset($data['blog_online']) && $data['blog_online'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="blog_online">Blog o altre news outlet online</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="media_other" name="media_other" <?php echo (isset($data['media_other']) && $data['media_other'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="media_other">Altro</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Dopo aver svolto la ricerca di monitoraggio, hai provato a contattare le Amministrazioni responsabili per presentare o discutere con loro i risultati del tuo monitoraggio?                    </label>
                    <small class="form-text text-muted">Non sono da considerare le interviste allo scopo solamente di raccogliere informazioni sul progetto.</small>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="admin_connection_yes" name="admin_connection" class="custom-control-input" value="1"  <?php echo (isset($data['admin_connection']) && $data['admin_connection'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_connection_yes">Si</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="admin_connection_no" name="admin_connection" class="custom-control-input" value="0"  <?php echo (isset($data['admin_connection']) && $data['admin_connection'] == 0 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_connection_no">No</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>In che modo le Pubbliche Amministrazioni hanno risposto alle tue sollecitazioni o ai problemi che hai sollevato?                    </label>
                    <small class="form-text text-muted">Non sono da considerare le interviste allo scopo solamente di raccogliere informazioni sul progetto.</small>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="admin_response_no" name="admin_response_no" <?php echo (isset($data['admin_response_no']) && $data['admin_response_no'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_response_no">Non ci hanno risposto</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="admin_response_some" name="admin_response_some" <?php echo (isset($data['admin_response_some']) && $data['admin_response_some'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_response_some">Abbiamo ottenuto solo risposte parziali</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="admin_response_formal" name="admin_response_formal" <?php echo (isset($data['admin_response_formal']) && $data['admin_response_formal'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_response_formal">Ci hanno dato risposte formali o generiche</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="admin_response_promises" name="admin_response_promises" <?php echo (isset($data['admin_response_promises']) && $data['admin_response_promises'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_response_promises">Almeno una tra quelle contattate ci ha fatto promesse concrete</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="admin_response_unlocked" name="admin_response_unlocked" <?php echo (isset($data['admin_response_unlocked']) && $data['admin_response_unlocked'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_response_unlocked">Hanno messo in pratica i nostri suggerimenti e il progetto ora è "sbloccato" o più efficace</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="admin_response_flagged" name="admin_response_flagged" <?php echo (isset($data['admin_response_flagged']) && $data['admin_response_flagged'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_response_flagged">Avevamo segnalato un problema che ora è stato risolto</label>
                    </div>

                    <div class="form-group">
                        <label class="" for="admin_altro">Altro</label>
                        <input class="form-control" type="text" id="admin_altro" name="admin_altro" value="<?php echo ckv($data, 'admin_altro'); ?>">

                    </div>
                </div>

                <div class="form-group">
                    <label for="impact_description">Descrivici il tuo caso. Quali fatti o episodi concreti ti portano a pensare che il tuo monitoraggio civico abbia avuto (o non abbia avuto) impatto tra i soggetti che gestiscono o attuano il progetto che hai monitorato?</label>
                    <textarea name="impact_description" id="impact_description" class="form-control"><?php echo ckv($data, 'impact_description'); ?></textarea>
                </div>

                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" value="<?php echo PENDING_REVIEW; ?>" id="status_tab_3" name="status_tab_3">
                    <label class="custom-control-label" for="status_tab_3">Questo step del report (Impatto & Risultati) è pronto per essere revisionato dalla Redazione</label>
                </div>

            </fieldset>
        </div>

          <!-- EOF Step 3 -->


      </div>






        <div class="form-group">
            <div class="alert alert-primary">Il tuo report è pronto <strong>(completo in step 1 e step 2)</strong>? Puoi inviarlo alla nostra Redazione!  Clicca sulla spunta, salva il report, aspetta alcuni giorni e controlla <strong>l’email che hai usato per registrarti</strong>: riceverai i nostri commenti e le istruzioni per effettuare eventuali correzioni.</div>
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
