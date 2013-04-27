<?php
    if(!isset($_POST['username']))
        system.exit(0);
    session_start();
    require_once "../globals.php";
    $db = pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
    $username   =   $_POST['username'];
    $password   =   $_POST['password'];
    
    $check_query    =   "SELECT count(*) FROM users WHERE username='$username'";
    $login_query    =   "SELECT id,username,name,password FROM users WHERE username='$username'";
    
    $check_result   =   pg_query($check_query) or die(pg_last_error());
    $check_row      =   pg_fetch_array($check_result);
    $num_rows       =   $check_row['count'];
    if($num_rows > 0) {
        $result =   pg_query($login_query) or die(pg_last_error());
        $row    =   pg_fetch_array($result) or die(pg_last_error());
        if($username==$row['username'] && md5($password)==$row['password']){
            $logged_user_id     =   $row['id'];
            $logged_username    =   $row['username'];
            $_SESSION['logged_user_id']     =   $logged_user_id;
            $_SESSION['logged_username']    =   $logged_username;
            echo "success";
        }
        else {
            echo "<span class=error>Error: Incorrect password. Please try again!</span>";
        }
    }
    else {
        echo "<span class=error>Error: Username doesn't exist. Please try again with the correct username</span>";
    }
?>
