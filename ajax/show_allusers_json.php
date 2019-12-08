<?php
require "../internal/dbconnect.php";
session_start();
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']==0) {
	die("You are not admin");
}
$stmt = $mysqli->prepare('SELECT * FROM customer');
$stmt->execute();
$res = $stmt->get_result();
$r = $res->fetch_all(MYSQLI_ASSOC);
print json_encode($r);
?>
