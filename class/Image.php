<?php
    class Image
    {
        public function __construct()
        {
        }

        public function getImages($image_dir)
        {
            $i=0;
            if ($handle = opendir($image_dir))
            {
                while (false !== ($entry = readdir($handle)))
                {
                    if ($entry != "." && $entry != ".." && $entry != ".DS_Store" && $entry != "thumbnails")
                    {
                        $i++;
                        $images[$i]['filename'] = $entry;
                        $image_data = $this->getImageData($entry);
                        $images[$i]['title'] = $image_data['title'] ;
                        $images[$i]['description'] = $image_data['description'];
                    }
                }
            }
            closedir($handle);
            return $images ;
        }

        public function insertImage($title, $filename)
        {
            $mysqli = new mysqli('localhost', 'root', '', 'projet_image');
            $mysqli->set_charset("utf8");
            if($mysqli->connect_errno)
            {
                echo 'Echec de la connexion ' .$mysqli->connect_error ;
                exit();
            }
            if(!$mysqli->query('INSERT INTO image (title, description, filename) VALUES ("'. $title .'", "'. $descr .'", "'. $filename .'")'))
            {
                echo 'Une erreur est survenue lors de l\'insertion des données dans la base. Message d\'erreur : ' . $mysqli->error ;
                return false;
            }
            else
            {
                return true;
            }
            $mysqli->close();
        }

        public function getImageData($filename)
        {
            $mysqli = new mysqli('localhost', 'root', '', 'projet_image');
            $mysqli->set_charset("utf8");
            if ($mysqli->connect_errno)
            {
                printf("Echec de la connexion: %s\n", $mysqli->connect_error);
                exit();
            }
            $result = $mysqli->query('SELECT id, title, description, filename FROM image WHERE filename = "' . $filename .'"');
            if (!$result)
            {
                echo 'Une erreur est survenue lors de la récupération des données dans la base. Message d\'erreur : ' . $mysqli->error;
                return false;
            }
            else
            {
                $row = $result->fetch_array();
                $image_data['id'] = $row['id'];
                $image_data['title'] = $row['title'];
                $image_data['description'] = $row['description'];
                $image_data['filename'] = $row['filename'];
                return $image_data;
            }
            $mysqli->close();
        }

        public function updateImageData ($title, $descr, $filename)
        {
            $mysqli = new mysqli('localhost', 'root', '', 'projet_image');
            if ($mysqli->connect_errno)
            {
                echo 'Echec de la connexion ' . $mysqli->connect_error;
                exit();
            }
            if(!$mysqli->query('UPDATE image SET title = "'. $title .'", description = "'. $descr .'" WHERE filename = "'. $filename .'"'))
            {
                $msg_error = 'Une erreur est survenue lors de la mise à jour des données dans la base. Message d\'erreur : ' .$mysqli->error;
                return $msg_error;
            }
            else
            {
                return true;
            }
            $mysqli->close();
        }

        public function upload ($files)
        {
            $upload_dir = IMAGE_DIR_PATH;
            foreach ($files['upload']['error'] as $key => $error)
            {
                $error = 0;
                if ($error == UPLOAD_ERR_OK)
                {
                    $tmp_name = $files['upload']['tmp_name'][$key];
                    $filename = $files['upload']['name'][$key];
                    $filename = $this->cleanText($filename);
                    $type = $files['upload']['type'][$key];
                    $size = $files['upload']['size'][$key];
                    if(($type == 'image/jpeg') AND ($size <= 1000000))
                    {
                        if(move_uploaded_file($tmp_name, $upload_dir .$filename) == false)
                        {
                        $error++ ;
                        }
                        else
                        {
                            $this->createThumbnail($filename);
                        }
                    }
                    else
                    {
                        $error++ ;
                    }
                }
                if($error == 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        public function createThumbnail($filename)
        {
            $image = IMAGE_DIR_PATH .$filename;
            $vignette = THUMB_DIR_PATH .$filename;

            $size = getimagesize($image);
            $largeur = $size[0];
            $hauteur = $size[1];

            $largeur_max = 200;
            $hauteur_max = 200;

            $image_src = imagecreatefromjpeg($image);

            if(($largeur > $largeur_max) OR ($hauteur > $hauteur_max))
            {
                if($hauteur <= $largeur)
                {
                    $ratio = $largeur_max / $largeur;
                }
                else
                {
                    $ratio = $hauteur_max / $hauteur;
                }
            }
            else
            {
            $ratio = 1;
            }

            $image_destination = imagecreatetruecolor(round($largeur * $ratio), round($hauteur * $ratio));
            imagecopyresampled($image_destination, $image_src, 0, 0, 0, 0, round($largeur * $ratio), round($hauteur * $ratio), $largeur, $hauteur);
            if(!imagejpeg($image_destination, $vignette))
            {
                $error_msg = 'la création de la vignette a échouée pour l\'image'. $image;
                return $error_msg;
                exit;
            }
            else
            {
                return true;
            }
        }

        public function cleanText($filename)
        {
            $filename = utf8_encode($filename);
            $filename = strtolower($filename);
            $special = array(' ', '\'', 'á', 'à', 'â', 'ä', 'ã', 'å', 'ç', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î', 'ï', 'ñ', 'ó', 'ò', 'ô', 'ö', 'õ', 'ú', 'ù', 'û', 'ü', 'ý', 'ÿ', 'Á', 'À', 'Â', 'Ä', 'Ã', 'Å', 'Ç', 'É','È', 'Ê', 'Ë', 'Í', 'Ì', 'Î', 'Ï', 'Ñ', 'Ó', 'Ò', 'Ô', 'Ö', 'Õ', 'Ú', 'Ù', 'Û', 'Ü', 'Ý');
            $normal = array('_', '', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y');
            $result = str_replace($special, $normal, $filename);
            return $result;
        }

        public function deleteImage($filename)
        {
            $path_images = IMAGE_DIR_PATH . $filename;
            $path_thumbs = THUMB_DIR_PATH . $filename;
            if(file_exists($path_images))
            {
                if(!unlink($path_images))
                {
                    $msg_error[] = 'Une erreur est survenue lors de la supression du fichier image';
                }
            }
            else
            {
                echo $path_images;
                $msg_error[] = 'Le fichier image n\'existe pas';
            }
            if(file_exists($path_thumbs))
            {
                if(!unlink($path_thumbs))
                {
                    $msg_error[] = 'Une erreur est survenue lors de la supression du fichier vignette';
                }
            }
            else
            {
                $msg_error[] = 'Le fichier vignette n\'existe pas';
            }

            $mysqli = new mysqli('localhost', 'root', '', 'projet_image');
            if($mysqli->connect_errno)
            {
                echo 'Echec de la connexion' . $mysqli->connect_error;
                exit();
            }

            if(!$mysqli->query('DELETE FROM image WHERE filename = " ' . $filename . '"'))
            {
                $msg_error[] = 'Une erreur est survenue lors de la supression des données dans la base. <br /> Le message d\'erreur de MySQL est : ' .$mysqli->error;
            }
            if(isset($msg_error))
            {
                $msg_error = implode(' ', $msg_error);
                return $msg_error;
            }
            else
            {
                return true;
            }
        }
    }
?>
