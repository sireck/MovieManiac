<html>
    <head>
        <?php 
            include "../includes.php"; 
            session_start();
            $logged_username    =   $_SESSION['logged_username'];
            $logged_user_id     =   $_SESSION['logged_user_id'];
            if(isset($_SESSION['logged_username'])) $logged =   true;
            else $logged    =   false;
        ?>        
        <title>Movie Mania - Online Movie Recommender - Individual Movie Detailed View</title>
    </head>
    <body>
    <?php include "../header.php";
    
    $db = pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');
    $id   =   $_GET['id'];
    $query ="SELECT q.id, q.title, q.year, q.mpaa_rating, q.runtime, q.theatre_release_date, q.critic_score, q.audience_score, q.synopsis, q.studio, q.thumbnail_poster, q.imdb_id, q.num_user_ratings, genre, actor_name, character, director_name FROM genre, genre_relationships AS g,movie_cast AS m,directors AS d,(SELECT * FROM movies WHERE id='$id') AS q WHERE g.movie_id='$id' AND genre.id=g.genre_id AND m.movie_id='$id' AND d.id='$id'";
    
    if($logged) {
        $user_data_query    =   "SELECT * from user_data where user_id='$logged_user_id' AND movie_id='$id'";
        $user_data_result   =   pg_query($user_data_query) or die(pg_last_error());
        $user_data          =   pg_fetch_array($user_data_result);
        
        $user_rating        =   $user_data['rating'];
        $user_notes         =   $user_data['notes'];
        $watched            =   $user_data['watched'];
        if($watched=="watched")          $watched_status    =   1;
        else if($watched=="not watched") $watched_status    =   2;
        else if($watched=="wanna watch") $watched_status    =   3;
    }

    if($user_rating=="")
        $user_rating=0;
    
    $result     =   pg_query($query) or die(pg_last_error());
    $prev_id    =   0;
        
    while($current = pg_fetch_array($result)) {
    if($prev_id==$current['id']){
            $genres[sizeof($genres)]    =   $current['genre'];
            $cast[sizeof($cast)]        =   Array($current['actor_name'], $current['character']);
            $dirs[sizeof($dirs)]        =   $current['director_name'];
            $prev=$current;
        }
        else {
            if(sizeof($genres)==0){
                $prev                   =   $current;
                $genres[sizeof($genres)]=   $current['genre'];
                $cast[sizeof($cast)]    =   Array($current['actor_name'], $current['character']);
                $dirs[sizeof($dirs)]    =   $current['director_name'];
                
                $movie_id               =   $prev['id'];
                $title                  =   $prev['title'];
                $year                   =   $prev['year'];
                $mpaa_rating            =   $prev['mpaa_rating'];
                $runtime                =   $prev['runtime'];
                $theatre_release_date   =   $prev['theatre_release_date'];
                $critic_score           =   $prev['critic_score'];
                $audience_score         =   $prev['audience_score']/$prev['num_user_ratings'];
                $synopsis               =   $prev['synopsis'];
                $studio                 =   $prev['studio'];
                $thumbnail_poster       =   $prev['thumbnail_poster'];
                $imdb_id                =   $prev['imdb_id'];
                $num_user_ratings       =   $prev['num_user_ratings'];
            }
            else {
                $genres                 =   array_unique($genres);
            }
            $prev_id    =   $current['id'];
            $prev       =   $current;
        }
    }
    $genres             =   array_unique($genres);
    $j=0;
    for($i=0;$i<sizeof($cast);$i++){
        if(!check_array($cast[$i],$cast_final)) $cast_final[$j] =   $cast[$i];
        $j++;
    }

    $j=0;
    for($i=0;$i<sizeof($dirs);$i++){
        if(!check_array($dirs[$i],$dirs_final)) $dirs_final[$j] =   $dirs[$i];
        $j++;
    }
    $dirs   =   $dirs_final;
    function check_array($element, $array){
        for($i=0;$i<sizeof($array);$i++) {
            if($element==$array[$i]) return true;
        }
        return false;
    }
