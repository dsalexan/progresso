$(document).ready(function(){

    $('#contato').submit(function(event){

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(data) {
                //console.log(data);
                if(data=='ok'){
                    $('#contato').find('input, textarea').each(function(){
                        $(this).val('');
                    });

                    $('#email-sent').removeAttr('hidden');
                }
            }
        });
    });
});