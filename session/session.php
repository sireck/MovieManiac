<?php
    session_start();
    if(isset($_GET['logged_user_id'])){
        $logged_user_id     =   $_GET['logged_user_id'];
        $logged_username    =   $_GET['username'];
    
        $_SESSION['logged_user_id']     =   $logged_user_id;
        $_SESSION['logged_username']    =   $logged_username;
        echo "success"
    }
?>
