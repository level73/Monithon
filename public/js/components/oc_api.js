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

    $('#oc_api_code_lookup').click( function(e){
        $('#oc_api_content').removeClass('invisible');
        e.preventDefault();
        console.log(config);
        // Get the Code
        var oc_api_code = $('#oc_api_code').val();
        // build the JSON API URL
        var oc_api_endpoint = config.api_url + oc_api_code + config.api_format;
        console.log(oc_api_endpoint);

        $.getJSON('/ajax/oc_api/' + oc_api_code, {'code': oc_api_code}, function(data){
          console.log(data);
          var response = '<h2>' + data.descrizione_grande_progetto + '</h2>';
          response += '<span class="status">' + data.oc_stato_progetto + '</span> | ';
          response += '<span class="date">' + data.oc_data_inizio_progetto + ' - ' + data.oc_data_fine_progetto_prevista + '</span>';
          $('#oc_api_content').html(response);
        });
      });
  }
}

OpenCoesione.init();
