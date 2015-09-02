$(function () {
	var dataBlock = $('.chart'),
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
		wyd = [],
		doch = [],
		def = [],
		startDate = 1990,
		premierPlotBandData = {},
		premierPlotBandColorO = 'rgba(200,200,200,.2)',
		premierPlotBandColorE = 'rgba(150,150,150,.2)';

	$.map(data, function (el) {
		var self = el.fields.source[0].data;

		if (self['budzety.rok'] >= startDate) {
			wyd.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: self['budzety.liczba_wydatki']*1000
			});
			doch.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: self['budzety.liczba_dochody']*1000
			});
			def.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: self['budzety.liczba_deficyt']*1000
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
					text: '<img src="//resources.sejmometr.pl/mowcy/a/3/' + premierPlotBandData.id + '.jpg" alt="" />',
					useHTML: true,
					y: +530
				};
				premierPlotBandData.from = self['budzety.rok'];
			}
		}
	});

	dataPremier.push(premierPlotBandData);
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

	dataBlock.highcharts({
		chart: {
			spacingBottom: 40,
			type: 'area',
			height: 600,
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
					radius: 4,
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

				for(index = 0; index < pointsLength; index += 1) {
					val = (points[index].y/1000000000).toFixed(2);

					tooltipMarkup += '<span style="color:' + points[index].series.color + '">\u25CF</span> ' + points[index].series.name + ': <b>' + val  + ' mld</b><br/>';
				}

				return tooltipMarkup;
			}
		},
		series: dataSeries,
		xAxis: {
			plotBands: dataPremier,
			pointStart: startDate,
			pointInterval: 1
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
});

