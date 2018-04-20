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
<p>
	<form action="homepage.php" method="GET">
		<textarea name="query" cols="60" rows="1"><?php echo htmlspecialchars($_GET['query']);?></textarea>
		<input type="submit" value="Submit" />
	</form>
</p>

<?php

	$db = new mysqli('localhost', 'cs143', '', 'TEST');

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$user_input=$_GET["query"];
    $user_input = preg_replace('/\s+/', ' ', $user_input);

    $user_input = trim($user_input);
    $user_input = strtoupper($user_input);

    $query_array = str_split($user_input);

    $actor_query = "SELECT DISTINCT * FROM Actor WHERE " . 'upper(CONCAT(first, ' . '\'' . '\'' . ', last)) LIKE \'%%';
    $movie_query = "SELECT DISTINCT * FROM Movie WHERE " . 'upper(title) LIKE \'%%';
    //
    foreach ($query_array as $char) {
        if($char == ' ') {
            $actor_query .=  '%%' . '\'' . ' AND ' . 'upper(CONCAT(first,' . '\'' . '\'' . ', last)) LIKE ' . '\'' . '%%';
            $movie_query .= '%%' . '\'' . ' AND ' . 'upper(title) LIKE ' . '\'' . '%%';
        }
        else {
            $actor_query .= $char;
            $movie_query .= $char;
        }
    }
    $actor_query .= '%%' . '\';';
    $movie_query .= '%%' . '\';';

    printf("ACTORS:");

	if($result = $db->query($actor_query)) {
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

    echo '</br>';

    printf("MOVIES:");

	if($result = $db->query($movie_query)) {
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
			foreach ($column_names as $c) {
				if($row[$c]) {
					echo '<td>', $row[$c], '</td>';
				}
				else {
					echo '<td>', 'N/A', '</td>';
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
