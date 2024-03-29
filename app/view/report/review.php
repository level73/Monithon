<div class="container">
  <div class="row">
    <div class="col">

      <h1>
        Revisiona il Report<br />
        <small><?php echo $data->titolo; ?></small>
      </h1>


      <form class="" method="post" enctype="multipart/form-data" action="/report/review/<?php echo $data->idreport_basic; ?>">
      <input type="hidden" name="id" value="<?php echo $data->idreport_basic; ?>">

      <ul class="nav nav-tabs nav-fill" id="report-tablist" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="step-1-tab" data-toggle="tab" href="#step-1" role="tab" aria-controls="step-1" aria-selected="true">Step 1: Desk Analysis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="step-2-tab" data-toggle="tab" href="#step-2" role="tab" aria-controls="step-2" aria-selected="false">Step 2: Valutazione</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="step-3-tab" data-toggle="tab" href="#step-3" role="tab" aria-controls="step-3" aria-selected="false">Step 3: Risultati e Impatto</a>
        </li>
      </ul>



      <div class="tab-content" id="report-tab-content">
        <div class="tab-pane fade show active" id="step-1" role="tabpanel" aria-labelledby="step-1">
          <!-- Codice OpenCoesione -->
          <fieldset>
            <legend>Informazioni di Base</legend>
              <small class="form-text text-muted">Inserisci la URL per fare apparire MoniTutor</small>
              <div class="alert alert-danger alert-dismissible"><strong>Attenzione:</strong> Non accedere da più dispositivi contemporaneamente!</div>
              <br /><br /><br />
            <div class="form-group">
                <label for="oc_api_code">URL del progetto monitorato su OpenCoesione/OpenPNRR/Altro:</label>
                <div class="input-group">
                  <input type="text" name="id_open_coesione" id="oc_api_code" placeholder="URL del progetto..." class="form-control" value="<?php echo ckv_object($data, 'id_open_coesione'); ?>">
                  <div class="input-group-append">
                    <button class="btn btn-primary" id="oc_api_code_lookup" type="button"><i class="fal fa-search"></i></button>
                  </div>
                </div>
                <small class="form-text text-muted">Incolla qui l'indirizzo (URL) della pagina di OpenCoesione/OpenCUP/Altro dedicata al singolo progetto che hai scelto di monitorare. Esempio: https://opencoesione.gov.it/it/progetti/1ca1c272007it161po009/</small>

            </div>




              <div class="form-group">
                <label for="titolo">Titolo del progetto monitorato:</label>
                <div class="input-group">
                  <input type="text" name="titolo" id="titolo" class="form-control" value="<?php echo ckv_object($data, 'titolo'); ?>">
                  <div class="input-group-append">
                    <button class="btn btn-primary comment" data-field="titolo" id="comment[titolo]" type="button"><i class="fal fa-comment"></i></button>
                  </div>
                </div>
                <?php showComment($comments, 'titolo'); ?>
              </div>
              <div class="form-group">
                <label for="autore">Autore:</label>
                  <div class="input-group">
                    <input type="text" name="autore" id="autore" class="form-control" value="<?php echo ckv_object($data, 'autore'); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary comment" data-field="autore" id="comment[autore]" type="button"><i class="fal fa-comment"></i></button>
                    </div>
                  </div>
                  <?php showComment($comments, 'autore'); ?>
              </div>



              <?php /*
              <div class="form-group">
                <label for="descrizione">Descrizione del progetto monitorato:</label>
                  <div class="input-group">
                    <textarea name="descrizione" id="descrizione" class="form-control"><?php echo ckv_object($data, 'descrizione'); ?></textarea>
                    <div class="input-group-append">
                        <button class="btn btn-primary comment" data-field="descrizione" id="comment[descrizione]" type="button"><i class="fal fa-comment"></i></button>
                    </div>
                  </div>
                  <?php showComment($comments, 'descrizione'); ?>
              </div>


              <div class="form-group">
                <label for="parte_di_piano"><?php t('Il progetto fa parte di un piano di interventi più ampio? Se sì, qual è l’obiettivo complessivo di questo piano?'); ?></label>
                  <div class="input-group">
                      <textarea name="parte_di_piano" id="parte_di_piano" class="form-control"><?php echo ckv_object($data, 'parte_di_piano'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="parte_di_piano" id="comment[parte_di_piano]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <?php showComment($comments, 'parte_di_piano'); ?>
              </div>
            */ ?>

              <div class="form-group">
                  <label for="obiettivi">Obiettivi del progetto monitorato:</label>
                  <div class="input-group">
                    <textarea name="obiettivi" id="obiettivi" class="form-control"><?php echo ckv_object($data, 'obiettivi'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="obiettivi" id="comment[obiettivi]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <small class="form-text text-muted">Descrivi brevemente il progetto monitorato. Perché è importante? Quali sono i suoi obiettivi principali? Vedi qui i nostri <a href="https://www.monithon.eu/blog/2021/07/01/come-inviare-il-report-di-monitoraggio-tutti-i-nostri-suggerimenti/" target="_blank">consigli per la scrittura</a>.</small>
                      <?php showComment($comments, 'obiettivi'); ?>
              </div>

              <div class="form-group">

                  <label for="attivita">Attività previste dal progetto monitorato :</label>
                  <div class="input-group">
                  <textarea name="attivita" id="attivita" class="form-control"><?php echo ckv_object($data, 'attivita'); ?></textarea>

                  <div class="input-group-append">
                      <button class="btn btn-primary comment" data-field="attivita" id="comment[attivita]" type="button"><i class="fal fa-comment"></i></button>
                  </div>
              </div>
                  <small class="form-text text-muted">Quali sono le specifiche attività previste e quali tempi sono previsti?</small>
                  <?php showComment($comments, 'attivita'); ?>
              </div>

              <div class="form-group">
                  <label for="origine">Origine del progetto monitorato:</label>
                  <div class="input-group">
                  <textarea name="origine" id="origine" class="form-control"><?php echo ckv_object($data, 'origine'); ?></textarea>

                  <div class="input-group-append">
                      <button class="btn btn-primary comment" data-field="origine" id="comment[origine]" type="button"><i class="fal fa-comment"></i></button>
                  </div>
              </div>
                  <small class="form-text text-muted">Quali decisioni pubbliche e procedure amministrative hanno dato origine al progetto (es. quale atto amministrativo? quale bando pubblico)? Quali soggetti sono stati coinvolti nella definizione a monte del progetto e in che modo (es. organizzazione eventi di presentazione, momenti di consultazione pubblica, incontri di coprogettazione, ecc.)? Alcune tipologie di persone impattate dal progetto sono rimaste escluse dalla sua definizione?</small>
                  <?php showComment($comments, 'origine'); ?>
              </div>

              <div class="form-group">
                  <label for="soggetti_beneficiari">Beneficiari finali del progetto monitorato:</label>
                  <div class="input-group">
                  <textarea name="soggetti_beneficiari" id="soggetti_beneficiari" class="form-control"><?php echo ckv_object($data, 'soggetti_beneficiari'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="soggetti_beneficiari" id="comment[soggetti_beneficiari]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <small class="form-text text-muted">Quali soggetti possono trarre un vantaggio dagli esiti del progetto o subirne le conseguenze? Es. cittadinanza in generale, utenti di un servizio, gruppi di persone (donne, giovani, migranti). Alcune tipologie di persone rimangono escluse?</small>

                  <?php showComment($comments, 'soggetti_beneficiari'); ?>
              </div>

              <div class="form-group">
                  <label for="contesto">Il contesto in cui opera il progetto monitorato:</label>
                  <div class="input-group">
                  <textarea name="contesto" id="contesto" class="form-control"><?php echo ckv_object($data, 'contesto'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="contesto" id="comment[contesto]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <small class="form-text text-muted">Descrivi brevemente i bisogni del territorio in cui agisce il progetto e che giustificano il suo finanziamento. Menziona eventuali altri progetti simili o complementari, citando, se presenti, piani o strategie pubbliche locali di cui il progetto fa parte (es. Piano Urbano della Mobilità Sostenibile, Strategia per le Aree Interne, etc.)</small>

                  <?php showComment($comments, 'contesto'); ?>
              </div>





              <!-- Mappa -->
              <div class="form-group">
                <label for="indirizzo">Luogo di riferimento del progetto monitorato: </label>
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

            </fieldset>



            <fieldset class="gender-equality-box">
                <h3>Parità di Genere</h3>

                <div class="form-group">
                    <label for="gender-objectives">
                        Nel progetto è coinvolta direttamente o indirettamente la parità di genere?
                        <div><div class=""><button class="btn btn-primary comment" data-field="gender_objectives" id="comment[gender_objectives]" type="button"><i class="fal fa-comment"></i></button></div></div>
                    </label>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_objectives_yes_direct" name="gender_objectives" class="trigger-desc check-eval custom-control-input" data-group="go" data-target="#goydd" value="1" <?php echo (isset($data->gender_objectives) && $data->gender_objectives ==  1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_objectives_yes_direct">Si, impatto di genere <em>diretto</em> (ad es. progetti che hanno le donne esplicitamente come destinatarie) </label>
                    </div>
                    <div class="form-group <?php echo ($data->gender_objectives == 1 ? '' : 'd-none'); ?> trigger-desc-wrapper" id="goydd">
                        <label>Aggiungi una descrizione</label>
                        <textarea id="gender_objectives_yes_direct_desc" name="gender_objectives_yes_direct_desc"  class="form-control"><?php echo ckv_object($data, 'gender_objectives_yes_direct_desc'); ?></textarea>
                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_objectives_yes_indirect" name="gender_objectives" class="trigger-desc check-eval custom-control-input" data-group="go" data-target="#goyid" value="2" <?php echo (isset($data->gender_objectives) && $data->gender_objectives ==  2 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_objectives_yes_indirect">Si, impatto di genere <em>indiretto</em> (ad es. le spese relative a interventi di sostegno verso persone anziane, non autosufficienti, con disabilità o minori ecc., la cui cura è largamente sostenuta dalle donne)</label>
                    </div>
                    <div class="form-group <?php echo ($data->gender_objectives == 2 ? '' : 'd-none'); ?> trigger-desc-wrapper" id="goyid">
                        <label>Aggiungi una descrizione</label>
                        <textarea id="gender_objectives_yes_indirect_desc" name="gender_objectives_yes_indirect_desc"  class="form-control"><?php echo ckv_object($data, 'gender_objectives_yes_indirect_desc'); ?></textarea>
                    </div>


                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_objectives_no" name="gender_objectives" class="trigger-desc check-eval custom-control-input"  data-group="go" value="3" <?php echo (isset($data->gender_objectives) && $data->gender_objectives ==  3 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_objectives_no">No</label>
                    </div>
                    <?php showComment($comments, 'gender_objectives'); ?>
                </div>

                <div class="form-group">
                    <label>
                        Nel progetto i partecipanti (a volte chiamati beneficiari) sono distinti per genere (donne, uomini, altri), utilizzando - per esempio - parole come donne, bambine, anziane, studentesse, lavoratrici, etc.
                        <div><div class=""><button class="btn btn-primary comment" data-field="gender_language" id="comment[gender_language]" type="button"><i class="fal fa-comment"></i></button></div></div>
                    </label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_language_yes" name="gender_language" class="custom-control-input" value="1" <?php echo (isset($data->gender_language) && $data->gender_language ==  1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_language_yes">Si</label>
                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_language_no" name="gender_language" class="custom-control-input" value="2" <?php echo (isset($data->gender_language) && $data->gender_language ==  2 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_language_no">No</label>
                    </div>
                    <?php showComment($comments, 'gender_language'); ?>
                </div>

                <div class="form-group">
                    <label>
                        Il progetto stanzia risorse finanziarie esplicitamente destinate ad azioni che promuovono la parità di genere?
                        <div><div class=""><button class="btn btn-primary comment" data-field="gender_finance" id="comment[gender_finance]" type="button"><i class="fal fa-comment"></i></button></div></div>
                    </label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_finance_yes" name="gender_finance" class="trigger-desc custom-control-input" data-group="gf" data-target="#gfy" value="1" <?php echo (isset($data->gender_finance) && $data->gender_finance ==  1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_finance_yes">Si</label>
                    </div>

                    <div class="form-group <?php echo ($data->gender_finance != 1 ? 'd-none' : ''); ?> trigger-desc-wrapper" id="gfy">
                        <label>In che percentuale rispetto al budget totale?</label>
                        <input id="gender_finance_desc" name="gender_finance_desc"  class="form-control" value="<?php echo ckv_object($data, 'gender_finance_desc'); ?>" />
                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_finance_no" name="gender_finance" class="trigger-desc custom-control-input"  data-group="gf"  value="2" <?php echo (isset($data->gender_finance) && $data->gender_finance ==  2 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_finance_no">No</label>
                    </div>
                    <?php showComment($comments, 'gender_finance'); ?>
                </div>

                <div class="form-group">
                    <label>
                        Sono stati indicati esplicitamente indicatori (es. numero di operatrici formate o percentuale di aumento delle studentesse iscritte a corsi STEM) per monitorare e valutare l’impatto del progetto in termini di promozione della parità di genere?
                        <div><div class=""><button class="btn btn-primary comment" data-field="gender_indicators" id="comment[gender_indicators]" type="button"><i class="fal fa-comment"></i></button></div></div>
                    </label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_indicators_yes" name="gender_indicators" class="trigger-desc custom-control-input" data-group="gi" data-target="#giy" value="1" <?php echo (isset($data->gender_indicators) && $data->gender_indicators ==  1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_indicators_yes">Si</label>
                    </div>

                    <div class="form-group <?php echo ($data->gender_indicators != 1 ? 'd-none' : ''); ?> trigger-desc-wrapper" id="giy">
                        <label>Quali indicatori?</label>
                        <input id="gender_indicators_desc" name="gender_indicators_desc"  class="form-control" value="<?php echo ckv_object($data, 'gender_indicators_desc'); ?>" />
                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="gender_indicators_no" name="gender_indicators" class="trigger-desc custom-control-input"  data-group="gi"  value="2" <?php echo (isset($data->gender_indicators) && $data->gender_indicators ==  2 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="gender_indicators_no">No</label>
                    </div>
                    <?php showComment($comments, 'gender_indicators'); ?>
                </div>

            </fieldset>

          </div>

        <div class="tab-pane fade" id="step-2" role="tabpanel" aria-labelledby="step-2">
          <div class="d-none" id="oc_api_content_s2">
            <i class="fal fa-sync fa-spin"></i>
          </div>
            <fieldset>
              <legend>Valutazione </legend>

                <div class="form-group">
                    <label>Stato di avanzamento del progetto monitorato:</label>
                    <div class="input-group-append">
                        <button class="btn btn-primary comment" data-field="stato_di_avanzamento" id="comment[stato_di_avanzamento]" type="button"><i class="fal fa-comment"></i></button>
                    </div>

                    <small class="form-text text-muted">Indipendentemente dalle tempistiche dichiarate, qual è il reale avanzamento del progetto monitorato?</small>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sda_1" name="stato_di_avanzamento" class="check-eval custom-control-input" value="1"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sda_1">Appena avviato <small>Il progetto è stato appena selezionato o è nelle fasi preliminari di realizzazione (es. progettazione preliminare)</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sda_2" name="stato_di_avanzamento" class="check-eval custom-control-input " value="2"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 2 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sda_2">Mai partito <small>Il progetto è stato selezionato da almeno un anno ma non è mai stato avviato e risulta quindi bloccato all’avvio</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sda_3" name="stato_di_avanzamento" class=" check-eval custom-control-input" value="3"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 3 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sda_3">In corso senza particolari intoppi <small>Il progetto è in corso di realizzazione (es. il cantiere è aperto) e segue le tappe prefissate; i ritardi sono limitati</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sda_4" name="stato_di_avanzamento" class="check-eval custom-control-input" value="4"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 4 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sda_4">In corso con problemi di realizzazione <small>Il progetto è in corso di realizzazione ma presenta problemi sostanziali (amministrativi, tecnici, etc.) oppure ritardi significativi</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sda_5" name="stato_di_avanzamento" class="check-eval custom-control-input" value="5"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 5 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sda_5">Bloccato <small>Il progetto è fermo da almeno un anno per problemi in fase di realizzazione</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sda_6" name="stato_di_avanzamento" class="check-eval custom-control-input" value="6"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 6 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sda_6">Concluso <small>Tutte le attività sono state completate</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sda_7" name="stato_di_avanzamento" class="check-eval custom-control-input" value="7"  <?php echo (isset($data->stato_di_avanzamento) && $data->stato_di_avanzamento == 7 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sda_7">Non è stato possibile verificare l’avanzamento <small>Le informazioni disponibili non sono sufficienti</small></label>
                    </div>

                    <?php showComment($comments, 'stato_di_avanzamento'); ?>
                </div>

                <div class="form-group <?php echo ($data->cup_descr_natura == 'REALIZZAZIONE DI LAVORI PUBBLICI (OPERE ED IMPIANTISTICA)' ? '' : 'd-none'); ?>" id="sda_infrastrutturale">
                    <input type="hidden" name="cup_descr_natura" id="cup_descr_natura" value="<?php echo $data->cup_descr_natura; ?>">
                    <label>Stato avanzamento lavori:</label>
                    <div class="input-group-append">
                        <button class="btn btn-primary comment" data-field="stato_di_avanzamento_infrastrutturale" id="comment[stato_di_avanzamento_infrastrutturale]" type="button"><i class="fal fa-comment"></i></button>
                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="sdai_1" name="stato_di_avanzamento_infrastrutturale" class="check-eval custom-control-input" value="1"  <?php echo (isset($data->stato_di_avanzamento_infrastrutturale) && $data->stato_di_avanzamento_infrastrutturale == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sdai_1">Non avviato</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sdai_2" name="stato_di_avanzamento_infrastrutturale" class="check-eval custom-control-input" value="2"  <?php echo (isset($data->stato_di_avanzamento_infrastrutturale) && $data->stato_di_avanzamento_infrastrutturale == 2 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sdai_2">In avvio di progettazione <small>Studio di fattibilità</small></label>
                    </div>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="sdai_3" name="stato_di_avanzamento_infrastrutturale" class="check-eval custom-control-input" value="3"  <?php echo (isset($data->stato_di_avanzamento_infrastrutturale) && $data->stato_di_avanzamento_infrastrutturale == 3 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sdai_3">In corso di progettazione <small>Progettazione esecutiva</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sdai_4" name="stato_di_avanzamento_infrastrutturale" class="check-eval custom-control-input" value="4"  <?php echo (isset($data->stato_di_avanzamento_infrastrutturale) && $data->stato_di_avanzamento_infrastrutturale == 4 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sdai_4">In affidamento <small>Affidamento gara in corso</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sdai_5" name="stato_di_avanzamento_infrastrutturale" class="check-eval custom-control-input" value="5"  <?php echo (isset($data->stato_di_avanzamento_infrastrutturale) && $data->stato_di_avanzamento_infrastrutturale == 5 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sdai_5">In esecuzione <small>Lavori iniziati</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="sdai_6" name="stato_di_avanzamento_infrastrutturale" class="check-eval custom-control-input" value="6"  <?php echo (isset($data->stato_di_avanzamento_infrastrutturale) && $data->stato_di_avanzamento_infrastrutturale == 6 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="sdai_6">Eseguito <small>Conclusa la fase di esecuzione</small></label>
                    </div>
                    <?php showComment($comments, 'stato_di_avanzamento_infrastrutturale'); ?>
                </div>


              <div class="form-group">
                  <label for="avanzamento">Descrizione dello stato di avanzamento del progetto monitorato:</label>
                  <small clasS="form-text text-muted">Descrivi lo stato del progetto sulla base delle informazioni raccolte, specificando la fonte delle informazioni (es. quali documenti, quali interviste, visita di monitoraggio).</small>
                <div class="input-group">
                <textarea name="avanzamento" id="avanzamento" class="form-control"><?php echo ckv_object($data, 'avanzamento'); ?></textarea>
                  <div class="input-group-append">
                      <button class="btn btn-primary comment" data-field="avanzamento" id="comment[avanzamento]" type="button"><i class="fal fa-comment"></i></button>
                  </div>
                </div>
                <?php showComment($comments, 'avanzamento'); ?>
              </div>

                <!-- Giudizio Sintetico -->
                <div class="form-group">
                    <label for="gs">Giudizio di efficacia (anche potenziale) sul progetto monitorato: </label>
                    <div class="input-group-append">
                        <button class="btn btn-primary comment" data-field="gs" id="comment[gs]" type="button"><i class="fal fa-comment"></i></button>
                    </div>
                    <small class="form-text form-muted">Come giudichi l’efficacia del progetto monitorato?</small>

                    <div class="custom-control custom-radio">
                        <input type="radio" id="giudizio_sintetico_1" name="gs" class="check-eval custom-control-input" value="1"  <?php echo (isset($data->gs) && $data->gs == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label gsl" for="giudizio_sintetico_1"></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="giudizio_sintetico_2" name="gs" class="custom-control-input check-eval" value="2"  <?php echo (isset($data->gs) && $data->gs == 2 ? 'checked' : ''); ?>>
                        <label class="custom-control-label gsl" for="giudizio_sintetico_2"></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="giudizio_sintetico_3" name="gs" class="custom-control-input check-eval" value="3"  <?php echo (isset($data->gs) && $data->gs == 3 ? 'checked' : ''); ?>>
                        <label class="custom-control-label gsl" for="giudizio_sintetico_3"></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="giudizio_sintetico_4" name="gs" class="check-eval custom-control-input" value="4"  <?php echo (isset($data->gs) && $data->gs == 4 ? 'checked' : ''); ?>>
                        <label class="custom-control-label gsl" for="giudizio_sintetico_4"></label>
                    </div>
                    <?php showComment($comments, 'gs'); ?>
                </div>


              <div class="form-group">
                  <label for="risultato_progetto">Risultato del progetto monitorato (se il progetto è concluso, quali risultati ha avuto?):</label>
                  <small class="text-muted form-text">Descrivi più in dettaglio i risultati ottenuti del progetto. Concentrati in particolare sull’utilità ed efficacia dei risultati, dal tuo punto di vista. Se il progetto è ancora in corso, prova a descrivere, se possibile, i suoi risultati parziali. Cita sempre le fonti delle tue affermazioni (es. documenti, visita di monitoragggio, interviste, etc.)</small>
                  <div class="input-group">
                <textarea name="risultato_progetto" id="risultato_progetto" class="form-control"><?php echo ckv_object($data, 'risultato_progetto'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="risultato_progetto" id="comment[risultato_progetto]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <?php showComment($comments, 'risultato_progetto'); ?>
              </div>



                <div class="form-group <?php echo ($data->gs == 1 ? 'd-none' : ''); ?>" id="cause_inefficacia_wrapper">
                    <label>Quali sono i problemi che hai rilevato?</label>
                    <div class="input-group-append">
                        <button class="btn btn-primary comment" data-field="cause_inefficacia" id="comment[cause_inefficacia]" type="button"><i class="fal fa-comment"></i></button>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="0" id="problemi_amministrativi_null" name="problemi_amministrativi">
                        <input class="custom-control-input" type="checkbox" value="1" id="problemi_amministrativi" name="problemi_amministrativi" <?php echo (isset($data->problemi_amministrativi) && $data->problemi_amministrativi == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="problemi_amministrativi">Realizzazione ha mostrato problemi di natura amministrativa</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="0" id="problemi_tecnici_null" name="problemi_tecnici">
                        <input class="custom-control-input" type="checkbox" value="1" id="problemi_tecnici" name="problemi_tecnici" <?php echo (isset($data->problemi_tecnici) && $data->problemi_tecnici == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="problemi_tecnici">Realizzazione ha mostrato problemi di natura tecnica</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="0" id="risultato_insoddisfacente_null" name="risultato_insoddisfacente">
                        <input class="custom-control-input" type="checkbox" value="1" id="risultato_insoddisfacente" name="risultato_insoddisfacente" <?php echo (isset($data->risultato_insoddisfacente) && $data->risultato_insoddisfacente == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="risultato_insoddisfacente">Il risultato del progetto non è soddisfacente</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="0" id="non_efficace_null" name="non_efficace">
                        <input class="custom-control-input" type="checkbox" value="1" id="non_efficace" name="non_efficace" <?php echo (isset($data->non_efficace) && $data->non_efficace == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="non_efficace">Intervento complessivamente ben realizzato ma non rispondente ai bisogni degli utenti finali (non efficace)</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="0" id="non_sufficiente_null" name="non_sufficiente">
                        <input class="custom-control-input" type="checkbox" value="1" id="non_sufficiente" name="non_sufficiente" <?php echo (isset($data->non_sufficiente) && $data->non_sufficiente == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="non_sufficiente">Intervento utile ma non sufficiente per rispondere al fabbisogno (“ne serve di più”, es. più investimenti nello stesso progetto o in progetti simili)</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="0" id="necessita_interventi_extra_null" name="necessita_interventi_extra">
                        <input class="custom-control-input" type="checkbox" value="1" id="necessita_interventi_extra" name="necessita_interventi_extra" <?php echo (isset($data->necessita_interventi_extra) && $data->necessita_interventi_extra == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="necessita_interventi_extra">Intervento di per sè utile ma sono necessari altri interventi complementari</label>
                    </div>
                    <?php showComment($comments, 'cause_inefficacia'); ?>
                </div>




               <?php /*
              <div class="form-group">
                <label for="valutazione_risultati">
                    <?php t('Se il progetto è concluso o sei stato comunque in grado di valutare alcuni dei suoi risultati qual è il tuo giudizio sull’efficacia del progetto che hai monitorato?'); ?>
                    <div><div class=""><button class="btn btn-primary comment" data-field="valutazione_risultati" id="comment[valutazione_risultati]" type="button"><i class="fal fa-comment"></i></button></div></div>
                </label>
                <div class="custom-control custom-radio">
                  <input type="radio" id="valutazione_risultati_1" name="valutazione_risultati" class="check-eval custom-control-input" value="1"  <?php echo (isset($data->valutazione_risultati) && $data->valutazione_risultati == 1 ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="valutazione_risultati_1">Intervento dannoso - Era meglio non farlo perché ha provocato conseguenze negative </label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="valutazione_risultati_2" name="valutazione_risultati" class="check-eval custom-control-input" value="2" <?php echo (isset($data->valutazione_risultati) && $data->valutazione_risultati ==  2 ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="valutazione_risultati_2">Intervento inutile - Non ha cambiato la situazione, soldi sprecati</label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="valutazione_risultati_3" name="valutazione_risultati" class="check-eval custom-control-input" value="3"  <?php echo (isset($data->valutazione_risultati) && $data->valutazione_risultati ==  3 ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="valutazione_risultati_3">Intervento utile ma presenta problemi - Ha avuto alcuni risultati positivi ed è tutto sommato utile, anche se presenta anche aspetti negativi</label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="valutazione_risultati_4" name="valutazione_risultati" class="check-eval custom-control-input" value="4"  <?php echo (isset($data->valutazione_risultati) && $data->valutazione_risultati ==  4 ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="valutazione_risultati_4">Intervento molto utile ed efficace - Gli aspetti positivi prevalgono ed è giudicato complessivamente efficace dal punto di vista dell'utente finale </label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="valutazione_risultati_5" name="valutazione_risultati" class="check-eval custom-control-input" value="5"  <?php echo (isset($data->valutazione_risultati) && $data->valutazione_risultati ==  5 ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="valutazione_risultati_5">Non è stato possibile valutare l’efficacia dell’intervento - Es. il progetto non ha ancora prodotto risultati valutabili </label>
                </div>
                  <?php showComment($comments, 'valutazione_risultati'); ?>
              </div>
                */ ?>

              <div class="form-group">
                <label for="punti_di_forza">Punti di forza (cosa ti è piaciuto del progetto monitorato?):</label>
                  <div class="input-group">
                <textarea name="punti_di_forza" id="punti_di_forza" class="form-control"><?php echo ckv_object($data, 'punti_di_forza'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="punti_di_forza" id="comment[punti_di_forza]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <?php showComment($comments, 'punti_di_forza'); ?>
              </div>


              <div class="form-group">
                <label for="punti_deboli">Debolezze (difficoltà riscontrate nell'attuazione/realizzazione del progetto monitorato?):</label>
                  <div class="input-group">
                <textarea name="punti_deboli" id="punti_deboli" class="form-control"><?php echo ckv_object($data, 'punti_deboli'); ?></textarea>
                  <div class="input-group-append">
                      <button class="btn btn-primary comment" data-field="punti_deboli" id="comment[punti_deboli]" type="button"><i class="fal fa-comment"></i></button>
                  </div>
              </div>
                <?php showComment($comments, 'punti_deboli'); ?>
              </div>


              <div class="form-group">
                <label for="rischi">Rischi futuri per il progetto monitorato:</label>
                  <div class="input-group">
                <textarea name="rischi" id="rischi" class="form-control"><?php echo ckv_object($data, 'rischi'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="rischi" id="comment[rischi]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <?php showComment($comments, 'rischi'); ?>
              </div>


              <div class="form-group">
                <label for="soluzioni_progetto">Soluzioni ed idee da proporre per il progetto monitorato:</label>
                  <div class="input-group">
                <textarea name="soluzioni_progetto" id="soluzioni_progetto" class="form-control"><?php echo ckv_object($data, 'soluzioni_progetto'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="soluzioni_progetto" id="comment[soluzioni_progetto]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <?php showComment($comments, 'soluzioni_progetto'); ?>
              </div>

              <?php /*
              <!-- Giudizio Sintetico -->
              <div class="form-group">
                <label for="giudizio_sintetico">
                    Giudizio Sintetico sul Progetto monitorato:
                    <div><div class=""><button class="btn btn-primary comment" data-field="giudizio_sintetico" id="comment[giudizio_sintetico]" type="button"><i class="fal fa-comment"></i></button></div></div>

                </label>
                <div class="custom-control custom-radio">
                  <input type="radio" id="giudizio_sintetico_1" name="giudizio_sintetico" class="custom-control-input" value="1"  <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico == 'Appena iniziato' ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="giudizio_sintetico_1">Appena iniziato <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è iniziato da troppo poco tempo per poter esprimere un giudizio. Si sa che è stato avviato, anche se i risultati non sono ancora visibili e monitorabili."></i></label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="giudizio_sintetico_2" name="giudizio_sintetico" class="custom-control-input" value="2" <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico ==  'In corso e procede bene' ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="giudizio_sintetico_2">In corso e procede bene <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è avviato e, tutto sommato, i risultati parziali sembrano positivi. Tutte (o almeno la maggior parte) delle attività avviate sembrano procedere nella direzione pianificata."></i></label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="giudizio_sintetico_3" name="giudizio_sintetico" class="custom-control-input" value="3"  <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico ==  'Procede con difficoltà' ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="giudizio_sintetico_3">Procede con difficoltà <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è stato avviato, ma ci sono problemi rilevanti nella sua attuazione (es. ritardi significativi, alcune attività ferme o alcune differenze significative rispetto a quanto preventivato)."></i></label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="giudizio_sintetico_4" name="giudizio_sintetico" class="custom-control-input" value="4"  <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico ==  'Bloccato' ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="giudizio_sintetico_4">Bloccato <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato non procede. Può essere bloccato all'inizio (mai avviato) o in una fase successiva."></i></label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="giudizio_sintetico_5" name="giudizio_sintetico" class="custom-control-input" value="5"  <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico ==  'Concluso e utile' ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="giudizio_sintetico_5">Concluso e utile <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è finito ed è ritenuto complessivamente efficace dal punto di vista dell'utilizzatore finale."></i></label>
                </div>

                <div class="custom-control custom-radio">
                  <input type="radio" id="giudizio_sintetico_6" name="giudizio_sintetico" class="custom-control-input" value="6"  <?php echo (isset($data->giudizio_sintetico) && $data->giudizio_sintetico ==  'Concluso e inefficace' ? 'checked' : ''); ?>>
                  <label class="custom-control-label" for="giudizio_sintetico_6">Concluso e inefficace <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è finito ma è ritenuto complessivamente inefficace (es. mancano altri interventi complementari, il progetto è concluso ma non è entrato in funzione, oppure non è funzionale, è obsoleto o comunque non rispondente ai bisogni dell'utenza)."></i></label>
                </div>
                  <?php showComment($comments, 'giudizio_sintetico'); ?>
              </div>
               */ ?>
            </fieldset>

            <fieldset>
              <legend>Metodi di Indagine</legend>
              <!-- Raccolta Info -->
              <div class="form-group">
                <label for="">
                    Raccolta Informazioni
                    <div><div class=""><button class="btn btn-primary comment" data-field="raccolta_informazioni" id="comment[raccolta_informazioni]" type="button"><i class="fal fa-comment"></i></button></div></div>
                </label>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="hidden" value="0" id="raccolta_info_web_null" name="raccolta_info_web">
                      <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_web" name="raccolta_info_web" <?php echo (isset($data->raccolta_info_web) && $data->raccolta_info_web == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="raccolta_info_web">Raccolta di informazioni via web</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="hidden" value="0" id="visita_diretta_null" name="visita_diretta">
                      <input class="custom-control-input" type="checkbox" value="1" id="visita_diretta" name="visita_diretta" <?php echo (isset($data->visita_diretta) && $data->visita_diretta == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="visita_diretta">Visita diretta documentata da foto e video</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="hidden" value="0" id="intervista_autorita_gestione_null" name="intervista_autorita_gestione">
                      <input class="custom-control-input" type="checkbox" value="1" id="intervista_autorita_gestione" name="intervista_autorita_gestione" <?php echo (isset($data->intervista_autorita_gestione) && $data->intervista_autorita_gestione == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="intervista_autorita_gestione">Intervista con l'Autorità di Gestione del Programma</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="hidden" value="0" id="intervista_soggetto_programmatore_null" name="intervista_soggetto_programmatore">
                      <input class="custom-control-input" type="checkbox" value="1" id="intervista_soggetto_programmatore" name="intervista_soggetto_programmatore" <?php echo (isset($data->intervista_soggetto_programmatore) && $data->intervista_soggetto_programmatore == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="intervista_soggetto_programmatore">Intervista con i soggetti che hanno programmato l'intervento (soggetto programmatore)</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="hidden" value="0" id="intervista_utenti_beneficiari_null" name="intervista_utenti_beneficiari">
                      <input class="custom-control-input" type="checkbox" value="1" id="intervista_utenti_beneficiari" name="intervista_utenti_beneficiari" <?php echo (isset($data->intervista_utenti_beneficiari) && $data->intervista_utenti_beneficiari == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="intervista_utenti_beneficiari">Intervista con gli utenti/beneficiari dell'intervento</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="hidden" value="0" id="intervista_altri_utenti_null" name="intervista_altri_utenti">
                      <input class="custom-control-input" type="checkbox" value="1" id="intervista_altri_utenti" name="intervista_altri_utenti" <?php echo (isset($data->intervista_altri_utenti) && $data->intervista_altri_utenti == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="intervista_altri_utenti">Intervista con altre tipologie di persone</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="hidden" value="0" id="raccolta_info_attuatore_null" name="raccolta_info_attuatore">
                      <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_attuatore" name="raccolta_info_attuatore" <?php echo (isset($data->raccolta_info_attuatore) && $data->raccolta_info_attuatore == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="raccolta_info_attuatore">Intervista con i soggetti che hanno o stanno attuando l'intervento (attuatore o realizzatore)</label>
                  </div>
                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="hidden" value="0" id="referenti_politici_null" name="referenti_politici">
                      <input class="custom-control-input" type="checkbox" value="1" id="referenti_politici" name="referenti_politici" <?php echo (isset($data->referenti_politici) && $data->referenti_politici == 1 ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="referenti_politici">Intervista con i referenti politici</label>
                  </div>

                  <?php showComment($comments, 'raccolta_informazioni'); ?>
              </div>

                <div class="form-group">
                    <label>
                        Facilità di accesso alle informazioni pubbliche
                        <div><div class=""><button class="btn btn-primary comment" data-field="facilita_accesso_informazioni" id="comment[facilita_accesso_informazioni]" type="button"><i class="fal fa-comment"></i></button></div></div>
                    </label>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="faip_1" name="facilita_accesso_informazioni" class=" custom-control-input" value="1"  <?php echo (isset($data->facilita_accesso_informazioni) && $data->facilita_accesso_informazioni == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="faip_1">Facile <small>(es. ho trovato tutte le informazioni di cui avevo bisogno sui siti ufficiali delle amministrazioni; le amministrazioni contattate mi hanno risposto rapidamente e sono state disponibili a farsi intervistare)</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="faip_2" name="facilita_accesso_informazioni" class=" custom-control-input" value="2"  <?php echo (isset($data->facilita_accesso_informazioni) && $data->facilita_accesso_informazioni == 2 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="faip_2">Con qualche difficiltà <small>(es. ho trovato alcune delle informazioni di cui avevo bisogno sui siti ufficiali delle amministrazioni, ma ho dovuto richiedere alcune informazioni o documenti ai soggetti coinvolti; non tutte le amministrazioni contattate mi hanno risposto rapidamente o non hanno risposto)</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="faip_3" name="facilita_accesso_informazioni" class=" custom-control-input" value="3"  <?php echo (isset($data->facilita_accesso_informazioni) && $data->facilita_accesso_informazioni == 3 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="faip_3">Difficoltoso <small>(es. ho trovato poche informazioni sui siti ufficiali delle amministrazioni; ho dovuto richiedere alle amministrazioni i documenti progettuali che mi servivano; è stato difficoltoso mettersi in contatto con le amministrazioni e avere disponibilità per interviste)</small></label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="faip_4" name="facilita_accesso_informazioni" class=" custom-control-input" value="4"  <?php echo (isset($data->facilita_accesso_informazioni) && $data->facilita_accesso_informazioni == 4 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="faip_4">Impossibile <small>(es. non ho trovato nessun documento disponibile in rete, le amministrazioni contattate non hanno risposto alle mie richieste, non sono riuscito a intervistare nessuno)</small></label>
                    </div>

                    <?php showComment($comments, 'facilita_accesso_informazioni'); ?>
                </div>


              <div class="form-group">
                <label for="intervista_intervistati">Chi è stato intervistato? Che ruolo ha la persona nel progetto? (es. gestore, funzionario comunale, cittadino informato…):</label>
                  <div class="input-group">
                  <textarea name="intervista_intervistati" id="intervista_intervistati" class="form-control"><?php echo ckv_object($data, 'intervista_intervistati'); ?></textarea>
                      <div class="input-group-append">
                          <button class="btn btn-primary comment" data-field="intervista_intervistati" id="comment[intervista_intervistati]" type="button"><i class="fal fa-comment"></i></button>
                      </div>
                  </div>
                  <?php showComment($comments, 'intervista_intervistati'); ?>
                <span class="form-text text-muted">Riportare i ruoli di tutte le persone intervistate</span>
              </div>

              <div class="form-group">
                <label for="intervista_domande">Principali due domande poste agli intervistati (specificare quali):</label>
                  <div class="input-group">
                <textarea name="intervista_domande" id="intervista_domande" class="form-control"><?php echo ckv_object($data, 'intervista_domande'); ?></textarea>
                  <div class="input-group-append">
                      <button class="btn btn-primary comment" data-field="intervista_domande" id="comment[intervista_domande]" type="button"><i class="fal fa-comment"></i></button>
                  </div>
              </div>
                <?php showComment($comments, 'intervista_domande'); ?>
              </div>

              <div class="form-group">
                <label for="intervista_risposte">Principali due risposte degli intervistati:</label>
                  <div class="input-group">
                  <textarea name="intervista_risposte" id="intervista_risposte" class="form-control"><?php echo ckv_object($data, 'intervista_risposte'); ?></textarea>
                  <div class="input-group-append">
                      <button class="btn btn-primary comment" data-field="intervista_risposte" id="comment[intervista_risposte]" type="button"><i class="fal fa-comment"></i></button>
                  </div>
              </div>
          <?php showComment($comments, 'intervista_risposte'); ?>
              </div>

            </fieldset>



            <fieldset>
              <legend>Link, Video, Allegati</legend>

              <div class="form-group">
                  <div class="input-group-append">
                      <button class="btn btn-primary comment" data-field="attachments" id="comment[attachments]" type="button"><i class="fal fa-comment"></i></button>
                  </div>
                <label>Carica immagini, documenti, etc.</label>
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
                      <button class="btn btn-sm btn-block btn-danger ajx-delete-repo" type="button" data-type="file" data-id="<?php echo $file->idfile_repository; ?>"><i class="fal fa-times"></i> Rimuovi Risorsa</button>
                  </div>


                <?php } ?>
              </div>

              <div class="form-group">
                <label>Aggiungi link alla documentazione ed alle fonti</label>
                <div class="link-grouper origin">
                  <input type="text" class="form-control" id="link-attachment[0]" name="link-attachment[0]" placeholder="Inserisci URL della fonte...">
                </div>

                <button type="button" class="btn btn-secondary btn-sm link-duplicator" data-duplicate=".link-grouper"><i class="fal fa-plus"></i> Aggiungi altri link alle fonti</button>
              </div>
              <div class="files">
                <h3>Link Caricati</h3>
                <ul class="links">
                <?php foreach($data->links as $l){ ?>
                  <li><a href="<?php echo $l->URL; ?>"><?php echo $l->URL; ?></a> <button class="btn btn-sm btn-danger ajx-delete-repo" type="button" data-type="link" data-id="<?php echo $l->idlink_repository; ?>"><i class="fal fa-times"></i></button></li>
                <?php } ?>
                </ul>
              </div>

              <div class="form-group">
                <label>Aggiungi link a Video (youtube, vimeo)</label>
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
                      <button class="btn btn-sm btn-block btn-danger ajx-delete-repo" type="button" data-type="video" data-id="<?php echo $v->idvideo_repository; ?>"><i class="fal fa-times"></i> Rimuovi Video</button>
                  </div>
                <?php } ?>
                </ul>
              </div>
                <?php showComment($comments, 'attachments'); ?>
            </fieldset>
            <button id="tab-3-nav" class="tab-subnav btn btn-primary btn-lg btn-block" data-step="#step-3" type="button">VAI ALLO STEP 3: RISULTATI E IMPATTO</button><br /><br />
        </div>

          <div class="tab-pane fade" id="step-3" role="tabpanel" aria-labelledby="step-3">
              <fieldset>
                  <legend>Le nuove connessioni che avete generato</legend>
                  <div class="form-group">
                      <label for="nuove-connessioni">
                          Come avete diffuso o state diffondendo i risultati del vostro monitoraggio civico?
                          <div><div class=""><button class="btn btn-primary comment" data-field="diffusione" id="comment[diffusione]" type="button"><i class="fal fa-comment"></i></button></div></div>
                      </label>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_twitter_null" name="diffusione_twitter">
                          <input class="custom-control-input" type="checkbox" value="1" id="diffusione_twitter" name="diffusione_twitter" <?php echo (isset($data->diffusione_twitter) && $data->diffusione_twitter == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="diffusione_twitter">Twitter</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_facebook_null" name="diffusione_facebook">
                          <input class="custom-control-input" type="checkbox" value="1" id="diffusione_facebook" name="diffusione_facebook" <?php echo (isset($data->diffusione_facebook) && $data->diffusione_facebook == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="diffusione_facebook">Facebook</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_instagram_null" name="diffusione_instagram">
                          <input class="custom-control-input" type="checkbox" value="1" id="diffusione_instagram" name="diffusione_instagram" <?php echo (isset($data->diffusione_instagram) && $data->diffusione_instagram == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="diffusione_instagram">Instagram</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_eventi_null" name="diffusione_eventi">
                          <input class="custom-control-input" type="checkbox" value="1" id="diffusione_eventi" name="diffusione_eventi" <?php echo (isset($data->diffusione_eventi) && $data->diffusione_eventi == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="diffusione_eventi">Eventi territoriali organizzati dai team</label>
                      </div>


                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_open_admin_null" name="diffusione_open_admin">
                          <input class="custom-control-input" type="checkbox" value="1" id="diffusione_open_admin" name="diffusione_open_admin" <?php echo (isset($data->diffusione_open_admin) && $data->diffusione_open_admin == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="diffusione_open_admin">Settimana dell'Amministrazione Aperta</label>
                      </div>


                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_blog_null" name="diffusione_blog">
                          <input class="custom-control-input" type="checkbox" value="1" id="diffusione_blog" name="diffusione_blog" <?php echo (isset($data->diffusione_blog) && $data->diffusione_blog == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="diffusione_blog">Blog/Sito web del Team</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_offline_null" name="diffusione_offline">
                          <input class="custom-control-input" type="checkbox" value="1" id="diffusione_offline" name="diffusione_offline" <?php echo (isset($data->diffusione_offline) && $data->diffusione_offline == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="diffusione_offline">Volantinaggio o altri metodi off-line (non via Internet)</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_incontri_null" name="diffusione_incontri">
                          <input class="custom-control-input" type="checkbox" value="1" id="diffusione_incontri" name="diffusione_incontri" <?php echo (isset($data->diffusione_incontri) && $data->diffusione_incontri == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="diffusione_incontri">Richiesta di audizioni o incontri a porte chiuse</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="diffusione_interviste_null" name="diffusione_interviste">
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
                      <label>Con quali soggetti avete creato delle connessioni per discutere dei risultati del vostro monitoraggio?</label>
                      <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="RUOLO: Elencate i soggetti con cui avete avuto dei contatti per diffondere o discutere i risultati del vostro monitoraggio.
Ad esempio: Sindaco, Presidente, Funzionario pubblico, giornalista, amministratore delegato di azienda, etc.

ORGANIZZAZIONE: Ad esempio: Città di Roma, Provincia di Chieti, Regione Calabria, Il Corriere della Sera, Buitoni, etc.">Cosa devo fare qui?</span>
                      <div><div class=""><button class="btn btn-primary comment" data-field="soggetti-connessioni" id="comment[soggetti-connessioni]" type="button"><i class="fal fa-comment"></i></button></div></div>
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
                          <?php foreach($connections as $i => $connection){ ?>
                              <tr>
                                  <td><input type="text" name="connection[<?php echo $i +1; ?>][subject]" value="<?php echo $connection->subject; ?>" placeholder="Soggetto..." class="form-control"></td>
                                  <td><input type="text" name="connection[<?php echo $i +1; ?>][role]"  value="<?php echo $connection->role; ?>" placeholder="Ruolo..." class="form-control"></td>
                                  <td><input type="text" name="connection[<?php echo $i +1; ?>][organisation]"  value="<?php echo $connection->organisation; ?>" placeholder="Organizzazione..." class="form-control"></td>
                                  <td>
                                      <?php if(!empty($connection->connection_type_other)){ ?>
                                          <input type="text" name="connection[<?php echo $i +1; ?>][connection_type_other]" value="<?php echo $connection->connection_type_other; ?>" placeholder="Altro tipo di connessione..." class="form-control">
                                      <?php } ?>
                                      <select name="connection[<?php echo $i +1; ?>][connection_type]" id="connection[<?php echo $i +1; ?>][connection_type]" class="form-control pck">
                                          <option></option>
                                          <?php foreach($connection_type as $c){ ?>
                                              <option value="<?php echo $c->idconnection_type; ?>" <?php if($connection->connection_type == $c->idconnection_type){ echo " selected"; } ?>><?php echo $c->connection_type; ?></option>
                                          <?php } ?>
                                      </select>
                                  </td>
                              </tr>
                          <?php } ?>
                          </tbody>

                      </table>
                      <button type="button" class="btn btn-primary" id="subject-button-add"><i class="fal fa-plus"></i> AGGIUNGI SOGGETTO</button>
                      <?php showComment($comments, 'soggetti-connessioni'); ?>
                  </div>

                  <div class="form-group">
                      <label>I media hanno parlato del vostro monitoraggio?</label>
                      <div><div class=""><button class="btn btn-primary comment" data-field="media" id="comment[media]" type="button"><i class="fal fa-comment"></i></button></div></div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="media_connection_yes" name="media_connection" class="custom-control-input" value="1"  <?php echo (isset($data->media_connection) && $data->media_connection == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="media_connection_yes">Si</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="media_connection_no" name="media_connection" class="custom-control-input" value="0"  <?php echo (( isset($data->media_connection) && $data->media_connection == 0) || is_null($data->media_connection) ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="media_connection_no">No</label>
                      </div>
                      <?php showComment($comments, 'media'); ?>
                  </div>


                  <div class="form-group">
                      <label>Se sì, I risultati del monitoraggio sono stati ripresi dai seguenti media:</label>
                      <div><div class=""><button class="btn btn-primary comment" data-field="media-outlets" id="comment[media-outlets]" type="button"><i class="fal fa-comment"></i></button></div></div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="tv_locali_null" name="tv_locali">
                          <input class="custom-control-input" type="checkbox" value="1" id="tv_locali" name="tv_locali" <?php echo (isset($data->tv_locali) && $data->tv_locali == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="tv_locali">TV Locali</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="tv_nazionali_null" name="tv_nazionali">
                          <input class="custom-control-input" type="checkbox" value="1" id="tv_nazionali" name="tv_nazionali" <?php echo (isset($data->tv_nazionali) && $data->tv_nazionali == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="tv_nazionali">TV Nazionali</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="giornali_locali_null" name="giornali_locali">
                          <input class="custom-control-input" type="checkbox" value="1" id="giornali_locali" name="giornali_locali" <?php echo (isset($data->giornali_locali) && $data->giornali_locali == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="giornali_locali">Giornali Locali</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="giornali_nazionali_null" name="giornali_nazionali">
                          <input class="custom-control-input" type="checkbox" value="1" id="giornali_nazionali" name="giornali_nazionali" <?php echo (isset($data->giornali_nazionali) && $data->giornali_nazionali == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="giornali_nazionali">Giornali Nazionali</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="blog_online_null" name="blog_online">
                          <input class="custom-control-input" type="checkbox" value="1" id="blog_online" name="blog_online" <?php echo (isset($data->blog_online) && $data->blog_online == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="blog_online">Blog o altre news outlet online</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="media_other_null" name="media_other">
                          <input class="custom-control-input" type="checkbox" value="1" id="media_other" name="media_other" <?php echo (isset($data->media_other) && $data->media_other == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="media_other">Altro</label>
                      </div>
                      <?php showComment($comments, 'media-outlets'); ?>
                  </div>

                  <div class="form-group">
                      <label>Avete avuto contatti con le Amministrazioni (es. il sindaco o dirigenti regionali) per presentare o discutere con loro i risultati del vostro monitoraggio?</label>
                      <div><div class=""><button class="btn btn-primary comment" data-field="admin-connection" id="comment[admin-connection]" type="button"><i class="fal fa-comment"></i></button></div></div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="admin_connection_yes" name="admin_connection" class="custom-control-input" value="1"  <?php echo (isset($data->admin_connection) && $data->admin_connection == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="admin_connection_yes">Si</label>
                      </div>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="admin_connection_no" name="admin_connection" class="custom-control-input" value="0"  <?php echo (( isset($data->admin_connection) && $data->admin_connection == 0) || (is_null($data->admin_connection)) ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="admin_connection_no">No</label>
                      </div>
                      <?php showComment($comments, 'admin-connection'); ?>
                  </div>

                  <div class="form-group">
                      <label>Le Pubbliche Amministrazioni hanno risposto alle vostre sollecitazioni o ai problemi che avete sollevato?</label>
                      <div><div class=""><button class="btn btn-primary comment" data-field="admin-response" id="comment[admin-response]" type="button"><i class="fal fa-comment"></i></button></div></div>
                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="admin_response_no_null" name="admin_response_no">
                          <input class="custom-control-input" type="checkbox" value="1" id="admin_response_no" name="admin_response_no" <?php echo (isset($data->admin_response_no) && $data->admin_response_no == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="admin_response_no">Non ci hanno risposto</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="admin_response_some_null" name="admin_response_some">
                          <input class="custom-control-input" type="checkbox" value="1" id="admin_response_some" name="admin_response_some" <?php echo (isset($data->admin_response_some) && $data->admin_response_some == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="admin_response_some">Alcune ci hanno risposto, altre no</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="admin_response_formal_null" name="admin_response_formal">
                          <input class="custom-control-input" type="checkbox" value="1" id="admin_response_formal" name="admin_response_formal" <?php echo (isset($data->admin_response_formal) && $data->admin_response_formal == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="admin_response_formal">Ci hanno dato risposte formali o generiche</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="admin_response_promises_null" name="admin_response_promises">
                          <input class="custom-control-input" type="checkbox" value="1" id="admin_response_promises" name="admin_response_promises" <?php echo (isset($data->admin_response_promises) && $data->admin_response_promises == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="admin_response_promises">Almeno una tra quelle contattate ci ha fatto promesse concrete</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="admin_response_unlocked_null" name="admin_response_unlocked">
                          <input class="custom-control-input" type="checkbox" value="1" id="admin_response_unlocked" name="admin_response_unlocked" <?php echo (isset($data->admin_response_unlocked) && $data->admin_response_unlocked == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="admin_response_unlocked">Hanno messo in pratica i nostri suggerimenti e il progetto ora è "sbloccato" o più efficace</label>
                      </div>

                      <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="hidden" value="0" id="admin_response_flagged_null" name="admin_response_flagged">
                          <input class="custom-control-input" type="checkbox" value="1" id="admin_response_flagged" name="admin_response_flagged" <?php echo (isset($data->admin_response_flagged) && $data->admin_response_flagged == 1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="admin_response_flagged">Avevamo segnalato un problema che ora è stato risolto</label>
                      </div>

                      <div class="form-group">
                          <label class="" for="admin_altro">Altro</label>
                          <input class="form-control" type="text" id="admin_altro" name="admin_altro" value="<?php echo ckv_object($data, 'admin_altro'); ?>">

                      </div>
                      <?php showComment($comments, 'admin-response'); ?>
                  </div>

                  <div class="form-group">

                      <label for="impact_description">Descriveteci il vostro caso. Quali fatti o episodi concreti vi portano a pensare che il vostro monitoraggio civico abbia avuto (o non abbia avuto) impatto tra i soggetti che gestiscono o attuano i progetto che avete monitorato?</label>
                      <div class="input-group">
                          <textarea name="impact_description" id="impact_description" class="form-control"><?php echo ckv_object($data, 'impact_description'); ?></textarea>
                          <div class="input-group-append">
                              <button class="btn btn-primary comment" data-field="impact-description" id="comment[impact-description]" type="button"><i class="fal fa-comment"></i></button>
                          </div>
                      </div>
                      <?php showComment($comments, 'impact-description'); ?>
                  </div>

                  <div class="">
                      <h3>IMPOSTA LO STATO DELLO STEP 3</h3>
                      <input type="hidden" name="current_status_tab_3" value="<?php echo $data->status_tab_3; ?>">
                      <input type="hidden" name="created_by" value="<?php echo $data->created_by; ?>">
                      <div class="form-group">
                          <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" value="<?php echo DRAFT; ?>" id="status-tab-3-1" name="status_tab_3" <?php echo ($data->status_tab_3 == DRAFT ? 'checked' : ""); ?>>
                              <label class="custom-control-label" for="status-tab-3-1">Riporta lo step in <strong>BOZZA</strong>, per permettere ai reporter di modificarlo</label>
                          </div>

                          <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" value="<?php echo PENDING_REVIEW; ?>" id="status-tab-3-3" name="status_tab_3" <?php echo ($data->status_tab_3 == PENDING_REVIEW ? 'checked' : ""); ?>>
                              <label class="custom-control-label" for="status-tab-3-3">Riporta lo step in <strong>ATTESA DI REVISIONE</strong></label>
                          </div>
                          <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" value="<?php echo IN_REVIEW; ?>" id="status-tab-3-5" name="status_tab_3" <?php echo ($data->status_tab_3 == IN_REVIEW ? 'checked' : ""); ?>>
                              <label class="custom-control-label" for="status-tab-3-5">Mantieni lo step <strong>IN REVISIONE</strong></label>
                          </div>
                          <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" value="<?php echo PUBLISHED; ?>" id="status-tab-3-7" name="status_tab_3" <?php echo ($data->status_tab_3 == PUBLISHED ? 'checked' : ""); ?>>
                              <label class="custom-control-label" for="status-tab-3-7">Imposta lo step come <strong>APPROVATO</strong></label>
                          </div>
                      </div>
                  </div>
              </fieldset>
          </div>



        </div>
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
                      <label class="custom-control-label" for="status-7">Imposta il report come <strong>APPROVATO</strong></label>
                  </div>


                  <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" type="checkbox" value="<?php echo ONLY_STEP_ONE; ?>" id="step_1_only" name="step_1_only" <?php echo ($data->step_1_only == ONLY_STEP_ONE ? 'checked' : ""); ?>>
                      <label class="custom-control-label" for="step_1_only">Pubblica <strong>SOLO LO STEP 1</strong> del Report</label>
                  </div>
              </div>
              <h3>LINGUA DEL REPORT</h3>
              <div class="form-group">
                  <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" value="it" id="report_lang_it" name="report_lang" <?php echo ($data->report_lang == 'it' ? 'checked' : ""); ?>>
                      <label class="custom-control-label" for="report_lang_it">Italiano</label>
                  </div>
                  <div class="custom-control custom-radio">
                      <input class="custom-control-input" type="radio" value="en" id="report_lang_en" name="report_lang" <?php echo ($data->report_lang == 'en' ? 'checked' : ""); ?>>
                      <label class="custom-control-label" for="report_lang_en">Inglese</label>
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
