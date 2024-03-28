var IMNTRReview = {

    init: function() {
        this.addCommentField();
        this.resolveComment();
    },

    Labels: {
      comment: 'Commento',
      comment_placeholder: 'Inserisci il tuo commento...',
      comment_fixed: 'risolto'
    },

    addCommentField: function(){
        $('.comment').click(function(e){
            var field = $(this).data('field');
            if( $('#comment-wrapper-' + field).length == 0){
                var htmlComment = '<div class="comment-wrapper" id="comment-wrapper-' + field + '">'+
                    '<div class="form-group">' +
                    '<label for="comment[' + field + ']">' + IMNTRReview.Labels.comment + '</label>' +
                    '<textarea class="form-control comment-field" id="comment[' + field + ']" name="comment[' + field + ']" placeholder="' + IMNTRReview.Labels.comment_placeholder + '"></textarea>' +
                    '</div>' +
                    '</div>';
                $(this).parent().append(htmlComment);
            }
        });
    },

    resolveComment: function(){
        $('.commented-delete').click(function(e){
            var wrapper = $(this).parent();
            var btn = $(this);
            var comment = $(this).data('comment');
            //var state = MonithonReview.changeCommentStatus(comment, 3);

            $.ajax({
                type: "POST",
                url: '/ajax/change_comment_status',
                data: {'id': comment, 'status': 3},
                cache: false,
                dataType: 'json',
                success: function(data){
                    if(data.code === 200){
                        wrapper.addClass('status-solved').removeClass('status-pending');
                        btn.before(
                            '<span class="badge badge-success float-right">' + IMNTRReview.Labels.comment_fixed + '</span>'
                        );
                        btn.hide();
                    }
                    else {
                        //return false;
                    }
                }
            });

        });
    },

    changeCommentStatus: function(comment, status){
        $.ajax({
            type: "POST",
            url: '/ajax/change_comment_status',
            data: {'id': comment, 'status': status},
            cache: false,
            dataType: 'json',
            success: function(ret){
                console.log(ret);
                if(ret.code === 200){
                    return true;
                }
                else {
                    return false;
                }
            }
        });
    }

}

IMNTRReview.init();