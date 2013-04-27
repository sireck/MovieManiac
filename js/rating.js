function editrating(movie_id, user_id, rating_old){
    watched(movie_id, user_id, 'watched');
    flag    =   true;
    while(flag) {
        rating  =   prompt("Please enter the rating you want to enter for this movie(out of 100)", rating_old);
        if(rating==null)
            break;
        if(isNaN(rating))
            falg    =   true;
        else if(rating>100 || rating<0) 
            flag    =   true;
        else 
            flag    =   false;
    }
    
    if(rating != null) {
    url     =   "http://localhost/movie_maniac/post/update_watched.php";
    $.post(url, {movie_id: movie_id, user_id: user_id, rating: rating}, function(data) {
        if(data=="success"){
            document.getElementById("user-rating").innerHTML =   "Your rating on the movie: "+rating+" (out of 100) <a class=link onclick=editrating('"+movie_id+"','"+user_id+"','"+rating+"')> (edit)</a></p>";
        }
        else {
            alert("fail "+data);
        }
    });
    }
}
