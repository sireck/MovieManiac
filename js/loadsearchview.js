function loadSearchView(data, category, search_string, page){
    if(data!=";;;;;;;;#") {
        movies=data.split("#"); //all movies data in a single javascript array
        html="<div class=search-view-title><p class=specs><b>search string:</b> "+search_string+" <b>category:</b> "+category+"</p><p class=totals>Total results : "+(movies.length-1)+" displaying 20 results per page</p></div>";
            min=(parseInt(page))*20;
            max=min+ 20;
        for(i=0;i<movies.length-1;i++) {
            
            if(i<min) {
                continue;
            }
            else if(i>max){
                break;
            }
            else if(i>=min && i<max && i<movies.length-1) {
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
                if(title!="undefined") {
                    html += "<div class=search-outer onclick=redirect("+id+")><div class=left><img src="+poster+" class=search-image></div><div class=right><p class=title>"+title+" ("+year+")</p><p class=genres>Genres: "+genres.replace(/,{2,}/g,',').slice(0,genres.length-1)+"</p><p class=actors>Acted by: "+actors.replace(/,{2,}/g,',').slice(0,actors.length-1)+"</p><p class=directors>Directed by: "+director.replace(/,{2,}/g,',').slice(0,director.length-1)+"</p><p class=ratings><b>MPAA rating:</b> "+rating+" "+critic_score+"</p></div></div>";
                }
            }
        }
        return html;
    }
    else return "<br /><br /><br /><br />No valid movies by the search string <b>"+search_string+"</b> in the category <b>"+category+"</b>";
}

function redirect(id) {
    location.href="http://localhost/movie_maniac/views/movie_individual.php?id="+id;
}
