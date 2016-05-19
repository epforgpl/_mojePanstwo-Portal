/*global mPHeart, Highcharts*/
$(document).ready(function () {
	
	var $dataForm = $('#dataForm'),
		$charts = $('#mp-sections .chart');
	
	$dataForm.find('select').change(function () {
		$dataForm.submit();
	});
	
	var params = $dataForm.serialize();
	
	for( var i=0; i<$charts.length; i++ ) {
		$chart = $($charts[i]);
		params += '&fields[' + $chart.data('field') + ']=' + $chart.data('histogram-interval');
	}
	
	$.get('/ngo/sprawozdania_opp_histogram.json?' + params, function(data){
		for( var i=0; i<$charts.length; i++ ) {
			
			$chart = $($charts[i]);
			var field = $chart.data('field');
			
			chartInit($chart, data['aggs']['krs_podmioty']['sprawozdania_opp']['rocznik'][ field + '_range' ]['histogram']['buckets']);
			
		}
	});
	
});

function chartInit(chart, data) {
	
	console.log('chart', chart, data);
	
	var $chart = $(chart),
		histogram_div = jQuery($chart.find('.histogram')),
		interval = $chart.data('histogram-interval') || 0,
		charts_data = [],
		i = $chart.attr('data-itemid');
		
	for (var d = 0; d < data.length; d++) {
		if (data[d]) {
			var v = Number(data[d]['doc_count']);

			charts_data.push({
				x: data[d]['key'],
				y: v
			});
		}
	}
	
	histogram_div.attr('id', 'h' + i);

	new Highcharts.Chart({
		chart: {
			renderTo: 'h' + i,
			type: 'column',
			height: 300,
			backgroundColor: null,
			spacingTop: 0,
			marginBottom : 100
		},

		tooltip: {
			enabled: true,
			formatter: function(){
				var y = Number(this.y);
				return 'Liczba organizacji w przedziale ' + pl_currency_format(this.x , 1) + ' - ' + pl_currency_format(this.x + interval , 1) + ' : <b>' + y + '</b>';
			},
			positioner: function() {
				return {
					x: 135,
					y: 230
				}
			}
		},

		credits: {
			enabled: false
		},

		legend: {
			enabled: false
		},

		title: {
			text: '',
		},

		xAxis: {
			labels: {
				enabled: true,
				formatter: function () {
					return pl_number_format(this.value, 1);
				}
			},
			gridLineWidth: 0,
			title: null
		},

		yAxis: {
			labels: {
				enabled: false
			},
			gridLineWidth: 0,
			title: {
				text: '',
				offset: 20,
				style: {
					color: '#AAA',
					'font-family': '"Helvetica Neue",Helvetica,Arial,sans-serif',
					'font-size': '13px',
					'font-weight': '300'
				}
			}
		},

		plotOptions: {
			column: {
				groupPadding: 0,
				pointPadding: 0,
				borderWidth: 0,
				minPointLength: 10
			},
			series: {
				pointPlacement: "on"
			}
		},

		series: [{
			data: charts_data
		}]

	});
}
