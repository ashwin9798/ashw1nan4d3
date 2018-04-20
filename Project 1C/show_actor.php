<html>
<head><title>Homepage</title></head>
<body>
	<style>
table, td {
border: 1px solid black;
}
</style>

<h1>Search Actors, Directors, anything Movie Related!</h1>
<br /><br />

<?php

	$db = new mysqli('localhost', 'cs143', '', 'TEST');

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$actor_id=$_GET["id"];

    //Query will take actor id and output the movie title and the role that that actor played
    $query = "SELECT movie.title as Title, movie_actor.role as Role FROM Movie movie, MovieActor movie_actor WHERE " . 'movie_actor.aid=' . $actor_id . ';';

    printf($query);

	if($result = $db->query($query)) {
		$finfo = $result->fetch_fields();
		$row_cnt = $result->num_rows;
		$column_names= array();

		foreach ($finfo as $val) {
            $column_names[] = $val->name;
        }

		//start table
		echo '<table>';

		//column names (first row)
		echo '<tr>';

		foreach ($column_names as $c) {
			 echo '<td>', $c, '</td>';
		}
		echo '</tr>';

		//rows
		while ($row = $result->fetch_assoc()) {
			echo '<tr>';
            $actor_name = '';
            $id = 0;
			foreach ($column_names as $c) {
                if($c == "last") {
                    $actor_name .= $row[$c];
                    continue;
                }
                if($c == "id") {
                    $id = $row[$c];
                    continue;
                }
                if($c == "first") {
                    $actor_name = $row[$c] . ' ' . $actor_name;
                    echo '<td><a href="show_actor.php?id=' . $id . '">', $actor_name, '</a></td>';
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
