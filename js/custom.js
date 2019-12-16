var booksTable = $('#booksTable');
if(booksTable.length){
	var table = $('#booksTable').DataTable({
		"paging": true,
		"lengthChange": true,
		"pageLength": 10,
		"lengthMenu": [
		[10, 15, 20, 50, -1],
		[10, 15, 20, 50, "All"]
		],
		"autoWidth": true,
		"processing": true,
		"serverSide": true,
		"pagingType": "full_numbers",
		"columnDefs": [{
			"orderable": false,
			"searchable": false,
			"targets": [0,6]
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
				return '<div title="click for details" class="book-description-truncate" data-description="'+data+'">'+data.substring(0, 30)+'...</div>'
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

	var createBtn = $('<button class="btn btn-outline-success btn-sm mb-1" title="Add Book"><img src="img/controls/create.png" alt="Add New">New Book</button>');
	$('#custom-btns').append(createBtn);

	$(document).on('click', 'button.btn-book-edit', function(e){
		var rowIdx = $($(e.target).parents('tr')[0]).index();// clicked row index
		var row = table.rows(rowIdx).data()[0];// clicked row data
		
		$('#editBookModal_title').val(row.title);
		$('#editBookModal_price').val(row.price);
		$('#editBookModal_description').val(row.description);
		$('#editBookModal_stock').val(row.stock);
		$('#editBookModal_author').val(row.author_id);
		$('#editBookModal_category').val(row.category_id);

		var id = $(e.target).data('id');
		$('#editBookModal_bookID').val(id);
		$('#editBookModal').modal('show');
	});

	var currentBookDescription;
	var expanded = false;
	$(document).on('click', '.book-description-truncate', function(e){
		if(expanded) return;
		var descr = $(e.target).data('description');
		currentBookDescription = $(e.target).html();
		$(e.target).html(descr);
		expanded = true;
	});
	$(document).on('mouseout', '.book-description-truncate', function(e){
		if(!expanded) return;
		$(e.target).html(currentBookDescription);
		currentBookDescription = null;
		expanded = false;
	});

	$(document).on('submit', '#editBookForm', function(e){
		e.preventDefault();
		$('#editBookForm input,select,textarea,button').prop('disabled', true);
		
		$.ajax({
			url: 'internal/book_manage.php',
			type: 'POST',
			data: $(e.target).serialize() + '&editBookSubmit'
		})
		.done(function(res) {
			console.log(res);
			table.ajax.reload();
			$('#editBookModal').modal('hide');
		})
		.fail(function(err) {
			console.log(err);
		})
		.always(function() {
			$('#editBookForm input,select,textarea,button').prop('disabled', false);
		});
		
	});
}