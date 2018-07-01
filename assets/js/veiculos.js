function get_veiculo_ano(a){
    d = a.indexOf("/");
    if(d == -1){
        return a;
    }else{
        return a.substring(0, d);
    }
}

function get_modelo_ano(a){
    d = a.indexOf("/");
    if(d == -1){
        return a;
    }else{
        return a.substring(d+1, a.length);
    }
}


// ARRUMA A COR DO LINK NA HEADER-ADMIN
$('#header-navbar').find('a.active').removeClass('active');
$('#header-navbar').find('a[data-page=veiculos]').addClass('active');


$(document).ready(function(){

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
    
    initFineUploader($('.fine-uploader-element'));

    $('.submit-form').click(function() {
        $form = $(this).closest('form');

        $form.form('validate form');
        if( $('.ui.form.vehicle').form('is valid') ){
                
            var submittedFileCount = $form.find('.fine-uploader-element').fineUploader('getUploads',{
                status: [qq.status.SUBMITTED]
            }).length;

            // console.log(submittedFileCount);
            if (submittedFileCount > 0) {
                $form.find('.fine-uploader-element').fineUploader('uploadStoredFiles');
            }else{
                submitForm.call($form.find('.fine-uploader-element').get(0));
            }
        }

        $("html, body").animate({ scrollTop: 0 }, "fast");
        
    });

    // $menu = $('[form-id=insert_form]').find('[dropdown-id=veiculo-tipo] .menu');
    // $menu.fetch('dropdown/tipo');

    // FUNCAO REMOCAO, TABELA
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
    
                        $('#table').bootstrapTable('togglePagination').bootstrapTable('uncheckAll').bootstrapTable('togglePagination');
    
                    }
                });
            }
            }).modal('show');

    });

    $('.btn.selective').click(function(){
        $table = $(this).closest('[data-id=table]').find('[table-id=table]');

        $(this).toggleClass('primary').toggleClass('secondary');

        if($(this).hasClass('primary')){
            $table.bootstrapTable('refresh', {url: $table.data('url-primary')});
        }else{
            $table.bootstrapTable('refresh', {url: $table.data('url-secondary')});
        }

    });


    $('.table-secondary').click(function(){
        $(this).addClass('loading');
        $(this).addClass('active-secondary');
        $dropdown = $(this).closest('.ui.dropdown');

        if($(this)[0].hasAttribute('clear')) $dropdown.dropdown('clear');

        $modal = $('#table-' + $(this).data('table'));
        $table = $modal.find('[table-id=table]');
        if($modal.inlineStyle('margin-top') && !$modal.data('fix')){
            $modal.data('fix', $modal.inlineStyle('margin-top'));
        }

        $table.bootstrapTable('refresh', {url: $table.data('url-primary')});
        $table.on('load-success.bs.table', function (e, data) {
            $modal.modal({
                blurring: true,
                onVisible: function(){
                    $('.active-secondary').removeClass('loading');
                    $('nav.navbar').addClass('to-back');
                },
                onApprove: function(){
                    $main = $('.active-secondary');
                    $main = $main.closest('.dropdown');
                    $dropdown = $('[dropdown-id=' + $(this).data('dropdown-id') + ']');
                    $form  = $(this).find('.ui.form');
    
                    $form.form('validate form');
                    
                    $('.active-secondary').removeClass('active-secondary');
                },
                onHide: function(){
                    if($(this).find('.btn.selective').hasClass('secondary')){
                        $(this).find('.btn.selective').toggleClass('primary').toggleClass('secondary');
                    }

                    $('nav.navbar').removeClass('to-back');
                    
                    $holder = $(this).find('.message-holder');
                    $holder.empty();
                }
              })
              .modal('show')
            ;
    
            $modal.css('margin-top', $modal.data('fix'));
        });
    });
    
    $('[button-id=remove]').click(function () {
        $table = $(this).closest('[data-id=table]').find('[table-id=table]');

        var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
            if($table.data('link-name')=='vehicle') return row.id_veiculo;
            else if($table.data('link-name')=='type') return row.id_tipo;
            else if($table.data('link-name')=='brand') return row.id_marca;
            else if($table.data('link-name')=='model') return row.id_modelo;
            else if($table.data('link-name')=='optional') return row.id_opcional;
            else if($table.data('link-name')=='fuel') return row.id_combustivel;
        });

        if(ids.length > 0){
            $("#remove-confirmation").find('.items').text(ids.join(', '));
            $("#remove-confirmation")
                .modal({
                closable  : false,
                onDeny    : function(){
                    $table.bootstrapTable('togglePagination').bootstrapTable('uncheckAll').bootstrapTable('togglePagination');
                },
                onApprove : function() {
                    $.ajax({
                        url: base_url('admin/vehicle/' + $table.data('link-name') + '/remove'),
                        type: 'POST',
                        dataType : "json",
                        data: {
                            'ids': ids
                        },
                        success: function(data) {
        
                            $table.bootstrapTable('remove', {
                                field: $table.data('id-name'),
                                values: ids
                            });
        
                            $table.bootstrapTable('togglePagination').bootstrapTable('uncheckAll').bootstrapTable('togglePagination');

                            $('.table-secondary[data-table='+$table.data('table-name')+']').click();

                            $dropdown = $('[dropdown-id=veiculo-'+$table.data('table-name')+']');
                            reloadDropdown($dropdown);
                        }
                    });
                }
                }).modal('show');
        }

    });

    // FUNCOES PARA FORMULARIO
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

    bindEvents();

    $('.clear-secondary').click(function(){
        $form = $(this).closest('form');

        $dropdown = $(this).closest('.ui.dropdown');
        $dropdown.dropdown('restore defaults');

        var i = $dropdown.data('group');
        
        $table = $(this).attr('dropdown-id').replace('veiculo-', '');

        if($table == 'tipo'){
            //set marcas, vehicle/brand/type/ID_TIPO
            $dropdown = $form.find('[dropdown-id=veiculo-marca][data-group='+i+']');
            if($dropdown.length > 0) reloadDropdown($dropdown);

            //set modelos, vehicle/model/type/ID_TIPO
            $dropdown = $form.find('[dropdown-id=veiculo-modelo][data-group='+i+']');
            if($dropdown.length > 0) reloadDropdown($dropdown);
        }else if($table == 'marca'){
            //set TIPO, vehicle/brand/select/ID_MARCA -> ['id_tipo']
            
            //set modelos, vehicle/model/brand/ID_MARCA
            $dropdown = $form.find('[dropdown-id=veiculo-modelo][data-group='+i+']');
            if($dropdown.length > 0) reloadDropdown($dropdown);  
        }else if($table == 'modelo'){
            //set TIPO, vehicle/model/select/ID_MODELO -> ['id_tipo']
            //set MARCA, vehicle/model/select/ID_MODELO -> ['id_marca']
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
                            // console.log(data);

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

    $('.remove-register').click(function(){
        var id = $('#tmp-id-field').val();

        $modal = $(this).closest('.ui.modal');
        var table = $modal.attr('id').replace('insert-', '');

        var func = 'type';
        if(table == 'marca') func = 'brand';
        else if(table == 'modelo') func = 'model';
        else if(table == 'opcional') func = 'optional';
        else if(table == 'combustivel') func = 'fuel';

        $.ajax({
            url: base_url('admin/vehicle/' + func + '/remove/' + id),
            type: 'GET',
            dataType : "json",
            success: function(data) {

                console.log(data);
                
            }
        });
    });

    n = [1, 2];
    $.each(n, function(index, i){
        $('[data-group='+i+']').change(function(){
            // console.log($(this));
            $form = $(this).closest('form');

            if(($(this).dropdown('get value')).length > 0 && !$(this).data('frozen')){
                $table = $(this).attr('dropdown-id').replace('veiculo-', '');
                $value = $(this).dropdown('get value');

                if($table == 'tipo'){
                    //set marcas, vehicle/brand/type/ID_TIPO
                    $dropdown = $form.find('[dropdown-id=veiculo-marca][data-group='+i+']');
                    if($dropdown.length > 0) reloadDropdown($dropdown, ['marca', 'tipo', $value]);

                    //set modelos, vehicle/model/type/ID_TIPO
                    $dropdown = $form.find('[dropdown-id=veiculo-modelo][data-group='+i+']');
                    if($dropdown.length > 0) reloadDropdown($dropdown, ['modelo', 'tipo', $value]);
                }else if($table == 'marca'){
                    //set TIPO, vehicle/brand/select/ID_MARCA -> ['id_tipo']
                    $.get('vehicle/brand/select/'+$value, function(data){
                        marca = JSON.parse(data);

                        $dropdown = $form.find('[dropdown-id=veiculo-tipo][data-group='+i+']');
                        if($dropdown.length > 0) $dropdown.data('frozen', '1');
                        if($dropdown.length > 0) $dropdown.dropdown('set selected', marca.id_tipo);
                    })
                    
                    //set modelos, vehicle/model/brand/ID_MARCA
                    $dropdown = $form.find('[dropdown-id=veiculo-modelo][data-group='+i+']');
                    if($dropdown.length > 0) reloadDropdown($dropdown, ['modelo', 'marca', $value]);  
                }else if($table == 'modelo'){                    
                    $.get('vehicle/model/select/'+$value, function(data){
                        modelo = JSON.parse(data);

                        //set TIPO, vehicle/model/select/ID_MODELO -> ['id_tipo']
                        $dropdown = $form.find('[dropdown-id=veiculo-tipo][data-group='+i+']');
                        if($dropdown.length > 0) $dropdown.data('frozen', '1');
                        if($dropdown.length > 0) $dropdown.dropdown('set selected', modelo.id_tipo);
                       
                        //set MARCA, vehicle/model/select/ID_MODELO -> ['id_marca']
                        $dropdown = $form.find('[dropdown-id=veiculo-marca][data-group='+i+']');
                        if($dropdown.length > 0) $dropdown.data('frozen', '1');
                        if($dropdown.length > 0) $dropdown.dropdown('set selected', modelo.id_marca);
                    });

                    
                }
            }

            if($(this).data('frozen')) $(this).removeData('frozen');
        });
    });

    //teste
    $('.roll-test').click(function(){
        $form = $(this).closest('form');
        $form.form('set values', {
            tipo     : 1,
            marca   : 74,
            modelo   : 372,
            estado    : "Novo",
            cor   : "Vermelho",
            ano   : 2016,
            observacoes   : "Ferrari né meu",
            valor   : 9999999999,
            opcionais: ["1","2","8","9","12"],
            combustivel: ["1","4","5"]
        });
    });
});

var sessionRequest = false;
function initFineUploader($fine, initialList=false){
    var fineParams = {
        template: 'qq-template-manual-trigger',
        request: {
            endpoint: 'admin/upload'
        },
        deleteFile: {
            enabled: true,
            endpoint: "admin/upload"
        },
        chunking: {
            enabled: false,
            concurrent: {
                enabled: true
            },
            success: {
                endpoint: "admin/upload?done"
            }
        },
        resume: {
            enabled: true
        },
        autoUpload: false
    };

    if(initialList!=false) {
        fineParams.session = {endpoint: initialList};
        sessionRequest = true;
    }
    fineParams.retry = {enableAuto: true, showButton: true};
    // fineParams.thumbnails = {
    //     placeholders: {
    //         waitingPath: '/source/placeholders/waiting-generic.png',
    //         notAvailablePath: '/source/placeholders/not_available-generic.png'
    //     }
    // };
    
    $fine.fineUploader(fineParams).on('complete', function (event, id, name, responseJSON) {
        var role = $(this).closest('form').data('role');
        fineData[role].push({data: responseJSON, id: id});
        console.log("complete");
        console.log(fineData[role]);
    }).on('allComplete', function (event, success, failed) {
        // console.log('all complete, sessionRequest=' + sessionRequest);
        // controlar o acionamento errado do evento onAllComplete ao carregar as imagens em initial files
        if(sessionRequest !== false){
            sessionRequest--;
            if(sessionRequest === 0) sessionRequest = false;
        } else{
            // console.log(fineData[role]);
            submitForm.call(this);
        }
        console.log("allComplete");
        console.log(fineData);
    }).on('sessionRequestComplete', function(response, success, x){
        // console.log(success);
        var role = $(this).closest('form').data('role');
        fineData[role] = [];
        $.each(success, function(index, image){
            fineData[role].push({data: image, id: index});
        });
        sessionRequest = success.length;
        console.log("sessionRequestComplete");
        console.log(fineData[role]);
        resetClicks();
    }).on('deleteComplete', function(event, id, xht, isError){
        var role = $(this).closest('form').data('role');
        // verificar qual foi removido para tirar do array com os dados
        fineData[role] = fineData[role].filter(function(item) { 
            return item.id != id; // remove da lista
        });
        console.log("deleteComplete");
        console.log(fineData[role]);
    }).on('submitted', function(event, id, name){
        console.log('submit for id: ' + id);
        resetClicks();
    });
            
    resetClicks();
}

function bindEvents(){
    $('.ui.dropdown.editable').find('div.button.edit').click(function(){
        // console.log('edit: ' + $(this).data('value'));
        $edit_button = $(this);
        $secondary = $(this).closest('.menu').find('.insert-secondary')
        
        //load data for update
        set_update_modal($(this).data('value'), $secondary.data('insert'));

        $modal = $('#insert-' + $secondary.data('insert'));
        if($modal.inlineStyle('margin-top') && !$modal.data('fix')){
            $modal.data('fix', $modal.inlineStyle('margin-top'));
        }

        $modal.modal({
            blurring: true,
            onHide: function(){
                $form  = $(this).find('.ui.form');
                $form.form('reset');
                $('#tmp-id-field').remove();

                $modal.find('.header.insert').show();
                $modal.find('.header.update').hide();

                if($edit_button.data('go-back') !== undefined){
                    $('.table-secondary[data-table='+$edit_button.data('go-back')+']').click();
                    
                    $edit_button.removeData('go-back');
                }

                $dropdown = $('[dropdown-id='+ $modal.data('dropdown-id') +']');
                reloadDropdown($dropdown);
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
                    var url = $form.attr('action');
                    url = url.replace('insert', 'update');

                    $form.find("input, select, button, textarea").attr("disabled", 'disabled');


                    request = $.ajax({
                        url: url,
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
                            // console.log(data);


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

                
            }
          })
          .modal('show')
        ;

        $modal.css('margin-top', $modal.data('fix'));
    });
}

function reloadDropdown($dropdown, $bind=false){
    if($bind !== false){
        $dropdown.dropdown('restore defaults');
        $menu = $dropdown.find('.menu');
        $menu.each(function(){
            var edit = ($(this).closest('.dropdown').hasClass('editable')) ? 'edit' : 'non-edit';
            $(this).find('div.item').remove();
            $(this).fetch('dropdown/'+$bind[0]+'/'+edit+'/'+$bind[1]+'/'+$bind[2], bindEvents);   
        });  
    }else{
        $tabela = ($dropdown.attr('dropdown-id')).replace('veiculo-', '');
        $dropdown.dropdown('restore defaults');
        $menu = $dropdown.find('.menu');
        $menu.each(function(){
            var edit = ($(this).closest('.dropdown').hasClass('editable')) ? 'edit' : 'non-edit';
            $(this).find('div.item').remove();
            $(this).fetch('dropdown/'+$tabela+'/'+edit, bindEvents);      
        });  
    }
}



// FUNCOES PARA TABELA
function updateFormatter(value, row){
    // console.log(row);

    $edit = '<button type="button" class="btn btn-default edit">' +
        '<i class="ui write icon" style="margin: 0;"></i>' +
    '</button>';
    
    $destaque = '<button type="button" class="btn btn-default destaque">' +
        '<i class="ui pin icon" style="margin: 0;"></i>' +
    '</button>';
    
    $remove_destaque = '<button type="button" class="btn btn-default remove-destaque">' +
        '<i style="color:#d11717" class="ui pin icon" style="margin: 0;"></i>' +
    '</button>';

    $revive = '<button type="button" class="btn btn-default revive">' +
        '<i class="ui leaf icon" style="margin: 0;"></i>' +
    '</button>';

    $return = ''
    if(row.status == 0) $return += $revive;
    else $return += $edit;

    if(row.destaque == 1) $return += $remove_destaque;
    else $return += $destaque;

    return $return;
}

window.updateEvents = {
    'click .edit': function (e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));

        change_tab('update');
        set_update_tab(row['id_veiculo']); 
    },
    'click .revive': function (e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));
        
        $.ajax({
            url: base_url('admin/vehicle/revive/' + row.id_veiculo),
            type: 'GET',
            dataType : "json",
            success: function(data) {


                var error = '';
                $.each(data, function(id, erros){
                    // console.log([index, value]);
                    if(erros !== true){ // se houve um erro
                        var msg_erro = 'Não foi possível reativar o item <b>'+ id + '</b> ';

                        $.each(erros, function(i, erro){
                            var msg_motivo = '';

                            if(erro.error == 'type_inactive'){
                                msg_motivo = 'porque o tipo <b>' + erro.on + '</b> está inativo.';
                            }else if(erro.error == 'brand_inactive'){
                                msg_motivo = 'porque a marca <b>' + erro.on + '</b> está inativa.';
                            }else if(erro.error == 'model_inactive'){
                                msg_motivo = 'porque o modelo <b>' + erro.on + '</b> está inativo.';
                            }

                            error += '<li>' + msg_erro + ' ' + msg_motivo + '</li>';
                        });
                    }
                });

                $holder = $(e.currentTarget).closest('[data-id=table]').find('.message-holder');
                $holder.empty();
                if(error != ''){
                    $holder.append('<div class="ui error message">'+
                                        '<i class="close icon"></i>'+
                                        '<div class="header">'+
                                            'Detectamos alguns erros na sua submissão'+
                                        '</div>'+
                                        '<ul class="list">'+
                                            error +
                                        '</ul>'+
                                    '</div>');                                
                    bindCloseMessage();
                }

                $(e.currentTarget).closest('[data-id=table]').find('button[name=refresh]').click();

            }
        });
    },
    'click .destaque': function (e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));
        
        $.ajax({
            url: base_url('admin/vehicle/pin/' + row.id_veiculo),
            type: 'GET',
            dataType : "json",
            success: function(data) {

                $('button[name=refresh]').click();
            }
        });
    },
    'click .remove-destaque': function (e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));
        
        $.ajax({
            url: base_url('admin/vehicle/remove_pin/' + row.id_veiculo),
            type: 'GET',
            dataType : "json",
            success: function(data) {

                $('button[name=refresh]').click();
            }
        });
    }
};

