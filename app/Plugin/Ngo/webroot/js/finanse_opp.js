function number_format(number, decimals, dec_point, thousands_sep) {
        
    number = number + '';
    
    var sign = true;
    if( number[0]=='-' ) {
    	sign = false;
    	number = number.substr(1);
    }
    
    number = number.replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    
    var ret = s.join(dec);
    
    if( !sign )
    	ret = '-' + ret;
        
    return ret;
}

function number_format_h(n) {
	
	n = String(n);
	
	var sign = '';
    if( n[0]=='-' ) {
    	sign = '-';
    	n = n.substr(1);
    }
	
    // first strip any formatting;
    n = (0 + n.replace(",", ""));

    // is this a number?
    if (isNaN(n)) return false;

    var $n = Math.abs(n);
    // now filter it;
    if ($n > 1000000000000000) return sign + Math.round((n / 1000000000000000) * 10) / 10 + ' blr.';
    else if ($n > 1000000000000) return sign + Math.round((n / 1000000000000) * 10) / 10 + ' bln.';
    else if ($n > 1000000000) return sign + Math.round((n / 1000000000) * 10) / 10 + ' mld.';
    else if ($n > 1000000) return sign + Math.round((n / 1000000) * 10) / 10 + ' mln';
    else if ($n > 1000) return sign + Math.round((n / 1000) * 10) / 10 + ' tys.';
	
	var ret = sign + number_format(n, 0, '.', ' ');		
    return ret;
}

