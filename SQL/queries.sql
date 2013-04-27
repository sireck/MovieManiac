--
--BEGIN - SEARCH QUERIES--
--

--MOVIE NAME (live search)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre, genre_relationships as g,movie_cast as m,directors as d,(SELECT id,title,mpaa_rating,critic_score,thumbnail_poster, year from movies where title ILIKE '%$movie_name%' ORDER BY critic_score DESC LIMIT 5) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby';

--MOVIE NAME FOR LOGGED USERS (show only non-watched movies)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre, genre_relationships as g,movie_cast as m,directors as d,(SELECT id,title,mpaa_rating,critic_score,thumbnail_poster, year from movies where title ILIKE '%$movie_name%' AND id not in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby'";

--MOVIE NAME FOR LOGGED USERS (show only watched movies)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre, genre_relationships as g,movie_cast as m,directors as d,(SELECT id,title,mpaa_rating,critic_score,thumbnail_poster, year from movies where title ILIKE '%$movie_name%' AND id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby'";

--MOVIE NAME FOR LOGGED USERS (show only wanna watch movies)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre, genre_relationships as g,movie_cast as m,directors as d,(SELECT id,title,mpaa_rating,critic_score,thumbnail_poster, year from movies where title ILIKE '%$movie_name%' AND id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='wanna watch') ORDER BY critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby'";

--MOVIE NAME (broad search)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre, genre_relationships as g,movie_cast as m,directors as d,(SELECT id,title,mpaa_rating,critic_score,thumbnail_poster, year from movies where title ILIKE '%$movie_name%' ORDER BY critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby'";

--GENRE
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre,genre_relationships as g,movie_cast as m,directors as d,(select movies.id, title, critic_score,mpaa_rating, thumbnail_poster, year from genre_relationships as gen_rel, movies, (SELECT id,genre from genre where genre ILIKE '%$genre%') as query where query.id=gen_rel.genre_id AND movies.id=gen_rel.movie_id ORDER BY movies.critic_score DESC LIMIT 5) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby';

--GENRE FOR LOGGED USERS (show only non-watched movies)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre,genre_relationships as g,movie_cast as m,directors as d,(select movies.id, title, critic_score,mpaa_rating, thumbnail_poster, year from genre_relationships as gen_rel, movies, (SELECT id,genre from genre where genre ILIKE '%$genre%') as query where query.id=gen_rel.genre_id AND movies.id=gen_rel.movie_id AND movies.id not in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY movies.critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby';

--GENRE FOR LOGGED USERS (show only watched movies)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre,genre_relationships as g,movie_cast as m,directors as d,(select movies.id, title, critic_score,mpaa_rating, thumbnail_poster, year from genre_relationships as gen_rel, movies, (SELECT id,genre from genre where genre ILIKE '%$genre%') as query where query.id=gen_rel.genre_id AND movies.id=gen_rel.movie_id AND movies.id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY movies.critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby';

--GENRE FOR LOGGED USERS (show only wanna watch movies)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre,genre_relationships as g,movie_cast as m,directors as d,(select movies.id, title, critic_score,mpaa_rating, thumbnail_poster, year from genre_relationships as gen_rel, movies, (SELECT id,genre from genre where genre ILIKE '%$genre%') as query where query.id=gen_rel.genre_id AND movies.id=gen_rel.movie_id AND movies.id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='wanna watch') ORDER BY movies.critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby';

--GENRE (broad search)
SELECT q.title,q.id,thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating, q.critic_score, year from genre,genre_relationships as g,movie_cast as m,directors as d,(select movies.id, title, critic_score,mpaa_rating, thumbnail_poster, year from genre_relationships as gen_rel, movies, (SELECT id,genre from genre where genre ILIKE '%$genre%') as query where query.id=gen_rel.genre_id AND movies.id=gen_rel.movie_id ORDER BY movies.critic_score DESC) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id '$orderby';

--ACTORS(live search)
SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' ORDER BY critic_score DESC LIMIT 5) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id '$orderby'";

--ACTORS FOR LOGGED USERS (show only non-watched movies)
SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' and movies.id not in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY critic_score DESC) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id '$orderby'";

--ACTORS FOR LOGGED USERS (show only watched movies)
SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' and movies.id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY critic_score DESC) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id '$orderby'";

--ACTORS FOR LOGGED USERS (show only non-watched movies)
SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' and movies.id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='wanna watch') ORDER BY critic_score DESC) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id '$orderby'";

--ACTORS (broad search)
SELECT mr.id, mr.title, mr.year, mr.mpaa_rating, mr.critic_score, director_name, mr.actor_name, thumbnail_poster, profile_poster FROM directors as dir, (SELECT id, title, year, mpaa_rating, critic_score, actor_name, thumbnail_poster, profile_poster FROM movie_cast, movies WHERE movies.id = movie_cast.movie_id AND actor_name ILIKE '%$actor_name%' ORDER BY critic_score DESC) AS mr, genre, genre_relationships AS gr WHERE mr.id=gr.movie_id AND dir.id=mr.id AND gr.genre_id=genre.id '$orderby'";

--DIRECTORS(live search)
SELECT title, movies.id, thumbnail_poster, genre, actor_name, director_name, mpaa_rating, critic_score, year from movies,genre_relationships as g,movie_cast as m,genre as gen,(SELECT id,director_name from directors where director_name ILIKE '%$director_name%' LIMIT 5) as q WHERE q.id=g.movie_id and g.genre_id=gen.id and q.id=movies.id and m.movie_id=g.movie_id '$orderby'";

--DIRECTORS FOR LOGGED USERS (show only non-watched movies)
SELECT title, movies.id, thumbnail_poster, genre, actor_name, director_name, mpaa_rating, critic_score, year from movies,genre_relationships as g,movie_cast as m,genre as gen,(SELECT id,director_name from directors where director_name ILIKE '%$director_name%' and id not in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched')) as q WHERE q.id=g.movie_id and g.genre_id=gen.id and q.id=movies.id and m.movie_id=g.movie_id '$orderby'";

--DIRECTORS FOR LOGGED USERS (show only watched movies)
SELECT title, movies.id, thumbnail_poster, genre, actor_name, director_name, mpaa_rating, critic_score, year from movies,genre_relationships as g,movie_cast as m,genre as gen,(SELECT id,director_name from directors where director_name ILIKE '%$director_name%' and id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched')) as q WHERE q.id=g.movie_id and g.genre_id=gen.id and q.id=movies.id and m.movie_id=g.movie_id '$orderby'";

--DIRECTORS FOR LOGGED USERS (show only wanna watch movies)
SELECT title, movies.id, thumbnail_poster, genre, actor_name, director_name, mpaa_rating, critic_score, year from movies,genre_relationships as g,movie_cast as m,genre as gen,(SELECT id,director_name from directors where director_name ILIKE '%$director_name%' and id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='wanna watch')) as q WHERE q.id=g.movie_id and g.genre_id=gen.id and q.id=movies.id and m.movie_id=g.movie_id '$orderby'";

--DIRECTORS (broad search)
SELECT title, movies.id, thumbnail_poster, genre, actor_name, director_name, mpaa_rating, critic_score, year from movies,genre_relationships as g,movie_cast as m,genre as gen,(SELECT id,director_name from directors where director_name ILIKE '%$director_name%') as q WHERE q.id=g.movie_id and g.genre_id=gen.id and q.id=movies.id and m.movie_id=g.movie_id '$orderby'";


--
--END - SEARCH QUERIES --
--


--
-- BEGIN - VIEW QUERIES--
--

--MOVIE DETAILS with ID $id
SELECT q.id, q.title, q.year, q.mpaa_rating, q.runtime, q.theatre_release_date, q.critic_score, q.audience_score, q.synopsis, q.studio, q.thumbnail_poster, q.imdb_id, q.num_user_ratings, genre, actor_name, character, director_name FROM genre, genre_relationships AS g,movie_cast AS m,directors AS d,(SELECT * FROM movies WHERE id='$id') AS q WHERE g.movie_id='$id' AND genre.id=g.genre_id AND m.movie_id='$id' AND d.id='$id';

--RATED MOVIES OF LOGGED IN USER
SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating from genre,genre_relationships as g,movie_cast as m,directors as d,(SELECT * from movies where id in (select movie_id from user_data where user_id='$logged_user_id' ORDER BY rating, movie_id) ORDER BY critic_score DESC LIMIT 10) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id;

--RECOMMENDED MOVIES BASED ON FAVORITE ACTOR OF LOGGED IN USER
SELECT actor_name, count(actor_name) FROM movie_cast, (SELECT user_id, movie_id, rating from user_data WHERE user_id='$logged_user_id' AND watched='watched' ORDER BY rating DESC) AS user_ratings WHERE user_ratings.movie_id = movie_cast.movie_id GROUP BY actor_name ORDER BY count DESC LIMIT 10;

SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating FROM genre, genre_relationships AS g, movie_cast AS m,directors AS d, (SELECT * FROM movies WHERE id in (SELECT id FROM (SELECT movies.id FROM movie_cast, movies WHERE actor_name = '$fav_actor' AND movies.id=movie_cast.movie_id ORDER BY critic_score LIMIT 3) as fav_actors group by id) ORDER BY critic_score DESC LIMIT 10) AS q WHERE g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ORDER BY q.critic_score, q.id;

--RECOMMENDED MOVIES BASED ON FAVORITE DIRECTORS OF LOGGED IN USER
SELECT director_name, count (director_name) FROM directors, (select user_id,movie_id,rating from user_data where user_id='$logged_user_id' AND watched='watched' order by rating DESC) as user_ratings WHERE user_ratings.movie_id = directors.id group by director_name order by count DESC LIMIT 10;

SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating FROM genre, genre_relationships AS g, movie_cast AS m,directors AS d, (SELECT * FROM movies WHERE id in (SELECT id FROM (SELECT movies.id FROM movie_cast, movies WHERE actor_name = '$fav_director' AND movies.id=movie_cast.movie_id ORDER BY critic_score LIMIT 3) as fav_actors group by id) ORDER BY critic_score DESC LIMIT 10) AS q WHERE g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ORDER BY q.critic_score, q.id;

--UPDATE LOGGED IN USER'S WATCHED STATUS OR RATING OR NOTES OF A MOVIE WITH id $movie_id
UPDATE user_data SET watched='$watched', rating='$rating', notes='$notes' WHERE user_id='$user_id' AND movie_id='$movie_id';

--WANNA WATCH LIST OF LOGGED IN USER
SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating from genre,genre_relationships as g,movie_cast as m,directors as d,(SELECT * from movies where id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='wanna watch') ORDER BY critic_score DESC LIMIT 10) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ORDER BY q.critic_score, q.id;

--WATCHED LIST OF LOGGED IN USER
SELECT q.title, q.id, q.year, thumbnail_poster, genre, actor_name, director_name, q.mpaa_rating from genre,genre_relationships as g,movie_cast as m,directors as d,(SELECT * from movies where id in (SELECT movie_id from user_data where user_id='$logged_user_id' AND watched='watched') ORDER BY critic_score DESC LIMIT 10) as q where g.movie_id=q.id AND genre.id=g.genre_id AND m.movie_id=q.id AND d.id=q.id ORDER BY q.critic_score, q.id;

--
--END - VIEW QUERIES --
--

--LOGIN QUERY
SELECT id,username,name,password FROM users WHERE username='$username';

--
--BEGIN - ADMIN QUERIES --
--

--ADD MOVIE
INSERT INTO movies (id, title, year, mpaa_rating, runtime, theatre_release_date, dvd_release_date, critic_score, audience_score, synopsis, studio, thumbnail_poster, profile_poster, imdb_id) VALUES ('$id', '$title', '$year', '$mpaa_rating', '$runtime', '$theatre_release_date', '$dvd_release_date', '$critic_score', '$audience_score', '$synopsis', '$studio', '$thumbnail_poster', '$profile_poster', '$imdb_id');

INSERT INTO genre_relationships VALUES ('$movie_id', '$genre_id');

INSERT INTO directors VALUES ('$movie_id', '$director_name');

INSERT INTO movie_cast VALUES ('$movie_id', '$actor_name', '$character', 'f');

--
--END - ADMIN QUERIES--
--
