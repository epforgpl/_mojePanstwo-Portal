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
				height: 1600
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
				pointFormatter: function () {
					var html = '<div>',
						c = this.category.data;

					html += '<p>Łączna ilość punktów: ';
					html += '<strong>' + number_format(c['*'], 0, '.', ' ') + '</strong>';
					html += '</p>';

					if (parseInt(c['*'], 0) > 1) {
						html += '<br /><p class="margin-top-5">zdobyte w: </p>';

						if (typeof c.s !== "undefined") {
							html += '<br /><p> - wystąpienia na posiedzeniu: ';
							html += '<strong>' + number_format(c.s, 0, '.', ' ') + '</strong>';
							html += '</p>';
						}
						if (typeof c.v !== "undefined") {
							html += '<br /><p> - oddane głosy: ';
							html += '<strong>' + number_format(c.v, 0, '.', ' ') + '</strong>';
							html += '</p>';
						}
						if (typeof c.i !== "undefined") {
							html += '<br /><p> - złożone interpelacje: ';
							html += '<strong>' + number_format(c.i, 0, '.', ' ') + '</strong>';
							html += '</p>';
						}

						if (typeof c.tel !== "undefined") {
							html += '<br /><p> - udostępniony numer telefonu: ';
							html += '<strong>' + number_format(c.tel, 0, '.', ' ') + '</strong>';
							html += '</p>';
						}
						if (typeof c.blog !== "undefined") {
							html += '<br /><p> - prowadzenie bloga: ';
							html += '<strong>' + number_format(c.blog, 0, '.', ' ') + '</strong>';
							html += '</p>';
						}
						if (typeof c.www !== "undefined") {
							html += '<br /><p> - prowadzenie strony WWW: ';
							html += '<strong>' + number_format(c.www, 0, '.', ' ') + '</strong>';
							html += '</p>';
						}
						if (typeof c.fb !== "undefined") {
							html += '<br /><p> - prowadzenie konta Facebook: ';
							html += '<strong>' + number_format(c.fb, 0, '.', ' ') + '</strong>';
							html += '</p>';
						}
						if (typeof c.twitter !== "undefined") {
							html += '<br /><p> - prowadzenie konta Twitter: ';
							html += '<strong>' + number_format(c.twitter, 0, '.', ' ') + '</strong>';
							html += '</p>';
						}
						if (typeof c.email2 !== "undefined") {
							html += '<br /><p> - udostępniony adresu e-mail: ';
							html += '<strong>' + number_format(c.email2, 0, '.', ' ') + '</strong>';
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

	var datepicker = $('.datepickerAktywnosciDate');

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

		window.location.href = '/aktywnosci?m=' + date.getFullYear() + '-' + d;
	});
})
;
