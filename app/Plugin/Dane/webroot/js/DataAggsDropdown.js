

var DataAggsDropdown = function(li) {
	var _this = this;
	this.li = $(li);
	this.skin = this.li.data('skin');
	this.aggs = this.li.data('aggs');
	this.cancelRequest = this.li.data('cancel-request');
	this.chooseRequest = this.li.data('choose-request');
	this.isSelected = this.li.data('is-selected') == '1';
	this.allLabel = this.li.data('all-label');
	this.counterField = this.li.data('counter-field') ? this.li.data('counter-field') : 'doc_count';
	this.labelField = this.li.data('label-field') ? this.li.data('label-field') : 'label';
	this.create();
};

DataAggsDropdown.prototype.create = function() {
	if(this.isCreated)
		return false;

	switch(this.skin) {
		case 'list':
			this.createList();
		break;

		case 'columns_horizontal':
			this.createColumnsHorizontal();
		break;

		case 'pie_chart':
			this.createPieChart();
		break;
	}

	this.isCreated = true;
};

DataAggsDropdown.prototype.createPieChart = function() {


	var _this = this;

	var dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownChart = '<li class="chart"></li>';

	dropdownChart += [
		'<li role="separator" class="divider"></li>',
		'<li><a href="' + this.cancelRequest + '">' + this.allLabel + '</a></li>'
	].join('');

	dropdownMenu.append(dropdownChart);

	var data = this.aggs;
	var pie_chart_data = [];
	var pie_chart_keys = [];
	var choose_request = this.chooseRequest;
	var chart_options;

	try {
		chart_options = $.parseJSON(li.attr('data-chart-options'));
	} catch (err) {
		chart_options = false;
	}

	for (var i = 0; i < data.buckets.length; i++) {

		var label = ( typeof data.buckets[i].label.buckets[0] == 'undefined' ) ? '' : data.buckets[i].label.buckets[0].key;

		pie_chart_data[i] = [
			label,
			parseFloat(data.buckets[i].doc_count)
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
						(function (i) {
							var item = legend.allItems[i].legendItem;
							item.on('mouseover', function (e) {
								chart.series[0].points[i].onMouseOver();
							});
						})(i);
					}

				}
			}
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
			data: pie_chart_data,
			point: {
				events: {
					click: function (e) {
						window.location.href = choose_request + '' + pie_chart_keys[this.index];
						return false;
					}
				}
			}
		}]
	};

	if (chart_options['mode'] == 'init') {

		options.legend = {
			useHTML: true,
			labelFormatter: function () {
				var name = this.name;
				if (name.length > 32)
					name = name.substring(0, 35) + '...';

				return '<a title="' + this.name + '" href="' + choose_request + '' + pie_chart_keys[this.index] + '">' + name + '</a>';
			},
			align: 'right',
			layout: 'vertical',
			verticalAlign: 'top',
			x: 0,
			y: 20,
			itemMarginBottom: 5,
			itemStyle: {
				'font-weight': 'normal'
			}
			// itemWidth: 150
		};

	} else {

		options.legend = {
			useHTML: true,
			labelFormatter: function () {
				var name = this.name;
				if (name.length > 18)
					name = name.substring(0, 15) + '...';
				return '<a href="' + choose_request + '' + pie_chart_keys[this.index] + '">' + name + '</a>';
			},
			itemWidth: 150,
			itemStyle: {
				'font-weight': 'normal'
			}
		};

	}

	this.li.find('li.chart').highcharts(options);

};

DataAggsDropdown.prototype.createColumnsHorizontal = function() {

	var columns_horizontal_data = [];
	var columns_horizontal_categories = [];
	var columns_horizontal_keys = [];

	for (var i = 0; i < this.aggs.buckets.length; i++) {
		columns_horizontal_categories[i] = this.aggs.buckets[i][this.labelField].buckets[0].key;
		columns_horizontal_data[i] = (this.aggs.buckets[i].label ? this.aggs.buckets[i].label.buckets[0][this.counterField] : false) || this.aggs.buckets[i][this.counterField]['value'] || this.aggs.buckets[i][this.counterField];
		columns_horizontal_keys[i] = this.aggs.buckets[i].key;
	}

	var tooltip = {
		valueSuffix: ' ',
		positioner: function () {
			return { x: this.now.anchorX, y: this.now.anchorY - 20 };
		},
		style: {
			zIndex: 9
		}
	};

	var _this = this;

	var dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownChart = '<li class="chart"></li>';

	dropdownChart += [
		'<li role="separator" class="divider"></li>',
		'<li><a href="' + this.cancelRequest + '">' + this.allLabel + '</a></li>'
	].join('');

	dropdownMenu.append(dropdownChart);

	this.li.find('li.chart').highcharts({
		chart: {
			type: 'bar',
			backgroundColor: null,
			events: {
				load: function () {
					var chart = this,
						legend = this.series[0].chart.axes[0].labelGroup.element;

					for (var i = 0, len = legend.childNodes.length; i < len; i++) {
						(function(i) {
							var item = legend.childNodes[i];
							item.onmouseover = function (e) {
								chart.series[0].points[i].onMouseOver();
							};

							item.onclick = function (e) {
								$(chart.series[0].points[i].graphic.element).click();
							}
						})(i);
					}

				}
			}
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
			},
			labels: {
				formatter: function () {

					var v = this.value;
					if (v.length > 15)
						v = v.substring(0, 12) + '...';

					return v;
				}
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
		tooltip: tooltip,
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
			data: columns_horizontal_data,
			point: {
				events: {
					click: function (e) {
						window.location.href = _this.chooseRequest + '' + columns_horizontal_keys[this.index];
						return false;
					}
				}
			},
			dataLabels: {
				enabled: true,
				formatter: function () {
					return _this.getAsPLNumber(this.y);
				}
			}
		}]
	});

};

DataAggsDropdown.prototype.createList = function() {

	var dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownList = '';

	for(var i = 0; i < this.aggs.buckets.length; i++) {
		dropdownList += [
			'<li' + (this.isSelected ? ' class="active"' : '') + '>',
				'<a href="' + this.chooseRequest + this.aggs.buckets[i].key + '">',
					this.aggs.buckets[i].key,
				'</a>',
			'</li>'
		].join('');
	}

	dropdownList += [
		'<li role="separator" class="divider"></li>',
		'<li><a href="' + this.cancelRequest + '">' + this.allLabel + '</a></li>'
	].join('');

	dropdownMenu.append(dropdownList);
};


DataAggsDropdown.prototype.getAsPLNumber = function(s) {
	var num = Math.round(s);

	if (num >= 1000000) {
		return (Math.round(num / 100000, 2) / 10) + 'M';
	} else if (num >= 1000) {
		return (Math.round(num / 100, 2) / 10) + 'k';
	}

	return num;
};

var dataAggsDropdown;

$(document).ready(function () {

	window.DataAggsDropdowns = [];

	$('li.dataAggsDropdown').each(function() {
		dataAggsDropdown = new DataAggsDropdown($(this));
		window.DataAggsDropdowns.push(dataAggsDropdown);
	});

});
