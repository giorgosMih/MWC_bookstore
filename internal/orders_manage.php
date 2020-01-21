<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	
	
	
	
	 if(isset($_GET['loadBooks'])){
		require('dbconnect.php');
		$draw = $_POST['draw'];
		$start = $_POST['start'];
		$length = $_POST['length'];
		$search = $_POST['search']['value'];
		$order = ( array_key_exists('order', $_POST) )? $_POST['columns'][$_POST['order'][0]['column']]['data'] : '';
		$orderDir = ( array_key_exists('order', $_POST) )? $_POST['order'][0]['dir'] : '';

		//get total count of all records
		$sql = 'select count(*) as "total" from orders';
		if ( $res = $mysqli->query($sql) ) {
			$row = $res->fetch_assoc();
			$total = $row['total'];
		}
		else{
			$total = 0;
		}

		$sql = "
		select * from v_orders
		WHERE CONCAT_WS(' ',ID, customer, oDate, `total price`,IF(
			Status=1,'Accepted',IF(Status=-1,'Declined','Processing')
		)) LIKE '%$search%' 
		".(($order)?"order by $order $orderDir":"")."
		LIMIT $start, $length
		";
		$data = array();
		if ( $res = $mysqli->query($sql) ) {
			$index = 1;
			while ($row = $res->fetch_assoc()) {
				$row['actions'] = "
				<button class='btn btn-outline-primary btn-sm btn-edit' title='Accept Order' data-id='$row[ID]'>
				</button>
				<button class='btn btn-outline-danger btn-sm btn-delete' title='Cancel Order' data-id='$row[ID]'>
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
	else if(isset($_POST['accept'])){
		

		require('dbconnect.php');
			
		

		$sql = "
		update orders set Status=1
		where ID=?
		";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_POST['orderID']);
		$stmt->execute();
		//echo $stmt->affected_rows;
		$stmt->close();
		exit();
	}
	else if(isset($_POST['decline'])){
		

		require('dbconnect.php');
			
		

		$sql = "
		update orders set Status=-1
		where ID=?
		";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_POST['orderID']);
		$stmt->execute();
		//echo $stmt->affected_rows;
		$stmt->close();
		exit();
	}
}

if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']==0) {
	die("You are not admin");
}



//SELECT orders.ID, concat(customer.Lname,' ' ,customer.Fname) as 'customer',orders.oDate,SUM(orderdetails.Quantity*product.Price) FROM orders JOIN customer ON customer.ID=orders.Customer JOIN orderdetails ON orderdetails.Orders=orders.ID JOIN product ON product.ID=orderdetails.Product GROUP BY orderdetails.Orders
?>

<div id="pageOrderManageContainer" class="px-2">
<table id="OrdersTable" class="table table-bordered table-striped w-100">
	<thead>
		<tr>
			<th>Order ID</th>
			<th>Customer</th>
			<th>Date</th>
			<th>Total Price</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
</table>


</div>



