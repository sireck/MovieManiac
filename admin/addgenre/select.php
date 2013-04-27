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
            $id             =   base64_decode($_GET['key']);
            $genres         =   get_genres();
            $movie_details  =   get_movie_details($id);
            echo $id;
        ?>        
        <title>Movie Mania - Online Movie Recommender - Select Genre - Admin</title>
        <script type="text/javascript">
        function validate(){
            var director_name   =   document.getElementById('director_name').value;
	        var movie_cast      =   document.getElementById('movie_cast').value;
	        
	        if(director_name == '') {
		        document.getElementById('director_name_error').innerHTML = "<span style='color:red'>Director Name field cannot be left blank</span>";
		        document.getElementById('director_name_error').style.display='block';
                document.getElementById('director_name').focus();
                document.getElementById('director_name').style.border='1px solid red';
            }
	        else if(movie_cast == '') {
		        document.getElementById('movie_cast_error').innerHTML = "<span style='color:red'>Movie Cast field cannot be left blank</span>";
		        document.getElementById('movie_cast_error').style.display = 'block';
                document.getElementById('movie_cast').focus();
                document.getElementById('movie_cast').style.border='1px solid red';
            }
            else
                document.forms['movie-details'].submit();
        }
        
        function changeColor(checked,id) {
            if(checked==true) {
                document.getElementById(id).style.background    =   '#3B5998';
                document.getElementById(id).style.color         =   'white';
            }
            else if(checked==false) {
                document.getElementById(id).style.background    =   'white';
                document.getElementById(id).style.color         =   'black';
            }
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
        <div class="select-genre">
            <p class="title"><?php echo "Please select Genres for the movie <b>".$movie_details['title']." (".$movie_details['year'].")</b>"; ?></p>
    <?php
        echo "<form action='./genre.php' method='post' id='movie-details' onsubmit='validate()'><div class=genre-row>";
        for($i=0;$i<count($genres);$i++) { 
            if($i%6==0) echo "</div><div class=genre-row>";
            else {?>
            <label class=genre-name id="<?php echo 'genre-name'.$genres[$i][0]; ?>"><input type="checkbox" value="<?php echo $genres[$i][0]; ?>" name="genre[]" onclick="changeColor(this.checked,'<?php echo 'genre-name'.$genres[$i][0]; ?>')"/><?php echo $genres[$i][1]; ?></label>
    <?php }} ?>
        </div>
        <div class=actor-row>
        <p class="info">Please write the director name(s) seperated by SEMICOLON(;) if there are more than one and the actor names and corresponding characters in braces '(actor name:character)' seperated by SEMICOLON(;) if there are more than one; Example: (Mandy Moore:Jamie Sullivan)</p>
        <table>
            <tr>
                <td class="left"><label for="director_name">Director Name(s)<span class='required'> *</span> </td>
                <td>
                    <input type="text" name="director_name" id="director_name" onkeyup="this.style.border='1px solid green'; document.getElementById('director_name_error').style.display='none';">
                    <div id="director_name_error" class="error" style="display: none;"></div>
                </td>
            </tr>
            <tr>
                <td class="left"><label for="movie_cast">Movie Cast<span class='required'> *</span> </td>
                <td>
                    <input type="text" name="movie_cast" id="movie_cast" onkeyup="this.style.border='1px solid green'; document.getElementById('movie_cast_error').style.display='none';">
                    <div id="movie_cast_error" class="error" style="display: none;"></div>
                </td>
            </tr>
        </table>
        </div>
        <div class=genre-row>
            <input type="hidden" value="<?php echo $id; ?>" name="movie_id" />
            <input type='button' onclick="validate()" value=' Save Changes' />
            <input type="button" onclick="location.href='../index.php'" value="Cancel" />
        </div>
    </form>
    </div>
    <?php }
    else {?>
    <div class="admin-description"><p class="user-data">You're not logged in! If you have admin access please <a href="<?php echo $LOGIN.'index.php?redirect=\''.$currentPage.'\''; ?>">Login</a> to views site statistics, add movies or delete unnecessary comments</p></div>
    <?php } ?>
    </body>
</html> 
