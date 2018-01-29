<div class="body" style="text-align: center">
<div class="login-container">
    <form class="ui form" action="<?php echo base_url('admin/validate');?>" method='post' enctype="multipart/form-data">

    <?php if($this->session->flashdata('invalid_credentials')): ?>
    <div class="field">
        <div class="ui negative message small">
            <p><?= $this->session->flashdata('invalid_credentials');?></p>
        </div>
    </div>
<?php endif; ?>

    <div class="field">
        <label>Usuário</label>
        <input type="text" name="username" placeholder="Usuário">
    </div>

    <div class="field">
        <label>Senha</label>
        <input type="password" name="password" placeholder="Senha">
    </div>
    <div class="fluid ui submit button">Entrar</div>
    <div class="ui error message"></div>
    </form>

</div>
</div>