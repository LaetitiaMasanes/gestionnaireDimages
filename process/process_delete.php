<?php
    require('../config.php');
    require_once('../class/Image.php');

    if(isset($_GET['delete']))
    {
        $filename = $_GET['delete'];
        $image = new Image();
        $deleteImage = $image->deleteImage($filename);
        if(true === $deleteImage)
        {
            $msg_sucess = 'Le fichier a bien été suprimé.';
            echo '<p class="msg_sucess">'.$msg_sucess. '</p>';
            echo '<a href="../admin/admin.php">retour</a>';
        }
        else
        {
            $msg_error = $deleteImage;
            echo '<p class="msg_error">'.$msg_error. '</p>';
            echo '<a href="../admin/admin.php">retour</a>';
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
