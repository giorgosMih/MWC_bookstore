/**
 * Main js file Contents
 * ---------------------
 * 1 - Global variables, settings
 * 2 - Products Page
 * 3 - Book Management Page
 * 4 - Global functions
 * 5 - Category Management Page
 * 6 - Author Management Page
 */



/**
 * ================================
 * 1 - Global variables, settings
 * ================================
 */
//initialize toastr
toastr.options = {
	"closeButton": true,
	"debug": false,
	"newestOnTop": false,
	"progressBar": false,
	"positionClass": "toast-top-right",
	"preventDuplicates": false,
	"newestOnTop": true,
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "6000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
}

//on navbar collapse toggle, resize the main container
$(document).ready(function(){
	calcMainContentHeight()
	$('#navbarsExampleDefault').on('shown.bs.collapse', function(){
		calcMainContentHeight();
	});
	$('#navbarsExampleDefault').on('hidden.bs.collapse', function(){
		calcMainContentHeight();
	});

	$(document).on('click', '.bookListCart', function(e){
		e.stopPropagation();
	});

	$('#searchBoxForm').submit(function(e){
		e.preventDefault();
		var val = $(this).find('input[type=search]').val();
		window.location.href = 'index.php?p=search_box&search='+val;
	});

	$('.select2').select2();
});
//on window resize, resize the main container
$(window).resize(function(){
	calcMainContentHeight()
});
/**
 * ================================
 * end - Global variables, settings
 * ================================
 */



/**
 * ===================
 * 2 - Products Page
 * ===================
 */
if( $('#pageProductsContainer').length ){
$(document).ready(function(){
	//initialize book datatable
	var bookList = $('#bookList').DataTable({
		"paging": true,
		"lengthChange": true,
		"pageLength": 5,
		"lengthMenu": [
			[5, 10, 20, 50, -1],
			[5, 10, 20, 50, "All"]
		],
		"autoWidth": true,
		"processing": true,
		"serverSide": true,
		"stateSave": true,
		"ajax": {
			"url": "internal/products.php?loadBooks",
			"method": "POST",
			"data": function(d) {
				var category = $('#filterCategory').val();
				var author = $('#filterAuthor').val();
				var priceFrom = $('#filterPriceFrom').val();
				var priceTo = $('#filterPriceTo').val();

				d.search = {
					"category": category,
					"author": author,
					"priceFrom": priceFrom,
					"priceTo": priceTo
				};
				return d;
			}
		},
		"columns": [{
			"targets": 0,
			"data": "row",
			"render": function(data, type, row, meta){
				var d = JSON.parse(data);
				return `
					<img class='float-left mr-2' src='img/`+d.image+`' width='128'>
			 		<div class='row m-0'>
			 			<div class='h5'>`+d.title+`</div>
			 		</div>
			 		<div class='row m-0'>
						<div>author: `+d.author+`</div>
					</div>
					<div class='row m-0'>
						<div>category: `+d.category+`</div>
					</div>
			 		<div class='row m-0'>
						<div>stock: `+d.stock+`, price: `+d.price+`</div>
					</div>
					`+((d.stock > 0)?`
					<form class="bookListCart" onsubmit="add_cart(event, `+d.book_id+`)">
						<input class="form-control" title="Quantity" type="number" min="1" step="1" value="1">
						<button type="submit" class="form-control btn-outline-success" title="Add To Cart">
							<img src="img/controls/cart.png" height="22" alt="" />
						</button>
					</form>
				`:'<div class="bookListCart text-danger h6">Out of stock</div>');
			}
		}],
		"pagingType": "full_numbers",
		"columnDefs": [{
			"orderable": false,
			"searchable": false,
			"targets": [0]
		}],
		"order": [],
		"dom": '<"row mx-1" <".mr-auto" l>i<"ml-auto" p>>rt<"row mx-1" <".mr-auto" l>i<"ml-auto" p>>',
		"language":{
    		"emptyTable":     "No books available in our store yet.",
    		"info":           "Showing _START_ to _END_ of _TOTAL_ books",
    		"infoEmpty":      "Showing 0 to 0 of 0 books",
    		"infoFiltered":   "(filtered from _MAX_ total books)",
    		"infoPostFix":    "",
    		"thousands":      ",",
    		"lengthMenu":     "_MENU_ books per page",
    		"loadingRecords": "Loading...",
    		"processing":     "Loading...",
    		"zeroRecords":    "No books found with these filters.",
    		"paginate": {
        		"first":      "<<",
        		"last":       ">>",
        		"next":       ">",
        		"previous":   "<"
    		}
		}
	});

	//on product click, redirect to product details page
	$(document).on('click','#bookList tr', function(e){
		var id = $(this).attr('id');
		window.location.href = 'index.php?p=productinfo&pid='+id;
	});

	//on select element filters changed, reload table to apply the filters
	$(document).on('change','#filterCategory, #filterAuthor',function(e){
		bookList.ajax.reload();
	});
	//on input element filters changed, reload table to apply the filters
	$(document).on('keyup','#filterPriceFrom, #filterPriceTo',function(e){
		bookList.ajax.reload();
	});

	$(document).on('click','#filterClearBtn',function(e){
		$('#filterCategory, #filterAuthor').val("");
		$('#filterPriceFrom, #filterPriceTo').val("");
		bookList.ajax.reload();
	});

	$(document).on('click','#filterClearSearchBtn',function(e){
		$('#searchBoxForm input').val("");
		$('#searchBoxForm').submit();
	});

});
}
/**
 * ===================
 * end - Products Page
 * ===================
 */



