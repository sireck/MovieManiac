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
    <title>Movie Mania - Online Movie Recommender - List of Your Rated Movies</title>
    </head>
    <body>
    <?php
    include "../header.php";
    if($logged) { ?>
    <script type="text/javascript">
        $.get("<?php echo $POST.'rated_movies.php?logged_user_id='.$logged_user_id; ?>", function(data) {
            document.getElementById("wannawatch-results").innerHTML = loadWannaWatch(data);
        });
    </script>
        <div class="wannawatch">
            <p class=heading>Rated movies list!</p>
            <div class="wannawatch-results" id="wannawatch-results"></div>
        </div>
    <?php } else { ?>
        <div class=wannawatch-loggedout><center><p class="user-data">You're not logged in! <br />Please <a href="<?php echo $LOGIN.'index.php?redirect=\''.$currentPage.'\''; ?>">Login</a> or <a href="<?php echo $REGISTER.'index.php?redirect=\''.$currentPage.'\''; ?>">Register</a> to view your Wanna Watch list!</p></center></div>
    <?php } ?>
    </body>
</html> 
