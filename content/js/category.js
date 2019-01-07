$('#category_form').submit(function(){
    var error = false;
    var category_name_length = $('#category_name').val().trim().length;

    if(category_name_length===0){
        error = true;
        $('#empty_category').show();
    }

    else{
        $('#empty_category').hide();
    }

    return !error;
});
