<?php
    session_start();
    $logged_username    =   $_SESSION['logged_username'];
    $logged_user_id     =   $_SESSION['logged_user_id'];
    
    if(isset($_SESSION['logged_username'])) 
        $logged =   true;
    else if($logged_user_id==$_GET['logged_user_id'])
        $logged =   true;
    else 
        $logged =   false;
        
    if($logged) {
        $db = pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
        $query  =   "SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating from genre,genre_relationships as g,movie_cast as m,directors as d,(SELECT * from movies where id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='wanna watch') ORDER BY critic_score DESC LIMIT 10) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ORDER BY q.critic_score, q.id";
        
        $result     =   pg_query($query) or die(pg_last_error());
        $prev       =   array();
        $prev_id    =   0;
        $genres     =   array();
        $actors     =   array();
        $final      =   "";

        while($current = pg_fetch_array($result)) {
            if($prev_id==$current['id']){
                $genres[sizeof($genres)]=$current['genre'];
                $actors[sizeof($actors)]=$current['actor_name'];
            }
            else {
                if(sizeof($genres)==0){
                    $prev   =   $current;
                    $genres[sizeof($genres)]=$current['genre'];
                    $actors[sizeof($actors)]=$current['actor_name'];
                }
                else {
                    $final .= $prev['id'].";".$prev['title'].";".$prev['thumbnail_poster'].";".print_array(array_unique($genres)).";".print_array(array_unique($actors)).";".$prev['director_name'].";".$prev['mpaa_rating'].";".$prev['critic_score'].";".$prev['year']."#";
                    $genres =   array();
                    $actors =   array();
                    $prev   =   $current;
                }
                $prev_id    =   $current['id'];
            }
            $last   =   $current;
        }
            $current    =   $last;
            $final .= $current['id'].";".$current['title'].";".$current['thumbnail_poster'].";".print_array(array_unique($genres)).";".print_array(array_unique($actors)).";".$current['director_name'].";".$current['mpaa_rating'].";".$current['critic_score'].";".$current['year']."#";
        echo $final;
    }
    else {
        system.exit(0);
    }
    
    function print_array($array) {
        $output =   "";
        for($i=0;$i<sizeof($array);$i++) {
            $output .= $array[$i].",";
        }
        return $output;
    }
?>
