var xmlhttp;
function show_orders() {
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = show_orders_response;
	xmlhttp.open("GET","ajax/showall_orders.php",true);
	xmlhttp.send();
}
	
function show_orders_response() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("maincontent").innerHTML = xmlhttp.responseText;
	}
}


function show_customers() {
	$.ajax('ajax/show_allusers_json.php', { success: show_customers_json} );
}


function show_customers_json(x,y,z) {
	var o = JSON.parse(x);
	$('#maincontent').html('<table class="table" id="custtable"><thead><tr><th>ID</th><th>Fname</th><th>Lname</th></tr></thead><tbody></tbody></table>');
	for(var i = 0; i< o.length;i++) {
		var t = '<tr><td>'+ o[i].ID+'</td><td>'+o[i].Fname+'</td><td>'+o[i].Lname+'</td></tr>';
		$('#custtable TBODY').append(t);

	}

	$.each(o,function(i,x) {
		$('#custtable TBODY').append('<tr><td>'+ x.ID+'</td><td>'+x.Fname+'</td><td>'+x.Lname+'</td></tr>');
	});
}

