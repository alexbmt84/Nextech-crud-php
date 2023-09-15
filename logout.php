<?php

    require_once('core/init.php');

    $db_obj = new Database();
    $db_connection = $db_obj->dbConnection();

    session_destroy();
    header('location: index.php');
    exit;
    
?>