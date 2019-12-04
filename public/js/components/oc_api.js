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
        $('#oc_api_content_s1').removeClass('d-none');
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
            $('#oc_api_content_s1').addClass('d-none');
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
              console.log(currentDate);
              console.log(projectEndDate);
              console.log(data.oc_data_fine_progetto_prevista);

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

              console.log(data.oc_cod_tema_sintetico);
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
                console.log(cod_spesa);
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
            });


            /*
            // Make dates
            var data_inizio     = OC.dateFormatter(data.oc_data_inizio_progetto);
            var data_fine_prev  = OC.dateFormatter(data.oc_data_fine_progetto_prevista);

            var response = '<h2>' + data.descrizione_grande_progetto + '</h2>';
            response += '<span class="status">' + data.oc_stato_progetto + '</span> | ';
            response += '<span class="date">' + data_inizio + ' - ' + data_fine_prev + '</span>';
            $('#oc_api_content').html(response);
            */
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
