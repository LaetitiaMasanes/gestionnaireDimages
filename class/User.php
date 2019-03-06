<?php
    class User
    {
        public function authUser($login, $password)
        {
            $mysqli = new mysqli('localhost', 'root', '', 'projet_image');
            $mysqli->set_charset("utf8");

            if($mysqli->connect_errno)
            {
                printf("Echec de la connexion: %s\n", $mysqli->connect_error);
                exit();
            }

            $login = $mysqli->real_escape_string($login);
            $password = $mysqli->real_escape_string($password);

            $salt = 'F4813N3';
            $md5_password = md5($password . $salt);
            echo $md5_password;

            $sql = 'SELECT COUNT(u.id), u.id, u.login, u.password, u.role, r.level FROM user as U INNER JOIN user_role as R ON ( login = "' . $login . '" AND password = "' . $md5_password .'" AND u.role = r.id)';
            $result = $mysqli->query($sql);

            if(!$result)
            {
                echo 'Une erreur est survenue lors de la récupération des données dans la base. Message d\'erreur de MySQL : '.$mysqli->error;
                return false;
            }
            else
            {
                $row = $result->fetch_array();
                $user_data['count'] = $row['COUNT(u.id)'];
                $user_data['id'] = $row['id'];
                $user_data['login'] = $row['login'];
                $user_data['password'] = $row['password'];
                return $user_data;
            }
            $mysqli->close();
        }

        public function lenght_control($text, $limit)
        {
            $lenght = strlen($text);
            if($lenght > $limit)
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        public function login_authorized($login)
        {
            $authorized_characters = array
            ('a','b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y', 'z', 'á', 'à', 'â', 'ä', 'ã', 'å', 'ç', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î',
            'ï', 'ñ', 'ó', 'ò', 'ô', 'ö', 'õ', 'ú', 'ù', 'û', 'ü', 'ý', 'ÿ', 'Á', 'À', 'Â', 'Ä', 'Ã', 'Å', 'Ç',
            'É', 'È', 'Ê', 'Ë', 'Í', 'Ì', 'Î', 'Ï', 'Ñ', 'Ó', 'Ò', 'Ô', 'Ö', 'Õ', 'Ú', 'Ù', 'Û', 'Ü', 'Ý', 'Ÿ',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            $login_lenght = strlen($login);
            $login_error = 0;

            for($i=0; $i < $login_lenght; $i++)
            {
                if(!in_array(strtolower($login[$i]), $authorized_characters))
                {
                    $login_error++;
                }
            }
            if($login_error > 0)
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        public function password_authorized($password)
        {
            $unauthorized_characters = array(" ' ", " '' ", "-");
            $password_lenght = strlen($password);
            $password_error = 0;
            for($i=0; $i<$password_lenght; $i++)
            {
                if(in_array(strtolower($password[$i]), $unauthorized_characters))
                {
                    $password_error++;
                }
            }
            if($password_error > 0)
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        public function display_Menu($user_role_id)
        {
            $mysqli = new mysqli('localhost', 'root', '', 'projet_image');
            $mysqli->set_charset('utf8');

            if($mysqli->connect_errno)
            {
                printf("Echec de la connexion: %s\n", $mysqli->connect_error);
                exit();
            }

            $sql = 'SELECT name, slug FROM user_action as A INNER JOIN user_permission AS P ON (A.id = P.action_id AND min_role_id <= "'.$user_role_id.'")';
            $result = $mysqli->query($sql);
            if (!$result)
            {
                echo 'Une erreur est survenue lors de la récupération des données dans la base. Message d\'erreur : ' . $mysqli->error;
                return false;
            }
            else
            {
                while($row = $result->fetch_array())
                {
                $menu_data['']= $row;
                }
                if(isset($menu_data))
                {
                    return $menu_data;
                }
                else
                {
                    return false;
                }
            }
            $mysqli->close();
        }

        public function checkUserPermission($user_role_id, $action_slug)
        {
            $mysqli = new mysqli('localhost', 'root', '', 'projet_image');
            $mysqli->set_charset('utf8');

            if($mysqli->connect_errno)
            {
                printf("Echec de la connexion: %s\n", $mysqli->connect_error);
                exit();
            }
            $sql = 'SELECT P.min_role_id, P.action_id FROM user_permission AS P INNER JOIN user_action AS A ON (A.slug = "'. $action_slug .'" AND P.action_id = A.id)';
            $result = $mysqli->query($sql);
            if (!$result)
            {
                echo 'Une erreur est survenue dans la base de données. Message d\'erreur :' . $mysqli->error;
                return false;
            }
            else
            {
                $row = $result->fetch_array();
                if ($row['min_role_id'] > $user_role_id)
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
            $mysqli->close();
        }
    }
?>
