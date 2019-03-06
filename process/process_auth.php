<?php
    require('class/User.php');
    if(isset($_POST['submitLoginForm']))
    {
        if( (isset($_POST['login'])) AND (isset($_POST['password'])) )
        {
            $user_login = trim($_POST['login']);
            $user_pass = trim($_POST['password']);

            $user = new User();

            $login_lenght_control = $user->lenght_control($user_login, 10);
            $passw_lenght_control = $user->lenght_control($user_pass, 32);
            if( ($login_lenght_control === false) OR ($passw_lenght_control === false) )
            {
                $msg_error = '(longeur) Le compte n\'est pas reconnu';
            }
            else
            {
                $login_authorized = $user->login_authorized($user_login);
                $password_authorized = $user->password_authorized($user_pass);
                if( ($login_authorized === false) OR ($password_authorized === false))
                {
                    $msg_error = '(valeur des caractère) Le compte n\'est pas reconnu';
                }
                else
                {
                    $authUser = $user->authUser($user_login, $user_pass);
                    if($authUser['count']==0)
                    {
                        $msg_error = 'Le compte n\'est pas reconnu';
                    }
                    else
                    {
                        session_start();
                        header('location:admin/admin.php');
                        exit;
                    }
                }
            }
        }
        else
        {
            $msg_error = 'Votre saisie ne semble pas valide. Merci de recommencer';
        }
    }
?>
