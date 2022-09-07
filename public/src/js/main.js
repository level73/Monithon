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
    this.triggerDescriptions();
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
  }

};

$(document).ready(function(){
  Monithon.init();
});
