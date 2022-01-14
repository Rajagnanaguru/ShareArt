<?php
    session_start();

    $user = $_POST["userid"];
    $passwd = $_POST["passwd"];

    $_SESSION["user"] = $user;

    
    

    
?>
