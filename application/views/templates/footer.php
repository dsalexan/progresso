
<!-- LOADING JQUERY -->
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>" type="text/javascript"></script>

<!-- LOADING SPECIFIC ASSETS -->

<?php if(isset($bootstrap)): ?>
<script src="<?php echo base_url('assets/bootstrap/bootstrap.min.js'); ?>"></script>
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

<!-- LOADING PAGE ASSETS -->semantic/dist/components
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