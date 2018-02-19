<?php
$tipos = $this->veiculos_model->get_tipos(1);
foreach($tipos as $tipo){
    ?><div class="item" data-value="<?=$tipo['id_tipo']?>">
    <div><?=$tipo['nome']?></div>
    <div class="ui icon button edit" data-value="<?=$tipo['id_tipo']?>"><i class="ui write icon"></i></div>
    </div>
    <?php
}
?>