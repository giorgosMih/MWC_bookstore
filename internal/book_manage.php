<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
	if(isset($_POST['editBookSubmit'])){
		require('dbconnect.php');
		$newImage = $_FILES['image']['name'];

		if($newImage){
			$imgPath = dirname(dirname(__FILE__)).'/img/products/';
			if(file_exists($imgPath.$newImage)) {
    			unlink($imgPath.$newImage); //remove the file
			}
			move_uploaded_file($_FILES['image']['tmp_name'], $imgPath.$newImage);
		}

		$sql = "
		update product set Title=?,author=?,Description=?,Price=?,stock=?,Category=?".(($newImage)?", image='products/$newImage'":"")."
		where ID=?
		";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('sisdiii', $_POST['title'], $_POST['author'], $_POST['description'], $_POST['price'], $_POST['stock'], $_POST['category'], $_POST['id']);
		$stmt->execute();
		echo $stmt->affected_rows;
		$stmt->close();
		exit();
	}
	else if(isset($_POST['addBookSubmit'])){
		require('dbconnect.php');
		$newImage = $_FILES['image']['name'];
		if($newImage){
			$imgPath = dirname(dirname(__FILE__)).'/img/products/';
			if(file_exists($imgPath.$newImage)) {
    			unlink($imgPath.$newImage); //remove the file
			}
			move_uploaded_file($_FILES['image']['tmp_name'], $imgPath.$newImage);
		}

		$sql = "
		insert into product(Title,author,Description,Price,stock,Category".(($newImage)?",image":"").")
		VALUES(?,?,?,?,?,?".(($newImage)?",?":"").")
		";

		$data = array($_POST['title'], $_POST['author'], $_POST['description'], $_POST['price'], $_POST['stock'], $_POST['category']);

		if($newImage) $data[] = $newImage;

		$binding = 'sisdii'.(($newImage)?"s":"");

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param($binding, ...$data);
		$stmt->execute();
		echo $stmt->insert_id;
		$stmt->close();
		exit();
	}
	else if(isset($_POST['deleteBookSubmit'])){
		require('dbconnect.php');
		$sql = "
		delete from product where ID=?
		";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_POST['id']);
		$stmt->execute();
		echo $stmt->affected_rows;
		$stmt->close();
		exit();
	}
	else if(isset($_GET['loadBooks'])){
		require('dbconnect.php');
		$draw = $_POST['draw'];
		$start = $_POST['start'];
		$length = $_POST['length'];
		$search = $_POST['search']['value'];
		$order = ( array_key_exists('order', $_POST) )? $_POST['columns'][$_POST['order'][0]['column']]['data'] : '';
		$orderDir = ( array_key_exists('order', $_POST) )? $_POST['order'][0]['dir'] : '';

		//get total count of all records
		$sql = 'select count(*) as "total" from v_books';
		if ( $res = $mysqli->query($sql) ) {
			$row = $res->fetch_assoc();
			$total = $row['total'];
		}
		else{
			$total = 0;
		}

		$sql = "
		select * 
		from v_books 
		where CONCAT_WS(' ',title, description, author, category, price) LIKE '%$search%'
		".(($order)?"order by $order $orderDir":"")."
		LIMIT $start, $length
		";
		$data = array();
		if ( $res = $mysqli->query($sql) ) {
			$index = 1;
			while ($row = $res->fetch_assoc()) {
				$row['index'] = $start+$index++;
				$row['actions'] = "
				<button class='btn btn-outline-primary btn-sm btn-book-edit' title='Edit Book' data-id='$row[book_id]'>
				</button>
				<button class='btn btn-outline-danger btn-sm btn-book-delete' title='Delete Book' data-id='$row[book_id]'>
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

//get authors for list
$sql = 'select * from v_authors';
$authors = array();
if ( $res = $mysqli->query($sql) ) {
	while($row = $res->fetch_assoc()){
		$authors[] = $row;
	}
}

//get book categories for list
$sql = 'select * from category order by Name';
$categories = array();
if ( $res = $mysqli->query($sql) ) {
	while($row = $res->fetch_assoc()){
		$categories[] = $row;
	}
}
?>

<div id="pageBookManageContainer" class="px-2">
<table id="booksTable" class="table table-bordered table-striped w-100">
	<thead>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>Author</th>
			<th>Description</th>
			<th>Category</th>
			<th>Price</th>
			<th>Stock</th>
			<th>Actions</th>
		</tr>
	</thead>
</table>

<!-- modals -->
<!-- add book modal -->
<div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add New Book</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="addBookForm" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col">
							<label for="addBookModal_title">Title (*)</label>
							<input type="text" class="form-control" id="addBookModal_title" required name="title">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col">
							<label for="addBookModal_author">Author (*)</label>
							<select id="addBookModal_author" class="form-control" required name="author">
								<option value="">Choose...</option>
							<?php foreach ($authors as $author):?>
								<option value="<?= $author['id']?>"><?= $author['name']?></option>
							<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group col">
							<label for="addBookModal_category">Category (*)</label>
							<select id="addBookModal_category" class="form-control" required name="category">
								<option value="">Choose...</option>
							<?php foreach ($categories as $cat):?>
								<option value="<?= $cat['ID']?>"><?= $cat['Name']?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col">
							<label for="addBookModal_price">Price (*)</label>
							<input type="number" min="0" step="0.01" class="form-control" id="addBookModal_price" required name="price">
						</div>

						<div class="form-group col">
							<label for="addBookModal_stock">Stock (*)</label>
							<input type="number" min="0" step="1" class="form-control" id="addBookModal_stock" required name="stock">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col">
							<label for="addBookModal_description">Description (*)</label>
							<textarea id="addBookModal_description" class="form-control" rows="3" required name="description"></textarea>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="form-group col">
							<label for="addBookModal_imageInput">Book Image</label>
							<input id="addBookModal_imageInput" name="image" type="file" class="form-control" accept=".png, .jpg, .jpeg">
						</div>
					</div>

				</form>

			</div>
			<div class="modal-footer">
				<div class="mr-auto h6">(*) Required fields</div>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="submit" form="addBookForm" class="btn btn-success">Add</button>
			</div>
		</div>
	</div>
</div>
<!-- /add book modal -->

<!-- edit book modal -->
<div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Book</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="editBookForm" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col">
							<label for="editBookModal_title">Title (*)</label>
							<input type="text" class="form-control" id="editBookModal_title" required name="title">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col">
							<label for="editBookModal_author">Author (*)</label>
							<select id="editBookModal_author" class="form-control" required name="author">
								<option value="">Choose...</option>
							<?php foreach ($authors as $author):?>
								<option value="<?= $author['id']?>"><?= $author['name']?></option>
							<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group col">
							<label for="editBookModal_category">Category (*)</label>
							<select id="editBookModal_category" class="form-control" required name="category">
								<option value="">Choose...</option>
							<?php foreach ($categories as $cat):?>
								<option value="<?= $cat['ID']?>"><?= $cat['Name']?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col">
							<label for="editBookModal_price">Price (*)</label>
							<input type="number" min="0" step="0.01" class="form-control" id="editBookModal_price" required name="price">
						</div>

						<div class="form-group col">
							<label for="editBookModal_stock">Stock (*)</label>
							<input type="number" min="0" step="1" class="form-control" id="editBookModal_stock" required name="stock">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col">
							<label for="editBookModal_description">Description (*)</label>
							<textarea id="editBookModal_description" class="form-control" rows="3" required name="description"></textarea>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<img id="editBookModal_image" width="128">
						<div class="form-group col">
							<label for="editBookModal_imageInput">Change Image</label>
							<input id="editBookModal_imageInput" name="image" type="file" class="form-control" accept=".png, .jpg, .jpeg">
						</div>
					</div>

					<input id="editBookModal_bookID" type="hidden" name="id" required>
				</form>

			</div>
			<div class="modal-footer">
				<div class="mr-auto h6">(*) Required fields</div>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="submit" form="editBookForm" class="btn btn-success">Save changes</button>
			</div>
		</div>
	</div>
</div>
<!-- /edit book modal -->

<!-- delete book modal -->
<div class="modal fade" id="deleteBookModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Book</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<form id="deleteBookForm">
					<div class="h5 text-danger">Are you sure you want to delete this book? The data will be removed permanently from you computer.</div>
					<input type="hidden" id="deleteBookModal_bookID" name="id" required>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" form="deleteBookForm" class="btn btn-danger">Delete</button>
			</div>
		</div>
	</div>
</div>
<!-- /delete book modal -->

<!-- /modals -->
</div>