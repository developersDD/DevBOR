var ttlpg, pg;
jQuery(document).ready(function () {
    var bknm = getParameterByName(queryParamBikeByName);
    _getSearchedProductResults(hostURL, bknm);
    //set page titles.
    setPageTitles(bknm);
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
    url += queryDelimeter + queryParamBikeByName + equalsOperator + element;
    //ajax call
    jcnlGlobalAjax(mthdG,null,url,updateProducts,updateProductsFailure);
}

function updateProducts(dt) {
    setPaginationData();
    var bk_dt = JSON.parse(dt);
    if (bk_dt == "No Data Found") {
        updateProductsFailure(dt);
    }
    else {
        for (var i = 0; i < bk_dt.length; i++) {
            jQuery(".products-grid").append('<li class="item first col-xs-12 col-sm-4" itemscope itemtype="#">' +
                          '<div class="wrapper-hover">' +
                          '<div class="product-image-container">' +
                          '<a href="#" title="' + bk_dt[i].name + '" class="product-image" itemprop="url">' +
                          '<img id="product-collection-image-11" src="../content/images/bike1.png" width="210" height="210" />' +
                           '</a>' +
                          '</div>' +
                           '<div class="product-info"><h2 class="product-name">' + bk_dt[i].name + '</h2>' +
                           '<div class="price-box" itemprop="offers" itemscope itemtype="#">' +
                           '<span class="regular-price" itemprop="price" id="product-price-11">' +
                           '<span class="price"><b>Rs.' + bk_dt[i].rate_per_hr + '</b>/hr</span> </span>' +
                         '</div>' +
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

}

function updateProductsFailure(dt) {
    jQuery(".products-grid").append('<li class="col-xs-12 col-sm-12 col-md-12 col-lg-12">' +
                      '<p style="font-size:16px;text-align:center;background-color:whitesmoke;line-height:35px">'+
                      'No Results for bikes</p></li>');
}


function setPaginationData() {
    jQuery('#pagination-content').bootpag({
        total: 10,
        page: 1,
        maxVisible: 5
    }).on("page", function (event, page) {
        alert(page);
        // some ajax content loading...
    });
}
