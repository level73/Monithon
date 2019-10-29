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
          // Load S1 Template
          $('#oc_api_content_s1').load('/public/assets/guide_s1.php', function(){
            var Block1 = '';

            for(i = 0; i < data.programmi.length; i++){
              Block1 += 'Il tuo progetto è finanziato dal <strong><a href="' + oc_api_url + '">' + data.programmi[i].oc_descrizione_programma + '</a></strong><br />';
              if(data.programmi[i].oc_cod_fonte == 'FS0713' || data.programmi[i].oc_cod_fonte == 'FS0713'){
                var descr_obiettivo_specifico = data.programmi[i].descr_obiettivo_specifico;
                if(data.programmi[i].descr_obiettivo_specifico == '') {
                  descr_obiettivo_specifico = 'N.D.';
                }
                Block1 += 'Per rispondere a questo obiettivo specifico: <span class="">' + descr_obiettivo_specifico + '</span><hr />';
              }
            }




            $('#oc_guide_s1_1').html(Block1);

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
