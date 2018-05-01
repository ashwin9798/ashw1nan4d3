<html>
<head>
    <title>Add Actor/Director</title>
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
    <div class="panel-heading">Add an Actor or a Director</div>
    <div class="panel-body">
    <div class="input-fields" id="input-fields">
    <form action="add_actor_director.php" method="GET">
      <div class="act_dict">
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" id="act_dict-tag" name="option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Actor/Director <span class="caret"></span> </button>
          <script>
            function changeOpt(a_d) {
              var sexOpt = document.getElementById("sex-tag");
              if (a_d=="Director") {
                if (sexOpt) {
                  sexOpt.style.display = "none";
                }
              }
              else {
                sexOpt.style.display = "block";
              }
              document.getElementById("act_dict-tag").innerHTML = a_d + " <span class=\"caret\">";
            }
          </script>
          <ul class="dropdown-menu" id="option-ul">
            <li><a onclick='changeOpt("Actor")'>Actor</a></li>
            <li><a onclick='changeOpt("Director")'>Director</a></li>
          </ul>
        </div>
        <input type="text" id="option-input" name="option" aria-describedby="basic-addon1" style="display: none;">
      </div>
      <br/>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">First Name: </span>
        <input type="text" class="form-control" name="first_name" placeholder="First Name" aria-describedby="basic-addon1">
      </div>
      <br/>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Last Name: </span>
        <input type="text" class="form-control" name="last_name" placeholder="Last Name" aria-describedby="basic-addon1">
      </div>
      <br/>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Date of Birth: </span>
        <input type="date" class="form-control" name="dob" placeholder="Date of Birth" aria-describedby="basic-addon1">
      </div>
      <br/>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Date of Death (optional): </span>
        <input type="date" class="form-control" name="dod" placeholder="Date of Death" aria-describedby="basic-addon1">
      </div>
      <br/>
      <div class="sex">
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" name="sex" id="sex-tag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Sex <span class="caret"></span> </button>
          <script>
            function changeSex(sex) {
              document.getElementById("sex-tag").innerHTML = sex + " <span class=\"caret\">";
            }
          </script>
          <ul class="dropdown-menu" id="sex-ul">
            <li><a onclick='changeSex("Male")'>Male</a></li>
            <li><a onclick='changeSex("Female")'>Female</a></li>
          </ul>
        </div>
        <input type="text" id="sex-input" name="sex" aria-describedby="basic-addon1" style="display: none;">
      </div>
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
  var ul1 = document.getElementById("option-ul");
  ul1.onclick = function(event) {
    var target = getEventTarget(event);
    document.getElementById("option-input").value = target.innerHTML;
  };
  var ul2 = document.getElementById("sex-ul");
  ul2.onclick = function(event) {
    var target = getEventTarget(event);
    document.getElementById("sex-input").value = target.innerHTML;
  };
</script>

<?php

	  $db = new mysqli('localhost', 'cs143', '', 'TEST');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    $option=$_GET["option"];
    if ($option=="") {
      exit;
    }
    $first=$_GET["first_name"];
    $last=$_GET["last_name"];
    $dob=$_GET["dob"];
    $dod=$_GET["dod"];
    if ($option=="Actor") {
      $sex=$_GET["sex"];
    }

    if ($option=="Actor") {

      if ($first=='') {
        echo "<script type='text/javascript'>alert('First Name Field Empty!');</script>";
        exit;
      }
      if ($last=='') {
        echo "<script type='text/javascript'>alert('Last Name Field Empty!');</script>";
        exit;
      }
      if ($dob=='') {
        echo "<script type='text/javascript'>alert('Date of Birth Field Empty!');</script>";
        exit;
      }
      if ($sex=='') {
        echo "<script type='text/javascript'>alert('Sex Field Empty!');</script>";
        exit;
      }

      $sql = "SELECT * FROM MaxPersonID";
      $result = ($db->query($sql))->fetch_assoc();
      $curr_MaxID = $result["id"];
      $new_MaxID = intval($curr_MaxID + 1);

      if ($dod=='') {
        $dod="NULL";
        $add_ad_query = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES('$new_MaxID', '$last', '$first', '$sex', '$dob', $dod)";
      }
      else {
        $add_ad_query = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES('$new_MaxID', '$last', '$first', '$sex', '$dob', '$dod')";
      }
      if($db->query($add_ad_query)) {
          echo "<span style=\"font-size: 18px; margin: 5%;\"class=\"label label-success\">Success: Actor Added</span>";

          $sql = "UPDATE MaxPersonID SET id=" . $new_MaxID;
          if ($db->query($sql) === FALSE) {
            echo "<span style=\"font-size: 18px; margin: 5%;\"class=\"label label-danger\">Error: Max Person ID not updated</span>";
          }
      }
    }

    else {
      if ($first=='') {
        echo "<script type='text/javascript'>alert('First Name Field Empty!');</script>";
        exit;
      }
      if ($last=='') {
        echo "<script type='text/javascript'>alert('Last Name Field Empty!');</script>";
        exit;
      }
      if ($dob=='') {
        echo "<script type='text/javascript'>alert('Date of Birth Field Empty!');</script>";
        exit;
      }

      $sql = "SELECT * FROM MaxPersonID";
      $result = ($db->query($sql))->fetch_assoc();
      $curr_MaxID = $result["id"];
      $new_MaxID = intval($curr_MaxID + 1);

      if ($dod=='') {
        $dod="NULL";
        $add_ad_query = "INSERT INTO Director (id, last, first, dob, dod) VALUES('$new_MaxID', '$last', '$first', '$dob', $dod)";
      }
      else {
        $add_ad_query = "INSERT INTO Director (id, last, first, dob, dod) VALUES('$new_MaxID', '$last', '$first', '$dob', '$dod')";
      }
      if($db->query($add_ad_query)) {
          echo "<span style=\"font-size: 18px; margin: 20%;\"class=\"label label-success\">Success: Director Added</span>";

          $sql = "UPDATE MaxPersonID SET id=" . $new_MaxID;
          if ($db->query($sql) === FALSE) {
            echo "<span style=\"font-size: 18px; margin: 20%;\"class=\"label label-danger\">Error: Max Person ID not updated</span>";
          }
      }
    }
	$db->close();
?>

</body>
</html>
