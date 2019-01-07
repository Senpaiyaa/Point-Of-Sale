function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
    function(m,key,value) {
      vars[key] = value;
    });
    return vars;
}
$(document).ready(function() {
    var product_id = getUrlVars()["product_id"];
    if (product_id.length) {
        console.log(product_id);
        $('small').hide();
        $("label[for='product_name']").css({
            "color": "#555555"
        });
        $("label[for='selling_price']").css({
            "color": "#555555"
        });
    }
});
