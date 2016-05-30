/*global $,jQuery,document*/

$(document).ready(function () {
	// STICKY
	$('#accountsSwitcher').sticky({
		widthFromWrapper: false,
		topSpacing: 45
	}).on('sticky-start', function () {
		var t = $(this),
			p = t.parent();

		if (t.width() < p.width()) {
			t.width(p.width());
		}
	});

	// TAGS CLOUD
	var tagsCloud = $("#tagsCloud");
	if (tagsCloud.length) {
		tagsCloud.cloud({
			hwratio: 0.5,
			fog: 0.4
		});
	}

	// HighstockPicker
	(function () {
		function dateToYYYYMMDD(date) {
			var d = date,
				month = String(d.getMonth() + 1),
				day = String(d.getDate()),
				year = String(d.getFullYear());

			if (month.length < 2) {
				month = '0' + month;
			}
			if (day.length < 2) {
				day = '0' + day;
			}

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
				current.getDate() === date.getDate() &&
				current.getMonth() === date.getMonth() &&
				current.getFullYear() === date.getFullYear()) {
				return 'dzisiaj';
			}

			return date.getDate() + ' ' + month + ' ' + date.getFullYear() + ' r.';
		}

		var main = $('.mediaHighstockPicker'),
			chart = main.find('.chart').first(),
			pie = $('.pie'),
			aggs = chart.data('aggs'),
			range = chart.data('range'),
			xmax = chart.data('xmax'),
			switcher = main.find('.range a.switcher').first(),
			cancel = main.find('.range a.cancel').first(),
			display = main.find('.range .display').first(),
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
				events: {
					load: function () {
						this.xAxis[0].setExtremes(range.min * 1000, range.max * 1000, true, false);
					}
				},
				marginLeft: 20,
				marginRight: 20,
				backgroundColor: null
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
						if (e.trigger === 'navigator') {
							switcher.removeClass('hidden');
							cancel.removeClass('hidden');

							var extremes = e,
								start = new Date(extremes.min),
								end = new Date(extremes.max),
								parms = '?t=[' + dateToYYYYMMDD(start) + ' TO ' + dateToYYYYMMDD(end) + ']';

							if (switcher.attr('data-type') !== '') {
								parms += '&a=' + switcher.attr('data-type');
							}
							
							parms += '&medium=' + _medium;
							switcher.attr('href', parms);

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

		cancel.click(function () {
			var c = chart.highcharts();
			c.xAxis[0].setExtremes(range.min * 1000, range.max * 1000, true, false);
			switcher.addClass('hidden');
			cancel.addClass('hidden');
			var start = new Date(range.min * 1000),
				end = new Date(range.max * 1000);

			display.html('<span class="_ds" datetime="' + dateToYYYYMMDD(start) + '">' + dataSlownie(start) + '</span> <span class="separator">—</span> <span class="_ds" datetime="' + dateToYYYYMMDD(end) + '">' + dataSlownie(end) + '</span>');
			return false;
		});

		var appPieDataNr = 1,
			appPieDataY = 30;
			
		
		try {
		
			$.map($.parseJSON(pie.attr('data-json')), function (el) {
				var name = $(el.label.buckets[0].key).text();
				el = {
					id: el.key,
					name: name,
					logo: name.toLowerCase().replace(/\s/g, '_'),
					x: appPieDataNr++,
					y: appPieDataY
				};
				appPieData.push(el);
				appPieDataY -= 5;
			});
	
			appPie = pie.highcharts({
				chart: {
					backgroundColor: null,
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: null
				},
				tooltip: {
					title: {
						text: null
					},
					formatter: function () {
						var img = '';
						if (this.point.logo === 'facebook' || this.point.logo === 'plume_for_android' || this.point.logo === 'tweetdeck' || this.point.logo === 'twitter_for_android' || this.point.logo === 'twitter_for_ipad' || this.point.logo === 'twitter_for_iphone' || this.point.logo === 'twitter_web_client' || this.point.logo === 'twitterfeed') {
							img = '<img src="/media/img/twitterapp/' + this.point.logo + '.png"/>';
						}
						return '<div style="display: block"><strong>#' + this.point.x + '</strong> ' + img + this.point.name + '</div>';
					},
					useHTML: true,
					headerFormat: ' '
				},
				legend: {
					enabled: true,
					labelFormatter: function () {
						var img = '',
							ret,
							name = this.name;
	
						if (this.logo === 'facebook' || this.logo === 'plume_for_android' || this.logo === 'tweetdeck' || this.logo === 'twitter_for_android' || this.logo === 'twitter_for_ipad' || this.logo === 'twitter_for_iphone' || this.logo === 'twitter_web_client' || this.logo === 'twitterfeed') {
							img = '<img src="/media/img/twitterapp/' + this.logo + '.png" style="margin-right:4px" />';
						}
	
						ret = '<strong>#' + this.x + '</strong> ' + img;
	
						if (name.length > 55) {
							name = this.name.substring(0, 52);
							name += '...';
						}
						return '<div style="margin-top: -5px; margin-bottom:10px">' + ret + name + '</div>';
					},
					useHTML: true
				},
				legacy: {
					enabled: false
				},
				credits: {
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
					data: appPieData,
					point: {
						events: {
							click: function () {
								window.location.href = '?conditions[twitter.source_id]=' + this.id + appPie.attr('data-parms');
								return false;
							}
						}
					}
				}]
			});
		
		}
		catch(err) {
		}
		
	}());
});
