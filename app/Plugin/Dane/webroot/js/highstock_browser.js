Number.prototype.round = function(p) {
  p = p || 10;
  return parseFloat( this.toFixed(p) );
};

function rodzaje_budzet(target_div) {
	li = $(target_div);
	var data = $.parseJSON(li.attr('data-chart')),
		pie_chart_data = [],
		pie_chart_keys = [],
		choose_request = li.attr('data-choose-request'),
		chart_options;

	try {
		chart_options = $.parseJSON(li.attr('data-chart-options'));
	} catch (err) {
		chart_options = false;
	}

	for (var i = 0; i < data.buckets.length; i++) {
		var label = ( typeof data.buckets[i].label.buckets[0] == 'undefined' ) ? '' : data.buckets[i].label.buckets[0].key;
		var value = parseFloat(data.buckets[i]['wartosc_brutto']['value']);
		value = Math.round(value);
		
		pie_chart_data[i] = [
			label,
			value
		];

		pie_chart_keys[i] = data.buckets[i].key;
	}

	var options = {
		chart: {
			backgroundColor: null,
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			height: 300,
			events: {
				load: function () {
					var chart = this,
						legend = chart.legend;

					for (var i = 0, len = legend.allItems.length; i < len; i++) {
						legend.allItems[i].legendItem.on('mouseover', function () {
							chart.series[0].points[i].onMouseOver();
						});
					}
				}
			}
		},
		title: {
			text: ''
		},
		tooltip: {
			pointFormat: '<b>{point.y} PLN</b>'
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
				showInLegend: true,
				point: {
					events: {
						legendItemClick: function () {
							return false;
						}
					}
				}
			}
		},
		series: [{
			type: 'pie',
			name: 'Liczba',
			data: pie_chart_data
		}]
	};

	options.legend = {
		useHTML: true,
		labelFormatter: function () {
			var name = this.name;
			if (name.length > 18) {
				name = name.substring(0, 15) + '...';
			}
			return name;
		},
		itemWidth: 150,
		itemStyle: {
			'font-weight': 'normal'
		}
	};
	li.find('.chart').highcharts(options);
}

jQuery(document).ready(function () {
    $('.mp-highstock_browser').each(function () {
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
                    more = btn.data('more');

                if (more) {
                    var href = more['url'] + '?' + $.param({
                            conditions: {
                                date: '[' + request['date_min'] + ' TO ' + request['date_max'] + ']'
                            }
                        });
                }

                var _href = btn.attr('data-href');
                if (_href) {
                    var href = _href + '?' + $.param({
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

            $.get('/dane/highstock_browser/aggs.html', params).done(function (data) {
                aggs_div.removeClass('loading');
                var html = $('<div>' + data + '</div>');

                for (var agg_id in aggs) {
                    if (aggs.hasOwnProperty(agg_id)) {
                        var target_div = aggs_div.find('.agg[data-agg_id="' + agg_id + '"]');
                        if (target_div.length) {
                            var src_div = html.find('.agg[data-agg_id=' + agg_id + ']');

                            if (src_div.length) {
                                target_div.html(src_div.html()).attr('class', src_div.attr('class')).attr('data-chart', src_div.attr('data-chart')).attr('data-counter_field', src_div.attr('data-counter_field'));

                                if (agg_id == 'wykonawcy') {
                                    DataBrowsers[0].initAggColumnsHorizontal(target_div);
                                }
                                
                                if (agg_id == 'rodzaje_budzet') {
                                    rodzaje_budzet(target_div);
                                }
                                
                                if (agg_id == 'rodzaje_wolumen') {
                                    DataBrowsers[0].initAggPieChart(target_div);
                                }
                                
                                if (agg_id == 'jednostki') {
                                    DataBrowsers[0].initAggPieChart(target_div);
                                }
                                
                                if (agg_id == 'tryby') {
                                    DataBrowsers[0].initAggPieChart(target_div);
                                }
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
