<style>
    .menu
    {
        float: right;
        margin-right: 400px;
        font-size: 20px;
        padding-right: 20px;
        margin-top: 105px;

    }
    li
    {
        list-style: none;
    }
    .li-menu
    {
        border-bottom: 1px solid #0747d0;
    }
    a
    {
        color: #0747d0;
        text-decoration: none;
        line-height: 30px;
    }
    a:hover
    {
        color: #673ab7;
    }
</style>

<?php
    require('../process/process_display_menu.php');
?>

<ul class="menu">
    <?php echo $menu_html ?>
    <li class="li-menu"><a href="../page.php">Site web</a></li>
    <li class="li-menu"><a href="upload.php">Ajouter des images</a></li>
    <li class="li-menu"><a href="admin.php">Modifier ou suprimer des images</a></li>
    <li class="li-menu"><a href="logout.php">Déconnexion</a></li>
</ul>
