var LiteReport = {
    config: {
        version: 0.1,
        api_url: 'https://opencoesione.gov.it/it/api/progetti/',
        api_format: '/?format=json',
        lang: 'it' // TODO: Change to dynamically set param from Monithon.config
    },

    init: function(){
        console.log('LiteReport v. ' + this.config.version);
        LiteReport.getProject();
        if($('#oc_api_code').val() != '' && $('#oc_api_code').val() !== undefined){
            console.log($('#oc_api_code').val());
            $('#oc_api_code_lookup').trigger('click');
        }
    },

    getProject: function(){
        $('#oc_api_code_lookup').click( function(e) {
            console.log('Researching OC API....');
            $('#oc_api_content').removeClass('d-none');
            e.preventDefault();

            // Get the Code
            var oc_api_url = $('#oc_api_code').val().toLowerCase();
            var oc_api_code = LiteReport.getProjectCode(oc_api_url);

            // build the JSON API URL
            var oc_api_endpoint = LiteReport.config.api_url + oc_api_code + LiteReport.config.api_format;
            console.log(oc_api_endpoint);

            $.getJSON('/ajax/oc_api/' + oc_api_code, {'code': oc_api_code}, function(data) {
                console.log(data);
                if (data.code == '404') {
                    alert('Non trovo il progetto! Controlla di aver copiato ed incollato la URL correttamente, e riprova.');
                    // $('#oc_api_content_s1, #oc_api_content_s2').addClass('d-none');
                } else {
                    // Inject data into hidden field
                    $('#oc-api-spinner').addClass('d-none');
                    $('#api_data').val(JSON.stringify(data));
                    $('#project_code').val(oc_api_code);

                    $('#oc_api_project_title').html(data.oc_titolo_progetto);
                    if(!$('form').hasClass('edit-lite-report')){
                        $('input#titolo').val(data.oc_titolo_progetto);
                    }
                    $('#oc_api_project_synth').html(data.oc_sintesi_progetto);

                    $('ul#oc_api_project_beneficiaries li').remove();
                    let Beneficiaries = LiteReport.getBeneficiaries(data);
                    Beneficiaries.forEach(soggetto => {
                        let url = soggetto.url.split('/');
                        let el = '<li><a href="https://opencoesione.gov.it/it/dati/soggetti/' + url[6] + '" target="_blank">' + soggetto.denominazione + '</a></li>';
                        $('ul#oc_api_project_beneficiaries').append(el);

                    });

                }
            });
        });
    },

    getProjectCode: function(theUrl){
        var urlPieces = theUrl.replace(/\/$/, "").split('/');
        return urlPieces.slice(-1).pop();
    },

    getBeneficiaries: function(data){
        var Beneficiaries = [];
        data.soggetti.forEach(soggetto => {

            if(soggetto.ruoli.includes("Beneficiario")){
                Beneficiaries.push(soggetto);
            }
        });
        return Beneficiaries;
    },
};

LiteReport.init();