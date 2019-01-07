var barcode_value = null;
var error = false;

$('#product_barcode').on('focusout', function() {
    barcode_value = $('#product_barcode').val();
    var callback = function(response) {
        console.log(response);
        if(response.found){
            if (barcode_value == response["product"]["product_barcode"]) {
                error = true;
                console.log(response["found"]);
                $('#barcode_exists').show();
            }
        } else {
            error = false;
            console.log("not existing");
            $('#barcode_exists').hide();
        }
    }
    $.ajax({
        'method': "post",
        'url': "ajax/save_product.php",
        'data': {'product_barcode' : $('#product_barcode').val()},
        'success': callback
    });

});

$(document).keypress(function(e){
    var barcode_value = $('#product_barcode').val();
    var error = false;

    if (e.which === 13) {
        barcode_value = $('#product_barcode').val();
        var callback = function(response) {
            console.log(response);
            if(response.found){
                if (barcode_value == response["product"]["product_barcode"]) {
                    error = true;
                    console.log("existing");
                    $('#barcode_exists').show();
                } else {
                    $('#barcode_exists').hide();                    
                }
            } else {
                error = false;
                console.log("not existing");
                $('#barcode_exists').hide();
            }
        }
        $.ajax({
            'method': "post",
            'url': "ajax/save_product.php",
            'data': {'product_barcode' : $('#product_barcode').val()},
            'success': callback
        });
    }
});
$('#product_form').submit(function(){
    var product_name_length = $('#product_name').val().trim().length;
    var selling_price_length = $('#selling_price').val().trim().length;

    
    if(product_name_length==0){
        error = true;
        $('#empty_name').show();
    }
    if(selling_price_length == 0) {
        error = true;
        $('#empty_selling_price').show();
    }

    else{
        $('#empty_name').hide();
        $('#empty_selling_price').hide();
        $('#barcode_exists').hide();
    }

    var callback = function(response) {
        console.log(response);
        if(response.found){
            barcode_value = $('#product_barcode').val();
            if (barcode_value == response["product"]["product_barcode"]) {
                error = true;
                $('#barcode_exists').show();
            } else {
                $('#barcode_exists').hide();                
            }
        }
    }
    $.ajax({
        'method': "post",
        'url': "ajax/save_product.php",
        'data': {'product_barcode' : $('#product_barcode').val()},
        'success': callback
    });

    return !error;
});
