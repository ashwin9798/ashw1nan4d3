<?php

$movie_id = $_GET["id"];


?>

<html>
<head>
    <title>Add Review</title>
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
</style>

<br /><br />


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
</br>

    <?php
        $movie_name = $_GET["name"];
        $mid=$_GET["mid"];
        echo '<h1 style="margin-left: 3%;"> Write a review for ', $movie_name, '</h1>';
        echo '<hr style="width:95%;">';
    ?>

    <form action="add_comments.php" method="GET" style="margin-top:10px;">
      <input type="hidden" name="mid" value="<?=$mid;?>" />
      <input type="hidden" name="name" value="<?=$movie_name;?>" />
      <p style="margin-left: 5%"><b>Your name:<b></p>
      <input type="text" name="username" style="margin-left: 5%; width: 20%" placeholder="Optional (Leave blank for Anonymous Review)">
      </br></br>
      <p style="margin-left: 5%"><b>Rating:<b></p>
      <select class="form-control" name="score" id="rating" style="margin-left: 5%; width: 20%">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
    </select>
    </br>
    <p style="margin-left: 5%"><b>Comments:<b></p>
      <textarea id="comment" style="margin-left: 5%; width: 40%;" class="form-control" name="comment" rows="5" placeholder="no more than 500 characters"></textarea>
</br>
      <input style="margin-left: 5%" type="submit" value="Add Review!" onclick="return validate();"/></form>

<script>
  function validate() {
    let text=document.getElementById("comment").value;
    if (text=='') {
      alert("Error: Comment Field Empty");
    }
  }
</script>

<?php

	$db = new mysqli('localhost', 'cs143', '', 'TEST');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $score = isset($_GET['score']) ? $_GET['score'] : '';
    $comment = isset($_GET['comment']) ? addslashes($_GET['comment']) : '';
    $username = isset($_GET['username']) ? $_GET['username'] : '';

    if($score && $comment) {
        if($username == '') {
            $username = "Anonymous";
        }
        $add_comment_query = "INSERT INTO Review (name, time, mid, rating, comment) VALUES('$username', now(), '$mid', '$score', '$comment')";

        if($result = $db->query($add_comment_query)) {
            echo '<a href="show_movie.php?mid=', $mid, '&name=', $movie_name, '"> SUCCESS! Head back to see your comment!</a>';
        }
        else {
            printf("failed");
        }

    }
    else {
        if(!$comment) {
            echo '';
        }
    }
	$db->close();
?>
</body>
</html>
