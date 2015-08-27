$(document).ready(function() {

	// STICKY

	$('#accountsSwitcher').sticky({
		widthFromWrapper: false
	});

	$('.sticky').sticky();

	// TAGS CLOUD

	var tagsCloud = $("#tagsCloud");
	if( tagsCloud.length )
		tagsCloud.cloud({
			hwratio: .3,
			fog: .4
		});

	// HighstockPicker

	(function() {

		function dateToYYYYMMDD(date) {
			var d = date,
				month = '' + (d.getMonth() + 1),
				day = '' + d.getDate(),
				year = d.getFullYear();

			if (month.length < 2) month = '0' + month;
			if (day.length < 2) day = '0' + day;

			return [year, month, day].join('-');
		}

		var main = $('.mediaHighstockPicker'),
			chart = main.find('.chart').first(),
			aggs = chart.data('aggs'),
			apply = main.find('.text-center a').first(),
			data = [],
			highchart;

		for(var i = 0; i < aggs.buckets.length; i++) {
			var bucket = aggs.buckets[i];
			data.push([
				bucket.key,
				bucket.doc_count
			]);
		}

		highchart = chart.highcharts('StockChart', {
			chart: {
				width: $(this.li).parent('.dataAggsDropdownList').first().outerWidth(),
				height: 210,
				backgroundColor: 'transparent',
				events: {
					load: function () {
						//var e = this.xAxis[0].getExtremes();
						//load(e.min, e.max);
					}
				}
			},
			navigator: {
				height: 140,
				yAxis: {
					tickWidth: 0,
					lineWidth: 0,
					gridLineWidth: 1,
					tickPixelInterval: 40,
					gridLineColor: '#EEE',
					labels: {
						enabled: true
					}
				}
			},
			credits: {
				enabled: false
			},
			rangeSelector: {
				buttons : [{
					type : 'day',
					count : 1,
					text : '1D'
				}, {
					type : 'month',
					count : 1,
					text : '1M'
				}, {
					type : 'all',
					count : 1,
					text : 'All'
				}],
				selected : 0
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
				events: {
					setExtremes: function (e) {
						if (e.trigger == 'navigator') {
							var extremes = e,
								start = new Date(extremes.min),
								end   = new Date(extremes.max);

							apply.attr('href', '?conditions[_date]=' + '['
								+ dateToYYYYMMDD(start)
								+ ' TO '
								+ dateToYYYYMMDD(end)
								+ ']');
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
				tickWidth: 0,
				events: {
					setExtremes: function (e) {
						if (e.trigger == 'navigator') {
							extremes = e;
							setTimeout(function () {
								if (extremes == e) {
									//load(e.min, e.max);
								}
							}, 300);
						} else {
							//load(e.min, e.max);
						}
					}
				}
			}
		});

	}());

});
