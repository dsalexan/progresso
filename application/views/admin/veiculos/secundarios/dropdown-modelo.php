<?php
                    $modelos = $this->veiculos_model->get_modelos(1);
                    foreach($modelos as $modelo){
                        ?><div class="item" data-value="<?=$modelo['id_modelo']?>">
                        <div><?=$modelo['nome']?></div>
                        <div class="ui icon button edit" data-value="<?=$modelo['id_modelo']?>"><i class="ui write icon"></i></div>
                        </div>
                        <?php
                    }
                    ?>