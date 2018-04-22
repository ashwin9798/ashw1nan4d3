SELECT CONCAT(actor.first, ' ', actor.last) as DieAnotherDayActors
FROM Actor actor, Movie movie, MovieActor movie_actor
WHERE movie.title='Die Another Day' AND movie.id=movie_actor.mid AND movie_actor.aid=actor.id;

SELECT COUNT(DISTINCT movie_actor.aid) as MultipleMovieActors
FROM MovieActor movie_actor, MovieActor movie_actor2
WHERE movie_actor.aid=movie_actor2.aid AND movie_actor.mid<>movie_actor2.mid;

--All the movies with dead directors

SELECT movie.title as Movies, CONCAT(director.first, ' ', director.last) as name
FROM Movie movie, Director director, MovieDirector movie_director
WHERE director.dod IS NOT NULL AND movie.id=movie_director.mid AND movie_director.did=director.id;
