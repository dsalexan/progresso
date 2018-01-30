<html>
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />-->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="ECTM Jr">
        <link rel="icon" href="../../../../favicon.ico">
        
        <title>Título do Site</title>

        <!-- LOADING SPECIFIC ASSETS -->

        <?php if(isset($bootstrap)): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/bootstrap.min.css'); ?>">
        <?php endif ?>
        
        <?php if(isset($semantic)): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/semantic/semantic.min.css'); ?>">
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

        <script>
            function base_url(url = ''){
                var base = "<?= base_url(); ?>";

                return base + url;
            }
        </script>
    </head>
    <body>