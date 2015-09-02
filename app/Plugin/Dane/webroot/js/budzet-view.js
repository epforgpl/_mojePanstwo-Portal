/**
 * Created by tomaszdrazewski on 26/08/15.
 */
$(document).ready(function () {

	var dane = $('.highchart_datasource').attr('data-highchart');
	dane = $.parseJSON(dane);
	var data = [];

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

	//console.log(drilldowns);

	$('#wydatki_budzetu_wg_czesci').highcharts({
		chart: {
			type: 'pie',
			height: 600,
			backgroundColor: null
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
		title: '',
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
			series: drilldowns
		}
	});

	$('#wydatki_budzetu_wg_czesci2').highcharts({
		chart: {
			type: 'column',
			height: 800
		},
		plotOptions: {
			series: {
				dataLabels: {
					enabled: false,
					formatter: function () {
						var ret = this.point.name;
						if (ret.length > 45) {
							ret = this.point.name.substring(0, 42);
							ret += '...';
						}
						return ret;
					}
				}
			}
		},
		title: '',
		credits: {
			enabled: false
		},
		legend: {
			enabled: false
		},
		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} tys. zł</b><br/>'
		},
		series: [{
			name: 'Działy',
			colorByPoint: true,
			data: data
		}],
		drilldown: {
			series: drilldowns
		},
		xAxis: {
			type: 'category',
			labels: {
				rotation: -45,
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				},
				formatter: function () {
					var ret = this.value;
					if (ret.length > 25) {
						ret = this.value.substring(0, 22);
						ret += '...';
					}
					return ret;
				}
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Wydatki w tys. zł'
			}
		}
	});

});
