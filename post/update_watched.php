<?php
    session_start();
    $logged_username    =   $_SESSION['logged_username'];
    $logged_user_id     =   $_SESSION['logged_user_id'];
    
    if(isset($_SESSION['logged_username'])) 
        $logged =   true;
    else 
        $logged =   false;

    if($logged) {
        $movie_id   =   $_POST['movie_id'];
        $user_id    =   $_POST['user_id'];
        if(isset($_POST['watched']))
            $watched=   $_POST['watched'];
        else
            $watched=   "not watched";
        if(isset($_POST['rating']))
            $rating =   $_POST['rating'];
        else
            $rating =   0;
        if(isset($_POST['notes']))
            $notes  =   $_POST['notes'];
        else
            $notes  =   "";
        if($rating=="") $rating=0;
        $db         =   pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
        
        $query      =   "SELECT * FROM user_data where user_id='$user_id' AND movie_id='$movie_id'";
        $result     =   pg_query($query) or die(pg_last_error());
        if(pg_num_rows($result)==0){
            $final_query    =   "INSERT INTO user_data VALUES ('$user_id','$movie_id','$rating','$notes','$watched')";
            $final_result   =   pg_query($final_query) or die(pg_last_error());
            if($final_result) echo "success";
            else echo "fail";
        }
        else {
            $row    =   pg_fetch_array($result);
            if(isset($_POST['watched']))
                $watched=   $_POST['watched'];
            else
                $watched=   $row['watched'];
            if(isset($_POST['rating']))
                $rating =   $_POST['rating'];
            else
                $rating =   $row['rating'];
            if(isset($_POST['notes']))
                $notes  =   $_POST['notes'];
            else
                $notes  =   $row['notes'];
                
            if($watched=="not watched") $rating=0;
            
            $final_query    =   "UPDATE user_data SET watched='$watched', rating='$rating', notes='$notes' WHERE user_id='$user_id' AND movie_id='$movie_id'";
            $final_result   =   pg_query($final_query) or die(pg_last_error());
            if($final_result) echo "success";
            else echo "fail";
        }
    }
    else {
        system.exit(0);
    }
?>
