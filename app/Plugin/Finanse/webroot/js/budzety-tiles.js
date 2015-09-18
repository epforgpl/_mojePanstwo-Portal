/*global mPHeart*/
$(document).ready(function () {
	var lastChoose,
		$administracja = lastChoose = $('#mp-sections');


	$.each($administracja.find('.item a'), function () {
		var that = $(this),
			block = that.parents('.block'),
			items = $(block.parent('.items'));

		that.click(function (e) {
			var next = block.nextAll('.block:first'),
				targetPos = block.position().top,
				slideMark;

			e.preventDefault();

			if (block[0] === lastChoose[0]) {
				lastChoose = false;
				items.removeClass('focus-control');
				items.find('.block.focus').removeClass('focus');
				$administracja.find('.infoBlock').addClass('old').css({
					'height': 0,
					'border-width': 0
				}).stop(true, true).animate({'margin-top': 0}, 500, function () {
					$administracja.find('.infoBlock.old').remove()
				});

				return;
			} else {
				items.find('.block.focus').removeClass('focus');
				items.addClass('focus-control');
				block.addClass('focus');
				lastChoose = block;
			}

			var nextPrev = block;
			if (next.length == 0) {
				slideMark = block;
			} else {
				while (next.length != 0) {
					if (Math.floor(next.position().top) != Math.floor(targetPos)) {
						slideMark = nextPrev;
						break;
					}
					nextPrev = next;
					next = next.nextAll('.block:first');
				}

				if (typeof(slideMark) == "undefined")
					slideMark = nextPrev;
			}

			var infoBlock = $('<div></div>').addClass('infoBlock _chart current active col-xs-12').css('height', 0).append(
				$('<div></div>').addClass('arrow')
			).append(
				$('<div></div>').addClass('content').append(
					$('<div></div>').addClass('container')
				)
			);

			if ($administracja.find('.infoBlock').length !== 0) {
				if ($administracja.find('.infoBlock').data('marker')[0] === slideMark[0]) {
					infoBlock = $administracja.find('.infoBlock');
					infoBlock.addClass('current active');

					$('html, body').animate({
						scrollTop: block.offset().top
					}, 600);
				} else {
					$administracja.find('.infoBlock.active').addClass('old').removeClass('active').css({
						'height': 0,
						'border-width': 0
					}).stop(true, true).animate({'margin-top': 0}, 500, function () {
						$administracja.find('.infoBlock.old').remove();

						$('html, body').animate({
							scrollTop: block.offset().top
						}, 600);
					});
					slideMark.after(infoBlock);
				}
			} else {
				$('html, body').animate({
					scrollTop: block.offset().top
				}, 600);
				slideMark.after(infoBlock);
			}

			infoBlock.data('marker', slideMark).find('.container').empty().append(function () {
				var slug = $(this),
					leftCol = $('<div></div>').addClass('leftSide col-xs-12');

				leftCol.append($('<div></div>'));

				slug.append(leftCol);
			});

			infoBlock.find('.arrow').css('left', block.position().left + (block.outerWidth() / 2) + 'px');
			infoBlock.removeClass('current');

			rozdzialy(that);
		})
	})
});

function rozdzialy(item) {
	var infoBlock = $('._chart.active').attr('data-itemid', item.parent().attr('data-id')),
		chart = item.find('.highchart');

	infoBlock.find('.leftSide').html(chart.html());
	graphInit(infoBlock);

	infoBlock.css('height', infoBlock.find('.container').outerHeight(true));
}

function graphInit(section) {

	var section = $(section),
		histogram_div = jQuery(section.find('.histogram')),
		data = histogram_div.data('histogram'),
		charts_data = [],
		i = section.attr('data-itemid'),
		title = section.find('.histogram').data('text');

	for (var d = 0; d < data.length; d++) {
		if (data[d]) {

			var v = Number(data[d]['y']);
			charts_data.push({
				x: data[d]['name'],
				y: v
			});
		}
	}

	histogram_div.attr('id', 'h' + i);

	new Highcharts.Chart({
		chart: {
			renderTo: 'h' + i,
			type: 'spline',
			backgroundColor: null,
			height: 400,
			spacingTop: 10,
			marginBottom: 30
		},

		tooltip: {
			enabled: true,
			formatter: function () {
				var y = Number(this.y);
				return title+ '<br/>'+this.x+': <b>' + pl_currency_format(y, 2) + '</b>';
			}
		},

		credits: {
			enabled: false
		},

		legend: {
			enabled: false
		},

		title: {
			text: title,
			y: 20
		},

		xAxis: {
			labels: {
				enabled: true
			},
			gridLineWidth: 0,
			title: null
		},

		yAxis: {

			min: 0,
			gridLineWidth: 1,
			title: {
				text: '',
				offset: 20,
				style: {
					color: '#AAA',
					'font-family': '"Helvetica Neue",Helvetica,Arial,sans-serif',
					'font-size': '13px',
					'font-weight': '300'
				}
			},
			labels: {
				formatter: function () {
					if(this.value <= 100) {
						return this.value + '%';
					} else return pl_currency_format(this.value, 0);
				}
			}
		},

		plotOptions: {
			column: {
				groupPadding: 0,
				pointPadding: 0,
				borderWidth: 0,
				minPointLength: 0
			},
			series: {
				pointPlacement: "on"
			}
		},

		series: [{
			data: charts_data
		}]

	});
}