function getIdSelections(table_id="table", table="vehicle") {
    $table = $('#'+table_id);
    return $.map($table.bootstrapTable('getSelections'), function (row) {
        if(table=='vehicle') return row.id_veiculo;
        else if(table=='type') return row.id_tipo;
        else if(table=='brand') return row.id_marca;
        else if(table=='model') return row.id_modelo;
        else if(table=='optional') return row.id_opcional;
        else if(table=='fuel') return row.id_combustivel;
    });
}


function secondaryFormatter(value, row){
    // console.log(row);

    $edit = '<button type="button" class="btn btn-default edit">' +
        '<i class="ui write icon" style="margin: 0;"></i>' +
    '</button>';

    $revive = '<button type="button" class="btn btn-default revive">' +
        '<i class="ui leaf icon" style="margin: 0;"></i>' +
    '</button>';

    $return = ''
    if(row.status == 0) $return += $revive;
    else $return += $edit;

    return $return;
}

window.secondaryEvents = {
    'click .edit': function (e, value, row, index) {
        $table = $(e.currentTarget).closest('[table-id=table]');
        var link = $(e.currentTarget).closest('[table-id=table]').data('link-name');

        var id='';
        if(link=='type') id = row.id_tipo;
        else if(link=='brand') id = row.id_marca;
        else if(link=='model') id = row.id_modelo;
        else if(link=='optional') id = row.id_opcional;
        else if(link=='fuel') id = row.id_combustivel;

        $edit_item = $('.ui.dropdown.editable[dropdown-id=veiculo-' + $table.data('table-name') + ']').find('div.button.edit[data-value=' + id + ']');
        $edit_item.data('go-back', $table.data('table-name'));
        $edit_item.click();

    },
    'click .revive': function (e, value, row, index) {
        
        var link = $(e.currentTarget).closest('[table-id=table]').data('link-name');

        var id='';
        if(link=='type') id = row.id_tipo;
        else if(link=='brand') id = row.id_marca;
        else if(link=='model') id = row.id_modelo;
        else if(link=='optional') id = row.id_opcional;
        else if(link=='fuel') id = row.id_combustivel;

        $.ajax({
            url: base_url('admin/vehicle/' + link + '/revive/' + id),
            type: 'GET',
            dataType : "json",
            success: function(data) {
                // console.log(data);


                var error = '';
                $.each(data, function(id, erros){
                    // console.log([index, value]);
                    if(erros !== true){ // se houve um erro
                        var msg_erro = 'Não foi possível reativar o item <b>'+ id + '</b> ';

                        $.each(erros, function(i, erro){
                            var msg_motivo = '';

                            if(erro.error == 'type_inactive'){
                                msg_motivo = 'porque o tipo <b>' + erro.on + '</b> está inativo.';
                            }else if(erro.error == 'brand_inactive'){
                                msg_motivo = 'porque a marca <b>' + erro.on + '</b> está inativa.';
                            }else if(erro.error == 'model_inactive'){
                                msg_motivo = 'porque o modelo <b>' + erro.on + '</b> está inativo.';
                            }

                            error += '<li>' + msg_erro + ' ' + msg_motivo + '</li>';
                        });
                    }
                });

                $holder = $(e.currentTarget).closest('[data-id=table]').find('.message-holder');
                $holder.empty();
                if(error != ''){
                    $holder.append('<div class="ui error message">'+
                                        '<i class="close icon"></i>'+
                                        '<div class="header">'+
                                            'Detectamos alguns erros na sua submissão'+
                                        '</div>'+
                                        '<ul class="list">'+
                                            error +
                                        '</ul>'+
                                    '</div>');
                }

                $(e.currentTarget).closest('[data-id=table]').find('button[name=refresh]').click();
                
                $table = $(e.currentTarget).closest('[table-id=table]');
                $dropdown = $('[dropdown-id=veiculo-'+$table.data('table-name')+']');
                reloadDropdown($dropdown);
            }
        });
    }
};

