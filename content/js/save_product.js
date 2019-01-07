$('#product_form').submit(function(){
    var product_name_length = $('#product_name').val().trim().length;
    var selling_price_length = $('#selling_price').val().trim().length;

    
    if(product_name_length===0){
        error = true;
        $('#empty_name').show();
    }
    if(selling_price_length=== 0) {
        error = true;
        $('#empty_selling_price').show();
    }

    else{
        error = false;
        $('#empty_name').hide();
        $('#empty_selling_price').hide();
        $('#barcode_exists').hide();
    }

    return !error;
});