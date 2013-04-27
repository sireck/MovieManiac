<html>
    <head>
        <?php 
            include "../includes.php"; 
            include "../globals.php";
            session_start();
            $logged_username    =   $_SESSION['logged_username'];
            $logged_user_id     =   $_SESSION['logged_user_id'];
            if(isset($_SESSION['logged_username'])) 
                $logged         =   true;
            else 
                $logged         =   false;
            $search_string      =   $_GET['search_string'];
            $category           =   $_GET['category'];
            $pattern            =   "_";
            $replacement        =   " ";
            $search_string  	=	str_replace($pattern,$replacement,$search_string);
        ?>        
        <title>Movie Mania - Online Movie Recommender - Search Results</title>
        <!-- script for live search -->
        <script type="text/javascript">
        function changePageNumber() {
            page    =   document.getElementById("page").value;
            document.getElementById("pagenumber").value   =   page;
        }
        function get_results() {
            search_string   =   document.getElementById("search_string").value;
            sort_by         =   document.getElementById("sort_by").value;
            show_only       =   document.getElementById("show_only").value;
            page            =   document.getElementById("pagenumber").value;
            
            if(search_string!= "") {    
                //checking category for search
                category        =   document.getElementById("category").value;
                url="<?php echo $SEARCH; ?>"+category+"s.php?search_string="+search_string+"&sort_by="+sort_by+"&show_only="+show_only+"&logged_user_id=<?php echo $logged_user_id; ?>";


                $.get(url, function(data) {
                    //alert(data);
                    movies  =   data.split("#");
                    maxpages=   Math.ceil(movies.length/20);

                    html="You're viewing page number <select name=page id=page onchange='changePageNumber(); get_results();'>";
                    for(i=0;i<maxpages;i++) {
                        current =   i+1;
                        if(i==page) 
                            html    +=  "<option selected value="+i+">"+current+"</option>";
                        else 
                            html    +=  "<option value="+i+">"+current+"</option>";
                    }
                    html += "</select>";
                    
                    document.getElementById("pagination").innerHTML =   html;
                    document.getElementById("Results").innerHTML= loadSearchView( data, category, search_string, page );
                });
            }
        }
        </script>
    </head>
    <body onload="document.getElementById('search_string').focus(); get_results(); ">
    <?php include "../header.php";
    if(!$logged) { ?>
    <div class="search">
        <p class="user-data">You're not logged in! <a href="<?php echo $LOGIN.'index.php?redirect=\''.$currentPage.'\''; ?>">Login</a> or <a href="<?php echo $REGISTER.'index.php?redirect=\''.$currentPage.'\''; ?>">Register</a> to filter search results with movies you wanted to watch, watched or haven't watched yet</p>
    </div>
    <?php } ?>
    <form action="" method="GET" onsubmit="return false">
        <div class="homesearchbox">
            Movie name <select name="match_type">
                <option value="=">exactly</option>
                <option value="ilike">similar</option>
            </select>
            <input type="text" name="movie_name">
            <input class="homePageSearchBox" type="text" name="search_string" value="<?php echo $search_string;?>" id="search_string" onkeyup="get_results()" />
            <select name="category" id="category" onchange="get_results()">
                <option <?php if($category=="movie") echo "selected";?> value="movie">Movie</option>
                <option <?php if($category=="genre") echo "selected";?> value="genre">Genre</option>
                <option <?php if($category=="director") echo "selected";?> value="director">Director</option>
                <option <?php if($category=="actor") echo "selected";?> value="actor">Actor</option>
            </select>
            <input type="hidden" id="pagenumber" value="0">
        </div>
    </form>
    <div id="search-header" class="search-header">
        <form action="" onsubmit="return false">
        <div class="sort">Sort by  
            <select name="sort_by" id="sort_by" onchange="get_results()">
                <option value="critic_score">critic score</option>
                <option value="title">title</option>
                <option value="year">year</option>
            </select>
            <?php if($logged) { ?>
            Showing
            <select name="show_only" id="show_only" onchange="get_results()">
                <option value="all">all movies</option>
                <option value="watched">watched only</option>
                <option value="wanna_watch">wanna watch only</option>
                <option value="not_watched">not watched only</option>
            </select>
            <?php } 
            else { ?>
                <input type="hidden" id="show_only" value="all">
            <?php } ?>
        </div>
        <div id="pagination" class="pagination"></div>
        </form>
    </div>
    <div id="Results"></div>
    </body>
</html> 
