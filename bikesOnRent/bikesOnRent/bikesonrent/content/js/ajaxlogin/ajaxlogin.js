/**
 * RentalBikes
 *
 * NOTICE OF LICENSE
 *
/* This source file is subject to the user login and registration.*/
(function ($) {
    $.fn.rentalbikesAjaxLogin = function(options) {
        var opts = $.extend({}, $.fn.rentalbikesAjaxLogin.defaults, options);
        return start();
        /**
         * Init.
         */
        function start() {
            // Add windows from Ajaxlogin view to RWD dropdown
            replaceAjaxWindows();
            // Disable links what are linked to login or register pages
            removeOriginalJsLocations();
            // Open and close windows
            openCloseWindowEvents();
            // Ajax calls
            sendEvents();
        }

        /**
         * Add windows from Ajaxlogin view to RWD dropdown include the Loader.
         */
        function replaceAjaxWindows() {
            var loginWindow = $('.rentalbikes-login-window');
            var registerWindow = $('.rentalbikes-register-window');
            var loader = $('.rentalbikes-ajaxlogin-loader');
            var confirmMsg = $('.rentalbikes-confirmmsg-window');
            $('#header-account2').html(loginWindow);
            $('#header-account2').append(registerWindow);
            $('#header-account2').append(loader);
            $('#header-account2').append(confirmMsg);
        }

        /**
         * Disable links what are linked to login or register pages.
         */
        function removeOriginalJsLocations() {
            $('a[href*="user-registration.html?register"], ' +
                'a[href*="user-login.html?login"], ' +
                '.customer-account-login .new-users button')
                .attr('onclick', 'return false;');
        }

        /**
         * Open, close and switch Login and Register windows.
         */
        function openCloseWindowEvents() {
            // Login open - auto
            if (opts.autoShowUp == 'yes'
                && $('.messages').css('display') != 'block') {
                $('.skip-links2 .skip-account2').trigger('click');
                animateShowWindow('login');
            }
            // Login open and close - click
            $('.skip-links2 .skip-account2').on('click', function() {
                // Close
                if ($('.rentalbikes-login-window').css('display') != 'none'
                    || $('.rentalbikes-register-window').css('display') != 'none') {
                    animateCloseWindow('login', false, false);
                // Open
                } else {
                    animateShowWindow('login');
                }
                return false;
            });
            // Open login window by back-link on customer/account/forgotpassword
            $('a[href*="user-login.html?login"]').click(function () {
                $('.skip-links2 .skip-account2').trigger('click');
                animateCloseWindow('register', false, false);
                animateShowWindow('login');
                $("#header-account2").css({ "width": "450px", "left": "45%" });
                return false;

            });
            // Switching between Login and Register windows
            $('.yoauam-switch-window').on('click', function() {
                // Close Register window and open Login window
                if ($(this).attr('id') == 'y-to-login') {
                    animateTop();
                    animateCloseWindow('register', false, false);
                    animateShowWindow('login');
                    $("#header-account2").css({ "width": "450px" ,"left":"45%"});

                // Open Login window and close Register window
                } else {
                    animateTop();
                    animateCloseWindow('login', false, false);
                    animateShowWindow('register');
                    $("#header-account2").css({"width":"600px","left":"40%"});
                }
            });
            // Open register window
            $('a[href*="user-registration.html?register"], .new-users button')
                .on('click', function() {
                $('.skip-links2 .skip-account2').trigger('click');
                animateCloseWindow('login', false, false);
                animateShowWindow('register');
                $("#header-account2").css({ "width": "600px", "left": "40%" });
                return false;
            });
            // Close login window by user
            $('.rentalbikes-login-window .close').click(function () {
                animateCloseWindow('login', true, true);
                $('div.shadow').removeClass('active-form');
                 $('body').removeClass('ind');
            });
            // Close register window by user
            $('.rentalbikes-register-window .close').click(function() {
                animateCloseWindow('register', true, true);
                $('div.shadow').removeClass('active-form');
                 $('body').removeClass('ind');
            });

            // Close confirmMsg window by user
            $('.rentalbikes-confirmmsg-window .close').click(function() {
                animateCloseWindow('confirmmsg', true, true);
                $('div.shadow').removeClass('active-form');
                 $('body').removeClass('ind');
            });
            // Close ajax window after drop down is closed
            autoClose();
        }

        /**
         * Scroll to top of page because of small screens.
         */
        function animateTop() {
            $('html,body').animate({scrollTop : 0});
        }

        /**
         * Registration or login request by user.
         */
        function sendEvents() {
            // Click to register in Register window
            $('.rentalbikes-register-window button').on('click', function() {
                setDatas('register');
                validateDatas('register');
                if (opts.errors != ''){
                    setError(opts.errors, 'register');
                } else {
                    callAjaxControllerRegistration('register');
                }
                return false;
            });

            // Press enter in login window
            $(document).keypress(function(e) {
                if (e.which == 13
                    && $('.rentalbikes-login-window').css('display') == 'block') {
                    setDatas('login');
                    validateDatas('login');
                    if (opts.errors != '') {
                        setError(opts.errors, 'login');
                    }
                    else {
                        callAjaxControllerLogin('login');
                    }
                }
            });

            // Click on login in Login window
            $('.rentalbikes-login-window button').on('click', function() {
                setDatas('login');
                validateDatas('login');
                if (opts.errors != '') {
                    setError(opts.errors, 'login');
                } else {
                    callAjaxControllerLogin('login');
                }
                return false;
            });

            //login from login page
            $('#send2').on('click', function () {
                var dataForm = new VarienForm('login-form', true);
                if (dataForm.validator && dataForm.validator.validate()) {
                    callAjaxControllerLogin('loginPage');
                }
            });

            //registration from login page
            $('#btnRegister').on('click', function () {
                var dataForm = new VarienForm('register-form', true);
                if (dataForm.validator && dataForm.validator.validate()) {
                    callAjaxControllerRegistration('registerPage');
                }
            });
        }

        /**
         * Display windows.
         * @param string windowName
         */
        function animateShowWindow(windowName) {
            $('.rentalbikes-' + windowName + '-window')
                .slideDown(300, 'easeInOutCirc');
        }

        /**
         * Show or hide the Loader with effects.
         * @param string windowName
         * @param int step
         */
        function animateLoader(windowName, step) {
            // Start
            if (step == 'start') {
                $('.main-'+ windowName +'-loader').fadeIn();
                $('.rentalbikes-' + windowName + '-window')
                    .animate({ opacity: '0.4' });
                $('#'+windowName+'InnerBox')
                    .animate({ opacity: '0.4' });
            // Stop
            } else {
                $('.main-' + windowName + '-loader').fadeOut('normal', function () {
                    $('.rentalbikes-' + windowName + '-window')
                        .animate({ opacity: '1' });
                    $('#' + windowName + 'InnerBox')
                    .animate({ opacity: '1' });
                });
            }
        }

        /**
         * Close windows.
         * @param string windowName
         * @param bool quickly Close without animation.
         * @param bool closeParent Close the parent drop down
         */
        function animateCloseWindow(windowName, quickly, closeParent) {
            if (opts.stop != true){
                if (quickly == true) {
                    $('.rentalbikes-' + windowName + '-window').hide();
                    $('.rentalbikes-ajaxlogin-error').hide(function() {
                        if (closeParent) {
                            $('#header-account2').removeClass('skip-active');
                        }
                    });
                } else {
                    $('.rentalbikes-ajaxlogin-error').fadeOut();
                    $('.rentalbikes-' + windowName + '-window').slideUp(function() {
                        if (closeParent) {
                            $('#header-account2').removeClass('skip-active');
                        }
                    });
                }
            }
        }

        /**
         * Validate user inputs.
         * @param string windowName
         */
        function validateDatas(windowName) {
            opts.errors = '';
            // Register
            if (windowName == 'register') {
                // There is no last name
                if (opts.lastname.length < 1) {
                    opts.errors = opts.errors + 'nolastname,'
                }

                // There is no first name
                if (opts.firstname.length < 1) {
                    opts.errors = opts.errors + 'nofirstname,'
                }

                // There is no email address
                if (opts.email.length < 1) {
                    opts.errors = opts.errors + 'noemail,'
                // It is not email address
                } else if (validateEmail(opts.email) != true) {
                    opts.errors = opts.errors + 'wrongemail,'
                }

                // There is no password
                if (opts.password.length < 1) {
                    opts.errors = opts.errors + 'nopassword,'
                // Too short password
                } else if (opts.password.length < 6) {
                    opts.errors = opts.errors + 'shortpassword,'
                // Too long password
                } else if (opts.password.length > 16) {
                    opts.errors = opts.errors + 'longpassword,'
                // Passwords doe not match
                } else if (opts.password != opts.passwordsecond) {
                    opts.errors = opts.errors + 'notsamepasswords,'
                }

                // Terms and condition has not been accepted
                if (opts.licence != 'ok') {
                    opts.errors = opts.errors + 'nolicence,'
                }


            // Login
            } else if (windowName == 'login') {
                //// There is no email address
                //if (opts.email.length < 1) {
                //    opts.errors = opts.errors + 'noemail,'
                //// It is not email address
                //} else if (validateEmail(opts.email) != true) {
                //    opts.errors = opts.errors + 'wrongemail,'
                //}

                // There is no password
                if (opts.password.length < 1) {
                    opts.errors = opts.errors + 'nopassword,'
                // Too long password
                } else if (opts.password.length > 16) {
                    opts.errors = opts.errors + 'wronglogin,'
                }
            }
        }

        /**
         * Email validator. Retrieve TRUE if it is an email address.
         * @param string emailAddress
         * @returns {boolean}
         */
        function validateEmail(emailAddress) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

            if (filter.test(emailAddress)) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Save user input data to property for ajax call.
         * @param string windowName
         */
        function setDatas(windowName) {
            // Register window
            if (windowName == 'register') {
                opts.firstname = $('.rentalbikes-' + windowName
                    + '-window #rentalbikes-firstname').val();
                opts.lastname = $('.rentalbikes-' + windowName
                    + '-window #rentalbikes-lastname').val();

                if ($('.rentalbikes-' + windowName
                    + '-window input[name="rentalbikes-newsletter"]:checked')
                    .length > 0) {
                    opts.newsletter = 'ok';
                } else {
                    opts.newsletter = 'no';
                }

                opts.email = $('.rentalbikes-' + windowName
                    + '-window .rentalbikes-email').val();
                opts.password = $('.rentalbikes-' + windowName
                    + '-window .rentalbikes-password').val();
                opts.passwordsecond = $('.rentalbikes-' + windowName
                    + '-window #rentalbikes-passwordsecond').val();

                if ($('.rentalbikes-' + windowName
                    + '-window input[name="rentalbikes-licence"]:checked')
                    .length > 0) {
                    opts.licence = 'ok';
                } else {
                    opts.licence = 'no';
                }
            // Login window
            } else if (windowName == 'login') {
                opts.email = $('.rentalbikes-' + windowName
                    + '-window .rentalbikes-email').val();
                opts.password = $('.rentalbikes-' + windowName
                    + '-window .rentalbikes-password').val();
            }
        }

        /**
         * Load error messages into windows and show them.
         * @param string errors Comma separated.
         * @param string windowName
         */
        function setError(errors, windowName) {
            $('.rentalbikes-' + windowName + '-window .rentalbikes-ajaxlogin-error')
                .text('');
            $('.rentalbikes-' + windowName + '-window .rentalbikes-ajaxlogin-error')
                .hide();
            var errorArr = new Array();
            errorArr = errors.split(',');
            var length = errorArr.length - 1;

            for (var i = 0; i < length; i++) {
                var errorText = $('.ytmpa-' + errorArr[i]).text();

                $('.rentalbikes-' + windowName + '-window .err-' + errorArr[i])
                    .text(errorText);
            }
            $('.rentalbikes-' + windowName + '-window .rentalbikes-ajaxlogin-error')
                .fadeIn();
        }

        /**
         * Ajax call for registration.
         */
        function callAjaxControllerRegistration(windowName) {
            var mregdet = new Object();
            var regdet = new Object();
            if (windowName == 'register') {
                mregdet.name = "Rohan";
                mregdet.address = "Shirdi";
                mregdet.email = "rbk@gmail.com";
                mregdet.mobile = "9858985878";
                mregdet.username = "sai";
                mregdet.password = "sai123123";
                mregdet.doc_submitted = "";
                regdet.userDetails = mregdet;
                var userDetails = JSON.stringify(regdet);
                // If there is no another ajax calling
                if (opts.stop != true) {
                    opts.stop = true;
                    // Load the Loader
                    animateLoader('register', 'start');
                    // Send data
                    jcnlGlobalAjax(mthdP, userDetails, opts.controllerUrl, callAjaxControllerRegisterSuccess, callAjaxRControllerFailed);
                }
            } else {
                mregdet.name = $('#name').val();
                mregdet.address = $('#address').val();
                mregdet.email = $('#email_address').val();
                mregdet.mobile = $('#mobile').val();
                mregdet.username = $('#username').val();
                mregdet.password = $('#password').val();
                mregdet.doc_submitted = "";
                regdet.userDetails = mregdet;
                var userDetails = JSON.stringify(regdet);
                animateLoader('registerPage', 'start');
                jcnlGlobalAjax(mthdP, userDetails, opts.controllerUrl, callAjaxControllerRegisterPageSuccess, callAjaxRControllerPageFailed);
            }
        }

        /**
        * success call for register - modal.
        */
        function callAjaxControllerRegisterSuccess(msg) {
            var response = JSON.parse(msg);
            // If there is error
            if (response.msg != 'Success') {
                alert("Registration Failed!");
                // If everything are OK
            } else {
                opts.stop = false;
                animateCloseWindow('register', false, true);
                if (response.msg == 'Success') {
                    setTimeout(
                    animateShowWindow('confirmmsg'),
                    3000);
                } else {
                    // Redirect
                    if (opts.redirection == '1') {
                        window.location = opts.profileUrl;
                        sessionStorage.setItem("user", response.userId);
                    } else {
                        window.location.reload();
                        sessionStorage.setItem("user", response.userId);
                    }
                }
            }
            animateLoader('register', 'stop');
            opts.stop = false;
        }

        /**
       * success call for register - page.
       */
        function callAjaxControllerRegisterPageSuccess(msg) {
            var response = JSON.parse(msg);
            // If there is error
            if (response.msg != 'Success') {
                alert("Registration Failed!");
                // If everything are OK
            } else {
                opts.stop = false;
                animateCloseWindow('register', false, true);
                if (response.msg == 'Success') {
                    animateShowWindow('confirmmsg');
                } else {
                    // Redirect
                        window.location = opts.profileUrl;
                        sessionStorage.setItem("user", response.userId)
                }
            }
            animateLoader('registerPage', 'stop');
            opts.stop = false;
        }

        /**
        * failure call for registration - modal.
        */
        function callAjaxRControllerFailed(msg) {
            opts.stop = false;
            animateLoader('register', 'stop');
        }

        /**
        * failure call for registration - page.
        */
        function callAjaxRControllerPageFailed(msg) {
            opts.stop = false;
            animateLoader('registerPage', 'stop');
        }

        /**
         * Ajax call for login.
         */
        function callAjaxControllerLogin(windowName) {
            var lgdt = new Object();
            var lgdt1 = new Object();
            if (windowName == 'login') {
                lgdt1.username = opts.email;
                lgdt1.password = opts.password;
                lgdt.loginDetails = lgdt1;
                var loginDetails = JSON.stringify(lgdt);
                // If there is no another ajax calling
                if (opts.stop != true) {
                    opts.stop = true;
                    // Load the Loader
                    animateLoader('login', 'start');
                    // Send data
                    jcnlGlobalAjax(mthdP, loginDetails, opts.controllerUrl, callAjaxControllerLoginSuccess, callAjaxLControllerFailed);
                }
            } else {
                lgdt1.username = $('#email').val();
                lgdt1.password = $('#pass').val();
                lgdt.loginDetails = lgdt1;
                var loginDetails = JSON.stringify(lgdt);
                animateLoader('loginPage', 'start');
                jcnlGlobalAjax(mthdP, loginDetails, opts.controllerUrl, callAjaxControllerLoginPageSuccess, callAjaxLControllerPageFailed);
            }
            
        }

        /**
        * success call for login - modal.
        */
        function callAjaxControllerLoginSuccess(msg) {
            var response = JSON.parse(msg);
            // // If there is error
            if (response.msg != 'Success') {
                alert("Invalid Username/Password!");
                //setError('wronglogin,', 'login');
                // If everything are OK
            } else {
                opts.stop = false;
                animateCloseWindow('login', false, true);
                // Redirect
                if (opts.redirection == '1') {
                    window.location = opts.profileUrl;
                    sessionStorage.setItem("user", response.userId);
                } else {
                    window.location.reload();
                    sessionStorage.setItem("user", response.userId);
                }
            }
            animateLoader('login', 'stop');
            opts.stop = false;
        }

        /**
       * success call for login - page.
       */
        function callAjaxControllerLoginPageSuccess(msg) {
            var response = JSON.parse(msg);
            // // If there is error
            if (response.msg != 'Success') {
                //set error.
                alert("Username and/or Password is worng!");
                // If everything are OK
            } else {
                // Redirect 
                    window.location = opts.profileUrl;
                    sessionStorage.setItem("user", response.userId);
            }
            animateLoader('loginPage', 'stop');
        }

        /**
        * failure call for login/registration - modal.
        */
        function callAjaxLControllerFailed(msg){
            opts.stop = false;
            animateLoader('login', 'stop');
        }

        /**
        * failure call for login/registration -page.
        */
        function callAjaxLControllerPageFailed(msg) {
            opts.stop = false;
            animateLoader('loginPage', 'stop');
        }

        /**
         * Close windows if media CSS are changing by resize or menu is closing.
         */
        function autoClose() {
            var isMobile_2 = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEmobile|Windows Phone|WPDesktop/i.test(navigator.userAgent);
            if (!isMobile_2) {
                closeInClose();
                // On resize event
                $(window).resize(function() {
                    closeInClose();
                    $('div.shadow').removeClass('active-form');
                    $('body').removeClass('ind');
                });

                // On click another menu item event
                $('.skip-links2 a').click(function() {
                    closeInClose();
                    $('div.shadow').removeClass('active-form');
                    $('body').removeClass('ind');
                });
            };
        }

        /**
         * Close windows if menu is not open.
         */
        function closeInClose() {
            if ($('#header-account2')
                .hasClass('skip-active') != true) {
                animateCloseWindow('login', true, false);
                animateCloseWindow('register', true, false);
                animateCloseWindow('confirmmsg', true, false);
            }
        }
        function heightWidthForm() {

          /*  windowWidth = $(window).width(); 
            windowHeight = $(window).height();
            W = $('.skip-content').width();
            //H = $('.skip-content').height();
            $('.skip-content').css({
                'top': (windowHeight - 404)/2 +'px',
                'right': (windowWidth - W)/2+'px',
            }); */
        }
    };

    /**
     * Property list.
     * @type {{
     *      redirection: string,
     *      windowSize: string,
     *      stop: boolean,
     *      controllerUrl: string,
     *      profileUrl: string,
     *      autoShowUp: string,
     *      errors: string,
     *      firstname: string,
     *      lastname: string,
     *      newsletter: string,
     *      email: string,
     *      password: string,
     *      passwordsecond: string,
     *      licence: string
     * }}
     */
    $.fn.rentalbikesAjaxLogin.defaults = {
        redirection : '0',
        windowSize : '',
        stop : false,
        controllerUrl : '',
        profileUrl : '',
        autoShowUp : '',
        errors : '',
        firstname : '',
        lastname : '',
        newsletter : 'no',
        email : '',
        password : '',
        passwordsecond : '',
        licence : 'no',
    };

})(jQuery);
