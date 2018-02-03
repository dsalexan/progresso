<div id="wrap-body">
    <div class="container">
        <div class="wrap-body-inner">
            <div class="">
                <div class="heading background-gradient">
                    <h3 class="wrapper" style="margin-right: 3em;">
                        <div class="centralize"><?= $query ?></div>
                    </h3>
                </div>
                    <div class="ui four doubling cards">
                    <?php foreach($results as $veiculo){ ?>
                        <div class="ui card">
                            <div class="ui slide masked reveal image">
                                <img src="<?= base_url('assets/img/veiculos/'.$veiculo['id_veiculo'].'/'.$veiculo['imagens'][0]['url_imagem']) ?>" class="visible content">
                                <img src="<?= base_url('assets/img/veiculos/'.$veiculo['id_veiculo'].'/'.$veiculo['imagens'][1]['url_imagem']) ?>" class="hidden content">
                            </div>
                            <div class="content">
                                <a class="ui grey right ribbon label" href="<?= base_url($veiculo['tipo']['url']); ?>"><?= $veiculo['tipo']['nome']; ?></a>
                                <a class="header" href="<?= base_url($veiculo['tipo']['url'].'/'.$veiculo['id_veiculo']); ?>"><?= $veiculo['modelo']['nome']; ?></a>
                                <div class="description">
                                <span class="date"><?= $veiculo['ano'] ?> - <?= $veiculo['cor']; ?></span>
                                </div>
                            </div>
                            <div class="extra content">
                                <a style="">
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