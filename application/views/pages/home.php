
<section class="block-sl">
    <div class="container">
        <div class="row">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <?php
                    $i = 0;
                    foreach($destaques as $veiculo){                        
                        $url_image = $veiculo['imagens'][0]['url_imagem'];

                        if (!@getimagesize(base_url('assets/img/veiculos/'.$url_image))) {
                            $url_image = 'image_frame.png';
                        }

                        $url_image = 'veiculos/'.$url_image;
                        // $url_image = '1.jpg'

                        ?>
                        <div class="carousel-item <?php if($i==0) echo 'active'; ?>" data-slide="<?=$i?>">
                                    
                            <div class="ui container" style="height: 400px; background-color: #111111 ">

                            <div class="ui middle aligned centered grid"  style="height: 400px;">
                                <div class="five wide column mask" style="overflow-x: hidden; height: 110%;">
                                    <!-- <img class="ui image" src="<?=base_url('assets/img/'.$url_image)?>"> -->
                                    <img class="ui image" src="<?=base_url('assets/img/'.$url_image)?>">

                                </div>
                                <div class="one wide computer only column"></div>
                                <div class="seven wide column mask" style="background-color: black">
                                    <div class="content">
                                        <h2 class="ui header"  style="color: #ddd;">
                                            <?= $veiculo['modelo']['nome']?>
                                            <div class="sub header"  style="color: #d11717;">
                                                <span><?= $veiculo['marca']['nome']?></span>
                                            </div>                                    
                                        </h2>
                                        <div class="description"  style="color: #bbb;">
                                            <p><?= $veiculo['observacoes']=='' ? '-' : $veiculo['observacoes']?></p>
                                        </div>
                                        </br>
                                        <div class="extra">
                                            <div class="ui label"><?= $veiculo['ano']?></div>
                                            <div class="ui label"><?= $veiculo['cor']?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>

                            <!-- <img class="d-block w-100" style="width: 100%;" src="<?=base_url('assets/img/'.$url_image)?>" alt="<?= $veiculo['marca']['nome']?>"> -->
                        </div>
                        <?php
                        $i++;
                    }

                    ?>
                </div>
                <a class="carousel-control-prev" href="#" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true">
                        <i class="ui icon chevron left"></i>
                    </span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true">
                        <i class="ui icon chevron right"></i>
                    </span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</section>


