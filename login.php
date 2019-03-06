<?php
    require('config.php');
    require('process/process_auth.php');
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Connexion</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>
        <h1>Connexion</h1>
        <div id="main">
            <?php if(isset($msg_error)) : ?>
                <p class="msg_error"><?php echo $msg_error ?></p>
            <?php endif ?>
            <form action="" method="post">
                <p>Login : <br/><input type="text" name="login" /></p>
                <p>Password : <br/><input type="password" name="password" /></p>
                <input type="submit" name="submitLoginForm"/>
            </form>
        </div>
    </body>
<html>
