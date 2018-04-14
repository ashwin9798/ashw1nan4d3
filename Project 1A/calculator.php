<!DOCTYPE html>
<html>
<body>

<h1>Calculator - CS 143 Project 1A</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Calculate: <input type="text" name="expression">
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_REQUEST['expression'];
    if (empty($name)) {
        echo "expression is empty";
    } else {
        ob_start();
        eval( '$result = (' . $name . ');' );
        ob_start();
        if ('' !== $error = ob_get_clean()) {
            echo "akjsdhkajs";
        }

        echo $result;
    }
}
?>

</body>
</html>
