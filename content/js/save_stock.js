$('#stock_form').submit(function(){
    var error = false;
    var cost_price_length = $('#cost_price').val().trim().length;
    if(cost_price_length===0){
        error = true;
        $('#empty_cost_price').show();
    }
    else{
        $('#empty_cost_price').hide();
    }

    return !error;
});