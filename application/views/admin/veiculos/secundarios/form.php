
<div id="insert-<?=$objeto['tabela']['nome']?>" class="ui modal" data-dropdown-id="veiculo-<?=$objeto['tabela']['nome']?>" data-table-name="<?=$objeto['tabela']['nome']?>" style="bottom: auto; overflow: visible;">
    <i class="ui close icon"></i>
    <div class="header insert">
        Cadastrar Novo <?=$objeto['tabela']['alt']?>
    </div>
    <div class="header update" hidden>
        Modificar <?=$objeto['tabela']['alt']?>
    </div>
    <div class="image content">
        <div class="image">
            <i class="ui <?=$objeto['tabela']['icone']?> large icon"></i>
        </div>

        <div class="description" style="width: 100%">

            <form class="ui form <?=$objeto['tabela']['link']?>" action="<?= base_url('admin/vehicle/'.$objeto['tabela']['link'].'/'.$objeto['acao']); ?>" method="post">

            <div class="ui centered grid">
                <div class="message_spot row hide">
                    <div class="sixteen wide column">
                    </div>    
                </div>

                <div class="eight wide column">

                    <?php
                        foreach($objeto['campos'] as $campo){
                    ?>
                            <div class="field">
                            <label><?=$campo['label']?></label>


                        <?php if($campo['tipo'] == 'text'): ?>

                            <div class="ui labeled input">
                                <label for="<?=$campo['nome']?>" class="ui label"><i class="id <?=$campo['icone']?> icon"></i></label>
                                
                                <input tabindex=0 autofocus <?php if($campo['id']!==false) echo 'id="'.$campo['id'].'"'; ?> type="text" name="<?=$campo['nome']?>" placeholder="<?=$campo['placeholder']?>">
                            </div>

                        <?php endif;
                        if($campo['tipo'] == 'dropdown'): ?>

                            <div dropdown-id="veiculo-<?=$campo['nome']?>" class="ui fluid dropdown labeled search icon button">
                                <input type="hidden" name="<?=$campo['nome']?>">
                                <i class="<?=$campo['icone']?> icon"></i>
                                <div class="default text"><?=$campo['placeholder']?></div>
                                <div class="menu">
                                    <?php $this->load->view('admin/veiculos/secundarios/dropdown.php', ['campo' => $campo]);?>
                                </div>
                            </div>

                        <?php endif;?>
                        
                            </div>
                    <?php
                        }
                    ?>

                </div>
                <div class="eight wide column">
                    <div class="ui error message"></div>
                </div>

            </div>

            </form>

        </div>
    </div>
    <div class="actions">
        <div class="ui button cancel">Cancel</div>
        <div class="ui button positive">OK</div>
    </div>
</div>