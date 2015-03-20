var DataBrowser = Class.extend({
		
	init: function(div) {
		
		this.div = $(div);		
		this.initAggs();
				
	},
	
	initAggs: function() {
				
		var lis = this.div.find('.dataAggs .agg');
		for( var i=0; i<lis.length; i++ ) {
			
			var li = $(lis[i]);
			if( li.hasClass('agg-PieChart') ) 
				this.initAggPieChart(li);
			else if( li.hasClass('agg-DateHistogram') ) 
				this.initAggDateHistogram(li);
			else if( li.hasClass('agg-ColumnsHorizontal') ) 
				this.initAggColumnsHorizontal(li);
			else if( li.hasClass('agg-ColumnsVertical') ) 
				this.initAggColumnsVertical(li);
		}
		
	},
	
	initAggPieChart: function(li) {
		
		li = $(li);
		var data = $.parseJSON(li.attr('data-chart'));
		
		var pie_chart_data = [];
        for(var i = 0; i < data.buckets.length; i++) {
            pie_chart_data[i] = [
                data.buckets[i].label.buckets[0].key,
                parseFloat(data.buckets[i].doc_count),
                data.buckets[i].key
            ];
        }

        li.find('.chart').highcharts({
            chart: {
                backgroundColor: null,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                events: {
                    click: function(e) {
                        console.log(e);
                    }
                },
	            height: 300
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b>'
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: false,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }                                
            },
            series: [{
                type: 'pie',
                name: 'Liczba',
                data: pie_chart_data
            }]
        });
		
	},
	
	initAggDateHistogram: function(li) {
		
		li = $(li);
		var data = $.parseJSON(li.attr('data-chart'));
		
		histogram_data = [];
        var max = 0;
        for(var i = 0; i < data.buckets.length; i++) {
            histogram_data[i] = parseInt(data.buckets[i].doc_count);
            if(max < histogram_data[i])
                max = histogram_data[i];
        }

        li.find('.chart').highcharts({
            chart: {
                zoomType: 'x',
                backgroundColor: null,
                height: 200
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'datetime',
                minRange: 365 * 24 * 3600000 // one year
            },
            yAxis: {
                title: {
                    text: ''
                },
                min: 0,
                max: max
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Liczba',
                pointInterval: 383 * 24 * 3600000,
                pointStart: Date.UTC(1918, 0, 1),
                data: histogram_data
            }]
        });
		
		
	},
	
	initAggColumnsVertical: function(li) {
		
		li = $(li);
		var data = $.parseJSON(li.attr('data-chart'));
		
		var columns_vertical_data = [];
        var columns_vertical_categories = [];

        for(var i = 0; i < data.buckets.length; i++) {
            columns_vertical_categories[i] = data.buckets[i].label.buckets[0].key;
            columns_vertical_data[i] = data.buckets[i].label.buckets[0].doc_count;
        }

        li.find('.chart').highcharts({
            chart: {
                type: 'column',
                backgroundColor: null
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: columns_vertical_categories,
                title: {
                    text: null
                },
                labels: {
                    rotation: -45
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' '
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Liczba',
                data: columns_vertical_data
            }]
        });
		
	},
	
	initAggColumnsHorizontal: function(li) {
		
		li = $(li);
		var data = $.parseJSON(li.attr('data-chart'));
		
		var columns_horizontal_data = [];
        var columns_horizontal_categories = [];

        for(var i = 0; i < data.buckets.length; i++) {
            columns_horizontal_categories[i] = data.buckets[i].label.buckets[0].key;
            columns_horizontal_data[i] = data.buckets[i].label.buckets[0].doc_count;
        }

        li.find('.chart').highcharts({
            chart: {
                type: 'bar',
                backgroundColor: null
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: columns_horizontal_categories,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' '
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Liczba',
                data: columns_horizontal_data
            }]
        });
		
	}
		
});


var dataBrowser;

$(document).ready(function() {
		
	window.DataBrowsers = [];
	var elements = $('.dataBrowser');
	for( var i=0; i<elements.length; i++ ) {
		dataBrowser = new DataBrowser(elements[i]);
		window.DataBrowsers.push(dataBrowser);
	}

});