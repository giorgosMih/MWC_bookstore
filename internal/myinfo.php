<h2>Account Information</h2>
<?php
if(isset($_REQUEST['action_save'])) {
	//$_ENV['LC_ALL'] = 'el_GR.UTF-8';
	setlocale(LC_ALL, 'el_GR.UTF-8');

	$sql = 'update customer set Fname=?, Lname=?, Address=?, Phone=? where ID=?';
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssssi", $_REQUEST['Fname'], $_REQUEST['Lname'], $_REQUEST['Address'], $_REQUEST['Phone'], $_SESSION['userid']);
	$r = $stmt->execute();
	if($r) {
		print "Save successful (".strftime('%H:%M:%S %a %d %b %Y',time()).").." ;
	} else {
		print "Error. Something went wrong (".strftime('%H:%M:%S %a %d %B %Y',time()).")..";
	}
}

?>

<form method='get'>
	<table>
		<?php
		$sql = "select * from customer where ID=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $_SESSION['userid']);
		$stmt->execute();
		$res = $stmt->get_result();
		$row = $res->fetch_assoc();
		?>
		<tr>
			<td class="text-right">First Name:</td>
			<td>
				<input class="form-control" type='text' name='Fname' value='<?= $row['Fname']; ?>'>
			</td>
		</tr>
		<tr>
			<td class="text-right">Last Name:</td>
			<td>
				<input class="form-control" type='text' name='Lname' value='<?= $row['Lname']; ?>'>
			</td>
		</tr>
		<tr>
			<td class="text-right">Address:</td>
			<td>
				<textarea class="form-control" name='Address' ><?= $row['Address']; ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="text-right">Phone Number:</td>
			<td>
				<input class="form-control" type='text' name='Phone' value='<?= $row['Phone']; ?>'>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="text-center">
				<input type='submit' class="btn btn-primary" value='Save' name='action_save'>
				<input type='reset' class="btn btn-primary" value='Cancel'>
				<input type='hidden' name='p' value='myinfo'>
			</td>
		</tr>
	</table>
</form>
