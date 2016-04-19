/*global $,document,Cookies,window,mPHeart*/

function addEvent(obj, evt, fn) {
	if (obj.addEventListener) {
		obj.addEventListener(evt, fn, false);
	}
	else if (obj.attachEvent) {
		obj.attachEvent("on" + evt, fn);
	}
}

$(document).ready(function () {
	var gaminificationExit = $('#gaminification-exit'),
		gaminificationExitAllowed = true,
		mPCookieExit = {
			'gamification': {
				exit: false,
				exitKrs: false
			}
		};

	if (Cookies.get('mojePanstwoExit') !== undefined) {
		mPCookieExit = $.extend(true, mPCookieExit, Cookies.getJSON('mojePanstwoExit'));
	}

	if (gaminificationExit.length && mPHeart.constant.domain === 'MP') {
		var exitNode = gaminificationExit.data('node'),
			exitshowModal = false;

		if (exitNode === 'main' && mPCookieExit.gamification.exit !== true) {
			exitshowModal = true;
		}

		if (exitNode === 'krs' && mPCookieExit.gamification.exitKrs !== true) {
			exitshowModal = true;
		}

		if (exitshowModal) {
			addEvent(window, "load", function () {
				addEvent(document, "mouseout", function (e) {
					var mPCookie = $.extend(true, {}, Cookies.getJSON('mojePanstwo'));

					if (!(typeof mPCookie.tutorial !== "undefined" && mPCookie.tutorial.option !== null || $('.popup-backdrop:visible').length || $('#tutorialModal:visible').length)) {
						var from = e.relatedTarget || e.toElement;
						if ((!from || from.nodeName === "HTML") && e.clientY < 50) {
							if (gaminificationExit.is(':hidden') && gaminificationExitAllowed) {
								mPCookieExit = $.extend(true, mPCookieExit, Cookies.getJSON('mojePanstwoExit'));

								if (exitNode === 'krs') {
									mPCookieExit.gamification.exitKrs = true;
								} else {
									mPCookieExit.gamification.exit = true;
								}

								Cookies.set('mojePanstwoExit', JSON.stringify(mPCookieExit), {expires: 7, path: '/'});
								gaminificationExit.modal('show');
								gaminificationExitAllowed = false;
							}
						}
					}
				});
			});
		}
	}
});
