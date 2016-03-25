jQuery(document).ready(function () {
    
    var followers_chart = $('#followers_chart');
    if( followers_chart.length ) {
		
		var _data = followers_chart.data('data');
		if( _data ) {
			
			console.log('data', _data);
			
		    followers_chart.highcharts({
		        credits: {
			        enabled: false
		        },
		        chart: {
	                zoomType: 'x',
	                height: 250
	            },
	            title: {
	                text: 'Liczba obserwujących:'
	            },
	            xAxis: {
	                type: 'datetime'
	            },
	            yAxis: {
	                title: {
	                    text: ''
	                }
	            },
	            legend: {
	                enabled: false
	            },
	            series: [{
	                type: 'line',
	                name: 'Liczba obserwujących konto',
	                data: _data
	            }]
		        
		    });
	    
	    }
    
    }
    
});
