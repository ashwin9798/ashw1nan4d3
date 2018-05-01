<html>
<head>
    <title>Add Movie</title>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/add-styles.css">

        <script src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

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
    <div class="panel-heading">Add a Movie</div>
    <div class="panel-body">
    <div class="input-fields" id="input-fields">
    <form action="add_movie.php" method="GET">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Title: </span>
        <input type="text" class="form-control" name="title" placeholder="Title" aria-describedby="basic-addon1">
      </div>
      <br/>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Company: </span>
        <input type="text" class="form-control" name="company" placeholder="Company" aria-describedby="basic-addon1">
      </div>
      <br/>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Year: </span>
        <input type="text" class="form-control" name="year" placeholder="Year" aria-describedby="basic-addon1">
      </div>
      <br/>
      <div class="rating">
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" id="rating" name="rating" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> MPAA Rating <span class="caret"></span> </button>
          <script>
            function changeOpt(opt) {
              document.getElementById("rating").innerHTML = opt + " <span class=\"caret\">";
            }
          </script>
          <ul class="dropdown-menu" id="rating-ul">
            <li><a onclick='changeOpt("G")'>G</a></li>
            <li><a onclick='changeOpt("NC-17")'>NC-17</a></li>
            <li><a onclick='changeOpt("PG")'>PG</a></li>
            <li><a onclick='changeOpt("PG-13")'>PG-13</a></li>
            <li><a onclick='changeOpt("R")'>R</a></li>
            <li><a onclick='changeOpt("surrendere")'>surrendere</a></li>
          </ul>
        </div>
        <input type="text" id="rating-input" name="rating" aria-describedby="basic-addon1" style="display: none;">
      </div>
      <br/>
      <div class="genre">
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" name="genre" id="genre-tag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Genre <span class="caret"></span> </button>
          <script>
            function changeGenre(genre) {
              document.getElementById("genre-tag").innerHTML = genre + " <span class=\"caret\">";
            }
          </script>
          <ul class="dropdown-menu" id="genre-ul">
            <li><a onclick='changeGenre("Action")'>Action</a></li>
            <li><a onclick='changeGenre("Adult")'>Adult</a></li>
            <li><a onclick='changeGenre("Adventure")'>Adventure</a></li>
            <li><a onclick='changeGenre("Animation")'>Animation</a></li>
            <li><a onclick='changeGenre("Comedy")'>Comedy</a></li>
            <li><a onclick='changeGenre("Crime")'>Crime</a></li>
            <li><a onclick='changeGenre("Documentary")'>Documentary</a></li>
            <li><a onclick='changeGenre("Drama")'>Drama</a></li>
            <li><a onclick='changeGenre("Family")'>Family</a></li>
            <li><a onclick='changeGenre("Fantasy")'>Fantasy</a></li>
            <li><a onclick='changeGenre("Horror")'>Horror</a></li>
            <li><a onclick='changeGenre("Musical")'>Musical</a></li>
            <li><a onclick='changeGenre("Mystery")'>Mystery</a></li>
            <li><a onclick='changeGenre("Romance")'>Romance</a></li>
            <li><a onclick='changeGenre("Sci-Fi")'>Sci-Fi</a></li>
            <li><a onclick='changeGenre("Short")'>Short</a></li>
            <li><a onclick='changeGenre("Thriller")'>Thriller</a></li>
            <li><a onclick='changeGenre("War")'>War</a></li>
            <li><a onclick='changeGenre("Western")'>Western</a></li>
          </ul>
        </div>
        <input type="text" id="genre-input" name="genre" aria-describedby="basic-addon1" style="display: none;">
      </div>
      <br/>
      <br/>
      <input class="submit" type="submit" value="Submit" /></form>
    </form>
    </div>
    </div>
  </div>
</div>

<script>
  function getEventTarget(e) {
      e = e || window.event;
      return e.target || e.srcElement;
  }
  var ul1 = document.getElementById("rating-ul");
  ul1.onclick = function(event) {
    var target = getEventTarget(event);
    document.getElementById("rating-input").value = target.innerHTML;
  };
  var ul2 = document.getElementById("genre-ul");
  ul2.onclick = function(event) {
    var target = getEventTarget(event);
    document.getElementById("genre-input").value = target.innerHTML;
  };
</script>

<?php

	  $db = new mysqli('localhost', 'cs143', '', 'TEST');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    $title=$_GET["title"];
    $year=$_GET["year"];
    $rating=$_GET["rating"];
    $company=$_GET["company"];

    if ($title!='') {

      if ($year=='') {
        echo "<script type='text/javascript'>alert('Year Field Empty!');</script>";
        exit;
      }
      if ($rating=='') {
        echo "<script type='text/javascript'>alert('Rating Field Empty!');</script>";
        exit;
      }
      if ($company=='') {
        echo "<script type='text/javascript'>alert('Company Field Empty!');</script>";
        exit;
      }

      $sql = "SELECT * FROM MaxMovieID";
      $result = ($db->query($sql))->fetch_assoc();
      $curr_MaxID = $result["id"];
      $new_MaxID = intval($curr_MaxID + 1);


      $add_ad_query = "INSERT INTO Movie (id, title, year, rating, company) VALUES('$new_MaxID', '$title', '$year', '$rating', '$company')";

      if($db->query($add_ad_query)) {
          echo "<span style=\"font-size: 18px; margin: 20%;\"class=\"label label-success\">Success: Movie Added</span>";

          $sql = "UPDATE MaxMovieID SET id=" . $new_MaxID;
          if ($db->query($sql) === FALSE) {
            echo "<span style=\"font-size: 18px; margin: 20%;\"class=\"label label-danger\">Error: Max Movie ID not updated</span>";
          }
      }
    }
	$db->close();
?>

</body>
</html>
