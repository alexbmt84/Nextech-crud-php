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
            <link rel="stylesheet" href="css/landing.css">
        </head>

        <body>

            <?php
                include 'nav.php';
            ?>

            <main>

                <?php
                    require 'core/errors.php'; 
                ?>

                <h2 class="h2Landing"><?= "Bienvenue " . $user_data->pseudo . " !"; ?></h2>

                <form class="formEdit" action="./profile_edit.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="profile-pic">
                        <label for="file" class="-label">
                            <span class="glyphicon glyphicon-camera"></span>
                            <span>Change Image</span>
                        </label>
                        <input id="file" type="file" name="avatar" onchange="loadFile(event);"/>
                        <img src="membres/avatars/<?= $user_data->avatar; ?>" id="output" width="150px" />
                    </div>

                    <input class="text-input1" type="text" name="newpseudo" placeholder="<?= $user_data->pseudo; ?>">
                    <input class="text-input3" type="email" name="newmail" placeholder="<?= $user_data->email; ?>">
                    <input class="text-input3" type="text" name="firstname" placeholder="<?php if($user_data->prenom) { echo $user_data->prenom; } else { echo "First name"; }?>">
                    <input class="text-input3" type="text" name="lastname" placeholder="<?php if($user_data->nom) { echo $user_data->nom; } else { echo "Last name"; }?>">
                    <input class="text-input3" type="password" name="newmdp1" placeholder="New password">
                    <input class="text-input3" type="password" name="newmdp2" placeholder="Confirm your password">
                    <input class="inputSubmit" type="submit" value="Update">
                    <input type="submit" name="deleteAccount" class="delete-button inputDelete" value="Delete my account">
               
                </form>
                
            </main>

            <script src="js/deleteAccount.js"></script>
            <script src="js/photo.js"></script>

        </body>

    </html>