﻿jQuery(document).ready(function () {
    //get all bikes.
    getAllBikes();

    //news letter
    var newsPopup = jQuery('#newsletterpopup');
    var newsPopupClose = newsPopup.find('.close');
    var showNewsPopup = sessionStorage.getItem("showNewsPopup");
    if (showNewsPopup != '0') {
        newsPopup.modal();
        disable_scroll();
    };

    newsPopupClose.click(function () {
        sessionStorage.setItem("showNewsPopup", '0');
        enable_scroll();
    });
    jQuery('body').click(function () {
        enable_scroll();
    });
});

function disable_scroll() {
    jQuery('body').bind('touchmove', function (e) { e.preventDefault() });
}

function enable_scroll() {
    jQuery('body').unbind('touchmove');

}

//getAllBikes(for sale or discount and offers)
function getAllBikes() {
    var url = hostURL + "?getallbike";
    jcnlGlobalAjax(mthdG, null, url, updateNewProducts, "");
}

//update new products.
function updateNewProducts(dt) {
    jQuery("#newProducts").append('<h2 class="subtitle">New Products</h2><div class="carousel_nav">' +
                             '<a class="btns prev_new"><span class="fa fa-caret-left"></span></a>' +
                             '<a class="btns next_new"><span class="fa fa-caret-right"></span></a>' +
                             '</div><div class="owl-carousel-wrapper owl-new-products">' +
                             '<div class="owl-carousel owl-new" id="owl-new-products"></div></div>');
    var data = JSON.parse(dt);
    for (var i = 0; i < data.length; i++) {
        jQuery("#owl-new-products").append('<div class="item index_item"><div class="item_wrap"><a href="#" title="Bell Fraction Multi-Sport Helmet" class="product-image">' +
                        '<img src="../content/images/bike1.png" alt="Bell Fraction Multi-Sport Helmet" /></a>' +
                        '<div class="product-shop"><h3 class="product-name"><a href="#" title="Bell Fraction Multi-Sport Helmet" itemprop="name">Bell Fraction Multi-Sport Helmet</a></h3>' +
                        '<div class="price-box" itemprop="offers" itemscope itemtype="#"><span class="regular-price" itemprop="price" id="product-price-19-new">' +
                        '<span class="price">$130.00</span></span></div><div class="prod_additional"><div class="ratings">' +
                        '<div class="rating-box stars"><i class="material-design-mark1"></i><i class="material-design-mark1"></i>' +
                        '<i class="material-design-mark1"></i><i class="material-design-mark1"></i><i class="material-design-mark1"></i>' +
                        '<div class="rating" style="width: 80%"><div class="mask"><i class="material-design-mark1"></i>' +
                        '<i class="material-design-mark1"></i><i class="material-design-mark1"></i><i class="material-design-mark1"></i>' +
                        '<i class="material-design-mark1"></i></div></div></div><span class="amount"><a href="#">1 Review(s)</a></span></div>' +
                        '<div class="actions"><div class="sm_btn_wrapp"><button type="button" title="Add to Cart" class="button btn-cart"><span><span>Add to Cart</span></span></button>' +
                        '</div><div class="btns_wrap"><a href="#" class="lnk_icons"><span class="material-design-favorite22"></span></a>' +
                        '<a href="../content/images" class="lnk_icons"><span class="material-design-shuffle24 "></span></a>' +
                        '</div></div></div></div><div class="label-product"><span class="new">New</span></div></div></div>')
    }

    //initialize owlCarousel for new products
    var owl = jQuery("#owl-new-products");
    owl.owlCarousel({
        autoHeight: false,
        pagination: false,
        items: 4,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [991, 3],
        itemsTablet: [768, 2],
        itemsMobile: [479, 1]
    });

    //adjust screen after owl-carousal
    MageResize();
    jQuery(window).bind('resize load', MageResize);

    // Custom Navigation Events
    jQuery(".next_new").click(function () {
        owl.trigger('owl.next');
    })
    jQuery(".prev_new").click(function () {
        owl.trigger('owl.prev');
    })
}


//update special products.
function updateSpecialProducts(dt){

}

// ----- Slide down carousel script
function MageResize() {
    var bodyWidthTest = jQuery('.page').width();
    if (bodyWidthTest >= 1200) {
        jQuery(".new_products .index_item .prod_additional").removeAttr("style");
        var carousel_height = jQuery(".owl-wrapper").height();
        var prod_additional_height = jQuery(".index_item .prod_additional").outerHeight();
        var thumb_height = jQuery(".new_products .index_item .product-thumbs").outerHeight();
        var total_height = carousel_height + prod_additional_height + thumb_height;

        if (prod_additional_height != 0) {
            jQuery(".new_products .owl-new-products").height(carousel_height + 24);
            jQuery(".new_products .owl-wrapper-outer").height(carousel_height);
            jQuery(".new_products .index_item .prod_additional").outerHeight(0);
        }

        jQuery('.new_products .index_item').hover(function () {
            var bodyWidthTest2 = jQuery('.page').width();
            if (bodyWidthTest2 >= 1200) {
                jQuery(".new_products .owl-wrapper-outer").height(total_height + 8);
                jQuery(".prod_additional", this).outerHeight(prod_additional_height);
            }
        }, function () {
            var bodyWidthTest2 = jQuery('.page').width();
            if (bodyWidthTest2 >= 1200) {
                jQuery(".new_products .owl-wrapper-outer").height(carousel_height);
                jQuery(".prod_additional", this).outerHeight(0);
            }
        });

    } else {
        jQuery(".new_products .owl-new-products").removeAttr("style");
        jQuery(".new_products .owl-wrapper-outer").removeAttr("style");
        jQuery(".new_products .index_item .prod_additional").removeAttr("style");
    }
}