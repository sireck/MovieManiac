function editnotes(movie_id, user_id, notes_old){
    notes   =   prompt("Please enter the notes you want to enter for this movie", notes_old);
    if(notes != null) {
    url     =   "http://localhost/movie_maniac/post/update_watched.php";
    $.post(url, {movie_id: movie_id, user_id: user_id, notes: notes}, function(data) {
        if(data=="success"){
            document.getElementById("user-notes").innerHTML =   "Your personal notes on the movie: "+notes+" <a class=link onclick=editnotes('"+movie_id+"','"+user_id+"','"+notes+"')> (edit)</a></p>";
        }
        else {
            alert("fail "+data);
        }
    });
    }
}
