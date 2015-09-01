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
				y: self['budzety.liczba_wydatki']
			});
			doch.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: self['budzety.liczba_dochody']
			});
			def.push({
				id: self['budzety.id'],
				x: self['budzety.rok'],
				y: self['budzety.liczba_deficyt']
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
					y: +320
				};
				premierPlotBandData.from = self['budzety.rok'];
			}
		}
	});

	dataPremier.push(premierPlotBandData);
	var dataSeries = [
		{
			type: 'line',
			name: 'Wydatki',
			data: wyd,
			color: '#ff4643'
		},
		{
			type: 'line',
			name: 'Dochody',
			data: doch,
			setData: doch,
			color: '#446ff9'
		},
		{
			type: 'area',
			name: 'Deficyt',
			data: def,
			color: '#fff700'
		}];

	dataBlock.highcharts({
		chart: {
			spacingBottom: 40
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
			}
		},
		series: dataSeries,
		xAxis: {
			plotBands: dataPremier,
			pointStart: startDate,
			pointInterval: 1
		},
		yAxis: {
			title: ' '
		}
	});
});
