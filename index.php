<?php
    require_once 'core/init.php';
?>

<!DOCTYPE html>

<html lang="fr">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    
    <body>
        
            <?php
                require 'core/errors.php'; 
                require './login.php'; 
            ?>

            <div class="containerLogo">
                <img id="logo" src="img/rocket.png" alt="">
            </div>

            <form class="loginForm" action="" method="post">

                <input class="text-input1" type="email" name="email" placeholder="Email" required>
                <input class="text-input2" type="password" name="password" placeholder="Password" required>
                
                <nav>

                    <ul>

                        <button type="submit" class="invisibleBtn">
                            <li>
                                login
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>   
                            </li>
                        </button>
                        
                        <br>

                        <button class="invisibleBtn" onclick="window.location.href='register.php';">
                            <li>
                                register
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>   
                            </li>
                        </button>

                    </ul>

                </nav>  

            </form>

        </body>

    </html>