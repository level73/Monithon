<div class="container">
  <div class="row">
    <div class="col">

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
        <li class="nav-item">
          <a class="nav-link" id="step-3-tab" data-toggle="tab" href="#step-3" role="tab" aria-controls="step-3" aria-selected="false">Step 3: Risultati e Impatto</a>
        </li>
      </ul>


      <div class="tab-content" id="report-tab-content">
        <div class="tab-pane fade show active" id="step-1" role="tabpanel" aria-labelledby="step-1">
          <fieldset>
              <legend>Informazioni di Base</legend>
              <small>Inserisci la URL per fare apparire MoniTutor!</small>
              <br /><br /><br />
              <!-- Codice OpenCoesione -->
              <div class="form-group">
                  <label for="oc_api_code">URL del Progetto su OpenCoesione:</label>
                  <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Incolla qui l\'indirizzo (URL) della pagina di OpenCoesione dedicata al progetto che hai scelto di monitorare. Lo trovi nella barra degli indirizzi del tuo browser. Esempio: https://opencoesione.gov.it/it/progetti/1ca1c272007it161po009/">Che cos'è?</span>
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
                <label for="titolo">Titolo del Report:</label>
                <input type="text" name="titolo" id="titolo" class="form-control" value="<?php echo ckv($data, 'titolo'); ?>">
              </div>
              <div class="form-group">
                <label for="autore">Autore del Report:</label>
                <input type="text" name="autore" id="autore" class="form-control" value="<?php echo ckv($data, 'autore'); ?>">
              </div>

              <div class="form-group">
                <label for="descrizione">Descrizione del progetto monitorato:</label>
                  <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Descrivere brevemente il progetto che avete scelto di monitorare in modo da attrarre l'attenzione del lettore del vostro report. Spiegate in poche frasi perché è importante monitorarlo, i suoi obiettivi e come intende raggiungerli">Cosa devo fare qui?</span>
                <textarea name="descrizione" id="descrizione" class="form-control"><?php echo ckv($data, 'descrizione'); ?></textarea>
              </div>
              <div class="form-group">
                <label for="parte_di_piano"><?php t('Il progetto fa parte di un piano di interventi più ampio? Se sì, qual è l’obiettivo complessivo di questo piano?'); ?></label>
                <textarea name="parte_di_piano" id="parte_di_piano" class="form-control"><?php echo ckv($data, 'parte_di_piano'); ?></textarea>
              </div>

              <!-- Mappa -->
              <div class="form-group">
                <label for="indirizzo">Luogo di riferimento del progetto: </label>
                <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Abbiamo bisogno delle coordinate di Latitudine e Longitudine del progetto monitorato! Inserendo l'indirizzo più vicino al luogo del monitoraggio e cliccando sul pulsante con la lente d'ingrandimento, la mappa vi si centerà e collocherà un marker in quel luogo. Se necessario, è possibile trascinare il marker sulla mappa per essere ancora più precisi nel posizionamento del marker (e quindi del tracciamento delle coordinate!).">Cosa devo fare qui?</span>
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
            <button class="btn btn-primary showhide" type="button" id="gender-equality-button" data-target=".gender-equality-box">compila la sezione sulla parità di genere</button>
              <fieldset class="gender-equality-box d-none">
                  <h3>Parità di Genere</h3>

                  <div class="form-group">
                      <label for="gender-objectives">Gli obiettivi del progetto includono esplicitamente la parità di genere?</label>

                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_objectives_yes_direct" name="gender_objectives" class="trigger-desc check-eval custom-control-input" data-group="go" data-target="#goydd" value="1" <?php echo (isset($data['gender_objectives']) && $data['gender_objectives'] ==  1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_objectives_yes_direct">Si, diretti: pianificati con l’obiettivo esplicito di intervenire a favore delle donne (es. il progetto ha tra i suoi obiettivi il contrasto alla violenza di genere, la protezione e il sostegno alle vittime di violenza, l’aumento della partecipazione delle donne al mercato del lavoro,  il contrasto alla povertà femminile...)</label>
                      </div>
                      <div class="form-group d-none trigger-desc-wrapper" id="goydd">
                          <label>Aggiungi una descrizione</label>
                          <textarea id="gender_objectives_yes_direct_desc" name="gender_objectives_yes_direct_desc"  class="form-control"><?php echo ckv($data, 'gender_objectives_yes_direct_desc'); ?></textarea>
                      </div>

                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_objectives_yes_indirect" name="gender_objectives" class="trigger-desc check-eval custom-control-input" data-group="go" data-target="#goyid" value="2" <?php echo (isset($data['gender_objectives']) && $data['gender_objectives'] ==  2 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_objectives_yes_indirect">Si, indiretti: potrebbero avere un impatto, anche indiretto, sulla riduzione delle disuguaglianze a sfavore delle donne (es. il progetto prevede rafforzamento servizi mense / asili, rafforzamento trasporto pubblico locale…)</label>
                      </div>
                      <div class="form-group d-none trigger-desc-wrapper" id="goyid">
                        <label>Aggiungi una descrizione</label>
                        <textarea id="gender_objectives_yes_indirect_desc" name="gender_objectives_yes_indirect_desc"  class="form-control"><?php echo ckv($data, 'gender_objectives_yes_indirect_desc'); ?></textarea>
                      </div>


                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_objectives_no" name="gender_objectives" class="trigger-desc check-eval custom-control-input"  data-group="go" value="3" <?php echo (isset($data['gender_objectives']) && $data['gender_objectives'] ==  3 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_objectives_no">No</label>
                      </div>
                  </div>

                  <div class="form-group">
                      <label>Il linguaggio utilizzato nei documenti progettuali è sensibile al genere (es. sono utilizzate parole come donne, bambine, anziane, studentesse, lavoratrici, etc.)? </label>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_language_yes" name="gender_language" class="custom-control-input" value="1" <?php echo (isset($data['gender_language']) && $data['gender_language'] ==  1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_language_yes">Si</label>
                      </div>

                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_language_no" name="gender_language" class="custom-control-input" value="2" <?php echo (isset($data['gender_language']) && $data['gender_language'] ==  2 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_language_no">No</label>
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
                  </div>

                  <div class="form-group">
                      <label>Sono utilizzati esplicitamente indicatori per monitorare e valutare l’impatto del progetto in termini di promozione della parità di genere?</label>
                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_indicators_yes" name="gender_indicators" class="trigger-desc custom-control-input" data-group="gi" data-target="#giy" value="1" <?php echo (isset($data['gender_indicators']) && $data['gender_indicators'] ==  1 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_indicators_yes">Si</label>
                      </div>

                      <div class="form-group d-none trigger-desc-wrapper" id="giy">
                          <label>Quali indicatori?</label>
                          <input id="gender_indicators_desc" name="gender_indicators_desc"  class="form-control" value="<?php echo ckv($data, 'gender_indicators_desc'); ?>" />
                      </div>

                      <div class="custom-control custom-radio">
                          <input type="radio" id="gender_indicators_no" name="gender_indicators" class="trigger-desc custom-control-input"  data-group="gi"  value="2" <?php echo (isset($data['gender_indicators']) && $data['gender_indicators'] ==  2 ? 'checked' : ''); ?>>
                          <label class="custom-control-label" for="gender_indicators_no">No</label>
                      </div>
                  </div>

              </fieldset>


            <button id="tab-2-nav" class="tab-subnav btn btn-primary btn-lg btn-block" data-step="#step-2" type="button">VAI ALLO STEP 2: VALUTAZIONE</button><br /><br />
        </div>

        <div class="tab-pane fade" id="step-2" role="tabpanel" aria-labelledby="step-2">
          <div class="d-none" id="oc_api_content_s2">
            <i class="fal fa-sync fa-spin"></i>
          </div>

          <fieldset>
            <legend>Valutazione</legend>
            <div class="form-group">
              <label for="avanzamento">Stato di avanzamento del progetto monitorato sulla base delle informazioni raccolte:</label>
              <textarea name="avanzamento" id="avanzamento" class="form-control"><?php echo ckv($data, 'avanzamento'); ?></textarea>
            </div>


            <div class="form-group">
              <label for="risultato_progetto">Risultato del progetto monitorato (se il progetto è concluso, quali risultati ha avuto?):</label>
              <textarea name="risultato_progetto" id="risultato_progetto" class="form-control"><?php echo ckv($data, 'risultato_progetto'); ?></textarea>
            </div>

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

            <div class="form-group">
              <label for="punti_di_forza">Punti di forza (cosa ti è piaciuto del progetto monitorato?):</label>
              <textarea name="punti_di_forza" id="punti_di_forza" class="form-control"><?php echo ckv($data, 'punti_di_forza'); ?></textarea>
            </div>


            <div class="form-group">
              <label for="punti_deboli">Debolezze (difficoltà riscontrate nell'attuazione/realizzazione del progetto monitorato?):</label>
              <textarea name="punti_deboli" id="punti_deboli" class="form-control"><?php echo ckv($data, 'punti_deboli'); ?></textarea>
            </div>


            <div class="form-group d-none" id="cause_inefficacia_wrapper">
              <label>Quali sono le cause dell’inefficacia del progetto che hai monitorato?</label>
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


            <div class="form-group">
              <label for="rischi">Rischi futuri per il progetto monitorato:</label>
              <textarea name="rischi" id="rischi" class="form-control"><?php echo ckv($data, 'rischi'); ?></textarea>
            </div>


            <div class="form-group">
              <label for="soluzioni_progetto">Soluzioni ed idee da proporre per il progetto monitorato:</label>
              <textarea name="soluzioni_progetto" id="soluzioni_progetto" class="form-control"><?php echo ckv($data, 'soluzioni_progetto'); ?></textarea>
            </div>

            <!-- Giudizio Sintetico -->
            <div class="form-group">
              <label for="giudizio_sintetico">Giudizio Sintetico sul Progetto monitorato: </label>
              <div class="custom-control custom-radio">
                <input type="radio" id="giudizio_sintetico_1" name="giudizio_sintetico" class="custom-control-input" value="1"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="giudizio_sintetico_1">Appena iniziato <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è iniziato da troppo poco tempo per poter esprimere un giudizio. Si sa che è stato avviato, anche se i risultati non sono ancora visibili e monitorabili."></i></label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="giudizio_sintetico_2" name="giudizio_sintetico" class="custom-control-input" value="2" <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 2 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="giudizio_sintetico_2">In corso e procede bene <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è avviato e, tutto sommato, i risultati parziali sembrano positivi. Tutte (o almeno la maggior parte) delle attività avviate sembrano procedere nella direzione pianificata."></i></label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="giudizio_sintetico_3" name="giudizio_sintetico" class="custom-control-input" value="3"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 3 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="giudizio_sintetico_3">Procede con difficoltà <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è stato avviato, ma ci sono problemi rilevanti nella sua attuazione (es. ritardi significativi, alcune attività ferme o alcune differenze significative rispetto a quanto preventivato)."></i></label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="giudizio_sintetico_4" name="giudizio_sintetico" class="custom-control-input" value="4"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 4 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="giudizio_sintetico_4">Bloccato <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato non procede. Può essere bloccato all'inizio (mai avviato) o in una fase successiva."></i></label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="giudizio_sintetico_5" name="giudizio_sintetico" class="custom-control-input" value="5"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 5 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="giudizio_sintetico_5">Concluso e utile <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è finito ed è ritenuto complessivamente efficace dal punto di vista dell'utilizzatore finale."></i></label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="giudizio_sintetico_6" name="giudizio_sintetico" class="custom-control-input" value="6"  <?php echo (isset($data['giudizio_sintetico']) && $data['giudizio_sintetico'] == 6 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="giudizio_sintetico_6">Concluso e inefficace <i class="fal fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Il progetto monitorato è finito ma è ritenuto complessivamente inefficace (es. mancano altri interventi complementari, il progetto è concluso ma non è entrato in funzione, oppure non è funzionale, è obsoleto o comunque non rispondente ai bisogni dell'utenza)."></i></label>
              </div>
            </div>

          </fieldset>

          <fieldset>
            <legend>Metodi di Indagine</legend>
            <!-- Raccolta Info -->
            <div class="form-group">
              <label for="">Raccolta Informazioni</label>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_web" name="raccolta_info_web" <?php echo (isset($data['raccolta_info_web']) && $data['raccolta_info_web'] == 1 ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="raccolta_info_web">Raccolta di informazioni via web</label>
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
            </div>

            <div class="form-group">
              <label for="intervista_intervistati">Chi è stato intervistato? Che ruolo ha la persona nel progetto? </label>
                <span class="form-text text-info">Riportare i ruoli di tutte le persone intervistate</span>
              <textarea name="intervista_intervistati" id="intervista_intervistati" class="form-control"><?php echo ckv($data, 'intervista_intervistati'); ?></textarea>
                <span class="form-text text-muted">(es. gestore, funzionario comunale, cittadino informato…)</span>

            </div>

            <div class="form-group">
              <label for="intervista_domande">Principali due domande poste agli intervistati (specificare quali):</label>
              <textarea name="intervista_domande" id="intervista_domande" class="form-control"><?php echo ckv($data, 'intervista_domande'); ?></textarea>
            </div>

            <div class="form-group">
              <label for="intervista_risposte">Principali due risposte degli intervistati:</label>
              <textarea name="intervista_risposte" id="intervista_risposte" class="form-control"><?php echo ckv($data, 'intervista_risposte'); ?></textarea>
            </div>

          </fieldset>

          <fieldset>
            <legend>Link, Video, Allegati</legend>
              <div class="alert alert-info" role="alert"><i class="fas fa-exclamation-triangle"></i> <strong>Il peso complessivo dei file che si vogliono caricare non deve eccedere gli 8mb per invio.</strong></div>
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
              <div class="link-grouper origin">
                <input type="text" class="form-control" id="link-attachment[0]" name="link-attachment[0]" placeholder="Inserisci URL della fonte...">
              </div>

              <button type="button" class="btn btn-secondary btn-sm link-duplicator" data-duplicate=".link-grouper"><i class="fal fa-plus"></i> Aggiungi altri link alle fonti</button>
            </div>

            <div class="form-group">
              <label>Aggiungi link a Video (youtube, vimeo)</label>
              <div class="video-grouper origin">
                <input type="text" class="form-control" id="video-attachment[0]" name="video-attachment[0]" placeholder="Inserisci URL del video...">
              </div>

              <button type="button" class="btn btn-secondary btn-sm video-duplicator" data-duplicate=".video-grouper"><i class="fal fa-plus"></i> Aggiungi altri link a video</button>
            </div>

          </fieldset>
            <button id="tab-3-nav" class="tab-subnav btn btn-primary btn-lg btn-block" data-step="#step-3" type="button">VAI ALLO STEP 3: RISULTATI E IMPATTO</button><br /><br />
        </div>



        <div class="tab-pane fade" id="step-3" role="tabpanel" aria-labelledby="step-3">

            <fieldset>
                <legend>Le nuove connessioni che avete generato</legend>
                <div class="form-group">
                    <label for="nuove-connessioni">Come avete diffuso o state diffondendo i risultati del vostro monitoraggio civico?</label>

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
                    <label>Con quali soggetti avete creato delle connessioni per discutere dei risultati del vostro monitoraggio?</label>
                    <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="RUOLO: Elencate i soggetti con cui avete avuto dei contatti per diffondere o discutere i risultati del vostro monitoraggio.
