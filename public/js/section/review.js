var MonithonReview = {

  init: function() {
    this.addCommentField();
  },

  addCommentField: function(){
    $('.comment').click(function(e){
      var field = $(this).data('field');
      var htmlComment = '<div class="comment-wrapper">'+
                          '<div class="form-group">' +
                            '<label for="comment[' + field + ']">Commento</label>' +
                            '<textarea class="form-control comment-field" id="comment[' + field + ']" id="comment[' + name + ']" placeholder="Inserisci il tuo commento..."></textarea>' +
                          '</div>' +
                        '</div>';
     $(this).parent().parent().parent().append(htmlComment);
    });
  }
}

MonithonReview.init();
