/*global $,jQuery,window,mpHeart*/

/* REDEFINE JQUERY UI DIALOG DEFAULT OPTIONS*/
jQuery.extend(jQuery.ui.dialog.prototype.options, {
    modal: true,
    resizable: false,
    draggable: false
});

/*global jQuery, $, window, mPHeart, trimTitle, FB, FBApiInit*/
(function ($) {
    "use strict";

    /* JQUERY FUNCTION RETURNING SIZE/WIDTH/HEIGHT/ETC HIDDEN ELEMENTS */
    $.fn.addBack = $.fn.addBack || $.fn.andSelf;
    $.fn.extend({
        actual: function (method, options) {
            // check if the jQuery method exist
            if (!this[method]) {
                throw '$.actual => The jQuery method "' + method + '" you called does not exist';
            }

            var defaults = {
                    absolute: false,
                    clone: false,
                    includeMargin: true
                },
                configs = $.extend(defaults, options),
                $target = this.eq(0),
                fix,
                restore,
                tmp = [],
                style = '',
                $hidden,
                actual;

            if (configs.clone === true) {
                fix = function () {
                    style = 'position: absolute !important; top: -1000 !important; ';

                    // this is useful with css3pie
                    $target = $target.
                        clone().
                        attr('style', style).
                        appendTo('body');
                };

                restore = function () {
                    // remove DOM element after getting the width
                    $target.remove();
                };
            } else {
                fix = function () {
                    // get all hidden parents
                    $hidden = $target.parents().addBack().filter(':hidden');
                    style += 'visibility: hidden !important; display: block !important; ';

                    if (configs.absolute === true) {
                        style += 'position: absolute !important; ';
                    }

                    // save the origin style props
                    // set the hidden el css to be got the actual value later
                    $hidden.each(function () {
                        var $this = $(this);

                        // Save original style. If no style was set, attr() returns undefined
                        tmp.push($this.attr('style'));
                        $this.attr('style', style);
                    });
                };

                restore = function () {
                    // restore origin style values
                    $hidden.each(function (i) {
                        var $this = $(this),
                            temp = tmp[i];

                        if (temp === undefined) {
                            $this.removeAttr('style');
                        } else {
                            $this.attr('style', temp);
                        }
                    });
                };
            }

            fix();
            // get the actual value with user specific methed
            // it can be 'width', 'height', 'outerWidth', 'innerWidth'... etc
            // configs.includeMargin only works for 'outerWidth' and 'outerHeight'
            actual = /(outer)/.test(method) ? $target[method](configs.includeMargin) : $target[method]();

            restore();
            // IMPORTANT, this plugin only return the value of the first element
            return actual;
        }
    });

    /*TURN OFF CASE-SENSITIVE FOR CONTAINS PLUGIN IN JQUERY*/
    $.expr[":"].contains = $.expr.createPseudo(function (arg) {
        return function (elem) {
            return $(elem).text().toLowerCase().indexOf(arg.toLowerCase()) >= 0;
        };
    });

    var jsDate = new Date(),
        jsHour = jsDate.getHours(),
        modalPaszportLoginForm = $('#modalPaszportLoginForm'),
        selectPickers = $('.selectpicker'),
        fbScript = document.createElement("script"),
        scriptsPos = document.getElementsByTagName("script")[0],
        mPCookie = $.cookie('mojePanstwo');

    /*FACEBOOK API - ONLY WHEN DIV ID:FB-ROOT EXIST*/
    if ($('#fb-root').length > 0 && $('#facebook-jssdk').length === 0) {
        if (document.getElementById("facebook-jssdk")) {
            return;
        }

        fbScript.id = "facebook-jssdk";

        if (mPHeart.language.twoDig === 'pl') {
            fbScript.src = "//connect.facebook.net/pl_PL/all.js";
        } else {
            fbScript.src = "//connect.facebook.net/en_US/all.js";
        }

        scriptsPos.parentNode.insertBefore(fbScript, scriptsPos);

        window.fbAsyncInit = function () {
            FB.init({
                "appId": mPHeart.social.facebook.id,
                "status": true,
                "cookie": true,
                "oauth": true,
                "xfbml": true
            });
            FB.Canvas.setSize();
        };
    }

    /*COOKIE MANAGER*/
    if (mPCookie) {
        mPCookie = JSON.parse(mPCookie);
    } else {
        mPCookie = {
            background: {
                set: '/img/home/backgrounds/home-background-default.jpg',
                time: jsHour
            }
        };
    }

    /*COOKIE MANAGER - BACKGROUND CHANGER*/
    if (mPCookie.background.time !== jsHour) {
        mPCookie.background.set = '/img/home/backgrounds/home-background-default2.jpg';
        /*JSON get new background*/
        mPCookie.background.time = jsHour;
    }

    /*COOKIE MANAGER - RESAVE ALL*/
    $.cookie('mojePanstwo', JSON.stringify(mPCookie));

    /*GLOBAL MODAL FOR LOGIN VIA PASZPORT PLUGIN*/
    if (modalPaszportLoginForm.length > 0) {
        $('#_mojePanstwoCockpit').find('a._mojePanstwoCockpitPowerButton._mojePanstwoCockpitIcons-login').click(function (e) {
            e.preventDefault();
            modalPaszportLoginForm.modal('show');
        });
        /*SPECIAL CLASS TO POP UP LOGIN BUTTON FOR SPECIAL CASE*/
        $('._specialCaseLoginButton').click(function (e) {
            e.preventDefault();
            modalPaszportLoginForm.modal('show');
        });
    }

    /*INITIALIZE BOOTSTRAP TOOLTIP*/
    $('[data-toggle="tooltip"]').each(function () {
        var that = $(this),
            iconTip = $('<i></i>').addClass('glyphicon glyphicon-info-sign').data(that.data()).attr('title', that.attr('title'));

        $.each(that.data(), function (key, value) {
            iconTip.attr(key, value);
        });

        that.removeAttr('title').addClass('tooltipIcon').append(iconTip.tooltip());
    });

    /*GLOBAL BOOTSTRAP-SELECT FORM SELECTPICKER CLASS*/
    if (selectPickers.length > 0) {
        selectPickers.selectpicker();
    }

    /*JS SHORTER TITLE FUNCTION*/
    if ($('.trimTitle').length > 0) {
        trimTitle();
    }
})(jQuery);