<div class="body" style="text-align: center">
<div class="login-container">
    <form class="ui form" action="<?php echo base_url('admin/validate');?>" method='post' enctype="multipart/form-data">

    <?php if($this->session->flashdata('logout_successful')): ?>
    <div class="field">
        <div class="ui info message small">
            <p><?= $this->session->flashdata('logout_successful');?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('invalid_credentials')): ?>
    <div class="field">
        <div class="ui negative message small">
            <p><?= $this->session->flashdata('invalid_credentials');?></p>
        </div>
    </div>
    <?php endif; ?>

    <div class="field">
        <label>Usuário</label>
        <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username_login" placeholder="Usuário">
          </div>
    </div>

    <div class="field">
        <label>Senha</label>
        <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password_login" placeholder="Senha">
        </div>
    </div>
    <div class="fluid ui submit button"  tabindex="0">Entrar</div>
    <div class="ui error message"></div>
    </form>

</div>
</div>