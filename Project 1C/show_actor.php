<html>
<head><title>Homepage</title></head>
<body>
	<style>
table, td {
border: 1px solid black;
}
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

	$actor_id=$_GET["id"];

    $query = "SELECT DISTINCT mid, title, role, year FROM Movie, MovieActor WHERE aid = $actor_id AND mid = id ORDER BY year;";

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
                if($c == "title") {
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
