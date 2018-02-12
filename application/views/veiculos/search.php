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
                    <?php
                        unset($_SESSION['no_results'])
                    ?>
                </div>
                <?php endif; ?>
                    <div class="ui four doubling cards">
                    <?php foreach($results as $veiculo){ ?>
                        <div class="ui card">
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
                                <a class="ui grey right ribbon label hoverable" href="<?= base_url($veiculo['tipo']['url']); ?>"><?= $veiculo['tipo']['nome']; ?></a>
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