<?php

    session_start();
    session_regenerate_id(true);

    require 'core/database.class.php';
    require 'core/user.class.php';

    // DATABASE CONNECTIONS
    $db_obj = new Database();
    $db_connection = $db_obj->dbConnection();

    // USER OBJECT
    $user_obj = new User($db_connection);
    
?>