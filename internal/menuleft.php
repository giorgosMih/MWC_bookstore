<h3 class="text-center">Select a category or search for a book from the to bar's search box.</h3>
<div class="row mx-0">
<?php
$sql = 'select * from category order by Name';

if (! ($res = $mysqli->query($sql))) {
 echo "Table creation failed: (" . 
 			$mysqli->errno . ") " . $mysqli->error;
} else {
	while ($row = $res->fetch_assoc()) {
		print "
		<div class='col-6 col-sm-4 col-md-3 my-1'>
			<a class='category-tile nav-link text-truncate text-center' href='index.php?p=catinfo&catid=$row[ID]'>
				$row[Name]
			</a>
		</div>
		";
	}
}
?>
</div>