$(function () {
	
	var divs = $('.krakow_glosowania_voting_chart');
	for( var i=0; i < divs.length; i++ ) {
		
		var div = $(divs[i]);
		var data = [
			['Za', Number(div.attr('data-za'))],
			['Przeciw', Number(div.attr('data-przeciw'))],
			['Wstrzymania od głosu', Number(div.attr('data-wstrzymanie'))],
			['Nieobecni', Number(div.attr('data-nieobecni'))]
		];
		
		console.log('data', data);
		
	    div.highcharts({
	        chart: {
	            plotBackgroundColor: null,
				backgroundColor: 'rgba(0,0,0,0)',
	            plotBorderWidth: null,
	            plotShadow: false,
                spacingLeft: 0,
                marginLeft: 0
	        },
	        title: {
	            text: null
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.y}</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    format: '<b>{point.name}</b>: {point.y}'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Liczba głosów',
	            data: data
	        }],
	        credits: {
		        enabled: false
	        }
	    });
    
    }
    
});

