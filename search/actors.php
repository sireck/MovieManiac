<?php
    $db = pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
    $actor_name  =   $_GET['search_string'];
    $sort           =   $_GET['sort_by'];
    $show_only      =   $_GET['show_only'];
    $logged_user_id =   $_GET['logged_user_id'];
    $logged         =   !($logged_user_id=="");
    if(!isset($_GET['sort_by']))
        $orderby    =   "ORDER BY mr.critic_score DESC, mr.id";
    else
        $orderby    =   "ORDER BY mr.$sort DESC, mr.id";
    
    if(isset($_GET['live'])) 
        $query ="SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' ORDER BY critic_score DESC LIMIT 5) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id ".$orderby;

    else if($show_only=="not_watched" && $logged)
        $query ="SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' and movies.id not in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY critic_score DESC) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id ".$orderby;

    else if($show_only=="watched" && $logged)   
        $query ="SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' and movies.id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY critic_score DESC) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id ".$orderby;

    else if($show_only=="wanna_watch" && $logged)   
        $query ="SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' and movies.id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='wanna watch') ORDER BY critic_score DESC) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id ".$orderby;

    else
        $query ="SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' ORDER BY critic_score DESC) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id ".$orderby;


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
            $dirs[sizeof($dirs)]    =$current['director_name'];
        }
        else {
            if(sizeof($genres)==0){
                $prev   =   $current;
                $genres[sizeof($genres)]=$current['genre'];
                $actors[sizeof($actors)]=$current['actor_name'];
                $dirs[sizeof($dirs)]    =$current['director_name'];
            }
            else {
                $final .= $prev['id'].";".$prev['title'].";".$prev['thumbnail_poster'].";".print_array(array_unique($genres)).";".print_array(array_unique($actors)).";".print_array(array_unique($dirs)).";".$prev['mpaa_rating'].";".$prev['critic_score'].";".$current['year']."#";
                $genres =   array();
                $actors =   array();
                $prev   =   $current;
            }
            $prev_id    =   $current['id'];
        }
        $last   =   $current;
    }
        $current    =   $last;
        $final .= $current['id'].";".$current['title'].";".$current['thumbnail_poster'].";".print_array(array_unique($genres)).";".print_array(array_unique($actors)).";".print_array(array_unique($dirs)).";".$current['mpaa_rating'].";".$current['critic_score'].";".$current['year']."#";
    echo $final;
    
    function print_array($array) {
        $output =   "";
        for($i=0;$i<sizeof($array);$i++) {
            $output .= $array[$i].",";
        }
        return $output;
    }
?>
