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

};

$(document).ready(function(){
  Monithon.init();
});
