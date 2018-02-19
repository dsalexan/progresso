<?php
                    $combustiveis = $this->veiculos_model->get_combustiveis_lista();
                    foreach($combustiveis as $combustivel){
                        ?><div class="item" data-value="<?=$combustivel['id_combustivel']?>">
                        <div><?=$combustivel['nome']?></div>
                        <div class="ui icon button edit" data-value="<?=$combustivel['id_combustivel']?>"><i class="ui write icon"></i></div>
                        </div>
                        <?php
                    }
                    ?>