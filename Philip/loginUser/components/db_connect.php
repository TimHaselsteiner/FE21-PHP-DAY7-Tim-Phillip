<?php 
require_once "db_classes.php";

$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "dbhotel";


$db = new Database($localhost, $username, $password, $dbname);


// // create connection
// $connect = new  mysqli($localhost, $username, $password, $dbname);

// // check connection
// if($connect->connect_error) {
//     die("Connection failed: " . $connect->connect_error);
// } else {
//     debug_to_console("Successfully Connected \"$dbname\".", TRUE);
// }

