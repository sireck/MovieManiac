<html>
    <head>
        <?php 
            include "../includes.php"; 
            session_start();
            $logged_username    =   $_SESSION['logged_username'];
            $logged_user_id     =   $_SESSION['logged_user_id'];
            $logged             =   isset($_SESSION['logged_username']);
            $currentPage        =   curPageURL();
        ?>
        <title>Movie Mania - Online Movie Recommender - Admin Home Page</title>
    </head>
    <body onload=" hideMessages(); ">
    <?php
        include "../header.php";
        if($logged_username!="admin" && $logged) {
            echo "<p class=error>Illegal action! You're not admin. You don't have access here! Exiting...</p>";
            system.exit(0);
        }
    if($logged) { ?>
    <div id="admin" class="admin">
        <?php
            if(isset($_GET['message'])) {
                $message    =   $_GET['message'];
                if($message=="movie_added") {
        ?>
            <p class=success id="success">Movie Added Successfully</p>
        <?php }} ?>
        <div class="admin-header">
            <p class="title">Admin Home Page</p>
        </div>
        <div class="admin-statistics clear">
        <p class="header">Admin Statistics</p>
        <table width="100%">
            <tr>
                <td class="label">Total number of movies</td>
                <td><span class="field"><?php echo total_movies(); ?></span></td>
            </tr>
            <tr>
                <td class="label">Total number of reviews on all movies</td>
                <td><span class="field"><?php echo total_reviews(); ?></span></td>
            </tr>
            <tr>
                <td class="label">Total number of genres</td>
                <td><span class="field"><?php echo total_genres(); ?></span></td>
            </tr>
            <tr>
                <td class="label">Total number of users</td>
                <td><span class="field"><?php echo total_users(); ?></span></td>
            </tr>
        </table>
    </div>
    <div class="admin-menu">
    <ul>
        <li onclick="location.href='./addmovie/'"><span>Add a movie</span</li>
        <li><span>Add a genre</span></li>
    </ul>
    </div>
    </div>
    <?php } 
    else {?>
    <div class="admin-description"><p class="user-data">You're not logged in! If you have admin access please <a href="<?php echo $LOGIN.'index.php?redirect=\''.$currentPage.'\''; ?>">Login</a> to views site statistics, add movies or delete unnecessary comments</p></div>
    <?php } ?>
    </body>
</html> 
