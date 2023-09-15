<?php
        if (isset($_POST["email"]) && isset($_POST["password"]) && $_POST["email"] != "" && $_POST["password"] != "") {
            
            require_once "core/user.class.php";

            $email = $_POST["email"];
            $password = $_POST["password"];
            $email = trim($email);
            $email = strtolower($email); // email transformé en minuscule
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $currentUser = User::login($email, $password);

                if ($currentUser->id > 0) {
                    
                    $_SESSION["user-id"] = $currentUser->id;
                    $_SESSION["user"] = $currentUser->token;

                    // L'utilisateur est connecté...

                    $db_obj = new Database();
                    $db_connection = $db_obj->dbConnection();
                    $user_id = $_SESSION["user-id"];
                    
                    header('Location: landing.php?page=home');

                } else {

                    header('Location: index.php?err=password');

                } 

            } else {

                header('Location: index.php?err=email');

            }
        }
    ?>