
<html>
<head><title>Movie/Actor Database Query</title></head>
<body>
	<style>
table, td {
border: 1px solid black;
}
</style>

<h1>Movie/Actor DB Query</h1>
(Project 1B by Nathan Tung)<br /><br />
Please type a MySQL SELECT Query into the box below:

<p>
	<form action="query.php" method="GET">
		<textarea name="query" cols="60" rows="8"><?php echo htmlspecialchars($_GET['query']);?></textarea>
		<input type="submit" value="Submit" />
	</form>
</p>

<p><small>Note: tables and fields are case sensitive. Run "show tables" to see the list of available tables.</small></p>

<?php

	$db = new mysqli('localhost', 'cs143', '', 'TEST');

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}
	$user_query=$_GET["query"];

	if($result = $db->query($user_query)) {
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
		printf("INVALID QUERY");
	}
	$db->close();
?>
</body>
</html>
