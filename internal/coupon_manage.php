<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	if(isset($_POST['editCouponSubmit'])){
		require('dbconnect.php');
		$reloadPage = false;	
	
		$sql = "update coupon set code=?, discount=?, total_usage=?,is_enable=?, valid_from=?, valid_to=? where coupon_id=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('siiissi', $_POST['code'], $_POST['discount'], $_POST['total_usage'], $_POST['is_enable'], $_POST['valid_from'], $_POST['valid_to'], $_POST['id']);
		$stmt->execute();
		$stmt->close();
		exit();
	}
	else if(isset($_POST['addCouponSubmit'])){
		require('dbconnect.php');
		$sql = "insert into coupon(code, discount, total_usage,is_enable, valid_from, valid_to) VALUES(?,?,?,?,?,?)";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('siiiss', $_POST['code'], $_POST['discount'], $_POST['total_usage'], $_POST['is_enable'], $_POST['valid_from'], $_POST['valid_to']);
		$stmt->execute();
		$stmt->close();
		exit();
	}
	else if(isset($_POST['deleteCouponSubmit'])){;
		require('dbconnect.php');

		$sql = "delete from coupon where coupon_id=?";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_POST['id']);
		$stmt->execute();
		//echo $stmt->affected_rows;
		$stmt->close();
		echo $reloadPage;
		exit();
	}
	else if(isset($_GET['loadCoupons'])){
		require('dbconnect.php');
		$draw = $_POST['draw'];
		$start = $_POST['start'];
		$length = $_POST['length'];
		$search = $_POST['search']['value'];
		$order = ( array_key_exists('order', $_POST) )? $_POST['columns'][$_POST['order'][0]['column']]['data'] : '';
		$orderDir = ( array_key_exists('order', $_POST) )? $_POST['order'][0]['dir'] : '';
		
		//get total count of all records - entries at the navigation menu at the bottom of the page
		$sql = 'select count(*) as "total" from coupon';
		if ( $res = $mysqli->query($sql) ) {
			$row = $res->fetch_assoc();
			$total = $row['total'];
		}
		else{
			$total = 0;
		}

		$sql = "select * from coupon where CONCAT_WS(' ', discount) LIKE '%$search%'".(($order)?"order by $order $orderDir":"")." LIMIT $start, $length";
		
		$data = array();
		if ( $res = $mysqli->query($sql) ) {
			$index = 1;
			while ($row = $res->fetch_assoc()) {
				$row['index'] = $start+$index++;
				$row['actions'] = "
				<button class='btn btn-outline-primary btn-sm btn-edit' title='Edit coupon' data-id='$row[coupon_id]'>
				</button>
				<button class='btn btn-outline-danger btn-sm btn-delete' title='Delete coupon' data-id='$row[coupon_id]'>
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
$sql = 'select * from coupon';
$categories = array();
if ( $res = $mysqli->query($sql) ) {
	while($row = $res->fetch_assoc()){
        $categories[] = $row;
	}
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#*&@';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<div id="pageCouponManageContainer" class="px-2">
<table id="couponsTable" class="table table-bordered table-striped w-100">
	<thead>
		<tr>
			<th>#</th>
			<th>Code</th>
			<th>Discount</th>
            <th>is_enable</th>
			<th>Total_usage</th>
			<th>Valid_from</th>
            <th>Valid_to</th>
            <th>Actions</th>
		</tr>
	</thead>
</table>

<!-- modals -->
<!-- add category modal -->
<div class="modal fade" id="addcouponModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add New coupon</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="addcouponForm" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col">
							<label for="addcouponModal_name">code (*)</label>
							<input type="text" class="form-control" id="addcouponModal_code" required name="code" value="<?=generateRandomString()?>">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="addcouponModal_name">discount (*)</label>
							<input type="number" class="form-control" id="addcouponModal_discount" required name="discount">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="addcouponModal_name">is_enable (*)</label>
							<input type="text" class="form-control" id="addcouponModal_is_enable" required name="is_enable">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="addcouponModal_name">Total_usage (*)</label>
							<input type="number" class="form-control" id="addcouponModal_total_usage" required name="total_usage">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="addcouponModal_name">Valid_from (*)</label>
							<input type="date" class="form-control" id="addcouponModal_valid_from" required name="valid_from">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="addcouponModal_name">Valid_to (*)</label>
							<input type="date" class="form-control" id="addcouponModal_valid_to" required name="valid_to">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="mr-auto h6">(*) Required fields</div>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="submit" form="addcouponForm" class="btn btn-success">Add</button>
			</div>
		</div>
	</div>
</div>
<!-- /add category modal -->

<!-- edit category modal -->
<div class="modal fade" id="editcouponModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit coupon</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="editcouponForm" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col">
							<label for="editcouponModal_name">code (*)</label>
							<input type="text" class="form-control" id="editcouponModal_code" required name="code">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="editcouponModal_name">discount (*)</label>
							<input type="number" class="form-control" id="editcouponModal_discount" required name="discount">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="editcouponModal_name">is_enable (*)</label>
							<input type="number" class="form-control" id="editcouponModal_is_enable" required name="is_enable">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="editcouponModal_name">Total_usage (*)</label>
							<input type="number" class="form-control" id="editcouponModal_total_usage" required name="total_usage">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="editcouponModal_name">Valid_from (*)</label>
							<input type="date" class="form-control" id="editcouponModal_valid_from" required name="valid_from">
						</div>
					</div>
                    <div class="form-row">
						<div class="form-group col">
							<label for="editcouponModal_name">Valid_to (*)</label>
							<input type="date" class="form-control" id="editcouponModal_valid_to" required name="valid_to">
						</div>
					</div>
					<input id="editcouponModal_couponID" type="hidden" name="id" required>
				</form>

			</div>
			<div class="modal-footer">
				<div class="mr-auto h6">(*) Required fields</div>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="submit" form="editcouponForm" class="btn btn-success">Save changes</button>
			</div>
		</div>
	</div>
</div>
<!-- /edit category modal -->


<!-- delete category modal -->
<div class="modal fade" id="deletecouponModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete coupon</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="deletecouponForm">
					<div class="h5 text-danger">Are you sure you want to delete this coupon? The data will be removed permanently from you computer.</div>
					<input type="hidden" id="deletecouponModal_couponID" name="id" required>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" form="deletecouponForm" class="btn btn-danger">Delete</button>
			</div>
		</div>
	</div>
</div>
<!-- /delete category modal -->

<!-- /modals -->
</div>