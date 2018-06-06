<?php 
	function get_veiculo_ano($a){
		$d = strpos($a, "/");
		if($d == false){
			return $a;
		}else{
			return substr($a, 0, $d);
		}
	}

	function get_modelo_ano($a){
		$d = strpos($a, "/");
		if($d == false){
			return $a;
		}else{
			return substr($a, $d+1, strlen($a));
		}
	}
?>
	
	<div id="wrap-body">
		<div class="container">
			<div class="wrap-body-inner">
				<section class="m-t-lg-30 m-t-xs-0">
					<div class="product_detail no-bg p-lg-0">
						<h3 class="product-name color1-f">
							<?=$veiculo['tipo']['nome']?> /
							<span class="product-price color-red">R$ <?= number_format($veiculo['venda_valor'], 2, ',', '.') ?></span>
						</h3>
						<div class="row">
							<div class="col-lg-9">
								<div class="product-img-lg bg-gray-f5 bg1-gray-15">
									<div id="myCarousel" class="carousel slide" data-ride="carousel">
										<div class="carousel-inner">
                                            <?php
                                            $i = 0;
                                            foreach($veiculo['imagens'] as $imagem){
                                                $url_image = $imagem['url_imagem'];

                                                if (!@getimagesize(base_url('assets/img/veiculos/'.$url_image))) {
                                                    $url_image = 'image_frame.png';
                                                }
                                            ?>
                                                <div class="carousel-item <?php if($i==0) echo 'active';?>">
                                                    <img class="d-block w-100" src="<?=base_url('assets/img/veiculos/'.$url_image);?>">
                                                </div>
                                                <?php
                                                $i++;
                                            }
                                            ?>
										</div>
										<a class="carousel-control-prev" href="#" role="button" data-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true">
												<i class="ui icon chevron circle left" style="color: white;"></i>
											</span>
											<span class="sr-only">Previous</span>
										</a>
										<a class="carousel-control-next" href="#" role="button" data-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true">
												<i class="ui icon chevron circle right" style="color: white;"></i>
											</span>
											<span class="sr-only">Next</span>
										</a><!--
										<a class="carousel-control-prev" href="#" role="button" data-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="sr-only">Previous</span>
										</a>
										<a class="carousel-control-next" href="#" role="button" data-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="sr-only">Next</span>
										</a>-->
									</div>
								</div>
							</div>
							<div class="col-md-5 col-lg-3">
								<ul class="product_para-1 p-lg-15 bg-gray-f5 bg1-gray-15" style="list-style-type: none;">
									<li><span style="display: block; width: 25%;">Modelo:</span>
										<div style="text-align: right;"> <?=$veiculo['modelo']['nome']?> </div>
										<div style="text-align: right;"> <?=get_modelo_ano($veiculo['ano'])?> </div>
									</li>
									<li><span>Marca:</span><a href="<?=base_url($veiculo['tipo']['url'].'/marca/'.$veiculo['marca']['id_marca']);?>"><?=$veiculo['marca']['nome']?></a></li>
									<li><span>Tipo:</span><a href="<?=base_url($veiculo['tipo']['url']);?>"><?=$veiculo['tipo']['nome']?></a></li>
									<li><span>Cor:</span><?=$veiculo['cor']?></li>
									<li><span>Estado:</span><?= $veiculo['estado'] == "Novo" ? "Novo" : "Seminovo"; ?></li>
									<li><span>Ano:</span><?=get_veiculo_ano($veiculo['ano'])?></li>
									<li><span>Combustível:</span>
                                        <?php 
                                        $i = 0;
                                        foreach($veiculo['combustiveis'] as $combustivel){
                                            echo $combustivel['nome'];
                                            if($i < count($veiculo['combustiveis']) -1) echo ', ';
                                        
                                            $i++;
                                        } ?>
                                    </li>
                                    <li><span>Opcionais:</span></br>
                                        <div style="color: transparent">.</div>
                                        <?php
                                        $i=0;
                                        foreach($veiculo['opcionais'] as $opcional){
                                            ?>
                                            <div style="padding-left: 1em"><?=$opcional['nome']?></div style="padding-left: 1em">
                                            
                                            
                                            <?php
                                        
                                            $i++;
                                        } ?>
                                    </li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row m-t-lg-30 m-b-lg-50">
						<div class="col-md-8">
							<div class="m-b-lg-30">
								<div class="heading-1"><h3>Descrição</h3></div>
								<div class="m-b-lg-30 bg-gray-fa bg1-gray-2 p-lg-30 p-xs-15" style="text-align: justify;text-justify: inter-word;">
									<p class="color1-9">
										<?=$veiculo['observacoes'];?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</body>
</html>
