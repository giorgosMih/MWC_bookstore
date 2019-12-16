//globals - start
//initialize toastr
toastr.options = {
	"closeButton": true,
	"debug": false,
	"newestOnTop": false,
	"progressBar": false,
	"positionClass": "toast-top-right",
	"preventDuplicates": true,
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
//globals - end

// book management - start
var booksTable = $('#booksTable');
if(booksTable.length){
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
	$(document).on('click', '.book-description-truncate', function(e){
		var descr = $(e.target).data('description');
		if(descr.length <= 30 || expanded) return;
		currentBookDescription = $(e.target).html();
		$(e.target).html(descr);
		expanded = true;
	});
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
			console.log('New book ID: ' + res);
			table.ajax.reload();//on success, refresh book list to get new data
			$('#addBookModal').modal('hide');//hide the edit book modal
			$('#addBookForm')[0].reset();
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
	$(document).on('click', 'button.btn-book-edit', function(e){
		var rowIdx = $($(e.target).parents('tr')[0]).index();// clicked row index
		var row = table.rows(rowIdx).data()[0];// clicked row data
		
		//fill in edit form fields with clicked row data
		$('#editBookModal_title').val(row.title);
		$('#editBookModal_price').val(row.price);
		$('#editBookModal_description').val(row.description);
		$('#editBookModal_stock').val(row.stock);
		$('#editBookModal_author').val(row.author_id);
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
			console.log('Affected Rows: ' + res);
			table.ajax.reload();//on success, refresh book list to get updated data
			$('#editBookModal').modal('hide');//hide the edit book modal
			$('#editBookForm')[0].reset();
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
	$(document).on('click', 'button.btn-book-delete', function(e){
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
			$('#deleteBookModal').modal('hide');//hide the edit book modal
			$('#deleteBookForm')[0].reset();
			toastr["success"]("","The book has been deleted successfully!");//show message to user
		})
		.fail(function(err) {
			console.log(err);//on error, log the error
			toastr["error"]("The book's deletion failed.", "Delete Error");//show message to user
		});
		
	});
	//delete book - end
}
// book management - end