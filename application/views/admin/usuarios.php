<div class="ui secondary pointing menu" >
  <a class="item active" data-tab="list">Listar Todos</a>
  <a class="item " data-tab="insert">Cadastrar</a>
  <a class="item" data-tab="update">Modificar</a>
</div>
<div class="ui tab segment active" data-tab="list">

    <div id="user_table" class="ui basic segment dimmable dimmed">
            
        <!-- <div class="ui active inverted dimmer">
            <div class="ui text loader">Acessando Banco de Dados</div>
        </div> -->

        <div id="toolbar" class="btn-group">
            <button id="remove" type="button" class="btn btn-default has-popup" data-inverted="" data-position="bottom left" data-tooltip="Remover usuários selecionados">
                <i class="ui icon trash"></i>
            </button>
            <button type="button" class="btn btn-default has-popup selective primary" data-inverted="" data-position="bottom left" data-tooltip="Mostrar/Esconder usuários removidos">
                <i class="ui icon unhide primary"></i>
                <i class="ui icon hide secondary"></i>
            </button>
        </div>
        <table 
            id="table"
            data-show-refresh="true"
            data-toolbar="#toolbar"
            
            data-toggle="table"
            data-pagination="true"
            data-search="true"
            data-url="<?= base_url('admin/user/list'); ?>"
            data-url-primary="<?= base_url('admin/user/list'); ?>"
            data-url-secondary="<?= base_url('admin/user/list-all'); ?>">
            <thead>
            <tr>
                <th data-field="state" data-checkbox="true"></th>
                <th data-field="id_usuario" data-sortable="true">ID</th>
                <th data-field="nome" data-sortable="true">Nome/Razão Social</th>
                <th data-field="username" data-sortable="true">Usuário</th>
                <th data-field="nivel" data-sortable="true">Nível de Acesso</th>
                <th data-field="status" data-sortable="true">Status</th>
                <th data-field="operate" data-formatter="updateFormatter" data-events="updateEvents">Ação</th>
            </tr>
            </thead>
        </table>

    </div>    
</div>

<div class="ui tab segment " data-tab="insert">
    
    <form id="insert_form" class="ui form" url="<?php echo base_url('admin/user/insert');?>" method="post" enctype="multipart/form-data">

    <div class="ui centered grid">
        <div class="message_spot row hide">
            <div class="sixteen wide column">
            </div>    
        </div>

        <div class="eight wide column">
            

            <div class="field">
            <label>Nome/Razão Social</label>
            <div class="ui labeled input">
                <label for="name" class="ui label"><i class="id card icon"></i></label>
                
                <input type="text" name="name" placeholder="Nome/Razão Social">
            </div>
            </div>

            <div class="field">
                <label>E-mail</label>
                <div class="ui labeled input">
                    <label for="email" class="ui label"><i class="mail icon"></i></label>
                    
                    <input type="text"  name="email" placeholder="E-mail">
                </div>
            </div>

            <div class="field">
                <label>Nome de Usuário</label>
                <div class="ui labeled input">
                    <label for="username" class="ui label"><i class="user icon"></i></label>
                    
                    <input type="text"  name="username" placeholder="Usuário">
                </div>
            </div>

            <div class="field">
                <label>Senha</label>
                <div class="ui labeled input">
                    <label for="password" class="ui label"><i class="lock icon"></i></label>
                    
                    <input type="password"  name="password" placeholder="Senha">
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
                    <input type="radio" name="nivel" value='1'>
                    <label>Administrador</label>
                </div>
                </div>
                <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" value="2" name="nivel">
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
                            <input type="checkbox" name="permissions[]" value="principal" checked="checked">
                            <label>Principal</label>
                        </div>
                        </div>

                        <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="permissions[]" value="usuarios">
                            <label>Usuários</label>
                        </div>
                        </div>

                        <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="permissions[]" value="textos">
                            <label>Textos</label>
                        </div>
                        </div>

                        <div class="field">
                        <div class="ui checkbox checked">
                            <input type="checkbox" name="permissions[]" value="veiculos">
                            <label>Veiculos</label>
                        </div>
                        </div>
                    </div>

                    <div class="inline fields">
                        <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="permissions[]" value="configuracoes">
                            <label>Configurações</label>
                        </div>
                        </div>

                        <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="permissions[]" value="estatisticas">
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
            <div class="sixteen wide column">
                <div class="fluid ui submit button"  tabindex="0">Cadastrar</div>
            </div>    
        </div>

    </div>

    </form>

</div>

<div class="ui tab segment" data-tab="update">
    
    <form id="update_form" class="ui form" url="<?php echo base_url('admin/user/update');?>" enctype="multipart/form-data">

    <div class="ui centered grid">

        <div class="eight wide column">
            

            <div class="field">
            <label>Nome/Razão Social</label>
            <div class="ui labeled input">
                <label for="name" class="ui label"><i class="id card icon"></i></label>
                
                <input type="text" name="name" placeholder="Nome/Razão Social">
            </div>
            </div>

            <div class="field">
                <label>E-mail</label>
                <div class="ui labeled input">
                    <label for="email" class="ui label"><i class="mail icon"></i></label>
                    
                    <input type="text"  name="email" placeholder="E-mail">
                </div>
            </div>

            <div class="field">
                <label>Nome de Usuário</label>
                <div class="ui labeled input">
                    <label for="username" class="ui label"><i class="user icon"></i></label>
                    
                    <input type="text"  name="username" placeholder="Usuário">
                </div>
            </div>

            <div class="field">
                <label>Senha</label>
                <div class="ui labeled input">
                    <label for="password" class="ui label"><i class="lock icon"></i></label>
                    
                    <input type="password"  name="password" placeholder="Senha">
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
                    <input type="radio" name="nivel" value='1'>
                    <label>Administrador</label>
                </div>
                </div>
                <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" value="2" name="nivel">
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
                            <input type="checkbox" name="permissions[]" value="principal" checked="checked">
                            <label>Principal</label>
                        </div>
                        </div>

                        <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="permissions[]" value="usuarios">
                            <label>Usuários</label>
                        </div>
                        </div>

                        <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="permissions[]" value="textos">
                            <label>Textos</label>
                        </div>
                        </div>

                        <div class="field">
                        <div class="ui checkbox checked">
                            <input type="checkbox" name="permissions[]" value="veiculos">
                            <label>Veiculos</label>
                        </div>
                        </div>
                    </div>

                    <div class="inline fields">
                        <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="permissions[]" value="configuracoes">
                            <label>Configurações</label>
                        </div>
                        </div>

                        <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="permissions[]" value="estatisticas">
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
                <div class="fluid ui submit button"  tabindex="0">Modificar</div>
            </div>    
        </div>

    </div>

    </form>

</div>
<script>
    var options = {
        <?php foreach($options as $key => $value){ ?>
            "<?=$key?>": "<?=$value?>",
        <?php } ?>
    };
</script>