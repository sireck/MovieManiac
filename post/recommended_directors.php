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
        $fav_directors          =   Array();
        $i                      =   0;     
        $fav_directors_query    =   "SELECT director_name, count (director_name) FROM directors, (select user_id,movie_id,rating from user_data where user_id='$logged_user_id' AND watched='watched' order by rating DESC) as user_ratings WHERE user_ratings.movie_id = directors.id group by director_name order by count DESC LIMIT 10";
        $fav_directors_result      =   pg_query($fav_directors_query) or die(pg_last_error());

        while($fav_directors_row=pg_fetch_array($fav_directors_result)) {
            $fav_directors[$i]     =   $fav_directors_row['director_name'];
            $i++;
        }
        $prev       =   array();
        $prev_id    =   0;
        $genres     =   array();
        $actors     =   array();
        $final      =   "";
        $appeared   =   array();
        for($i=0;$i<count($fav_directors);$i++) {
            $fav_director   =   $fav_directors[$i];
            $query  =   "SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating FROM genre, genre_relationships AS g, movie_cast AS m,directors AS d, (SELECT * FROM movies WHERE id in (SELECT id FROM (SELECT movies.id FROM movie_cast, movies WHERE actor_name = '$fav_director' AND movies.id=movie_cast.movie_id ORDER BY critic_score LIMIT 3) as fav_actors group by id) ORDER BY critic_score DESC LIMIT 10) AS q WHERE g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ORDER BY q.critic_score, q.id";
            
            
            $result     =   pg_query($query) or die(pg_last_error());

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
                        if(!check_array($appeared, $current['id'])) {
                        $appeared[sizeof($appeared)]    =   $current['id'];
                        $final .= $prev['id'].";".$prev['title'].";".$prev['thumbnail_poster'].";".print_array(array_unique($genres)).";".print_array(array_unique($actors)).";".$prev['director_name'].";".$prev['mpaa_rating'].";".$prev['critic_score'].";".$prev['year']."#";
                        }
                        $genres =   array();
                        $actors =   array();
                        $prev   =   $current;
                    }
                    $prev_id    =   $current['id'];
                }
                $last   =   $current;
            }
                $current    =   $last;
                if(!check_array($appeared, $current['id'])) {
                    $appeared[sizeof($appeared)]    =   $current['id'];
                    $final .= $current['id'].";".$current['title'].";".$current['thumbnail_poster'].";".print_array(array_unique($genres)).";".print_array(array_unique($actors)).";".$current['director_name'].";".$current['mpaa_rating'].";".$current['critic_score'].";".$current['year']."#";
                }
        }
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
        
        function check_array($array,$id) {
            for($i=0;$i<sizeof($array);$i++) {
                if($id==$array[$i])
                    return true;
            }
            return false;
        }
    
?>
