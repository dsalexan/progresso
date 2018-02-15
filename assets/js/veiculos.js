$('#header-navbar').find('a.active').removeClass('active');
$('#header-navbar').find('a[data-page=veiculos]').addClass('active');

if(options['action'] !== undefined){
    change_tab(options['action']);

    if(options['action'] == 'update'){
        set_update_tab(options['id_veiculo']);
    }else{
        disable_tab('update');
    }
}else{
    disable_tab('update');
}

$(document).ready(function(){

    $('.ui.checkbox.fixed').checkbox({
        uncheckable: false
    });

    $('.access-level .ui.checkbox').checkbox({
        onChecked: function(){
            verifyCheckboxState(this);
        }
    });

    $('.btn.selective').click(function(){
        $(this).toggleClass('primary').toggleClass('secondary');

        if($(this).hasClass('primary')){
            $('#table').bootstrapTable('refresh', {url: $('#table').data('url-primary')});
        }else{
            $('#table').bootstrapTable('refresh', {url: $('#table').data('url-secondary')});
        }

    });

    
    $('#remove').click(function () {
        var ids = getIdSelections();
        $.ajax({
            url: base_url('admin/vehicle/remove'),
            type: 'POST',
            dataType : "json",
            data: {
                'ids': ids
            },
            success: function(data) {

                $('#table').bootstrapTable('remove', {
                    field: 'id_veiculo',
                    values: ids
                });

            }
        });
    });

    $("input[type=file]").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = (function (i) {
                return function(e){
                    $('#' + $(i).attr('to')).attr('src', e.target.result);
                }
            })($(this));
            reader.readAsDataURL(this.files[0]);
        }
    });


    $('.insert-secondary').click(function(){
        // alert($(this).closest('.ui.dropdown').attr('class'));
        $(this).addClass('active-secondary');
        $dropdown = $(this).closest('.ui.dropdown');

        if($(this)[0].hasAttribute('clear')) $dropdown.dropdown('clear');

        $modal = $('#insert-' + $(this).data('insert'));
        if($modal.inlineStyle('margin-top') && !$modal.data('fix')){
            $modal.data('fix', $modal.inlineStyle('margin-top'));
        }

        $modal.modal({
            blurring: true,
            onHide: function(){
                $form  = $(this).find('.ui.form');
                $form.form('reset');
            },
            onDeny: function(){
                $form  = $(this).find('.ui.form');
                $form.form('reset');
            },
            onApprove: function(){
                $main = $('.active-secondary');
                $main = $main.closest('.dropdown');
                $dropdown = $('[dropdown-id=' + $(this).data('dropdown-id') + ']');
                $form  = $(this).find('.ui.form');

                $form.form('validate form');

                // inserir no banco
                if( $form.form('is valid') ){
                    if (request) {
                        request.abort();
                    }

                    var form_data = new FormData($form.get(0)); //$form.serialize();
                    
                    $form.find("input, select, button, textarea").attr("disabled", 'disabled');

                    request = $.ajax({
                        url: $form.attr('action'),
                        type: "post",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        form: $form,
                        dropdown: $dropdown,
                        main: $main
                    });

                    request.done(function (response, textStatus, jqXHR){
                            // Log a message to the console
                            $form = this.form;
                            $form.find("input, select, button, textarea").removeAttr('disabled');;
                                        
                            var data = JSON.parse(response);
                            console.log(data);

                            //inserir tipo na dropdown
                            
                            //optional, set new value as selected option
                            var id = -1;
                            if('id_modelo' in data)
                                id = data.id_modelo;
                            else if('id_marca' in data)
                                id = data.id_marca;
                            else if('id_tipo' in data)
                                id = data.id_tipo;  
                            else if('id_opcional' in data)
                                id = data.id_opcional;  
                            else if('id_combustivel' in data)
                                id = data.id_combustivel;  

                            //get menu
                            var $menu =  $dropdown.find('.menu');
                            //append new option to menu
                            $menu.append('<div class="item" data-value="' + id + '">' + data.nome + '</div>');
                            //reinitialize drop down
                            $dropdown.dropdown();

                            $main.dropdown('set selected',[id]);  
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.error(
                            "The following error occurred: "+
                            textStatus, errorThrown
                        );
                    });

                    request.always(function () {
                        $form.find("input, select, button, textarea").prop("disabled", false);
                    });

                    $form.form('reset');
                }else{
                    return false;
                }

                
                $('.active-secondary').removeClass('active-secondary');
            }
          })
          .modal('show')
        ;

        $modal.css('margin-top', $modal.data('fix'));
    });
});

function resetDropdown($dropdown){
    $dropdown.find('input[type=hidden]').removeAttr('value');
    $dropdown.find('div.text').val('DEFAULT').addClass('default');
    $dropdown.find('.menu .item.active.selected').removeClass('active').removeClass('selected');
}

function updateFormatter(){
    return '<button type="button" class="btn btn-default edit">' +
        '<i class="ui write icon" style="margin: 0;"></i>' +
    '</button>';
}


