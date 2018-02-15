<div class="bg-3" style="overflow: visible;">
    <header class="color-inher">
        <div class="menu-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-lg-3" style="padding-left: 0">
                        <div class="wrapper" style="width: 225px">
                            <img class="ui small image" style="width: 225px;; display: inline-block; float: left;" src="<?=base_url('assets/img/logo.jpg');?>"></img>
                        </div>  
                    </div>
                    <div class="col-md-9 col-lg-9">
                        <div class="main-menu">
                            <div class="container">
                                <nav class="navbar navbar-default menu">
                                    <div class="container1-fluid">
                                        <div class="navbar-collapse">
                                            <ul class="nav navbar-nav" style="max-height: 470px; flex-direction: initial;">
                                                <li><a href="<?= base_url(); ?>">Home</a></li>
                                                <li><a href="<?= base_url('carros'); ?>">Carros</a></li>
                                                <li><a href="<?= base_url('motos'); ?>">Motos</a></li>
                                                <li><a href="<?= base_url('contato'); ?>">Contato</a></li>
                                                <li><a href="<?= base_url('admin'); ?>">Admin</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                                <div class="search-box">
                                    <i class="fa fa-search"></i>
                                    <form action="<?= base_url('veiculos/search'); ?>" method="get">
                                        <input type="text" name="q" placeholder="Procurar" class="search-txt form-item">
                                        <button type="submit" class="search-btn btn-1"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>