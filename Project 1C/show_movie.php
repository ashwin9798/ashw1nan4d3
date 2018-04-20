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

<?php
    echo '<h1>', $_GET["name"], '</h1>';
?>

<br /><br />

<?php

	$db = new mysqli('localhost', 'cs143', '', 'TEST');

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$mid=$_GET["mid"];

    $movie_info_query = 'SELECT DISTINCT year, rating, company FROM Movie WHERE id= ' . $mid . ';';
    $director_query = "SELECT first, last, dob FROM MovieDirector, Director WHERE mid = $mid AND did = id ORDER BY first;";
    $actors_query = "SELECT id, first, last, dob, role FROM Actor, MovieActor WHERE mid = $mid AND aid = id;";

    printf("Movie Info:");
	if($result = $db->query($movie_info_query)) {
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
            if($c == "mid") {
                continue;
            }
			 echo '<td>', $c, '</td>';
		}
		echo '</tr>';

		//rows
		while ($row = $result->fetch_assoc()) {
			echo '<tr>';
            $actor_name = '';
            $mid = 0;
			foreach ($column_names as $c) {
                if($c == "mid") {
                    $mid = $row[$c];
                    continue;
                }
                if($c == "title") {
                    $actor_name = $row[$c] . ' ' . $actor_name;
                    echo '<td><a href="show_movie.php?mid=' . $mid . '">', $actor_name, '</a></td>';
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

    echo '</br>';

    printf("Director:");

    if($result = $db->query($director_query)) {
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
            if($c == "mid") {
                continue;
            }
			 echo '<td>', $c, '</td>';
		}
		echo '</tr>';

		//rows
		while ($row = $result->fetch_assoc()) {
			echo '<tr>';
            $actor_name = '';
            $mid = 0;
			foreach ($column_names as $c) {
                if($c == "mid") {
                    $mid = $row[$c];
                    continue;
                }
                if($c == "title") {
                    $actor_name = $row[$c] . ' ' . $actor_name;
                    echo '<td><a href="show_movie.php?mid=' . $mid . '">', $actor_name, '</a></td>';
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
            if($c == "last" || $c == "id") {
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

	$db->close();
?>
</body>
</html>
