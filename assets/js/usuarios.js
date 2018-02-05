
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
    
});