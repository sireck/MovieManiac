<?php
    if(!isset($_POST['title']))
        system.exit(0);
        
    $db         =   pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
    
    $title                  =   $_POST['title'];
    $year                   =   $_POST['year'];
    $mpaa_rating            =   $_POST['mpaa_rating'];
    if(isset($_POST['runtime']) && $_POST['runtime']!="")
        $runtime            =   $_POST['runtime'];
    else
        $runtime            =   0;
    if(isset($_POST['theatre_release_date']) && $_POST['theatre_release_date']!="")
        $theatre_release_date   =   $_POST['theatre_release_date'];
    else
        $theatre_release_date   =   "1970-01-01";
    if(isset($_POST['dvd_release_date']) && $_POST['dvd_release_date']!="")
        $dvd_release_date   =   $_POST['dvd_release_date'];
    else
        $dvd_release_date   =   "1970-01-01";
    $critic_score           =   0;
    $audience_score         =   0;
    $synopsis               =   $_POST['synopsis'];
    $studio                 =   $_POST['studio'];
    $thumbnail_poster       =   $_POST['thumbnail_poster'];
    $profile_poster         =   $_POST['profile_poster'];
    $imdb_id                =   $_POST['imdb_id'];

    $count_query    =   "SELECT max(id) from movies";
    $count_result   =   pg_query($count_query) or die(pg_last_error());
    $count_row      =   pg_fetch_array($count_result);
    $id             =   $count_row['max']+1;
    
    $query    =   "INSERT INTO movies (id, title, year, mpaa_rating, runtime, theatre_release_date, dvd_release_date, critic_score, audience_score, synopsis, studio, thumbnail_poster, profile_poster, imdb_id) VALUES ('$id', '$title', '$year', '$mpaa_rating', '$runtime', '$theatre_release_date', '$dvd_release_date', '$critic_score', '$audience_score', '$synopsis', '$studio', '$thumbnail_poster', '$profile_poster', '$imdb_id')";
    $result   =   pg_query($query) or die(pg_last_error());
    if($result) {
        $id =   base64_encode($id);
        header("location: ../addgenre/select.php?key=$id");
    }
    else {
        echo "fail";
        system.exit(0);
    }
    
?>
