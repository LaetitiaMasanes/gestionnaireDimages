<?php
    require('../config.php');
    require('../class/Image.php');
    require('menu.php');
    require('../process/process_image.php');
    require('../process/process_delete.php');
    require('../process/process_permission.php');

    $image = new Image();
    $images = $image->getImages(IMAGE_DIR_PATH);
?>

<h1><?php echo WEB_TITLE_ADMIN ?></h1>
<ul>
    <?php if(isset($_GET['erreur'])):?>
        <?php echo $msg_error ?>
    <?php endif ?>
    <?php foreach ($images as $image): ?>
        <li>
            <img src="<?php echo THUMB_DIR_URL . $image['filename'] ?>" />
            <form method="post" action="../process/process_image.php">
                <p>Titre : <input type="text" name="title" value="<?php echo $image['title'] ?>"/></p>
                <input type="hidden" name="filename" value="<?php echo $image['filename'] ?>" />
                <p>Description<br> <textarea name="descr" cols="50" rows="5"><?php echo $image['description'] ?></textarea></p>
                <?php if(!empty($image['title'])): ?>
                    <input type="hidden" name="update" value="1" />
                <?php endif ?>
                <p><input type="submit" name="formImageSubmit" value="validez" /></p>
            </form>
            <form method="get" action="../process/process_delete.php">
                <p>suprimer : <input type="submit" name="delete" value="<?php echo $image['filename']?>" /></p>
            </form>
        </li>
    <?php endforeach ?>
</ul>
