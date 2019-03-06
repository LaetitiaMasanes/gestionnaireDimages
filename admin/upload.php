
<?php
    require('../config.php');
    require('../class/Image.php');
    require('menu.php');
    require('../process/process_permission.php');

    if(!empty($_FILES))
    {
        $image = new Image();
        $images = $image->upload($_FILES);
        if($images === true)
        {
            $msg_sucess = 'Le chargement a réussi';
        }
        else
        {
            $msg_error = 'Le chargement a échoué';
        }
    }
?>

<style>
    .msg_sucess
    {
        background-color: #8bc34a;
        border: 1px solid #2c6b2b;
        padding: 10px;
    }
    .msg_error
    {
        background-color: #e66969;
        border: 1px solid #e20808;
        padding: 10px;
    }
</style>

<h1>Upload</h1>
<?php if(isset($msg_sucess)) : ?>
    <p class="msg_sucess"><?php echo $msg_sucess ?></p>
<?php endif ?>
<?php if(isset($msg_error)) : ?>
    <p class="msg_error"><?php echo $msg_error ?></p>
<?php endif ?>

<form id="uploadForm" action="" method="post" enctype="multipart/form-data">
    <p>Ajoutez des images</p>
    <input type="file" value="" name="upload[]" multiple="multiple" />
    <input id="uploadFormSubmit" name="uploadFormSubmit" type="submit" />
</form>
