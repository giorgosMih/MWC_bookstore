<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	
	if(isset($_POST['editAuthorSubmit'])){
		require('dbconnect.php');
		$reloadPage = false;	
	
		$sql = "update author set name=? where ID=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('si', $_POST['name'], $_POST['id']);
		$stmt->execute();
		$stmt->close();
		exit();
	}
	else if(isset($_POST['addAuthorSubmit'])){
		require('dbconnect.php');
		$sql = "insert into author(name) VALUES(?)";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('s', $_POST['name']);
		$stmt->execute();
		$stmt->close();
		exit();
	}
	else if(isset($_POST['deleteAuthorSubmit'])){
		require('dbconnect.php');

		$sql = "delete from author where ID=?";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_POST['id']);
		$stmt->execute();
		//echo $stmt->affected_rows;
		$stmt->close();
		echo $reloadPage;
		exit();
	}
	else if(isset($_GET['loadAuthors'])){
		require('dbconnect.php');
		$draw = $_POST['draw'];
		$start = $_POST['start'];
		$length = $_POST['length'];
		$search = $_POST['search']['value'];
		$order = ( array_key_exists('order', $_POST) )? $_POST['columns'][$_POST['order'][0]['column']]['data'] : '';
		$orderDir = ( array_key_exists('order', $_POST) )? $_POST['order'][0]['dir'] : '';
		
		//get total count of all records - entries at the navigation menu at the bottom of the page
		$sql = 'select count(*) as "total" from author';
		if ( $res = $mysqli->query($sql) ) {
			$row = $res->fetch_assoc();
			$total = $row['total'];
		}
		else{
			$total = 0;
		}

		$sql = "select * from author where CONCAT_WS(' ', name) LIKE '%$search%'".(($order)?"order by $order $orderDir":"")." LIMIT $start, $length";
		
		$data = array();
		if ( $res = $mysqli->query($sql) ) {
			$index = 1;
			while ($row = $res->fetch_assoc()) {
				$row['index'] = $start+$index++;
				$row['actions'] = "
				<button class='btn btn-outline-primary btn-sm btn-edit' title='Edit Author' data-id='$row[ID]'>
				</button>
				<button class='btn btn-outline-danger btn-sm btn-delete' title='Delete Author' data-id='$row[ID]'>
				</button>
				";
				$data[] = $row;
			}
		}

		$totalFiltered = count($data);

		//response
		$response = array(
			"draw"=>(int)$draw,
			"recordsTotal"=>$total,
			"recordsFiltered"=>((!empty($search))?$totalFiltered:$total),
			"data"=>$data
		);

		echo json_encode($response);
		exit();
	}
}

if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']==0) {
	die("You are not admin");
}

//get book categories for list
$sql = 'select * from author order by name';
$categories = array();
if ( $res = $mysqli->query($sql) ) {
	while($row = $res->fetch_assoc()){
		$categories[] = $row;
	}
}
?>

<div id="pageAuthorManageContainer" class="px-2">
<table id="authorsTable" class="table table-bordered table-striped w-100">
	<thead>
		<tr>
			<th>#</th>
			<th>Author</th>
			<th>Actions</th>
		</tr>
	</thead>
</table>

<!-- modals -->
<!-- add category modal -->
<div class="modal fade" id="addAuthorModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add New Author</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="addAuthorForm" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col">
							<label for="addAuthorModal_name">Author (*)</label>
							<input type="text" class="form-control" id="addAuthorModal_name" required name="name">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="mr-auto h6">(*) Required fields</div>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="submit" form="addAuthorForm" class="btn btn-success">Add</button>
			</div>
		</div>
	</div>
</div>
<!-- /add category modal -->

<!-- edit category modal -->
<div class="modal fade" id="editAuthorModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Author</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="editAuthorForm" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col">
							<label for="editAuthorModal_name">Author (*)</label>
							<input type="text" class="form-control" id="editAuthorModal_name" required name="name">
						</div>
					</div>
					<input id="editAuthorModal_authorID" type="hidden" name="id" required>
				</form>

			</div>
			<div class="modal-footer">
				<div class="mr-auto h6">(*) Required fields</div>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="submit" form="editAuthorForm" class="btn btn-success">Save changes</button>
			</div>
		</div>
	</div>
</div>
<!-- /edit category modal -->

<!-- delete category modal -->
<div class="modal fade" id="deleteAuthorModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Author</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<form id="deleteAuthorForm">
					<div class="h5 text-danger">Are you sure you want to delete this author? The data will be removed permanently from you computer.</div>
					<input type="hidden" id="deleteAuthorModal_authorID" name="id" required>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" form="deleteAuthorForm" class="btn btn-danger">Delete</button>
			</div>
		</div>
	</div>
</div>
<!-- /delete category modal -->

<!-- /modals -->
</div>