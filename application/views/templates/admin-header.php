
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?= base_url(); ?>">Progresso Veículos</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Procurar" aria-label="Procurar">
    <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
        <a id="logout" class="nav-link" href="<?= base_url('admin/logout') ?>" >Sair</a>
    </li>
    </ul>
</nav>

<div id="logout-confirmation" class="ui modal mini">
  <div class="header">Confirmação</div>
  <div class="content">
    <p>Tem certeza que deseja sair?</p>
  </div>
  <div class="actions">
    <div class="ui approve button">Sim</div>
    <div class="ui cancel button">Não</div>
  </div>
</div>