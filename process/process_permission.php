<?php
    require_once('../class/User.php');
    $action_slug = substr ($filename, 0, 4);
    $mysqli = '';
    $_SESSION['user_level'] ='';
    $user = new user();
    $user_permission = $user->checkUserPermission($_SESSION['user_level'], $action_slug);
    if($user_permission === false)
    {
        echo 'Erreur. Cette page n\'existe pas.';
        ini_set('denied_log', '/Applications/XAMPP/htdocs/projet_image/denied_access_log.txt');
        exit;
    }
?>
