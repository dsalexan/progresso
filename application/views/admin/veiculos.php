<div class="ui secondary pointing menu" >
  <a class="item active" data-tab="list">Listar Todos</a>
  <a class="item " data-tab="insert">Cadastrar</a>
  <a class="item" data-tab="update">Modificar</a>
</div>
<div class="ui tab segment active" data-tab="list">

    <div id="user_table" class="ui basic segment dimmable dimmed">
            
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
</div>

<div class="ui tab segment " data-tab="insert">
    
    <form id="insert_form" class="ui form vehicle" url="<?php echo base_url('admin/vehicle/insert');?>" method="post" enctype="multipart/form-data">

    <div class="ui centered grid">
        <div class="message_spot row hide">
            <div class="sixteen wide column">
            </div>    
        </div>

        <div class="eight wide column">
            
            <div class="field">
                <label>Tipo</label>
                <div dropdown-id="veiculo-tipo" class="ui fluid dropdown labeled search icon button editable">
                    <input type="hidden" name="tipo">
                    <i class="car icon"></i>
                    <div class="default text">Tipo</div>
                    <div class="menu">
                        <div class="ui top attached button fluid  insert-secondary" clear data-insert="tipo">
                            <i class="plus icon"></i>
                            Cadastrar Novo Tipo
                        </div>
                        <?php
                        $tipos = $this->veiculos_model->get_tipos();
                        foreach($tipos as $tipo){
                            ?><div class="item" data-value="<?=$tipo['id_tipo']?>">
                            <div><?=$tipo['nome']?></div>
                            <div class="ui icon button edit" data-value="<?=$tipo['id_tipo']?>"><i class="ui write icon"></i></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            
            <div class="field">
                <label>Marca</label>
                <div dropdown-id="veiculo-marca" class="ui fluid dropdown labeled search icon button">
                    <input type="hidden" name="marca">
                    <i class="cubes icon"></i>
                    <div class="default text">Marca</div>
                    <div class="menu">
                        <div class="ui top attached button fluid  insert-secondary" clear data-insert="marca">
                            <i class="plus icon"></i>
                            Cadastrar Nova Marca
                        </div>
                        <?php
                        $marcas = $this->veiculos_model->get_marcas();
                        foreach($marcas as $marca){
                            ?><div class="item" data-value="<?=$marca['id_marca']?>"><?=$marca['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>

                        
            <div class="field">
                <label>Modelo</label>
                <div dropdown-id="veiculo-modelo" class="ui fluid dropdown labeled search icon button">
                    <input type="hidden" name="modelo">
                    <i class="cube icon"></i>
                    <div class="default text">Modelo</div>
                    <div class="menu">
                        <div class="ui top attached button fluid  insert-secondary" clear data-insert="modelo">
                            <i class="plus icon"></i>
                            Cadastrar Novo Modelo
                        </div>
                        <?php
                        $modelos = $this->veiculos_model->get_modelos();
                        foreach($modelos as $modelo){
                            ?><div class="item" data-value="<?=$modelo['id_modelo']?>"><?=$modelo['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>


            <div class="field">
                <label>Estado</label>
                <div class="ui fluid dropdown labeled search icon button">
                    <input type="hidden" name="estado">
                    <i class="asterisk icon"></i>
                    <div class="default text">Estado</div>
                    <div class="menu">
                        <div class="item" data-value="Novo">Novo</div>
                        <div class="item" data-value="Usado">Usado</div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label>Cor</label>
                <div class="ui labeled input">
                    <label for="cor" class="ui label"><i class="paint brush icon"></i></label>
                    
                    <input type="text" name="cor" placeholder="Cor">
                </div>
            </div>

            <div class="field">
                <label>Ano/Modelo</label>
                <div class="ui labeled input">
                    <label for="ano" class="ui label"><i class="calendar outline icon"></i></label>
                    
                    <input type="text"  name="ano" placeholder="Ano">
                </div>
            </div>

            <div class="field">
                <label>Observações</label>
                <div class="ui labeled input">
                    <label for="observacoes" class="ui label"><i class="quote left outline icon"></i></label>
                    
                    <textarea name="observacoes" placeholder="Observações"></textarea>
                </div>
            </div>

            <div class="field">
                <label>Valor de Venda</label>
                <div class="ui labeled input">
                    <label for="valor" class="ui label">R$</label>
                    
                    <input type="text"  name="valor" placeholder="Valor">
                </div>
            </div>

                        
            <div class="field">
                <label>Opcionais</label>
                <div dropdown-id="veiculo-opcional" class="ui fluid dropdown labeled multiple search icon button">
                <!-- <div class="ui fluid multiple search selection dropdown labeled button"> -->
                    <input type="hidden" name="opcionais">
                    <i class="check square icon"></i>
                    <div class="default text">Opcionais</div>
                    <div class="menu">
                        <div class="ui top attached button fluid  insert-secondary" data-insert="opcional">
                            <i class="plus icon"></i>
                            Cadastrar Novo Opcional
                        </div>
                        <?php
                        $opcionais = $this->veiculos_model->get_opcionais_lista();
                        foreach($opcionais as $opcional){
                            ?><div class="item" data-value="<?=$opcional['id_opcional']?>"><?=$opcional['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>
                        
            <div class="field">
                <label>Tipos de Combustível</label>
                <div dropdown-id="veiculo-combustivel" class="ui fluid dropdown labeled multiple search icon button">
                <!-- <div class="ui fluid multiple search selection dropdown labeled button"> -->
                    <input type="hidden" name="combustivel">
                    <i class="battery full icon"></i>
                    <div class="default text">Tipos de Combustível</div>
                    <div class="menu">
                        <div class="ui top attached button fluid  insert-secondary" data-insert="combustivel">
                            <i class="plus icon"></i>
                            Cadastrar Novo Tipo de Combustível
                        </div>
                        <?php
                        $combustiveis = $this->veiculos_model->get_combustiveis_lista();
                        foreach($combustiveis as $combustivel){
                            ?><div class="item" data-value="<?=$combustivel['id_combustivel']?>"><?=$combustivel['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <h4 class="ui horizontal divider header">
                <i class="image icon"></i>
                Imagens
            </h4>

            <?php for($index=0; $index< 7; $index++){ ?>
            <div class="field">
            <!-- <form id="form-img<?=$index?>" method="post" enctype="multipart/form-data"  action="<?=base_url('admin/vehicle/image');?>"> -->
                <img id="img<?=$index?>" class="ui small image left floated middle aligned" src="<?=base_url('assets/img/image_frame.png')?>">
                    
                <div class="ui labeled mini input">
                    <label for="imagem<?=$index?>" class="ui label"><i class="upload icon"></i></label>
                    
                    <input type="file" to="img<?=$index?>" name="image<?=$index?>">
                </div>
            <!-- </form> -->
            </div>
                </br>
            <?php } ?>

        </div>
        <div class="eight wide column">
            <div class="ui error message"></div>
        </div>
        <div class="row">
            <div class="sixteen wide column">
                <div class="fluid ui submit button"  tabindex="0">Cadastrar</div>
            </div>    
        </div>

    </div>

    </form>

</div>

<div class="ui tab segment" data-tab="update">
    
    <form id="update_form" class="ui form vehicle" url="<?php echo base_url('admin/user/update');?>" enctype="multipart/form-data">

    <div class="ui centered grid">

        <div class="message_spot row hide">
            <div class="sixteen wide column">
            </div>    
        </div>

        <div class="eight wide column">
            
            <input type="hidden" name="id">
            <div class="field">
                <label>Tipo</label>
                <div class="ui fluid dropdown labeled search icon button">
                    <input type="hidden" name="tipo">
                    <i class="car icon"></i>
                    <div class="default text">Tipo</div>
                    <div class="menu">
                        <?php
                        $tipos = $this->veiculos_model->get_tipos();
                        foreach($tipos as $tipo){
                            ?><div class="item" data-value="<?=$tipo['id_tipo']?>"><?=$tipo['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            
            <div class="field">
                <label>Marca</label>
                <div class="ui fluid dropdown labeled search icon button">
                    <input type="hidden" name="marca">
                    <i class="cubes icon"></i>
                    <div class="default text">Marca</div>
                    <div class="menu">
                        <?php
                        $marcas = $this->veiculos_model->get_marcas();
                        foreach($marcas as $marca){
                            ?><div class="item" data-value="<?=$marca['id_marca']?>"><?=$marca['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>

                        
            <div class="field">
                <label>Modelo</label>
                <div class="ui fluid dropdown labeled search icon button">
                    <input type="hidden" name="modelo">
                    <i class="cube icon"></i>
                    <div class="default text">Modelo</div>
                    <div class="menu">
                        <?php
                        $modelos = $this->veiculos_model->get_modelos();
                        foreach($modelos as $modelo){
                            ?><div class="item" data-value="<?=$modelo['id_modelo']?>"><?=$modelo['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>


            <div class="field">
                <label>Estado</label>
                <div class="ui fluid dropdown labeled search icon button">
                    <input type="hidden" name="estado">
                    <i class="asterisk icon"></i>
                    <div class="default text">Estado</div>
                    <div class="menu">
                        <div class="item" data-value="Novo">Novo</div>
                        <div class="item" data-value="Usado">Usado</div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label>Cor</label>
                <div class="ui labeled input">
                    <label for="cor" class="ui label"><i class="paint brush icon"></i></label>
                    
                    <input type="text" name="cor" placeholder="Cor">
                </div>
            </div>

            <div class="field">
                <label>Ano/Modelo</label>
                <div class="ui labeled input">
                    <label for="ano" class="ui label"><i class="calendar outline icon"></i></label>
                    
                    <input type="text"  name="ano" placeholder="Ano">
                </div>
            </div>

            <div class="field">
                <label>Observações</label>
                <div class="ui labeled input">
                    <label for="observacoes" class="ui label"><i class="quote left outline icon"></i></label>
                    
                    <textarea name="observacoes" placeholder="Observações"></textarea>
                </div>
            </div>

            <div class="field">
                <label>Valor de Venda</label>
                <div class="ui labeled input">
                    <label for="valor" class="ui label">R$</label>
                    
                    <input type="text"  name="valor" placeholder="Valor">
                </div>
            </div>

                        
            <div class="field">
                <label>Opcionais</label>
                <div class="ui fluid dropdown labeled multiple search icon button">
                <!-- <div class="ui fluid multiple search selection dropdown labeled button"> -->
                    <input type="hidden" name="opcionais">
                    <i class="check square icon"></i>
                    <div class="default text">Opcionais</div>
                    <div class="menu">
                        <?php
                        $opcionais = $this->veiculos_model->get_opcionais_lista();
                        foreach($opcionais as $opcional){
                            ?><div class="item" data-value="<?=$opcional['id_opcional']?>"><?=$opcional['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>
                        
            <div class="field">
                <label>Tipos de Combustível</label>
                <div class="ui fluid dropdown labeled multiple search icon button">
                <!-- <div class="ui fluid multiple search selection dropdown labeled button"> -->
                    <input type="hidden" name="combustivel">
                    <i class="battery full icon"></i>
                    <div class="default text">Tipos de Combustível</div>
                    <div class="menu">
                        <?php
                        $combustiveis = $this->veiculos_model->get_combustiveis_lista();
                        foreach($combustiveis as $combustivel){
                            ?><div class="item" data-value="<?=$combustivel['id_combustivel']?>"><?=$combustivel['nome']?></div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <h4 class="ui horizontal divider header">
                <i class="image icon"></i>
                Imagens
            </h4>

            <?php for($index=0; $index< 7; $index++){ ?>
            <div class="field">
            <!-- <form id="form-img<?=$index?>" method="post" enctype="multipart/form-data"  action="<?=base_url('admin/vehicle/image');?>"> -->
                <img id="update_img<?=$index?>" class="ui small image left floated middle aligned" src="<?=base_url('assets/img/image_frame.png')?>">
                    
                <div class="ui labeled mini input">
                    <label for="imagem<?=$index?>" class="ui label"><i class="upload icon"></i></label>
                    
                    <input type="file" to="update_img<?=$index?>" name="image<?=$index?>">
                </div>
            <!-- </form> -->
            </div>
                </br>
            <?php } ?>

        </div>
        <div class="eight wide column">
            <div class="ui error message"></div>
        </div>

        <div class="row">
            <div class="seven wide column">
                <div class="fluid ui submit button"  tabindex="0">Modificar</div>
            </div>    
        </div>

    </div>

    </form>

</div>


<div id="insert-tipo" class="ui modal" data-dropdown-id="veiculo-tipo" style="bottom: auto; overflow: visible;">
    <i class="ui close icon"></i>
    <div class="header">
        Cadastrar Novo Tipo
    </div>
    <div class="image content">
        <div class="image">
            <i class="ui car large icon"></i>
        </div>

        <div class="description" style="width: 100%">

            <form id="form_marca" class="ui form type" action="<?= base_url('admin/vehicle/type/insert'); ?>" method="post">

            <div class="ui centered grid">
                <div class="message_spot row hide">
                    <div class="sixteen wide column">
                    </div>    
                </div>

                <div class="eight wide column">

                    <div class="field">
                    <label>Nome</label>
                    <div class="ui labeled input">
                        <label for="nome" class="ui label"><i class="id card icon"></i></label>
                        
                        <input type="text" name="nome" placeholder="Nome">
                    </div>
                    </div>

                    <div class="field">
                        <label>Nome (plural)</label>
                        <div class="ui labeled input">
                            <label for="plural" class="ui label"><i class="id card icon"></i></label>
                            
                            <input id="tipo_nome_plural" type="text"  name="plural" placeholder="Nome (plural)">
                        </div>
                    </div>

                    <div class="field">
                        <label>Link</label>
                        <div class="ui labeled input">
                            <label for="url" class="ui label"><i class="world icon"></i></label>
                            
                            <input id="tipo_url" type="text"  name="url" placeholder="Link">
                        </div>
                    </div>

                </div>
                <div class="eight wide column">
                    <div class="ui error message"></div>
                </div>

            </div>

            </form>

        </div>
    </div>
    <div class="actions">
        <div class="ui button red remove-register">Remover</div>
        <div class="ui button cancel">Cancel</div>
        <div class="ui button positive">OK</div>
    </div>
</div>

<div id="insert-marca" class="ui modal" data-dropdown-id="veiculo-marca" style="bottom: auto; overflow: visible;">
    <i class="ui close icon"></i>
    <div class="header">
        Cadastrar Nova Marca
    </div>
    <div class="image content">
        <div class="image">
            <i class="ui car large icon"></i>
        </div>

        <div class="description" style="width: 100%">

            <form class="ui form brand" action="<?= base_url('admin/vehicle/brand/insert'); ?>" method="post">

            <div class="ui centered grid">
                <div class="message_spot row hide">
                    <div class="sixteen wide column">
                    </div>    
                </div>

                <div class="eight wide column">

                    <div class="field">
                        <label>Tipo</label>
                        <div dropdown-id="veiculo-tipo" class="ui fluid dropdown labeled search icon button">
                            <input type="hidden" name="tipo">
                            <i class="car icon"></i>
                            <div class="default text">Tipo</div>
                            <div class="menu">
                                <?php
                                $tipos = $this->veiculos_model->get_tipos();
                                foreach($tipos as $tipo){
                                    ?><div class="item" data-value="<?=$tipo['id_tipo']?>"><?=$tipo['nome']?></div><?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label>Nome </label>
                        <div class="ui labeled input">
                            <label for="nome" class="ui label"><i class="id card icon"></i></label>
                            
                            <input type="text"  name="nome" placeholder="Nome">
                        </div>
                    </div>

                </div>
                <div class="eight wide column">
                    <div class="ui error message"></div>
                </div>

            </div>

            </form>

        </div>
    </div>
    <div class="actions">
        <div class="ui button red remove-register">Remover</div>
        <div class="ui button cancel">Cancel</div>
        <div class="ui button positive">OK</div>
    </div>
</div>

<div id="insert-modelo" class="ui modal" data-dropdown-id="veiculo-modelo" style="bottom: auto; overflow: visible;"> 
    <i class="ui close icon"></i>
    <div class="header">
        Cadastrar Novo Tipo
    </div>
    <div class="image content">
        <div class="image">
            <i class="ui car large icon"></i>
        </div>

        <div class="description" style="width: 100%">

            <form class="ui form model" action="<?= base_url('admin/vehicle/model/insert'); ?>" method="post">

            <div class="ui centered grid">
                <div class="message_spot row hide">
                    <div class="sixteen wide column">
                    </div>    
                </div>

                <div class="eight wide column">

                    <div class="field">
                        <label>Tipo</label>
                        <div dropdown-id="veiculo-tipo" class="ui fluid dropdown labeled search icon button">
                            <input type="hidden" name="tipo">
                            <i class="car icon"></i>
                            <div class="default text">Tipo</div>
                            <div class="menu">
                                <?php
                                $tipos = $this->veiculos_model->get_tipos();
                                foreach($tipos as $tipo){
                                    ?><div class="item" data-value="<?=$tipo['id_tipo']?>"><?=$tipo['nome']?></div><?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label>Marca</label>
                        <div dropdown-id="veiculo-marca" class="ui fluid dropdown labeled search icon button">
                            <input type="hidden" name="marca">
                            <i class="cubes icon"></i>
                            <div class="default text">Marca</div>
                            <div class="menu">
                                <?php
                                $marcas = $this->veiculos_model->get_marcas();
                                foreach($marcas as $marca){
                                    ?><div class="item" data-value="<?=$marca['id_marca']?>"><?=$marca['nome']?></div><?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>                    

                    <div class="field">
                    <label>Nome</label>
                    <div class="ui labeled input">
                        <label for="nome" class="ui label"><i class="id card icon"></i></label>
                        
                        <input type="text" name="nome" placeholder="Nome">
                    </div>
                    </div>

                </div>
                <div class="eight wide column">
                    <div class="ui error message"></div>
                </div>

            </div>

            </form>

        </div>
    </div>
    <div class="actions">
        <div class="ui button red remove-register">Remover</div>
        <div class="ui button cancel">Cancel</div>
        <div class="ui button positive">OK</div>
    </div>
</div>

<div id="insert-opcional" class="ui modal" data-dropdown-id="veiculo-opcional" style="bottom: auto; overflow: visible;">
    <i class="ui close icon"></i>
    <div class="header">
        Cadastrar Novo Tipo
    </div>
    <div class="image content">
        <div class="image">
            <i class="ui car large icon"></i>
        </div>

        <div class="description" style="width: 100%">

            <form class="ui form optional" action="<?= base_url('admin/vehicle/optional/insert'); ?>" method="post">

            <div class="ui centered grid">
                <div class="message_spot row hide">
                    <div class="sixteen wide column">
                    </div>    
                </div>

                <div class="eight wide column">

                    <div class="field">
                    <label>Nome</label>
                    <div class="ui labeled input">
                        <label for="nome" class="ui label"><i class="id card icon"></i></label>
                        
                        <input type="text" name="nome" placeholder="Nome">
                    </div>
                    </div>

                </div>
                <div class="eight wide column">
                    <div class="ui error message"></div>
                </div>

            </div>

            </form>

        </div>
    </div>
    <div class="actions">
        <div class="ui button red remove-register">Remover</div>
        <div class="ui button cancel">Cancel</div>
        <div class="ui button positive">OK</div>
    </div>
</div>

<div id="insert-combustivel" class="ui modal" data-dropdown-id="veiculo-combustivel" style="bottom: auto; overflow: visible;">
    <i class="ui close icon"></i>
    <div class="header">
        Cadastrar Novo Tipo
    </div>
    <div class="image content">
        <div class="image">
            <i class="ui car large icon"></i>
        </div>

        <div class="description" style="width: 100%">

            <form class="ui form fuel" action="<?= base_url('admin/vehicle/fuel/insert'); ?>" method="post">

            <div class="ui centered grid">
                <div class="message_spot row hide">
                    <div class="sixteen wide column">
                    </div>    
                </div>

                <div class="eight wide column">

                    <div class="field">
                    <label>Nome</label>
                    <div class="ui labeled input">
                        <label for="nome" class="ui label"><i class="id card icon"></i></label>
                        
                        <input type="text" name="nome" placeholder="Nome">
                    </div>
                    </div>

                </div>
                <div class="eight wide column">
                    <div class="ui error message"></div>
                </div>

            </div>

            </form>

        </div>
    </div>
    <div class="actions">
        <div class="ui button red remove-register">Remover</div>
        <div class="ui button cancel">Cancel</div>
        <div class="ui button positive">OK</div>
    </div>
</div>

<div id="remove-confirmation" class="ui modal mini" style="bottom: auto">
  <div class="header">Confirmação</div>
  <div class="content">
    <p>Tem certeza que deseja excluir esses itens?</p>
    <p class="items"></p>
  </div>
  <div class="actions">
    <div class="ui negative button">Não</div>
    <div class="ui positive button">Sim</div>
  </div>
</div>

<script>
    var options = {
        <?php foreach($options as $key => $value){ ?>
            "<?=$key?>": "<?=$value?>",
        <?php } ?>
    };
</script>
