

var DataAggsDropdown = function(li) {
	var _this = this;
	this.li = $(li);
	this.skin = this.li.data('skin');
	this.aggs = this.li.data('aggs');
	this.cancelRequest = this.li.data('cancel-request');
	this.chooseRequest = this.li.data('choose-request');
	this.labelDictionary = this.li.data('label-dictionary');
	this.isSelected = this.li.data('is-selected') == '1';
	this.selected = this.li.data('selected');
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

		case 'date_histogram':
			this.createDateHistogram();
		break;

		case 'krs/kapitalizacja':
			this.createColumnsVertical();
		break;
	}

	this.isCreated = true;
};

DataAggsDropdown.prototype.createColumnsVertical = function() {

	var data = this.aggs;

	var columns_vertical_data = [];
	var columns_vertical_categories = [];
	var columns_vertical_keys = [];
	var choose_request = this.chooseRequest;

	var _this = this;

	var dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownChart = '<li class="chart"></li>';

	dropdownChart += [
		'<li role="separator" class="divider"></li>',
		'<li><a href="' + this.cancelRequest + '">' + this.allLabel + '</a></li>'
	].join('');

	dropdownMenu.append(dropdownChart);

	for (var i = 0; i < data.buckets.length; i++) {
		if (data.buckets[i].label === undefined) {
			columns_vertical_categories[i] = this.prepareNumericLabel(data.buckets[i].key);
			columns_vertical_data[i] = data.buckets[i].doc_count;
		} else {
			columns_vertical_categories[i] = data.buckets[i].label.buckets[0].key;
			columns_vertical_data[i] = data.buckets[i].label.buckets[0].doc_count || data.buckets[i].doc_count;
		}

		columns_vertical_keys[i] = data.buckets[i].key;
	}

	this.li.find('.chart').highcharts({
		chart: {
			type: 'column',
			backgroundColor: null,
			height: 300
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
			data: columns_vertical_data,
			point: {
				events: {
					click: function (e) {
						var index = e.point.index;
						var bucket = data.buckets[index];

						var dataArg = ['[', bucket.from];
						dataArg.push(' TO ');
						if (bucket.to)
							dataArg.push(bucket.to);
						dataArg.push(']');

						window.location.href = choose_request + dataArg.join('');
						return false;
					}
				}
			}
		}]
	});

};

DataAggsDropdown.prototype.createDateHistogram = function() {

	var _this = this;

	var dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownChart = '<li class="chart"></li>';

	dropdownChart += [
		'<li role="separator" class="divider"></li>',
		'<li><a href="' + this.cancelRequest + '">' + this.allLabel + '</a></li>'
	].join('');

	dropdownMenu.append(dropdownChart);

	var data = this.aggs;
	var histogram_keys = [];
	var choose_request = this.chooseRequest;
	var histogram_data = [];
	var max = 0;

	var dateRange = {
		min: 9000000000000,
		max: 0
	};

	for (var i = 0; i < data.buckets.length; i++) {
		var date = data.buckets[i].key_as_string.split("-");

		var utc = Date.UTC(parseInt(date[0]), parseInt(date[1]) - 1, parseInt(date[2]));
		if (utc < dateRange.min)
			dateRange.min = utc;
		if (utc > dateRange.max)
			dateRange.max = utc;

		histogram_data[i] = [
			Date.UTC(parseInt(date[0]), parseInt(date[1]) - 1, parseInt(date[2])),
			parseInt(data.buckets[i].doc_count)
		];

		histogram_keys[i] = data.buckets[i].key_as_string;

		if (max < histogram_data[i][1])
			max = histogram_data[i][1];
	}

	this.li.find('li.chart').highcharts({
		chart: {
			zoomType: 'x',
			backgroundColor: null,
			height: 200,
			events: {
				selection: function (e) {
					var range = e.xAxis[0];
					var dateMin = new Date(range.min);
					var dateMax = new Date(range.max);
					var dataArg = [
						'[',
						_this.getFormattedDate(dateMin),
						' TO ',
						_this.getFormattedDate(dateMax),
						']'
					];

					window.location.href = choose_request + dataArg.join('');
					return false;
				}
			}
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
			type: 'datetime'
			//minRange: 365 * 24 * 3600000 // one year
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
			//pointInterval: 383 * 24 * 3600000,
			//pointStart: Date.UTC(1918, 0, 1),
			point: {
				events: {
					click: function (e) {
						var time = e.point.category;
						var dateMin = new Date(time);
						var dateMax = new Date(time + 31536000000);
						var dataArg = [
							'[',
							_this.getFormattedDate(dateMin),
							' TO ',
							_this.getFormattedDate(dateMax),
							']'
						];

						window.location.href = choose_request + dataArg.join('');
						return false;
					}
				}
			},
			data: histogram_data
		}]
	});

};

