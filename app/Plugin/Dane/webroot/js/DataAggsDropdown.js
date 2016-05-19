

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
	this.desc = this.li.data('desc');
	this.counterField = this.li.data('counter-field') ? this.li.data('counter-field') : 'doc_count';
	this.labelField = this.li.data('label-field') ? this.li.data('label-field') : 'label';
	this.create();
};

DataAggsDropdown.prototype.create = function() {
	if(this.isCreated)
		return false;

	var dropdownMenu = this.li.find('ul.dropdown-menu');


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

		case 'highstockPicker':
			this.createHighstockPicker();
		break;
	}

	this.isCreated = true;
};

DataAggsDropdown.prototype.createHighstockPicker = function() {

	var data = this.aggs;
	var _this = this;

	var histogram_data = [];
	for(var i = 0; i < data.buckets.length; i++) {
		var bucket = data.buckets[i];
		histogram_data.push([
			bucket.key,
			bucket.doc_count
		]);
	}

	var dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownChart = '<li class="chart highstock"></li>';

	dropdownMenu.css('left', '-' + (this.li[0].offsetLeft - 38) + 'px');

	dropdownChart += [
		'<li class="apply"><a href="' + this.cancelRequest + '"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Zastosuj</a></li>'
	].join('');

	if(this.allLabel.length > 0 && this.isSelected) {
		dropdownChart += [
			'<li class="cancel"><a href="' + this.cancelRequest + '">Usuń filtr</a></li>'
		].join('');
	}

	dropdownMenu.append(dropdownChart);

	var apply = dropdownMenu.find('li.apply').first();

	dropdownMenu.click(function(e) {
		e.stopPropagation();
	});

	var chart = this.li.find('.chart').highcharts('StockChart', {
		chart: {
			width: $(this.li).parent('.dataAggsDropdownList').first().outerWidth(),
			height: 210,
			backgroundColor: null,
			events: {
				load: function () {
					//var e = this.xAxis[0].getExtremes();
					//load(e.min, e.max);
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
			selected: 5
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
								//load(e.min, e.max);
							}

							apply.css('visibility', 'visible');
						}, 300);
					} else {
						//load(e.min, e.max);
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
								//load(e.min, e.max);
							}
						}, 300);
					} else {
						//load(e.min, e.max);
					}
				}
			}
		}
	});

	$(this.li).find('.apply').click(function() {
		var extremes = chart.highcharts().xAxis[0].getExtremes(),
			start = new Date(extremes.min),
			end   = new Date(extremes.max);

		window.location.href = _this.chooseRequest + '['
				+ _this.dateToYYYYMMDD(start)
				+ ' TO '
				+ _this.dateToYYYYMMDD(end)
				+ ']';

		return false;
	});

};


