<?php
if($campo['edit'] == 'non-edit'){
    foreach($campo['dados']['origem'] as $dado){
        ?><div class="item" data-value="<?=$dado[$campo['dados']['valor']]?>"><?=$dado[$campo['dados']['texto']]?></div><?php
    }
}else{
    foreach($campo['dados']['origem'] as $dado){
        ?><div class="item" data-value="<?=$dado[$campo['dados']['valor']]?>">
        <div><?=$dado[$campo['dados']['texto']]?></div>
        <div class="ui icon button edit" data-value="<?=$dado[$campo['dados']['valor']]?>"><i class="ui write icon"></i></div>
        </div>
        <?php
    }
}
?>