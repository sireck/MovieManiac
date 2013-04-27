<html>
    <head>
        <?php 
            include "includes.php"; 
            session_start();
            $logged_username    =   $_SESSION['logged_username'];
            $logged_user_id     =   $_SESSION['logged_user_id'];
        ?>        
        <title>Movie Mania - Online Movie Recommender - Home Page</title>
        <!-- script for live search -->
        <script type="text/javascript">
        function get_results() {
            document.getElementById("searchView").innerHTML="";
            search_string = document.getElementById("search_string").value;
            if(search_string!= "") {
                //checking category for search
                category = document.getElementById("category").value;
                if(category == "movie") url="<?php echo $SEARCH; ?>"+"movies.php?search_string="+search_string+"&live=true";
                else if(category == "genre") url="<?php echo $SEARCH; ?>"+"genres.php?search_string="+search_string+"&live=true";
                else if(category == "director") url="<?php echo $SEARCH; ?>"+"directors.php?search_string="+search_string+"&live=true";
                else if(category == "actor") url="<?php echo $SEARCH; ?>"+"actors.php?search_string="+search_string+"&live=true";
                
                $.get(url, function(data) {
                    document.getElementById("searchView").innerHTML = loadLiveSearchView(data,category,search_string);
                });
            }
            else {
                document.getElementById("searchView").innerHTML="";
            }
        }
        </script>
    </head>
    <body onload="document.getElementById('search_string').focus(); hideMessages(); " style="background-image: url('./images/movie_poster_collage.jpg')">
    <?php include "header.php" ?>
    <form action="" method="POST" onsubmit="return false">
        <div class="homesearchbox">
            <input class="homePageSearchBox" type="text" autocomplete="off" name="search_string" id="search_string" onkeyup="get_results()" />
            <select name="category" id="category" onchange="get_results()">
                <option value="movie">Movie</option>
                <option value="genre">Genre</option>
                <option value="director">Director</option>
                <option value="actor">Actor</option>
            </select>
        </div>
    </form>
    
    <div id="searchView"></div>
    </body>
</html> 
