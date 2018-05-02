<html>
<head>
    <title>Add Movie-Director Relation</title>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/add-styles.css">

        <script src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="css/b-select.min.css">
        <script src="js/b-select.min.js"></script>

</head>
<body>

  <nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="homepage.php">IMDB Clone</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="add_actor_director.php">Add Actor/Director</a></li>
        <li><a href="add_movie.php">Add Movie Information</a></li>
        <li><a href="add_actor_movie_relation.php">Add Movie/Actor Relation</a></li>
        <li><a href="add_director_movie_relation.php">Add Movie/Director Relation</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><form action="homepage.php" method="GET" style="margin-top:10px;">
    		<input type="text" name="query" id="search-box"><?php if (isset($_GET['query'])){};?></input>
    		<input type="submit" value="Search" style="margin-right: 15px;"/></form></li>
      </ul>
    </div>
  </nav>

<br /><br />
<br /><br />

<div class="add-area">
  <div class="panel panel-primary">
    <div class="panel-heading">Add an Movie-Director Relation</div>
    <div class="panel-body">
    <div class="input-fields" id="input-fields">
    <form action="add_director_movie_relation.php" method="GET">
      <div class="title" style="display: flex; flex-flow: row;">
        <span class="input-group-addon" id="basic-addon1" style="width: 20%;">Movie Title: </span>
        <select class="selectpicker" data-live-search="true" onchange="changeTitle()" id="title">
          <option value=""></option>;
            <?php
              $conn = new mysqli('localhost', 'cs143', '', 'TEST');
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $sql = "SELECT DISTINCT title, id FROM Movie ORDER BY title";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<option value=" . $row["id"] . ">" . $row["title"] . "</option>";
                }
              } else {
                echo "0 results";
              }
              $conn->close();
            ?>
        </select>
        <input type="text" id="title-input" name="title" aria-describedby="basic-addon1" style="display: none;">
      </div>
      <br/>
      <div class="director" style="display: flex; flex-flow: row;">
        <span class="input-group-addon" id="basic-addon1" style="width: 12%;">Director: </span>
        <select class="selectpicker" data-live-search="true" onchange="changeDirector()" id="director">
          <option value=""></option>;
            <?php
              $conn = new mysqli('localhost', 'cs143', '', 'TEST');
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $sql = "SELECT CONCAT(first, ' ', last) as name, id FROM Director ORDER BY first";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<option value=" . $row["id"] . ">" . $row["name"] . "</option>";
                }
              } else {
                echo "0 results";
              }
              $conn->close();
            ?>
        </select>
        <input type="text" id="director-input" name="director" aria-describedby="basic-addon1" style="display: none;">
      </div>
      <br/>
      <input class="submit" type="submit" value="Submit" onclick="return validate();"/></form>
    </form>
    </div>
    </div>
  </div>
</div>

<script>
  function validate() {
    let text=document.getElementById("title-input").value;
    if (text=='') {
      alert("Error: No Movie Selected");
    }
  }
  function changeTitle() {
    var list = document.getElementById("title");
    var mid = list.options[list.selectedIndex].value;
    document.getElementById("title-input").value = mid;
  }
  function changeDirector() {
    var list = document.getElementById("director");
    var did = list.options[list.selectedIndex].value;
    document.getElementById("director-input").value = did;
  }
</script>

<?php

	  $db = new mysqli('localhost', 'cs143', '', 'TEST');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $mid = isset($_GET['title']) ? intval($_GET['title']) : '';
    $did = isset($_GET['director']) ? intval($_GET['director']) : '';

    if ($mid!=0) {

      if ($did==0) {
        echo "<span style=\"font-size: 12px; margin: 20%;\"class=\"label label-danger\">Error: No Director selected</span>";
        echo "<br/><br/>";
      }

      $add_ad_query = "INSERT INTO MovieDirector (mid, did) VALUES('$mid', '$did')";

      if($db->query($add_ad_query)) {
          echo "<span style=\"font-size: 18px; margin: 20%;\"class=\"label label-success\">Success: Relation Added</span>";
      }
      else {
        echo "<span style=\"font-size: 18px; margin: 20%;\"class=\"label label-danger\">Error: Could not add Relation</span>";
      }
    }
	$db->close();
?>

</body>
</html>
