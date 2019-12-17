<?php
$user='root';
$pass='';
$host='localhost';
$db = 'bookstore';


$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: (".$mysqli->connect_errno.") ".$mysqli->connect_error);
}else{
	$mysqli->set_charset('utf-8');
}
?>
