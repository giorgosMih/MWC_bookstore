<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	session_start();
	if(isset($_GET['loadBooks'])){
		require('dbconnect.php');
		$draw = $_POST['draw'];
		$start = $_POST['start'];
		$length = $_POST['length'];
		$search = $_POST['search'];
		$_SESSION['bookSearch']['category'] = $search['category'];
		$_SESSION['bookSearch']['author'] = $search['author'];
		$_SESSION['bookSearch']['priceFrom'] = $search['priceFrom'];
		$_SESSION['bookSearch']['priceTo'] = $search['priceTo'];

		//build filters
		$filters = array();
		if( !empty($search['category']) ){
			$filters[] = "category_id = '$search[category]'";
		}
		if( !empty($search['author']) ){
			$filters[] = "author_id = '$search[author]'";
		}
		if( !empty($search['priceFrom']) ){
			$filters[] = "price >= '$search[priceFrom]'";
		}
		if( !empty($search['priceTo']) ){
			$filters[] = "price <= '$search[priceTo]'";
		}
		$filters = implode(' AND ', $filters);

		//check search box filter
		if( isset($_SESSION['bookSearch']['searchbox']) ){
			$searchbox = htmlspecialchars($_SESSION['bookSearch']['searchbox']);
			if( !empty($filters) ){
				$filters .= " AND CONCAT(category,author,description,title) LIKE '%$searchbox%'";
			}
			else{
				$filters .= "CONCAT(category,author,description,title) LIKE '%$searchbox%'";
			}
		}

		//get total count of all records
		$sql = 'select count(*) as "total" from v_books';
		if ( $res = $mysqli->query($sql) ) {
			$row = $res->fetch_assoc();
			$total = $row['total'];
		}
		else{
			$total = 0;
		}
		
		//get total count of all records
		if(!empty($filters)){
			$sql = "select count(*) as 'total' from v_books WHERE $filters";
			if ( $res = $mysqli->query($sql) ) {
				$row = $res->fetch_assoc();
				$totalFiltered = $row['total'];
			}
			else{
				$totalFiltered = $total;
			}
		}
		else{
			$totalFiltered = $total;
		}

		$sql = "
		select book_id, title, author, category, price, stock, image
		from v_books
		".((empty($filters))?"":"WHERE $filters")."
		order by title
		".(($length>0)?"LIMIT $start, $length":"")."
		";

		$data = array();
		if ( $res = $mysqli->query($sql) ) {
			while ($row = $res->fetch_assoc()) {
				$r = array();
				$r['DT_RowId'] = $row['book_id'];
				$r['row'] = json_encode($row);
				$data[] = $r;
			}
		}

		//response
		$response = array(
			"draw"=>(int)$draw,
			"recordsTotal"=>$total,
			"recordsFiltered"=>$totalFiltered,
			"data"=>$data
		);

		echo json_encode($response);
		exit();
	}
}

$sql = "select * from author";
if( $stmt = $mysqli->prepare($sql) ) {
	$stmt->execute();
	$authors = $stmt->get_result();
}

$sql = "select * from category";
if( $stmt = $mysqli->prepare($sql) ) {
	$stmt->execute();
	$categories = $stmt->get_result();
}
?>

<div id="pageProductsContainer" class="row m-0">
	<div class="col-md-4 col-lg-3 col-xl-2">
		<div class="h4">
			<div class="d-md-block d-none">Filters</div>
			<button class="btn d-md-none collapsed" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Filters</button>
		</div>
		<form id="multiCollapseExample2" class="d-md-block collapse">
			
			<div class="form-row">
				<div class="form-group col">
					<label for="filterCategory">Category</label>
					<select id="filterCategory" class="form-control">
						<option value="">All categories</option>
					<?php foreach ($categories as $c):?>
						<option value="<?= $c['ID']?>" <?php if(isset($_SESSION['bookSearch']) && $_SESSION['bookSearch']['category']==$c['ID']) echo "selected";?>><?= $c['Name']?></option>
					<?php endforeach;?>
					</select>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col">
					<label for="filterAuthor">Author</label>
					<select id="filterAuthor" class="form-control">
						<option value="">All authors</option>
					<?php foreach ($authors as $a):?>
						<option value="<?= $a['ID']?>" <?php if(isset($_SESSION['bookSearch']) && $_SESSION['bookSearch']['author']==$a['ID']) echo "selected";?>><?= $a['name']?></option>
					<?php endforeach;?>
					</select>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col">
					<label for="filterPriceFrom">Price From</label>
					<input id="filterPriceFrom" type="number" min="0" step="0.01" class="form-control" value="<?php if(isset($_SESSION['bookSearch'])) echo $_SESSION['bookSearch']['priceFrom'];?>">
				</div>

				<div class="form-group col">
					<label for="filterPriceTo">Price To</label>
					<input id="filterPriceTo" type="number" min="0" step="0.01" class="form-control" value="<?php if(isset($_SESSION['bookSearch'])) echo $_SESSION['bookSearch']['priceTo'];?>">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col">
					<input id="filterClearBtn" class="form-control btn-danger" type="button" value="Clear Filters">
				</div>

				<div class="form-group col">
					<input id="filterClearSearchBtn" class="form-control btn-danger" type="button" value="Clear Search">
				</div>
			</div>
			
			<hr class="d-md-none">

		</form>

	</div>
	<div class="col">
		<table id="bookList" class="table table-bordered w-100">
			<thead class="d-none"></thead>
		</table>
	</div>
</div>