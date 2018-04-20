<html>
<head>
    <title>Homepage</title>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>

    <nav class="navbar navbar-fixed-top navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">IMDB Clone</a>
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

<?php
    echo '<h1>', $_GET["name"], '</h1>';
?>

<br /><br />

<?php

	$db = new mysqli('localhost', 'cs143', '', 'TEST');

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$actor_id=$_GET["id"];

    $query = "SELECT DISTINCT mid, title as Movie, role as Role, year as Year FROM Movie, MovieActor WHERE aid = $actor_id AND mid = id ORDER BY year;";

	if($result = $db->query($query)) {
		$finfo = $result->fetch_fields();
		$row_cnt = $result->num_rows;
		$column_names= array();

		foreach ($finfo as $val) {
            $column_names[] = $val->name;
        }

		//start table
		echo '<table class="table table-hover table-bordered" style="width:90%; margin-left:5%;">';

		//column names (first row)
		echo '<tr>';

		foreach ($column_names as $c) {
            if($c == "mid") {
                continue;
            }
			 echo '<td>', $c, '</td>';
		}
		echo '</tr>';

		//rows
		while ($row = $result->fetch_assoc()) {
			echo '<tr>';
            $movie_name = '';
            $mid = 0;
			foreach ($column_names as $c) {
                if($c == "mid") {
                    $mid = $row[$c];
                    continue;
                }
                if($c == "Movie") {
                    $movie_name = $row[$c];
                    echo '<td><a href="show_movie.php?mid=' , $mid , '&name=' , $movie_name , '">', $movie_name, '</a></td>';
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
	$db->close();
?>
</body>
</html>
