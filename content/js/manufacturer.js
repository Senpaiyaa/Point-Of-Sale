$('#manufacturer_form').submit(function(){
    var error = false;
    var manufacturer_name_length = $('#manufacturer_name').val().trim().length;

    if(manufacturer_name_length===0){
        error = true;
        $('#empty_manufacturer_name').show();
    }

    else{
        $('#empty_manufacturer_name').hide();
    }

    return !error;
});