function onSuccessCallback(res){
    $('.ui.segment[data-tab=list]').dimmer('hide');
    return res;
}


//FUNCOES PARA FORMULARIO
function submitForm(){
    if ($(this).fineUploader('getInProgress') == 0) {
        var failedUploads = $(this).fineUploader('getUploads', 
            { status: qq.status.UPLOAD_FAILED });
        if (failedUploads.length == 0) {    
            $form = $(this).closest('form');
            var role = $form.data('role')
            //colocar os links upados das imagens em hidden fields dinamicos
            $count = $('<input type="hidden" class="tmp-hidden-input" name="image-count">');
            var ids = [];
            $.each(fineData[role], function(index, image){
                var url = image.data.uuid + '/' + image.data.uploadName;
                // input da url
                $img = $('<input type="hidden" class="tmp-hidden-input" name="image'+image.id+'">');
                $img.val(url);

                $img.appendTo($form);
                
                var ordem = parseInt($form.find('.qq-file-id-' + image.id).attr('qq-file-order')) + 1;
                // input da url
                $img = $('<input type="hidden" class="tmp-hidden-input" name="imageOrdem'+image.id+'">');
                $img.val(ordem);

                $img.appendTo($form);

                var id = -1;
                if(image.data.id_imagem != undefined) id = image.data.id_imagem;
                // input do id
                $img = $('<input type="hidden" class="tmp-hidden-input" name="imageID'+image.id+'">');
                $img.val(id);

                $img.appendTo($form);

                //array com os ids
                ids.push(image.id);
            });
            $count.val(ids);
            $form.append($count);

            $form.submit();

            $('.tmp-hidden-input').remove();

            $fine = $form.find('.fine-uploader-element');
            $fine.unbind().empty();
            fineData[role] = [];
            initFineUploader($fine);
        }
    }
}


