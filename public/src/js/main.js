/** START UP THE APP **/


var Monithon = {
  init: function(){
    console.log('MONITHON V3.0');
    this.selects();
    this.validateForms();
    this.bootstrapComponents();
    this.fileFieldDuplicator();
    this.linkFieldDuplicator();
    this.videoFieldDuplicator();
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

    // Show filename on change of filebrowser input
    $('input[type="file"]').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').text(fileName);
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
      console.log(counter);

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
      console.log(counter);

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
      console.log(counter);

      var inputField = duplicated.find('input').first();
      var labelField = duplicated.find('label').first();
      var newAttr = 'video-attachment[' + counter + ']';

      inputField.attr('id', newAttr).attr('name', newAttr);
      labelField.attr('for',newAttr);

      $(this).before(duplicated);

    });
  }

}

Monithon.init();