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
});

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
            }).on("click", function () {
                ajaxLogoutController("user");
            });
       
    }
}

//logout for user.
function ajaxLogoutController(user) {
    window.location.reload();
    sessionStorage.removeItem(user);
}

//setting page titles.
function setPageTitles(title) {
    $("pageTitle").update("'" + title + "'");
    $("containerPageTitle").update(title);
    $("mainPageTitle").update("Search results for : '" + title + "'");
}

