
<div id="table-<?=$objeto['tabela']['nome']?>" class="ui modal" data-dropdown-id="veiculo-<?=$objeto['tabela']['nome']?>" style="bottom: auto; overflow: visible;" data-id="table">
    <i class="ui close icon"></i>
    <div class="header insert">
        Listar <?=$objeto['tabela']['alt']?>
    </div>
    <div class="scrolling content">
        <div class=" ui basic segment dimmable dimmed" style="width: 100%">
            <div class="ui container message-holder">

            </div>

            <div id="toolbar-<?=$objeto['tabela']['nome']?>" class="btn-group">
                <button button-id="remove" type="button" class="btn btn-default has-popup" data-inverted="" data-position="bottom left" data-tooltip="Remover <?=strtolower($objeto['tabela']['alt']);?> selecionados">
                    <i class="ui icon trash"></i>
                </button>
                <button type="button" class="btn btn-default has-popup selective primary" data-inverted="" data-position="bottom left" data-tooltip="Mostrar/Esconder <?=strtolower($objeto['tabela']['alt']);?> removidos">
                    <i class="ui icon unhide primary"></i>
                    <i class="ui icon hide secondary"></i>
                </button>
            </div>
            <table 
                table-id="table"
                data-id-name="id_<?=$objeto['tabela']['nome']?>"
                data-table-name="<?=$objeto['tabela']['nome']?>"
                data-link-name="<?=$objeto['tabela']['link']?>"

                id="table-<?=$objeto['tabela']['nome'];?>"
                data-show-refresh="true"
                data-toolbar="#toolbar-<?=$objeto['tabela']['nome']?>"
                
                data-toggle="table"
                data-pagination="true"
                data-search="true"
                data-url-primary="<?= base_url('admin/vehicle/'.$objeto['tabela']['link'].'/list'); ?>"
                data-url-secondary="<?= base_url('admin/vehicle/'.$objeto['tabela']['link'].'/list-all'); ?>">

                
                <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <?php
                    foreach($objeto['campos'] as $campo){
                        ?><th data-field="<?=$campo['nome']?>" data-visible="<?=$campo['visible']?>" data-sortable="<?=$campo['sortable']?>"><?=$campo['label']?></th><?php
                    }
                    ?>
                    <th data-field="operate" data-formatter="secondaryFormatter" data-events="secondaryEvents">Ação</th>
                </tr>
                </thead>
            </table>

        </div>
    </div>
    <div class="actions">
        <div class="ui button positive">Atualizar Campos</div>
    </div>
</div>