DataAggsDropdown.prototype.dateToYYYYMMDD = function(date) {
	var d = date,
		month = '' + (d.getMonth() + 1),
		day = '' + d.getDate(),
		year = d.getFullYear();

	if (month.length < 2) month = '0' + month;
	if (day.length < 2) day = '0' + day;

	return [year, month, day].join('-');
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

	if(this.allLabel.length > 0 && this.isSelected) {
		dropdownChart += [
			'<li class="cancel"><a href="' + this.cancelRequest + '">Usuń filtr</a></li>'
		].join('');
	}

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

DataAggsDropdown.prototype.histogramOptions = [
	{
		label: 'Kiedykolwiek',
		value: null
	},
	{
		label: 'Ostatnie 24 godziny',
		value: '1D'
	},
	{
		label: 'Ostatni tydzień',
		value: '1W'
	},
	{
		label: 'Ostatni miesiąc',
		value: '1M'
	},
	{
		label: 'Ostatni rok',
		value: '1Y'
	}
];

DataAggsDropdown.prototype.createDateHistogram = function() {

	var _this = this;

	var dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownStr = '<li class="chart"></li>';

	var key, option;
	for(key in _this.histogramOptions) {
		if(!_this.histogramOptions.hasOwnProperty(key))
			continue;

		option = _this.histogramOptions[key];

		dropdownStr += [
			'<li', ((option.value == null && !this.isSelected) || (this.isSelected && option.value == this.selected)) ? ' class="active"' : '' ,'>',
			'<a href="', (option.value == null) ? _this.cancelRequest : _this.chooseRequest + option.value, '">',
					option.label,
				'</a>',
			'</li>'
		].join('');
	}

	var rangeSelected = (this.isSelected && this.selected.indexOf('TO') !== -1),
		rangeFrom = null,
		rangeTo = null;

	if(rangeSelected) {
		var dates = this.selected.split('TO');
		rangeFrom = dates[0].substring(1, dates[0].length - 1);
		rangeTo = dates[1].substring(1, dates[1].length - 1);
	}

	dropdownStr += [
		'<li', rangeSelected ? ' class="active"' : '' ,'>',
			'<a href="#" data-toggle="modal" data-target=".histogramDateRange">Wybierz zakres..</a>',
		'</li>'
	].join('');

	this.li.append([
		'<div class="modal fade histogramDateRange" tabindex="-1" role="dialog" aria-labelledby="histogramDateRange">',
			'<div class="modal-dialog modal-sm">',
				'<div class="modal-content">',
					'<div class="modal-header">',
						'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
						'<h3 class="modal-title">Niestandardowy zakres dat</h3>',
					'</div>',
					'<div class="modal-body">',
						'<div class="input-daterange input-group" id="datepicker">',
							'<input type="text" class="input-sm form-control" ', rangeFrom != null ? 'value="' + rangeFrom + '"' : '' ,'name="start"/>',
							'<span class="input-group-addon">do</span>',
							'<input type="text" class="input-sm form-control" ', rangeTo != null ? 'value="' + rangeTo + '"' : '' ,'name="end"/>',
						'</div>',
					'</div>',
					'<div class="modal-footer">',
		'<button class="btn width-auto btn-default btn-icon" type="button" data-dismiss="modal">',
		'<span class="icon  glyphicon glyphicon-remove text-muted" aria-hidden="true"></span>',
							'Anuluj',
						'</button>',
		'<button class="btn width-auto btn-primary btn-icon" type="button">',
		'<span class="icon" data-icon="&#xe604;"></span>',
							'Zastosuj',
						'</button>',
					'</div>',
				'</div>',
			'</div>',
		'</div>'
	].join(''));

	dropdownMenu.append(dropdownStr);

	var bootstrapDP = $.fn.datepicker.noConflict();
	$.fn.bootstrapDP = bootstrapDP;
	var _datepicker = $('#datepicker'),
		_start = _datepicker.find('input[name=start]').first(),
		_end = _datepicker.find('input[name=end]').first(),
		submit = this.li.find('.histogramDateRange .btn.btn-primary').first();

	_datepicker.bootstrapDP({
		language: 'pl',
		orientation: 'auto top',
		format: "yyyy-mm-dd",
		autoclose: true
	});

	submit.click(function() {
		var startStr = _start.val(),
			endStr = _end.val(),
			dataArg = ['[', startStr, ' TO ', endStr, ']'];

		if(startStr == '' || endStr == '') {
			window.location.href = _this.cancelRequest;
		} else {
			window.location.href = _this.chooseRequest + dataArg.join('');
		}

		return false;
	});

};

DataAggsDropdown.prototype.createPieChart = function() {
	var _this = this,
		dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownChart = '<li class="chart"></li>';

	if(this.allLabel.length > 0 && this.isSelected) {
		dropdownChart += [
			'<li class="cancel"><a href="' + this.cancelRequest + '">Usuń filtr</a></li>'
		].join('');
	}

	dropdownMenu.append(dropdownChart);

	var data = this.aggs;
	var pie_chart_data = [];
	var pie_chart_keys = [];
	var choose_request = this.chooseRequest;
	var chart_options;
	var selectedIndex = 0;

	try {
		chart_options = $.parseJSON(this.li.attr('data-chart-options'));
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
		if(this.selected == data.buckets[i].key)
			selectedIndex = i;
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
			text: this.li.data('label')
		},
		tooltip: {
			pointFormat: '<b>{point.y}</b>'
		},
		credits: {
			enabled: false
		},
		plotOptions: {
			series: {
				animation: false
			},
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
				'font-weight': 'normal',
				paddingBottom: '5px'
			}
			// itemWidth: 150
		};

	} else {

		options.legend = {
			useHTML: true,
			labelFormatter: function () {
				if(_this.isSelected && selectedIndex == this.index) {
					return '<a class="active" href="' + choose_request + '' + pie_chart_keys[this.index] + '">' + this.name + '</a>';
				} else {
					return '<a href="' + choose_request + '' + pie_chart_keys[this.index] + '">' + this.name + '</a>';
				}
			},
        	layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            margin: 30,
            y: 50,
			itemStyle: {
				'font-weight': 'normal',
				paddingBottom: '5px'
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

	if(this.allLabel.length > 0 && this.isSelected) {
		dropdownChart += [
			'<li class="cancel"><a href="' + this.cancelRequest + '">Usuń filtr</a></li>'
		].join('');
	}

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

	console.log('createList', this.aggs);

	var dropdownMenu = this.li.find('ul.dropdown-menu'),
		dropdownList = '';

	for(var i = 0; i < this.aggs.buckets.length; i++) {

		var label = this.aggs.buckets[i].key;

		if(
			this.aggs.buckets[i].hasOwnProperty('label') &&
			this.aggs.buckets[i].label.hasOwnProperty('buckets') &&
			this.aggs.buckets[i].label.buckets.length &&
			this.aggs.buckets[i].label.buckets[0].hasOwnProperty('key')
		)
			label = this.aggs.buckets[i].label.buckets[0].key;

		if(this.labelDictionary.hasOwnProperty(label))
			label = this.labelDictionary[label];

		var label_short = label.substring(0, 50);
		if( label_short.length < label.length )
			label_short += '...';

		dropdownList += [
			'<li' + (this.isSelected && this.selected == this.aggs.buckets[i].key ? ' class="active"' : '') + '>',
				'<a title="' + label + '" href="' + this.chooseRequest + this.aggs.buckets[i].key + '">',
					label_short + '<span class="badge pull-right">' + this.aggs.buckets[i].doc_count + '</span>',
				'</a>',
			'</li>'
		].join('');
	}

	if(this.allLabel.length > 0 && this.isSelected) {
		dropdownList += [
			'<li class="cancel"><a href="' + this.cancelRequest + '">Usuń filtr</a></li>'
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
