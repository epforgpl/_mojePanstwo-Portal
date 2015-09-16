/*global $, jQuery, window, mPHeart*/
/* HTML5 HISTORY.JS */
(function (window) {
	"use strict";
	// Prepare
	var History = window.History; // Note: We are using a capital H instead of a lower h
	if (!History.enabled) {
		// History.js is disabled for this browser.
		// This is because we can optionally choose to support HTML4 browsers or not.
		return false;
	}
})(window);

/* SCRIPT FIX IMG WITH BROKEN LINKS */
function imgFixer(img) {
	"use strict";

	var style = window.getComputedStyle(img, null),
		maxWidth = style.getPropertyValue('max-width'),
		size = (img.offsetWidth === 0) ? ((maxWidth === "") ? 100 : parseInt(maxWidth, 10)) : img.offsetWidth,
		imgBlankSrc = img.src,
		defaultImg = 'https://placeholdit.imgix.net/~text?txtsize=20&bg=ffffff&txttrack=0';

	/*IMG LINK TO DOCUMENT - SO WE GENERATE RECTANGLE*/
	if (imgBlankSrc.toLowerCase().indexOf("docs.sejmometr") >= 0) {
		/*WE TRY SIMILAR NEW IMAGE TO DOCUMENTS*/
		img.style.border = "2px solid #ddd";
		/*LINK WITH DOCUMENT TEXT*/
		imgBlankSrc = defaultImg + "&w=" + size + "&h=" + Math.ceil(Number(size * 1.32)) + "&txt=brak+dokumentu";
	} else if (imgBlankSrc.toLowerCase().indexOf("resources.sejmometr") >= 0) {/*IMG LINK TO AVATAR - SO WE GENERATE SQUARE*/
		/*LINK WITH AVATAR TEXT*/
		imgBlankSrc = defaultImg + "&w=" + size + "&txt=brak+zdjęcia";
	} else {/*IMG LINK TO OTHERS - SO WE GENERATE SQUARE TOO*/
		/*LINK WITH ERROR TEXT*/
		imgBlankSrc = defaultImg + "&w=" + size + "&h=" + size;
	}

	/*REMOVE ONERROR FUNCTION - CAUSE WE USE IT ALREADY*/
	img.onerror = "";
	/*CLEAR SRC SO CHROME WILL NOW STOP AT ONE IMAGE*/
	img.setAttribute('src', null);
	/*AND INSTERT NEW SRC*/
	img.src = imgBlankSrc;

	return true;
}
/*FUNCTION CHECK IS ELEMENT IS VISIBLE AT SCREEN*/
function isElementVisibled(elem) {
	"use strict";

	var docViewTop, docViewBottom, elemTop, elemBottom;

	docViewTop = jQuery(window).scrollTop();
	docViewBottom = docViewTop + jQuery(window).height();
	elemTop = jQuery(elem).offset().top;
	elemBottom = elemTop + jQuery(elem).height();

	return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
/*FUNCTION CUT TITLE TO SHORTER FORM WITH OPTION OF EXPANDING IT*/
function trimTitle() {
	"use strict";

	jQuery('.trimTitle').each(function () {
		var that = jQuery(this),
			textBody = (that.find('.titleName').length) ? that.find('.titleName') : that,
			body = jQuery.trim(textBody.text()),
			title = (that.attr('title') !== undefined && that.attr('title') !== '') ? that.attr('title') : ((that.data('trimtitle') !== undefined && that.data('trimtitle') !== '') ? that.data('trimtitle') : false),
			trimLength = ((that.data('trimlength') !== undefined) ? that.data('trimlength') : 180),
			splitLocation,
			shortTitle = false,
			hyperlink;

		if (title !== false && trimLength !== undefined) {
			if (body.length > trimLength + 20) {
				splitLocation = body.indexOf(' ', trimLength);
				hyperlink = (that.closest('a').length);

				if (splitLocation !== -1) {
					splitLocation = body.indexOf(' ', trimLength);
					shortTitle = body.substring(0, splitLocation);
					that.data('trimtitle', title);

					if (hyperlink) { /*TARGET IS HYPERLINK*/
						textBody.text(shortTitle);
						textBody.append($('<span></span>').addClass('trimTitleTrigger hyper').text('...'));

						that.parent().find('.trimTitleTrigger').click(function (e) {
							var handler = $(this).parents('.trimTitle'),
								textNode = (handler.children().length) ? handler.children() : handler,
								nodes = textNode[0].childNodes;

							e.preventDefault(handler, handler.children(), handler.children()[0].childNodes);

							textBody.text(handler.data('trimtitle'));
							handler.find('.trimTitleTrigger').remove();
						});
					} else { /*TARGET IS NORMAL TEXT */
						that.html(shortTitle + '<span class="trimTitleTrigger">...</span>');
						that.click(function () {
							that.html(jQuery(this).data('trimtitle'));
						});
					}
				}
			}
		}
	});
}

/**/
function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
			var k = Math.pow(10, prec);
			return '' + (Math.round(n * k) / k)
					.toFixed(prec);
		};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
		.split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '')
			.length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1)
			.join('0');
	}
	return s.join(dec);
}

/* FUNCTION CONVERT CURRENCY INTO READABLE FORMAT */
function pl_currency_format(n, prec) {
	var str = '',
		mld = 0,
		mln = 0,
		tys = 0;

	if (n > 1000000000) {
		mld = (n / 1000000000).toFixed(prec);
		n -= mld * 1000000000;
		return mld + ' mld zł.';
	}

	if (n > 1000000) {
		mln = (n / 1000000).toFixed(prec);
		n -= mln * 1000000;
		return mln + ' mln zł.';
	}

	if (n > 1000) {
		tys = (n / 1000).toFixed(prec);
		n -= tys * 1000;
		return tys + ' tys. zł.';
	}

	if (mld === 0 && mln === 0 && tys === 0)
		str += n + ' zł.';

	return str.trim();
}

/*OTHER LIBRARY*/
/* Simple JavaScript Inheritance
 * By John Resig http://ejohn.org/
 * MIT Licensed.
 */
// Inspired by base2 and Prototype
(function () {
	var initializing = false, fnTest = /xyz/.test(function () {
		xyz;
	}) ? /\b_super\b/ : /.*/;

	// The base Class implementation (does nothing)
	this.Class = function () {
	};

	// Create a new Class that inherits from this class
	Class.extend = function (prop) {
		var _super = this.prototype;

		// Instantiate a base class (but only create the instance,
		// don't run the init constructor)
		initializing = true;
		var prototype = new this();
		initializing = false;

		// Copy the properties over onto the new prototype
		for (var name in prop) {
			// Check if we're overwriting an existing function
			prototype[name] = typeof prop[name] == "function" &&
			typeof _super[name] == "function" && fnTest.test(prop[name]) ?
				(function (name, fn) {
					return function () {
						var tmp = this._super;

						// Add a new ._super() method that is the same method
						// but on the super-class
						this._super = _super[name];

						// The method only need to be bound temporarily, so we
						// remove it when we're done executing
						var ret = fn.apply(this, arguments);
						this._super = tmp;

						return ret;
					};
				})(name, prop[name]) :
				prop[name];
		}

		// The dummy class constructor
		function Class() {
			// All construction is actually done in the init method
			if (!initializing && this.init)
				this.init.apply(this, arguments);
		}

		// Populate our constructed prototype object
		Class.prototype = prototype;

		// Enforce the constructor to be what we expect
		Class.prototype.constructor = Class;

		// And make this class extendable
		Class.extend = arguments.callee;

		return Class;
	};
})();
