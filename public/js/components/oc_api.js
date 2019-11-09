var OpenCoesione = {

  config: {
    api_url: 'https://opencoesione.gov.it/it/api/progetti/',
    api_format: '/?format=json',
  },


  init: function(){
    console.log(this.config.api_url);
    this.getProject();
  },

  getProject: function(){
    var config = this.config;
    var OC = this;

    $('#oc_api_code_lookup').click( function(e){
        $('#oc_api_content_s1').removeClass('invisible');
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

          if(data.code == 404){
            alert('Sembra che il codice progetto non sia disponibile nella API di OpenCoesione. Controlla di aver copiato ed incollato correttamente la URL del Progetto.');
          }

          else {

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

              console.log(po);


              Block1 += 'Il tuo progetto è finanziato dal <strong><a href="' + po.url_oc + '">' + data.programmi[i].oc_descrizione_programma + '</a></strong><br />';

              if(oc_cod_fonte == 'FS0713' || oc_cod_fonte == 'FS0713'){
                var descr_obiettivo_specifico = data.programmi[i].descr_obiettivo_specifico;
                if(data.programmi[i].descr_obiettivo_specifico == '') {
                  descr_obiettivo_specifico = 'N.D.';
                }
                Block1 += 'Per rispondere a questo obiettivo specifico: <span class="guide-hilite">' + descr_obiettivo_specifico + '</span><br />';
              }
              if(po.pdf_po){
                Block1 += '<a href="' + po.pdf_po + '">Scarica il testo del Programma</a> e cerca gli obiettivi all’interno del documento.<br />';
              }
              if(po.url_ec){
                Block1 += 'Vedi la <a href="' + po.url_ec + '" target="_blank">sintesi del programma sul sito della Commissione Europea</a>.';
              }

              if(oc_cod_fonte == 'FSC0713' || oc_cod_fonte == 'FSC1420' || oc_cod_fonte == 'PAC' || oc_cod_fonte == 'PAC1420'){
                Block1 += 'Il tuo progetto è stato finanziato da fondi nazionali per la coesione.<br />';
              }

              if( (oc_cod_fonte == 'FSC1420' || oc_cod_fonte == 'PAC1420') && po.url_del_cipe) {
                Block1 += 'Leggi la delibera del CIPE che descrive gli obiettivi dell’intervento. <a href="'+ po.url_del_cipe +'">' + po.del_cipe + '</a>';
              }
              if(oc_cod_fonte == 'FSC0713'){
                Block1 += 'Consulta <a href="https://opencoesione.gov.it/media/uploads/relazione_fsc_regionale_2007_2013.pdf">questa relazione sull’utilizzo del Fondo Sviluppo e Coesione nel 2007-13</a>.<br />';
              }
              if(oc_cod_fonte == 'PAC'){
                Block1 += 'Consulta il Piano Azione Coesione del 2011<br />';
              }
              if(po.oc_tipologia_programma_fsc && po.oc_tipologia_programma_fsc.toLowerCase() == 'patti per lo sviluppo'){
                Block1 += '<a href="' + po.url_interventi_patti + '">Scarica la scheda degli interventi</a>.';
              }

            }

            $('#oc_guide_s1_1').html(Block1);
            /** EOF BLOCK 1 OF STEP 1 **/

            /** BOF BLOCK 2 OF STEP 1 **/
            var Block2 = '';
            for(i = 0; i < data.programmi.length; i++){
              Block2 += 'Nei dati OpenCoesione trovi un’informazione che potrebbe essere utile a seconda della qualità dei dati immessi dai soggetti programmatori. Si tratta della procedura amministrativa che ha dato inizio al finanziamento. Potrebbe essere il riferimento a un bando pubblico o a un altro atto amministrativo che puoi cercare su Internet.<br />';
              Block2 += 'La procedura che ha dato origine a questo progetto è <span class="guide-hilite">' + data.programmi[i].descr_proced_attivazione + '</span>.<br />';
              Block2 += 'Si tratta di <span class="guide-hilite">' + data.programmi[i].descr_tipo_proced_attivazione + '</span>';
            }

            $('#oc_guide_s1_2').html(Block2);

            /** EOF BLOCK 2 OF STEP 1 **/

            /** BOF BLOCK 3 STEP 1 **/
            var Block3 = '';
            Block3 += 'Cerca il titolo del tuo progetto nelle news!<br />';
            Block3 += 'Vai qui: <a href="https://news.google.com/search?q=' + data.oc_titolo_progetto + '" target="_blank" class="btn btn-primary btn-sm">CERCA SU GOOGLE "' + data.oc_titolo_progetto + '"</a><br />';
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
            Block4 += 'Controlla sulla pagina di progetto di <a href="' + oc_api_url + '" target="_blank">OpenCoesione</a>. <br />';
            Block4 += 'Se i pagamenti salgono in modo uniforme o ci sono stati dei blocchi in passato… o ci sono ancora!<br />';
            Block4 += 'Potrebbe essere una domanda interessante da fare durante le interviste.<br />';


            $('#oc_guide_s1_4').html(Block4);
            /** EOF BLOCK 4 STEP 1 **/

            /** BOF BLOCK 5 STEP 1 **/
            var Block5 = '';
            Block5 += 'Secondo OpenCoesione, il progetto che hai scelto fa parte del tema <span class="guide-hilite">' + data.oc_tema_sintetico + '</span>.<br />';
            Block5 += 'Guarda il video dell’esperto tematico di Monithon, potresti trovare qualche consiglio utile alle tue ricerche!';
            $('#oc_guide_s1_5').html(Block5);

            /** EOF BLOCK 5 STEP 1 **/

            /** BOF BLOCK 6 STEP 1 **/

            /** EOF BLOCK 6 STEP 1 **/
          });

          }


          /*
          // Make dates
          var data_inizio     = OC.dateFormatter(data.oc_data_inizio_progetto);
          var data_fine_prev  = OC.dateFormatter(data.oc_data_fine_progetto_prevista);

          var response = '<h2>' + data.descrizione_grande_progetto + '</h2>';
          response += '<span class="status">' + data.oc_stato_progetto + '</span> | ';
          response += '<span class="date">' + data_inizio + ' - ' + data_fine_prev + '</span>';
          $('#oc_api_content').html(response);
          */
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
    return urlPieces.slice(-1).pop()

  }

}

OpenCoesione.init();
