function loadLiveSearchView(data,category,search_string){
    if(data!=";;;;;;;;#") {
        movies=data.split("#"); //all movies data in a single javascript array
        html="<div class=search-title><p class=specs><b>search string:</b> "+search_string+" <b>category:</b> "+category+"</p></div>";
        for(i=0;i<movies.length-1;i++) {
            if(movies[i]==";;;;;;;;")
                continue;   
            details     =   movies[i].split(";"); //data of a particular movie in an array
            
            //single movie details
            id          =   details[0];
            title       =   details[1];
            poster      =   details[2];
            genres      =   details[3];
            actors      =   details[4];
            director    =   details[5];
            rating      =   details[6];
            critic_score=   details[7];
            year        =   details[8];
            
            if(critic_score==-1) critic_score = "";
            else critic_score = "<b>Critic score:</b> "+critic_score;
            
            if(title.length > 53) 
                titlecut  =   "...";
            else 
                titlecut   =   "";
                
            if(title!="undefined") {
                html += "<div class=outer onclick=redirect("+id+")><div class=left><img src="+poster+" class=livesearch></div><div class=right><p class=title>"+title.slice(0,50)+titlecut+" ("+year+")</p><p class=genres>Genres: "+genres.replace(/,{2,}/g,',').slice(0,50)+"...</p><p class=actors>Acted by: "+actors.replace(/,{2,}/g,',').slice(0,actors.length-1)+"</p><p class=directors>Directed by: "+director.replace(/,{2,}/g,',').slice(0,director.length-1)+"</p><p class=ratings><b>MPAA rating:</b> "+rating+" "+critic_score+"</p></div></div>";
            }
        }
        url="http://localhost/movie_maniac/views/search.php?search_string="+search_string.split(" ").join("_")+"&category="+category;
        html += "<a href="+url+"><div class=show-all><p class=show-more>Show all results with '<b>"+search_string+"</b>' from '<b>"+category+"s</b>'</p></div></a>"
        return html;
    }
    else return "No valid movies by the search string <b>"+search_string+"</b> in the category <b>"+category+"</b>";
}

function redirect(id) {
    location.href="http://localhost/movie_maniac/views/movie_individual.php?id="+id;
}
