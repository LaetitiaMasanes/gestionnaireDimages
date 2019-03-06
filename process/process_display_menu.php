<?php
    require_once('../class/User.php');

    $user = new User();
    $menu_items = $user->display_Menu($_SESSION['user_role']);
    $menu_html = '';
    foreach ($menu_items as $id => $menu_items)
    {
        $name = $menu_items['name'];
        $slug = $menu_items['slug'];
        $menu_html .= '<li><a href=" '. $slug .'.php">'. $name .'</a></li>' . "\n";
    }
?>
