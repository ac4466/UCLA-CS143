-- PRIMARY KEY CONSTRAINTS
INSERT INTO Movie VALUES(995, 'Title', 2015, 'PG', 'CS143');
-- Movie table already has tuple with id = 995
-- ERROR 1062 (23000): Duplicate entry '995' for key 'PRIMARY'

INSERT INTO Actor VALUES(999, 'Last', 'First', 'Male', 1993-05-26, NULL);
-- Actor table already has tuple with id = 999
-- ERROR 1062 (23000): Duplicate entry '999' for key 'PRIMARY'

INSERT INTO Director VALUES(974, 'Last', 'First', 1993-05-26, NULL);
-- Director table already has tuple with id = 974
-- ERROR 1062 (23000): Duplicate entry '974' for key 'PRIMARY'

-- FOREIGN KEY CONSTRAINTS
INSERT INTO MovieGenre VALUES(994, 'Action');
-- There is no movie with id = 994
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO MovieDirector VALUES(994, 974);
-- There is no movie with id = 994
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO MovieDirector VALUES(995, 973);
-- There is no director with id = 973
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))

INSERT INTO MovieActor VALUES(994, 999, 'Joey Tribbiani');
-- There is no movie with id = 994
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO MovieActor VALUES(995, 998, 'Chandler Bing');
-- There is no actor with id = 998
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))

INSERT INTO Review VALUES('Aaron', '2015-01-01 12:34:56', 994, 5, 'Good movie');
-- There is no movie with id = 994
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`TEST`.`Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- CHECK CONSTRAINTS
INSERT INTO Movie VALUES (1, 'Title', 20015, 'PG', 'CS143');
-- Year is too large, but MySQL does not enforce

INSERT INTO Actor VALUES (2, 'Last', 'First', 'asdfjk', 1993-05-26, NULL);
-- Sex is invalid, but MySQL does not enforce

INSERT INTO Review VALUES ('Aaron', '2015-01-01 12:34:56', 2, 999, 'Best movie ever!');
-- Rating is too high, MySQL does not enforce