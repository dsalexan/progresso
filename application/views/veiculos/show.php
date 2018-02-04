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
                                        COISA
                                    </div>
                                </div>
                                <div class="ui slide masked reveal image">
                                    <img src="<?= base_url('assets/img/veiculos/'.$veiculo['id_veiculo'].'/'.$veiculo['imagens'][0]['url_imagem']) ?>" class="visible content">
                                    <img src="<?= base_url('assets/img/veiculos/'.$veiculo['id_veiculo'].'/'.$veiculo['imagens'][1]['url_imagem']) ?>" class="hidden content">
                                </div>
                                <div class="content">
                                    <?php if($veiculo['estado'] == 'Novo'): ?>
                                    <div class="ui red ribbon label colapsed-hidden"><?= $veiculo['estado']; ?></div>
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