<div id="wrap-body">
    <div class="container">
        <div class="wrap-body-inner">
            <div class="">
                <wrapper id="template-wise">
                    <div class="heading">
                        <h3>Veículos</h3>
                    </div>
                </wrapper>

                <div class="ui right aligned top attached segment basic">


                    
                    <div id="filtro-marca" class="ui dropdown labeled multiple icon button">
                    <!-- <div class="ui fluid multiple search selection dropdown labeled button"> -->
                        <input type="hidden" name="marcas">
                        <i class="cubes icon"></i>
                        <div class="default text">Filtrar por Marcas</div>
                        <div class="menu">
                            <?php
                            $marcas = $this->veiculos_model->get_marcas();
                            foreach($marcas as $marca){
                                ?><div class="item" data-value="<?=$marca['id_marca']?>"><?=$marca['nome']?></div><?php
                            }
                            ?>
                        </div>
                    </div>


                    <div id="filtro-outros" class="ui floated labeled icon top right pointing dropdown button">
                        <input type="hidden" name="filtro">
                        <i class="filter icon"></i>
                        <span class="text">Filtrar Veículos</span>
                        <div class="menu">
                        <div class="ui search icon input">
                            <i class="search icon"></i>
                            <input type="text" name="search" placeholder="Pesquisar filtro...">
                        </div>
                        <div class="divider"></div>
                        <div class="header">
                            <i class="tags icon"></i>
                            Filtar por Preço
                        </div>
                        <div class="item" data-value="venda_valor DESC">
                            <div class="ui red empty circular label"></div>
                            Maior > Menor
                        </div>
                        <div class="item" data-value="venda_valor ASC">
                            <div class="ui blue empty circular label"></div>
                            Menor > Maior
                        </div>
                        <!-- <div class="divider"></div>
                        <div class="header">
                            <i class="calendar icon"></i>
                            Filtrar por Ano
                        </div>
                        <div class="item" data-value="">
                            <i class="olive circle icon"></i>
                            Maior > Menor
                        </div>
                        <div class="item" data-value="">
                            <i class="violet circle icon"></i>
                            Menor > Maior
                        </div> -->
                        </div>
                    </div>
                </div>

                <div id="vehicle-display" class="ui blurring attached segment">
                    <div class="ui inverted dimmer">
                        <div class="ui massive text loader">Acessando Banco de Dados</div>
                    </div>

                    <div class="ui three stackable cards">
                        <?php 
                        $idx=0;
                        foreach($results as $veiculo){ ?>
                            <div class="ui displayed card" data-index="<?=$idx?>">
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
                                                    $url_image = $veiculo['imagens'][$i]['url_imagem'];

                                                    if (!@getimagesize(base_url('assets/img/veiculos/'.$url_image))) {
                                                        $url_image = 'image_frame.png';
                                                    }
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
                                    <?php 
                                    if(count($veiculo['imagens']) == 0){
                                        $img1 = 'image_frame.png';
                                        $img2 = 'image_frame.png';
                                    }elseif(count($veiculo['imagens']) == 1){
                                        $img2 = 'image_frame.png';
                                    }else{
                                        $img1 = $veiculo['imagens'][0]['url_imagem'];
                                        $img2 = $veiculo['imagens'][1]['url_imagem'];
                                    }
                                    
                                    if (!@getimagesize(base_url('assets/img/veiculos/'.$img1))) {
                                        $img1 = 'image_frame.png';
                                    }
                                    if (!@getimagesize(base_url('assets/img/veiculos/'.$img2))) {
                                        $img2 = 'image_frame.png';
                                    }

                                    ?>
                                    <img src="<?= base_url('assets/img/veiculos/'.$img1) ?>" class="visible content">
                                    <img src="<?= base_url('assets/img/veiculos/'.$img2) ?>" class="hidden content">
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
                        <?php 
                        $idx++;
                        } ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="sample-card" hidden>
    <div class="ui displayed card">
        <div class="ui display" tabindex="0">
            <p><i class="chevron right icon"></i> </p>
            <div class="ui content segment">
                <div class="ui horizontal divider">
                    <i class="image icon"></i>
                    Fotos
                </div>
                <div class="ui centered small images" style="text-align: center">
                    <img field="imagem2" src="<?= base_url('assets/img/veiculos/image_frame.png') ?>">
                    <img field="imagem3" src="<?= base_url('assets/img/veiculos/image_frame.png') ?>">
                    <img field="imagem4" src="<?= base_url('assets/img/veiculos/image_frame.png') ?>">
                    <img field="imagem5" src="<?= base_url('assets/img/veiculos/image_frame.png') ?>">
                </div>
                
                <div class="ui horizontal divider">
                    <i class="info icon"></i>
                    Informações
                </div>

                <div class="ui grid">
                
                    <div class="eleven wide left floated right aligned column">
                        <span field="observacoes"></span>
                    </div>      
                    
                    <div class="five wide column">
                    
                        <div class="ui horizontal small statistic">
                            <div class="label">
                            R$
                            </div>
                            <div class="value">
                                <span field="venda_valor"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui slide masked reveal image">
            <img field="imagem1" src="<?= base_url('assets/img/veiculos/image_frame.png') ?>" class="visible content">
            <img field="imagem2" src="<?= base_url('assets/img/veiculos/image_frame.png') ?>" class="hidden content">
        </div>
        <div class="content">
            <div class="ui red ribbon label colapsed-hidden" value="Novo" hidden><span field="estado"></span></div>
            <div class="ui grey ribbon label colapsed-hidden" value="Usado" hidden><span field="estado"></span></div>

            <a class="header" href=""><span field="modelo"></span></a>
            <div class="description">
            <span class="date"><span field="ano"></span> - <span field="cor"></span></span>
            </div>
        </div>
        <div class="extra content">
            <a style="" href="">
                <i class="tag icon"></i><span field="marca"><span>
            </a>
        </div>
    </div>
</div>