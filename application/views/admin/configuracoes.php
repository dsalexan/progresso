<div class="ui secondary pointing menu" >
  <a class="item active" data-tab="update">Modificar</a>
</div>

<div class="ui tab segment active dimmed max-height70" data-tab="update">

    <div class="ui active inverted dimmer">
        <div class="ui large text loader">Acessando Banco de Dados</div>
    </div>
    
    <form id="insert_form" class="ui form" url="<?php echo base_url('admin/config/update');?>" method="post" enctype="multipart/form-data">

    <div class="ui centered stackable grid">
        <div class="message_spot row hide">
            <div class="sixteen wide column">
            </div>    
        </div>

        
        <div class="computer reversed row">
            <div class="eight wide column">
                <div class="ui error message"></div>
            </div>

            <div class="eight wide column">

                <input type="hidden" name="id">
                <div class="field">
                <label>Título do Site</label>
                <div class="ui labeled input">
                    <label for="titulo" class="ui label"><i class="id card icon"></i></label>
                    
                    <input type="text" name="titulo" placeholder="Título do Site">
                </div>
                </div>

                <div class="field">
                    <label>Url do Site</label>
                    <div class="ui labeled input">
                        <label for="url" class="ui label"><i class="mouse pointer icon"></i></label>
                        
                        <input type="text"  name="url" placeholder="Url do Site">
                    </div>
                </div>

                <div class="field">
                    <label>Logradouro</label>
                    <div class="ui labeled input">
                        <label for="logradouro" class="ui label"><i class="world icon"></i></label>
                        
                        <input type="text"  name="logradouro" placeholder="Logradouro">
                    </div>
                </div>

                <div class="field">
                    <label>Cidade</label>
                    <div class="ui labeled input">
                        <label for="cidade" class="ui label"><i class="world icon"></i></label>
                        
                        <input type="text"  name="cidade" placeholder="Cidade">
                    </div>
                </div>

                <div class="field">
                    <label>UF</label>
                    <div class="ui labeled input">
                        <label for="uf" class="ui label"><i class="world icon"></i></label>
                        
                        <input type="text"  name="uf" placeholder="UF">
                    </div>
                </div>

                <div class="field">
                    <label>Telefone</label>
                    <div class="ui labeled input">
                        <label for="telefone" class="ui label"><i class="call icon"></i></label>
                        
                        <input type="text"  name="telefone" placeholder="Telefone">
                    </div>
                </div>

                <div class="field">
                    <label>Telefone 2</label>
                    <div class="ui labeled input">
                        <label for="telefone2" class="ui label"><i class="call icon"></i></label>
                        
                        <input type="text"  name="telefone2" placeholder="Telefone 2">
                    </div>
                </div>

                <div class="field">
                    <label>E-mail</label>
                    <div class="ui labeled input">
                        <label for="email" class="ui label"><i class="mail icon"></i></label>
                        
                        <input type="text"  name="email" placeholder="E-mail">
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="sixteen wide column">
                <div class="fluid ui submit button"  tabindex="0">Salvar</div>
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