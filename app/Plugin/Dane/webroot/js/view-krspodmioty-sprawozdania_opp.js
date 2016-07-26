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

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

/*global mPHeart, Highcharts*/
$(document).ready(function () {
	
	$('.chart_description a').click(function(event){
		
		event.preventDefault();
		
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
    
    
    
    
    
    var $documentFastCheck = $('.documentFastCheck');
    if ($documentFastCheck) {
        var modal = $('<div></div>').addClass('modal fade').attr({
            'id': 'documentFastCheckModal',
            'tabindex': "-1",
            'role': 'dialog',
            'aria-labelledby': 'documentFastCheckModalLabel',
            'aria-hidden': 'true'
        }).append(
            $('<div></div>').addClass('modal-dialog').append(
                $('<div></div>').addClass('modal-content').append(
                    $('<div></div>').addClass('modal-header').append(
                        $('<button></button>').addClass('close').attr({
                            'type': 'button',
                            'data-dismiss': 'modal',
                            'aria-label': 'Close'
                        }).append(
                            $('<span></span>').attr('aria-hidden', 'true').html("&times;")
                        )
                    )
                ).append(
                    $('<div></div>').addClass('modal-body').append(
                        $('<iframe></iframe>').addClass('loading').attr('name', 'preview')
                    )
                )
            )
        );
        $('#_main').append(modal);
		
		modal.on('hidden.bs.modal', function () {
		    history.pushState('?', '?', '?');
		});
		
		if( getUrlParameter('c') ) {
			
			$.each($documentFastCheck, function () {
	        	
	        	$this = $(this).find('a');
	        	
	        	if( $this.data('id')==getUrlParameter('c') ) {
	                
	                modal.find('.modal-body').html(
	                    $('<iframe></iframe>').addClass('loading').attr('name', 'preview')
	                );
	                modal.modal('show');
	
	                var documentId = $this.data('documentid');
	                var frame = modal.find('iframe');
									
					frame.attr('src', 'https://mojepanstwo.pl/docs/' + documentId + '.html');
										
				}
	                	            
	        });
			
		}
		
        $.each($documentFastCheck, function () {
	        
	        
            $(this).find('a').click(function (e) {
                
                e.preventDefault();
                $this = $(this);
                
                history.pushState($this.data('id'), $this.find('content').text(), '?c=' + $this.data('id'));
                
                modal.find('.modal-body').html(
                    $('<iframe></iframe>').addClass('loading').attr('name', 'preview')
                );
                modal.modal('show');

                var documentId = $this.data('documentid');
                var frame = modal.find('iframe');
								
				frame.attr('src', 'https://mojepanstwo.pl/docs/' + documentId + '.html');
                
            });
        });
    }
	
	
});