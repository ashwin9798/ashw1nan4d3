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
	<style>
table, td {
border: 1px solid black;
}
</style>

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

<br /><br />
<br /><br />

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

	if($user_input != '' && $result = $db->query($actor_query)) {
        if($result->num_rows > 0) {
            echo '<h1 style="margin-left:5%;"> Actors </h1>';

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
                if($c == "last" || $c == "id" || $c == "sex") {
                    continue;
                }
                if($c == "first") {
                    echo '<td> Name', '</td>';
                }
                else if($c == "dob") {
                    echo '<td>', 'Born', '</td>';
                }
                else if($c == "dod") {
                    echo '<td>', 'Died', '</td>';
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
                    if($c == "sex") {
                        continue;
                    }
                    if($c == "first") {
                        $actor_name = $row[$c] . ' ' . $actor_name;
                        echo '<td><a href="show_actor.php?id=' , $id , '&name=' , $actor_name , '">', $actor_name, '</a></td>';
                    }
                    else {
    				    if($row[$c]) {
    					    echo '<td>', $row[$c], '</td>';
                        }
    				    else {
    					    echo '<td>', '-', '</td>';
    				    }
                    }
    	        }
    			echo '</tr>';
        	}
    		echo '</table>';
            $result->free();
        }
	}

    echo '</br>';

    //TODO: Make movie titles link to the show_movie.php page

	if($user_input != '' && $result = $db->query($movie_query)) {
        if($result->num_rows > 0) {
            echo '<h1 style="margin-left:5%;"> Movies  </h1>';
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
                if($c == "id") {
                    continue;
                }
                if($c == "sex") {
                    continue;
                }
                else {
                    echo '<td>', $c, '</td>';
                }
    		}
    		echo '</tr>';

    		//rows
    		while ($row = $result->fetch_assoc()) {
    			echo '<tr>';
                $movie_name = '';
                $mid = 0;
    			foreach ($column_names as $c) {
                    if($c == "id") {
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
	}
    if($user_input == '') {
        echo '<h1 style="margin-left:5%;"> Search for a Movie or Actor in the search bar above! </h1>';
    }
	$db->close();
?>
</body>
</html>
