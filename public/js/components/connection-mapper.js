let ConnMapper = {
    config: {
        tableHead: '#connection-relationships-table thead tr',
        tableBody: '#connection-relationships-table tbody',
        headCell: '<th></th>',
        dataCell: '<td><div class="" id=""><input name="" id="" type="number" class="form-control"></div></td>'
    },
    init: function(){
        this.subjectChanged();
    },


    // Get name and position of subject name
    subjectChanged: function(){
        $('#aggiorna-soggetti').click(function(e){
            var soggetti = $('.c-subject');

            var subjectsCap = soggetti.length - 1;
            soggetti.each(function(i, el){
                if(i > 0){
                    var subjectIndex = i;
                    var subjectName = $(this).val();
                    //var strName = subjectIndex + '. ' + subjectName;
                    var strName =  subjectName;
                    if(subjectIndex === 1 ){
                        $('#r1').text(strName);
                    }
                    if( (subjectIndex > 1 && subjectIndex < 10) && subjectIndex !== subjectsCap ){
                        $('#r' + subjectIndex + ', #c' + subjectIndex).text(strName);
                    }
                    if(subjectIndex === 10 || subjectIndex === subjectsCap ){
                        $('#c' + subjectIndex).text(strName);
                    }
                }
            });

            $('.crt-name').each(function(i){
                var row = $(this).data('row');
                var col = $(this).data('col');

                var name_row = $('#r' + row).text();
                var name_col = $('#c' + col).text();
                $('#crt_r' + row + '_c' + col + '_names').val(name_row + ' ::: ' + name_col);
            });


        });
    }
}
ConnMapper.init();