$(function () {
	var dataBlock = $('.chart'),
		dataBlock2 = $('.chart2'),
		dataBlockmid = $('.mid-chart'),
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
		premierPlotBandColorO = '#444444',//'#FFF',
		premierPlotBandColorE = '#222222';//'#f8f9fa';

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
					text: '<img class="test" src="//resources.sejmometr.pl/mowcy/a/1/' + premierPlotBandData.id + '.jpg" alt="" width="30" />',
					useHTML: true,
					zIndex: 115,
					y: +240
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

	premierPlotBandData.color = (dataPremier.length % 2) ? premierPlotBandColorE : premierPlotBandColorO;
	premierPlotBandData2.color = (dataPremier2.length % 2) ? premierPlotBandColorE : premierPlotBandColorO;
	premierPlotBandData.to = last_year + 1;
	premierPlotBandData2.to = last_year + 1;
	//premierPlotBandData.label.x = -15;
	dataPremier.push(premierPlotBandData);
	dataPremier2.push(premierPlotBandData2);

	console.log(dataPremier);

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

	var dataSeriesMid = [{
		name: '',
		data: def,
		lineWidth: 0,
		fillOpacity: 0.0,
		visible: false,
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
			spacingTop: 40,
			spacingBottom: 40,
			type: 'line',
			backgroundColor: null,
			height: 300,
			style: {
				fontFamily: "'Roboto', sans-serif"
			}
		},
		credits: {
			enabled: false
		},
		legend: {
			align: 'left',
			//backgroundColor: '#FFFFFF',
			enabled: true,
			floating: true,
			layout: 'vertical',
			shadow: true,
			verticalAlign: 'top',
			x: +125,
			y: +50
		},
		plotOptions: {
			series: {
				cursor: 'pointer',
				events: {
					click: function (event) {
						window.location = "/dane/budzety/" + event.point.id;
					}
				},
				shadow: true,
				pointPlacement: 'between',
				pointRange: 1
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
			labels: {
				autoRotation: 0,
				step:2
			}
		},
		yAxis: {
			title: ' ',
			min: 0,
			labels: {
				formatter: function () {
					return this.value / 1000000000 + ' mld';
				}
			}
		}
	});

	dataBlockmid.highcharts({
		chart: {
			spacingBottom: 0,
			type: 'line',
			height: 90,
			backgroundColor: null,
			spacingTop: 0,
			marginTop: 0,
			marginBottom: 0,
			spacingLeft: 64,
			ignoreHiddenSeries: false,
			style: {
				fontFamily: "'Roboto', sans-serif"
			}
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
				shadow: true,
				pointPlacement: 'between',
				pointRange: 1
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
		series: dataSeriesMid
		,
		xAxis: {
			plotBands: dataPremier2,
			labels: {
				step: 2,
				enabled: false
			},
			tickInterval: 2,
			opposite: true
		},
		yAxis: {
			gridLineColor: 'transparent',
			lineColor: 'transparent',
			labels: {
				enabled: false
			},
			minorTickLength: 0,
			tickLength: 0,
			title: ' '
		}
	});

	dataBlock2.highcharts({
		chart: {
			spacingBottom: 40,
			type: 'area',
			height: 175,
			backgroundColor: null,
			spacingTop: 0,
			marginTop: 40,
			spacingLeft: 27,
			style: {
				fontFamily: "'Roboto', sans-serif"
			}
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
				shadow: true,
				pointPlacement: 'between',
				pointRange: 1
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
});

