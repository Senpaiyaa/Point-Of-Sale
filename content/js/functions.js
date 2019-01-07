
$(function() {
	var col = 2;
	$('[data-toggle="tooltip"]').tooltip();
    $("#menu-toggle").click(function(e) {
    	e.preventDefault();
	    $("#wrapper").toggleClass("toggled");
	});
	$('span a[id="action"]').next().css("display", "none");
		$.each($("table").find("tr"), function(){
		  var active = $(this).children().eq(col).text();
		  $(this).click(function() {
			  // log(active);
			  $("#item").text(active);
		  	});
		});
		$("#select_all").click(function () {
		    $("input[type='checkbox']").prop('checked', $(this).prop('checked'));
		});
		$("span[title='Edit']").click(function() {
			log($(this));
		});
	check_active_item();
	$('#btnCompleteSubmit').click(function() {
		redirect_to("save_sales.php");
	});
});

function SaveModal(e) {
	$(document).on('hidden.bs.modal', function (event) {
		  if ($('.modal:visible').length) {
		    $('body').addClass('modal-open');
		  }
	});
}

function delete_item(id) {
	DeleteForm();
}

function DeleteForm() {
	$("#delete-modal").modal('show');
} 


function log(value) {
	value === undefined ? console.log("No value") : console.log("Value: " + value);
}


function check_active_item() {
    $("input[type='checkbox']").on('click', function() {
	    var $row = $(this).closest("tr");
	    var $tds = $row.find("td");
	    $.each($tds, function() {
	        log($(this).text());
	    });
    });
}

function category_add() {
	$("#add_category").show('modal');
}

function category_edit(id) {
	window.location = "edit_category.php?category_id=" + id;
}

function category_delete(id) {
	window.location = "remove_category.php?category_id=" + id;	
}

function item_delete(id) {
	window.location = "remove_item.php?stock_id=" + id;
}

function edit_manufacturer(id) {
	window.location = "edit_manufacturer.php?manufacturer_id=" + id;
}

function delete_manufacturer(id) {
	window.location = "remove_manufacturer.php?manufacturer_id=" + id;
}

function edit_employee(id) {
	window.location = "edit_employee.php?staff_id=" + id;
}

function redirect_to(page) {
	window.location = page;
}

function submit_unsuspend(id) {
	window.location = "unsuspend.php?suspended_sales_id=" + id;
}

function reactivate_account(id) {
	window.location = "reactivate.php?staff_id=" +id;
}

