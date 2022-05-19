let ConnMapper = {
    config: {
        tableHead: '#connection-relationships-table thead tr',
        tableBody: '#connection-relationships-table tbody',
        headCell: '<th></th>',
        dataCell: '<td><div class="" id=""><input name="" id="" type="number" class="form-control"></div></td>'
    },
    init: function(){
        this.subjectAdded();
    },

    getSubjects: function(){ },
    addCells: function(){ },

    subjectAdded: function(){

        $('#subject-button-add').click(function(){
            let SubRowsCount = $('#subjects-table tbody tr').length - 1;
            // If subjects are more than 1
            if(SubRowsCount >= 1){

                console.log(SubRowsCount);
                    // Add THEAD cell
                    let HeaderCell = $(ConnMapper.config.headCell).text(SubRowsCount);
                    $(ConnMapper.config.tableHead).append(HeaderCell);
                //Add TD element to relevant row
                $(ConnMapper.config.tableBody).append('<tr id="connmapper-row-' + SubRowsCount + '"><td class="counter-holder">' + ( parseInt(SubRowsCount) + 1 ) + '</td></tr>');
                for(i=0; i < SubRowsCount; i++){
                    $('tr#connmapper-row-' + SubRowsCount).append(ConnMapper.config.dataCell);
                }
            }
        });

    },

    subjectChanged: function(){

    }
}
ConnMapper.init();