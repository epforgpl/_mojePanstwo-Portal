/* global mPHeart */
/* HTML5 HISTORY.JS */
(function (window) {
    // Prepare
    var History = window.History; // Note: We are using a capital H instead of a lower h
    if (!History.enabled) {
        // History.js is disabled for this browser.
        // This is because we can optionally choose to support HTML4 browsers or not.
        return false;
    }
})(window);

/* REDEFINE JQUERY UI DIALOG DEFAULT OPTIONS*/
jQuery.extend(jQuery.ui.dialog.prototype.options, {
    modal: true,
    resizable: false,
    draggable: false
});

(function ($) {
    /* CONSTANTS DATA of MP HEARTH*/
    $.extend(mPHeart, {
        constant: {
            ajax: {
                api: 'http://mojepanstwo.pl:4444'
            }
        }
    });

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
            };

            var configs = $.extend(defaults, options);

            var $target = this.eq(0);
            var fix, restore;

            if (configs.clone === true) {
                fix = function () {
                    var style = 'position: absolute !important; top: -1000 !important; ';

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
                var tmp = [];
                var style = '';
                var $hidden;

                fix = function () {
                    // get all hidden parents
                    $hidden = $target.parents().addBack().filter(':hidden');
                    style += 'visibility: hidden !important; display: block !important; ';

                    if (configs.absolute === true) style += 'position: absolute !important; ';

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
                        var $this = $(this);
                        var _tmp = tmp[i];

                        if (_tmp === undefined) {
                            $this.removeAttr('style');
                        } else {
                            $this.attr('style', _tmp);
                        }
                    });
                };
            }

            fix();
            // get the actual value with user specific methed
            // it can be 'width', 'height', 'outerWidth', 'innerWidth'... etc
            // configs.includeMargin only works for 'outerWidth' and 'outerHeight'
            var actual = /(outer)/.test(method) ?
                $target[method](configs.includeMargin) :
                $target[method]();

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

    var carouselList,
        modalPaszportLoginForm,
        selectPickers;

    /* STOP ALL BOOTSTRAP CAROUSEL */
    if ((carouselList = $('.carousel')).length > 0) {
        carouselList.each(function () {
            $(this).carousel({
                interval: false
            });
        });
    }

    /* SETTING INFORMATION WITH RESOLUTION FOR PHP/JS */
    var sizeMarker = {
            'xs': {
                'max': 768
            },
            'sm': {
                'min': 768,
                'max': 992
            },
            'md': {
                'min': 992,
                'max': 1200
            },
            'lg': {
                'min': 1200
            }
        },
        checkSizeMarker = null,
        _mPviewport = {
            width: $(document).width(),
            height: $(document).height()
        };

    $.each(sizeMarker, function (key, value) {
        if (((value.min == undefined) ? true : _mPviewport.width >= value.min) && ((value.max == undefined) ? true : _mPviewport.width <= value.max))
            checkSizeMarker = key;
    });

    _mPviewport.sizeMarker = checkSizeMarker;

    /*if (($.cookie('_mPViewport') == null) || ($.cookie('_mPViewport') != checkSizeMarker)) {
        var rescaleOverlay = $('<div></div>').css({
                'position': 'fixed',
                'top': 0,
                'left': 0,
                'width': '100%',
                'height': '100%',
                'background': 'rgba(255,255,255,0.8)',
                'z-index': '9998'
            }),
            rescaleWindow = $('<div></div>').css({
                'position': 'fixed',
                'top': '50%',
                'left': '50%',
                'width': '40px',
                'height': '100px',
                'marginTop': '-20px',
                'marginLeft': '-50px',
                'z-index': '9999',
                'textAlign': 'center',
                'fontSize': '25px'
            }).text("Rescaling..."),
            _mPViewportReloadCookie = $.cookie('_mPViewportReload'),
            _mPViewportReload = (_mPViewportReloadCookie == undefined || Number(_mPViewportReloadCookie) == "NaN" ) ? 1 : Number(_mPViewportReloadCookie) + 1;

        $.cookie('_mPViewportCookieAvailable', 'true');
        var cookieAvailable = $.cookie('_mPViewportCookieAvailable');

        if (Number(_mPViewportReload) < 5 && cookieAvailable == 'true') {
            $.cookie('_mPViewport', checkSizeMarker, {expires: 365, path: '/'});
            $.cookie('_mPViewportReload', _mPViewportReload, {expires: 1, path: '/'});

            $('body').append(rescaleOverlay).append(rescaleWindow);
            if (cookieAvailable == 'true')
                location.reload();
        } else {
            $.cookie('_mPViewport', 'lg', {expires: 365, path: '/'});
            $.removeCookie('_mPViewportReload');
            $.removeCookie('_mPViewportCookieAvailable');
        }
    } else {
        $.removeCookie('_mPViewportReload');
        $.removeCookie('_mPViewportCookieAvailable');
     }*/

    /*COOKIE LAW*/
    var cookieLaw,
        cookieLawStart = ($(window).scrollTop() + 40) - ($(document).height() - $(window).height()) - 1;

    if ((cookieLaw = $('.cookieLaw')).length > 0) {
        cookieLaw.css('bottom', (cookieLawStart >= 0 ? cookieLawStart : 0));

        $(window).scroll(function () {
            if ($(window).scrollTop() + 40 > $(document).height() - $(window).height()) {
                cookieLaw.css('bottom', ($(window).scrollTop() + 40) - ($(document).height() - $(window).height()) - 1);
            } else {
                cookieLaw.css('bottom', 0);
            }
        });
        cookieLaw.find('.btn').click(function () {
            cookieLaw.animate({
                bottom: '-100px',
                right: '-100px'
            }, function () {
                cookieLaw.remove();
                $.cookie('_mPCookieLaw', 1);
            });
        })
    }

    /*JS SHORTER TITLE FUNCTION*/
    if ($('.trimTitle').length > 0)
        trimTitle();

    /*GLOBAL MODAL FOR LOGIN VIA PASZPORT PLUGIN*/
    if ((modalPaszportLoginForm = $('#modalPaszportLoginForm')).length > 0) {
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

    /*GLOBAL BOOTSTRAP-SELECT FORM SELECTPICKER CLASS*/
    if ((selectPickers = $('.selectpicker')).length > 0)
        selectPickers.selectpicker();

    /*FACEBOOK API - ONLY WHEN DIV ID:FB-ROOT EXIST*/
    if ($('#fb-root').length > 0 && $('#facebook-jssdk').length == 0) {
        var js = document.createElement("script"),
            fjs = document.getElementsByTagName("script")[0];

        if (document.getElementById("facebook-jssdk")) {
            return;
        }

        js.id = "facebook-jssdk";

        if (mPHeart.language.twoDig == 'pl')
            js.src = "//connect.facebook.net/pl_PL/all.js";
        else {
            js.src = "//connect.facebook.net/en_US/all.js";
        }

        fjs.parentNode.insertBefore(js, fjs);

        window.fbAsyncInit = function () {
            FB.init({
                "appId": mPHeart.social.facebook.id,
                "status": true,
                "cookie": true,
                "oauth": true,
                "xfbml": true
            });
            FB.Canvas.setSize();
            FBApiInit = true;
        };
    }

    /*INITIALIZE JSCROLLPANE*/
    $('.jScrollPane').jScrollPane({
        horizontalGutter: 5,
        verticalGutter: 5,
        'showArrows': false
    });

    /*INITIALIZE BOOTSTRAP TOOLTIP*/
    $('[data-toggle="tooltip"]').each(function () {
        var that = $(this),
            iconTip = $('<i></i>').addClass('glyphicon glyphicon-info-sign').data(that.data()).attr('title', that.attr('title'));

        $.each(that.data(), function (key, value) {
            iconTip.attr(key, value);
        });

        that.removeAttr('title').addClass('tooltipIcon').append(iconTip.tooltip());
    });

    /*CHANGE IMG WITH .SVG INTO SVG FILE*/
    $('img.svg').each(function () {
        var $img = $(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        $.get(imgURL, function (data) {
            var $svg = $(data).find('svg');

            $svg = $svg.removeAttr('xmlns:a id class');
            $svg.find('path').removeAttr('id style');

            if (typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass + ' replaced-svg');
            }

            $img.replaceWith($svg);
            $svg.animate({
                opacity: 1
            });
        }, 'xml');
    });

    /* $(".hasclear").keyup(function () {
        var t = $(this);
        t.next('a').find('span').toggle(Boolean(t.val()));
    });

    if($(".hasclear").val() == '')
        $(".clearer").hide($(this).prev('input').val()); */

    /*$(".clearer").click(function () {
        $(this).prev('input').val('').focus();
        $(this).hide();
    });*/
})(jQuery);