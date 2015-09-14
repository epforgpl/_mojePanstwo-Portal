/*global mPHeart, Highcharts*/
$(document).ready(function () {
	var lastChoose,
		$dataForm = $('#dataForm'),
		$administracja = lastChoose = $('#mp-sections');

	graphInit('#mainChart');

	$dataForm.find('select').change(function () {
		$dataForm.submit();
	});

	$.each($administracja.find('.item a'), function () {
		var that = $(this),
			block = that.parents('.block'),
			items = $(block.parent('.items'));

		that.click(function (e) {
			var next = block.next(),
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

			if (next.length == 0) {
				slideMark = block;
			} else {
				while (next.length != 0) {
					if (next.next().length == 0) {
						slideMark = next;
						break;
					} else {
						if (next.position().top != targetPos) {
							slideMark = next.prev();
							break;
						}
						next = next.next();
					}
				}
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
				} else {
					$administracja.find('.infoBlock.active').addClass('old').removeClass('active').css({
						'height': 0,
						'border-width': 0
					}).stop(true, true).animate({'margin-top': 0}, 500, function () {
						$administracja.find('.infoBlock.old').remove()
					});
					slideMark.after(infoBlock);
				}
			} else {
				slideMark.after(infoBlock);
			}

			infoBlock.data('marker', slideMark).find('.container').empty().append(function () {
				var slug = $(this),
					leftCol = $('<div></div>').addClass('leftSide col-xs-12'),
					rightCol = $('<div></div>').addClass('rightSide col-xs-12');

				leftCol.append($('<div></div>'));

				slug.append(leftCol).append(rightCol);
			});

			infoBlock.find('.arrow').css('left', block.position().left + (block.outerWidth() / 2) + 'px');
			infoBlock.removeClass('current');

			rozdzialy(that);

		})
	})
});

function rozdzialy(item) {
	var infoBlock = $('._chart.active').attr('data-itemid', item.parent().attr('data-id')),
		rozdzialy = item.find('table.rozdzialy'),
		subtitle = item.find('.subtitle'),
		chart = item.find('.chart');

	infoBlock.find('.leftSide').html(chart.html());
	graphInit(infoBlock);

	infoBlock.find('.rightSide').html( $(subtitle.html() + '<table>' + rozdzialy.html() + '</table>').addClass('table table-condensed') );
	infoBlock.css('height', infoBlock.find('.container').outerHeight(true));

}

function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s,
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

function pl_currency_format(n) {
	var str = '';
	var mld = 0;
	var mln = 0;
	var tys = 0;

	if (n > 1000000000) {
		mld = Math.round(n / 1000000000);
		n -= mld * 1000000000;
		return mld + ' Mld';
	}

	if (n > 1000000) {
		mln = Math.round(n / 1000000);
		n -= mln * 1000000;
		return mln + ' M';
	}

	if (n > 1000) {
		tys = Math.round(n / 1000);
		n -= tys * 1000;
		return tys + ' k';
	}

	if (mld > 0)
		str += mld + ' Mld ';
	if (mln > 0)
		str += mln + ' M ';
	if (tys > 0 && mld === 0)
		str += tys + ' k';

	if (mld === 0 && mln === 0 && tys === 0)
		str += number_format(n);

	return str.trim();
}

function graphInit(section) {
	var $section = $(section),
		histogram_div = jQuery($section.find('.histogram')),
		data = histogram_div.data('histogram'),
		charts_data = [],
		i = $section.attr('data-itemid'),
		title = $section.find('.histogram').data('title'),
		subtitle = $section.find('.histogram').data('subtitle');

	for (var d = 0; d < data.length; d++) {
		if (data[d]) {

			var v = Number(data[d]['doc_count']);
			charts_data.push({
				x: data[d]['key'],
				y: v
			});
		}
	}

	histogram_div.attr('id', 'h' + i);

	new Highcharts.Chart({
		chart: {
			renderTo: 'h' + i,
			type: 'column',
			height: 250,
			backgroundColor: null,
			spacingTop: 0,
			marginBottom : 100
		},

		tooltip: {
			enabled: true,
			formatter: function(){
				var y = Number(this.y);
				return 'Liczba gmin, których wydatki mieszczą się w przedziale ' + pl_currency_format( this.x ) + ' - ' + pl_currency_format( this.x + 100000000 ) + ':<br/><b>' + y + '</b>';
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

		subtitle: {
			text: subtitle,
			y: 40
		},

		xAxis: {
			labels: {
				enabled: true
			},
			gridLineWidth: 0,
			title: null
		},

		yAxis: {
			labels: {
				enabled: false
			},
			gridLineWidth: 0,
			title: {
				text: '',
				offset: 20,
				style: {
					color: '#AAA',
					'font-family': '"Helvetica Neue",Helvetica,Arial,sans-serif',
					'font-size': '13px',
					'font-weight': '300'
				}
			}
		},

		plotOptions: {
			column: {
				groupPadding: 0,
				pointPadding: 0,
				borderWidth: 0,
				minPointLength: 10
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
