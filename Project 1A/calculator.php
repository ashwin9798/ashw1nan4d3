<!DOCTYPE html>
<html>
<body>

<h1>Calculator - CS 143 Project 1A</h1>

<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Calculate: <input type="text" name="expression">
  <input type="submit">
</form>

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // collect value of input field
    if (!array_key_exists('expression', $_REQUEST)) {
      return;
    }
    $name = $_REQUEST['expression'];
    $name_noSpace = str_replace(' ', '', $name);
    if (empty($name_noSpace)) {
        echo "<h2> Result </h2>";
        echo "Expression is empty";
        return;
    } elseif (preg_match('/((\-*)(\d+)([\+\-\*\/]*)+)/', $name_noSpace, $matches)==false) {
        echo "<h2> Result </h2>";
        echo "Invalid Expression!";
        return;
    } elseif (strpos($name_noSpace, '/0')!==false){
      echo "<h2> Result </h2>";
      echo "Division by zero. Error!";
      return;
    } else {
        ob_start();
        eval( '$result = (' . $name_noSpace . ');' );
        echo "<h2> Result </h2>";
        echo "$name : $result";
    }
}
?>

</body>
</html>
