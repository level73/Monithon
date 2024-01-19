var LiteReport = {
    config: {
        version: 0.1,
        api_url: 'https://opencoesione.gov.it/it/api/progetti/',
        api_format: '/?format=json',
        lang: 'it' // TODO: Change to dynamically set param from Monithon.config
    },

    init: function(){
        console.log('LiteReport v. ' + this.config.version);


    },

    getProject: function(){

    }
};

LiteReport.init();