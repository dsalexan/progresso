<form form-id="<?=$acao?>_form" data-role="<?=$acao?>" class="ui form vehicle" url="<?php echo base_url('admin/vehicle/'.$acao);?>" method="post" enctype="multipart/form-data">

<div class="ui centered stackable grid">
    <div class="message_spot row hide">
        <div class="sixteen wide column">
        </div>    
    </div>

    <div class="computer reversed row">
        <div class="eight wide column">
            <div class="ui error message"></div>
        </div>

        <div class="eight wide column">

            <div class="field">
            <label>Teste</label>
            <div class="ui button fluid roll-test">Rodar Teste</div>
            </div>

            <?php if($acao=='update'): ?>
            <input type="hidden" name="id">
            <?php endif; ?>

            <div class="field">
                <label>Tipo</label>
                <div dropdown-id="veiculo-tipo" class="ui fluid dropdown labeled search icon button editable" data-group="1">
                    <input type="hidden" name="tipo">
                    <i class="car icon"></i>
                    <div class="default text">Tipo</div>
                    <div class="menu">
                        <div class="ui buttons grid fluid top attached">
                            <div class="ui eleven wide column button insert-secondary" clear data-insert="tipo">
                                <i class="plus icon"></i>
                                Cadastrar Novo Tipo
                            </div>
                            <div class="ui three wide column button table-secondary" clear data-table="tipo">
                                Listar
                            </div>
                            <div class="ui two wide column button clear-secondary" clear dropdown-id="veiculo-tipo">
                                <i class="icon minus circle"></i>
                            </div>
                        </div>
                        <?php $this->load->view('admin/veiculos/secundarios/dropdown-tipo.php');?>
                    </div>
                </div>
            </div>

            
            <div class="field">
                <label>Marca</label>
                <div dropdown-id="veiculo-marca" class="ui fluid dropdown labeled search icon button editable" data-group="1">
                    <input type="hidden" name="marca">
                    <i class="cubes icon"></i>
                    <div class="default text">Marca</div>
                    <div class="menu">
                        <div class="ui buttons grid fluid top attached">
                            <div class="ui eleven wide column button insert-secondary" clear data-insert="marca">
                                <i class="plus icon"></i>
                                Cadastrar Nova Marca
                            </div>
                            <div class="ui three wide column button table-secondary" clear data-table="marca">
                                Listar
                            </div>
                            <div class="ui two wide column button clear-secondary" clear dropdown-id="veiculo-tipo">
                                <i class="icon minus circle"></i>
                            </div>
                        </div>
                        <?php $this->load->view('admin/veiculos/secundarios/dropdown-marca.php');?>
                    </div>
                </div>
            </div>

                        
            <div class="field">
                <label>Modelo</label>
                <div dropdown-id="veiculo-modelo" class="ui fluid dropdown labeled search icon button editable" data-group="1">
                    <input type="hidden" name="modelo">
                    <i class="cube icon"></i>
                    <div class="default text">Modelo</div>
                    <div class="menu">
                        <div class="ui buttons grid fluid top attached">
                            <div class="ui eleven wide column button insert-secondary" clear data-insert="modelo">
                                <i class="plus icon"></i>
                                Cadastrar Novo Modelo
                            </div>
                            <div class="ui three wide column button table-secondary" clear data-table="modelo">
                                Listar
                            </div>
                            <div class="ui two wide column button clear-secondary" clear dropdown-id="veiculo-tipo">
                                <i class="icon minus circle"></i>
                            </div>
                        </div>
                        <?php $this->load->view('admin/veiculos/secundarios/dropdown-modelo.php');?>
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
                <div dropdown-id="veiculo-opcional" class="ui fluid dropdown labeled multiple search icon button editable">
                <!-- <div class="ui fluid multiple search selection dropdown labeled button"> -->
                    <input type="hidden" name="opcionais">
                    <i class="check square icon"></i>
                    <div class="default text">Opcionais</div>
                    <div class="menu">
                        <div class="ui buttons grid fluid top attached">
                            <div class="ui eleven wide column button insert-secondary" clear data-insert="opcional">
                                <i class="plus icon"></i>
                                Cadastrar Novo Opcional
                            </div>
                            <div class="ui three wide column button table-secondary" clear data-table="opcional">
                                Listar
                            </div>
                            <div class="ui two wide column button clear-secondary" clear dropdown-id="veiculo-tipo">
                                <i class="icon minus circle"></i>
                            </div>
                        </div>
                        <?php $this->load->view('admin/veiculos/secundarios/dropdown-opcional.php');?>
                    </div>
                </div>
            </div>
                        
            <div class="field">
                <label>Tipos de Combustível</label>
                <div dropdown-id="veiculo-combustivel" class="ui fluid dropdown labeled multiple search icon button editable">
                <!-- <div class="ui fluid multiple search selection dropdown labeled button"> -->
                    <input type="hidden" name="combustivel">
                    <i class="battery full icon"></i>
                    <div class="default text">Tipos de Combustível</div>
                    <div class="menu">
                        <div class="ui buttons grid fluid top attached">
                            <div class="ui eleven wide column button insert-secondary" clear data-insert="combustivel">
                                <i class="plus icon"></i>
                                Cadastrar Novo Tipo de Combustível
                            </div>
                            <div class="ui three wide column button table-secondary" clear data-table="combustivel">
                                Listar
                            </div>
                            <div class="ui two wide column button clear-secondary" clear dropdown-id="veiculo-tipo">
                                <i class="icon minus circle"></i>
                            </div>
                        </div>
                        <?php $this->load->view('admin/veiculos/secundarios/dropdown-combustivel.php');?>
                    </div>
                </div>
            </div>

            <h4 class="ui horizontal divider header">
                <i class="image icon"></i>
                Imagens
            </h4>

            <?php for($index=0; $index< 0; $index++){ ?>
            <div class="field">
            <!-- <form id="form-img<?=$index?>" method="post" enctype="multipart/form-data"  action="<?=base_url('admin/vehicle/image');?>"> -->
                <img image-id="img<?=$index?>" class="ui small image left floated middle aligned" src="<?=base_url('assets/img/image_frame.png')?>">
                    
                <div class="ui labeled mini input">
                    <label for="imagem<?=$index?>" class="ui label"><i class="upload icon"></i></label>
                    
                    <input type="file" to="img<?=$index?>" name="image<?=$index?>">
                </div>
            <!-- </form> -->
            </div>
            </br>
            <?php } ?>

            <div class="fine-uploader-element"></div>

        </div>
    </div>

    <div class="row">
        <div class="sixteen wide column">
            <div class="fluid ui submit-form button"  tabindex="0">
                <?php
                    if($acao=='insert') echo 'Cadastrar';
                    elseif($acao=='update') echo 'Modificar';
                ?>
            </div>
        </div>    
    </div>

</div>

</form>