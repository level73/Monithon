var MonithonReview = {

  init: function() {
    this.addCommentField();
  },

  addCommentField: function(){
    $('.comment').click(function(e){
      var field = $(this).data('field');
      if( $('#comment-wrapper-' + field).length == 0){
        var htmlComment = '<div class="comment-wrapper" id="comment-wrapper-' + field + '">'+
                            '<div class="form-group">' +
                              '<label for="comment[' + field + ']">Commento</label>' +
                              '<textarea class="form-control comment-field" id="comment[' + field + ']" name="comment[' + field + ']" placeholder="Inserisci il tuo commento..."></textarea>' +
                            '</div>' +
                          '</div>';
      $(this).parent().parent().parent().append(htmlComment);
     }
    });
  }
}

MonithonReview.init();
