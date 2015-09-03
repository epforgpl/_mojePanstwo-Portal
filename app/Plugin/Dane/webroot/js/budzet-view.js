/**
 * Created by tomaszdrazewski on 26/08/15.
 */
$(document).ready(function () {

	var dane = $('.highchart_datasource').attr('data-highchart');
	dane = $.parseJSON(dane);
	var data = [];

	var sum = (parseInt($('.highchart_datasource').attr('data-total')) / 1000000).toFixed(2);

	$.each(dane['dzialy'], function () {
		data.push({name: $(this)[0]['name'], y: parseInt($(this)[0]['y']), drilldown: $(this)[0]['drilldown']});
	});

	var drilldowns = [];
	$.each(dane['rozdzialy'], function () {
		var data_lokal = [];
		$.each($(this)[0]['data'], function () {
			if ($(this)[0]['drilldown']) {
				data_lokal.push({
					name: $(this)[0]['name'],
					y: parseInt($(this)[0]['y']),
					drilldown: $(this)[0]['drilldown']
				});
			} else {
				data_lokal.push([$(this)[0]['name'], parseInt($(this)[0]['y'])]);
			}
		});
		drilldowns.push({name: $(this)[0]['name'], id: $(this)[0]['id'], data: data_lokal})
	});

	var btnDrillUp = $('.btnDrillUp');
	$('#wydatki_budzetu_wg_czesci').highcharts({
		chart: {
			type: 'pie',
			height: 600,
			backgroundColor: null,
			events: {
				drilldown: function (event) {
					var total = 0; // get total of data;

					console.log(event);
					console.log(this);

					for (var i = 0, len = event.seriesOptions.data.length; i < len; i++) {
						if (typeof(event.seriesOptions.data[i]['y']) != "undefined") {
							total += event.seriesOptions.data[i]['y'];
						} else {
							total += event.seriesOptions.data[i][1];
						}
					}
					total = (total / 1000000).toFixed(2);
					$('.highcharts-title').html('<div class="text-center">' + total + '<br>mld</div>');

					btnDrillUp.data('drill', parseInt(btnDrillUp.data('drill')) + 1);

					if (btnDrillUp.data('drill') > 0) {
						$('.btnDrillUp').removeClass('hide').unbind('click').click(function (e) {
							e.preventDefault();
							$('.highcharts-button').trigger("click");
						})
					} else {
						$('.btnDrillUp').addClass('hide').unbind('click');
					}
				},
				drillup: function (event) {
					var total = 0; // get total of data;

					for (var i = 0, len = event.seriesOptions.data.length; i < len; i++) {
						if (typeof(event.seriesOptions.data[i]['y']) != "undefined") {
							total += event.seriesOptions.data[i]['y'];
						} else {
							total += event.seriesOptions.data[i][1];
						}
					}
					total = (total / 1000000).toFixed(2);
					$('.highcharts-title').html('<div class="text-center">' + total + '<br>mld</div>');

					btnDrillUp.data('drill', parseInt(btnDrillUp.data('drill')) - 1);

					if (btnDrillUp.data('drill') > 0) {
						$('.btnDrillUp').removeClass('hide').unbind('click').click(function (e) {
							e.preventDefault();
							$('.highcharts-button').trigger("click");
						})
					} else {
						$('.btnDrillUp').addClass('hide').unbind('click');
					}
				}
			}
		},
		plotOptions: {
			series: {
				dataLabels: {
					enabled: true,
					formatter: function () {
						var ret = this.point.name;
						if (ret.length > 55) {
							ret = this.point.name.substring(0, 52);
							ret += '...';
						}
						return ret;
					}
				}
			},
			pie: {
				size: "80%",
				innerSize: "35%"
			}
		},
		title: {
			verticalAlign: 'middle',
			y: -5,
			text: '<div class="text-center">' + sum + '<br>mld</div>',

			style: {"color": "#333333", "fontSize": "28px", "font-family": 'Lato'},
			useHTML: true
		},
		credits: {
			enabled: false
		},
		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.percentage:.2f} %</b><br/>',
			valueDecimals: 2
		},
		series: [{
			name: 'Działy',
			colorByPoint: true,
			data: data
		}],
		drilldown: {
			series: drilldowns,
			drillUpButton: {
				position: {
					y: -5000,
					x: -5000
				}
			}
		}
	});

});
