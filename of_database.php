<?php 
define("DB_HOST", '172.17.0.3');
define("DB_USER", 'root');
define("DB_PASS", 'root');
define("DB_TABLE", 'sheet');

// define("DB_HOST", 'localhost');
// define("DB_USER", 'root');
// define("DB_PASS", '');
// define("DB_TABLE", 'order');

$conn = mysqli_connect(DB_HOST , DB_USER , DB_PASS , DB_TABLE);
// Check connection

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
 // mysqli_close($conn);

}



 ?>