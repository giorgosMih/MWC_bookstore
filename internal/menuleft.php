<h3>Book Categories</h3>
<ul class="nav nav-pills flex-column">
<?php
$sql = 'select * from category order by Name';

if (! ($res = $mysqli->query($sql))) {
 echo "Table creation failed: (" . 
 			$mysqli->errno . ") " . $mysqli->error;
} else {
	while ($row = $res->fetch_assoc()) {
		print "<li class='nav-item'><a class='nav-link' href='index.php?p=catinfo&catid=$row[ID]'>".
				"$row[Name]</a></li>";
	}
}



?>

</ul>

