var sales_details = [];
var product = {};
var valid_sales = getUrlVars()["total_sales"];

function reset(){
	$('#barcode').val('');
	$('#tbody').empty();
	$('#total_sales').html('');
	sales_details = [];
	product = {};
	window.location.reload();
	console.clear();
}

function openWindow(url){
    var w = window.open(url);
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
    function(m,key,value) {
      vars[key] = value;
    });
    return vars;
}


$('#payment-form').submit(function(){
	var cash = parseFloat($('#amount_paid').val());
	var total = $('#total_sales').html();
	var discount = $('#discount');
	var link = "";

	if (valid_sales == total) {
		log(valid_sales + " not exceeded");
		var callback = function(response){
			console.log(response);
			$('#payment-modal').modal('hide');
			$('#complete-modal').modal('show');
			$('#print').attr('href','plain_receipt.php?sales_id='+response);
			link ="plain_receipt.php?sales_id="+response;
			openWindow("plain_receipt.php?sales_id="+response);
		};

		var post_data = {
			'sales' : sales,
			'sales_details' : sales_details
		};

		$.ajax({
			'method' : 'post',
			'url' : 'ajax/process_return.php',
			'data' : post_data,
			'success' : callback
		});				
	} else {
		alert("Valid total of cash exceeded " +valid_sales);
		log(valid_sales)
	}

	//reset();
	return false;

});

function show_payment_modal(){
	$('#amount_paid').val(parseFloat($(total_sales).html()));
	$('#amount_change').val(0);
	$('#payment-modal').modal('show');
}

function sales_details_table(){
	var total_sales = 0;
	var output = [];

	$('#tbody').empty();
	for(var x=0; x<sales_details.length; x++){
		var temp = sales_details[x];
		product = temp.product;
		quantity = temp.quantity;
		total =  (temp.total);
		var row = '<tr class="item" id="'+x+'">';
		row+= '<td id="product_name">'+product.product_name+ '</td>';
		row+= '<td id="selling_price" class="text-right">'+parseFloat(product.selling_price).toFixed(2)+'</td>';
		row+= '<td id="quantity" class="text-right">'+quantity+'</td>';
		row+= '<td id="total" class="text-right">'+total.toFixed(2)+'</td>';
		row+= '<td class="text-right text-danger pointer" onclick="remove('+product.product_id+')">Remove</td>';
		row+= '</tr>';

		total_sales+= total;

		$('#tbody').append($(row));
	}
	$('#total_sales').html(total_sales.toFixed(2));
}

$('#add-product-form').on('submit', function(){
	var quantity = parseInt($('#quantity').val());
	var total = compute_product_total();
	var this_button = $('#add-product-form button');

	var temp = {
		'product' : product,
		'total' : total,
		'quantity' : quantity
	}

	var unique = true;
	var index = -1;
	for(var x=0; x<sales_details.length; x++){
		var this_product_id = sales_details[x].product.product_id;
		if(product.product_id===this_product_id){
			unique = false;
			index = x;
			break;
		}
		console.log(product.product_id+" vs "+this_product_id);
	}

	if(unique){
		sales_details.push(temp);
	}
	else{
		var this_product = sales_details[index];
		var new_product = {
			'product' : product,
			'total' : total + this_product.total,
			'quantity' : quantity + this_product.quantity
		};
		sales_details[index] = new_product;
	}
	// sales_details.push(function() {
	// 	if (temp.product == ) {}
	// })

	sales_details_table();

	$('#product-quantity-modal').modal('hide');
	return false;
});			

function quantity_change(){
	var total = compute_product_total();
	// log(total);
	$('#total').val(total);
}

function compute_product_total(){
	var qty = parseInt($('#quantity').val());
	return product.selling_price * qty;
}

function show_product_modal(){
	$('#barcode').val(null);
	$('#product-modal').modal('show');	
}

function show_product_quantity_modal(){
	// $('#product-quantity-modal').modal('show');
	//$('#quantity').val(1);
	$('#product_name').val(product.product_name);
	$('#price').val(product.selling_price);
	compute_product_total();
	$('#add-product-form').submit();
	$('#barcode').val('');
	$('#quantity').val('1');
	$('#barcode').focus();
}

$('#product-form').submit(function(){
	$('#product-not-found').hide();
	var this_button = $('#product-form button');
	var length = false;
	var formId = this.id;
	log(formId);
	if ($(this_button).length) {
		length = true;
	}
	log(length);
	var callback = function(response){
		console.log(response);
		if(response.found){
			product = response.product;
			if (response['product']['product_quantity'] == 0) {
				alert("This item is not available!");
			} else {
				// log(product);
				$('#product-modal').modal('hide');
				show_product_quantity_modal();
				
			}
		}
		else{
			$('#product-not-found').show();
			$('#barcode').val('');
			$('#barcode').focus();
			setTimeout(function() {
				$('#product-not-found').hide();
			}, 3000);
		}
	};

	$.ajax({
		'method' : 'post',
		'data' : {'product_barcode' : $('#barcode').val()},
		'url' : 'ajax/search_product.php',
		'success' : callback
	});

	return false;
});

function remove(product_id) {
	var index = -1;
	for(var x=0; x<sales_details.length; x++){
		var temp = sales_details[x];
		if(temp.product.product_id==product_id){
			index = x;
			break;
		}
	}
	if (index > -1) {
	    sales_details.splice(index, 1);
	    sales_details_table();
	}}

function show_cancel_modal() {
	$('#cancel_sale').modal('show');
}