var request;
var fineData = {insert: [], update: []};
$('.ui.form.vehicle').submit(function(event){

    if( $(this).form('is valid') ){
        
        $(this).closest('.ui.segment').dimmer('show');

        event.preventDefault();
    
        if (request) {
            request.abort();
        }

        var form_data = new FormData($(this).get(0)); //$(this).serialize();
        
        $(this).find("input, select, button, textarea").attr("disabled", 'disabled');

        request = $.ajax({
            url: $(this).attr('url'),
            type: "post",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            form: $(this)
        });

        request.done(function (response, textStatus, jqXHR){            
            $form = this.form;

            var verbo = "criado";
            if($form.data('role') == 'update') verbo = "modificado";

            $form.find("input, select, button, textarea").removeAttr('disabled');;

            $messageSpot = $form.find('.message_spot');
            if($form.data('role') == 'update') {
                
                $holder = $('#user_table').find('.message-holder');
                $holder.empty();
                $holder.append('<div class="ui positive message">'+
                                    '<i class="close icon"></i>'+
                                    '<div class="header">'+
                                        'Veiculo '+verbo+' com sucesso'+
                                    '</div>'+
                                '</div>');                                
                bindCloseMessage();
                
            }else{
                $messageSpot.removeClass('hide');
                $messageSpot.find('.column').empty();
                $messageSpot.find('.column').append(
                    '<div class="ui positive message small">'+
                        '<div class="header">Veículo '+verbo+' com sucesso</div>'+
                    '</div>'
                );
            }

            $form.closest('.ui.segment').dimmer('hide');
            // resetar tab de modificação
            if($form.data('role') == 'update') $('.ui.menu .item[data-tab=update]').text('Modificar');
            if($form.data('role') == 'update') disable_tab('update');
            change_tab('list');
            if($form.data('role') == 'update') $form.closest('.ui.segment').dimmer('show');
            if($form.data('role') == 'update') $form.closest('.ui.segment').addClass('max-height70');
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error("The following error occurred: "+textStatus, errorThrown);
        });

        
        request.always(function () {
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
            
            data.ano_veiculo = get_veiculo_ano(data.ano);
            data.ano_modelo = get_modelo_ano(data.ano);

            $('[form-id=update_form].ui.form').form('set values', {
                id : id_veiculo,
                tipo     : data.tipo.id_tipo,
                marca   : data.marca.id_marca,
                modelo   : data.modelo.id_modelo,
                estado    : data.estado,
                cor   : data.cor,
                ano_veiculo   : data.ano_veiculo,
                ano_modelo   : data.ano_modelo,
                diferencial : data.diferencial,
                observacoes   : data.observacoes,
                valor   : data.venda_valor,
                opcionais: ops,
                combustivel: cmb
            });
            
            
            $fine = $('[form-id=update_form].ui.form').find('.fine-uploader-element');
            $fine.unbind().empty();
            fineData['update'] = [];
            initFineUploader($fine, 'vehicle/image/' + id_veiculo);

            $('[form-id=update_form].ui.form').closest('.ui.segment').dimmer('hide');
            $('[form-id=update_form].ui.form').closest('.ui.segment').removeClass('max-height70');
        }
    });
}

function set_update_modal(id, table){

    $modal = $('#insert-' + table);
    $modal.find('form').append('<input id="tmp-id-field" value="' + id + '" type="hidden" name="id">');

    $modal.find('.header.insert').hide();
    $modal.find('.header.update').show().removeAttr('hidden');

    var func = 'type';
    if(table == 'marca') func = 'brand';
    else if(table == 'modelo') func = 'model';
    else if(table == 'opcional') func = 'optional';
    else if(table == 'combustivel') func = 'fuel';

    $.ajax({
        url: base_url('admin/vehicle/' + func + '/select/' + id),
        type: 'GET',
        dataType : "json",
        modal: $modal,
        tabela: table,
        success: function(data) {

            // console.log(data);
            var corr = {};
            
            if(this.tabela == 'tipo'){
                corr = {
                    id : data.id_tipo,
                    nome     : data.nome,
                    plural   : data.nome_plural,
                    url   : data.url
                };
            }else if(this.tabela == 'marca'){
                corr = {
                    id : data.id_marca,
                    tipo     : data.id_tipo,
                    nome   : data.nome
                };
            }else if(this.tabela == 'modelo'){
                corr = {
                    id : data.id_modelo,
                    tipo     : data.id_tipo,
                    marca   : data.id_marca,
                    nome   : data.nome
                };
            }else if(this.tabela == 'opcional'){
                corr = {
                    id : data.id_opcional,
                    nome     : data.nome
                };
            }else if(this.tabela == 'combustivel'){
                corr = {
                    id : data.id_combustivel,
                    nome     : data.nome
                };
            }

            this.modal.find('form').form('set values', corr);
            
        }
    });
}


$('#tipo_nome_plural').keyup(function(){
    $('#tipo_url').val(removeAcento($(this).val()).toLowerCase());
});

function resetClicks(){
    $('ul.qq-upload-list-selector.qq-upload-list li').each(function(){
        $(this).attr('qq-file-order', $(this).index());
    });

    $('.qq-move-up').click(function(){
        slot = $(this).closest("li");

        if (slot.index() > 0){
            class_name = "qq-file-id-" + slot.index();
            class_name2 = "qq-file-id-" + slot.prev().index();

            // slot.toggleClass(class_name).toggleClass(class_name2);
            // slot.prev().toggleClass(class_name).toggleClass(class_name2);

            // slot.attr("qq-file-id", slot.prev().index());
            // slot.prev().attr("qq-file-id", slot.index());

            slot.attr("qq-file-order", slot.prev().index());
            slot.prev().attr("qq-file-order", slot.index());

            slot.swapWith(slot.prev());
        }
    });
    
    $('.qq-move-down').click(function(){
        slot = $(this).closest("li");

        if (slot.index()!=slot.siblings().length){
            class_name = "qq-file-id-" + slot.index();
            class_name2 = "qq-file-id-" + slot.next().index();

            //slot.toggleClass(class_name).toggleClass(class_name2);
            //slot.next().toggleClass(class_name).toggleClass(class_name2);

            //slot.attr("qq-file-id", slot.next().index());
            //slot.next().attr("qq-file-id", slot.index());

            slot.attr("qq-file-order", slot.next().index());
            slot.next().attr("qq-file-order", slot.index());

            slot.swapWith(slot.next());
        }
    });
}

/*PRINCIPAL*/
$('.ui.form.vehicle').form({
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


/*SECUNDARIOS*/
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

