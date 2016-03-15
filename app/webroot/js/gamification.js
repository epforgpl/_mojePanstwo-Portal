/*global $,document,Cookies,window*/

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
		mPCookie = {
			'gamification': {
				exit: false
			}
		};

	if (Cookies.get('mojePanstwo') !== undefined) {
		mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
	}

	if (gaminificationExit.length && mPCookie.gamification.exit !== true && false) {
		addEvent(window, "load", function () {
			addEvent(document, "mouseout", function (e) {
				var from = e.relatedTarget || e.toElement;
				if (!from || from.nodeName === "HTML") {
					if (gaminificationExit.is(':hidden')) {
						mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
						mPCookie.gamification.exit = true;
						Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
						gaminificationExit.modal('show');
					}
				}
			});
		});
	}
});
