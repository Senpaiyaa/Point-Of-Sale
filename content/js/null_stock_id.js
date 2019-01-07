function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
    function(m,key,value) {
      vars[key] = value;
    });
    return vars;
}
$(document).ready(function() {
	var stock_id = getUrlVars()["stock_id"];
	if (stock_id.length) {
		console.log(stock_id);
	    $('#product, #product_quantity, #supplier_id').attr('disabled', 'disabled');
	    $("label[for='cost_price']").addClass('control-label');
	}
});
