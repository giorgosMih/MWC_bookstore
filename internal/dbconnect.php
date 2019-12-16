<?php
//$user='root';
//$pass='';
//$host='localhost';
//$db = 'bookstore';

$user='bookstore_user';
$pass='b00k$t0rE';
$host='localhost';
$db = 'bookstore_db';


$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . 
    $mysqli->connect_errno . ") " . $mysqli->connect_error;
}?>