/*global mPHeart, Highcharts*/
$(document).ready(function () {
	
	var $dataForm = $('#dataForm');
	var $charts = $('.histogram_chart.init');	
	
	$dataForm.find('select').change(function () {
		$dataForm.submit();
	});
	
	var params = $dataForm.serialize();
	
	for( var i=0; i<$charts.length; i++ ) {
		$chart = $($charts[i]);
		params += '&fields[' + $chart.data('field') + ']=' + $chart.data('histogram-interval');
	}
	
	$('button.btn-rank').click(function(event){
		
		event.preventDefault();
		var btn = $(event.target);
		var div = btn.parents('.histogram_chart');
		
		var field = div.data('field');
		
		showRank({
			field: field
		});
		
	});
	
	$.get('/ngo/sprawozdania_opp_histogram.json?' + params, function(data){
		for( var i=0; i<$charts.length; i++ ) {
			
			$chart = $($charts[i]);
			var field = $chart.data('field');
			
			chartInit($chart, data['aggs']['krs_podmioty']['sprawozdania_opp']['rocznik']['histogram.'+field]['buckets']);
			
		}
	});
	
	$('#chart-income-sources .chart_description a, #chart-income-types .chart_description a').click(function(event){
		
		event.preventDefault();
		var a = $(event.target).parents('a');
		var field = a.data('field');
		chartStart('#chart-dynamic-income', field, a.find('._label').text());	
		
	});
	
	$('#chart-outcome-types .chart_description a, #chart-outcome-percent-types .chart_description a').click(function(event){
		
		event.preventDefault();
		var a = $(event.target).parents('a');
		var field = a.data('field');
		chartStart('#chart-dynamic-outcome', field, a.find('._label').text());	
		
	});

	var incomeSources = [];
	var incomeSubsources = [];
		
	var items = $('#chart-income-sources .chart_description >ul >li >.item');
	for( var i=0; i<items.length; i++ ) {
		
		var item = $(items[i]);
		var subitems = item.parents('li').find('ul li .item');
		var value = item.data('value');
		var color = item.data('color');
		
		incomeSources.push({
			id: item.data('field'),
			name: item.find('._label').text(),
			y: Number(value),
			color: color
		});
		
		var incomeSubsourcesSum = 0;
		
		for( var j=0; j<subitems.length; j++ ) {
			
			var subitem = $(subitems[j]);
			var subvalue = subitem.data('value');
			var subcolor = Highcharts.Color(color).brighten((j+2)/16).get();
			
			incomeSubsources.push({
				id: subitem.data('field'),
				name: subitem.find('._label').text(),
				y: Number(subvalue),
				color: subcolor
			});
			
			subitem.find('._color').css('background-color', subcolor);
			
			incomeSubsourcesSum += subvalue;
			
		}
		
		var diff = value - incomeSubsourcesSum;
		if( diff > 0 ) {
			
			incomeSubsources.push({
				name: '',
				y: diff,
				color: 'rgba(0,0,0,0)'
			});
			
		}
		
	}
		
	

    $('#chart-income-sources .chart').highcharts({
        chart: {
            type: 'pie',
	        backgroundColor: 'rgba(0,0,0,0)'
        },
        title: {
            text: ''
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                point:{
					events : {
						click: function(event) {
							event.preventDefault();
							if( this.id )
								chartStart('#chart-dynamic-income', this.id, this.name);
						}
					}
				}
            }
        },
        credits: {
	        enabled: false
        },
        series: [{
            name: 'Wartość: ',
            data: incomeSources,
        }, {
            name: 'Wartość: ',
            data: incomeSubsources,
            innerSize: '75%',
            borderColor: 'rgba(0,0,0,0)'
        }],
        tooltip: {
	        formatter: function() {
	            return this.point.name ? this.point.name + ':<br/><b>' + number_format_h(this.y) + ' zł</b>' : false;
            }
        }
    });
    
    
  
    var incomeSources = [];
	
	var items = $('#chart-income-types .chart_description >ul >li >.item');
	for( var i=0; i<items.length; i++ ) {
		
		var item = $(items[i]);
		var subitems = item.parents('li').find('ul li .item');
		var value = item.data('value');
		var color = item.data('color');
		
		incomeSources.push({
			id: item.data('field'),
			name: item.find('._label').text(),
			y: Number(value),
			color: color
		});
				
	}
	
	

    $('#chart-income-types .chart').highcharts({
        chart: {
            type: 'pie',
	        backgroundColor: 'rgba(0,0,0,0)'
        },
        title: {
            text: ''
        },
        plotOptions: {
            pie: {
                allowPointSelect: false,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                point:{
					events : {
						click: function(event) {
							event.preventDefault();
							if( this.id )
								chartStart('#chart-dynamic-income', this.id, this.name);
						}
					}
				}
            }
        },
        credits: {
	        enabled: false
        },
        series: [{
            name: 'Wartość: ',
            data: incomeSources
        }],
        tooltip: {
	        formatter: function() {
	            return this.point.name ? this.point.name + ':<br/><b>' + number_format_h(this.y) + ' zł</b>' : false;
            }
        }
    });
    
    
    
    
    var outcomeTypes = [];
	var outcomeSubtypes = [];
    
    var items = $('#chart-outcome-types .chart_description >ul >li >.item');
	for( var i=0; i<items.length; i++ ) {
		
		var item = $(items[i]);
		var subitems = item.parents('li').find('ul li .item');
		var value = item.data('value');
		var color = item.data('color');
		
		outcomeTypes.push({
			id: item.data('field'),
			name: item.find('._label').text(),
			y: Number(value),
			color: color
		});
		
		var incomeSubsourcesSum = 0;
		
		for( var j=0; j<subitems.length; j++ ) {
			
			var subitem = $(subitems[j]);
			var subvalue = subitem.data('value');
			var subcolor = Highcharts.Color(color).brighten((j+2)/16).get();
			
			outcomeSubtypes.push({
				id: subitem.data('field'),
				name: subitem.find('._label').text(),
				y: Number(subvalue),
				color: subcolor
			});
			
			subitem.find('._color').css('background-color', subcolor);
			
			incomeSubsourcesSum += subvalue;
			
		}
		
		var diff = value - incomeSubsourcesSum;
		if( diff > 0 ) {
			
			outcomeSubtypes.push({
				name: '',
				y: diff,
				color: 'rgba(0,0,0,0)'
			});
			
		}
		
	}
		
	

    $('#chart-outcome-types .chart').highcharts({
        chart: {
            type: 'pie',
	        backgroundColor: 'rgba(0,0,0,0)'
        },
        title: {
            text: ''
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                point:{
					events : {
						click: function(event) {
							event.preventDefault();
							if( this.id )
								chartStart('#chart-dynamic-outcome', this.id, this.name);
						}
					}
				}
            }
        },
        credits: {
	        enabled: false
        },
        series: [{
            name: 'Wartość: ',
            data: outcomeTypes,
        }, {
            name: 'Wartość: ',
            data: outcomeSubtypes,
            innerSize: '75%',
            borderColor: 'rgba(0,0,0,0)'
        }],
        tooltip: {
	        formatter: function() {
	            return this.point.name ? this.point.name + ':<br/><b>' + number_format_h(this.y) + ' zł</b>' : false;
            }
        }
    });
    
    
    
	
	
	
});


function chartInit(chart, data) {
		
	var $chart = $(chart),
		histogram_div = jQuery($chart.find('.histogram')),
		interval = $chart.data('histogram-interval') || 0,
		charts_data = [];
				
	for (var d = 0; d < data.length; d++) {
		if (data[d]) {
			var v = Number(data[d]['doc_count']);

			charts_data.push({
				x: data[d]['key'],
				y: v
			});
		}
	}
	
	new Highcharts.Chart({
		chart: {
			renderTo: chart.find('.histogram')[0],
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
					x: 185,
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
				pointPlacement: "on",
				cursor: 'pointer',
	            point: {
	                events: {
	                    click: function(event) {
	                        
	                        console.log('click');
	                        
	                        var min = this.x;
	                        var chart = $(event.target).parents('.histogram_chart');
	                        var field = chart.data('field');
	                        var interval = chart.data('histogram-interval');
	                        var max = min + interval;
	                        
	                        showRank({
		                        field: field,
		                        min: min,
		                        max: max
	                        });
	                        
	                    }
	                }
	            }
			}
		},

		series: [{
			data: charts_data
		}]

	});
}

