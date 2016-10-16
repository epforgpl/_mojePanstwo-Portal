/*global window, document, $, jQuery, number_format*/

$(document).ready(function () {
	$('.radniRankingChart').each(function () {
		var aggs = $(this).data('ranking'),
			request = $(this).data('request'),
			chart,
			categories = [],
			data = [];

		aggs = aggs.sort(function (a, b) {
			return b.types['*'] - a.types['*'];
		});

		aggs.forEach(function (row) {
			categories.push({
				name: row.nazwa,
				id: row.id,
				avatar: row.avatar_id,
				data: row.types
			});
			data.push(parseInt(row.types['*'], 0));
		});

		$(this).append('<div class="chart"></div>');
		chart = $(this).find('.chart');

		chart.highcharts({
			chart: {
				type: 'bar',
				spacingRight: 60,
				backgroundColor: null,
				height: 1100
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: categories,
				title: {
					text: null
				},
				labels: {
					formatter: function () {
						var el = this.value,
							v = el.name;

						return [
							'<a href="' + request + el.id + '" target="_self" class="highchart-avatar">',
							'<div class="text-center highchart-avatar-div">',
							'<img src="http://resources.sejmometr.pl/avatars/1/' + el.avatar + '.jpg"/>',
							'<p>' + v + '</p>',
							'</div>',
							'</a>'
						].join('');
					},
					style: {
						width: '150px',
						'min-width': '150px'
					},
					useHTML: true
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: null
				},
				labels: {
					overflow: 'justify'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size: 10px">{point.key.name}</span><br/>',
				useHTML: true,
				pointFormatter: function () {
					var html = '<div>',
						c = this.category.data;

					html += '<p>Łączna liczba punktów: ';
					html += '<strong>' + number_format(c['*'], 0, '.', ' ') + '&nbsp;pkt</strong>';
					html += '</p>';

					if (parseInt(c['*'], 0) > 1) {
						if (typeof c.s !== "undefined") {
							html += '<p>Za wystąpienia:  ';
							html += '<strong>' + number_format(c.s, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.p !== "undefined") {
							html += '<p>Za wystąpienia w roli przewodniczącego:  ';
							html += '<strong>' + number_format(c.p, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.v !== "undefined") {
							html += '<p>Za udział w głosowaniach: ';
							html += '<strong>' + number_format(c.v, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.i !== "undefined") {
							html += '<p>Za złożone interpelacj: ';
							html += '<strong>' + number_format(c.i, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.d !== "undefined") {
							html += '<p>Za dyżury: ';
							html += '<strong>' + number_format(c.d, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}

						if (typeof c.tel !== "undefined") {
							html += '<p>Za udostępnione numery telefonów: ';
							html += '<strong>' + number_format(c.tel, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.blog !== "undefined") {
							html += '<p>Za prowadzenie blogów: ';
							html += '<strong>' + number_format(c.blog, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.www !== "undefined") {
							html += '<p>Za prowadzenie stron WWW: ';
							html += '<strong>' + number_format(c.www, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.fb !== "undefined") {
							html += '<p>Za prowadzenie kont Facebook: ';
							html += '<strong>' + number_format(c.fb, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.twitter !== "undefined") {
							html += '<p>Za prowadzenie kont Twitter: ';
							html += '<strong>' + number_format(c.twitter, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
						if (typeof c.email2 !== "undefined") {
							html += '<p>Za udostępnione adresy e-mail: ';
							html += '<strong>' + number_format(c.email2, 0, '.', ' ') + '&nbsp;pkt</strong>';
							html += '</p>';
						}
					}

					html += '</div>';

					return html;
				}
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				},
				series: {
					pointWidth: 15
				}
			},
			legend: {
				enabled: false
			},
			credits: {
				enabled: false
			},
			series: [{
				name: 'Ilość punktów',
				data: data,
				point: {
					events: {
						click: function () {
							return false;
						}
					}
				}
			}]
		});

		$('img').error(function () {
			$(this).hide();
		});

	});

	var datepicker = $('.datepickerAktywnosciDate'),
		url = datepicker.data('url');

	$.fn.bootstrapDP = $.fn.datepicker.noConflict();

	datepicker.bootstrapDP({
		language: 'pl',
		orientation: 'auto top',
		format: "yyyy-mm",
		viewMode: "months",
		minViewMode: "months",
		startDate: '2014-11',
		endDate: '0d',
		autoclose: true
	}).on('changeDate', function (e) {
		var date = new Date(e.date),
			d = date.getMonth() + 1;

		if (d < 10) {
			d = '0' + d;
		}

		window.location.href = url + '?m=' + date.getFullYear() + '-' + d;
	});
})
;
