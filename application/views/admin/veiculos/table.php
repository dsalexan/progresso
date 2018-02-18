<div id="user_table" class="ui basic segment dimmable dimmed" data-id="table">
        
    <!-- <div class="ui active inverted dimmer">
        <div class="ui text loader">Acessando Banco de Dados</div>
    </div> -->

    <div id="toolbar" class="btn-group">
        <button id="remove" type="button" class="btn btn-default has-popup" data-inverted="" data-position="bottom left" data-tooltip="Remover veículos selecionados">
            <i class="ui icon trash"></i>
        </button>
        <button type="button" class="btn btn-default has-popup selective primary" data-inverted="" data-position="bottom left" data-tooltip="Mostrar/Esconder veículos removidos">
            <i class="ui icon unhide primary"></i>
            <i class="ui icon hide secondary"></i>
        </button>
    </div>
    <table 
        table-id="table"
        id="table"
        data-show-refresh="true"
        data-toolbar="#toolbar"
        
        data-toggle="table"
        data-pagination="true"
        data-search="true"
        data-url="<?= base_url('admin/vehicle/list'); ?>"
        data-url-primary="<?= base_url('admin/vehicle/list'); ?>"
        data-url-secondary="<?= base_url('admin/vehicle/list-all'); ?>">
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="id_veiculo" data-sortable="true">ID</th>
            <th data-field="nome_tipo" data-sortable="true">Tipo</th>
            <th data-field="nome_marca" data-sortable="true">Marca</th>
            <th data-field="nome_modelo" data-sortable="true">Modelo</th>
            <th data-field="estado" data-sortable="true">Estado</th>
            <th data-field="ano" data-sortable="true">Ano</th>
            <th data-field="venda_valor" data-sortable="true">Valor</th>
            <th data-field="destaque" data-visible="false" data-sortable="true">Destaque</th>
            <th data-field="status" data-sortable="true">Status</th>
            <th data-field="operate" data-formatter="updateFormatter" data-events="updateEvents">Ação</th>
        </tr>
        </thead>
    </table>

</div>    