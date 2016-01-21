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
					$target = $target.clone().attr('style', style).appendTo('body');
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
		modalPaszportLoginForm = $('#modalPaszportLoginForm'),
		selectPickers = $('.selectpicker'),
		fbScript = document.createElement("script"),
		scriptsPos = document.getElementsByTagName("script")[0],
		jsHour,
		cookieBackgroundLimit = 4,
		mPCookie = {};

	if (Cookies.get('mojePanstwo') !== undefined) {
		mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
	}

	$('#_main').css('margin-bottom', $('footer.footer').outerHeight());

	/*FACEBOOK API - ONLY WHEN DIV ID:FB-ROOT EXIST*/
	if ($('#fb-root').length > 0 && $('#facebook-jssdk').length === 0) {
		if (document.getElementById("facebook-jssdk")) {
			return;
		}

		fbScript.id = "facebook-jssdk";
		fbScript.src = "//connect.facebook.net/" + ((mPHeart.language.twoDig === 'pl') ? 'pl_PL' : 'en_US') + '/all.js';

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

	/*----- COOKIE MANAGER -----*/
	function cookieSave(mPCookie) {
		Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
	}

	/*COOKIE LAW CONTROLER*/
	if (mPCookie === undefined || mPCookie.law === undefined) {
		$('.cookieLaw .btn').click(function () {
			/*Cookies can be change between page start and button clicked*/
			mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));

			mPCookie.law = true;
			$(this).parents('.cookieLaw').fadeOut();

			cookieSave(mPCookie);
		});
	}

	/*COOKIE BACKGROUND CONTROL*/
	if ($('body').hasClass('theme-wallpaper')) {
		var rand = Math.floor(Math.random() * cookieBackgroundLimit);
		jsHour = jsDate.getHours();

		if (mPCookie === undefined || mPCookie.background === undefined) {
			mPCookie.background = {
				url: '/img/home/backgrounds/home-background-default' + rand + '.jpg',
				current: rand,
				limit: cookieBackgroundLimit,
				time: jsHour
			};
			$('body.theme-wallpaper').css('background-image', 'url(' + mPCookie.background.url + ')');
		} else {
			/*COOKIE MANAGER - BACKGROUND CHANGER*/
			if (mPCookie.background.time !== jsHour) {
				if (mPCookie.background.current + 1 < mPCookie.background.limit) {
					/*CHECK IF NEW BACKGROUND EXIST - IF NOT SET DEFAULT*/
					var http = new XMLHttpRequest();
					http.open('HEAD', '/img/home/backgrounds/home-background-default' + mPCookie.background.current + '.jpg', false);
					http.send();
					if (http.status === 404) {
						mPCookie.background.current = rand;
						mPCookie.background.url = '/img/home/backgrounds/home-background-default' + rand + '.jpg';
					} else {
						mPCookie.background.current = mPCookie.background.current + 1;
						mPCookie.background.url = '/img/home/backgrounds/home-background-default' + mPCookie.background.current + '.jpg';
					}
				} else {
					mPCookie.background.current = rand;
					mPCookie.background.url = '/img/home/backgrounds/home-background-default' + rand + '.jpg';
				}
				mPCookie.background.time = jsHour;
				mPCookie.background.limit = cookieBackgroundLimit;
			}
		}

		cookieSave(mPCookie);
	}

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

		$('#modalPaszportLoginForm').on('shown.bs.modal', function () {
			$('#UserEmail').focus();
		});
	}

	var tooltipOptions = {
		delay: {
			hide: 1
		}
	};

	$('[data-tooltip="true"]').tooltip(tooltipOptions);
	$('[data-toggle="tooltip"]').tooltip(tooltipOptions);

	/*GLOBAL BOOTSTRAP-SELECT FORM SELECTPICKER CLASS*/
	if (selectPickers.length > 0) {
		selectPickers.selectpicker();
	}

	/*JS SHORTER TITLE FUNCTION*/
	if ($('.trimTitle').length > 0) {
		trimTitle();
	}

	/**/
	var $mpSticky = $('.mp-sticky');

	function mp_sticky_resize() {
		if ($(window).width() >= 768) {
			$('.mp-sticky.mp-sticky-disable-sm-4').removeClass('_mp-sticky-disabled');
		} else {
			$('.mp-sticky.mp-sticky-disable-sm-4').addClass('_mp-sticky-disabled');
		}
	}

	if ($mpSticky.length) {
		$mpSticky.each(function () {
			var el = $(this);
			el.sticky();

			if (el.hasClass('mp-sticky-disable-sm-4')) {
				mp_sticky_resize();
				$(window).resize(mp_sticky_resize);
			}
		});
	}

	/*MOBILE MENU*/
	$('.app-sidebar ._mobile').click(function (e) {
		var that = $(this);

		e.preventDefault();

		if (that.hasClass('_mobile-show')) {
			that.removeClass('_mobile-show');
			that.parents('.app-sidebar').find('.app-list').hide();
		} else {
			that.addClass('_mobile-show');
			that.parents('.app-sidebar').find('.app-list').show();
		}
	});
})
(jQuery);
