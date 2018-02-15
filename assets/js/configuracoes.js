$(document).ready(function(){
    set_update_tab();
});

var request;
$('.ui.form').submit(function(event){

    if( $(this).form('is valid') ){

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
    
        // Abort any pending request
        if (request) {
            request.abort();
        }


        var form_data = new FormData($(this).get(0)); //$(this).serialize();

        //form_data.append('files[]', $(this).find('input[type=file]').get(0).files[0]);
        
        $(this).find("input, select, button, textarea").attr("disabled", 'disabled');

        // Fire off the request to /form.php
        request = $.ajax({
            url: $(this).attr('url'),
            type: "post",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            form: $(this)
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            // Log a message to the console
            $form = this.form;
            $form.find("input, select, button, textarea").removeAttr('disabled');;

            console.log(response);

            $form.find('.message_spot').removeClass('hide');
            $form.find('.message_spot .column').empty();
            $form.find('.message_spot .column').append(
                '<div class="ui positive message small">'+
                    '<div class="header">Configurações alteradas com sucesso</div>'+
                '</div>'
            );
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            $(this).find("input, select, button, textarea").prop("disabled", false);
        });
    }

    $("html, body").animate({ scrollTop: 0 }, "fast");
    

});




function set_update_tab(){
    $.ajax({
        url: base_url('admin/config/list'),
        type: 'GET',
        dataType : "json",
        success: function(data) {

            $('.ui.form').form('set values', {
                id : data.id_config,
                titulo     : data.titulo_site,
                url   : data.url_site,
                logradouro   : data.logradouro,
                cidade    : data.cidade,
                uf   : data.uf,
                telefone   : data.telefone,
                telefone2   : data.telefone2,
                email   : data.email
            });

        }
    });
}

    


$('.ui.form')
.form({
  fields: {
    name: {
      identifier: 'name',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor informe um título do site'
        }
      ]
    },
    url: {
      identifier: 'url',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor informe o url do site'
        }
      ]
    },
    logradouro: {
      identifier: 'logradouro',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor informe um logradouro'
        }
      ]
    },
    cidade: {
      identifier: 'cidade',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor informe uma cidade'
        }
      ]
    },
    uf: {
      identifier: 'uf',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor informe uma unidade federativa'
        }
      ]
    },
    telefone: {
      identifier: 'telefone',
      rules: [
        {
          type   : 'empty',
          prompt : 'Por favor informe um telefone'
        }
      ]
    },
    email: {
      identifier: 'email',
      rules: [
        {
          type   : 'email',
          prompt : 'Por favor informe um email'
        }
      ]
    }
  }
});