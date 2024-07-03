var IMNTR = {

    Bidders: [],
    InspectionSites: [],

    config: {
        version: '0.0.1',
        opentenderBaseURL: "https://open-api.staging.opentender.eu/search/"
        //opentenderBaseURL: "http://135.181.208.42:8848/"
    },

    opentenderLabels: {
        it: {
            SINGLE_BID: "Singola offerta",
            ADVERTISEMENT_PERIOD: "Durata del periodo di presentazione delle offerte",
            DECISION_PERIOD: "Durata del periodo di aggiudicazione",
            CALL_FOR_TENDER_PUBLICATION: "Pubblicazione del bando di gara",
            PROCEDURE_TYPE: "Tipo di procedura",
            TAX_HAVEN: "Paradiso fiscale",
            BUYER_CONCENTRATION: "Quota contrattuale del fornitore della spesa dell’acquirente per gli appalti pubblici",
            //"BENFORDS_LAW_FOR_BID_PRICES": "",
            NEW_COMPANY: "Nuova azienda",
        }
    },

    init: function(){
        this.getSubdomain();
        this.openTenderLookup();

        this.repeatField();
        this.triggerDisplay();
        this.calculateAggregates();
        this.calculatePercentage();
        this.calculateDateDiff();
        this.calculateDiff();

        this.updateInspectionSites();
        this.inspectionSiteStep2();
        this.statusDepTriggers();

        this.contractModificationsSubdep();

        // Enable BS Popovers
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

        $(document).ready(function() {
            if($('#imonitor-contract-url').length > 0 && $('#imonitor-contract-url').val() ){
                let tenderId = IMNTR.parseOpenTenderUrl($('#imonitor-contract-url').val());
                IMNTR.getTender(tenderId);
            }
        });
    },

    getSubdomain: function(){
        let url = window.location.origin;
        if (url.includes("://")) {
            domain = url.split('://')[1];
        }
        const subdomain = domain.split('.')[0];
        IMNTR.ISO2 = subdomain;
    },

    getTender: function( tenderId ){
        var fetchStatus;


        $.getJSON(
            '/ajax/getTenderById?tender=' + tenderId,
            //IMNTR.config.opentenderBaseURL + 'tender_by_id?tender_id=' + tenderId,
            //{ 'id':  tenderId },
            function(data){
                console.log(data);

                $('#opentender-json').val(JSON.stringify(data));

                // flag
                let flagUrl = "https://flagcdn.com/" + data.country.toLowerCase() + '.svg';

                $('h3#imonitor-ot-title span').text(data.title);
                $('h3#imonitor-ot-title img').attr('src', flagUrl).removeClass('d-none');

                // Check for EU Funding
                let euFunding = false;
                if(data.hasOwnProperty('fundings')){
                     euFunding = data.fundings[0].isEuFund;
                }
                if(!euFunding){
                    $('input#imonitor-report-eu-funded2').prop('checked', true);
                }
                else {
                    $('input#imonitor-report-eu-funded1').prop('checked', true);
                    if(data.fundings[0].hasOwnProperty('programme')){
                        $('input#imonitor-report-project-programme').val(data.fundings[0].programme);
                    }
                }

                //CUP Code
                if(data.lots[0].hasOwnProperty("fundings")){
                    $('#imonitor-report-project-cup').val(data.lots[0].fundings[0].programme);
                }
                // CIG Code
                if(data.lots[0].hasOwnProperty("contractNumber")){
                    $('#imonitor-report-contract-cig').val(data.lots[0].contractNumber);
                }

                if(data.title !== undefined ) { $('input#imonitor-report-contract-title').val(data.title); }
                if(data.ot.cpv !== undefined ){ $('input#imonitor-report-contract-object').val(data.ot.cpv + ' - ' + data.description); }
                if(data.ot.cpv !== undefined ){ $('input#imonitor-report-contract-body').val(data.buyers[0].name); }

                let contractValue = ( ('finalPrice' in data) ? data.finalPrice.netAmountEur : data.digiwhistPrice.netAmountEur );
                $('input#imonitor-report-contract-value').val(parseInt(contractValue) );

                // Build Contract Integrity Indicators table
                let Indicators = data.indicators;

                // get Overall Score

                $('#integrity-profile-score').addClass('score').addClass('score-value-' + data.ot.score.INTEGRITY).html(" (Overall Score: " + data.ot.score.INTEGRITY + ")");

                Indicators.forEach( (element) => {

                    //check if is Integrity Indicator
                    let indicatorLabel = element.type.split('_');

                    if(indicatorLabel[0] === "INTEGRITY"){
                        let indicatorValue = 0;
                        if(element.status === "CALCULATED"){
                            indicatorValue = element.value;
                        }
                        indicatorLabel.shift();


                        let iLabel = indicatorLabel.join( " " );
                        indicatorLabel = indicatorLabel.join("_");
                        if(IMNTR.opentenderLabels[IMNTR.ISO2].hasOwnProperty(indicatorLabel)){
                            iLabel = IMNTR.opentenderLabels[IMNTR.ISO2][indicatorLabel];
                        }


                        let tr = '<tr><td class="indicator">' + iLabel + '</td><td class="score score-value-' + element.value + '">' + indicatorValue + '</td><td class="raw">' + element.status.replace('_', ' ' ) + '</td></tr>';
                        $('table#imonitor-contract-integrity tbody').append(tr);
                    }


                } );

                let Lots = data.lots;
                Lots.forEach( (lot) => {
                    IMNTR.Bidders.push(lot);
                });



                IMNTR.getSupplier();
            }
        );

    },

    parseOpenTenderUrl: function(url){
        let sliced = url.split('/');
        return sliced.slice(-1);
    },

    openTenderLookup: function(){
        $('#imonitor-opentender-lookup').click(function(e){
           e.preventDefault();
           let url = $('#imonitor-contract-url').val();
           let tenderId = IMNTR.parseOpenTenderUrl(url);
           IMNTR.getTender(tenderId);
        });
    },

    repeatField: function(){
        $('.repeater').click(function(e){
            e.preventDefault();
            // get target of repeater
            let ancestor = $(this).data('repeater-target');
            // Get the flat name of the Ancestor and other data that we need to properly set up the repeated field
            let flatName = $(ancestor).data('flat-name');
            let ancestorId = $(ancestor).attr('id');

            let family = $('body').find("[data-flat-name='" + flatName + "']");



            let offspring = $(ancestor).clone(true, true);
            let fields = offspring.find('input, select');
            fields.each(function(){
                let theID = $(this).attr('id');
                $(this).attr('name', flatName + '[' + family.length + '][' + $(this).data('particle-name') + ']');
                $(this).attr('id', theID.replace('0', family.length));
            })
            //offspring.find('input').attr('name', flatName + '[' + family.length + '][' + $(this).data('particle-name') + ']');

            //offspring.attr('name', flatName + '[' + family.length+ ']');
            offspring.attr('id', ancestorId.replace('0', family.length));
            offspring.val(null);

            if(offspring.hasClass('address')){

            }

            if($(this).parent().hasClass('btn-group')){
                $(this).parent().before(offspring);
            }
            else{
                $(this).before(offspring);
            }
        });
    },

    getInspectionSites: function(){
        $('.address').each( function(){
            IMNTR.InspectionSites.push( $(this).val());
        });

    },
    updateInspectionSites: function(){
      $('#update-inspection-sites').click(function(e){
          e.preventDefault();
          IMNTR.getInspectionSites();
          console.log(IMNTR.InspectionSites);
          IMNTR.InspectionSites.forEach( entry => {
              $('select.inspection-site').append( '<option value="' + entry + '">' + entry + '</option>');
          })
      });
    },

    triggerDisplay: function(){
        $('.trigger-display').change(function(e){
            e.preventDefault();
            console.log('trigger display check');
            console.log( ($(this).prop('selected', true) || $(this).prop('checked', true)) && $(this).hasClass('show-dependency') );
            console.log( $(this).attr('id'));
            if( ($(this).prop('selected', true) || $(this).prop('checked', true)) && $(this).hasClass('show-dependency')){
                $($(this).data('target')).removeClass('d-none');
            }
            else {
                $($(this).data('target')).addClass('d-none');
            }
        });
    },


    calculateAggregates: function(){
        $('.calcaggro').click(function(e){
            e.preventDefault();
            let fields = $(this).data('to-aggregate');
            let sum = 0;
                $(fields).each( function( ){
                    sum += parseInt($(this).val());
                });

            $($(this).data('aggro-field')).val(sum.toFixed(2));
        });
    },

    calculatePercentage: function(){
        $('.calcpercent').click(function(e) {
            e.preventDefault();
            if($(this).hasClass('dates')){
                // calc diff in days
                let enddate = new Date( $($(this).data('end-date')).val() );
                let startdate = new Date( $($(this).data('start-date')).val() );
                let amendeddays = parseInt($($(this).data('days-diff')).val());
                let originaldays = Math.floor( (enddate - startdate) / (24*3600*1000));

                let percent = (amendeddays * 100) / originaldays;
                $($(this).data('percent-field')).val(percent.toFixed(2));
            }
            else {
                let onehundred = parseInt($($(this).data('full-percentage')).val());
                let partial = parseInt($($(this).data('partial-percentage')).val());
                let percent = (partial * 100) / onehundred;
                $($(this).data('percent-field')).val(percent.toFixed(2));
            }

        });
    },

    calculateDateDiff: function(){
        $('.calcdatediff').click(function(e){
            e.preventDefault();
            let originaldate =  new Date( $($(this).data('end-date')).val() );
            let newdate = new Date($($(this).data('modified-date')).val());

            let days = Math.floor( (newdate - originaldate) / (24*3600*1000));
            $($(this).data('date-field')).val(days);

        });
    },

    calculateDiff: function(){
        $('.calcdiff').click(function(e){
            e.preventDefault();
            let newval =  parseInt( $($(this).data('newvalue')).val() );
            let oldval = parseInt($($(this).data('fullvalue')).val());

            let diff = parseInt( newval - oldval);
            $($(this).data('diff-field')).val(diff);

        });
    },

    getSupplier: function(){
        IMNTR.Bidders.forEach( (lot) => {

           if(lot.isAwarded === true || lot.status === 'AWARDED'){
               lot.bids.forEach( (bid) => {
                    if(bid.isWinning === true){
                        let supplier = bid.bidders[0];

                        // Populate form with Supplier data
                        if('name' in supplier){
                            $('#imonitor-report-supplier-name').val(supplier.name);
                            $('input#imonitor-report-contract-supplier').val(supplier.name);
                        }
                        if('city' in supplier.address){
                            $('#imonitor-report-supplier-city').val(supplier.address.city);
                        }
                        if('country' in supplier.address){
                            $('#imonitor-report-supplier-country').val(supplier.address.country);
                        }
                        if('postcode' in supplier.address){
                            $('#imonitor-report-supplier-postcode').val(supplier.address.postcode);
                        }
                        if('street' in supplier.address){
                            $('#imonitor-report-supplier-address').val(supplier.address.street);
                        }
                        if('nuts' in supplier.address){
                            $('#imonitor-report-supplier-nuts').val( supplier.address.nuts );
                        }
                        if('url' in supplier.address){
                            $('#imonitor-report-supplier-website').val( supplier.address.url );
                        }
                        if('phone' in supplier){
                            $('#imonitor-report-supplier-phone').val( supplier.phone );
                        }
                        if('email' in supplier){
                            $('#imonitor-report-supplier-email').val( supplier.email );
                        }
                        console.log(supplier);
                    }
               });
           }
        });
    },

    inspectionSiteStep2: function(){
        $(".inspection-sites-trigger").click(function(e){
            $('.inspection-site-wrap').addClass('d-none');
            let target = $(this).data('target');
            $(target).removeClass('d-none');
        });
    },

    statusDepTriggers: function(){
        $('.status-dep-trigger').click(function(e){
            $('.status-dep').addClass('d-none');
            let target = $(this).data('target');
            $(target).removeClass('d-none');
        });

    },

    contractModificationsSubdep: function(){
        $('input.contract-modifications-subdep-trigger').change(function(e){
            let theCheckedOption = $(this).val();
            if(theCheckedOption === 'Yes') {
                $('#contract-mdofications-on').removeClass('d-none');
            }
            else {
                $('#contract-mdofications-on').addClass('d-none');
            }
        });
    }
}


IMNTR.init();


//IMNTR.getTender('539ae8e2-6a55-46af-968c-fcfd47792d55');