/**
 * ==========================
 * 3 - Book Management Page
 * ==========================
 */
if( $('#pageBookManageContainer').length ){
$(document).ready(function(){
	var select2_opts = {
		tags: true,
		placeholder: 'Choose or add new...',
		theme: 'bootstrap4'
	};

	$('#addBookModal_author').select2(select2_opts);
	$('#editBookModal_author').select2(select2_opts);

	//initialize book datatable
	var table = $('#booksTable').DataTable({
		"paging": true,
		"lengthChange": true,
		"pageLength": 10,
		"lengthMenu": [
		[5, 10, 20, 50, -1],
		[5, 10, 20, 50, "All"]
		],
		"autoWidth": true,
		"processing": true,
		"serverSide": true,
		"pagingType": "full_numbers",
		"columnDefs": [{
			"orderable": false,
			"searchable": false,
			"targets": [0,7]
		}],
		"order": [],
		"ajax": {
			"url": "internal/book_manage.php?loadBooks",
			"method": "POST",
			"data": function(d) {
				return d;
			}
		},
		"columns": [{
			"data": "index"
		},
		{
			"data": "title"
		},
		{
			"data": "author"
		},
		{
			"data": "description",
			"render": function(data, type, row, meta) {
				return '<div title="click for details" class="book-description-truncate" data-description="'+data+'">'+((data.length>30)?(data.substring(0, 30)+'...'):data)+'</div>'
			}
		},
		{
			"data": "category"
		},
		{
			"data": "price"
		},
		{
			"data": "stock"
		},
		{
			"data": "actions"
		}
		],
		dom: '<"row mx-1" <"#custom-btns.mr-auto"> <"ml-auto" f>><"clear">rtilp'
	});

	var currentBookDescription;
	var expanded = false;
	//on click book description cell, expand and show all of it
	$(document).on('click', '.book-description-truncate', function(e){
		var descr = $(e.target).data('description');
		if(descr.length <= 30 || expanded) return;
		currentBookDescription = $(e.target).html();
		$(e.target).html(descr);
		expanded = true;
	});
	//on mouse out of book description cell, collapse and show only 30 chars of the description
	$(document).on('mouseout', '.book-description-truncate', function(e){
		var descr = $(e.target).data('description');
		if(descr.length <= 30 || !expanded) return;
		$(e.target).html(currentBookDescription);
		currentBookDescription = null;
		expanded = false;
	});

	//add book - start
	var createBtn = $('<button data-toggle="modal" data-target="#addBookModal" class="btn btn-outline-success btn-sm mb-1" title="Add Book"><img src="img/controls/create.png" alt="Add New">New Book</button>');
	$('#custom-btns').append(createBtn);//add create book button to datatable DOM

	//book add form submit
	$(document).on('submit', '#addBookForm', function(e){
		e.preventDefault();//stop original event

		var formData = new FormData(e.target);
		formData.append('addBookSubmit',null);
		$('#addBookForm input,select,textarea,button').prop('disabled', true);//disabled form fields for preventing editing

		//send data with ajax
		$.ajax({
			url: 'internal/book_manage.php',
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
			data: formData
		})
		.done(function(res) {
			if(res){
				window.location.reload();
			}
			else{
				table.ajax.reload();//on success, refresh book list to get new data
			}
			$('#addBookForm')[0].reset();
			$('#addBookModal_author').val(null).trigger('change');
			$('#addBookModal').modal('hide');//hide the edit book modal
			toastr["success"]("","The book has been inserted successfully!");//show message to user
		})
		.fail(function(err) {
			console.log(err);//on error, log the error
			toastr["error"]("The book's insertion failed.", "Insert Error");//show message to user
		})
		.always(function() {
			$('#addBookForm input,select,textarea,button').prop('disabled', false);//always re-enable the fields for next use
		});
		
	});
	//add book - end


	//edit book - start
	//button edit book was clicked from book list
	$(document).on('click', 'button.btn-edit', function(e){
		var rowIdx = $($(e.target).parents('tr')[0]).index();// clicked row index
		var row = table.rows(rowIdx).data()[0];// clicked row data
		
		//fill in edit form fields with clicked row data
		$('#editBookModal_title').val(row.title);
		$('#editBookModal_price').val(row.price);
		$('#editBookModal_description').val(row.description);
		$('#editBookModal_stock').val(row.stock);
		$('#editBookModal_author').val(row.author_id).trigger('change');
		$('#editBookModal_category').val(row.category_id);
		$('#editBookModal_image').attr("src", "./img/"+row.image);

		var id = $(e.target).data('id');//get book ID
		$('#editBookModal_bookID').val(id);//add book ID to hidden field in edit form
		$('#editBookModal').modal('show');//show modal with edit form
	});

	//book edit form submit
	$(document).on('submit', '#editBookForm', function(e){
		e.preventDefault();//stop original event

		var formData = new FormData(e.target);
		formData.append('editBookSubmit',null);
		$('#editBookForm input,select,textarea,button').prop('disabled', true);//disabled edit form fields for preventing editing
		
		//send updated data with ajax
		$.ajax({
			url: 'internal/book_manage.php',
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
			data: formData
		})
		.done(function(res) {
			if(res){
				window.location.reload();
			}
			else{
				table.ajax.reload();//on success, refresh book list to get new data
			}
			$('#editBookForm')[0].reset();
			$('#editBookModal_author').val(null).trigger('change');
			$('#editBookModal').modal('hide');//hide the edit book modal
			toastr["success"]("","The book has been updated successfully!");//show message to user
		})
		.fail(function(err) {
			console.log(err);//on error, log the error
			toastr["error"]("The book's update failed.", "Update Error");//show message to user
		})
		.always(function() {
			$('#editBookForm input,select,textarea,button').prop('disabled', false);//always re-enable the fields for next use
		});
		
	});
	//edit book - end
	

	//delete book - start
	//button delete book was clicked from book list
	$(document).on('click', 'button.btn-delete', function(e){
		var id = $(e.target).data('id');//get book ID
		$('#deleteBookModal_bookID').val(id);//add book ID to hidden field in delete form
		$('#deleteBookModal').modal('show');//show modal with edit form
	});

	//book delete form submit
	$(document).on('submit', '#deleteBookForm', function(e){
		e.preventDefault();//stop original event

		var formData = $(e.target).serialize() + '&deleteBookSubmit';//get form data and append identifier for serverside handling

		//send updated data with ajax
		$.ajax({
			url: 'internal/book_manage.php',
			type: 'POST',
			data: formData
		})
		.done(function(res) {
			console.log('Affected Rows: ' + res);
			table.ajax.reload();//on success, refresh book list to get updated data
			$('#deleteBookForm')[0].reset();
			toastr["success"]("","The book has been deleted successfully!");//show message to user
		})
		.fail(function(err) {
			console.log(err);//on error, log the error
			toastr["error"]("The book's deletion failed.", "Delete Error");//show message to user
		})
		.always(function(){
			$('#deleteBookModal').modal('hide');//hide the delete book modal
		});
		
	});
	//delete book - end
	
});
}
/**
 * ==========================
 * end - Book Management Page
 * ==========================
 */
 


