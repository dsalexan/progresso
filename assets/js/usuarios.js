$(document).ready(function(){

    $('#header-navbar').find('a.active').removeClass('active');
    $('#header-navbar').find('a[data-page=usuarios]').addClass('active');

    if(options['action'] !== undefined){
        change_tab(options['action']);

        if(options['action'] == 'update'){
            set_update_tab(options['id_usuario']);
        }else{
            disable_tab('update');
        }
    }else{
        disable_tab('update');
    }

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
        console.log(ids);

        $("#remove-confirmation").find('.items').text(ids.join(', '));
        $("#remove-confirmation")
            .modal({
            closable  : false,
            onDeny    : function(){
                $('#table').bootstrapTable('togglePagination').bootstrapTable('uncheckAll').bootstrapTable('togglePagination');
            },
            onApprove : function() {
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
    
                        $('#table').bootstrapTable('togglePagination').bootstrapTable('uncheckAll').bootstrapTable('togglePagination');
    
                    }
                });
            }
            }).modal('show');

    });
});

function verifyCheckboxState(){
    var checked = $('.access-level .ui.checkbox.checked');

    if(checked.find('input[type=radio]').attr('value') == 1){
        $('.permissions .ui.checkbox').checkbox('check');
        $('.permissions .ui.checkbox').checkbox('disable');
    }else{
        $('.permissions .ui.checkbox').not('.fixed').checkbox('uncheck');
        $('.permissions .ui.checkbox').checkbox('enable');
    }

    $('.access-level .ui.checkbox').checkbox('uncheck');
    checked.checkbox('set checked');
}

function updateFormatter(value, row){
    console.log(row);

    $edit = '<button type="button" class="btn btn-default edit">' +
        '<i class="ui write icon" style="margin: 0;"></i>' +
    '</button>';

    $revive = '<button type="button" class="btn btn-default revive">' +
        '<i class="ui leaf icon" style="margin: 0;"></i>' +
    '</button>';

    if(row.status == 0) return $revive;
    else return $edit;
}

window.updateEvents = {
    'click .edit': function (e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));

        change_tab('update');
        set_update_tab(row['id_usuario']);        
    },
    'click .revive': function (e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));

        
        $.ajax({
            url: base_url('admin/user/revive/' + row.id_usuario),
            type: 'GET',
            dataType : "json",
            success: function(data) {

                $('button[name=refresh]').click();
            }
        });
    }
};

function change_tab(data_tab){
    $('.ui.tab.active').removeClass('active');
    $('.ui.tab[data-tab=' + data_tab).addClass('active');

    $('.ui.menu .item.active').removeClass('active');
    $('.ui.menu .item[data-tab=' + data_tab+']').addClass('active');

    enable_tab(data_tab);
}

function set_update_tab(id_usuario){
    var permissions = ['principal', 'usuarios', 'textos', 'veiculos', 'configuracoes', 'estatisticas'];

    $('.ui.menu .item[data-tab=update]').text('Modificar ('+id_usuario+')');

    $.ajax({
        url: base_url('admin/user/select/' + id_usuario),
        type: 'GET',
        dataType : "json",
        success: function(data) {

            $('#update_form.ui.form').form('set values', {
                id : id_usuario,
                name     : data.nome,
                email   : data.email,
                username   : data.username,
                nivel    : data.nivel
            });

            if(data.permissoes == 'all')
                $('#update_form.ui.form').form('set value', 'permissions', permissions);
            else
                $('#update_form.ui.form').form('set value', 'permissions', data.permissoes);

            if(data.nivel == 1)
                verifyCheckboxState();
        }
    });
}

function getIdSelections() {
    return $.map($('#table').bootstrapTable('getSelections'), function (row) {
        return row.id_usuario
    });
}

var request;
$('.ui.form').submit(function(event){
    if( $(this).form('is valid') ){

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
    
        // Abort any pending request
        if (request) {
            request.abort();
        }

        var form_data = $(this).serialize();
        
        $(this).find("input, select, button, textarea").attr("disabled", 'disabled');

        // Fire off the request to /form.php
        request = $.ajax({
            url: $(this).attr('url'),
            type: "post",
            data: form_data,
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
                    '<div class="header">Usuário criado com sucesso</div>'+
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
    }
    

});
    
$('.ui.form')
  .form({
    fields: {
      name: {
        identifier: 'name',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe um nome/razão social'
          }
        ]
      },
      email: {
        identifier: 'email',
        rules: [
          {
            type   : 'email',
            prompt : 'Por favor informe um e-mail válido'
          }
        ]
      },
      username: {
        identifier: 'username',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe um usuário'
          }
        ]
      },
      password: {
        identifier: 'password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe uma senha'
          }
        ]
      },
      nivel: {
        identifier: 'nivel',
        rules: [
          {
            type   : 'checked',
            prompt : 'Por favor escolha um nível de acesso'
          }
        ]
      }
    },
    onValid: function(){
        var name = $(this).attr('name');
        var value = $(this).val();
    }
  });
