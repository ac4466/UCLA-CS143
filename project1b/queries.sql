SELECT CONCAT(first,' ',last) AS ActorsInDieAnotherDay
FROM Actor, MovieActor
WHERE Actor.id = MovieActor.aid AND MovieActor.mid =
(SELECT id
FROM Movie
WHERE title = 'Die Another Day');
-- Joins Actor and MovieActor and only keeps tuples with matching actor ids and a movie id of 
-- 'Die Another Day'. Then concatenates the first and last names of the tuple, giving the full 
-- names of all the actors in 'Die Another Day'

SELECT COUNT(*) AS ActorsInMultipleMovies
FROM
(SELECT aid
FROM MovieActor
GROUP BY aid
HAVING COUNT(aid) > 1) AS aid_counts;
-- Groups MovieActor by aid and then only keeps aids with count > 1. Then counts the number
-- of tuples left, giving the number of actors in multiple movies

SELECT title AS TomCruiseMovies
FROM Movie, (SELECT mid
FROM MovieActor
WHERE aid =
(SELECT id
FROM Actor
WHERE first = 'Tom' AND last = 'Cruise')) AS temp
WHERE id = mid;
-- Finds id of Tom Cruise in order to find all the movies that he is in. Then joins those movies
-- with the Movie table and keeps only the tuples with the same movie ids. Finally, show only
-- the title of those tuples to get the names of all the movies that Tom Cruise is in.