var OpenCoesione = {

  config: {
    api_url: 'https://opencoesione.gov.it/it/api/progetti/',
    api_format: '/?format=json',
    lang: 'it' // TODO: Change to dynamically set param from Monithon.config
  },


  init: function(){
    console.log(this.config.api_url);
    this.getProject();
    if($('#oc_api_code').val() != ''){
        $('#oc_api_code_lookup').trigger('click');
    }
  },

  getProject: function(){
    var config = this.config;
    var OC = this;

    $('#oc_api_code_lookup').click( function(e){
        $('#oc_api_content_s1, #oc_api_content_s2').removeClass('d-none');
        e.preventDefault();
        console.log(config);

        // Get the Code
        var oc_api_url = $('#oc_api_code').val().toLowerCase();
        var oc_api_code = OC.getProjectCode(oc_api_url);

        // build the JSON API URL
        var oc_api_endpoint = config.api_url + oc_api_code + config.api_format;
        console.log(oc_api_endpoint);

        $.getJSON('/ajax/oc_api/' + oc_api_code, {'code': oc_api_code}, function(data){
          console.log(data);
          if(data.code == '404'){
            alert('Non trovo il progetto! Controlla di aver copiato ed incollato la URL correttamente, e riprova.');
            $('#oc_api_content_s1, #oc_api_content_s2').addClass('d-none');
          }
          else {
            // Inject data into hidden field
            $('#oc_data').val(JSON.stringify(data));

            // Load S1 Template
            $('#oc_api_content_s1').load('/public/assets/guide_s1.php', function(){

              /** BOF BLOCK 1 OF STEP 1 **/
              var Block1 = '';

              for(i = 0; i < data.programmi.length; i++){
                var oc_cod_fonte = data.programmi[i].oc_cod_fonte;
                var po;

                // Sync call to PO TABLE
                $.ajax({
                  url: '/ajax/programma_operativo/' + data.programmi[i].oc_codice_programma,
                  dataType: 'json',
                  async: false,
                  success: function(data) {
                    po = data;
                  }
                });


                Block1 += 'Il tuo progetto è finanziato dal <strong><a href="' + po.url_oc + '" target="_blank">' + data.programmi[i].oc_descrizione_programma + '</a></strong><br />';

                if(oc_cod_fonte == 'FS0713' || oc_cod_fonte == 'FS0713'){
                  var descr_obiettivo_specifico = data.programmi[i].descr_obiettivo_specifico;
                  if(data.programmi[i].descr_obiettivo_specifico == '') {
                    descr_obiettivo_specifico = 'N.D.';
                  }
                  Block1 += 'Per rispondere a questo obiettivo specifico: <span class="guide-hilite">' + descr_obiettivo_specifico + '</span><br />';
                }
                if(po.pdf_po){
                  Block1 += '<a href="' + po.pdf_po + '" target="_blank">Scarica il testo del Programma</a> e cerca gli obiettivi all’interno del documento.<br />';
                }
                if(po.url_ec){
                  Block1 += 'Vedi la <a href="' + po.url_ec + '" target="_blank">sintesi del programma sul sito della Commissione Europea</a>.';
                }

                if(oc_cod_fonte == 'FSC0713' || oc_cod_fonte == 'FSC1420' || oc_cod_fonte == 'PAC' || oc_cod_fonte == 'PAC1420'){
                  Block1 += 'Il tuo progetto è stato finanziato da fondi nazionali per la coesione.<br />';
                }

                if( (oc_cod_fonte == 'FSC1420' || oc_cod_fonte == 'PAC1420') && po.url_del_cipe) {
                  Block1 += 'Leggi la delibera del CIPE che descrive gli obiettivi dell’intervento. <a href="'+ po.url_del_cipe +'" target="_blank">' + po.del_cipe + '</a>';
                }
                if(oc_cod_fonte == 'FSC0713'){
                  Block1 += 'Consulta <a href="https://opencoesione.gov.it/media/uploads/relazione_fsc_regionale_2007_2013.pdf" target="_blank">questa relazione sull’utilizzo del Fondo Sviluppo e Coesione nel 2007-13</a>.<br />';
                }
                if(oc_cod_fonte == 'PAC'){
                  Block1 += 'Consulta il Piano Azione Coesione del 2011<br />';
                }
                if(po.oc_tipologia_programma_fsc && po.oc_tipologia_programma_fsc.toLowerCase() == 'patti per lo sviluppo'){
                  Block1 += '<a href="' + po.url_interventi_patti + '" target="_blank">Scarica la scheda degli interventi</a>.';
                }

              }

              $('#oc_guide_s1_1').html(Block1);
              /** EOF BLOCK 1 OF STEP 1 **/

              /** BOF BLOCK 2 OF STEP 1 **/
              var Block2 = '';
              for(i = 0; i < data.programmi.length; i++){
                Block2 += 'Nei dati OpenCoesione trovi un’informazione che potrebbe essere utile a seconda della qualità dei dati immessi dai soggetti programmatori. Si tratta della procedura amministrativa che ha dato inizio al finanziamento. Potrebbe essere il riferimento a un bando pubblico o a un altro atto amministrativo che puoi cercare su Internet.<br />';
                Block2 += 'La procedura che ha dato origine a questo progetto è <span class="guide-hilite">' + data.programmi[i].descr_proced_attivazione + '</span>.<br />';
                Block2 += 'La tipologia di questa procedura è <span class="guide-hilite">' + data.programmi[i].descr_tipo_proced_attivazione + '</span>';
              }

              $('#oc_guide_s1_2').html(Block2);

              /** EOF BLOCK 2 OF STEP 1 **/

              /** BOF BLOCK 3 STEP 1 **/
              var Block3 = '';
              Block3 += 'Cerca il titolo del tuo progetto nelle news!<br />';
              Block3 += 'Vai qui: <a target="_blank" href="https://news.google.com/search?hl=' + OC.config.lang + '&gl=' + OC.config.lang.toUpperCase() + '&ceid=' + OC.config.lang.toUpperCase() + ':' + OC.config.lang + '&q=' + data.oc_titolo_progetto + '" target="_blank" class="btn btn-primary btn-sm">CERCA SU GOOGLE "' + data.oc_titolo_progetto + '"</a><br />';
              Block3 += '<small><i>Il link si aprirà in un\'altra finestra.</i></small><br />';
              if(data.oc_sintesi_progetto && data.oc_sintesi_progetto != ' '){
                Block3 += 'Poi raffina la tua ricerca individuando delle parole chiave a partire dalla sintesi del progetto: <span class="guide-hilite">' + data.oc_sintesi_progetto + '</span>.';
              }
              $('#oc_guide_s1_3').html(Block3);
              /** EOF BLOCK 3 STEP 1 **/

              /** BOF BLOCK 4 STEP 1 **/
              var Block4 = '';

              var currentDate = new Date();
              var projectEndDate = new Date(OC.dateFormatter(data.oc_data_fine_progetto_prevista));

              if(data.oc_stato_progetto.toLowerCase() == 'in corso' && projectEndDate < currentDate ){
                Block4 += '<strong>Il tuo progetto sembra in ritardo, è davvero così?</strong><br />';
              }
              Block4 += 'Controlla sulla <a href="' + oc_api_url + '" target="_blank">pagina di progetto</a> di OpenCoesione. <br />';
              Block4 += 'Se i pagamenti salgono in modo uniforme o ci sono stati dei blocchi in passato… o ci sono ancora!<br />';
              Block4 += 'Potrebbe essere una domanda interessante da fare durante le interviste.<br />';


              $('#oc_guide_s1_4').html(Block4);
              /** EOF BLOCK 4 STEP 1 **/

              /** BOF BLOCK 5 STEP 1 **/
              var Block5 = '';

              /** EOF BLOCK 5 STEP 1 **/

              /** BOF BLOCK 6 STEP 1 **/
              var Block6 = '';
              Block6 += 'Secondo OpenCoesione, il progetto che hai scelto fa parte del tema <span class="guide-hilite">' + data.oc_tema_sintetico + '</span>.<br />';


              var sottotemi;
              $.ajax({
                url: '/ajax/sottotemi/' + data.cod_locale_progetto,
                dataType: 'json',
                async: false,
                success: function(data) {
                  sottotemi = data;
                }
              });


              if(data.oc_cod_tema_sintetico == '07'){
                //Theme: TRASPORTI
                var expert = '<span class="oc_expert">Gianpiero Di Muro</span>';
                var body = "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema. <br />" +
                           "<a href=\"https://www.monithon.it/guida-al-monitoraggio-civico-tema-trasporti/\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico</a> dell'Accordo di Partenariato 2014-2020 sull'obiettivo dedicato ai trasporti.<br />" +
                           "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!<br />" +
                           "Per un quadro generale sulle politiche nazionali messe in campo dal Ministero delle Infrastrutture e dei Trasporti, <a href=\"http://www.mit.gov.it/comunicazione/news/connettere-litalia-introduzione\" target=\"_blank\">consulta il quadro strategico sul sito del Ministero</a><br /> " +

                           "Per entrare più nello specifico, il nostro suggerimento principale è di cercare e leggere i piani di mobilità urbana della tua città. Verifica se la tua città ha approvato un Piano Urbano per la Mobilità Sostenibile (PUMS): troverai informazioni sullo stato dell'arte della mobilità urbana, l'analisi dei flussi, dati di prospettiva per lo sviluppo di scenari futuri, e le principali scelte sulle tipologie di investimento su cui puntare (es. grandi infrastrutture come metro e ferrovie oppure piste ciclabili).<br />" +
                           "Più probabilmente, potresti trovare un Piano Urbano di Mobilità (PUM), con la strategia sulla mobilità della tua città, oppure un Piano Urbano dei Trasporti (PUT), con gli strumenti di breve periodo da mettere in campo.<br />" +
                           "Se il tuo progetto riguarda una infrastruttura di livello regionale, cerca e consulta il Piano Regionale dei Trasporti (PRT) della tua regione.";

              }
              else if (data.oc_cod_tema_sintetico == '01') {
                var expert = '<span class="oc_expert">Osvaldo La Rosa</span>';
                var cod_spesa = sottotemi.OC_COD_CATEGORIA_SPESA;

                var flags = ['056', '057', '058', '059', '060', '061'];
                if(cod_spesa == '01' || cod_spesa == '02' || OC.subFinder(cod_spesa, flags)){
                  var body = "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                             "Consulta le <a href=\"<href = http://www.monithon.it/guida-al-monitoraggio-civico-tema-ricerca/ \" target=\"_blank\">linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato alla ricerca e all'innovazione. <br />" +
                             "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!<br />"+
                             "In particolare, sul tema specifico delle infrastrutture di ricerca puoi consultare il <a href=\" http://www.ponricerca.gov.it/notizie/2017/pnir/\" target=\"_blank\">Programma Nazionale per le Infrastrutture di Ricerca (PNIR)<br />"+
                             "<a href=\"https://www.apre.it/ricerca-europea/horizon-2020/excellent-science/research-infrastructures/\" target=\"_blank\">Approfondisci le caratteristiche delle infrastrutture di ricerca in ambito europeo</a><br />"+
                             "Per un quadro generale dei progetti di ricerca e innovazione presenti su OpenCoesione, puoi leggere anche <a hreF=\"https://opencoesione.gov.it/it/pillole/pillola-n-39-progetti-di-ricerca-e-innovazione-nelle-politiche-di-coesione-del-ciclo-2007-2013-analisi-dei-dati-di-monitoraggio-aggiornati-al-31-ottobre-2017/\" target=\"_blank\">questa analisi</a>.<br />";
                }
                else if (cod_spesa == '03' || cod_spesa == '04' || cod_spesa == '06'  || cod_spesa == '07' || cod_spesa == '09' || OC.subFinder(cod_spesa, ["001", "002", "004", "062", "063", "064"])){
                  var body =  "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                              "Consulta le <a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-ricerca/\" target=\"_blank\">linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato alla ricerca e all'innovazione.<br />" +
                              "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!<br />" +

                              "Tieni conto, poi, che tutti gli interventi di questo settore devono essere coerenti con le Strategie regionali e Nazionali per la Specializzazione intelligente. <a href=\"http://old2018.agenziacoesione.gov.it/it/S3/S3_Regionale/Strategie_Regionali_di_Specializzazione_Intelligente.html\" target=\"_blank\">Scarica qui</a> la strategia S3 della tua regione.<br />" +
                              "<a href=\"http://old2018.agenziacoesione.gov.it/it/S3/S3_Nazionale/Strategia_nazionale_di_specializzazione_intelligente.html\" target=\"_blank\">Qui trovi anche la Strategia Nazionale</a><br />" +
                              "Per un quadro generale dei progetti di ricerca e innovazione presenti su OpenCoesione, <a href=\"https://opencoesione.gov.it/it/pillole/pillola-n-39-progetti-di-ricerca-e-innovazione-nelle-politiche-di-coesione-del-ciclo-2007-2013-analisi-dei-dati-di-monitoraggio-aggiornati-al-31-ottobre-2017/\" target=\"_blank\">puoi leggere questa analisi</a>";
                }

              }

              else if(data.oc_cod_tema_sintetico == '05'){
                  var expert = '<span class="oc_expert">Francesca De Lucia</span>';
                  if(
                    (
                      sottotemi.OC_COD_CATEGORIA_SPESA == "49" ||
                      sottotemi.OC_COD_CATEGORIA_SPESA == "53" ||
                      sottotemi.OC_COD_CATEGORIA_SPESA == "53:::53" ||
                      sottotemi.OC_COD_CATEGORIA_SPESA == "54" ||
                      OC.subFinder( sottotemi.OC_COD_CATEGORIA_SPESA, ["087", "088"])
                    )
                    ||
                    (
                      OC.subFinder(sottotemi.OC_CODICE_PROGRAMMA, ["2015XXXXXPSO000", "2016PATTIABR", "2016PATTIBARI", "2016PATTICAGL", "2016PATTICAL", "2016PATTICAMP", "2016PATTICAT", "2016PATTIGEN", "2016PATTILOMB", "2016PATTIMES", "2016PATTIMIL", "2016PATTIMOL", "2016PATTIPAL", "2016PATTIPUG", "2016PATTISARD", "2016PATTISICI", "2016XXAMPSAP00", "2017POAMBIENFSC", "2018POFSCBO"])
                      &&
                      (sottotemi.OC_DESCR_SUBARTICOLAZ_PROGRAMMA == "Cambiamento climatico, prevenzione e gestione dei")
                    )
                  ) {

                    var body =  "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                                "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-ambiente-clima/\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato all'ambiente (clima e rischi climatici).<br />" +
                                "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!<br />" +

                                "Consulta il Piano Nazionale per il dissesto idrogeologico (ProteggItalia), per avere informazioni di contesto sul tema e sulle sulle politiche che si stanno mettendo in campo. <a href=\"http://www.governo.it/sites/governo.it/files/ProteggItalia_0.pdf\" target=\"_blank\">(Slides)</a><br />" +

                                "Se il progetto che hai scelto riguarda la prevenzione del rischio sismico, puoi verificare se il tuo Comune ha un piano di protezione civile e poi <a href=\"http://www.protezionecivile.gov.it/servizio-nazionale/attivita/prevenzione/piano-protezione-civile/mappa-piani-comunali\" target=\"_blank\">cercarlo sul web</a>";
                  }
                  else if(
                     (sottotemi.OC_COD_CATEGORIA_SPESA == "44" || OC.subFinder(sottotemi.OC_COD_CATEGORIA_SPESA, ["017", "118"]))
                     ||
                     (
                       (OC.subFinder( sottotemi.OC_CODICE_PROGRAMMA, ["2016PATTIBASIL","2016PATTICAMP","2016PATTIMES","2016PATTINAP","2016PATTIRC","2016PATTISARD","2017POAMBIENFSC"]) &&
                       (sottotemi.OC_DESCR_SUBARTICOLAZ_PROGRAMMA == "Gestione dei rifiuti urbani")
                     ))
                   ) {

                    var body = "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                    "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-ambiente-rifiuti\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato all'ambiente (clima e rischi climatici).<br />" +
                    "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!<br />" +

                    "Se vuoi conoscere quali sono gli obiettivi quantitativi di raccolta differenziata e di produzione dei rifiuti che si è data la tua regione, <a href=\"https://www.monitorpiani.it/#!/dati-ambientali/elenco-indicatori\" target=\"_blank\">verifica se la tua regione è presente tra i dati ambientali della piattaforma di Monitoraggio dei piani regionali di gestione dei rifiuti</a>.<br />";

                  }

              }

              else if(data.oc_cod_tema_sintetico == '08'){
                var expert = '';
                var body =  "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                            "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-occupazione/\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato all'occupazione.<br />" +
                            "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!";
              }

              else if(data.oc_cod_tema_sintetico == '11'){
                var expert = '';
                var body =  "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                            "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-occupazione/\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato all'istruzione.<br />" +
                            "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!";
              }

              else if(data.oc_cod_tema_sintetico == '09'){
                var expert = '<span class="oc_expert">Lorenzo Improta</span>';
                var body =  "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                            "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-inclusione/\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato all'inclusione sociale.<br />" +
                            "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!";
              }
              else if(data.oc_cod_tema_sintetico == '06'){
                var expert = '<span class="oc_expert">Rossella Almanza</span>';
                var body =    "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                              "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-ambiente-rifiuti\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato alla tutela e valorizzazione del patrimonio ambientale, naturale e culturale. <br />" +
                              "Troverai un\'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!<br />" +

                              "Per un quadro delle polirtiche nazionali messe i n campo dal  Ministero per i beni e le attività culturali e per il turismo <a href=\"http://www.programmazionestrategica.beniculturali.it\" target=\"_blank\">consulta il sito dedicato alla programmazione</a>. <br />" +
                              "Se sei interessato a conoscere le statistiche relative a visitaori e servizi dei siti culturali nazionali e della tua regione, <a href=\"http://www.statistica.beniculturali.it/Rilevazioni.htm\" target=\"_blank\">consulta il sito dell'Ufficio di statistica del MIBACT</a> e il progetto <a href=\"http://www.culturaitalia.it/opencms/museid/index_museid.jsp?language=it\">MuseiD-Italia</a>.<br />" +
                              "Altre informazione le potresti trovare sul sito dell'Ufficio di Statitstica della tua Regione.";
              }
              else if (data.oc_cod_tema_sintetico == '02'){
                var expert = '<span class="oc_expert">Marta Pieroni</span>';

                if( (sottotemi.OC_COD_CATEGORIA_SPESA == '10' || OC.subFinder(sottotemi.OC_COD_CATEGORIA_SPESA, ["045", "046", "047", "048"])) || sottotemi.OC_CODICE_PROGRAMMA == '2016MISEBULFSC1'){
                  var body = "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                  "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-ambiente-ad\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato all'agenda digitale (e in particolare alle infrastrutture digitali e ai servizi pubblici).<br />" +

                  "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!<br />" +

                  "Se il tuo progetto riguarda un intervento per la Banda Ultralarga, vai sul sito del Ministero dello Sviluppo Economico ed esplora i dati sull'avanzamento del Piano Nazionale Banda Ultralarga, che attua la Strategia nazionale italiana per la banda ultralarga. Troverai mappe e grafici con i comuni attualmente coperti e gli obiettivi di copertura in banda ultralarga in termini di unità immobiliari raggiunte: <a href=\"http://bandaultralarga.italia.it/\" target=\"_blank\">http://bandaultralarga.italia.it/</a>. Se sei interessato a dati elaborabili, cerca tra le news gli ultimi aggiornamento del Piano in termini di progetti avviati e conclusi. Ricorda che le Regioni possono realizzare anche piani autonomi al di fuori del \"Piano nazionale\", ma tutti i piani sono tra loro complementari per raggiungere, senza sovrapposizioni, il comune obiettivo europeo (consulta, se vuoi capire di cosa si tratta, il documento europeo <a href=\"https://eur-lex.europa.eu/legal-content/en/TXT/?uri=CELEX%3A52016DC0587\" target=\"_blank\">\"Connectivity for a Competitive Digital Single Market - Towards a European Gigabit Society\"</a>.";

                }
                else {
                  var body = "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                  "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-ad\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato all'agenda digitale (e in particolare alle infrastrutture digitali e ai servizi pubblici). <br />" +
                  "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!<br />" +

                  "Se il progetto che hai scelto intende sviluppare nuovi servizi digitali per la pubblica amministrazione, i cittadini e le imprese, <a href=\"https://guidadinamica.agid.gov.it\" target=\"_blank\">consulta la guida dinamica al Piano Triennale dell'Agenzia Italia Digitale</a>. Qui troverai i principali obiettivi nazionali per la creazione di servizi digitali per i cittadini, le imprese e la Pubblica Amministrazione. Puoi consultare inoltre i siti del <a href=\"http://www.teamdigitale.governo.it\" target=\"_blank\">Team digitale</a> e dell'<a href=\"http://www.agid.gov.it\" target=\"_blank\">Agenzia per l'Italia digitale</a> per conoscere i progetti nazionali che attuano la Strategia per la crescita digitale del nostro Paese. I progetti realizzati a livello regionale devono sempre essere coerenti con gli obiettivi definiti a livello nazionale. Se il progetto sviluppa iniziative e servizi dedicati alla scuola, puoi consultare anche il <a href=\"https://www.istruzione.it/scuola_digitale/\" target=\"_blank\">Piano nazionale Scuola Digitale</a> ";
                }

              }
              else if (data.oc_cod_tema_sintetico == '03'){
                var expert = '<span class="oc_expert"></span>';
                var body =  "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                            "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-ad\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato all'agenda digitale (e in particolare alle infrastrutture digitali e ai servizi pubblici).<br />" +
                            "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!";

              }
              else if (data.oc_cod_tema_sintetico == '13'){
                var expert = '<span class="oc_expert"></span>';
                var body =  "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-capacita-istituzionale/\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020</a> sull'obiettivo dedicato alla capacità istituzionale.<br />" +
                "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!";

              }
              else if (data.oc_cod_tema_sintetico == '04'){
                var expert = '<span class="oc_expert">Elena Donnari</span>';
                var body =  "Come prima cosa, è importante farsi un'idea dei grandi obiettivi di livello europeo e nazionale su questo tema.<br />" +
                "<a href=\"http://www.monithon.it/guida-al-monitoraggio-civico-tema-energia/\" target=\"_blank\">Consulta le linee nazionali di indirizzo strategico dell'Accordo di Partenariato 2014-2020 sull'obiettivo dedicato all'energia.<br />" +
                "Troverai un'analisi dei principali problemi che le politiche intendono affrontare, e i relativi obiettivi e azioni di carattere generale, a cui i diversi Programmi Operativi europei (e in particolare FESR e FSE) 2014-2020 contribuiscono a raggiungere.  Anche se il progetto che hai scelto è finanziato nella passata programmazione europea 2007-2013 o da fondi nazionali, è importante conoscere il quadro aggiornato degli obiettivi decisi in modo partecipato da tutte le amministrazioni italiane per l'utilizzo dei fondi europei nel 2014-2020. Ma attenzione, i testi di policy sono difficili da leggere e interpretare, se ne hai la possibilità chiedi aiuto a un esperto!";

              }

              else if (data.oc_cod_tema_sintetico == '12'){
                var expert = '<span class="oc_expert">Giovanni Pineschi</span>';
                var body =  "Guarda se esistono piani per lo sviluppo urbano nella tua città e consultali. Vedi ad esempio <a href=\"http://www.monithon.it/blog/2015/04/29/politiche-pubbliche-per-lo-sviluppo-territoriale-attraverso-la-valorizzazione-del-patrimonio-il-caso-di-pisa/\" target=\"_blank\">questa analisi</a> dei progetti inclusi nel Piano Integrato di Sviluppo Sostenibile di Pisa ";

              }
              else if (data.oc_cod_tema_sintetico == '10'){
                var expert = '<span class="oc_expert"></span>';

                var body =  "";

              }

              Block6 += body + expert;
              $('#oc_guide_s1_6').html(Block6);

              /** EOF BLOCK 6 STEP 1 **/

              /** Beni Confiscati **/
              var beni_confiscati;
              $.ajax({
                url: '/ajax/beni_confiscati/' + data.cod_locale_progetto,
                dataType: 'json',
                async: false,
                success: function(data) {
                  beni_confiscati = data;
                }
              });

              if(beni_confiscati.code == 200){
                var body = "<br />N.B. Il Progetto rientra nell'elenco dei <strong>Beni Confiscati alle Mafie</strong>";
                $('#oc_guide_s1_6').append(body);
              }



            });

            // Load S2 Template
            $('#oc_api_content_s2').load('/public/assets/guide_s2.php', function() {

              // P1
              if(data.oc_stato_progetto == 'In corso'){
                var prj_status = 'ancora in corso';
                var text =  'Valuta come sta andando di persona!<br />' +
                            'Fai foto e video mostrando il progresso nel tempo<br />' +
                            'Raccogli testimonianze sul suo avanzamento.<br />' +
                            'Cerca di capire quali possibili problemi sono incorsi durante la realizzazione… e non dimenticare di pensare a suggerimenti su come risolverli!<br />' +

                            'Se il progetto è iniziato da poco, potresti valutare la bontà della pianificazione: intervista i progettisti e i programmatori e chiedi che ti vengano mostrati i documenti di progettazione per poter verificare nel tempo i progressi.<br />' +
                            'Per esempio, dai un’occhiata a questa nostra <a href="http://www.monithon.it/blog/2014/02/22/monithon-2014-una-radiografia-completa-allanello-ferroviario-di-palermo/" target="_blank">analisi partecipativa sulla pianificazione di una grande infrastruttura di trasporto a Palermo.</a><br />' +

                            'Se il progetto ha già prodotto dei risultati, puoi iniziare a porti domande del tipo:<br />' +
                            '- Sta rispondendo alle aspettative? E’ realmente efficace per gli utenti finali? <br />' +
                            '- Cosa andrebbe fatto per renderlo più efficace?<br />';
              }
              else if(data.oc_stato_progetto == 'Concluso' || data.oc_stato_progetto == 'Liquidato'){
                var prj_status = 'già concluso!';
                var text =  'Verifica che lo sia veramente, e che tutto sia stato completato come pianificato.<br />' +
                            'Poi, puoi porti domande sui risultati e sul suo impatto dal punto di vista dell’utente finale, ad esempio:<br />' +
                            '- Ha risposto alle aspettative? E’ realmente efficace per gli utenti finali? <br />' +
                            '- Cosa andrebbe fatto per renderlo più efficace?<br />' +
                            'Programma delle interviste con gli utenti per verificare l’impatto del progetto nella tua comunità.<br />';
              }
              else if(data.oc_stato_progetto == 'Non avviato'){
                var prj_status = 'non essere ancora avviato';
                var text =  'E’ davvero così? Dall’ultimo aggiornamento dei dati di OpenCoesione il progetto potrebbe essere partito!<br />' +
                            'Se ancora non è avviato o è avviato da poco, potresti valutare la bontà della pianificazione: intervista i progettisti e i programmatori e chiedi che ti vengano mostrati i documenti di progettazione per poter verificare nel tempo i progressi. L’opera è realmente utile così come progettata?<br />' +
                            'Per esempio, dai un’occhiata a questa nostra <a href="http://www.monithon.it/blog/2014/02/22/monithon-2014-una-radiografia-completa-allanello-ferroviario-di-palermo/" target="_blank">analisi partecipativa sulla pianificazione di una grande infrastruttura di trasporto a Palermo.</a>';
              }
              $('.prj_status').text(prj_status);
              $('#oc_guide_s2_1').html(text);


              // P2 - this only applies if oc_cod_fonte = FS0714 or FS1420
              for(i = 0; i < data.programmi.length; i++){
                var po;
                var oc_cod_fonte = data.programmi[i].oc_cod_fonte;
                $.ajax({
                  url: '/ajax/programma_operativo/' + data.programmi[i].oc_codice_programma,
                  dataType: 'json',
                  async: false,
                  success: function(data) {
                    po = data;
                  }
                });

                if(oc_cod_fonte == 'FS0714' || oc_cod_fonte == 'FS1420'){

                  var adg_ref = po.nome_authority;
                  var text =  'E’ il soggetto responsabile della gestione e dell\'attuazione del  programma operativo. Le sue principali responsabilità sono:<br />' +
                              '<ul><li>assicurare che le attività selezionate per il finanziamento corrispondano ai criteri del programma operativo</li>' +
                              '<li>verificare che i prodotti e i servizi cofinanziati siano erogati in modo efficiente secondo le norme dell\'UE e nazionali</li>' +
                              '<li>registrare e archiviare dati e informazioni sui finanziamenti</li>' +
                              '<li>assicurare che le prestazioni di un programma operativo siano adeguatamente valutate</li></ul>' +
                              '(Fonte:  <a href="https://ec.europa.eu/regional_policy/en/policy/what/glossary/m/managing-authority" target="_blank">Commissione Europea</a>)<br /><br />' +

                              'Il responsabile dell’AdG è <strong>' + po.nome_responsabile + '</strong> <br />' + po.nome_authority + ' <br /> ' + po.indirizzo + ' <br /> <a href="mailto:' + po.email +'">' + po.email + '</a><br />';
                              'Visita il sito dell’Autorità di Gestione: <a href="'+po.url_adg+'" target="_blank">' + po.url_adg + '</a>';
                  $('.adg_ref').text(adg_ref);
                  $('#oc_guide_s2_2').html(text);
                  $('#adg').removeClass('d-none');
                }

              }

              // P3 - Roles
              var programmatori = [];
              var attuatori = [];
              var beneficiari = [];
              var realizzatori = [];
              for(i = 0; i < data.soggetti.length; i++){

                var roles = data.soggetti[i].ruoli;
                console.log(data.soggetti[i]);

                if($.inArray('Programmatore', roles) >= 0){
                  programmatori.push(data.soggetti[i]);

                  var label = '<strong>' + data.soggetti[i].denominazione + '</strong><br />';
                  var text =  'E’ soggetto cui compete la decisione di finanziare il progetto. <br />';

                  if(data.soggetti[i].indirizzo){ text += 'L’indirizzo è ' + data.soggetti[i].indirizzo + ', ' + data.soggetti[i].cap; }

                  $('#programmatori').append('<div class="subject">' + label + text + '</div>');
                }
                else if($.inArray('Attuatore', roles) >= 0){
                  attuatori.push(data.soggetti[i]);
                  var label = '<strong>' + data.soggetti[i].denominazione + '</strong><br />';
                  var text =  'Il soggetto responsabile dell\'attuazione del progetto. Nel caso dei Fondi Strutturali 2007-2013 corrisponde al "beneficiario" L’attuatore può a sua volta avvalersi di altri soggetti nella realizzazione del progetto <br />';
                  if(data.soggetti[i].indirizzo){ text += 'L’indirizzo è ' + data.soggetti[i].indirizzo + ', ' + data.soggetti[i].cap; }
                  $('#attuatori').append('<div class="subject">' + label + text + '</div>');
                }

                if($.inArray('Beneficiario', roles) >= 0){
                  beneficiari.push(data.soggetti[i]);
                  var label = '<strong>' + data.soggetti[i].denominazione + '</strong><br />';
                  var text =  'L’organismo pubblico o privato responsabile dell\'avvio e/o dell\'attuazione delle operazioni. Nel caso di progetti classificati come aiuti di Stato il beneficiario è il soggetto che riceve l\'aiuto.<br />';
                  if(data.soggetti[i].indirizzo){ text += 'L’indirizzo è ' + data.soggetti[i].indirizzo + ', ' + data.soggetti[i].cap; }
                  $('#beneficiari').append('<div class="subject">' + label + text + '</div>');
                }

                if($.inArray('Realizzatore', roles) >= 0){
                  realizzatori.push(data.soggetti[i]);
                  var label = '<strong>' + data.soggetti[i].denominazione + '</strong><br />';
                  var text =  'Il soggetto che realizza effettivamente il progetto. Nel caso di opere e lavori pubblici coincide con la società titolare del contratto di appalto che esegue materialmente l\'opera. Analogamente per un progetto di acquisto di beni o servizi, il realizzatore è individuabile nella società titolare del contratto di appalto chiamata a fornire i beni o ad erogare il servizio.<br />';
                  if(data.soggetti[i].indirizzo){ text += 'L’indirizzo è ' + data.soggetti[i].indirizzo + ', ' + data.soggetti[i].cap; }
                  $('#realizzatori').append('<div class="subject">' + label + text + '</div>');
                }
              }
              var sottotemi;
              $.ajax({
                url: '/ajax/sottotemi/' + data.cod_locale_progetto,
                dataType: 'json',
                async: false,
                success: function(data) {
                  sottotemi = data;
                }
              });
              console.log(sottotemi);

              /** Beni Confiscati **/
              var beni_confiscati;
              $.ajax({
                url: '/ajax/beni_confiscati/' + data.cod_locale_progetto,
                dataType: 'json',
                async: false,
                success: function(data) {
                  beni_confiscati = data;
                }
              });
              console.log(beni_confiscati);
              var domande_confiscati = '';
              var esempi_confiscati = '';
              if(beni_confiscati.code == 200){
                domande_confiscati += "<br /><strong>Il progetto che hai scelto sembra essere dedicato a un bene confiscato alle mafie!</strong><br />" +
"Potresti raccogliere ulteriori informazioni specifiche sul bene confiscato, come ad esempio:" +
"<ul><li>Storia e descrizione del bene: quando è stato costruito? Quando è stato sequestrato, a chi e perchè?</li>" +
"<li>Qual è il contesto territoriale in cui il bene si inserisce e le sue caratteristiche in termini economici, sociali, culturali?</li>" +
"<li>Qual era lo stato del bene al momento del sequestro e della confisca?</li>" +
"<li>Il bene ha già avuto in passato interventi di recupero e valorizzazione?</li>" +
"<li>Chi gestisce il bene attualmente? Quando è stato consegnato in gestione?</li>" +
"<li>Quali attività si svolgono?</li>" +
"<li>Il soggetto gestore è in grado di gestirlo effiacemente?</li>" +
"<li>Quanti utenti usufruiscono del bene annualmente?</li>" +
"<li>La destinazione di uso del bene è coerente con l'attività effettivamente svolta?</li>" +
"<li>Quali altri finanziamenti ha ricevuto o riceve il bene (es. per ristrutturazioni o in capo al soggetto gestore)?</li>" +
"<li>Quali criticità emergono nella gestione del bene? Es. la gestione è economicamente sostenibile? Quale modello di business è implementato?</li>" +
"<li>Quali soluzioni è possibile proporre per risolvere tali criticità?</li>" +
"<li>Quale impatto sul territorio è possibile stimare sulla base delle informazioni raccolte? il recupero del bene confiscato è utile alla comunità territoriale?</li>" +
"<li>Quali possibili ulteriori possibilità di valorizzazione è possibile consigliare?</li></ul>" +

"Scheda monitoraggio beni confiscati: <a href=\"https://docs.google.com/document/d/1WTy-6n3i9Dfb79_mBm7Sjuyhoch8x7jucZ2bcvWyO1k/edit#\" target=\"_blank\">report Castello di Ottaviano</a><br />Post: <a href=\"http://www.monithon.it/blog/2013/10/24/alle-pendici-del-magico-vesuvio/\" target=\"_blank\">Alle Pendici del Vesuvio</a>";

              }

              if(data.oc_cod_tema_sintetico == '07'){
                //Theme: TRASPORTI
                var sottotema = '';
                var expert = '<span class="oc_expert">Gianpiero Di Muro</span>';
                var body = "";

                var body2 = "Se il progetto che hai scelto di monitorare è concluso o comunque è possibile provare direttamente i nuovi servizi disponibili, queste sono domande che potreste farvi durante un \"test su strada\" e porvi (o porre!) le seguenti domande:<br />" +
                            "<ul><li>E’ migliorata la qualità del servizio? Come?</li>" +
                            "<li>Quali sono i nuovi servizi ora disponibili per gli utenti?</li>" +
                            "<li>Come vengono fornite le informazioni ai viaggiatori? (informazioni e aggiornamenti su scioperi, ritardi, tempi di attesa, guasti lungo le linee etc.). Es. Paline intelligenti; Call center; SMS; Sito Internet adattato per il cellulare, App per smartphone, non vengono fornite. Altrimenti come altro vengono fornite?</li>" +
                            "<li>Come si possono consultare gli orari? Es. Tabellone orari o paline o tabelloni elettronici; Download dal sito pdf oppure word; Pagina web statica; Pianificazione percorso via web o cellulare etc; non sono disponibili</li>" +
                            "<li>Il servizio di consultazione funziona bene? (da 0 a 5)<br />" +
                            "<li>Come si possono pagare i biglietti? Es. SMS; NFC; App per cellulare; codice QR; sito Internet; solo canali tradizionali. Come altro si possono pagare?<br />" +
                            "<li>Il servizio di biglietteria funziona bene? (da 0 a 5)<br />" +
                            "<li>Il biglietto che usi per questo mezzo vale anche per altri? Esiste una tariffazione integrata con altri mezzi di trasporto? E' calcolata in base allo spostamento? (Questo potrebbe essere un utile suggerimento per i decisori locali!)</li>" +
                            "<li>Quali sono le principali difficoltà riscontrate durante la prova del servizio?<br />" +
                            "<li>Quanto è elevato il livello di inquinamento acustico all'interno e all'esterno dell'infrastruttura? Ci sono numerose app per smartphone che potrebbero essere utili per misurare il rumore ambientale in decibel.</li></ul>" +
                            "Alcuni di questi spunti nascono dal lavoro sul campo di alcuni di noi, a partire da questo blog post http://www.monithon.it/blog/2013/09/05/aaa-cercasi-aiuto-per-i-progetti-di-mobilita/<br />" +

                            "Se invece il tuo progetto riguarda una piattaforma di infomobilità (ITS), alcune domande per le amministrazioni potrebbero essere:<br />" +
                            "<ul><li>Qual era l'obiettivo iniziale della piattaforma o servizio? (es. limitare il traffico o l'inquinamento ambientale)</li>" +
                            "<li>I dati raccolti sono utilizzati dall'amministrazione? In modo intensivo /regolare oppure saltuario? Vengono utilizzati anche per pianificazione in tema di mobilità o di sviluppo urbano?</li>" +
                            "<li>I dati sulla mobilità (es. spostamento in tempo reale dei mezzi di trasporto pubblico) sono rilasciati pubblicamente con licenze aperte per favoire lo sviluppo di app indipendenti?</li></ul>";
                var example = '<a href="http://www.monithon.it/blog/2014/02/22/monithon-2014-una-radiografia-completa-allanello-ferroviario-di-palermo/" target="_blank">Una “radiografia” completa all’Anello Ferroviario di Palermo</a>,  ' +
                              '<a href="https://monithon.org/reports/1458" target="_blank">Adeguamento normativo, riassetto funzionale e distributivo aerostazione passeggeri- aeroporto Sant\'Anna, Crotone </a>, ' +
                              '<a href="https://monithon.org/reports/1711" target="_blank">Finanziamento del ramo nord della tangenziale di Campobasso </a>';

              }
              else if (data.oc_cod_tema_sintetico == '01') {
                var sottotema = 'Infrastrutture per la ricerca e l\'innovazione';
                var expert = '<span class="oc_expert">Osvaldo La Rosa</span>';
                var cod_spesa = sottotemi.OC_COD_CATEGORIA_SPESA;
                var flags = ['056', '057', '058', '059', '060', '061'];
                if(cod_spesa == '01' || cod_spesa == '02' || OC.subFinder(cod_spesa, flags)){
                  var body = "Alla fine del tuo lavoro di ricerca documentale, potresti contattare l'ANVUR per acquisire il punto di vista di esperti tecnici sulla valenza strategica dell'investimento. Potrebbero fornirti consigli utili rispetto al metodo che puoi utilizzare per valutare una tipologia complessa di finanziamenti come quelli alle infrastrutture di ricerca. Puoi scrivere una email a <a href=\"mailto:comunicazione@anvur.it\">comunicazione@anvur.it</a>.";
                  var body2 = "Se il tuo progetto è concluso o comunque è già possibile verificare alcuni risultati, qui di seguito ci sono alcune domande che potresti porre direttamente agli intervistati.<br />" +
                              "Considerando gli effetti \"diretti\", il progetto finanziato ha permesso di<br />" +
                              "<ul><li>introdurre un'innovazione? Quale? Come giudicate l'innovatività e l'utilità dell'innovazione sviluppata?</li>" +
                              "<li>introdurre nuovi dotazioni tecnologiche più avanzate, che consentono di svolgere attività di ricerca prima non sviluppate?</li>" +
                              "<li>rinnovare la dotazione tecnologica relativa ad attività di ricerca già sviluppate?</li></ul>" +
                              "E' possibile anche provare a chiedere informazioni sugli effetti \"indiretti\" del progetto finanziato. Ad esempio, il progetto finanziato ha permesso di<br />"+
                              "<ul><li>rafforzare la collaborazione scientifica con organismi di ricerca operanti sugli stessi ambiti disciplinari?</li>" +
                              "<li>creare nuovi collegamenti con organismi di ricerca operanti in ambiti disciplinari nuovi, con possibili benefici di medio periodo sulla diversificazione dell'offerta scientifica?</li>" +
                              "<li>rafforzare la collaborazione con imprese che esprimono una domanda di innovazione nell'ambito di operatività dell'infrastruttura?</li>" +
                              "<li>migliorare lo stato dell'occupazione all'interno dell'infrastruttura (conslidando i rapporti di lavoro di addetti precari o consentendo l'impiego di nuovi lavoratori)?</li>" +
                              "<li>migliorare il posizionamento scientifico dell'infrastrutture nel contesto di riferimento, a livello nazionale e/o europeo?</li></ul>" ;
                  var example = '<a href="https://monithon.org/reports/1201" target="_blank">PLASS - platform for agrofood science and safety</a>,  <a href="https://monithon.org/reports/1199" target="_blank">Realizzazione di un centro per le biotecnologie e la ricerca biomedica a Palermo</a>';
                }
                else if (cod_spesa == '03' || cod_spesa == '04' || cod_spesa == '06'  || cod_spesa == '07' || cod_spesa == '09' || OC.subFinder(cod_spesa, ["001", "002", "004", "062", "063", "064"])){
                  var body =  "Alla fine del tuo lavoro di ricerca documentale, potresti contattare l'Airi – Associazione Italiana per la Ricerca Industriale per acquisire il punto di vista di esperti tecnici sulla valenza dell'investimento. Potrebbero fornirti consigli utili rispetto al metodo che puoi utilizzare per valutare una tipologia complessa di finanziamenti come quelli alla ricerca e all'innovazione.<br />" +
                              "AIRI – Associazione italiana per la ricerca industriale<br />" +
                              "Viale Gorizia, 25/c<br />" +
                              "I – 00198 Roma<br />" +
                              "Tel. +39 (06) 8848831<br />" +
                              "Tel. +39 (06) 8546662<br />" +
                              "Fax +39 (06) 8552949<br />" +
                              "e-mail: <a href=\"mailto:info@airi.it\">info (at) airi.it</a><br />" +
                              "<a href=\"https://www.airi.it/\" target=\"_blank\">https://www.airi.it/</a>";
                  var body2 = "Se il tuo progetto è concluso o comunque è già possibile verificare alcuni risultati, qui di seguito ci sono alcune domande che potresti porre direttamente agli intervistati.<br />" +
                                "Alcune domande riguardano i seguenti effetti \"diretti\" del progetto sull'innovazione:<br />" +
                                "<ul><li>Il progetto finanziato ha permesso di introdurre un'innovazione? Quale? Come giudicate l'innovatività e l'utilità dell'innovazione sviluppata? </li>" +
                                "<li>Il finanziamento monitorato è riuscito a portare una ricerca scientifica o tecnologica da uno stadio preliminare ad uno stadio prossimo a consentire l'industrializzazione del risultato?</li>" +
                                "<li>Il finanziamento ha prodotto un'innovazione capace di introdurre già un nuovo prodotto sul mercato?</li>" +
                                "<li>Quali ostacoli o passi mancanti sono necessari per rendere economicamente sostenibile l'innovazione finanziata attraverso il progetto che avete scelto?</li>" +
                                "<li>Il finanziamento monitorato ha permesso di ridisegnare i processi produttivi di un'azienda, rendendoli più efficiente dal punto di vista economico o ambientale, attraverso l'introduzione di una nuova soluzione tecnologica?</li></ul>" +

                                "Altre domande potrebbero riguardare degli effetti più indiretti del progetto finanziato. Ad esempio<br />" +
                                "<ul><li>Il progetto finanziato ha rafforzato la collaborazione con altre imprese della stessa filiera produttiva?</li>" +
                                "<li>Ha permesso di creare nuovi collegamenti con imprese operanti in una diversa filiera produttiva, con possibili benefici di medio periodo sulla diversificazione (tecnologica) del business?</li>" +
                                "<li>Ha rafforzato la collaborazione con enti di ricerca che possono offrire nuove soluzioni alla domanda di innovazione dell'impresa?</li></ul>" +

                                "Infine, un effetto indotto del progetto finanziato riguarda le sue conseguenze di medio-lungo termine sul vostro territorio, ad esempio:<br />" +
                                "<ul><li>il finanziamento ha permesso di migliorare lo stato dell'occupazione nell'impresa (conslidando i rapporti di lavoro di addetti precari o consentendo l'impiego di nuovi lavoratori)? Quanti nuovi posti di lavoro sono stati creati? Di che tipo? (es. full-time / part-time, tempo indeterminato / determinato, etc.)</li>" +
                                "<li>il progetto finanziato ha migiorato il posizionamento industriale/commerciale dell'impresa nel contesto produttivo di riferimento? Come? Con quali effetti sul fatturato e sul valore aggiunto dell'azienda?";
                  var example = '<a href="https://monithon.org/reports/1448" target="_blank">Realizzazione di una piattaforma di social computing</a>, ' +
                                '<a href="https://monithon.org/reports/1722" target="_blank">Digitalizzazione della rete di alta frequenza di un\'azienda lombarda</a>, '+
                                '<a href="https://monithon.org/reports/1687" target="_blank">La macchina ad energia solare</a>';

                }

              }
              else if(data.oc_cod_tema_sintetico == '05'){
                  var expert = '<span class="oc_expert">Francesca De Lucia</span>';
                  if(
                    (
                      sottotemi.OC_COD_CATEGORIA_SPESA == "49" ||
                      sottotemi.OC_COD_CATEGORIA_SPESA == "53" ||
                      sottotemi.OC_COD_CATEGORIA_SPESA == "53:::53" ||
                      sottotemi.OC_COD_CATEGORIA_SPESA == "54" ||
                      OC.subFinder( sottotemi.OC_COD_CATEGORIA_SPESA, ["087", "088"])
                    )
                    ||
                    (
                      OC.subFinder(sottotemi.OC_CODICE_PROGRAMMA, ["2015XXXXXPSO000", "2016PATTIABR", "2016PATTIBARI", "2016PATTICAGL", "2016PATTICAL", "2016PATTICAMP", "2016PATTICAT", "2016PATTIGEN", "2016PATTILOMB", "2016PATTIMES", "2016PATTIMIL", "2016PATTIMOL", "2016PATTIPAL", "2016PATTIPUG", "2016PATTISARD", "2016PATTISICI", "2016XXAMPSAP00", "2017POAMBIENFSC", "2018POFSCBO"])
                      &&
                      (sottotemi.OC_DESCR_SUBARTICOLAZ_PROGRAMMA == "Cambiamento climatico, prevenzione e gestione dei")
                    )
                  ) {
                    sottotema = 'Clima e rischi (dissesto idrogeologico + rischi)';
                    var body =  "";
                    var body2 =  "";
                    var example ='<a href="https://monithon.org/reports/1010" target="_blank">Adeguamento canale scolmatore di nord ovest</a>,  '+
                    '<a href="https://monithon.org/reports/1061" target="_blank">Realizzazione di una nuova eliosuperfice per azioni di mitigazione dei rischi ambientali</a>,  '+
                    '<a href="https://monithon.org/reports/1215" target="_blank">Piano di protezione civile del comune di Marcianise</a>, '+
                    '<a href="https://monithon.org/reports/1640" target="_blank">Costruzione di un canalone di gronda che protegge la città di Palma di Montechiaro (AG) dalle acque piovane</a>';
                  }
                  else if(
                    (
                      ( sottotemi.OC_COD_CATEGORIA_SPESA == "45" || sottotemi.OC_COD_CATEGORIA_SPESA == "45:::45"|| sottotemi.OC_COD_CATEGORIA_SPESA ==  "46" || sottotemi.OC_COD_CATEGORIA_SPESA == "46:::46" )
                      ||
                      ( OC.subFinder(sottotemi.OC_COD_CATEGORIA_SPESA, ["020","021","022"])
                    )
                  )
                  ||
                  (
                    (sottotemi.OC_CODICE_PROGRAMMA == "2016PATTIABR" || sottotemi.OC_CODICE_PROGRAMMA == "2016PATTIBASIL" || sottotemi.OC_CODICE_PROGRAMMA == "2016PATTICAMP" || sottotemi.OC_CODICE_PROGRAMMA == "2016PATTILAZ" || sottotemi.OC_CODICE_PROGRAMMA == "2016PATTILOMB" || sottotemi.OC_CODICE_PROGRAMMA == "2016PATTIMOL" || sottotemi.OC_CODICE_PROGRAMMA == "2016PATTIRC" || sottotemi.OC_CODICE_PROGRAMMA == "2016PATTISARD" || sottotemi.OC_CODICE_PROGRAMMA == "2016PATTIVEN" || sottotemi.OC_CODICE_PROGRAMMA == "2017POAMBIENFSC")
                    &&
                    (sottotemi.OC_DESCR_SUBARTICOLAZ_PROGRAMMA == "Servizio idrico integrato")
                  )
                ){
                    sottotema = 'Servizio idrico integrato';
                    var body =  "Se il progetto che hai scelto riguarda la depurazione, potresti contattare la struttura del Commissario Straordinario Unico per la Depurazione per ottenere maggiori informazioni sul progetto e sul suo stato di avanzamento.<br />" +
                                "Mail: <a href=\"mailto:commissario@commissariounicodepurazione.it\">commissario@commissariounicodepurazione.it</a><br />" +
                                "Recapiti telefonici: <br />" +
                                "Sede operativa (Sogesid S.p.A.) di Roma: 06-42082264<br />" +
                                "Ufficio locale (Sogesid S.p.A.) di Palermo: 091-6787111<br />";
                    var body2 =  "";
                    var example ='<a href="https://monithon.org/reports/1161" target="_blank">Interventi di manutenzione sull’impianto di depurazione sito in località Pantani e stazioni di sollevamento nel comune di Paola</a>,  '+
                    '<a href="https://monithon.org/reports/1457" target="_blank">Realizzazione di opere di adduzione dalla Diga sul Lordo a Siderno</a>,  '+
                    '<a href="https://monithon.org/reports/1454"" target="_blank">Potenziamento ed adeguamento dell\'impianto di depurazione di Acqua dei Corsari</a>';
                  }
                  else if(
                     (sottotemi.OC_COD_CATEGORIA_SPESA == "44" || OC.subFinder(sottotemi.OC_COD_CATEGORIA_SPESA, ["017", "118"]))
                     ||
                     (
                       (OC.subFinder( sottotemi.OC_CODICE_PROGRAMMA, ["2016PATTIBASIL","2016PATTICAMP","2016PATTIMES","2016PATTINAP","2016PATTIRC","2016PATTISARD","2017POAMBIENFSC"]) &&
                       (sottotemi.OC_DESCR_SUBARTICOLAZ_PROGRAMMA == "Gestione dei rifiuti urbani")
                     ))
                   ) {
                    sottotema = 'Rifiuti';
                    var body =  "";
                    var body2 =  "Quanta raccolta differenziata si faceva prima e quanta se ne fa ora grazie al progetto finanziato?<br />" +
                                  "Esempio per la raccolta differenziata: avete ricevuto kit per la raccolta differenziata? E' stata realizzata o potenziata l'isola ecologica?";
                    var example ='<a href="https://monithon.org/reports/1435" target="_blank">Adeguamento e ristrutturazione dei Centri Comunali di Raccolta a Martina Franca</a>,  '+
                    '<a href="https://monithon.org/reports/1648" target="_blank">Finanziamento dei piani comunali di raccolta differenziata a Napoli</a>';
                  }

              }
              else if(data.oc_cod_tema_sintetico == '08'){
                sottotema = '';
                var expert = '';
                var body =  "";
                var body2 =  "";
                var example="";
              }
              else if(data.oc_cod_tema_sintetico == '11'){
                sottotema = '';
                var expert = '';
                var body =  "";
                  var body2 =  "";
                  var example='<a href="https://monithon.org/reports/1656" target="_blank">Lavori di manutenzione straordinaria della Scuola Media "Dante Alighieri" di Pantelleria</a>'
              }
              else if(data.oc_cod_tema_sintetico == '09'){
                sottotema = '';
                var expert = '';
                var body =  "";
                var body2 =  "";
                var example = '<a href="https://monithon.org/reports/1077" target="_blank">Cura ut Valeas- Centro di aggregazione giovanile</a>,  '+
                '<a href="https://monithon.org/reports/1361" target="_blank">CEDA Centro di Educazione e Documentazione Ambientale "Pio La Torre" ed Isola Ecologica</a>  ';
              }
              else if(data.oc_cod_tema_sintetico == '06'){
                sottotema = '';
                var expert = '';
                var body =  "";
                var body2 =  "Se il tuo progetto riguarda il recupero o la valorizzazione del nostro patrimonio culturale e naturale, le seguenti domande potrebbero essere di ispirazione per formulare la traccia di intervista sul progetto che hai scelto di monitorare:<br />" +
                      "<ul><li> Quali sono le principali caratteristiche del sito (museo, area archeologica, chiesa, area naturale protetta,  itinerario naturale, etc)? E' visitabile?</li>" +
                       "<li>Quali sono i nuovi servizi disponibili per per i visitatori grazie al finanziamento ricevuto?</li>" +
                      "<li> Esiste uno spazio (fisico e/o digitale) nel quale è possibile avere aggiornamenti sul progetto? (es. sito web o pannelli per aggiornare i visitatori)</li>" +
                      "<li> Durante la realizzazione del progetto il sito ha dovuto interrompere le sue attività? Se sì, con quali conseguenze?</li>" +
                      "<li> Se il progetto è ancora in fase di cantiere, come il cantiere incide sul percorso di visita e sulla fruibilità?</li>" +
                      "<li> La comunicazione del progetto verso i visitatori è efficace? Quali canali sono utilizzati?</li>" +
                      "<li> La visita è adatta anche a persone con disabilità? (rampe, ascensori, bagni adatti, testi in braille, disegni a rilievo, ecc.) </li>" +
                      "<li> La visita è adatta anche a famiglie con bimbi piccoli? (percorsi per bambini, bagni con fasciatoi, spazi per lasciare il passeggino, servizio noleggio zaini per portare i bambini, ecc.)</li>" +
                      "<li> La visita è adatta anche a persone straniere? (quali servizi vengono forniti in lingue diverse dall’italiano? Es. Sito internet; Guide; Audioguide; Cartellonistica e segnaletica nel museo; Pieghevoli informativi; Pubblicazioni</li>" +
                      "<li> Il sito ha attivato modalità innovative per il dialogo con i visitatori? Es. social Media (specificare quali); Canale YouTube; Virtual tour; digital library; QR code; Applicazioni specifiche per smartphone e tablet (guide mobile, ecc.); altro (specificare)</li>" +
                      "<li> Quali opportunità didattiche sono offerte dal museo? Come il progetto finanziato ha contribuito o potrebbe contribuire?</li></ul>" +
                      "Se il progetto è  concluso e in funzione da tempo è possibile valutare se ha effettivamente raggunto i risultati prefissati. Ad esempio, potrebbe essere opportuno verificare:" +
                      "<ul><li>il numero dei visitatori è aumentato? se sì, quali  categorie in particolare (es. stranieri, giovani, famiglie, scuole, etc.);</li>" +
                      "<li>  la comunità locale (famiglie, scuole, ecc.) è stata direttamente coinvolta in iniziative  promosse dal museo /biblioteca / parco, ecc.?</li>" +
                      "<li>  quali sono gli effetti delle attività di comunicazione e promozionali realizzate rispetto ai target individuati?</li></ul>" +
                      "Approfondisci questi suggerimenti in <a href=\"http://www.monithon.it/blog/2014/04/21/monithon-museo-egizio-di-torino-appunti-e-riflessioni-2/\" target=\"_blank\">questo nostro blog post</a> sviluppato dalla comunità Monithon Piemonte";

                  var example = '<a href="https://monithon.org/reports/1010" target="_blank">Restauro apparati decorativi della Casa della Venere in Conchiglia</a>,  '+
                  '<a href="https://monithon.org/reports/1524" target="_blank">Recupero del Mastio della Cittadella di Torino</a>,  '+
                  '<a href="https://monithon.org/reports/1271" target="_blank">Restauro del Teatro Apollo di Lecce</a>,  '+
                  '<a href="https://monithon.org/reports/1271" target="_blank">Restauro e consolidamento di edifici appartenenti al complesso architettonico dell\'Antico Convento dei Cappuccini di Grottaglie</a>,  '+
                  '<a href="https://monithon.org/reports/1354" target="_blank">Prevenzione agli incendi, la messa in sicurezza e i servizi a disposizione dei visitatori nella celebre riserva naturale siciliana dello “Zingaro”</a>';
              }
              else if (data.oc_cod_tema_sintetico == '02'){
                var expert = '<span class="oc_expert">Marta Pieroni</span>';

                if( (sottotemi.OC_COD_CATEGORIA_SPESA == '10' || OC.subFinder(sottotemi.OC_COD_CATEGORIA_SPESA, ["045", "046", "047", "048"])) || sottotemi.OC_CODICE_PROGRAMMA == '2016MISEBULFSC1'){
                  sottotema = "Infrastrutture digitali";
                  var example;
                  var body = "Se il progetto che hai scelto riguarda un intervento Banda Ultralarga, contatta il team di Infratel alla seguente email: comunicazioni@infratelitalia.it. La sede operativa di Infratel è presso il Ministero dello sviluppo economico, Viale America, 201 - 00144 Roma.";
                  var body2 = "Se il tuo progetto riguarda la banda ultralarga, le tue domande potrebbero essere: - quale modello di intervento è stato scelto per l'attuazione di questo progetto (es. costruzione di una rete di proprietà pubblica - modello \"diretto\"; costruzione di una rete di proprietà privata - modello \"a contributo;\" costruzione di una rete in partnership pubblico/privata); - in che proporzione la rete è realizzata in fibra ottica, rispetto a soluzioni wireless?; - quanti cantieri per lavori pubblici è stato necessario aprire (o sono previsti) e in media quanto dura l'apertura di un cantiere? - quali sono le principali criticità legate all'apertura/chiusura dei cantieri? - come è misurato l'avanzamento del progetto e quello della copertura in banda ultralarga delle zone interessate? - quali erano gli obiettivi, sono stati raggiunti? - attraverso quali passaggi la rete realizzata può essere resa disponibile agli utenti? il progetto prevede una misurazione dell'impatto sull'utente finale? Come si misura, o si potrebbe misurare tale impatto?";
                }
                else {
                  var example;
                  sottotema = 'Servizi digitali';
                  var body = "Se il progetto che hai scelto riguarda i servizi digitali per la pubblica amministrazione, i cittadini e le imprese potresti contattare Agid o il Team digitale (teamdigitale@governo.it) per capire come l'intervento realizzato, a livello nazionale o regionale, si colloca nella strategia nazionale per la crescita digitale del Paese: ad esempio quali caratteristiche dovrebbe avere per portare effettivi benefici, come questi impatti saranno misurati a livello nazionale.<br /> " +
                  "I contatti di AGID sono:<br /> " +
                  "Via Liszt 21 - 00144 Roma<br /> " +
                  "Telefono: +39 06852641<br /> " +
                  "PEC: <a href=\"mailto:protocollo@pec.agid.gov.it\">protocollo@pec.agid.gov.it</a><br /> " +
                  "<a href=\"mailto:stampa@agid.gov.it\">stampa@agid.gov.it</a><br /> " +
                  "Se invece il progetto riguarda i servizi e iniziative digitali per le scuole, potresti contattare il Miur - Autorità di Gestione del PON Scuola -  per avere chiarimenti sulla tipologia e le finalità della tipologia di progetto (ad esempio laboratorio tecnologico o digitale, rete di connettività per la scuola, iniziativa di formazione sul digitale, ecc)";

                  var body2 = "Se il tuo progetto riguarda i servizi digitali per la pubblica amministrazione, i cittadini e le imprese, le tue domande potrebbero essere: <br />" +
                              "<ul><li>quali sono i destinatari del progetto (ad es. la pubblica amministrazione: regione, comuni della regione; cittadini; imprese); </li>" +
                              "<li>che tipo di progetto si sta realizzando? (ad esempio: dotazione di hardware e software digitalizzare i processi interni dell'ente, gestione di dati e banche dati di interesse pubblico, piattaforme nazionali abilitanti per l'erogazione di servizi, servizi digital per il cittadini, servizi per le imprese, tecnologie per le città intelligenti, postazioni digitali a disposizione della cittadinanza ecc);</li>" +
                              "<li> cosa cambia dopo la conclusione del progetto? (es. i processi interni all'ente pubblico sono semplificati e i tempi di risposta sono ridotti, il cittadino può fruire di un servizio on line invece di recarsi allo sportello, la città ha un sistema di sensoristica in grado di raccogliere dati per l'erogazione di servizi in tempo reale..ecc); </li>" +
                              "<li> esiste uno spazio fisico e/o digitale dove avere informazioni sul progetto?; se è un servizio digitale già utilizzabile, con quali strumenti si può accedere?; </li>" +
                              "<li> è stata pianificata un'iniziativa di informazione/formazione sul progetto? </li>" +
                              "<li> Il progetto ha tenuto conto dell'impatto delle proprie attività sull'utente finale? Come misura tale impatto?</li><li>I dati di impatto sono resi pubblici?</li></ul>" +

                               "Se il progetto riguarda i servizi digitali per la scuola, <br />" +
                              "<ul><li> che tipo di progetto si sta realizzando (ad esempio: laboratorio tecnologico, ambienti digitali per la didattica innovativa, reti di connettività..ecc); </li>" +
                              "<li> quante sono le scuole interessate? </li>" +
                              "<li> l'iniziativa copre il fabbisogno potenziale delle scuole che necessiterebbero interventi? in quale misura? </li>" +
                              "<li>quali sono le criticità che possono emergere a valle dell'intervento (es. gestione delle tecnologie e dei laboratori attivati; sicurezza degli ambienti dove sono collocati i dispositivi tecnologici); </li>" +
                              "<li>esistono valutazioni circa l'impatto delle tecnologie sulla didattica? </li>" +
                              "<li>le scuole possono fornire feedback sull'efficacia degli interventi in relazione ai bisogni?</li></ul>" +

                               "Se il tuo progetto riguarda settori specifici quali il turismo e la cultura, le tue domande potrebbero essere:  <br />" +
                              "<ul><li>quali sono i destinatari del progetto?; </li>" +
                              "<li>qual è l’obiettivo?; </li>" +
                              "<li>cosa portano in più le nuove tecnologie e/o i servizi digitali introdotti dal progetto?</li>" +

                               "Se il tuo progetto riguarda settori specifici quali l’inclusione sociale, le tue domande potrebbero essere: <br />" +
                              "<ul><li>quali sono i destinatari del progetto?; </li>" +
                              "<li>qual è l’obiettivo?; </li>" +
                              "<li> su quale dimensione del disagio sociale e/o del divario digitale si interviene? </li>" +
                              "<li> l'iniziativa copre il fabbisogno potenziale dei soggetti che necessiterebbero interventi? </li>" +
                              "<li> cosa portano in più le nuove tecnologie e/o i servizi digitali introdotti dal progetto?</li></ul>";
                }
              }
              else if (data.oc_cod_tema_sintetico == '03'){
                sottotema = '';
                var expert = '';
                var body =  "";
                var body2  = "";
                var example;
              }
              else if (data.oc_cod_tema_sintetico == '13'){
                sottotema = '';
                var expert = '';
                var body =  "";
                var example;
              }
              else if (data.oc_cod_tema_sintetico == '04'){
                sottotema = '';
                var expert = '';
                var body =  "";
                var body2  = "";
                var example;
              }
              else if (data.oc_cod_tema_sintetico == '12'){
                sottotema = '';
                var expert = '';
                var body =  "";
                var body2  = "";
                var example = '<a href="https://monithon.org/reports/1401" target="_blank">Riqualificazione di piazza Savignano ad Aversa (Napoli)</a>';
              }
              else if (data.oc_cod_tema_sintetico == '10'){
                sottotema = '';
                var expert = '';
                var body =  "";
                var body2  = "";
              }

              $('#guide_s2 .hiliter.theme').text(data.oc_tema_sintetico);
              $('#guide_s2 .hiliter.subtheme').text(sottotema);
              $('#oc_guide_s2_4').html(body + expert);

              $('#oc_guide_s2_5').html(body2 + expert + domande_confiscati);
              $('#oc_guide_s2_6').html(example + esempi_confiscati);


            });
          }
        });
      });
  },

  dateFormatter: function(s){
    var date = '';
    var year  = s.slice(0, 4);
    var month = s.slice(4, 6);
    var day   = s.slice(6, 8);
    date = year + '-' + month + '-' + day;
    return date;
  },

  getProjectCode: function(theUrl){
    var urlPieces = theUrl.replace(/\/$/, "").split('/');
    return urlPieces.slice(-1).pop();
  },

  getSubjectCode: function(theUrl){
    var urlPieces = theUrl.replace(/\/$/, "").split('/');
    return urlPieces[6];
  },

  storeReturn: function(data){
    return data;
  },

  subFinder: function(string, array){
    console.log(string);
    var indexer = 0;
    for(i = 0; i < array.length; i++){
      indexer = string.indexOf(array[i]);
      if( indexer >= 0){
        return true;
      }
    }
  }

}

OpenCoesione.init();
