function watched(movie_id, user_id, watched_status){
    url     =   "http://localhost/movie_maniac/post/update_watched.php";
    $.post(url, {movie_id: movie_id, user_id: user_id, watched: watched_status}, function(data) {
            if(data=="success"){
                if(watched_status=="not watched") {
                    document.getElementById("user-rating").innerHTML =   "Your rating on the movie: 0 (out of 100) <a class=link onclick=editrating('"+movie_id+"','"+user_id+"','0')> (edit)</a></p>";
                    document.getElementById("watched").innerHTML="Seems like you haven't watched this movie yet, have you? Please confirm!<button onclick=\"watched('"+movie_id+"','"+user_id+"','wanna watch')\">Wanna Watch!</button><button onclick=\"watched('"+movie_id+"','"+user_id+"','watched')\">Watched!</button>";
                }
                else if(watched_status=="watched") {
                    document.getElementById("watched").innerHTML="Seems like you've watched this movie. Please rate it or confirm your watched status!<button onclick=\"watched('"+movie_id+"','"+user_id+"','not watched')\">Haven't watched yet!</button><button onclick=\"watched('"+movie_id+"','"+user_id+"','wanna watch')\">Wanna Watch!</button>";
                }
                else if(watched_status=="wanna watch") {
                    document.getElementById("watched").innerHTML="Seems like you wanted to watch this movie, have you watched it yet? Please confirm!<button onclick=\"watched('"+movie_id+"','"+user_id+"','not watched')\">Remove from Wanna Watch List!</button><button onclick=\"watched('"+movie_id+"','"+user_id+"','watched')\">Watched!</button>";
                }
            }
        });
}
