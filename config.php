<?php
    ini_set("display_errors",0);error_reporting(0);

    define ('WEB_TITLE', 'Banque d\'images');
    define ('WEB_TITLE_ADMIN', 'Modifier ou suprimer des images');
    define ('WEB_DIR_NAME', 'projet_image');
    define ('WEB_DIR_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/'. WEB_DIR_NAME .'/');
    define ('IMAGE_DIR_NAME', 'images');
    define('IMAGE_THUMB_NAME', 'thumbnails');
    define ('IMAGE_DIR_PATH', $_SERVER['DOCUMENT_ROOT'] . '/' . WEB_DIR_NAME .'/'. IMAGE_DIR_NAME .'/');
    define ('IMAGE_DIR_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/'. WEB_DIR_NAME .'/'. IMAGE_DIR_NAME . '/');
    define('THUMB_DIR_PATH', $_SERVER['DOCUMENT_ROOT'] . '/' . WEB_DIR_NAME .'/'. IMAGE_DIR_NAME .'/'. IMAGE_THUMB_NAME .'/');
    define('THUMB_DIR_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/'. WEB_DIR_NAME .'/'. IMAGE_DIR_NAME . '/'. IMAGE_THUMB_NAME . '/');

    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', '/Applications/XAMPP/htdocs/projet_image/log_error_php.txt');
?>
