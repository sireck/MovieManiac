<html>
    <head>
        <?php 
            include "http://localhost/movie_maniac/includes.php"; 
            include "../../functions.php";
            session_start();
            $logged_username    =   $_SESSION['logged_username'];
            $logged_user_id     =   $_SESSION['logged_user_id'];
            $logged             =   isset($_SESSION['logged_username']);
            
            $currentPage    =   curPageURL();
        ?>        
        <title>Movie Mania - Online Movie Recommender - Add Movie - Admin</title>
    <script type="text/javascript">
    
        function checkIt(evt,id) {
            evt = (evt) ? evt : window.event
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                status = "This field accepts numbers only."
	            document.getElementById(id+'_error').innerHTML = "<span style='color:red'>Only numbers allowed</span>";
	            document.getElementById(id+'_error').style.display='block';
                return false
            }
            status = ""
            return true
        }

        function validate(){
            var title       =   document.getElementById('title').value;
	        var year        =   document.getElementById('year').value;
	        var mpaa_rating =   document.getElementById('mpaa_rating').value;
	        
	        if(title == '') {
		        document.getElementById('title_error').innerHTML = "<span style='color:red'>Title field cannot be left blank</span>";
		        document.getElementById('title_error').style.display='block';
                document.getElementById('title').focus();
                document.getElementById('title').style.border='1px solid red';
            }
	
	        else if(year == '') {
		        document.getElementById('year_error').innerHTML = "<span style='color:red'>Year field cannot be left blank</span>";
		        document.getElementById('year_error').style.display='block';
                document.getElementById('year').focus();
                document.getElementById('year').style.border='1px solid red';
            }   
	        else if(mpaa_rating == '') {
		        document.getElementById('mpaa_rating_error').innerHTML = "<span style='color:red'>Year field cannot be left blank</span>";
		        document.getElementById('mpaa_rating_error').style.display = 'block';
                document.getElementById('mpaa_rating').focus();
                document.getElementById('mpaa_rating').style.border='1px solid red';
            }
            else
                document.forms['add-movie'].submit();
        }
    </script>
    </head>
    <body onload="document.getElementById('search_string').focus()">
    <?php
        include "../../header.php";
        if($logged_username!="admin" && $logged) {
            echo "<p class=error>Illegal action! You're not admin. You don't have access here! Exiting...</p>";
            system.exit(0);
        }
    if($logged) { ?>
    <div class="admin-add-movie" >
        <p><span class="highlight">Step 1: Enter movie details</span> => <span class="non-highlight">Step 2: Select genres for the movie</span> => <span class="non-highlight">Step 3: select cast and director for the movie</span></p>
        <fieldset>
        <legend><i>Add movie form - Admin</i></legend>
        <form action="./addmovie.php" method="POST" class="add-movie" id="add-movie" onsubmit="return false">
        <table>
        <tr>
            <td class="left"><label for="title">Title <span class='required'> *</span> </td>
            <td>
                <input type="text" name="title" id="title" onkeyup="this.style.border='1px solid green';;document.getElementById('title_error').style.display='none';">
                <div id="title_error" style="display: none;"></div>
            </td>
        </tr>
        <tr>
            <td class="left"><label for="year">Year <span class='required'> *</span> </td>
            <td>
                <input type="text" name="year" id="year" onkeypress="return checkIt(event,'year')" onblur="this.style.border='1px solid green';;document.getElementById('year_error').style.display='none';">
                <div id="year_error" style="display: none;"></div>
            </td>
        </tr>
        <tr>
            <td class="left"><label for="mpaa_rating">mpaa rating <span class='required'> *</span></td>
            <td>
                <input type="text" name="mpaa_rating" id="mpaa_rating" onkeyup="this.style.border='1px solid green';;document.getElementById('mpaa_rating_error').style.display='none';">
                <div id="mpaa_rating_error" style="display: none;"></div>
            </td>
        </tr>
        <tr>
            <td class="left"><label for="runtime">Runtime (in minutes)</td>
            <td>
                <input type="text" name="runtime" id="runtime" onkeypress="return checkIt(event,'runtime')" onblur="this.style.border='1px solid green'; document.getElementById('runtime_error').style.display='none';">
                <div id="runtime_error"></div>
            </td>
        </tr>
        <tr>
            <td class="left"><label for="theatre_release_date">Theatre release date</td>
            <td><input type="text" name="theatre_release_date" id="theatre_release_date"></td>
        </tr>
        <tr>
            <td class="left"><label for="dvd_release_date">dvd release date</td>
            <td><input type="text" name="dvd_release_date" id="dvd_release_date"></td>
        </tr>
        <tr>
            <td class="left"><label for="synopsis">Synopsis</td>
            <td><input type="text" name="synopsis" id="synopsis"></td>
        </tr>
        <tr>
            <td class="left"><label for="studio">Studio</td>
            <td><input type="text" name="studio" id="studio"></td>
        </tr>
        <tr>
            <td class="left"><label for="thumbnail_poster">Thumbnail Poster link</td>
            <td><input type="text" name="thumbnail_poster" id="thumbnail_poster"></td>
        </tr>
        <tr>
            <td class="left"><label for="profile_poster">Profile poster link</td>
            <td><input type="text" name="profile_poster" id="profile_poster"></td>
        </tr>
        <tr>
            <td class="left"><label for="imdb_id">IMDB id</td>
            <td><input type="text" name="imdb_id" id="imdb_id"></td>
        </tr>
        <tr>
            <td><input type=submit class=submit value="Add movie" onclick="validate()"></td>
            <td><input type=submit class=cancel value="Add movie" onsubmit="validate()"></td>
        </tr>
        </table>
        </form>
        </fieldset>
    </div>
    <?php } 
    else {?>
    <div class="admin-description"><p class="user-data">You're not logged in! If you have admin access please <a href="<?php echo $LOGIN.'index.php?redirect=\''.$currentPage.'\''; ?>">Login</a> to views site statistics, add movies or delete unnecessary comments</p></div>
    <?php } ?>
    </body>
</html> 
