/**
 * Created by tomaszdrazewski on 26/08/15.
 */
$(document).ready(function () {

	var dataBlock = $('.chart'),
		dataBlock2 = $('.chart2');
	data = $.parseJSON(dataBlock.attr('data-json'));

	/**
	 * @return {number}
	 */
	function SortByDate(a, b) {
		var aName = a.fields.source[0].data['budzety.rok'];
		var bName = b.fields.source[0].data['budzety.rok'];
		return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
	}

	data.sort(SortByDate);

	var dataPremier = [],
		dataPremier2 = [],
		wyd = [],
		doch = [],
		def = [],
		def_proc = [],
		startDate = 1990,
		premierPlotBandData = {},
		premierPlotBandData2 = {},
		premierPlotBandColorO = 'rgba(200,200,200,.2)',
		premierPlotBandColorE = 'rgba(100,100,100,.2)';

	var last_year;
	$.map(data, function (el) {
		var self = el.fields.source[0].data;

		if (self['budzety.rok'] >= startDate) {
			wyd.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: self['budzety.liczba_wydatki'] * 1000
			});
			doch.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: self['budzety.liczba_dochody'] * 1000
			});
			def.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: self['budzety.liczba_deficyt'] * 1000
			});

			def_proc.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: -(1 - self['budzety.liczba_wydatki'] / self['budzety.liczba_dochody'])
			});

			if (premierPlotBandData.id !== self['budzety.premier_czlowiek_id']) {
				if (premierPlotBandData.id !== undefined) {
					premierPlotBandData.to = self['budzety.rok'];
					premierPlotBandData.color = (dataPremier.length % 2) ? premierPlotBandColorE : premierPlotBandColorO;
					dataPremier.push(premierPlotBandData);
					premierPlotBandData = {};
				}
				premierPlotBandData.id = self['budzety.premier_czlowiek_id'];
				premierPlotBandData.label = {
					align: 'left',
					text: '<img src="//resources.sejmometr.pl/mowcy/a/1/' + premierPlotBandData.id + '.jpg" alt="" width="30" />',
					useHTML: true,
					zIndex: 15,
					y: +466,
					//x: -15
				};
				premierPlotBandData.from = self['budzety.rok'];
				last_year = self['budzety.rok'];

				if (premierPlotBandData2.id !== undefined) {
					premierPlotBandData2.to = self['budzety.rok'];
					premierPlotBandData2.color = (dataPremier2.length % 2) ? premierPlotBandColorE : premierPlotBandColorO;
					dataPremier2.push(premierPlotBandData2);
					premierPlotBandData2 = {};
				}
				premierPlotBandData2.id = self['budzety.premier_czlowiek_id'];
				premierPlotBandData2.from = self['budzety.rok'];
			}
		}
	});


	premierPlotBandData.to = last_year + 1;
	premierPlotBandData.label.x = -15;
	dataPremier.push(premierPlotBandData);
	dataPremier2.push(premierPlotBandData2);

	var selecetedPlot = {};
	selecetedPlot.from = dataBlock.attr('data-year');
	selecetedPlot.to = parseInt(dataBlock.attr('data-year')) + 1;
	selecetedPlot.color = 'rgba(0,0,0,.5)';
	dataPremier.push(selecetedPlot);
	dataPremier2.push(selecetedPlot);

	var dataSeries = [
		{
			name: 'Wydatki',
			data: wyd,
			color: '#e4d354',
			fillOpacity: 0.4
		},
		{
			name: 'Dochody',
			data: doch,
			setData: doch,
			color: '#90ed7d',
			fillOpacity: 0.7
		},
		{
			name: 'Deficyt',
			data: def,
			color: '#f45b5b',
			fillOpacity: 0.9
		}];

	var dataSeries2 = [
		{
			name: 'Deficyt',
			data: def_proc,
			color: '#f45b5b',
			fillOpacity: 0.5,
			zIndex: 0.01
		}];

	dataBlock.highcharts({
		chart: {
			spacingBottom: 40,
			type: 'area',
			height: 500,
			backgroundColor: null
		},
		credits: {
			enabled: false
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				cursor: 'pointer',
				events: {
					click: function (event) {
						window.location = "/dane/budzety/" + event.point.id;
					}
				},
				shadow: true
			},
			area: {
				marker: {
					enabled: false,
					symbol: 'circle',
					radius: 2,
					fillColor: '#555555',
					states: {
						hover: {
							enabled: true
						}
					}
				}
			}
		},
		title: {
			text: null
		},
		tooltip: {
			shared: true,
			valueSuffix: ' mld',
			formatter: function () {
				var points = this.points;
				var pointsLength = points.length;
				var tooltipMarkup = pointsLength ? '<span style="font-size: 10px">' + points[0].key + '</span><br/>' : '';
				var index;
				var val;

				for (index = 0; index < pointsLength; index += 1) {
					val = (points[index].y / 1000000000).toFixed(2);

					tooltipMarkup += '<span style="color:' + points[index].series.color + '">\u25CF</span> ' + points[index].series.name + ': <b>' + val + ' mld</b><br/>';
				}

				return tooltipMarkup;
			}
		},
		series: dataSeries,
		xAxis: {
			plotBands: dataPremier,
			tickInterval: 1,
		},
		yAxis: {
			title: ' ',
			labels: {
				formatter: function () {
					return this.value / 1000000000 + ' mld';
				}
			}
		}
	});

	dataBlock2.highcharts({
		chart: {
			spacingBottom: 40,
			type: 'area',
			height: 200,
			backgroundColor: null,
			spacingTop: 0,
			marginTop: 5,
			spacingLeft: 34
		},
		credits: {
			enabled: false
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				cursor: 'pointer',
				events: {
					click: function (event) {
						window.location = "/dane/budzety/" + event.point.id;
					}
				},
				shadow: true
			},
			area: {
				marker: {
					enabled: false,
					drenabled: false,
					symbol: 'circle',
					radius: 2,
					fillColor: '#555555',
					states: {
						hover: {
							enabled: true
						}
					}
				}
			}
		},
		tooltip: {
			shared: true,
			valueSuffix: ' mld',
			formatter: function () {
				var points = this.points;
				var pointsLength = points.length;
				var tooltipMarkup = pointsLength ? '<span style="font-size: 10px">' + points[0].key + '</span><br/>' : '';
				var index;
				var val;

				for (index = 0; index < pointsLength; index += 1) {
					val = (points[index].y * 100).toFixed(2);

					tooltipMarkup += '<span style="color:' + points[index].series.color + '">\u25CF</span> ' + points[index].series.name + ': <b>' + val + '%</b><br/>';
				}

				return tooltipMarkup;
			}
		},
		title: {
			text: null
		},
		series: dataSeries2,
		xAxis: {
			plotBands: dataPremier2,
			labels: {
				step: 1,
				enabled: false
			},
			tickInterval: 1,
			opposite: true
		},
		yAxis: {
			title: ' ',
			labels: {
				formatter: function () {
					return this.value.toFixed(2) * 100 + '%';
				}
			},
			min: 0,
			reversed: true
		}
	});


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

					if (event.seriesOptions.id !== 'Inne')
						$('.subTitle').css('visibility', 'hidden');

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

					$('.subTitle').css('visibility', 'visible');

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
