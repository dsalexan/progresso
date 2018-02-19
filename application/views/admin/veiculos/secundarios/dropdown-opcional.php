<?php
                    $opcionais = $this->veiculos_model->get_opcionais_lista();
                    foreach($opcionais as $opcional){
                        ?><div class="item" data-value="<?=$opcional['id_opcional']?>">
                        <div><?=$opcional['nome']?></div>
                        <div class="ui icon button edit" data-value="<?=$opcional['id_opcional']?>"><i class="ui write icon"></i></div>
                        </div>
                        <?php
                    }
                    ?>