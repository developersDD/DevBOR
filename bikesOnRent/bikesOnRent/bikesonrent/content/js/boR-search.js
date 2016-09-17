jQuery(document).ready(function () {
    var bknm = getParameterByName('bikename');
    var srchurl = "http://192.168.0.11/BikesOnRent1/services/services.php";
    _getSearchedProductResults(srchurl,bknm);
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


function _getSearchedProductResults(url, element) {
    url += "?bikename=" + element + "";
    //ajax call
    jcnlGlobalAjax(mthdG,null,url,updateProducts,updateNoProducts);
}

function updateProducts(dt) {
    var bk_dt = JSON.parse(dt);
    //var plt = document.createElement("li");
    //plt.className = "item first col-xs-12 col-sm-4";
    //plt.setAttribute("itemscope","");
    //plt.setAttribute("itemtype", "#");
    //var wr_dv = document.createElement("div");
    //wr_dv.className = "wrapper-hover";
    //plt.appendChild(wr_dv);
    //document.getElementById("borProducts").appendChild(plt);
    for (var i = 0; i < bk_dt.length; i++) {
        jQuery(".products-grid").append('<li class="item first col-xs-12 col-sm-4" itemscope itemtype="#">' +
                      '<div class="wrapper-hover">' +
                      '<div class="product-image-container">' +
                      '<a href="#" title="'+bk_dt[i].name+'" class="product-image" itemprop="url">' +
                      '<img id="product-collection-image-11" src="../content/images/bike1.png" width="210" height="210" />' +
                       '</a>' +
                      '</div>' +
                       '<div class="product-info"><h2 class="product-name">' + bk_dt[i].name + '</h2>' +
                       '<div class="price-box" itemprop="offers" itemscope itemtype="#">' +
                       '<span class="regular-price" itemprop="price" id="product-price-11">' +
                       '<span class="price"><b>Rs.' + bk_dt[i].rate_per_hr + '</b>/hr</span> </span>' +
                     '</div>'+
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

function updateNoProducts(dt) {
    alert(dt);
}



