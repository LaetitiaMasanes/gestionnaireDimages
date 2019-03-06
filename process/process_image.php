<?php
    require_once('../config.php');
    require_once('../class/Image.php');
    ini_set('display_errors', 1);

    if(!isset($_POST['formImageSubmit']))
    {
        $error_msg = 'Aucune donnée n\'est fournie. <a href="' . WEB_DIR_URL .'admin.php">retour</a>';
    }
    if(isset($_POST['formImageSubmit']))
    {
        if( (empty($_POST['title'])) OR (empty($_POST['descr'])) OR (empty($_POST['filename'])) )
        {
            echo 'Une des informations est manquante.';
            echo '<br><a href="' . WEB_DIR_URL .'/admin/admin.php">retour</a>';
        }
        else
        {
            $title = trim ($_POST['title']);
            $descr = trim ($_POST['descr']);
            $filename = trim ($_POST['filename']);
            $image = new Image();

            if(isset($_POST['update']))
            {
                $insertImage = $image->updateImageData($title, $descr, $filename);
            }
            else
            {
                $insertImage = $image->insertImage($title, $descr, $filename);
            }

            if(true === $insertImage)
            {
                $sucess_msg = '<br><a href="' . WEB_DIR_URL .'admin/admin.php?insertImage=ok">retour</a>';
                $msg_success = 'La mise à jour des données dans la base à bien été effectué.';
                echo '<p class="msg_sucess">' .$msg_success. '</p>';
                echo $sucess_msg;
            }
            else
            {
                $error_msg = '<br><a href="' . WEB_DIR_URL .'admin/admin.php">retour</a>';
                echo '<p class="msg_error">'.$msg_error. '</p>';
                echo $error_msg;
            }
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
