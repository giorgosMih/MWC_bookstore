Proccessing login.....
<?php
	$u = $_REQUEST['username'];
	$p = $_REQUEST['pass'];
	$sql = "SELECT COUNT(*) AS ok, sum(is_admin) as is_admin, min(ID) as ID FROM customer WHERE uname=? AND passwd_enc=PASSWORD(?)";
	$stmt = $mysqli->prepare($sql);
	if(! $stmt) {
		print "ERROR:: ".$mysqli->error;
	}
	$stmt->bind_param("ss", $u,$p);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	
	if($row['ok']) {
		$_SESSION['username'] = $u;
		$_SESSION['is_admin'] = $row['is_admin'];
		$_SESSION['userid'] = $row['ID'];
		header("Location: index.php?p=after_login");
	} else {
		print "Unknown user... Please try again.";
		$_SESSION['username'] = '?';
	}


?>