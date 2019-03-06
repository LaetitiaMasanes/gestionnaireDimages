<?php
    $image = new Image();
    $images = $image->getImages(IMAGE_DIR_PATH);
?>

<h1><?php echo WEB_TITLE ?></h1>
<ul>
    <?php foreach ($images as $image): ?>
        <li>
            <img src="<?php echo THUMB_DIR_URL . $image['filename'] ?>" />
            <p><?php echo $image['title'] ?></p>
            <p><?php echo $image['description'] ?></p>
        </li>
    <?php endforeach ?>
</ul>
