jQuery(document).ready(function () {
    //check if session has user id.
    sessionMonitor("user");

    //initialize searchForm
    var searchForm = new Varien.searchForm('search_mini_form', 'search', '');
    searchForm.initAutocomplete(hostURL, 'search_autocomplete');

    //initialize loginForm
    var dataForm = new VarienForm('login-form', true);

    //initialize newsletter
    var newsletterSubscriberFormDetail = new VarienForm('newsletter-validate-detail2');

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

    jQuery(window).bind('resize load', MageResize);

    // Custom Navigation Events
    jQuery(".next_new").click(function () {
        owl.trigger('owl.next');
    })
    jQuery(".prev_new").click(function () {
        owl.trigger('owl.prev');
    })


    var owl1 = jQuery("#owl-specials-products");
    owl1.owlCarousel({
        autoHeight: false,
        pagination: false,
        items: 4,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [991, 3],
        itemsTablet: [768, 2],
        itemsMobile: [479, 1]

    });

    // ----- Slide down carousel script
    function MageResize2() {
        var bodyWidthTest = jQuery('.page').width();
        if (bodyWidthTest >= 1200) {

            jQuery(".specials_products .index_item .prod_additional").removeAttr("style");
            var carousel_height = jQuery(".specials_products .owl-wrapper").height();
            var prod_additional_height = jQuery(".specials_products .index_item .prod_additional").outerHeight();
            var thumb_height = jQuery(".specials_products .index_item .product-thumbs").outerHeight();
            var total_height = carousel_height + prod_additional_height + thumb_height;
            if (prod_additional_height != 0) {
                jQuery(".specials_products .owl-specials-products").height(carousel_height + 20);
                jQuery(".specials_products .owl-wrapper-outer").height(carousel_height);
                jQuery(".specials_products .index_item .prod_additional").outerHeight(0);
            }

            jQuery('.specials_products .index_item').hover(function () {
                var bodyWidthTest2 = jQuery('.page').width();
                if (bodyWidthTest2 >= 1200) {
                    jQuery(".specials_products .owl-wrapper-outer").height(total_height);
                    jQuery(".prod_additional", this).outerHeight(prod_additional_height);
                }
            }, function () {
                var bodyWidthTest2 = jQuery('.page').width();
                if (bodyWidthTest2 >= 1200) {
                    jQuery(".specials_products .owl-wrapper-outer").height(carousel_height);
                    jQuery(".prod_additional", this).outerHeight(0);
                }
            });

        } else {
            jQuery(".specials_products .owl-specials-products").removeAttr("style");
            jQuery(".specials_products .owl-wrapper-outer").removeAttr("style");
            jQuery(".specials_products .index_item .prod_additional").removeAttr("style");
        }
    }

    jQuery(window).bind('resize load', MageResize2);


    // Custom Navigation Events
    jQuery(".next_specials").click(function () {
        owl.trigger('owl.next');
    })
    jQuery(".prev_specials").click(function () {
        owl.trigger('owl.prev');
    })


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


jQuery(window).load(function () {
    //login-register initialization
    jQuery().youamaAjaxLogin({
        redirection: '0',
        profileUrl: ajaxLoginSURL,
        autoShowUp: 'no',
        controllerUrl: hostURL
    });
});

//session check for userid.
function sessionMonitor(user) {
    if (sessionStorage.getItem(user) || !!sessionStorage.getItem(user)) {
        jQuery(".top-links .top-links-inline .links ul .last a")
            .text("Log out")
            .attr({
            "href": "#",
            "title": "Log out"
        });
       
    }
}
