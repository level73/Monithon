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
        $('#oc_api_content').removeClass('invisible');
        e.preventDefault();
        console.log(config);
        // Get the Code
        var oc_api_code = $('#oc_api_code').val().toLowerCase();
        // build the JSON API URL
        var oc_api_endpoint = config.api_url + oc_api_code + config.api_format;
        console.log(oc_api_endpoint);

        $.getJSON('/ajax/oc_api/' + oc_api_code, {'code': oc_api_code}, function(data){
          console.log(data);

          // Make dates
          var data_inizio     = OC.dateFormatter(data.oc_data_inizio_progetto);
          var data_fine_prev  = OC.dateFormatter(data.oc_data_fine_progetto_prevista);

          var response = '<h2>' + data.descrizione_grande_progetto + '</h2>';
          response += '<span class="status">' + data.oc_stato_progetto + '</span> | ';
          response += '<span class="date">' + data_inizio + ' - ' + data_fine_prev + '</span>';
          $('#oc_api_content').html(response);
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
  }
}

OpenCoesione.init();
