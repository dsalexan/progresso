<?php
$marcas = $this->veiculos_model->get_marcas_lista(1);
foreach($marcas as $marca){
    ?><div class="item" data-value="<?=$marca['id_marca']?>">
    <div><?=$marca['nome']?></div>
    <div class="ui icon button edit" data-value="<?=$marca['id_marca']?>"><i class="ui write icon"></i></div>
    </div>
    <?php
}
?>