/**
 * ======================
 * 4 - Global functions
 * ======================
 */

/**
 * Returns the current viewport height (in pixels) based on a given percentage.
 * @param  {float} v viewport percentage.
 * @return {int}   viewport height in pixels.
 */
function vh(v=100){
	//var h =  Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
	var h =  window.visualViewport.height;
	return (v*h)/100;
}

/**
 * Returns the current viewport width (in pixels) based on a given percentage.
 * @param  {float} v viewport percentage.
 * @return {int}   viewport width in pixels.
 */
function vw(v=100){
	//var w =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
	var w =  window.visualViewport.width;
	return (v*w)/100;
}

/**
 * Resizes the main container's height, so that the navbar, the footer and the main container
 * have a total of 100% of the window's current height.
 */
function calcMainContentHeight(){
	var navH = $('#topNavbar').parent().height();
	var footH = $('#bottomFooter').height();
	$('#maincontent').parents('div.container-fluid').outerHeight(vh() - navH - footH);
}

function add_cart(e, pid) {
	e.preventDefault()
	var a = $(e.target).find('input[type=number]').val();
	
	$.ajax({
		url: 'ajax/add_cart.php',
		type: 'GET',
		data: {
			"pid": pid,
			"qty": a,
		}
	})
	.done(function(res) {
		toastr["success"]("The book has been added to your cart!", "Success");//show message to user
	})
	.fail(function(err) {
		console.log("Add to cart error.");
		console.log(err);
		toastr["error"]("The book failed to be added to your cart.", "An Error Occurred");//show message to user
	})
	.always(function() {
		e.target.reset();
	});
}
/**
 * ======================
 * end - Global functions
 * ======================
 */

