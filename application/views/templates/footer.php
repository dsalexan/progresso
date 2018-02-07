
<!-- LOADING JQUERY -->
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>" type="text/javascript"></script>

<!-- LOADING SPECIFIC ASSETS -->

<?php if(isset($bootstrap) or isset($bootstrap_dashboard)): ?>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<?php endif ?>

<?php if(isset($semantic)): ?>
<?php
    foreach ($semantic as $folder => $files){
        if($folder == 'js'){
            foreach($files as $file){
                ?><script src="<?php echo base_url('assets/semantic/dist/components/'.$file); ?>" type="text/javascript"></script><?php
            }
        }
    } 
?>
<?php endif ?>


<?php if(isset($fileupload)): ?>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?=base_url('assets/fileupload/vendor/jquery.ui.widget.js') ?>"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <!-- <script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script> -->
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <!-- <script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script> -->
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <!-- <script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script> -->
    <!-- blueimp Gallery script -->
    <!-- <script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script> -->
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <!-- <script src="<?=base_url('assets/fileupload/jquery.iframe-transport.js') ?>"></script> -->
    <!-- The basic File Upload plugin -->
    <script src="<?=base_url('assets/fileupload/jquery.fileupload.js') ?>"></script>
    <!-- The File Upload processing plugin -->
    <!-- <script src="<?=base_url('assets/fileupload/jquery.fileupload-process.js') ?>"></script> -->
    <!-- The File Upload image preview & resize plugin -->
    <!-- <script src="<?=base_url('assets/fileupload/jquery.fileupload-image.js') ?>"></script> -->
    <!-- The File Upload audio preview plugin -->
    <!-- <script src="<?=base_url('assets/fileupload/jquery.fileupload-audio.js') ?>"></script> -->
    <!-- The File Upload video preview plugin -->
    <!-- <script src="<?=base_url('assets/fileupload/jquery.fileupload-video.js') ?>"></script> -->
    <!-- The File Upload validation plugin -->
    <!-- <script src="<?=base_url('assets/fileupload/jquery.fileupload-validate.js') ?>"></script> -->
    <!-- The File Upload user interface plugin -->
    <!-- <script src="<?=base_url('assets/fileupload/jquery.fileupload-ui.js') ?>"></script> -->
<?php endif ?>
        
<?php if(isset($kingtable)): ?>
<!-- para melhorar o tempo de carregamento da página os modulos do kingtable são carregados a medida que são utilizados -->
<?php
    foreach ($kingtable as $folder => $files){
        if($folder == 'js'){
            foreach($files as $file){
                ?><script src="<?php echo base_url('assets/kingtable/'.$file); ?>" type="text/javascript"></script><?php
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
            if($folder == 'js'){
                foreach($files as $file){
                    ?><script src="<?php echo base_url('assets/js/'.$file);   ?>" type="text/javascript"></script><?php
                }
            }
        }       
    }
?>

<!-- LOADING GENERAL ASSETS -->
<script src="<?php echo base_url('assets/js/general.js');   ?>" type="text/javascript"></script>

</body>
</html>