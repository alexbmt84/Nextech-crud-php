<!DOCTYPE html>

    <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Register</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="css/main.css">
        </head>

        <body>

            <?php
                require 'core/errors.php';
            ?>

            <div class="containerLogo">
                <img id="logo" src="img/rocket.png" alt="">
            </div>


            <form action="register_conf.php" method="post" class="loginForm2">

                <input class="text-input1" type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required>
                <input class="text-input3" type="text" id="email" name="email" placeholder="Email" required>
                <input class="text-input3" type="password" id="password" name="password" placeholder="Password" required>
                <input class="text-input3" type="password" id="confirm_password" name="password_retype" placeholder="Confirm password" required>
                
                <nav>

                    <ul>

                        <button type="submit" class="invisibleBtn">

                            <li>
                                sign up
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>   
                            </li>
                            
                        </button>
                        
                        <br>

                        <button class="invisibleBtn" onclick="window.location.href='index.php';">

                            <li>
                                back
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