?>
    <div class="description">
        <div class="incorrect-div clear"><center><p class="incorrect">Not sure if the movie details shown are not of the '<?php echo $title; ?>' you wanted? Please click <a  href="<?php echo $VIEWS.'search.php?search_string='.$title.'&category=movie'; ?>">here</a> to view details of '<?php echo $title; ?>' you intended to view! </p></center></div>
        <div class="clear">
            <img src="<?php echo $thumbnail_poster; ?>" />
        </div>
        <div>
            <p class="title"><?php echo $title." ($year) "; ?></p>
            <?php if($synopsis!="") { ?>
                <p class="synopsis"><?php echo "<b>Synopsis:</b> ".$synopsis; ?></p>
            <?php }
            echo "<p class=director>Directed by ";
            for($d=0;$d<sizeof($dirs);$d++) {
                $director_name  =   $dirs[$d];
                $search_string  =   str_replace(" ","_",$director_name);
                $dir_url        =   "http://localhost/movie_maniac/views/search.php?search_string=".$search_string."&category=director";
                if($director_name!="") echo " <span class=field><a href='$dir_url'>".$director_name."</a></span> ";
            }
            echo "</p>";
            if($studio!="") echo "<p class=studio>Produced by <span class=field>".$studio."</span> studios</p>";
            
            $cast_list =   "";
            for($i=0;$i<sizeof($cast_final);$i++) {
                $cast_array =   $cast_final[$i];
                $actor_name =   $cast_array[0];
                $character  =   $cast_array[1];
                $search_string  =   str_replace(" ","_",$actor_name);
                $actor_url      =   "http://localhost/movie_maniac/views/search.php?search_string=".$search_string."&category=actor";
                if($cast_array[1]!="") $cast_list  .=   "<a href='".$actor_url."'>".$actor_name." (".$character.")</a><br />";
                else $cast_list  .=   $cast_array[0]."<br />";
            }
            echo "<span class=cast-field>Cast: <br /></span><p class=cast>".$cast_list."</p>";
            if($logged) { ?>
            <div class="logged-user">          
            <?php
            if($watched_status==1){
            ?>
                <span class="watched" id="watched">Seems like you've watched this movie. Please rate it or confirm your 'watched' status! 
                    <button onclick="watched('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','not watched')">Haven't watched yet!</button>
                    <button onclick="watched('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','wanna watch')">Wanna Watch!</button>
                </span>
                <?php if($user_notes!="") {?>
                    <p class=user-notes id=user-notes>Your personal notes on the movie: <?php echo $user_notes; ?> <a class=link onclick="editnotes('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','<?php echo $user_notes; ?>')"> (edit)</a></p>
                <?php } else {?>
                    <p class=user-notes id=user-notes>Your don't have any personal notes on the movie <a class=link onclick="editnotes('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','<?php echo $user_notes; ?>')"> (add)</a></p>
                <?php } ?>
                    <p class=user-rating id=user-rating><?php echo "Your rating of the movie: ".$user_rating." (out of 100)"; ?><a class=link onclick="editrating('<?php echo $movie_id ?>', '<?php echo $logged_user_id; ?>', '<?php echo $user_rating; ?>')"> (edit)</a></p>
            <?php }
            else if($watched_status==2) {
            ?>  
                <span class="watched" id="watched">Seems like you haven't watched this movie yet, have you? Please confirm! 
                    <button onclick="watched('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','not watched')">Wanna Watch!</button>
                    <button onclick="watched('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','watched')">Watched!</button>
                </span>
                <?php if($user_notes!="") { ?>
                    <p class=user-notes id=user-notes>Your personal notes on the movie: <?php echo $user_notes; ?> <a class=link onclick="editnotes('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','<?php echo $user_notes; ?>')"> (edit)</a></p>
                <?php }else {?>
                    <p class=user-notes id=user-notes>Your don't have any personal notes on the movie <a class=link onclick="editnotes('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','<?php echo $user_notes; ?>')"> (add)</a></p>
                <?php } ?>
                <p class=user-rating id=user-rating><?php echo "Your rating of the movie: ".$user_rating." (out of 100)"; ?><a class=link onclick="editrating('<?php echo $movie_id ?>', '<?php echo $logged_user_id; ?>', '<?php echo $user_rating; ?>')"> (edit)</a></p>
                <?php }
            else if($watched_status==3){
            ?>
                <span class="watched" id="watched">Seems like you wanted to watch this movie, have you watched it yet? Please confirm! 
                    <button onclick="watched('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','not watched')">Remove from Wanna Watch List!</button>
                    <button onclick="watched('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','watched')">Watched!</button>
                </span>
                <?php if($user_notes!="") {?>
                    <p class=user-notes id=user-notes>Your personal notes on the movie: <?php echo $user_notes; ?> <a class=link onclick="editnotes('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','<?php echo $user_notes; ?>')"> (edit)</a></p>
                <?php } else {?>
                    <p class=user-notes id=user-notes>Your don't have any personal notes on the movie <a class=link onclick="editnotes('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','<?php echo $user_notes; ?>')"> (add)</a></p>
                <?php } ?>
                    <p class=user-rating id=user-rating><?php echo "Your rating of the movie: ".$user_rating." (out of 100)"; ?><a class=link onclick="editrating('<?php echo $movie_id ?>', '<?php echo $logged_user_id; ?>', '<?php echo $user_rating; ?>')"> (edit)</a></p>
                <?php }
            else { ?>
                <span class="watched" id="watched">Seems like you haven't watched this movie yet, have you? Please confirm! 
                    <button onclick="watched('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','wanna watch')">Wanna Watch!</button>
                    <button onclick="watched('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','watched')">Watched!</button>
                </span>
                <?php if($user_notes!="") {?>
                    <p class=user-notes id=user-notes>Your personal notes on the movie: <?php echo $user_notes; ?> <a class=link onclick="editnotes('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','<?php echo $user_notes; ?>')"> (edit)</a></p>
                <?php } else {?>
                    <p class=user-notes id=user-notes>Your don't have any personal notes on the movie <a class=link onclick="editnotes('<?php echo $movie_id; ?>','<?php echo $logged_user_id; ?>','<?php echo $user_notes; ?>')"> (add)</a></p>
                <?php } ?>
                    <p class=user-rating id=user-rating><?php echo "Your rating of the movie: ".$user_rating." (out of 100)"; ?><a class=link onclick="editrating('<?php echo $movie_id ?>', '<?php echo $logged_user_id; ?>', '<?php echo $user_rating; ?>')"> (edit)</a></p>
            <?php } ?>
                    <p class=user-rating id=user-rating style=" display: none; "><?php echo "Your rating of the movie: ".$user_rating." (out of 100)"; ?><a class=link onclick="editrating('<?php echo $movie_id ?>', '<?php echo $logged_user_id; ?>', '<?php echo $user_rating; ?>')"> (edit)</a></p>
            <?php } else {?> 
                <p class="user-data">You're not logged in! <a href="<?php echo $LOGIN.'index.php?redirect=\''.$currentPage.'\''; ?>">Login</a> or <a href="<?php echo $REGISTER.'index.php?redirect=\''.$currentPage.'\''; ?>">Register</a> to get recommended movies, rate or review movies, create your Wanna Watch list!</p>
            <?php } ?>
            </div>
        </div>
    </div>
        
    <div class="extra-details clear">
        <table width="100%">
            <tr>
                <td class="label">Mpaa_rating</td>
                <td><span class="field"><?php echo $mpaa_rating; ?></span></td>
            </tr>
            <tr>
                <td class="label">Runtime</td>
                <td><span class="field"><?php echo $runtime." minutes"; ?></span></td>
            </tr>
            <tr>
                <td class="label">Theatre release date</td>
                <td><span class="field"><?php echo $theatre_release_date; ?></span></td>
            </tr>
            <?php if($critic_score >= 0) { ?>
            <tr>
                <td class="label">Critic score</td>
                <td><span class="field"><?php echo $critic_score; ?></span></td>
            </tr>
            <?php }
            if($audience_score >= 0) { ?>
            <tr>
                <td class="label">Audience score</td>
                <td><span class="field"><?php echo intval($audience_score)." (".$num_user_ratings." votes)"; ?></span></td>
            </tr>
            <?php } ?>
            <tr>
                <td class="label">IMDB id</td>
                <td><span class="field"><?php echo $imdb_id; ?></span></td>
            </tr>
        </table>
    </div>
    
    <div class="reviews clear">
        <p class="title">Critic Reviews for '<?php echo $title; ?>'</p>
        <?php 
            $reviews_query      =   "SELECT * from reviews where movie_id='$movie_id'";
            $reviews_result     =   pg_query($reviews_query) or die(pg_last_error());
            $reviews_count      =   pg_num_rows($reviews_result);
            if($reviews_count==0) { ?>
                <p class="no-reviews">Oops! This movie hasn't got any critic reviews yet!</p>
            <?php }
            while($reviews_row  =   pg_fetch_array($reviews_result)){
                $critic_name    =   $reviews_row['critic_name'];
                $date           =   $reviews_row['date'];
                $freshness      =   $reviews_row['freshness'];
                $publication    =   $reviews_row['publication'];
                $quote          =   $reviews_row['quote'];
                
                $date           =   changeDateFormat($date);
            if($quote!="") {
            ?>
                <div class="review">
                    <p class="quote"><?php echo $quote; ?></p>
                    <p class="publication">through <?php echo "<b>".$publication."</b> on ".$date; ?></p>
                    <span class="critic_name"><?php echo "- ".$critic_name; ?></span>
                </div>
            <?php
            }}
        ?>
    </div>
    </body>
</html> 