function chartStart(div, field, title) {
		
	$chart_dynamic = $(div);	
	
	$chart_dynamic.data('field', field);
	$chart_dynamic.find('h2').text(title+':')
	$chart_dynamic.find('.block-ranking ul').html('');
	$chart_dynamic.find('.block-ranking button').hide();
	$chart_dynamic.find('.gradient_cont ._median').hide();
	$chart_dynamic.find('.histogram').html('<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
	
	var targetHeight = $chart_dynamic.height() + 10;
	
	if( $chart_dynamic.hasClass('closed') )
		$chart_dynamic.css({height: 0}).show();
	
	var offset = $chart_dynamic.offset();		
	var top = offset['top']-43;
	
	var top_init = $(window).scrollTop();
	
		
	if( $chart_dynamic.hasClass('closed') ) {
	
		$chart_dynamic.removeClass('closed').animate({
			'height': targetHeight
		}, {
			progress: function(a, b) {
				var p = top_init + (top-top_init) * b;
				$(window).scrollTop(p);
			}
		});
	
	} else {
		
		$chart_dynamic.animate({
			'null': targetHeight
		}, {
			progress: function(a, b) {
				var p = top_init + (top-top_init) * b;
				$(window).scrollTop(p);
			}
		});
		
	}
		
	var $dataForm = $('#dataForm');	
	var params = $dataForm.serialize();
	var _params = params + '&fields[]=' + field;
	
	$.get('/ngo/sprawozdania_opp_stats.json?' + _params, function(aggs){
		
		var aggs = aggs.aggs.krs_podmioty.sprawozdania_opp.rocznik;
		
		var diff = aggs['stats.'+field]['max'] - aggs['stats.'+field]['min'];
		var histogram_interval = Math.ceil(diff / 50); 
		var left = Math.round( 100 * ( aggs['percentiles.'+field]['values']['50.0'] - aggs['stats.'+field]['min'] ) / diff );
		
		$chart_dynamic.data('histogram-interval', histogram_interval);
		$chart_dynamic.find('.histogram').data('median', aggs['percentiles.'+field]['values']['50.0']);
		$chart_dynamic.find('._median').css({left: left + '%'}).html('Mediana<br/>' + number_format_h(aggs['percentiles.'+field]['values']['50.0'])).show();
		
		var ul_html = '';
		var items = aggs['max.' + field]['buckets'];
		
		for( var i=0; i<items.length; i++ ) {
			
			var item = items[i];
			var title = item['reverse']['top']['hits']['hits'][0]['_source']['data']['krs_podmioty']['nazwa'];
			var short_title = title.substring(0, 60);
			if( short_title.length<title.length )
				short_title += '...'
			
			ul_html += '<li class="objectRender krs_podmioty"><span class="object-icon icon-datasets-krs_podmioty"></span><div class="title_cont"><p class="title"><a href="/' + item['reverse']['top']['hits']['hits'][0]['_source']['slug'] + '/sprawozdania_opp_rocznik/' + $('#dataForm #rangeSelect').val() + '">' + short_title + '</a></p><p class="value">' + number_format_h(item['key']) + ' zł</p></div></li>';			
			
		}
		
		$chart_dynamic.find('.block-ranking ul').html(ul_html);
		$chart_dynamic.find('.block-ranking button').show();
		

		var _params = params + '&fields[' + field + ']=' + histogram_interval;
		
		$.get('/ngo/sprawozdania_opp_histogram.json?' + _params, function(data){
			chartInit($chart_dynamic, data['aggs']['krs_podmioty']['sprawozdania_opp']['rocznik']['histogram.'+field]['buckets']);
		});
				
	});
		
}

function showRank(params) {
	
	var $dataForm = $('#dataForm');
	var _params = $dataForm.serialize();
	
	if( params['field'] )
		_params += '&field=' + params['field'];
		
	if( params['min'] )
		_params += '&min=' + params['min'];
		
	if( params['max'] )
		_params += '&max=' + params['max'];
	
	var body = $('#rankModal .modal-body').html('<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
	$('#rankModal').modal('show');
	
	$.get('/ngo/sprawozdania_opp_rank.json?' + _params, function(data){
		
		var ul_html = '<ul>';
		var items = data.aggs.krs_podmioty.sprawozdania_opp.rocznik.rank.buckets;
		
		for( var i=0; i<items.length; i++ ) {
			
			var item = items[i];
			var hits = item['reverse']['top']['hits']['hits'];
			
			for( var j=0; j<hits.length; j++ ) {
			
				var title = hits[j]['_source']['data']['krs_podmioty']['nazwa'];
				var short_title = title.substring(0, 60);
				if( short_title.length<title.length )
					short_title += '...'
								
				ul_html += '<li class="objectRender krs_podmioty"><span class="object-icon icon-datasets-krs_podmioty"></span><div class="title_cont"><p class="title"><a href="/' + hits[j]['_source']['slug'] + '/sprawozdania_opp_rocznik/' + $('#dataForm #rangeSelect').val() + '">' + short_title + '</a></p><p class="value">' + number_format_h(item['key']) + ' zł</p></div></li>';	
			
			}		
			
		}
		
		ul_html += '</ul>';
				
		body.html(ul_html);
		
	});
	
}