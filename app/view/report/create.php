<div class="container">
  <div class="row">
    <div class="col">

      <h1>Nuovo Report</h1>

      <h2>
        Step 1: Desk Analysis<br />
        <small>Cosa puoi fare prima della visita di Monitoraggio</small>
      </h2>

      <!-- Codice OpenCoesione -->
      <div class="form-group">
          <label for="oc_api_code">URL del Progetto su OpenCoesione:</label>
          <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Il Codice Univoco OpenCoesione è utilizzato per individuare i dati aperti messi a disposizione dal Dipartimento per le Politiche di Coesione della Presidenza del consiglio dei Ministri. ">Che cos'è?</span>
          <div class="input-group">
            <input type="text" name="id_open_coesione" id="oc_api_code" placeholder="Codice univoco..." class="form-control" value="<?php echo ckv($data, 'id_open_coesione'); ?>">
            <div class="input-group-append">
              <button class="btn btn-primary" id="oc_api_code_lookup" type="button"><i class="fal fa-search"></i></button>
            </div>
          </div>
          <div class="invisible" id="oc_api_content_s1">
            <i class="fal fa-sync fa-spin"></i>
          </div>
      </div>


      <form class="" method="post" enctype="multipart/form-data" action="/report/create">
        <fieldset>
          <legend>Informazioni di Base</legend>
          <div class="form-group">
            <label for="titolo">Titolo:</label>
            <input type="text" name="titolo" id="titolo" class="form-control" value="<?php echo ckv($data, 'titolo'); ?>">
          </div>
          <div class="form-group">
            <label for="autore">Autore:</label>
            <input type="text" name="autore" id="autore" class="form-control" value="<?php echo ckv($data, 'autore'); ?>">
          </div>

          <div class="form-group">
            <label for="descrizione">Descrizione:</label>
            <textarea name="descrizione" id="descrizione" class="form-control"><?php echo ckv($data, 'descrizione'); ?></textarea>
          </div>




          <!-- Mappa -->
          <div class="form-group">
            <label for="indirizzo">Luogo del Monitoraggio: </label>
            <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Abbiamo bisogno delle coordinate di Latitudine e Longitudine del progetto monitorato! Inserendo l'indirizzo più vicino al luogo del monitoraggio e cliccando sul pulsante con la lente d'ingrandimento, la mappa vi si centerà e collocherà un marker in quel luogo. Se necessario, è possibile trascinare il marker sulla mappa per essere ancora più precisi nel posizionamento del marker (e quindi del tracciamento delle coordinate!).">Cosa devo fare qui?</span>
            <div class="input-group">
              <input type="text" name="indirizzo" id="indirizzo" placeholder="Indirizzo..." class="form-control" value="<?php echo ckv($data, 'indirizzo'); ?>">
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
            <label for="punti_di_forza">Punti di forza (cosa ti è piaciuto del progetto monitorato?):</label>
            <textarea name="punti_di_forza" id="punti_di_forza" class="form-control"><?php echo ckv($data, 'punti_di_forza'); ?></textarea>
          </div>


          <div class="form-group">
            <label for="punti_deboli">Debolezze (difficoltà riscontrate nell'attuazione/realizzazione del progetto monitorato?):</label>
            <textarea name="punti_deboli" id="punti_deboli" class="form-control"><?php echo ckv($data, 'punti_deboli'); ?></textarea>
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
              <input class="custom-control-input" type="checkbox" value="1" id="visita_diretta" name="visita_diretta" <?php echo (isset($data['visita_diretta']) && $data['visita_diretta'] == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="visita_diretta">Visita Diretta</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="intervista_responsabili_progetto" name="intervista_responsabili_progetto" <?php echo (isset($data['intervista_responsabili_progetto']) && $data['intervista_responsabili_progetto'] == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="intervista_responsabili_progetto">Intervista con i responsabili del progetto</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="intervista_utenti_beneficiari" name="intervista_utenti_beneficiari" <?php echo (isset($data['intervista_utenti_beneficiari']) && $data['intervista_utenti_beneficiari'] == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="intervista_utenti_beneficiari">Intervista con gli utenti/beneficiari dell'intervento</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="intervista_altri_utenti" name="intervista_altri_utenti" <?php echo (isset($data['intervista_altri_utenti']) && $data['intervista_altri_utenti'] == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="intervista_altri_utenti">Intervista con altre tipologie di persone</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_web" name="raccolta_info_web" <?php echo (isset($data['raccolta_info_web']) && $data['raccolta_info_web'] == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="raccolta_info_web">Raccolta di informazioni via web</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_attuatore" name="raccolta_info_attuatore" <?php echo (isset($data['raccolta_info_attuatore']) && $data['raccolta_info_attuatore'] == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="raccolta_info_attuatore">Raccolta di informazioni presso il soggetto attuatore</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="referenti_politici" name="referenti_politici" <?php echo (isset($data['referenti_politici']) && $data['referenti_politici'] == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="referenti_politici">Intervista con i referenti politici</label>
            </div>
          </div>

          <div class="form-group">
            <label for="intervista_intervistati">Chi è stato intervistato? Che ruolo ha la persona nel progetto? (es. gestore, funzionario comunale, cittadino informato…):</label>
            <textarea name="intervista_intervistati" id="intervista_intervistati" class="form-control"><?php echo ckv($data, 'intervista_intervistati'); ?></textarea>
          </div>

          <div class="form-group">
            <label for="intervista_domande">Domande poste agli intervistati:</label>
            <textarea name="intervista_domande" id="intervista_domande" class="form-control"><?php echo ckv($data, 'intervista_domande'); ?></textarea>
          </div>

          <div class="form-group">
            <label for="intervista_risposte">Risposte degli intervistati:</label>
            <textarea name="intervista_risposte" id="intervista_risposte" class="form-control"><?php echo ckv($data, 'intervista_risposte'); ?></textarea>
          </div>

        </fieldset>



        <fieldset>
          <legend>Link, Video, Allegati</legend>

          <div class="form-group">
            <label>Carica immagini, documenti, etc.</label>
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

        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="<?php echo PENDING_REVIEW; ?>" id="status" name="status">
            <label class="custom-control-label" for="status">Il Report è pronto per essere revisionato dalla Redazione, che lo pubblicherà se rispetterà i nostri <a href="#">Termini d'uso</a></label>
          </div>

        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-lg" type="submit" ><i class="fal fa-save"></i> Salva Report</button>
        </div>
      </form>

    </div>
  </div>
</div>
