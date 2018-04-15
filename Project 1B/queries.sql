SELECT DISTINCT CONCAT(actor.first, ' ', actor.last)
FROM Actor actor, Movie movie, MovieActor movie_actor
WHERE movie.title='Die Another Day' AND movie.id=movie_actor.mid AND movie_actor.aid=actor.id;

SELECT COUNT(DISTINCT movie_actor.aid)
FROM MovieActor movie_actor, MovieActor movie_actor2
WHERE movie_actor.aid=movie_actor2.aid AND movie_actor.mid<>movie_actor2.mid;

Still need to do one more query