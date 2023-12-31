<?php 

require 'core/database.class.php';

    // Si les variables existent et qu'elles ne sont pas vides
    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_retype'])) {
        
        // Patch XSS
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);

        // On vérifie si l'utilisateur existe
        $connexion = new PDO("mysql: host=localhost; port=3306; dbname=exophp; charset=utf8", "root", "A12z09eR");
        $check = $connexion->prepare('SELECT pseudo, email, password FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        $email = strtolower($email); // on transforme toute les lettres majuscule en minuscule pour éviter que Foo@gmail.com et foo@gmail.com soient deux compte différents ..
        
        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        if($row == 0){ 

            if(strlen($pseudo) <= 100){ // On verifie que la longueur du pseudo <= 100
               
                if(strlen($email) <= 100){ // On verifie que la longueur du mail <= 100
                    
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // Si l'email est de la bonne forme
                        
                        if($password === $password_retype){ // si les deux mdp saisis sont bon

                            // On hash le mot de passe avec Bcrypt, via un coût de 12
                            $cost = ['cost' => 12];
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                            
                            // On stock l'adresse IP
                            $ip = $_SERVER['REMOTE_ADDR']; 

                            // On insère dans la base de données
                            $insert = $connexion->prepare('INSERT INTO utilisateurs(pseudo, email, password, token) VALUES(:pseudo, :email, :password, :token)');
                            $insert->execute(array(
                                'pseudo' => $pseudo,
                                'email' => $email,
                                'password' => $password,
                                'token' => bin2hex(openssl_random_pseudo_bytes(64)),
                            ));

                            // On redirige avec le message de succès
                            header('Location: profile.php');

                        }else{ 

                            header('Location: register.php?err=confirmation'); 
                            die();

                        }

                    }else{ 

                        header('Location: register.php?err=email');
                        die();

                    }

                }else{ 

                    header('Location: register.php?err=already');
                    die();

                }

            }else{ 

                header('Location: register.php?err=already');
                die();

            }

        }else{ 

            header('Location: register.php?err=already');
            die();

        }
        
    }