<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="ECTM Jr">
        <link rel="icon" href="<?=base_url("assets/img/icon.ico");?>">
        
        <title>Progresso Veículos</title>

        <!-- LOADING SPECIFIC ASSETS -->

        <?php if(isset($bootstrap_dashboard)): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/dashboard/bootstrap.min.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/dashboard/bootstrap-dashboard.css'); ?>">
        <?php endif ?>

        <?php if(isset($bootstrap)): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
        <?php endif ?>

        
        <?php if(isset($fileupload)): ?>
        <!-- blueimp Gallery styles -->
        <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="<?=base_url('assets/fileupload/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?=base_url('assets/fileupload/jquery.fileupload.css'); ?>">
        <link rel="stylesheet" href="<?=base_url('assets/fileupload/jquery.fileupload-ui.css'); ?>">
        <?php endif ?>
        
        <?php if(isset($semantic)): ?>
        <!-- para melhorar o tempo de carregamento da página os modulos do semantic são carregados a medida que são utilizados -->
        <?php
            foreach ($semantic as $folder => $files){
                if($folder == 'css'){
                    foreach($files as $file){
                        ?><link href="<?php echo base_url('assets/semantic/dist/components/'.$file); ?>" rel="stylesheet" type="text/css" /><?php
                    }
                }
            }   
        ?>
        <?php endif ?>
        
        <?php if(isset($kingtable)): ?>
        <!-- para melhorar o tempo de carregamento da página os modulos do kingtable são carregados a medida que são utilizados -->
        <?php
            foreach ($kingtable as $folder => $files){
                if($folder == 'css'){
                    foreach($files as $file){
                        ?><link href="<?php echo base_url('assets/kingtable/styles/'.$file); ?>" rel="stylesheet" type="text/css" /><?php
                    }
                }
            }   
        ?>
        <?php endif ?>

        <!-- LOADING PAGE ASSETS -->
        <?php 
            // dentro de assets/css e assets/js podem ter arquivos especificos pra cada página. No controlador eu especifico que arquivos eu quero carregar dessas páginas
            // e nos loops abaixo eu pego esses arquivos especificados no controlador e puxo eles
            // pra ver um exemplo é só olhar em admin/login
            if(isset($assets)){
                foreach ($assets as $folder => $files){
                    if($folder == 'css'){
                        foreach($files as $file){
                            ?><link href="<?php echo base_url('assets/css/'.$file); ?>" rel="stylesheet" type="text/css" /><?php
                        }
                    }
                }       
            }
        ?>

        <!-- LOADING GENERAL ASSETS -->

        <link href="<?php echo base_url('assets/css/general.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/bootstrap4.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/mobile.css'); ?>" rel="stylesheet" type="text/css" />

        <script>
            function base_url(url = '', type = ''){
                var base = "<?= base_url(); ?>";

                if(type=="HTTPLESS") base = base.replace('http:', '');

                return base + url;
            }
        </script>

        <script type="text/template" id="qq-template-manual-trigger">
            <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Arraste as imagens aqui">
                <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
                </div>
                <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                    <span class="qq-upload-drop-area-text-selector"></span>
                </div>
                <div class="ui buttons top attached">
                    <!-- <div class="qq-upload-button-selector qq-upload-button">
                        <div>Select files</div>s
                    </div>
                    <button type="button" id="trigger-upload" class="btn btn-primary">
                        <i class="icon-upload icon-white"></i> Upload
                    </button> -->
                    <div class="qq-upload-button-selector qq-upload-button ui button">
                        <i class="ui icon cloud upload alternate"></i>Select Files</div>
                </div>
                <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>Processando imagens...</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
                <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                    <li>
                        <div hidden class="qq-progress-bar-container-selector">
                            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                        </div>
                        <div class="ui grid" style="margin:0">
                            <div class="five wide column">
                                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                                <img class="ui bordered image fluid qq-thumbnail-selector" qq-max-size="500" qq-server-scale>
                                </br>
                                <button type="button" class="ui mini button fluid qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancelar</button>
                                <button type="button" class="no ui mini button fluid qq-btn qq-upload-delete-selector qq-upload-delete">Remover</button>
                                </br>
                                <button type="button" class="ui mini button qq-move-up"><i class="ui icon chevron up" style="margin-right: 0;"></i></button>
                                <button type="button" class="ui mini button qq-move-down"><i class="ui icon chevron down" style="margin-right: 0;"></i></button>
                                </br>
                                <button type="button" class="ui mini positive button fluid qq-btn qq-upload-retry-selector qq-upload-retry">Tentar Novamente</button>
                            </div>

                            <div class="eleven wide column">
                                <span class="qq-upload-file-selector qq-upload-file"></span>
                                <div class="ui input focus">
                                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                                </div>
                                <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Editar"></span>
                                <span class="qq-upload-size-selector qq-upload-size"></span>
                                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                            </div>
                        </div>
                    </li>
                </ul>

                <dialog class="qq-alert-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">Fechar</button>
                    </div>
                </dialog>

                <dialog class="qq-confirm-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">Não</button>
                        <button type="button" class="qq-ok-button-selector">Sim</button>
                    </div>
                </dialog>

                <dialog class="qq-prompt-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <input type="text">
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">Cancelar</button>
                        <button type="button" class="qq-ok-button-selector">Ok</button>
                    </div>
                </dialog>
            </div>
        </script>
    </head>
    <body>