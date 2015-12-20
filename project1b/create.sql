CREATE TABLE Movie(
	id INT NOT NULL,
	title VARCHAR(100) NOT NULL,
	year INT NOT NULL,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY(id), -- Movie id must be unique: primary key
	CHECK (year >= 1000 AND year <= 9999) -- Check to ensure year is 4 digits
) ENGINE = INNODB;

CREATE TABLE Actor(
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	sex VARCHAR(6) NOT NULL,
	dob DATE NOT NULL,
	dod DATE,
	PRIMARY KEY (id), -- Actor id must be unique: primary key
	CHECK (sex = 'Male' OR sex = 'Female') -- Check to ensure sex is 'Male' or 'Female'
) ENGINE = INNODB;

CREATE TABLE Director(
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	dob DATE NOT NULL,
	dod DATE,
	PRIMARY KEY (id) -- Director id must be unique: primary key
) ENGINE = INNODB;

CREATE TABLE MovieGenre(
	mid INT NOT NULL,
	genre VARCHAR(20) NOT NULL,
	FOREIGN KEY(mid) REFERENCES Movie(id) -- mid must reference an existing Movie.id
) ENGINE = INNODB;

CREATE TABLE MovieDirector(
	mid INT NOT NULL,
	did INT NOT NULL,
	FOREIGN KEY(mid) REFERENCES Movie(id), -- mid must reference an existing Movie.id
	FOREIGN KEY(did) REFERENCES Director(id) -- did must reference an existing Director.id
) ENGINE = INNODB;

CREATE TABLE MovieActor(
	mid INT NOT NULL,
	aid INT NOT NULL,
	role VARCHAR(50),
	FOREIGN KEY(mid) REFERENCES Movie(id), -- mid must reference an existing Movie.id
	FOREIGN KEY(aid) REFERENCES Actor(id) -- aid must reference an existing Actor.id
) ENGINE = INNODB;

CREATE TABLE Review(
	name VARCHAR(20),
	time TIMESTAMP NOT NULL,
	mid INT NOT NULL,
	rating INT NOT NULL,
	comment VARCHAR(500),
	FOREIGN KEY(mid) REFERENCES Movie(id), -- mid must reference an existing Movie.id
	CHECK (rating >= 0 AND rating <=10) -- rating must be between 0 and 10, inclusive
) ENGINE = INNODB;

CREATE TABLE MaxPersonID(
	id INT NOT NULL
) ENGINE = INNODB;

CREATE TABLE MaxMovieID(
	id INT NOT NULL
) ENGINE = INNODB;