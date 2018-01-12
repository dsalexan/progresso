<html>
    <head>
        <title>Título do Site | Painel de Administração</title>
    </head>

    <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js')?>" type="text/javascript"></script>
    <link href="<?php echo base_url('assets/css/bootswatch-sandstone.css') ?>" rel="stylesheet" type="text/css" />
    <body>

        <div class="container">
        <!-- Flash messages -->
        <?php if($this->session->flashdata('forbidden_access')): ?>
        <?php echo '<p class="alert alert-warning">'.$this->session->flashdata('forbidden_access').'</p>'; ?>
        <?php endif; ?>

        </div>