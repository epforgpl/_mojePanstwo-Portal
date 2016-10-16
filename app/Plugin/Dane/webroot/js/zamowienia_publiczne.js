/*global Highcharts*/
jQuery(document).ready(function () {
    $('.mp-zamowienia_publiczne').each(function () {
        var div = $(this),
            highstock_div = div.find('.highstock'),
            aggs_div = div.find('.dataAggs'),
            aggs = {},
            aggs_divs = aggs_div.find('.agg');

        for (var i = 0; i < aggs_divs.length; i++) {
            var agg_div = $(aggs_divs[i]),
                agg_params = agg_div.data('agg_params');

            aggs[agg_div.attr('data-agg_id')] = (
            agg_params && !$.isEmptyObject(agg_params)
            ) ? agg_params : true;
        }

        var request = div.data('request');
        if ($.isEmptyObject(request))
            request = {};
        var histogram_data = div.data('histogram');
        var extremes = false;

        var load = function (min, max) {
            var moreBtns = div.find('.btn-more');

            request['date_min'] = Highcharts.dateFormat("%Y-%m-%d", min);
            request['date_max'] = Highcharts.dateFormat("%Y-%m-%d", max);

            for (var i = 0; i < moreBtns.length; i++) {
                var btn = $(moreBtns[i]),
					more = btn.data('more'),
					href;

                if (more) {
	                console.log('more', more);
	                
	            href = more['url'];
	            
	            if(
		            !href.length || 
		            ( href.substring( href.length-1 ) !== '?' ) 
	            )
	            	href += '?';
	            
				href += $.param({
                        conditions: {
                            date: '[' + request['date_min'] + ' TO ' + request['date_max'] + ']'
                        }
                    });
                }

                var _href = btn.attr('data-href');
                if (_href) {
	                
	                href = _href;
	                
	                if(
			            !_href.length || 
			            ( _href.substring( _href.length-1 ) !== '?' ) 
		            )
		            	_href += '?';
	                
					href += $.param({
                        date_min: request['date_min'],
                        date_max: request['date_max']
                    });
                }

                btn.attr('href', href);
            }

            var params = {
                request: request,
                aggs: aggs
            };

            aggs_div.addClass('loading');

            $.get('/zamowienia_publiczne/aggs.html', params).done(function (data) {
                aggs_div.removeClass('loading');
                var html = $('<div>' + data + '</div>');

                for (var agg_id in aggs) {
                    if (aggs.hasOwnProperty(agg_id)) {
                        var target_div = aggs_div.find('.agg[data-agg_id="' + agg_id + '"]');
                        if (target_div.length) {
                            var src_div = html.find('.agg[data-agg_id=' + agg_id + ']');

                            if (src_div.length) {
                                target_div.html(src_div.html()).attr('class', src_div.attr('class')).attr('data-chart', src_div.attr('data-chart')).attr('data-counter_field', src_div.attr('data-counter_field'));

                                if (agg_id == 'wykonawcy')
                                    DataBrowsers[0].initAggColumnsHorizontal(target_div);
                            }
                        }
                    }
                }

                aggs_div.find('.buttons').show();
            });
        };

        highstock_div.highcharts('StockChart', {
            chart: {
                height: 210,
				backgroundColor: null,
                events: {
                    load: function () {
                        var e = this.xAxis[0].getExtremes();
                        load(e.min, e.max);
                    }
                }
            },
            navigator: {
                height: 140,
                yAxis: {
                    tickWidth: 0,
                    lineWidth: 0,
                    gridLineWidth: 1,
                    tickPixelInterval: 40,
                    gridLineColor: '#EEE',
                    labels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            rangeSelector: {
                selected: 1
            },
            title: {
                text: ''
            },
            series: [{
                name: 'Suma',
                data: histogram_data,
                tooltip: {
                    valueDecimals: 2
                },
                color: 'transparent'
            }],
            xAxis: {
                labels: {
                    enabled: false
                },
                gridLineWidth: 0,
                lineWidth: 0,
                tickWidth: 0,
                events: {
                    setExtremes: function (e) {
                        if (e.trigger == 'navigator') {
                            extremes = e;
                            setTimeout(function () {
                                if (extremes == e) {
                                    load(e.min, e.max);
                                }
                            }, 300);
                        } else {
                            load(e.min, e.max);
                        }
                    }
                }
            },
            yAxis: {
                labels: {
                    enabled: false
                },
                gridLineWidth: 0,
                lineWidth: 0,
                tickWidth: 0,
                events: {
                    setExtremes: function (e) {
                        if (e.trigger == 'navigator') {
                            extremes = e;
                            setTimeout(function () {
                                if (extremes == e) {
                                    load(e.min, e.max);
                                }
                            }, 300);
                        } else {
                            load(e.min, e.max);
                        }
                    }
                }
            }
        });
    });
});
