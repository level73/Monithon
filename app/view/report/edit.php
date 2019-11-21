<div class="container">
  <div class="row">
    <div class="col">

      <h1>
        Modifica il Report<br />
        <small><?php echo $data->titolo; ?></small>
      </h1>


      <form class="" method="post" enctype="multipart/form-data" action="/report/edit/<?php echo $data->idreport_basic; ?>">
      <input type="hidden" name="id" value="<?php echo $data->idreport_basic; ?>">


      <!-- Codice OpenCoesione -->
      <div class="form-group">
          <label for="oc_api_code">URL del Progetto su OpenCoesione:</label>
          <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Incolla qui l\'indirizzo (URL) della pagina di OpenCoesione dedicata al progetto che hai scelto di monitorare. Lo trovi nella barra degli indirizzi del tuo browser. Esempio: https://opencoesione.gov.it/it/progetti/1ca1c272007it161po009/">Che cos'è?</span>
          <div class="input-group">
            <input type="text" name="id_open_coesione" id="oc_api_code" placeholder="URL del progetto..." class="form-control" value="<?php echo ckv_object($data, 'id_open_coesione'); ?>">
            <div class="input-group-append">
              <button class="btn btn-primary" id="oc_api_code_lookup" type="button"><i class="fal fa-search"></i></button>
            </div>
          </div>
          <div class="d-none" id="oc_api_content_s1">
            <i class="fal fa-sync fa-spin"></i>
          </div>
      </div>



        <fieldset>
          <legend>Informazioni di Base</legend>
          <div class="form-group">
            <label for="titolo">Titolo:</label>
            <input type="text" name="titolo" id="titolo" class="form-control" value="<?php echo ckv_object($data, 'titolo'); ?>">
          </div>
          <div class="form-group">
            <label for="autore">Autore:</label>
            <input type="text" name="autore" id="autore" class="form-control" value="<?php echo ckv_object($data, 'autore'); ?>">
          </div>

          <div class="form-group">
            <label for="descrizione">Descrizione:</label>
            <textarea name="descrizione" id="descrizione" class="form-control"><?php echo ckv_object($data, 'descrizione'); ?></textarea>
          </div>




          <!-- Mappa -->
          <div class="form-group">
            <label for="indirizzo">Luogo di riferimento del progetto: </label>
            <span class="float-right help-text" data-toggle="tooltip" data-placement="top" title="Abbiamo bisogno delle coordinate di Latitudine e Longitudine del progetto monitorato! Inserendo l'indirizzo più vicino al luogo del monitoraggio e cliccando sul pulsante con la lente d'ingrandimento, la mappa vi si centerà e collocherà un marker in quel luogo. Se necessario, è possibile trascinare il marker sulla mappa per essere ancora più precisi nel posizionamento del marker (e quindi del tracciamento delle coordinate!).">Cosa devo fare qui?</span>
            <div class="input-group">
              <input type="text" name="indirizzo" id="indirizzo" placeholder="Indirizzo..." class="form-control" value="<?php echo ckv_object($data, 'indirizzo'); ?>">
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

        <fieldset>
          <legend>Valutazione</legend>
          <div class="form-group">
            <label for="avanzamento">Stato di avanzamento del progetto monitorato sulla base delle informazioni raccolte:</label>
            <textarea name="avanzamento" id="avanzamento" class="form-control"><?php echo ckv_object($data, 'avanzamento'); ?></textarea>
          </div>


          <div class="form-group">
            <label for="risultato_progetto">Risultato del progetto monitorato (se il progetto è concluso, quali risultati ha avuto?):</label>
            <textarea name="risultato_progetto" id="risultato_progetto" class="form-control"><?php echo ckv_object($data, 'risultato_progetto'); ?></textarea>
          </div>

          <div class="form-group">
            <label for="punti_di_forza">Punti di forza (cosa ti è piaciuto del progetto monitorato?):</label>
            <textarea name="punti_di_forza" id="punti_di_forza" class="form-control"><?php echo ckv_object($data, 'punti_di_forza'); ?></textarea>
          </div>


          <div class="form-group">
            <label for="punti_deboli">Debolezze (difficoltà riscontrate nell'attuazione/realizzazione del progetto monitorato?):</label>
            <textarea name="punti_deboli" id="punti_deboli" class="form-control"><?php echo ckv_object($data, 'punti_deboli'); ?></textarea>
          </div>


          <div class="form-group">
            <label for="rischi">Rischi futuri per il progetto monitorato:</label>
            <textarea name="rischi" id="rischi" class="form-control"><?php echo ckv_object($data, 'rischi'); ?></textarea>
          </div>


          <div class="form-group">
            <label for="soluzioni_progetto">Soluzioni ed idee da proporre per il progetto monitorato:</label>
            <textarea name="soluzioni_progetto" id="soluzioni_progetto" class="form-control"><?php echo ckv_object($data, 'soluzioni_progetto'); ?></textarea>
          </div>

          <!-- Giudizio Sintetico -->
          <div class="form-group">
            <label for="giudizio_sintetico">Giudizio Sintetico sul Progetto monitorato: </label>
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
          </div>

        </fieldset>

        <fieldset>
          <legend>Metodi di Indagine</legend>
          <!-- Raccolta Info -->
          <div class="form-group">
            <label for="">Raccolta Informazioni</label>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_web" name="raccolta_info_web" <?php echo (isset($data->raccolta_info_web) && $data->raccolta_info_web == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="raccolta_info_web">Raccolta di informazioni via web</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="visita_diretta" name="visita_diretta" <?php echo (isset($data->visita_diretta) && $data->visita_diretta == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="visita_diretta">Visita diretta documentata da foto e video</label>
            </div>

            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="intervista_autorita_gestione" name="intervista_autorita_gestione" <?php echo (isset($data->intervista_autorita_gestione) && $data->intervista_autorita_gestione == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="intervista_autorita_gestione">Intervista con l'Autorità di Gestione del Programma</label>
            </div>

            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="intervista_soggetto_programmatore" name="intervista_soggetto_programmatore" <?php echo (isset($data->intervista_soggetto_programmatore) && $data->intervista_soggetto_programmatore == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="intervista_soggetto_programmatore">Intervista con i soggetti che hanno programmato l'intervento (soggetto programmatore)</label>
            </div>


            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="intervista_utenti_beneficiari" name="intervista_utenti_beneficiari" <?php echo (isset($data->intervista_utenti_beneficiari) && $data->intervista_utenti_beneficiari == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="intervista_utenti_beneficiari">Intervista con gli utenti/beneficiari dell'intervento</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="intervista_altri_utenti" name="intervista_altri_utenti" <?php echo (isset($data->intervista_altri_utenti) && $data->intervista_altri_utenti == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="intervista_altri_utenti">Intervista con altre tipologie di persone</label>
            </div>

            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="raccolta_info_attuatore" name="raccolta_info_attuatore" <?php echo (isset($data->raccolta_info_attuatore) && $data->raccolta_info_attuatore == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="raccolta_info_attuatore">Intervista con i soggetti che hanno o stanno attuando l'intervento (attuatore o realizzatore)</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" value="1" id="referenti_politici" name="referenti_politici" <?php echo (isset($data->referenti_politici) && $data->referenti_politici == 1 ? 'checked' : ''); ?>>
              <label class="custom-control-label" for="referenti_politici">Intervista con i referenti politici</label>
            </div>
          </div>

          <div class="form-group">
            <label for="intervista_intervistati">Chi è stato intervistato? Che ruolo ha la persona nel progetto? (es. gestore, funzionario comunale, cittadino informato…):</label>
            <textarea name="intervista_intervistati" id="intervista_intervistati" class="form-control"><?php echo ckv_object($data, 'intervista_intervistati'); ?></textarea>
            <span class="form-text text-muted">Riportare i ruoli di tutte le persone intervistate</span>
          </div>

          <div class="form-group">
            <label for="intervista_domande">Principali due domande poste agli intervistati (specificare quali):</label>
            <textarea name="intervista_domande" id="intervista_domande" class="form-control"><?php echo ckv_object($data, 'intervista_domande'); ?></textarea>
          </div>

          <div class="form-group">
            <label for="intervista_risposte">Principali due risposte degli intervistati:</label>
            <textarea name="intervista_risposte" id="intervista_risposte" class="form-control"><?php echo ckv_object($data, 'intervista_risposte'); ?></textarea>
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
              <li><a href="<?php echo $l->URL; ?>"><?php echo $l->URL; ?></a></li>
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
              </div>
            <?php } ?>
            </ul>
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