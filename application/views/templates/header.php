<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Título do Site</title>

        <!-- LOADING JQUERY -->
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>" type="text/javascript"></script>

        <!-- LOADING SPECIFIC ASSETS -->

        <?php if(isset($bootstrap)): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/bootstrap.min.css'); ?>">
        <script src="<?php echo base_url('assets/bootstrap/bootstrap.min.js'); ?>"></script>
        <?php endif ?>
        
        <?php if(isset($semantic)): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/semantic/semantic.min.css'); ?>">
        <script src="<?php echo base_url('assets/semantic/semantic.min.js'); ?>"></script>
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
                    }elseif($folder == 'js'){
                        foreach($files as $file){
                            ?><script src="<?php echo base_url('assets/js/'.$file);   ?>" type="text/javascript"></script><?php
                        }
                    }
                }       
            }
        ?>

        <!-- LOADING GENERAL CSS/JS -->

        <link href="<?php echo base_url('assets/css/general.css'); ?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/js/general.js');   ?>" type="text/javascript"></script>
    </head>
    <body>