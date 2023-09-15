<?php

    require 'core/init.php';

    if (isset($_SESSION['user']) && isset($_SESSION['user-id'])) {

        $user_data = $user_obj->findByiD($_SESSION['user-id']);

        if ($user_data ===  false) {

            header('Location: logout.php');
            exit;

        }

    } else {

        header('Location: logout.php');
        exit;

    }

?>

<!DOCTYPE html>

    <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo  $user_data->pseudo; ?></title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link href="https://cdn.jsdelivr.net/gh/yesiamrocks/cssanimation.io@1.0.3/cssanimation.min.css" rel="stylesheet">
            <link rel="stylesheet" href="css/landing.css">
        </head>

        <body>

            <?php
                include 'nav.php';
            ?>

            <main>

                <h2 class="h2Landing"><?= "Bienvenue " . $user_data->pseudo . " !"; ?></h2>
                
                <div class="containerLogo cssanimation hu__hu__">
                    <img id="logo" src="img/rocket.png" alt="">
                </div>

            </main>

        </body>

    </html>