/** USER PAGES SPECIFIC JS **/

var MonithonUser = {
  init: function(){
    this.checkPasswords();
    this.checkAsoc();
  },

  checkPasswords: function(){
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


    if($('#pwd').length > 0 && $('#c_pwd').length > 0){
      var m_pwd = $('#pwd').val();
      var c_pwd = $('#c_pwd').val();

      if( (m_pwd == c_pwd) && m_pwd != '' && c_pwd != '') {
        $('#pwd, #c_pwd').addClass('is-invalid');
        $('#pwd').append('<div class="invalid-feedback">Le password non corrispondono</div>');
      }
    }
    Monithon.validateForms();
  },

  checkAsoc: function(){
    $('#role').change(function(e) {
      console.log('Changing...');
      var role = $(this).val();
      if(role > 3){
        $('#asoc').removeClass('d-none');
      }
      else {
        $('#asoc').addClass('d-none');
      }
    });
  }

}

MonithonUser.init();
