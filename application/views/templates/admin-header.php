
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
        <ul class="nav flex-column">
            <li class="nav-item">
            <a class="nav-link active" href="#">
                <span data-feather="home"></span>
                Dashboard <span class="sr-only">(current)</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="file"></span>
                Orders
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="shopping-cart"></span>
                Products
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="users"></span>
                Customers
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="bar-chart-2"></span>
                Reports
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="layers"></span>
                Integrations
            </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Saved reports</span>
            <a class="d-flex align-items-center text-muted" href="#">
            <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Current month
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Last quarter
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Social engagement
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Year-end sale
            </a>
            </li>
        </ul>
        </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">