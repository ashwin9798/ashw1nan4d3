<html>
<head>
    <title>About Movie</title>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
</style>

<br /><br />


    <nav class="navbar navbar-fixed-top navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="homepage.php">IMDB Clone</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="add_actor_director.php">Add Actor/Director</a></li>
          <li><a href="add_movie.php">Add Movie Information</a></li>
          <li><a href="add_actor_movie_relation.php">Add Movie/Actor Relation</a></li>
          <li><a href="add_director_movie_relation.php">Add Movie/Director Relation</a></li>
          <li><form action="homepage.php" method="GET" style="margin-top:10px;">
      		<input type="text" name="query" style="margin-left: 50px; width: 300px"><?php ($_GET['query']);?></input>
      		<input type="submit" value="Search" /></form></li>
        </ul>
      </div>
    </nav>
</br>

    <?php
        echo '<h1 style="margin-left: 3%;">', $_GET["name"], '</h1>';
        echo '<hr style="width:95%;">';
    ?>


<?php

	$db = new mysqli('localhost', 'cs143', '', 'TEST');

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$mid=$_GET["mid"];

    $movie_info_query = 'SELECT DISTINCT year, rating, company FROM Movie WHERE id= ' . $mid . ';';
    $director_query = "SELECT first, last, dob FROM MovieDirector, Director WHERE mid = $mid AND did = id ORDER BY first;";
    $genre_query = "SELECT genre from MovieGenre WHERE mid=$mid";
    $actors_query = "SELECT id, first, last, dob, role FROM Actor, MovieActor WHERE mid = $mid AND aid = id;";

	if($result = $db->query($movie_info_query)) {
		$finfo = $result->fetch_fields();
		$row_cnt = $result->num_rows;
		$column_names= array();

		foreach ($finfo as $val) {
            $column_names[] = $val->name;
        }

		//start table
		echo '<table class="table table-bordered" style="width:90%; margin-left:5%;">';
		//rows
		while ($row = $result->fetch_assoc()) {
            $actor_name = '';
            $mid = 0;
			foreach ($column_names as $c) {
                if($c == "year") {
                    echo '<p style="margin-left: 5%;"> Year Released: ', $row[$c], '</p>';
                    continue;
                }
                if($c == "rating") {
                    echo '<p style="margin-left: 5%;"> MPAA Rating: ', $row[$c], '</p>';
                    continue;
                }
                if($c == "company") {
                    echo '<p style="margin-left: 5%;"> Producer: ', $row[$c], '</p>';
                    continue;
                }
	        }
    	}
        $result->free();
	}
    else {
        printf("Couldn't do this for some reason");
    }

    if($result = $db->query($director_query)) {
		$finfo = $result->fetch_fields();
		$row_cnt = $result->num_rows;
		$column_names= array();

		foreach ($finfo as $val) {
            $column_names[] = $val->name;
        }
		//rows
		while ($row = $result->fetch_assoc()) {
            $director_name = '';
            $director_dob = '';
			foreach ($column_names as $c) {
                if($c == "first") {
                    $director_name .= $row[$c] . ' ';
                    continue;
                }
                if($c == "last") {
                    $director_name .= $row[$c];
                    continue;
                }
                if($c == "dob") {
                    $director_dob .= $row[$c];
                    continue;
                }
	        }
			echo '<p style="margin-left: 5%;"> Directed by: ', $director_name, ' (', $director_dob, ')', '</p>';
    	}
        $result->free();
	}
    else {
        printf("Couldn't do this for some reason");
    }

    if($result = $db->query($genre_query)) {
		while ($row = $result->fetch_assoc()) {
            $genre = $row['genre'];
    	}
        echo '<p style="margin-left: 5%;"> Genre: ', $genre, '</p>';
        $result->free();
	}
    else {
        printf("Couldn't do this for some reason");
    }


    echo '<hr style="width:90%;">';
    echo '<h3 style="margin-left: 5%">Actors in this Movie</h3>';

    if($result = $db->query($actors_query)) {
		$finfo = $result->fetch_fields();
		$row_cnt = $result->num_rows;
		$column_names= array();

		foreach ($finfo as $val) {
            $column_names[] = $val->name;
        }

		//start table
		echo '<table class="table table-bordered" style="width:90%; margin-left:5%;">';

		//column names (first row)
		echo '<tr>';

		foreach ($column_names as $c) {
            if($c == "last" || $c == "id" || $c == "dob") {
                continue;
            }
            if($c == "first") {
                echo '<td> Name', '</td>';
            }
            else {
			    echo '<td>', $c, '</td>';
            }
		}
		echo '</tr>';

		//rows
		while ($row = $result->fetch_assoc()) {
			echo '<tr>';
            $actor_name = '';
            $mid = 0;
			foreach ($column_names as $c) {
                if($c == "dob") {
                    continue;
                }
                if($c == "first") {
                    $actor_name .= $row[$c];
                    continue;
                }
                if($c == "id") {
                    $id = $row[$c];
                    continue;
                }
                if($c == "last") {
                    $actor_name  .= ' ' . $row[$c];
                    echo '<td><a href="show_actor.php?id=' , $id , '&name=' , $actor_name , '">', $actor_name, '</a></td>';
                }
                else {
				    if($row[$c]) {
					    echo '<td>', $row[$c], '</td>';
                    }
				    else {
					    echo '<td>', 'N/A', '</td>';
				    }
                }
	        }
			echo '</tr>';
    	}
		echo '</table>';
        $result->free();
	}
    else {
        printf("Couldn't do this for some reason");
    }

    //TODO: Comments, adding and viewing them

	$db->close();
?>
</body>
</html>