DataAggsDropdown.prototype.createPieChart = function() {
	var _this = this,
		dropdownMenu = this.li.find('ul.dropdown-menu'),
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
		var label = '';
		if(typeof data.buckets[i].label !== 'undefined') {
			label = ( typeof data.buckets[i].label.buckets[0] == 'undefined' ) ? '' : data.buckets[i].label.buckets[0].key;
		} else if(typeof data.buckets[i].key !== 'undefined') {
			label = data.buckets[i].key;
		}

		if(this.labelDictionary.hasOwnProperty(label)) {
			label = this.labelDictionary[label];
		}

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
				if (name.length > 45)
					name = name.substring(0, 42) + '...';

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
					if (v.length > 45)
						v = v.substring(0, 42) + '...';

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

		var label = this.aggs.buckets[i].key;
		if(this.labelDictionary.hasOwnProperty(label))
			label = this.labelDictionary[label];

		dropdownList += [
			'<li' + (this.isSelected && this.selected == this.aggs.buckets[i].key ? ' class="active"' : '') + '>',
				'<a href="' + this.chooseRequest + this.aggs.buckets[i].key + '">',
					label,
				'</a>',
			'</li>'
		].join('');
	}

	if(this.allLabel.length > 0) {
		dropdownList += [
			'<li role="separator" class="divider"></li>',
			'<li><a href="' + this.cancelRequest + '">' + this.allLabel + '</a></li>'
		].join('');
	}

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

DataAggsDropdown.prototype.getFormattedDate = function (date) {
	var year = date.getFullYear();
	var month = (date.getMonth() + 1).toString();
	month = month.length == 2 ? month : '0' + month;
	var day = date.getDate().toString();
	day = day.length == 2 ? day : '0' + day;
	return year + '-' + month + '-' + day;
};

DataAggsDropdown.prototype.scienNotationToNum = function (str) {
	var number = str[0];
	for (var i = 0; i <= parseInt(str[str.length - 1]); i++)
		number += '0';
	return number;
};

DataAggsDropdown.prototype.prepareNumeric = function (str) {
	var number = str[0];
	if (str.indexOf('E') > -1)
		str = this.scienNotationToNum(str);
	var zeros = str.split('0').length - 2;
	var addZeros = 0;
	var unit = '';
	var newStr = number;

	if (zeros >= 3 && zeros < 6) {
		unit = 'k';
		addZeros = zeros - 3;
	}

	if (zeros >= 6 && zeros < 9) {
		unit = 'M';
		addZeros = zeros - 6;
	}

	for (var i = 0; i < addZeros; i++)
		newStr += '0';

	newStr += unit;

	return newStr;
};

DataAggsDropdown.prototype.prepareNumericLabel = function (str) {
	if (str.indexOf('-') === -1) {
		return this.prepareNumeric(str);
	} else {
		var s = str.split('-');
		return this.prepareNumeric(s[0]) + '-' + this.prepareNumeric(s[1]);
	}
};

var dataAggsDropdown;

$(document).ready(function () {

	window.DataAggsDropdowns = [];

	$('li.dataAggsDropdown').each(function() {
		dataAggsDropdown = new DataAggsDropdown($(this));
		window.DataAggsDropdowns.push(dataAggsDropdown);
	});

});
