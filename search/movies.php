<?php
    $db = pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
    $movie_name     =   $_GET['search_string'];
    $sort           =   $_GET['sort_by'];
    $show_only      =   $_GET['show_only'];
    $logged_user_id =   $_GET['logged_user_id'];
    $logged         =   !($logged_user_id=="");
    
    if(!isset($_GET['sort_by']))
        $orderby    =   "ORDER BY q.critic_score DESC, q.id";
    else
        $orderby    =   "ORDER BY $sort DESC, q.id";
    
    
    if(isset($_GET['live'])) 
        $query ="SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre, genre_relationships as g,movie_cast as m,directors as d,(SELECT id,title,mpaa_rating,critic_score,thumbnail_poster, year from movies where title ILIKE '%$movie_name%' ORDER BY critic_score DESC LIMIT 5) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ".$orderby;
        
    else if($show_only=="not_watched" && $logged)
        $query ="SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre, genre_relationships as g,movie_cast as m,directors as d,(SELECT id,title,mpaa_rating,critic_score,thumbnail_poster, year from movies where title ILIKE '%$movie_name%' AND id not in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ".$orderby;

    else if($show_only=="watched" && $logged)   
        $query  =   "SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating from genre,genre_relationships as g,movie_cast as m,directors as d,(SELECT * from movies where id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') AND title ILIKE '%$movie_name%' ORDER BY critic_score DESC LIMIT 10) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ".$order_by;

    else if($show_only=="wanna_watch" && $logged)   
        $query  =   "SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating from genre,genre_relationships as g,movie_cast as m,directors as d,(SELECT * from movies where id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='wanna watch') AND title ILIKE '%$movie_name%' ORDER BY critic_score DESC LIMIT 10) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ".$order_by;

    else $query ="SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre, genre_relationships as g,movie_cast as m,directors as d,(SELECT id,title,mpaa_rating,critic_score,thumbnail_poster, year from movies where title ILIKE '%$movie_name%' ORDER BY critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ".$orderby;

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
                $final .= $prev['id'].";".$prev['title'].";".$prev['thumbnail_poster'].";".print_array(array_unique($genres)).";".print_array(array_unique($actors)).";".print_array(array_unique($dirs)).";".$prev['mpaa_rating'].";".$prev['critic_score'].";".$prev['year']."#";
                $genres =   array();
                $actors =   array();
                $dirs   =   array();
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