Ad esempio: Sindaco, Presidente, Funzionario pubblico, giornalista, amministratore delegato di azienda, etc.

ORGANIZZAZIONE: Ad esempio: Città di Roma, Provincia di Chieti, Regione Calabria, Il Corriere della Sera, Buitoni, etc.">Cosa devo fare qui?</span>
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
                                <td><input type="text" name="connection[1][subject]" placeholder="Soggetto..." class="form-control"></td>
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

                <div class="form-group" id="connection-relationships">
                    <table id="connection-relationships-table">
                        <thead>
                            <tr>
                                <th><!-- blank for matrix structure --></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>

                <div class="form-group">
                    <label>I media hanno parlato del vostro monitoraggio?</label>
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
                    <label>Se sì, I risultati del monitoraggio sono stati ripresi dai seguenti media:</label>
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
                    <label>Avete avuto contatti con le Amministrazioni (es. il sindaco o dirigenti regionali) per presentare o discutere con loro i risultati del vostro monitoraggio?</label>
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
                    <label>Le Pubbliche Amministrazioni hanno risposto alle vostre sollecitazioni o ai problemi che avete sollevato?</label>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="admin_response_no" name="admin_response_no" <?php echo (isset($data['admin_response_no']) && $data['admin_response_no'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_response_no">Non ci hanno risposto</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" value="1" id="admin_response_some" name="admin_response_some" <?php echo (isset($data['admin_response_some']) && $data['admin_response_some'] == 1 ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="admin_response_some">Alcune ci hanno risposto, altre no</label>
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
                    <label for="impact_description">Descriveteci il vostro caso. Quali fatti o episodi concreti vi portano a pensare che il vostro monitoraggio civico abbia avuto (o non abbia avuto) impatto tra i soggetti che gestiscono o attuano i progetto che avete monitorato?</label>
                    <textarea name="impact_description" id="impact_description" class="form-control"><?php echo ckv($data, 'impact_description'); ?></textarea>



                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" value="<?php echo PENDING_REVIEW; ?>" id="status_tab_3" name="status_tab_3">
                    <label class="custom-control-label" for="status_tab_3">Questo step del report (Impatto & Risultati) è pronto per essere revisionato dalla Redazione</label>
                </div>

            </fieldset>
        </div>
      </div>






        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="<?php echo PENDING_REVIEW; ?>" id="status" name="status">
            <label class="custom-control-label" for="status">Il Report è pronto (<strong>completo in step 1 e step 2</strong>) per essere revisionato dalla Redazione</label>
          </div>

        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-lg" type="submit" ><i class="fal fa-save"></i> Salva Report</button>
        </div>
      </form>

    </div>
  </div>
</div>
