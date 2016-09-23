jQuery(document).ready(function () {
    //check if session has user id.
    sessionMonitor("user");

    //call remember me login.
    rememberMeLogin();

    //initialize searchForm
    var searchForm = new Varien.searchForm('search_mini_form', 'search', '');
    searchForm.initAutocomplete(hostURL, 'search_autocomplete');

    //initialize loginForm
    var dataForm = new VarienForm('login-form', true);

    //initialize registerForm
    var dataForm = new VarienForm('register-form', true);
});

//toggle remember me.s
function toggleRememberMePopup() {
    var formParent = jQuery(this).parents('form:first');
    formParent.find('.remember-me-box a').toggleClass('hide');
    formParent.find('.remember-me-popup').toggleClass('show');
    return false;
}

//for login remember me(currently not in use)
function rememberMeLogin() {
    var rememberMeToggleSetup = false;
    if (rememberMeToggleSetup) {
        jQuery('.remember-me-box a, .remember-me-popup a').on('click', toggleRememberMePopup);
        rememberMeToggleSetup = true;
    }
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
        //remove register link
        jQuery('li a.register-link', '.top-links-inline').parent().remove();
        //change to logout
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

