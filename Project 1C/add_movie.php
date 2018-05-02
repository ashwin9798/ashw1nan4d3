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

        <link href="css/boot-select.min.css" rel="stylesheet">
        <script type="text/javascript" src="js/boot-select.min.js"></script>


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
        <input type="text" class="form-control" name="title" placeholder="Title" id="title" aria-describedby="basic-addon1">
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
        <select class="selectpicker" multiple data-selected-text-format="count" onchange="changeGenres()" id="genre">
          <option>Action</option>
          <option>Adult</option>
          <option>Adventure</option>
          <option>Animation</option>
          <option>Comedy</option>
          <option>Crime</option>
          <option>Documentary</option>
          <option>Drama</option>
          <option>Family</option>
          <option>Fantasy</option>
          <option>Horror</option>
          <option>Musical</option>
          <option>Mystery</option>
          <option>Romance</option>
          <option>Sci-Fi</option>
          <option>Short</option>
          <option>Thriller</option>
          <option>War</option>
          <option>Western</option>
        </select>
        <input type="text" id="genre-input" name="genre" aria-describedby="basic-addon1" style="display: none;">
      </div>
      <br/>
      <br/>
      <input class="submit" type="submit" value="Submit" onclick="return validate();"/>
      <br/>
    </form>
    </div>
    </div>
  </div>
</div>

<script>
  function validate() {
    let text=document.getElementById("title").value;
    if (text=='') {
      alert("Error: Title Field Empty");
    }
  }

  function getEventTarget(e) {
      e = e || window.event;
      return e.target || e.srcElement;
  }
  var ul1 = document.getElementById("rating-ul");
  ul1.onclick = function(event) {
    var target = getEventTarget(event);
    document.getElementById("rating-input").value = target.innerHTML;
  };

  function changeGenres() {
    var genres_list= $('.selectpicker').val()
    var text = document.getElementById('genre-input');
    text.value= "";
    for (i = 0; i < genres_list.length; i++) {
      text.value += genres_list[i] + " ";
    }
  }

</script>

<?php

	  $db = new mysqli('localhost', 'cs143', '', 'TEST');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    $title = isset($_GET['title']) ? addslashes($_GET['title']) : '';
    $year = isset($_GET['year']) ? $_GET['year'] : '';
    $rating = isset($_GET['rating']) ? $_GET['rating'] : '';
    $company = isset($_GET['company']) ? addslashes($_GET['company']) : '';
    $genre = isset($_GET['genre']) ? $_GET['genre'] : '';
    $genres_list=explode(' ',$genre);

    if ($title!='') {

      if ($company=='') {
        echo "<a href=\"add_movie.php\"><span style=\"font-size: 12px; margin: 20%;\"class=\"label label-danger\">Error: Company Field Empty</span></a>";
        echo "<br/><br/>";
      }

      if ($year=='') {
        echo "<a href=\"add_movie.php\"><span style=\"font-size: 12px; margin: 20%;\"class=\"label label-danger\">Error: Year Field Empty</span></a>";
        echo "<br/><br/>";
      }

      if ($rating=='') {
        echo "<a href=\"add_movie.php\"><span style=\"font-size: 12px; margin: 20%;\"class=\"label label-danger\">Error: Rating Field Empty</span></a>";
        echo "<br/><br/>";
      }

      $validateYear = intval($year);
      if ($validateYear>=1000 && $validateYear<=9999) {}
      else {
        echo '<script type="text/javascript">alert("Year must be a number between 1000 and 9999");</script>';
      }

      $sql = "SELECT * FROM MaxMovieID";
      $result = ($db->query($sql))->fetch_assoc();
      $curr_MaxID = $result["id"];
      $new_MaxID = intval($curr_MaxID + 1);

      $add_ad_query = "INSERT INTO Movie (id, title, year, rating, company) VALUES('$new_MaxID', '$title', '$year', '$rating', '$company')";

      if($db->query($add_ad_query)) {

        $sql = "UPDATE MaxMovieID SET id=" . $new_MaxID;
        if ($db->query($sql) === FALSE) {
          echo "<a href=\"add_movie.php\"><span style=\"font-size: 18px; margin: 20%;\"class=\"label label-danger\">Error: Max Movie ID not updated</span></a>";
          echo "<br/><br/>";
        }

        foreach ($genres_list as $g)
        {
          if ($g!='') {
            $add_ad_query2 = "INSERT INTO MovieGenre (mid, genre) VALUES('$new_MaxID', '$g')";
            if(!($db->query($add_ad_query2))) {
              echo $db->error;
            }
          }
        }
        echo "<a href=\"add_movie.php\"><span style=\"font-size: 18px; margin: 20%;\"class=\"label label-success\">Success: Movie Added</span>";
        echo "<br/><br/>";
      }
      else {
        echo "<a href=\"add_movie.php\"><span style=\"font-size: 18px; margin: 20%;\"class=\"label label-danger\">Error: Could not add Movie</span></a>";
      }
    }
	$db->close();
?>

</body>
</html>
