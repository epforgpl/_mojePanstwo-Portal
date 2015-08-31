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
			hwratio: .5,
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
			range = chart.data('range'),
			xmax = chart.data('xmax'),
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
				height: 160,
				backgroundColor: 'transparent',
				events: {
					load: function () {
						this.xAxis[0].setExtremes(range.min*1000, range.max*1000, true, false);
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
							
							/*
							var extremes = e,
								start = new Date(extremes.min),
								end   = new Date(extremes.max);

							apply.attr('href', '?t=' + '['
								+ dateToYYYYMMDD(start)
								+ ' TO '
								+ dateToYYYYMMDD(end)
								+ ']');
							apply.css('visibility', 'visible');
							*/
							
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

	}());

});