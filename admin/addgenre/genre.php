<?php
    if(!isset($_POST['movie_id']))
        system.exit(0);
    $db             =   pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
    $movie_id       =   $_POST['movie_id'];
    $genres         =   $_POST['genre'];
    $director_name  =   $_POST['director_name'];
    $movie_cast     =   $_POST['movie_cast'];
    
    for($i=0;$i<count($genres);$i++) {
        $genre_id   =   $genres[$i];
        $query      =   "INSERT INTO genre_relationships VALUES ('$movie_id', '$genre_id')";
        $result     =   pg_query($query) or die(pg_last_error());
    }
    
    $directors      =   explode(";",$directors);
    for($i=0;$i<count($directors);$i++) {
        $director_name  =   $directors[$i];
        $query      =   "INSERT INTO directors VALUES ('$movie_id', '$director_name')";
        $result     =   pg_query($query) or die(pg_last_error());
    }
    
    $movie_cast     =   explode(";",$movie_cast);
    for($i=0;$i<count($movie_cast);$i++) {
        $cast       =   explode(":", $movie_cast[$i]);
        $actor_name =   explode("(", $cast[0]);
        $character  =   explode(")", $cast[1]);
        
        $actor_name =   $actor_name[1];
        $character  =   $character[0];
        
        $query      =   "INSERT INTO movie_cast VALUES ('$movie_id', '$actor_name', '$character', 'f')";
        $result     =   pg_query($query) or die(pg_last_error());
    }
    header("location: ../index.php?message=movie_added");
?>
