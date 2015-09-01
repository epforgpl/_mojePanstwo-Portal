$(document).ready(function () {
	// STICKY
	$('#accountsSwitcher').sticky({
		widthFromWrapper: false
	});

	$('.sticky').sticky();

	// TAGS CLOUD
	var tagsCloud = $("#tagsCloud");
	if (tagsCloud.length)
		tagsCloud.cloud({
			hwratio: .5,
			fog: .4
		});

	// HighstockPicker
	(function () {
		function dateToYYYYMMDD(date) {
			var d = date,
				month = '' + (d.getMonth() + 1),
				day = '' + d.getDate(),
				year = d.getFullYear();

			if (month.length < 2) month = '0' + month;
			if (day.length < 2) day = '0' + day;

			return [year, month, day].join('-');
		}

		function dataSlownie(date) {
			var m = [
					'stycznia',
					'lutego',
					'marca',
					'kwietnia',
					'maja',
					'czerwca',
					'lipca',
					'sierpnia',
					'września',
					'października',
					'listopada',
					'grudnia'
				],
				current = new Date(),
				month = date.getMonth();
			if (m.hasOwnProperty(month)) {
				month = m[month];
			}

			if (
				current.getDate() == date.getDate() &&
				current.getMonth() == date.getMonth() &&
				current.getFullYear() == date.getFullYear())
				return 'dzisiaj';

			return date.getDate() + ' ' + month + ' ' + date.getFullYear() + ' r.';
		}

		var main = $('.mediaHighstockPicker'),
			chart = main.find('.chart').first(),
			pie = $('.pie'),
			aggs = chart.data('aggs'),
			range = chart.data('range'),
			xmax = chart.data('xmax'),
			switcher = main.find('.dataWrap a.switcher').first(),
			display = main.find('.dataWrap .display').first(),
			data = [],
			highchart,
			appPie,
			appPieData = [];

		for (var i = 0; i < aggs.buckets.length; i++) {
			var bucket = aggs.buckets[i];

			data.push([
				bucket.key,
				bucket.doc_count
			]);
		}

		highchart = chart.highcharts('StockChart', {
			chart: {
				width: $(this.li).parent('.dataAggsDropdownList').first().outerWidth(),
				height: 160,
				backgroundColor: 'transparent',
				events: {
					load: function () {
						this.xAxis[0].setExtremes(range.min * 1000, range.max * 1000, true, false);
					}
				},
				marginLeft: 20,
				marginRight: 20
			},
			navigator: {
				height: 132,
				yAxis: {
					tickWidth: 0,
					lineWidth: 0,
					gridLineWidth: 1,
					tickPixelInterval: 40,
					gridLineColor: '#EEE',
					labels: {
						enabled: false
					}
				},
				xAxis: {
					gridLineWidth: 1,
					startOnTick: false,
					endOnTick: false,
					labels: {
						enabled: true
					},
					tickWidth: 1,
					tickPixelInterval: 40,
					// minRange: 3600000
					max: xmax ? xmax : null

				}
			},
			credits: {
				enabled: false
			},
			rangeSelector: {
				enabled: false
			},
			title: {
				text: ''
			},
			series: [{
				name: 'Suma',
				data: data,
				tooltip: {
					valueDecimals: 2
				},
				color: 'transparent'
			}],
			xAxis: {
				labels: {
					enabled: false
				},
				gridLineWidth: 0,
				lineWidth: 0,
				tickWidth: 0,
				minRange: 86400000,
				events: {
					setExtremes: function (e) {
						if (e.trigger == 'navigator') {

							switcher.removeClass('hidden');

							var extremes = e,
								start = new Date(extremes.min),
								end = new Date(extremes.max);

							switcher.attr('href', '?t=['
								+ dateToYYYYMMDD(start)
								+ ' TO '
								+ dateToYYYYMMDD(end)
								+ ']');

							display.html('<span class="_ds" datetime="' + dateToYYYYMMDD(start) + '">' + dataSlownie(start) + '</span> <span class="separator">—</span> <span class="_ds" datetime="' + dateToYYYYMMDD(end) + '">' + dataSlownie(end) + '</span>');

						} else {
							//load(e.min, e.max);
						}
					}
				}
			},
			yAxis: {
				labels: {
					enabled: false
				},
				gridLineWidth: 0,
				lineWidth: 0,
				tickWidth: 0
			}
		});

		var appPieDataNr = 1,
			appPieDataY = 30;
		$.map($.parseJSON(pie.attr('data-json')), function (el) {
			el = {
				name: $(el.label.buckets[0].key).text(),
				x: appPieDataNr++,
				y: appPieDataY
			};
			appPieData.push(el);
			appPieDataY -= 5;
		});

		appPie = pie.highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: null
			},
			tooltip: {
				pointFormat: '<b>#{point.x}</b> <img src="/media/img/twitterapp/{point.x}.png"/> {point.name}',
				useHTML: true
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top'
			},
			legacy: {
				enabled: false
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: false
					},
					showInLegend: true
				}
			},
			series: [{
				colorByPoint: true,
				data: appPieData
			}]
		});
	}());
});
