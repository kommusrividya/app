<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
//define('DB_SERVER', 'localhost');
define('DB_SERVER', '43.255.154.9');
define('DB_USERNAME', 'madhup');
define('DB_PASSWORD', 'madhup');
define('DB_NAME', 'bspdhyd_wp1');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//echo ("test");
?>