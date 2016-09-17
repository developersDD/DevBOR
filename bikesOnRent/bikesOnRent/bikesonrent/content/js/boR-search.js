jQuery(document).ready(function () {
    var bknm = getParameterByName('bikename');
    var srchurl = "";
    getSearchedProductResults(srchurl,bknm);
});


//get bikename from window location.
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}


function getSearchedProductResults(url, element) {
    for (var j = 0; j < 12; j++) {
        jQuery(".products-grid").append('<li class="item first col-xs-12 col-sm-4" itemscope itemtype="#">' +
                      '<div class="wrapper-hover">' +
                      '<div class="product-image-container">' +
                      '<a href="#" title="SafeCycler LED Bike Lights" class="product-image" itemprop="url">' +
                      '<img id="product-collection-image-11" src="../content/images/brand1.gif" width="210" height="210" />' +
                       '</a>' +
                      '</div>' +
                       '<div class="product-info">' +
                       '<div class="price-box" itemprop="offers" itemscope itemtype="#">' +
                       '<span class="regular-price" itemprop="price" id="product-price-11">' +
                       '<span class="price">€24.73</span> </span>' +
                     '</div>' +
                    '<h2 class="product-name"><a href="#" title="SafeCycler LED Bike Lights">'+
                    'WOLFBIKE Non-Slip Gel Pad Gloves Mens Womens Sportswear Bike Bicycle Cycling Riding Short Half Finger Gloves Breathable </a></h2>' +
                     '<div class="wrapper-hover-hiden">' +
                      '<div class="actions">' +
                     '<button type="button" title="Add to Cart" class="button btn-cart" onclick="setLocation("#")">' +
                    '<span><span>Add to Cart</span></span></button>' +
                       '<ul class="add-to-links">' +
                     '<li><a href="#" class="link-wishlist">Add to Wishlist</a></li>' +
                      '<li><span class="separator">|</span> <a href="#" class="link-compare">Add to Compare</a></li>' +
                       '</ul>' +
                       '</div>' +
                        '</div>' +
                       '</div>' +
                       '<div class="label-product">' +
                       '</div>' +
                      ' </div>' +
                     '</li>');
    }

}