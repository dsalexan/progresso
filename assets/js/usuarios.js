

$(document).ready(function(){
    disable_tab('update');

    $('.ui.checkbox.fixed').checkbox({
        uncheckable: false
    });

    $('.access-level .ui.checkbox').checkbox({
        onChecked: function(){
            if($(this).attr('value') == 'adm'){
                $('.permissions .ui.checkbox').checkbox('check');
                $('.permissions .ui.checkbox').checkbox('disable');
            }else{
                $('.permissions .ui.checkbox').not('.fixed').checkbox('uncheck');
                $('.permissions .ui.checkbox').checkbox('enable');
            }

            $('.access-level .ui.checkbox').checkbox('uncheck');
            $(this).parent().checkbox('set checked');
        }
    });

    $('.btn.selective').click(function(){
        $(this).toggleClass('primary').toggleClass('secondary');

        var selective = 'secondary';
        if($(this).hasClass('primary')){
            selective = 'primary';
        }

    });

    
    $('#remove').click(function () {
            

        var ids = getIdSelections();
        $.ajax({
            url: base_url('admin/user/remove'),
            type: 'POST',
            dataType : "json",
            data: {
                'ids': ids
            },
            success: function(data) {

                $('#table').bootstrapTable('remove', {
                    field: 'id_usuario',
                    values: ids
                });

            }
        });

    });
});

function updateFormatter(){
    return '<button type="button" class="btn btn-default edit">' +
        '<i class="ui write icon" style="margin: 0;"></i>' +
    '</button>';
}

window.updateEvents = {
    'click .edit': function (e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));
        $('#table').bootstrapTable('uncheck', index);
    }
};


function getIdSelections() {
    return $.map($('#table').bootstrapTable('getSelections'), function (row) {
        return row.id_usuario
    });
}