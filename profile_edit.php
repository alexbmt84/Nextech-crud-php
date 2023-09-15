<?php

    require './core/init.php';

    $user_data = $user_obj->findByiD($_SESSION['user-id']);

    if(!empty($_POST['newmdp1']) AND !empty($_POST['newmdp2'])) {
        User::changePassword();
    }

    elseif(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        User::changeAvatar(); 
    }

    elseif (!empty($_POST['newpseudo']) && $_POST['newpseudo'] != $user_data->pseudo) { 
        User::changePseudo();
    }

    elseif (!empty($_POST['newmail']) && $_POST['newmail'] != $user_data->email) {   
        User::changeMail(); 
    }

    elseif (!empty($_POST['firstname'])) {
        User::changeFirstName();
    }

    elseif (!empty($_POST['lastname'])) {
        User::changeLastName();
    }

    elseif (isset($_POST['deleteAccount'])) {
        User::deleteAccount();
    }

    else {
        header('Location: profile.php?err=update');
    }

?>