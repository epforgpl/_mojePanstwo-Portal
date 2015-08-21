String.prototype.capitalizeFirstLetter = function () {
	"use strict";
	return this.charAt(0).toUpperCase() + this.slice(1);
};

var BDLapp = function () {
	this.itemsInit = function () {
		var self = this,
			bdlWskazniki = jQuery('#bdl-wskazniki'),
			wskazniki = bdlWskazniki.find('.wskaznik');

		if (wskazniki.length) {
			wskazniki.each(function () {
				var el = $(this);

				el.find('h2>a').click(function (e) {
					var that = $(this),
						text = that.text().capitalizeFirstLetter(),
						href = that.attr('href');

					e.preventDefault();

					if (History.pushState !== undefined) {
						var obj = {Page: text, Url: href};
						History.pushState(obj, obj.Page, obj.Url);
					}

					if (!that.hasClass('subItemLoaded')) {
						that.addClass('subItemLoaded');
						self.subitemLoad(el);
					}
				});
			});
		}
	};

	this.subitemLoad = function (item) {
		var self = this;

		$.ajax({
			url: '/dane/bdl_wskazniki/' + item.attr('data-id') + '/kombinacje/' + item.attr('data-dim_id') + '.html',
			type: "GET",
			dataType: "html",
			beforeSend: function () {
				self.loading();

				item.find('.map').fadeOut(function () {
					item.find('.charts').attr('data-chart', chart.outerWidth()).animate({
						width: '100%'
					}, {
						duration: 600,
						step: function () {
							item.find('.chart').highcharts().reflow()
						}
					});
				});
			},
			complete: function (res) {
				var bdlDetail = item.find('.bdl-details'),
					html = res.responseText;

				if (bdlDetail.length)
					bdlDetail.replaceWith(html);
				else
					item.append(html);

				self.subitemInit();
				self.loaded();
			}
		});
	};
	this.subitemInit = function () {
		var bdlWskazniki = jQuery('#bdl-wskazniki'),
			wskazniki = bdlWskazniki.find('.wskaznik'),
			wskaznikiTable,
			geoType;

		if (typeof(local_data) == 'undefined' || local_data == undefined || local_data.length == 0)
			return false;

		geoType = local_data.length > 0 ? local_data.length > 16 ? local_data.length > 380 ? 'gminy' : 'powiaty' : 'wojewodztwa' : false;

		if (!geoType)
			return false;

		$.getJSON(mPHeart.constant.ajax.api + '/geo/geojson/get?quality=4&types=' + geoType, function (data) {
			var geo = Highcharts.geojson(data, 'map');
			var max = 0, min = 9999999999;
			for (var i = 0; i < geo.length; i++) {
				var found = false;
				for (var k = 0; k < local_data.length; k++) {
					if (geo[i].properties.id == local_data[k].local_id) {
						geo[i].value = parseFloat(local_data[k].lv);
						geo[i].id = 'o' + geo[i].properties.id;
						found = true;
						break;
					}
				}
				if (!found)
					geo[i].value = 0;

				if (geo[i].value > max)
					max = geo[i].value;

				if (geo[i].value < min)
					min = geo[i].value;
			}

			var type = 'linear';
			if (min == 0 && max == 0)
				max = 1;

			var highmap = $('#highmap');
			highmap.css('height', '85vh');

			highmap.highcharts('Map', {
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
					pointFormat: '{point.name}: {point.value} ' + (this.unit !== undefined ? this.unit : unitStr),
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
						//allowPointSelect: true,
						point: {
							events: {
								mouseOver: function () {
									this.graphic.toFront();
								},
								mouseOut: function () {

								},
								select: function () {
									this.graphic.toFront();
								},
								click: function () {
									var index = this.index + 1;
									$('tr.wskaznikStatic').each(function () {
										var _this = $(this);
										var _index = $(this).attr('data-local_id');
										if (_index == index) {
											$('html, body').animate({
												scrollTop: _this.offset().top
											}, 1000);
											if (!_this.hasClass('clicked'))
												_this.click();
											return true;
										}

										_this
											.removeClass('clicked')
											.find('.wskaznikChart')
											.hide();
									});
								}
							}
						},
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
					borderColor: '#777'
				}]
			});

			$('tr.wskaznikStatic')
				.on("mouseenter", function () {
					var id = parseInt($(this).attr('data-local_id'));
					highmap
						.highcharts()
						.get('o' + id)
						.select();
				})
				.on("mouseleave", function () {
					var id = parseInt($(this).attr('data-local_id'));
					highmap
						.highcharts()
						.get('o' + id)
						.select(false);
				})
				.on("click", function () {
					var wskaznik = $(this),
						wskaznikwidth = $(this).outerWidth(),
						wskaznikData = wskaznik.data(),
						wskaznikChart = wskaznik.find('.wskaznikChart');

					if (wskaznik.hasClass('clicked')) {
						wskaznikChart.hide();
						wskaznik.removeClass('clicked');
						return false;
					}

					wskaznikChart.css({'width': wskaznikwidth});

					$.ajax({
						url: '/dane/bdl_wskazniki/local_chart_data_for_dimmensions.json?dims=' + wskaznikData.dim_id + '&localtype=' + wskaznikData.local_type + '&localid=' + wskaznikData.local_id,
						type: "POST",
						dataType: "json",
						beforeSend: function () {
							wskaznikChart.slideDown();
							wskaznikChart.find('.chart .progress-bar').attr('aria-valuenow', '45').css('width', '45%');
						},
						always: function () {
							wskazniki.find('.chart .progress-bar').attr('aria-valuenow', '80').css('width', '80%');
						},
						complete: function (res) {
							var data = res.responseJSON.data;

							var chart = data,
								label = [],
								value = [];

							$.each(chart, function () {
								label.push(this.y);
								value.push(Number(this.v));
							});

							wskaznikChart.highcharts({
								title: {
									text: ''
								},
								chart: {
									height: 150
								},
								credits: {
									enabled: false
								},
								xAxis: {
									categories: label
								},
								yAxis: {
									title: ''
								},
								tooltip: {
									valueSuffix: ''
								},
								legend: {
									enabled: false,
									align: 'left'
								},
								series: [
									{
										name: unitStr,
										data: value
									}
								]
							});
						}
					});

					wskaznik.addClass('clicked');
				});

			wskaznikiTable = bdlWskazniki.find('.localDataTable tbody');

			$('.localDataSearch input').keyup(function () {
				var input = $(this).val();

				if (input != '') {
					wskaznikiTable.find('tr').hide();
					wskaznikiTable.find('td:contains(' + input + ')').parent().show();
					wskaznikiTable.find('[data-ay-sort-weight*="' + input + '"]').parent().show();
				} else {
					wskaznikiTable.find('tr:hidden').show();
				}
			});

			$('.localDataSearch .btn').click(function (e) {
				e.preventDefault();
				$('.localDataSearch input').val('');
				wskaznikiTable.find('tr:hidden').show();
			});

		});

		$('.bdl-select select').selectpicker();
	};

	this.loading = function () {
		var main = $('#_main'),
			w = main.find('.objectsPage').width();

		if (main.find('.curtain').length == 0) {
			main.append(
				$('<div></div>').addClass('curtain loading').css({
					'background-color': 'rgba(255, 255, 255, .7)',
					'background-position': Math.floor(w / 2) + 'px 50%',
					'width': w,
					'height': '100%',
					'display': 'block',
					'left': '85px',
					'position': 'fixed',
					'top': 0,
					'z-index': 2

				})
			);

			$('.wskaznik').each(function () {
				var wsk = $(this);

				if (wsk.find('.bdl-details').length) {
					wsk.find('.bdl-details').slideUp("fast", function () {
						$(wsk).remove()
					});
					wsk.find('.map').fadeOut(function () {
						var chart = wsk.find('.charts');

						chart.animate({
							width: chart.attr('data-chart')
						}, {
							duration: 600,
							step: function () {
								chart.highcharts().reflow()
							},
							complete: function () {
								wsk.find('.map').fadeIn();

							}
						});
					});
				}
			});
		}
	};

	this.loaded = function () {
		$('#_main').find('.curtain').remove();
	};

	this.itemsInit();
};

(function ($) {
	var _bdl_app = new BDLapp();
}(jQuery));
