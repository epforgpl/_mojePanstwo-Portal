/*global $, Class, window, document, mPHeart, Highcharts*/
var DataBrowser = Class.extend({
	aggsDiv: false,

	init: function (div) {
		this.div = $(div);

		$('.goto .selectpicker').selectpicker('val', null).on('change', function () {
			var href = $(this).find("option:selected").attr('href');
			window.location = href;
		});

		this.initAggs();

		if (this.div.hasClass('manage')) {
			this.initManage();
		}
	},

	initManage: function () {
		var that = this;

		this.div.find('.manage-checkbox').prop('checked', false).change(function (event) {
			that.manageUpdateDisplay();
		});
	},

	manageUpdateDisplay: function () {
		var inputs_html = '',
			cbx = this.div.find('.manage-checkbox:checked');

		this.div.find('.manage-display .inputs').html('');

		if (cbx.length) {
			for (var i = 0; i < cbx.length; i++) {
				var obj = $(cbx[i]).parents('.objectRender');

				if (obj.length) {
					obj = $(obj[0]);
					inputs_html += '<input type="hidden" name="id[]" value="' + obj.attr('gid') + '" />';
				}
			}

			this.div.find('.manage-display .inputs').html(inputs_html);

			var txt = cbx.length + ' zaznaczonych pism';
			this.div.find('.manage-display .display').text(txt);

			this.div.find('.manage-display').show();
			this.div.find('.manage-display').sticky({topSpacing: 44});
			this.div.find('.dataAggsDropdownList.nav').hide();
		} else {
			this.div.find('.manage-display').hide();
			this.div.find('.manage-display').unstick();
			this.div.find('.dataAggsDropdownList.nav').show();
		}
	},

	initAggs: function () {
		this.aggsDiv = this.div.find('.dataAggsContainer .dataAggs');

		if (this.aggsDiv.length) {
			this.aggsDiv.fadeTo('slow', 1);
		}

		var lis = this.div.find('.dataAggs .agg');

		for (var i = 0; i < lis.length; i++) {
			var li = $(lis[i]);

			if (li.hasClass('agg-PieChart')) {
				this.initAggPieChart(li);
			} else if (li.hasClass('agg-DateHistogram')) {
				this.initAggDateHistogram(li);
			} else if (li.hasClass('agg-ColumnsHorizontal')) {
				this.initAggColumnsHorizontal(li);
			} else if (li.hasClass('agg-ColumnsVertical')) {
				this.initAggColumnsVertical(li);
			} else if (li.hasClass('agg-GeoPL')) {
				this.initAggGeoPL(li);
			}
		}
	},

	initAggGeoPL: function (li) {
		li = $(li);

		var data = $.parseJSON(li.attr('data-chart'));
		var geo_keys = [];
		var choose_request = li.attr('data-choose-request');
		var chart_options;

		try {
			chart_options = $.parseJSON(li.attr('data-chart-options'));
		} catch (err) {
			chart_options = false;
		}

		var geoType = chart_options.unit;

		$.getJSON(mPHeart.constant.ajax.api + '/geo/geojson/get?quality=4&types=' + geoType, function (res) {
			var geo = Highcharts.geojson(res, 'map'),
				max = 0,
				min = 9999999999;
			for (var i = 0; i < geo.length; i++) {
				var found = false;
				for (var k = 0; k < data.buckets.length; k++) {
					if (geo[i].properties.id === data.buckets[k].key) {
						geo[i].value = parseInt(data.buckets[k].doc_count);
						geo[i].id = 'o' + geo[i].properties.id;
						found = true;
						break;
					}
				}
				if (!found) {
					geo[i].value = 0;
				}
				if (geo[i].value > max) {
					max = geo[i].value;
				}
				if (geo[i].value < min) {
					min = geo[i].value;
				}
				geo_keys[i] = geo[i].properties.id;
			}

			var type = 'linear';
			if (min === 0 && max === 0) {
				max = 1;
			}

			var options = {
				title: {
					text: ' '
				},
				chart: {
					backgroundColor: null
				},
				mapNavigation: {
					enabled: true,
					enableMouseWheelZoom: false,
					buttonOptions: {
						verticalAlign: 'bottom'
					}
				},
				credits: {
					enabled: false
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: '{point.name}: {point.value}',
					headerFormat: ''
				},
				colorAxis: {
					minColor: '#ffffff',
					maxColor: '#006df0',
					min: min,
					max: max,
					type: type
				},
				plotOptions: {
					series: {
						states: {
							select: {
								borderColor: '#014068',
								borderWidth: 1
							},
							hover: {
								borderColor: '#014068',
								borderWidth: 1,
								brightness: false,
								color: false
							}
						}
					}
				},
				series: [{
					data: geo,
					nullColor: '#ffffff',
					borderWidth: 1,
					borderColor: '#777',
					point: {
						events: {
							click: function (e) {
								window.location.href = choose_request + '' + geo_keys[this.index];
								return false;
							}
						}
					}
				}]
			};

			li.find('.chart').highcharts('Map', options);
		});
	},

	initAggPieChart: function (li) {
		li = $(li);
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
						click: function () {
							window.location.href = choose_request + '' + pie_chart_keys[this.index];
							return false;
						}
					}
				}
			}]
		};

		if (chart_options.mode === 'init') {
			options.legend = {
				useHTML: true,
				labelFormatter: function () {
					var name = this.name;
					if (name.length > 32) {
						name = name.substring(0, 35) + '...';
					}

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
			};

		} else {
			options.legend = {
				useHTML: true,
				labelFormatter: function () {
					var name = this.name;
					if (name.length > 18) {
						name = name.substring(0, 15) + '...';
					}
					return '<a href="' + choose_request + '' + pie_chart_keys[this.index] + '">' + name + '</a>';
				},
				itemWidth: 150,
				itemStyle: {
					'font-weight': 'normal'
				}
			};

		}
		li.find('.chart').highcharts(options);
	},

	getFormattedDate: function (date) {
		var year = date.getFullYear(),
			month = (date.getMonth() + 1).toString(),
			day = date.getDate().toString();
		month = (month.length === 2) ? month : '0' + month;
		day = (day.length === 2) ? day : '0' + day;

		return year + '-' + month + '-' + day;
	},

	initAggDateHistogram: function (li) {
		li = $(li);
		var data = $.parseJSON(li.attr('data-chart'));
		var histogram_keys = [];
		var choose_request = li.attr('data-choose-request');
		var histogram_data = [];
		var _this = this;
		var max = 0;

		var dateRange = {
			min: 9000000000000,
			max: 0
		};

		for (var i = 0; i < data.buckets.length; i++) {
			var date = data.buckets[i].key_as_string.split("-");

			var utc = Date.UTC(parseInt(date[0]), parseInt(date[1]) - 1, parseInt(date[2]));
			if (utc < dateRange.min) {
				dateRange.min = utc;
			}
			if (utc > dateRange.max) {
				dateRange.max = utc;
			}

			histogram_data[i] = [
				Date.UTC(parseInt(date[0]), parseInt(date[1]) - 1, parseInt(date[2])),
				parseInt(data.buckets[i].doc_count)
			];

			histogram_keys[i] = data.buckets[i].key_as_string;

			if (max < histogram_data[i][1]) {
				max = histogram_data[i][1];
			}
		}

		li.find('.chart').highcharts({
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

		try {
			var datepicker = $.fn.datepicker.noConflict();
			$.fn.bootstrapDP = datepicker;

			li.find('a.select-date-range').first().click(function () {
				var _datepicker = $('#datepicker');
				var _start = _datepicker.find('input[name=start]').first();
				var _end = _datepicker.find('input[name=end]').first();
				var _submit = $('#selectDateSubmit');
				var _startDate = _this.getFormattedDate(new Date(dateRange.min));
				var _endDate = _this.getFormattedDate(new Date(dateRange.max));

				_start.val(_startDate);
				_end.val(_endDate);

				_datepicker.bootstrapDP({
					language: 'pl',
					orientation: 'auto top',
					format: "yyyy-mm-dd",
					autoclose: true
				});

				_submit.click(function () {
					var dataArg = [
						'[',
						_start.val(),
						' TO ',
						_end.val(),
						']'
					];

					window.location.href = choose_request + dataArg.join('');
					return false;
				});

			});

		}
		catch (err) {
		}
	},

	initAggColumnsVertical: function (li) {
		li = $(li);
		var data = $.parseJSON(li.attr('data-chart'));

		var columns_vertical_data = [];
		var columns_vertical_categories = [];
		var columns_vertical_keys = [];
		var choose_request = li.attr('data-choose-request');

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

		li.find('.chart').highcharts({
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
							var index = e.point.index,
								bucket = data.buckets[index],
								dataArg = ['[', bucket.from];

							dataArg.push(' TO ');
							if (bucket.to) {
								dataArg.push(bucket.to);
							}
							dataArg.push(']');

							window.location.href = choose_request + dataArg.join('');
							return false;
						}
					}
				}
			}]
		});

	},

	initAggColumnsHorizontal: function (li) {
		li = $(li);
		var data = $.parseJSON(li.attr('data-chart'));
		var choose_request = li.attr('data-choose-request');
		var labelWidth = 150;

		if (li.attr('data-label-width')) {
			labelWidth = parseInt(li.attr('data-label-width'));
		}

		var counter_field = li.attr('data-counter_field');
		if (!counter_field) {
			counter_field = 'doc_count';
		}

		var label_field = li.attr('data-label_field');
		if (!label_field) {
			label_field = 'label';
		}

		var image_field = li.attr('data-image_field');

		var escape_html_label = li.attr('data-escape-html') === '1';

		var columns_horizontal_data = [];
		var columns_horizontal_categories = [];
		var columns_horizontal_keys = [];
		var columns_horizontal_images = {};

		for (var i = 0; i < data.buckets.length; i++) {

			if (data.buckets[i][label_field].buckets.length === 0) {
				continue;
			}

			columns_horizontal_categories[i] = {
				name: data.buckets[i][label_field].buckets[0].key,
				id: data.buckets[i].key
			};

			if (escape_html_label) {
				columns_horizontal_categories[i]['name'] = columns_horizontal_categories[i]['name'].replace(/<(?:.|\n)*?>/gm, '');
			}

			columns_horizontal_data[i] = (data.buckets[i].label ? data.buckets[i].label.buckets[0][counter_field] : false) || data.buckets[i][counter_field]['value'] || data.buckets[i][counter_field];
			columns_horizontal_keys[i] = data.buckets[i].key;
			if (image_field && typeof data.buckets[i][image_field].buckets[0] !== 'undefined') {
				columns_horizontal_images[columns_horizontal_categories[i].name] = data.buckets[i][image_field].buckets[0].key;
			}
		}

		var tooltip = {
			valueSuffix: ' ',
			positioner: function () {
				return {x: this.now.anchorX, y: this.now.anchorY - 20};
			},
			style: {
				zIndex: 9
			},
			headerFormat: '<span style="font-size: 10px">{point.key.name}</span><br/>'
		};

		var _this = this;

		var labelsStyle = {
			width: labelWidth + 'px',
			'min-width': labelWidth + 'px'
		};

		var chart = {
			type: 'bar',
			spacingRight: 60,
			backgroundColor: null,
			events: {
				load: function () {
					var chart = this,
						legend = this.series[0].chart.axes[0].labelGroup.element;

					for (var i = 0, len = legend.childNodes.length; i < len; i++) {
						var item = legend.childNodes[i];
						item.onmouseover = function (e) {
							chart.series[0].points[i].onMouseOver();
						};

						item.onclick = function (e) {
							$(chart.series[0].points[i].graphic.element).click();
						}
					}
				}
			}
		};

		li.find('.chart').highcharts({
			chart: chart,
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
						var el = this.value,
							v = el.name;

						if (v.length > (((labelWidth / 10) * 2) - 2)) {
							v = v.substring(0, ((labelWidth / 10) * 2) - 5) + '...';
						}

						if (image_field) {
							return [
								'<a href="' + choose_request + el.id + '" target="_self">',
								'<div class="text-center" style="line-height: 1em">',
								columns_horizontal_images.hasOwnProperty(el.name) ? '<img style="margin-bottom: 5px; margin-right: 5px; float: left; max-width: 30px;" src="' + columns_horizontal_images[el.name] + '"/><br/>' : '<div style="width: 30px; height: 30px; margin-bottom: 5px; margin-right: 5px; float: left;"></div><br/>',
								v,
								'</div>',
								'</a>'
							].join('');
						}

						return '<a href="' + choose_request + el.id + '" target="_self">' + v + '</a>';
					},
					style: labelsStyle,
					useHTML: true
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
				},
				series: {
					pointWidth: 15
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
							window.location.href = choose_request + columns_horizontal_keys[this.index];
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

	},

	getAsPLNumber: function (s) {
		var num = Math.round(s);

		if (num >= 1000000) {
			return (Math.round(num / 100000, 2) / 10) + 'M';
		} else if (num >= 1000) {
			return (Math.round(num / 100, 2) / 10) + 'k';
		}

		return num;
	},

	scienNotationToNum: function (str) {
		var number = str[0];
		for (var i = 0; i <= parseInt(str[str.length - 1]); i++) {
			number += '0';
		}
		return number;
	},

	prepareNumeric: function (str) {
		var number = str[0];
		if (str.indexOf('E') > -1) {
			str = this.scienNotationToNum(str);
		}
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

		for (var i = 0; i < addZeros; i++) {
			newStr += '0';
		}

		newStr += unit;

		return newStr;
	},

	prepareNumericLabel: function (str) {
		if (str.indexOf('-') === -1) {
			return this.prepareNumeric(str);
		} else {
			var s = str.split('-');
			return this.prepareNumeric(s[0]) + '-' + this.prepareNumeric(s[1]);
		}
	}

});


var dataBrowser;

$(document).ready(function () {
	window.DataBrowsers = [];
	var elements = $('.dataBrowser');
	for (var i = 0; i < elements.length; i++) {
		dataBrowser = new DataBrowser(elements[i]);
		window.DataBrowsers.push(dataBrowser);
	}

	$('form.searchForm').submit(function () {
		var value = $(this).find('input').val(),
			data_url = $(this).attr('data-url'),
			c = data_url.indexOf('?') === -1 ? '?' : '&';

		if (value === '') {
			return false;
		}
		window.location.href = $(this).attr('data-url') + c + 'q=' + value;
		return false;
	});
	var $dropdownToggleManual = $('.dropdown-toggle-manual');
	if ($dropdownToggleManual.length) {
		$dropdownToggleManual.each(function () {
			var dTM = $(this);
			dTM.click(function () {
				var sub = dTM.parent().find('.dropdown-menu');
				if (sub.hasClass('open')) {
					sub.removeClass('open').hide();
				} else {
					sub.addClass('open').show();
				}
			});
		});
	}
});