window.updateEvents = {
    'click .edit': function (e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));

        change_tab('update');
        set_update_tab(row['id_veiculo']); 
    }
};

function change_tab(data_tab){
    $('.ui.tab.active').removeClass('active');
    $('.ui.tab[data-tab=' + data_tab).addClass('active');

    $('.ui.menu .item.active').removeClass('active');
    $('.ui.menu .item[data-tab=' + data_tab+']').addClass('active');

    enable_tab(data_tab);
}

function getIdSelections() {
    return $.map($('#table').bootstrapTable('getSelections'), function (row) {
        return row.id_veiculo
    });
}




var request;
$('.ui.form.vechicle').submit(function(event){

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

            $form.find('.message_spot').removeClass('hide');
            $form.find('.message_spot .column').empty();
            $form.find('.message_spot .column').append(
                '<div class="ui positive message small">'+
                    '<div class="header">Veículo criado com sucesso</div>'+
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

        $(this).form('reset');
        $(this).find('.field img.ui.image').attr('src', base_url('assets/img/image_frame.png'));
    }

    $("html, body").animate({ scrollTop: 0 }, "fast");
    

});




function set_update_tab(id_veiculo){
    $('.ui.menu .item[data-tab=update]').text('Modificar ('+id_veiculo+')');

    $.ajax({
        url: base_url('admin/vehicle/select/' + id_veiculo),
        type: 'GET',
        dataType : "json",
        success: function(data) {

            var ops = [];
            $.each(data.opcionais, function( index, value ){
                ops.push(value.id_opcional);
            });

            var cmb = [];
            $.each(data.combustiveis, function( index, value ){
                cmb.push(value.id_combustivel);
            });

            $('#update_form.ui.form').form('set values', {
                id : id_veiculo,
                tipo     : data.tipo.id_tipo,
                marca   : data.marca.id_marca,
                modelo   : data.modelo.id_modelo,
                estado    : data.estado,
                cor   : data.cor,
                ano   : data.ano,
                observacoes   : data.observacoes,
                valor   : data.venda_valor,
                opcionais: ops,
                combustivel: cmb
            });
            
            var imgs = [];
            $.each(data.imagens, function( index, value ){
                $('#update_form').find('.field #update_img'+index).attr('src', base_url('assets/img/veiculos/'+value.url_imagem));
            });

        }
    });
}

    


$('.ui.form.vehicle')
  .form({
    fields: {
      tipo: {
        identifier: 'tipo',
        rules: [
          {
            type   : 'empty',
            prompt : 'Selecione um tipo de veículo'
          }
        ]
      },
      marca: {
        identifier: 'marca',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor selecione uma marca'
          }
        ]
      },
      modelo: {
        identifier: 'modelo',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor selecione um modelo'
          }
        ]
      },
      estado: {
        identifier: 'estado',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor selecione um estado'
          }
        ]
      },
      cor: {
        identifier: 'cor',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe uma cor'
          }
        ]
      },
      ano: {
        identifier: 'ano',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe um ano/modelo'
          }
        ]
      },
      valor: {
        identifier: 'valor',
        rules: [
          {
            type   : 'decimal',
            prompt : 'Por favor informe um valor de venda válido (use <b>ponto</b> para separar a casa decimal)'
          }
        ]
      },
      combustivel: {
        identifier: 'combustivel',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor selecione ao menos um tipo de combustível'
          }
        ]
      }
    }
  });

/*TIPO*/

$('#tipo_nome_plural').keyup(function(){
    $('#tipo_url').val(removeAcento($(this).val()).toLowerCase());
});

  $('.ui.form.type')
  .form({
    fields: {
      nome: {
        identifier: 'nome',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe o nome'
          }
        ]
      },
      nome_plural: {
        identifier: 'plural',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe o nome (plural)'
          }
        ]
      },
      url: {
        identifier: 'url',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe um link'
          }
        ]
      }
    }
  });

  $('.ui.form.brand')
  .form({
    fields: {
        tipo: {
            identifier: 'tipo',
            rules: [
            {
                type   : 'empty',
                prompt : 'Por favor selecione um tipo de veículo'
            }
            ]
        },
        nome: {
        identifier: 'nome',
        rules: [
            {
            type   : 'empty',
            prompt : 'Por favor informe o nome'
            }
        ]
        }
    }
  });

  $('.ui.form.model')
  .form({
    fields: {
      tipo: {
        identifier: 'tipo',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor selecione um tipo de veículo'
          }
        ]
      },
      marca: {
        identifier: 'marca',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor selecione uma marca'
          }
        ]
      },
      nome: {
        identifier: 'nome',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe um nome'
          }
        ]
      }
    }
  });

  $('.ui.form.optional')
  .form({
    fields: {
      nome: {
        identifier: 'nome',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe o nome'
          }
        ]
      }
    }
  });

  $('.ui.form.fuel')
  .form({
    fields: {
      nome: {
        identifier: 'nome',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe o nome'
          }
        ]
      }
    }
  });

