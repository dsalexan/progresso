<div class="bg-3" style="overflow: visible;">
    <header class="color-inher">
        <div class="menu-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-lg-3 nav-logo" style="padding-left: 0">
                        <div class="wrapper" style="">
                            <img class="ui small image" style="display: inline-block; float: left;" src="<?=base_url('assets/img/logo.jpg');?>"></img>
                        </div>  
                    </div>
                    <div class="col-md-9 col-lg-9 full-width-mobile">
                        <div class="main-menu">
                            <div class="container bootstrap4">

                                <nav class="navbar navbar-expand-lg">
                                    <div class="button-collapse">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                            <i class="sidebar icon"></i>
                                        </button>
                                    </div>

                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav mr-auto">
                                            <li class="nav-item active">
                                                <a class="nav-link" href="<?= base_url(); ?>">Home <span class="sr-only">(current)</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= base_url('carros'); ?>">Carros</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= base_url('motos'); ?>">Motos</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= base_url('contato'); ?>">Contato</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?= base_url('admin'); ?>">Admin</a>
                                            </li>
                                        </ul>
                                        <form class="search-box form-inline my-2 my-lg-0" action="<?= base_url('veiculos/search'); ?>" method="get">
                                            <input type="text" name="q" placeholder="Procurar" class="search-txt form-item">
                                            <button type="submit" class="search-btn btn-1"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                </nav>


                                <!-- <nav class="navbar navbar-default menu">
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
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>