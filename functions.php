<?php
$db = pg_connect('host=localhost dbname=movie_maniac user=postgres password=mrinmayee');

function total_movies() {

    $tm_query  =   "select count(*) from movies";
    $tm_result =   pg_query($tm_query) or die(pg_last_error());
    $tm_row    =   pg_fetch_array($tm_result);
    return $tm_row['count'];
}

function total_reviews() {
    $tr_query  =   "select count(*) from reviews";
    $tr_result =   pg_query($tr_query) or die(pg_last_error());
    $tr_row    =   pg_fetch_array($tr_result);
    return $tr_row['count'];
}

function total_genres() {
    $tg_query  =   "select count(*) from genre";
    $tg_result =   pg_query($tg_query) or die(pg_last_error());
    $tg_row    =   pg_fetch_array($tg_result);
    return $tg_row['count'];
}

function total_users() {
    $tu_query  =   "select count(*) from users";
    $tu_result =   pg_query($tu_query) or die(pg_last_error());
    $tu_row    =   pg_fetch_array($tu_result);
    return $tu_row['count'];
}

function get_genres() {
    $gg_query   =   "select * from genre";
    $gg_result  =   pg_query($gg_query) or die(pg_last_error());
    $gg_array   =   array();
    $number     =   0;
    while($gg_row=pg_fetch_array($gg_result)) {
        $gg_array[$number]  =   array($gg_row['id'],$gg_row['genre']);
        $number++;
    }
    return $gg_array;
}

function get_movie_details($id) {
    $gm_query   =   "select * from movies where id='$id'";
    $gm_result  =   pg_query($gm_query) or die(pg_last_error());
    return pg_fetch_array($gm_result);
}

function changeDateFormat($date) {
    $details    =   explode("-",$date);
    $year       =   $details[0];
    $month      =   $details[1];
    $day        =   $details[2];
    
    return $day.", ".getMonthName($month)." ".$year;
}

function getMonthName($month) {
    $month_name["01"]  =   "January";
    $month_name["02"]  =   "February";
    $month_name["03"]  =   "March";
    $month_name["04"]  =   "April";
    $month_name["05"]  =   "May";
    $month_name["06"]  =   "June";
    $month_name["07"]  =   "July";
    $month_name["08"]  =   "August";
    $month_name["09"]  =   "September";
    $month_name["10"] =   "October";
    $month_name["11"] =   "November";
    $month_name["12"] =   "December";
    
    return $month_name[$month];
}
/*current page URL function*/
function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
?>
