<?php
    if(!isset($_POST['username']))
        system.exit(0);
    session_start();
    require_once "../globals.php";
    $db = pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
    $username   =   $_POST['username'];
    $password   =   $_POST['password'];
    $name       =   $_POST['name'];
        
    $check_query    =   "SELECT count(*) FROM users WHERE username='$username'";
    $login_query    =   "INSERT INTO users VALUES (1+(select max(id) from users),'$name','$username',md5('$password'),'f')";
    
    $check_result   =   pg_query($check_query) or die(pg_last_error());
    $check_row      =   pg_fetch_array($check_result);
    $num_rows       =   $check_row['count'];
    if($num_rows > 0) {
        $result =   pg_query($login_query) or die(pg_last_error());
        if($result)
            header("location: ../index.php?message=user_added");
    }
    else {
        header("location: ./index.php?message=username_exists");
    }
?>
