<div class="ui secondary pointing menu" >
  <a class="item " data-tab="list">Listar Todos</a>
  <a class="item active" data-tab="insert">Cadastrar</a>
  <a class="item" data-tab="update">Modificar</a>
</div>
<div class="ui tab segment " data-tab="list">
</div>
<div class="ui tab segment active" data-tab="insert">
    
<form class="ui form" action="<?php echo base_url('admin/validate');?>" method='post' enctype="multipart/form-data">

<div class="ui centered grid">

    <div class="eight wide column">
        

        <div class="field">
        <label>Nome/Razão Social</label>
        <div class="ui labeled input">
            <label for="name" class="ui label"><i class="id card icon"></i></label>
            
            <input type="text" id="name" name="name" placeholder="Nome/Razão Social">
        </div>
        </div>

        <div class="field">
            <label>E-mail</label>
            <div class="ui labeled input">
                <label for="email" class="ui label"><i class="mail icon"></i></label>
                
                <input type="text" id="email" name="email" placeholder="E-mail">
            </div>
        </div>

        <div class="field">
            <label>Nome de Usuário</label>
            <div class="ui labeled input">
                <label for="username" class="ui label"><i class="user icon"></i></label>
                
                <input type="text" id="username" name="username" placeholder="Usuário">
            </div>
        </div>

        <div class="field">
            <label>Senha</label>
            <div class="ui labeled input">
                <label for="password" class="ui label"><i class="lock icon"></i></label>
                
                <input type="password" id="password" name="password" placeholder="Senha">
            </div>
        </div>

        <h4 class="ui horizontal divider header">
            <i class="database icon"></i>
            Acesso Administrativo
        </h4>

        <div class="inline fields access-level">
            <label>Nível de Acesso</label>

            <div class="field">
            <div class="ui radio checkbox">
                <input type="radio" name="administrator" value='adm'>
                <label>Administrador</label>
            </div>
            </div>
            <div class="field">
            <div class="ui radio checkbox">
                <input type="radio" value="adv" name="advanced">
                <label>Usuário Avançado</label>
            </div>
            </div>
            
        </div>

        <div class="ui grid permissions">
            <div class="three wide column">
                <label><b>Permissões</b></label>
            </div>
            
            <div class="thirteen wide column">

                <div class="inline fields">
                    <div class="field">
                    <div class="ui fixed checkbox">
                        <input type="checkbox" name="principal" checked="checked">
                        <label>Principal</label>
                    </div>
                    </div>

                    <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="usuarios">
                        <label>Usuários</label>
                    </div>
                    </div>

                    <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="textos">
                        <label>Textos</label>
                    </div>
                    </div>

                    <div class="field">
                    <div class="ui checkbox checked">
                        <input type="checkbox" name="veiculos">
                        <label>Veiculos</label>
                    </div>
                    </div>
                </div>

                <div class="inline fields">
                    <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="configuracoes">
                        <label>Configurações</label>
                    </div>
                    </div>

                    <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="estatisticas">
                        <label>Estatistísticas</label>
                    </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="eight wide column">
        <div class="ui error message"></div>
    </div>
    <div class="row">
        <div class="seven wide column">
            <div class="fluid ui submit button"  tabindex="0">Cadastrar</div>
        </div>    
    </div>

</div>

</form>

</div>
<div class="ui tab segment" data-tab="update">
  Third
</div>