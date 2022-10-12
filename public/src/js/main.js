/** START UP THE APP **/

var Monithon = {

  config: {
    lang: 'it'
  },

  init: function(){
    console.log('MONITHON V3.0');
    this.selects();
    this.validateForms();
    this.bootstrapComponents();
    this.fileFieldDuplicator();
    this.linkFieldDuplicator();
    this.videoFieldDuplicator();
    this.checkEval();
    this.delRepoElement();
    this.tabSubNav();
    this.subjectMultiply();
    this.showhide();
    this.triggerDescriptions();
    this.radioDisplayTrigger('.gender_equality_trigger');
    this.giudizioSintetico();
    this.triggerProblems();
    this.extraQuestionario();


  },

  selects: function(){
    $('.pck').selectpicker();
  },

  validateForms: function(){
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  },

  bootstrapComponents: function(){
    // Initialize Tooltips
    $('[data-toggle="tooltip"]').tooltip();
    $('.custom-file-input').on('change', function(e){
      var file = $(this).val().replace("C:\\fakepath\\", "");
      $(this).next('.custom-file-label').text(file);
    });
  },

  fileFieldDuplicator: function(){
    var toDuplicate = $('.file-duplicator').data('duplicate');
    var elementToDupe = $(toDuplicate);

    var duplicator = elementToDupe.clone(true);
    duplicator.removeClass('origin');

    $('.file-duplicator').click(function(e){

      e.preventDefault();
      var duplicated = duplicator.clone(true);
      var counter = $(toDuplicate).length;

      var inputField = duplicated.find('input').first();
      var labelField = duplicated.find('label').first();
      var newAttr = 'file-attachment[' + counter + ']';

      inputField.attr('id', newAttr).attr('name', newAttr);
      labelField.attr('for',newAttr);

      $(this).before(duplicated);

    });
  },

  linkFieldDuplicator: function(){
    var toDuplicate = $('.link-duplicator').data('duplicate');
    var elementToDupe = $(toDuplicate);

    var duplicator = elementToDupe.clone(true);
    duplicator.removeClass('origin');

    $('.link-duplicator').click(function(e){

      e.preventDefault();

      var duplicated = duplicator.clone(true);
      var counter = $(toDuplicate).length;

      var inputField = duplicated.find('input').first();
      var labelField = duplicated.find('label').first();
      var newAttr = 'link-attachment[' + counter + ']';

      inputField.attr('id', newAttr).attr('name', newAttr);
      labelField.attr('for',newAttr);

      $(this).before(duplicated);

    });
  },

  videoFieldDuplicator: function(){
    var toDuplicate = $('.video-duplicator').data('duplicate');
    var elementToDupe = $(toDuplicate);

    var duplicator = elementToDupe.clone(true);
    duplicator.removeClass('origin');

    $('.video-duplicator').click(function(e){

      e.preventDefault();

      var duplicated = duplicator.clone(true);
      var counter = $(toDuplicate).length;

      var inputField = duplicated.find('input').first();
      var labelField = duplicated.find('label').first();
      var newAttr = 'video-attachment[' + counter + ']';

      inputField.attr('id', newAttr).attr('name', newAttr);
      labelField.attr('for',newAttr);

      $(this).before(duplicated);

    });
  },

  checkEval: function(){
    $('.check-eval').change(function(e){
      if($(this).val() < 4){
        $('#cause_inefficacia_wrapper').removeClass('d-none');
      }
      else {
        $('#cause_inefficacia_wrapper').addClass('d-none');
      }
    });
  },

  triggerDescriptions: function(){
    $('.trigger-desc').change(function(){
      var group = $(this).data('group');
      var els = $('div').find("[data-group='" + group + "']");
      els.each(function(){
        if($(this).parent().next().hasClass('trigger-desc-wrapper')){
          var elid = $(this).parent().next().attr('id');
          console.log('adding d-none to el ID: ' + elid);
          $(this).parent().next().addClass('d-none');
        }
      });
      //console.log($(elements).parent().next('.trigger-desc-wrapper')) ; //.addClass('d-none');
      var target= $(this).data('target');
      if($(this).is(':checked')){
        $(target).removeClass('d-none');
      }
    });
  },

  showhide: function(){
    $('.showhide').click(function(){
      var target = $(this).data('target');

      if($(target).hasClass('d-none')){
        $(target).removeClass('d-none');
        $(this).text(
            $(this).text().replace('compila', 'nascondi')
        );
      }
      else{
        $(target).addClass('d-none');
        $(this).text(
            $(this).text().replace('nascondi', 'compila')
        );
      }
    });
  },

  radioDisplayTrigger: function(triggerClass){
    $(triggerClass).change(function(){
      var target = $(this).data('target');
      $(target).addClass('d-none');
      if($(this).is(':checked') && $(this).val() == 1){
        $(target).removeClass('d-none');
      }
    });
  },


  delRepoElement: function(){
    $('.ajx-delete-repo').click(function(e){
      var repo = $(this).data('type');
      var id = $(this).data('id');
      var target = $(this);
      $.getJSON('/ajax/delete_repo_ref/' + repo + '/' + id, {'type': repo, 'id': id}).done(
        function(response){
          if(response.code == 200){
            var message = '<div class="alert alert-success" role="alert"><i class="fal fa-tick"></i> ' + response.msg + '</div>';
          }
          else {
            var message = '<div class="alert alert-warning" role="alert"><i class="fal fa-times"></i> ' + response.msg + '</div>';
          }
          target.after(message);
          if(response.code == 200){
            setTimeout(function(){
              target.parent().remove();
            }, 3000);
          }
        }
      );
    });
  },

  tabSubNav: function(){
    $('.tab-subnav').click(function(){
      var target = $(this).data('step');
      $('.tab-pane, .nav-link').removeClass('active').removeClass('show');
      $(target).addClass('active').addClass('show');
      $(target +'-tab').addClass('active');
      window.scrollTo(0, 0);
    });
  },

  subjectMultiply: function(){
    $('#subject-button-add').click(function(e){
      e.preventDefault();
      var newLine = $('#connection-0').clone();
      $('#subjects-table > tbody').append(newLine);
      newLine.removeAttr('id');

      // how many elements
      var counter = $('#subjects-table tbody tr').length;

      // new names and Ids
      var newAttr = {
        cSubject: 'connection[' + counter + '][subject]',
        cRole:    'connection[' + counter + '][role]',
        cOrg:     'connection[' + counter + '][organisation]',
        cType:    'connection[' + counter + '][connection_type]',
      }

      newLine.find('.c-subject').attr('name', newAttr.cSubject);
      newLine.find('.c-role').attr('name', newAttr.cRole);
      newLine.find('.c-org').attr('name', newAttr.cOrg);
      newLine.find('.c-type').attr('name', newAttr.cType).attr('id', newAttr.cType);
      console.log(newLine.find('#' + newAttr.cType)); //.selectpicker('refresh');

      newLine.find('.c-type').selectpicker('refresh');
      newLine.find('.c-type').change(function(e){
        if($(this).val() == 6){
          var other = '<input type="text" name="connection[' + counter + '][connection_type_other]" class="c-other form-control">';
          $(this).after(other);
        }
        else {
          if($(this).next('.c-other').length > 0){
            $(this).next('.c-other').remove();
          }
        }
      });

    });
  },

  giudizioSintetico: function(){
    // Get Cur Status of Stato di Avanzamento

    var labels_opt_1 = {
      'giudizio_sintetico_1': "Potenzialmente efficace <small>Il progetto sembra utile e complessivamente ben progettato, anche se potenziali rischi possono essere individuati</small>",
      'giudizio_sintetico_2': "Potenzialmente efficace ma con rischi sostanziali <small>Il progetto sembra utile, anche se ci sono debolezze o rischi importanti che ne possono pregiudicare l’efficacia</small>",
      'giudizio_sintetico_3': "Inutile o dannoso <small>Non andava finanziato: non serve o può avere conseguenze negative, oppure la progettazione è largamente insufficiente per raggiungere gli obiettivi</small>",
      'giudizio_sintetico_4': "Non è stato possibile valutare <small>Le informazioni disponibili non sono sufficienti; i soggetti coinvolti non ci hanno risposto</small>"
    };
    var labels_opt_2 = {
      'giudizio_sintetico_1': "Potenzialmente efficace <small>Il progetto sembra utile e il suo sviluppo incoraggiante, anche se potenziali rischi possono essere individuati</small>",
      'giudizio_sintetico_2': "Potenzialmente efficace ma con problemi <small>Il progetto sembra complessivamente utile ma ci sono debolezze o rischi importanti che ne possono pregiudicare l’efficacia, non legati a ritardi o problemi realizzativi</small>",
      'giudizio_sintetico_3': "Intervento inutile o dannoso <small>Non andava finanziato: non serve o può avere conseguenze negative, oppure la realizzazione presenta problemi che rendono impossibile raggiungere gli obiettivi</small>",
      'giudizio_sintetico_4': "Non è stato possibile valutare <small>Le informazioni disponibili non sono sufficienti; i soggetti coinvolti non ci hanno risposto</small>"
    };
    var labels_opt_3 = {
      'giudizio_sintetico_1': "Intervento efficace <small>Gli aspetti positivi prevalgono ed è giudicato complessivamente efficace dal punto di vista dell'utente finale</small>",
      'giudizio_sintetico_2': "Intervento utile ma presenta problemi <small>Ha avuto alcuni risultati positivi ed è tutto sommato utile, anche se presenta aspetti negativi significativi</small>",
      'giudizio_sintetico_3': "Intervento inefficace o dannoso <small>Era meglio non finanziarlo perché non ha provocato alcun effetto o ha provocato effetti negativi</small>",
      'giudizio_sintetico_4': "Non è stato possibile valutare <small>Es. il progetto non ha ancora prodotto risultati valutabili</small>"
    };

    $('input[name="stato_di_avanzamento"]').on('change', function(){
      var sda = $('input[name="stato_di_avanzamento"]:checked').val();
      if (sda < 3){
        var labels = labels_opt_1;
      }
      else if(sda > 2 && sda < 6){
        var labels = labels_opt_2;
      }
      else {
        var labels = labels_opt_3;
      }
      $('.gsl').each(function(){
        var theForProp = $(this).attr('for');
        var theLabel = labels[theForProp];
        $(this).html(theLabel);
      });
    });
  },

  triggerProblems: function(){
    var triggerFlag = false;
    var Problems = $('#problems_found');
    $('.checkforproblems').each(function(){
      if($(this).is(':checked')){
        triggerFlag = true;
      }
    });

    if(triggerFlag === true){
      Problems.removeClass('d-none');
    }
    else {
      Problems.addClass('d-none');
    }

    $('input[name="gs"], input[name="stato_di_avanzamento"]').change( function(){
      Monithon.triggerProblems();
    });
  },

  extraQuestionario: function(){
    $('input#questionario_altri, input#questionario_utenti').change(function(){
      if($('input#questionario_altri').is(':checked') || $('input#questionario_utenti').is(':checked') ){
        $('.qe_w').removeClass(('d-none'));
      }
      else {
        $('.qe_w').addClass(('d-none'));
      }
    });
  }
};

$(document).ready(function(){
  Monithon.init();
});
