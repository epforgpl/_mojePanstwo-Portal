/*global $, document, window*/

var bdlClick;

$(document).ready(function () {
	var lastChoose,
		$bdl = $('.bdlClickEngine');

	bdlClick = function (block) {
		block = $(block);

		var openCenterBlock = function () {
			var offset = block.offset();
			$('html').animate({scrollTop: offset.top});
		};

		if (typeof lastChoose === "undefined") {
			lastChoose = $bdl;
		}

		var items = block.parent('.items'),
			next = block.next('.block'),
			targetPos = block.position().top,
			slideMark;

		if (block[0] === lastChoose[0]) {
			lastChoose = false;
			items.removeClass('focus-control');
			items.find('.block.focus').removeClass('focus');
			$bdl.find('.infoBlock').addClass('old').css({
				'height': 0,
				'border-width': 0
			}).stop(true, true).animate({'margin-top': 0}, 500, function () {
				$bdl.find('.infoBlock.old').remove();
				openCenterBlock();
			});

			return;
		} else {
			items.find('.block.focus').removeClass('focus');
			items.addClass('focus-control');
			block.addClass('focus');
			lastChoose = block;
			openCenterBlock();
		}

		if (next.length === 0) {
			slideMark = block;
		} else {
			while (next.length !== 0) {
				if (next.next('.block').length === 0) {
					if (next.position().top !== targetPos) {
						slideMark = next.prev('.block');
					} else {
						slideMark = next;
					}
					break;
				} else {
					if (next.position().top !== targetPos) {
						slideMark = next.prev('.block');
						break;
					}
					next = next.next('.block');
				}
			}
		}

		var infoBlock = $('<div></div>').addClass('infoBlock current active col-xs-12').css('height', 0).append(
			$('<div></div>').addClass('arrow')
		).append(
			$('<div></div>').addClass('content').append(
				$('<div></div>').addClass('container')
			)
		);


		if ($bdl.find('.infoBlock').length !== 0) {
			if ($bdl.find('.infoBlock').data('marker')[0] === slideMark[0]) {
				infoBlock = $bdl.find('.infoBlock');
				infoBlock.addClass('current active');
			} else {
				$bdl.find('.infoBlock').addClass('old').removeClass('active').css({
					'height': 0,
					'border-width': 0
				}).stop(true, true).animate({'margin-top': 0}, 500, function () {
					$bdl.find('.infoBlock.old').remove();
					openCenterBlock();
				});
				slideMark.after(infoBlock);
			}
		} else {
			slideMark.after(infoBlock);
		}

		infoBlock.data('marker', slideMark).find('.container').empty().append(function () {
			var slug = $(this);
			var leftCol = $('<div><div class="block-nav"><div class="row"><div class="col-xs-8"><span class="nazwa">Nazwa wskaźnika</span></div><div class="col-xs-2">Ostatni rocznik</div><div class="col-xs-2">Poziom agregacji</div></div></div>').addClass('leftSide col-xs-12');
			
			var content = block.find('.text').html();

			leftCol.append(content.replace(/span/g, 'a'));
			slug.append(leftCol);
		});


		infoBlock.find('.arrow').css('left', (block.position().left - $bdl.position().left) + (block.outerWidth() / 2) + 'px');
		infoBlock.removeClass('current').css('height', infoBlock.find('.container').outerHeight(true));
	};
});
