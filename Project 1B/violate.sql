--Violating Primary Key Constraint for Movie relation
--An entry with the key 119 already exists in the table
INSERT INTO Movie VALUES(119, 'Movie-Test', 2018, 'R', 'Test');

--Violating Primary Key Constraint for Actor relation
--An entry with the key 10 already exists in the table
INSERT INTO Actor VALUES(10, 'Actor', 'Test', 'Male', 2000-12-11, 2090-12-11);

--Violating Primary Key Constraint for Director relation
--An entry with the key 2046 already exists in the table
INSERT INTO Director VALUES(2046, 'Director', 'Test', 2000-12-11, 2090-12-11);



--Violating Foreign Key Constraint for MovieGenre relation
--An entry with the key 999999 does not exist in the Movie Table
INSERT INTO MovieGenre VALUES(999999, 'Horror');

--Violating Foreign Key Constraint for MovieDirector relation
--An entry with the key 999999 does not exist in the Movie Table
INSERT INTO MovieDirector VALUES(999999, 2046);

--Violating Foreign Key Constraint for MovieDirector relation
--An entry with the key 999999 does not exist in the Director Table
INSERT INTO MovieDirector VALUES(119, 999999);

--Violating Foreign Key Constraint for MovieActor relation
--An entry with the key 999999 does not exist in the Actor Table
INSERT INTO MovieActor VALUES(119, 999999, 'Bob');

--Violating Foreign Key Constraint for MovieActor relation
--An entry with the key 999999 does not exist in the Movie Table
INSERT INTO MovieActor VALUES(999999, 10, 'Bob');

--Violating Foreign Key Constraint for Review relation
--An entry with the key 999999 does not exist in the Movie Table
INSERT INTO Review VALUES('Die Another Day', 2018-04-19 10:00:00, 999999, 5, 'Pretty Good');



--Violating Check Constraint for Movie relation
--202020 is not a valid year
INSERT INTO Movie VALUES(1, 'Movie-Test', 202020, 'R', 'Test');

--Violating Check Constraint for Actor relation
--dod can't be less than dob
INSERT INTO Actor VALUES(2, 'Actor', 'Test', 'Male', 2090-12-11, 2000-12-11);

--Violating Check Constraint for Director relation
--dod can't be less than dob
INSERT INTO Director VALUES(2046, 'Director', 'Test', 2090-12-11, 2000-12-11);

--Violating Check Constraint for Actor relation
--Sex must be either Male or Female
INSERT INTO Actor VALUES(2, 'Actor', 'Test', 'Bogus', 2090-12-11, 2000-12-11);

--Violating Check Constraint for Review relation
--Rating must be between 0 and 5
INSERT INTO Review VALUES('Die Another Day', 2018-04-19 10:00:00, 119, 20, 'Pretty Good');
