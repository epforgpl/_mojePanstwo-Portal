/*global window, document, $, jQuery*/

$(document).ready(function () {
	function normalize(aggs, mode) {
		var data = [];
		if (aggs && aggs.length) {
			if (mode === 'm') {

				aggs.forEach(function (row) {
					data.push(row.reverse.top.hits.hits[0].fields.source[0].data);
				});
			} else {
				aggs.forEach(function (row) {
					data.push(row.fields.source[0].data);
				});
			}
		}

		return data;
	}

	$('.radniRankingChart').each(function () {
		var mode = $(this).data('mode'),
			aggs = normalize($(this).data('aggs'), mode),
			request = $(this).data('request'),
			field = $(this).data('field'),
			chart,
			categories = [],
			data = [];

		aggs.forEach(function (row) {
			categories.push({
				name: row['radni_gmin.nazwa'],
				id: row['radni_gmin.id'],
				avatar: row['radni_gmin.avatar_id']
			});
			data.push(parseInt(row[field]));
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
				headerFormat: '<span style="font-size: 10px">{point.key.name}</span><br/>'
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
						click: function (e) {
							// window.location.href = choose_request + columns_horizontal_keys[this.index];
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
		window.location.href = '/aktywnosci?m=' + e.target.value;
	});
});
