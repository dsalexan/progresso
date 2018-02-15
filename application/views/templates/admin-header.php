
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?= base_url(); ?>">Progresso Veículos</a>
    <div id="searcher" class="ui fluid category search" style="width: 100%">
        <div class="ui left icon input" style="width: 100%">
            <input class="dark-prompt prompt form-control form-control-dark w-100" type="text" placeholder="Procurar" aria-label="Procurar">
            <i class="search icon" style="color: #EEE"></i>
        </div>
        <div class="results"></div>
    </div>
    <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
        <a id="logout" class="nav-link" href="<?= base_url('admin/logout') ?>" >Sair</a>
    </li>
    </ul>
</nav>

<div id="logout-confirmation" class="ui modal mini" style="bottom: auto">
  <div class="header">Confirmação</div>
  <div class="content">
    <p>Tem certeza que deseja sair?</p>
  </div>
  <div class="actions">
    <div class="ui negative button">Não</div>
    <a class="ui positive button" href="<?= base_url('admin/logout') ?>">Sim</a>
  </div>
</div>


<div class="container-fluid">
    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
        <ul class="nav flex-column" id="header-navbar">
            <li class="nav-item">
            <a class="nav-link active" data-page="home" href="<?= base_url('admin/') ?>">
                <i class="home icon"></i>
                Dashboard <span class="sr-only">(current)</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-page="usuarios" href="<?= base_url('admin/usuarios') ?>">
                <i class="user icon"></i>
                Usuários
            </a>
            </li>
            <!-- <li class="nav-item">
            <a class="nav-link" data-page="textos" href="<?= base_url('admin/') ?>">
                <i class="align left icon"></i>
                Textos
            </a>
            </li> -->
            <li class="nav-item">
            <a class="nav-link" data-page="veiculos" href="<?= base_url('admin/veiculos') ?>">
                <i class="car icon"></i>
                Veículos
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-page="configuracoes" href="<?= base_url('admin/configuracoes') ?>">
                <i class="settings icon"></i>
                Configurações
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" data-page="estatisticas" href="<?= base_url('admin/') ?>">
                <i class="line chart icon"></i>
                Estatísticas
            </a>
            </li>
        </ul>

        </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">