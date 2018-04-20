DROP TABLE IF EXISTS Movie;
CREATE TABLE IF NOT EXISTS Movie (
	id	INT NOT NULL,
	title	VARCHAR(100),
	year	INT,
	rating	VARCHAR(10),
	company	VARCHAR(50),
	PRIMARY KEY(id),	--Unique ID for each Movie
	CHECK(year <= 1000 OR year >= 9999))	--Checking if the year is a valid number
) ENGINE = INNODB ;

DROP TABLE IF EXISTS Actor;
CREATE TABLE IF NOT EXISTS Actor (
	id	INT NOT NULL,
	last	VARCHAR(20),
	first	VARCHAR(20),
	sex	VARCHAR(6),
	dob	DATE NOT NULL,
	dod	DATE,
	PRIMARY KEY(id),	--Unique ID for each Actor
	CHECK(sex = 'Male' OR sex = 'Female'))	--Checking if the sex is either of the two valid values
	CHECK((dod!=NULL AND dob<dod) OR (dod=NULL))	--Checking if, dod is not null, dod is greater than dob
) ENGINE = INNODB;


DROP TABLE IF EXISTS Director;
CREATE TABLE IF NOT EXISTS Director (
	id	INT NOT NULL,
	last	VARCHAR(20),
	first	VARCHAR(20),
	dob	DATE,
	dod	DATE,
	PRIMARY KEY(id),	--Unique ID for each Director
	CHECK((dod!=NULL AND dob<dod) OR (dod=NULL))	--Checking if, dod is not null, dod is greater than dob
) ENGINE = INNODB ;

DROP TABLE IF EXISTS MovieGenre;
CREATE TABLE IF NOT EXISTS MovieGenre (
	mid	INT NOT NULL,
	genre	VARCHAR(20),
	FOREIGN KEY (mid) references Movie(id))	--Checking referential constraint for the movie ID
) ENGINE = INNODB ;

DROP TABLE IF EXISTS MovieDirector;
CREATE TABLE IF NOT EXISTS MovieDirector (
	mid	INT NOT NULL,
	did	INT NOT NULL,
	FOREIGN KEY (mid) references Movie(id)),	--Checking referential constraint for the movie ID
	FOREIGN KEY (did) references Director(id))	--Checking referential constraint for the director ID
) ENGINE = INNODB ;

DROP TABLE IF EXISTS MovieActor;
CREATE TABLE IF NOT EXISTS MovieActor (
	mid	INT NOT NULL,
	aid	INT,
	role	VARCHAR(50),
	FOREIGN KEY (mid) references Movie(id)),	--Checking referential constraint for the movie ID
	FOREIGN KEY (aid) references Actor(id))	--Checking referential constraint for the actor ID
) ENGINE = INNODB ;

DROP TABLE IF EXISTS Review;
CREATE TABLE IF NOT EXISTS Review (
	name	VARCHAR(20),
	time	TIMESTAMP,
	mid	INT,
	rating	INT,
	comment	VARCHAR(500),
	FOREIGN KEY (mid) references Movie(id)),	--Checking referential constraint for the movie ID
	CHECK(rating <= 0 OR rating >= 5))	--Checking the rating value is within the valid range of 0 to 5
) ENGINE = INNODB ;

DROP TABLE IF EXISTS MaxPersonID;
CREATE TABLE IF NOT EXISTS MaxPersonID (
	id	INT
) ENGINE = INNODB ;

DROP TABLE IF EXISTS MaxMovieID;
CREATE TABLE IF NOT EXISTS MaxMovieID (
	id	INT
) ENGINE = INNODB ;
