<html>
<head><title>Project 1B - Query Movie Database</title></head>
<body>

Enter a SELECT Query below, or Enter SHOW TABLES to get list of all tables
<p>
	<form action="query.php" method="GET">
		<textarea name="query" cols="60" rows="8"><?php echo htmlspecialchars($_GET['query']);?></textarea>
		<input type="submit" value="Submit" />
	</form>
</p>

<?php

    $db_connection = new mysqli('localhost', 'cs143', '', 'TEST');

    if($db_connection->connect_errno > 0){
        die('Unable to connect to database [' . $db_connection->connect_error . ']');
    }
	$user_query=$_GET["query"];
    $rs = $db_connection->query($user_query);
    $data = array();
 ?>

 <html><body><table border=1 cellspacing=1 cellpadding=2><tr align="center">
     <?php
        $i = 0;
        while($i < mysql_num_fields($rs)) {
            $column = mysql_fetch_field($rs, $i);
            echo '<td><b>' . $column->name . '</b></td>';
            $i = $i + 1;
        }

     ?>
     <tr>
    <?php
        $i = 0;
        while($row = mysql_fetch_row($rs)) {
            echo '<tr align="center">';
		    $count = count($row);
		    $y = 0;
            while($y < $count) {
			    $c_row = current($row);

			    //if any value is NULL (blank), replace it with N/A
			    if($c_row==NULL)
				    echo '<td>N/A</td>';
			    else
				    echo '<td>' . $c_row . '</td>';

			    next($row);
			    $y = $y + 1;
		    }
		    echo '</tr>';
		    $i = $i + 1;
        }
    ?>