//==================================================================
//==================================================================
//==================================================================
 /**
 * ==========================
 * 5 - Category Management Page
 * ==========================
 */
if( $('#pageCategoryManageContainer').length ){
$(document).ready(function(){
	var select2_opts = {
		tags: true,
		placeholder: 'Choose or add new...',
		theme: 'bootstrap4'
	};

	//$('#addCategoryModal_author').select2(select2_opts);
	//$('#editCategoryModal_author').select2(select2_opts);

	//initialize category datatable
	var table = $('#categoriesTable').DataTable({
		"paging": true,
		"lengthChange": true,
		"pageLength": 10,
		"lengthMenu": [
		[5, 10, 20, 50, -1],
		[5, 10, 20, 50, "All"]
		],
		"autoWidth": true,
		"processing": true,
		"serverSide": true,
		"pagingType": "full_numbers",
		"columnDefs": [{
			"orderable": false,
			"searchable": false,
			"targets": [0,2]
		}],
		"order": [],
		"ajax": {
			"url": "internal/category_manage.php?loadCategories",
			"method": "POST",
			"data": function(d) {
				return d;
			}
		},
		"columns": [
		{"data": "index"},
		{"data": "Name"},
		{"data": "actions"}
		],
		dom: '<"row mx-1" <"#custom-btns.mr-auto"> <"ml-auto" f>><"clear">rtilp'
	});

	//add category - start
	var createBtn = $('<button data-toggle="modal" data-target="#addCategoryModal" class="btn btn-outline-success btn-sm mb-1" title="Add Category"><img src="img/controls/create.png" alt="Add New">New Category</button>');
	$('#custom-btns').append(createBtn);//add create category button to datatable DOM

	//category add form submit
	$(document).on('submit', '#addCategoryForm', function(e){
		e.preventDefault();//stop original event

		var formData = new FormData(e.target);
		formData.append('addCategorySubmit',null);
		$('#addCategoryForm input,select,textarea,button').prop('disabled', true);//disabled form fields for preventing editing

		//send data with ajax
		$.ajax({
			url: 'internal/category_manage.php',
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
			data: formData
		})
		.done(function(res) {
			if(res){
				window.location.reload();
			}
			else{
				table.ajax.reload();//on success, refresh category list to get new data
			}
			$('#addCategoryForm')[0].reset();
			$('#addCategoryModal').modal('hide');//hide the edit category modal
			toastr["success"]("","The category has been inserted successfully!");//show message to user
		})
		.fail(function(err) {
			console.log(err);//on error, log the error
			toastr["error"]("The category's insertion failed.", "Insert Error");//show message to user
		})
		.always(function() {
			$('#addCategoryForm input,select,textarea,button').prop('disabled', false);//always re-enable the fields for next use
		});
		
	});
	//add category - end


	//edit category - start
	//button edit category was clicked from category list
	$(document).on('click', 'button.btn-category-edit', function(e){
		var rowIdx = $($(e.target).parents('tr')[0]).index();// clicked row index
		var row = table.rows(rowIdx).data()[0];// clicked row data
		
		//fill in edit form fields with clicked row data
		$('#editCategoryModal_category').val(row.category_id);

		var id = $(e.target).data('id');//get category ID
		$('#editCategoryModal_CategoryID').val(id);//add category ID to hidden field in edit form
		$('#editCategoryModal').modal('show');//show modal with edit form
	});

	//category edit form submit
	$(document).on('submit', '#editCategoryForm', function(e){
		e.preventDefault();//stop original event

		var formData = new FormData(e.target);
		formData.append('editCategorySubmit',null);
		$('#editCategoryForm input,select,textarea,button').prop('disabled', true);//disabled edit form fields for preventing editing
		
		//send updated data with ajax
		$.ajax({
			url: 'internal/category_manage.php',
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
			data: formData
		})
		.done(function(res) {
			if(res){
				window.location.reload();
			}
			else{
				table.ajax.reload();//on success, refresh category list to get new data
			}
			$('#editCategoryForm')[0].reset();
			//$('#editCategoryModal_author').val(null).trigger('change');
			$('#editCategoryModal').modal('hide');//hide the edit category modal
			toastr["success"]("","The category has been updated successfully!");//show message to user
		})
		.fail(function(err) {
			console.log(err);//on error, log the error
			toastr["error"]("The category's update failed.", "Update Error");//show message to user
		})
		.always(function() {
			$('#editCategoryForm input,select,textarea,button').prop('disabled', false);//always re-enable the fields for next use
		});
		
	});
	//edit category - end
	

	//delete category - start
	//button delete category was clicked from category list
	$(document).on('click', 'button.btn-category-delete', function(e){
		var id = $(e.target).data('id');//get category ID
		$('#deleteCategoryModal_categoryID').val(id);//add category ID to hidden field in delete form
		$('#deleteCategoryModal').modal('show');//show modal with edit form
	});

	//category delete form submit
	$(document).on('submit', '#deleteCategoryForm', function(e){
		e.preventDefault();//stop original event

		var formData = $(e.target).serialize() + '&deleteCategorySubmit';//get form data and append identifier for serverside handling

		//send updated data with ajax
		$.ajax({
			url: 'internal/category_manage.php',
			type: 'POST',
			data: formData
		})
		.done(function(res) {
			console.log('Affected Rows: ' + res);
			table.ajax.reload();//on success, refresh category list to get updated data
			$('#deleteCategoryForm')[0].reset();
			toastr["success"]("","The category has been deleted successfully!");//show message to user
		})
		.fail(function(err) {
			console.log(err);//on error, log the error
			toastr["error"]("The category's deletion failed.", "Delete Error");//show message to user
		})
		.always(function(){
			$('#deleteCategoryModal').modal('hide');//hide the delete category modal
		});
		
	});
	//delete category - end
	
});
}
/**
 * ==========================
 * end - Category Management Page
 * ==========================
 */


 // Order Management 
 if( $('#pageOrderManageContainer').length ){
	$(document).ready(function(){
		
	
		
	
		//initialize book datatable
		var table = $('#OrdersTable').DataTable({
			"paging": true,
			"lengthChange": true,
			"pageLength": 10,
			"lengthMenu": [
			[5, 10, 20, 50, -1],
			[5, 10, 20, 50, "All"]
			],
			"autoWidth": true,
			"processing": true,
			"serverSide": true,
			"pagingType": "full_numbers",
			"columnDefs": [{
				"orderable": false,
				"searchable": false,
				"targets": [4]
			}],
			"order": [],
			"ajax": {
				"url": "internal/orders_manage.php?loadBooks",
				"method": "POST",
				"data": function(d) {
					return d;
				}
			},
			"columns": [{
				"data": "ID"
			},
			{
				"data": "customer"
			},
			{
				"data": "oDate"
			},
			
			{
				"data": "total price"
			},
			{
				"data": "Status",
				"render": function(data, type, row, meta) {
					
					if (data==0){
						return '<span class="badge badge-pill badge-secondary">Processing</span>'

					}
					else if (data==-1){
						return '<span class="badge badge-pill badge-danger">Declined</span>'
					}
					else 
					    return '<span class="badge badge-pill badge-success">Accepted</span>'
				}
			},
			
			{
				"data": "actions"
			}

			],
			dom: '<"row mx-1" <"#custom-btns.mr-auto"> <"ml-auto" f>><"clear">rtilp'
		});
	
		
		
		
	
		
		
		
	
	
		//edit book - start
		//button edit book was clicked from book list
		$(document).on('click', 'button.btn-edit', function(e){
			var id = $(e.target).data('id');//get book ID

			
			
			$.ajax({
				url: 'internal/orders_manage.php',
				type: 'POST',
				data: {
					orderID:id,
					accept:null
				 }
			})
			.done(function(res) {
				table.ajax.reload();//on success, refresh book list to get new data
				toastr["success"]("","The Order has been Accepted successfully!");//show message to user
				
			})
			.fail(function(err) {
				console.log(err);//on error, log the error
				toastr["error"]("The order failed to be accepted.", "Update Error");//show message to user
			})
			
			
			
		});
	
		
	
		//delete book - start
		//button delete book was clicked from book list
		$(document).on('click', 'button.btn-delete', function(e){
			var id = $(e.target).data('id');//get book ID

			
			
			$.ajax({
				url: 'internal/orders_manage.php',
				type: 'POST',
				data: {
					orderID:id,
					decline:null
				 }
			})
			.done(function(res) {
				table.ajax.reload();//on success, refresh book list to get new data
				toastr["success"]("","The Order has been declined!");//show message to user
				
			})
			.fail(function(err) {
				console.log(err);//on error, log the error
				toastr["error"]("The order failed to be declined.", "Update Error");//show message to user
			})
		});
	
		//book delete form submit
		
		
	});
	}