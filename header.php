<?php
    include "globals.php";
    require_once "includes.php";
    session_start();
    $logged_username    =   $_SESSION['logged_username'];
    $logged_user_id     =   $_SESSION['logged_user_id'];
    $logged             =   isset($_SESSION['logged_user_id']);
    $currentPage        =   urlencode(curPageURL());
?>
<div class="header">
    <div class="logo" onclick="location.href='<?php echo $HOME; ?>'">
        <div class="left">
            <img src="/movie_maniac/images/movie_maniac logo.jpg" class="logo-image" />
        </div>
        <!--<div class="right">
            <span class="header-title">Movie Maniac</span>
        </div>-->
    </div>
    <div class="loggedin">
    <?php if(!isset($_SESSION['logged_username'])) { ?>
        <span class="logged"><a href="<?php echo $LOGIN.'index.php?redirect=\''.$currentPage.'\''; ?>">Login</a>|<a href="<?php echo $REGISTER.'index.php?redirect=\''.$currentPage.'\''; ?>">Register</a></span>
    <?php } else { 
        $logout =  "<a class=logout href='".$SESSION."logout.php?sure=yes'>logout</a>"?>
        <span class="logged">Logged in as <span class="username"><?php echo $logged_username." ( $logout ) "; ?></span></span>
    <?php } ?>
    </div>
    <?php if($logged) { ?>
    <center>
    <div class="menu clear">
        <ul>
            <li><a href="<?php echo $HOME; ?>">Home</a></li>
            <li><a href="<?php echo $WANNAWATCH; ?>">Wanna Watch</a></li>
            <li><a href="<?php echo $RECOMMENDED; ?>">Recommended Movies</a></li>
            <li><a href="<?php echo $WATCHED; ?>">Watched</a></li>
            <li><a href="<?php echo $RATED; ?>">Rated By You</a></li>
        </ul>
    </div>
    </center>
    <?php } ?>
    <div class="clear"></div>
</div>
