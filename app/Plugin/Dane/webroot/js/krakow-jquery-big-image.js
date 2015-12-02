/*global window, document, $, jQuery*/

(function ($) {
	var COMMANDS = {
		'init': function (argumentsArray) {
			return typeof argumentsArray[0] === 'undefined' || $.isPlainObject(argumentsArray[0]);
		},
		'changeImage': function (argumentsArray) {
			return argumentsArray[0] === 'changeImage' && $.isPlainObject(argumentsArray[1]);
		},
		'destroy': function (argumentsArray) {
			return argumentsArray[0] === 'destroy';
		}
	};

	function throwBigImageError(message) {
		throw 'BigImage Error: ' + message;
	}

	function getElementSetting(value) {
		if ($.isFunction(value)) {
			value = value();
		}

		value = $(value);

		if (!value.length) {
			throwBigImageError(value + ' must be a valid HTML string or return a valid DOM object');
		}

		return value;
	}

	function setSettings($anchor, settings) {
		var anchorSettings = $.extend(true, $.bigImage.defaultSettings, settings);

		$.bigImage.settings[$anchor.data('bigImageId')] = anchorSettings;
		return anchorSettings;
	}

	function getSettings($anchor) {
		return $.bigImage.settings[$anchor.data('bigImageId')];
	}

	function setupAnchor($anchor, settings) {
		var id = (new Date()).getTime();

		$.bigImage.anchors.push($anchor[0]);
		$anchor.data('bigImageId', id);

		setSettings($anchor, settings);

		return $anchor.bind('click.bigImage', function (e) {
			e.preventDefault();
		});
	}

	function getZoomMask($anchor) {
		var val = $.bigImage.zoomMasks[$anchor.data('bigImageId')];

		if (!val) {
			var settings = getSettings($anchor) || {zoom: {}},
				$container = getElementSetting(settings.zoom.maskElement);
			$container.css({
				position: 'absolute',
				left: '-9999px'
			});

			val = $.bigImage.zoomMasks[$anchor.data('bigImageId')] = $container.appendTo('body');
		}

		return val;
	}

	function getSmallImage($anchor) {
		var $val = $('img:first', $anchor);

		if (!$val.length) {
			throwBigImageError('anchor must have a image child');
		}

		return $val;
	}

	function getLargeImage($anchor) {
		var $zoomMask = getZoomMask($anchor),
			$val = $('img:first', $zoomMask);

		if (!$val.length) {
			$val = $('<img/>').appendTo($zoomMask);
		}

		return $val;
	}

	function getLens($anchor) {
		var val = $.bigImage.lenses[$anchor.data('bigImageId')];

		if (!val) {
			var settings = getSettings($anchor),
				$lens = getElementSetting(settings.lens.element);

			val = $.bigImage.lenses[$anchor.data('bigImageId')] = $lens.appendTo($anchor);
		}

		return val;
	}

	function setStyles($anchor) {
		var settings = getSettings($anchor),
			$smallImg = getSmallImage($anchor),
			$lens = getLens($anchor),
			$largeImg = getLargeImage($anchor),
			$zoomMask = getZoomMask($anchor);

		$anchor.css({
			display: 'block',
			width: $smallImg.width(),
			height: $smallImg.height()
		});

		var anchorOffset = $anchor.offset();

		$zoomMask.css({
			overflow: 'hidden',
			width: settings.zoom.width + 'px',
			height: settings.zoom.height + 'px',
			position: 'absolute',
			top: anchorOffset.top,
			left: anchorOffset.left + $anchor.outerWidth()
		});

		$lens.css({position: 'absolute'});

		$largeImg.css({position: 'absolute'});

		if (settings.autoStyle) {
			$anchor.css({position: 'relative'});

			$smallImg.css({zIndex: 999});

			$lens.css({
				border: '2px solid',
				zIndex: 1000
			});
		}
	}

	function preload() {
		var argumentsArray = $.makeArray(arguments),

			images = argumentsArray.slice(0, argumentsArray.length - 1),
			callback = argumentsArray[argumentsArray.length - 1],

			preloaded = [];

		function allImagesLoaded() {
			var allLoaded = true;

			$.each(images, function (i, url) {
				allLoaded = allLoaded && $.inArray(url, preloaded) >= 0;
			});

			return allLoaded;
		}

		$.each(images, function (i, url) {
			$('<img/>')
				.load(function () {
					preloaded.push(url);

					if (allImagesLoaded()) {
						callback();
						$(this).remove();
					}
				})
				.get(0)
				.src = url;
		});
	}

	var imageRatioCache = {};

	function calculateImageRatios($smallImg, $largeImg, callback) {
		var smallImageUrl = $smallImg.attr('src'),
			largeImageUrl = $largeImg.attr('src'),
			cacheKey = [smallImageUrl, largeImageUrl].join();

		if (imageRatioCache[cacheKey]) {
			callback(imageRatioCache[cacheKey]);
			return;
		}

		preload(smallImageUrl, largeImageUrl, function () {
			if (!$smallImg.is(':visible') || !$largeImg.is(':visible')) {
				throwBigImageError('images must be visible to calculate lens size');
			}

			var ratios = {
				height: $smallImg.height() / $largeImg.height(),
				width: $smallImg.width() / $largeImg.width()
			};

			// WebKit has invalid dimensions depending on image load state
			if (!isFinite(ratios.height) || !isFinite(ratios.width)) {
				window.setTimeout(function () {
					calculateImageRatios($smallImg, $largeImg, callback);
				}, 5);
				return;
			}

			imageRatioCache[cacheKey] = ratios;

			callback(ratios);
		});
	}

	function setupLens($lens, $smallImg, $largeImg) {
		calculateImageRatios($smallImg, $largeImg, function (ratios) {
			var $anchor = $smallImg.closest('a'),
				settings = getSettings($anchor),
				lensDimensions = {
					height: ratios.height * settings.zoom.height,
					width: ratios.width * settings.zoom.width
				};

			$lens.css({
				height: lensDimensions.height + 'px',
				width: lensDimensions.width + 'px'
			});
		});
	}

	function savePosition($anchor, position) {
		var id = $anchor.data('bigImageId');
		$.bigImage.lastPositions[id] = position;

		return $.bigImage.lastPositions[id];
	}

	function getPosition($anchor) {
		var id = $anchor.data('bigImageId');

		if (!$.bigImage.lastPositions[id]) {
			return null;
		}

		return $.bigImage.lastPositions[id];
	}

	function moveZoom($lens, $smallImg, $largeImg, position) {
		calculateImageRatios($smallImg, $largeImg, function (ratios) {
			var mouseOffset = $smallImg.offset(),

				lensHeight = $lens.outerHeight(),
				lensWidth = $lens.outerWidth(),

				lensTop = (position[1] - mouseOffset.top) - (lensHeight / 2),
				lensLeft = (position[0] - mouseOffset.left) - (lensWidth / 2),

				maxLensTop = $smallImg.height() - lensHeight,
				maxLensLeft = $smallImg.width() - lensWidth;

			if (lensTop < 0) {
				lensTop = 0;
			}
			if (lensLeft < 0) {
				lensLeft = 0;
			}

			if (lensTop > maxLensTop) {
				lensTop = maxLensTop;
			}
			if (lensLeft > maxLensLeft) {
				lensLeft = maxLensLeft;
			}

			$lens.css({
				top: lensTop + 'px',
				left: lensLeft + 'px'
			});

			var imgTop = lensTop / ratios.height,
				imgLeft = lensLeft / ratios.width;

			$largeImg.css({
				top: '-' + imgTop + 'px',
				left: '-' + imgLeft + 'px'
			});
		});
	}

	function turnOnZoom($anchor) {
		getZoomMask($anchor).css({
			left: $anchor.offset().left + $anchor.outerWidth()
		});

		var currentMousePosition = getPosition($anchor),
			$lens = getLens($anchor);

		if (currentMousePosition) {
			moveZoom(
				$lens,
				getSmallImage($anchor),
				getLargeImage($anchor),
				currentMousePosition
			);
		}

		$lens.show();
	}

	function turnOffZoom($anchor) {
		getZoomMask($anchor).css({left: '-9999px'});
		getLens($anchor).hide();
	}

	$.bigImage = {
		settings: {},

		zoomMasks: {},
		lenses: {},

		anchors: [],

		lastPositions: {}
	};

	$.extend($.bigImage, {
		defaultSettings: {
			autoStyle: true,

			zoom: {
				width: 500,
				height: 500,
				maskElement: '<div class="zoom-mask"></div>'
			},

			lens: {
				element: '<div/>',
				loadingElement: '<span class="loading">Loading...</span>'
			}
		},


		/*
		 * Public Functions
		 *
		 */

		init: function (anchor, settings) {
			var $anchor = $(anchor),
				largeImageUrl = $anchor.attr('href');

			if ($anchor.data('bigImageId')) {
				return;
			} else {
				setupAnchor($anchor, settings);
			}

			var id = $anchor.data('bigImageId'),
				$smallImg = getSmallImage($anchor),
				$largeImg = getLargeImage($anchor);

			$largeImg.attr('src', largeImageUrl);

			calculateImageRatios($smallImg, $largeImg, function () {
				var $lens = getLens($anchor);

				setStyles($anchor);

				setupLens($lens, $smallImg, $largeImg);

				turnOffZoom($anchor);

				$anchor
					.bind('mouseenter.bigImage', function () {
						turnOnZoom($anchor);

						$anchor.bind('mousemove.bigImage', function (e) {
							moveZoom($lens, $smallImg, $largeImg, [e.pageX, e.pageY]);
							savePosition($anchor, [e.pageX, e.pageY]);
						});
					})
					.bind('mouseleave.bigImage', function () {
						turnOffZoom($anchor);
						savePosition($anchor, null);

						$smallImg.unbind('mousemove.bigImage');
					});
			});
		},

		changeImage: function (anchor, options) {
			var $anchor = $(anchor),
				id = $anchor.data('bigImageId');

			if (!id) {
				throwBigImageError('must be initialized to change image');
			}

			var $lens = getLens($anchor),
				$loading = getElementSetting(getSettings($anchor).lens.loadingElement),
				$smallImg = getSmallImage($anchor),
				$largeImg = getLargeImage($anchor);

			options = $.extend({smallImageUrl: $smallImg.attr('src')}, options);

			$lens.append($loading);

			$anchor.attr('href', options.largeImageUrl);

			$smallImg.attr('src', options.smallImageUrl);
			$largeImg.attr('src', options.largeImageUrl);

			calculateImageRatios($smallImg, $largeImg, function () {
				setupLens($lens, $smallImg, $largeImg);

				$loading.remove();

				if (getPosition($anchor)) {
					turnOnZoom($anchor);
				}
			});

			setStyles($anchor);

			turnOffZoom($anchor);
		},

		destroy: function (anchor) {
			var $anchor = $(anchor);

			if (!$anchor.data('bigImageId')) {
				throwBigImageError('plugin not initialized');
			}

			var $lens = getLens($anchor);
			id = $anchor.data('bigImageId');

			$lens.remove();
			getZoomMask($anchor).remove();

			$anchor
				.unbind('click.bigImage')
				.unbind('mouseenter.bigImage')
				.unbind('mousemove.bigImage')
				.unbind('mouseleave.bigImage')
				.data('bigImageId', null);


			$.bigImage.zoomMasks[id] = null;
			$.bigImage.settings[id] = null;

			var anchorIndex = $.inArray(anchor, $.bigImage.anchors);
			$.bigImage.anchors.splice(anchorIndex, 1);
		}
	});

	var isWindowLoaded = false;

	$.fn.bigImage = function () {
		$(window).load(function () {
			isWindowLoaded = true;
		});

		var argumentsArray = $.makeArray(arguments),
			command = null,
			options = argumentsArray[argumentsArray.length - 1];

		$.each(COMMANDS, function (name, fn) {
			if (fn(argumentsArray)) {
				command = name;
			}
		});

		if (!command) {
			throwBigImageError('invalid method name');
		}

		function runCommand(links) {
			return $(links).each(function () {
				$.bigImage[command](this, options);
			});
		}

		var links = this;
		isWindowLoaded ? runCommand(links) : $(window).load(function () {
			runCommand(links);
		});
		return links;
	};


	/*
	 * Public Event Binding
	 *
	 */

	$(document).bind('destroy.bigImage', function () {
		$.each($.bigImage.anchors, function (i, el) {
			$(el).bigImage('destroy');
		});
	});
})(jQuery);
