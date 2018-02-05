<div id="wrap-body">
    <div class="container">
        <div class="wrap-body-inner">
            <div class="">
                <div class="heading background-gradient">
                    <h3 class="wrapper" style="margin-right: 3em;">
                        <div class="centralize"><?= $query ?></div>
                    </h3>
                </div>
                    <?php if($this->session->flashdata('no_results')): ?>
                    <div class="ui floating large message">
                        <p><?= $this->session->flashdata('no_results'); ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="ui three stackable cards">
                        <?php foreach($results as $veiculo){ ?>
                            <div class="ui displayed card">
                                <div class="ui display" tabindex="0">
                                    <p><i class="chevron right icon"></i> </p>
                                    <div class="ui content segment">
                                        <div class="ui horizontal divider">
                                            <i class="image icon"></i>
                                            Fotos
                                        </div>
                                        <div class="ui centered small images" style="text-align: center">
                                            <?php for($i=1; $i < 5; $i++){
                                                $url_image = '';
                                                if(count($veiculo['imagens'])-1 > $i){ //ainda tem imagens pra colocar
                                                    $url_image = $veiculo['id_veiculo'].'/'.$veiculo['imagens'][$i]['url_imagem'];
                                                }else{ // n tem mais imagens,coloca o frame
                                                    $url_image = 'image_frame.png';
                                                }

                                                ?><img src="<?= base_url('assets/img/veiculos/'.$url_image) ?>"><?php
                                             } ?>
                                        </div>
                                        
                                        <div class="ui horizontal divider">
                                            <i class="info icon"></i>
                                            Informações
                                        </div>

                                        <div class="ui grid">
                                      
                                            <div class="eleven wide left floated right aligned column">
                                                <?= $veiculo['observacoes'] ?>
                                            </div>      
                                            
                                            <div class="five wide column">
                                            
                                                <div class="ui horizontal small statistic">
                                                    <div class="label">
                                                    R$
                                                    </div>
                                                    <div class="value">
                                                    <?= $veiculo['venda_valor'];?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui slide masked reveal image">
                                    <img src="<?= base_url('assets/img/veiculos/'.$veiculo['id_veiculo'].'/'.$veiculo['imagens'][0]['url_imagem']) ?>" class="visible content">
                                    <img src="<?= base_url('assets/img/veiculos/'.$veiculo['id_veiculo'].'/'.$veiculo['imagens'][1]['url_imagem']) ?>" class="hidden content">
                                </div>
                                <div class="content">
                                    <?php if($veiculo['estado'] == 'Novo'): ?>
                                    <div class="ui red ribbon label colapsed-hidden"><?= $veiculo['estado']; ?></div>
                                    <?php else: ?>
                                    <div class="ui grey ribbon label colapsed-hidden"><?= $veiculo['estado']; ?></div>
                                    <?php endif; ?>
                                    <a class="header" href="<?= base_url($veiculo['tipo']['url'].'/'.$veiculo['id_veiculo']); ?>"><?= $veiculo['modelo']['nome']; ?></a>
                                    <div class="description">
                                    <span class="date"><?= $veiculo['ano'] ?> - <?= $veiculo['cor']; ?></span>
                                    </div>
                                </div>
                                <div class="extra content">
                                    <a style="" href="<?= base_url($veiculo['tipo']['url'].'/marca/'.$veiculo['marca']['id_marca']); ?>">
                                        <i class="tag icon"></i><?= $veiculo['marca']['nome']; ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>