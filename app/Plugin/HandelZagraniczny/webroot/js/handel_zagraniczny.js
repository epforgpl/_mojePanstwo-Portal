/*global $,jQuery,mPHeart,Highcharts,pl_currency_format,number_format*/
$(function () {
	'use strict';

	var hz_map = $('#hzMap'),
		apiHost = mPHeart.constant.ajax.api,
		hz_api = mPHeart.constant.ajax.api + '/handel_zagraniczny/stats/',
		hz_type = 'import',
		hz_countries_data = [],
		hz_top_symbols_data = [],
		hz_year = 2014,
		hz_type_last,
		hz_year_last,
		hz_map_data;

	String.prototype.capitalize = function () {
		return this.charAt(0).toUpperCase() + this.slice(1);
	};

	function max_eksport(countries) {
		var max = parseInt(countries[0].eksport, 0),
			i;

		for (i = 0; i < countries.length; i++) {
			if (parseInt(countries[i].eksport, 0) > max) {
				max = parseInt(countries[i].eksport, 0);
			}
		}

		return max;
	}

	function max_import(countries) {
		var max = parseInt(countries[0].import, 0),
			i;

		for (i = 0; i < countries.length; i++) {
			if (parseInt(countries[i].import, 0) > max) {
				max = parseInt(countries[i].import, 0);
			}
		}

		return max;
	}

	function short(s, len) {
		var ret;
		if (s.length > len) {
			ret = s.substr(0, len) + '..';
		} else {
			ret = s;
		}

		return ret;
	}

	var hz_getCountriesData = function (year, doneFunction) {
		if (hz_countries_data[year] === undefined) {
			$.getJSON(hz_api + 'getCountriesData.json?year=' + year, function (d) {
				hz_countries_data[year] = d;
				doneFunction(d);
			});
		} else {
			doneFunction(hz_countries_data[year]);
		}
	};

	var more = {
		countries_import: [],
		countries_export: [],
		symbols_import: [],
		symbols_export: [],

		update: function (element_type, type) {
			var moreList = $('#more #list'),
				i, c;

			switch (element_type) {
				case 'symbols':
					switch (type) {
						case 'export':
							moreList.html('');
							for (i = 0; i < this.symbols_export[hz_year].length; i++) {
								c = this.symbols_export[hz_year][i];
								moreList.append(
									'<li class="list-group-item"><span class="badge">' + pl_currency_format(c.wartosc_pln) + '</span><a href="/dane/handel_zagraniczny_towary/' + c.id + '?y=' + hz_year + '">' + c.nazwa + '</a></li>'
								);
							}
							break;

						default: // import
							moreList.html('');
							for (i = 0; i < this.symbols_import[hz_year].length; i++) {
								c = this.symbols_import[hz_year][i];
								moreList.append(
									'<li class="list-group-item"><span class="badge">' + pl_currency_format(c.wartosc_pln) + '</span><a href="/dane/handel_zagraniczny_towary/' + c.id + '?y=' + hz_year + '">' + c.nazwa + '</a></li>'
								);
							}
							break;
					}
					break;
				default: // countries
					switch (type) {
						case 'export':
							moreList.html('');
							for (i = 0; i < this.countries_export[hz_year].length; i++) {
								c = this.countries_export[hz_year][i];
								moreList.append(
									'<li class="list-group-item"><span class="badge">' + pl_currency_format(c.eksport) + '</span><img src="/img/flags/' + c.code + '.png" onerror="if (this.src != \'/img/flags/_unknown.png\') this.src = \'/img/flags/_unknown.png\';"/> <a href="/dane/panstwa/' + c.id + '?y=' + hz_year + '">' + c.kraj + '</a></li>'
								);
							}
							break;

						default: // import
							moreList.html('');
							for (i = 0; i < this.countries_import[hz_year].length; i++) {
								c = this.countries_import[hz_year][i];
								moreList.append(
									'<li class="list-group-item"><span class="badge">' + pl_currency_format(c.import) + '</span><img src="/img/flags/' + c.code + '.png" onerror="if (this.src != \'/img/flags/_unknown.png\') this.src = \'/img/flags/_unknown.png\';"/> <a href="/dane/panstwa/' + c.id + '?y=' + hz_year + '">' + c.kraj + '</a></li>'
								);
							}
							break;
					}
					break;
			}
		},

		open: function (element_type, type) {
			var t = this,
				moreEl = $('#more');

			moreEl.html('');
			switch (element_type) {
				case 'symbols':
					switch (type) {
						case 'export':
							$('#more').append('<a class="close" href="#close">x</a><h1>Eksport</h1><h2>Towary których Polska eksportowała najwięcej w ' + hz_year + ' roku</h2><ul class="list-group" id="list"></ul>');
							if (this.symbols_export[hz_year] === undefined) {
								this.get(hz_year, 'export', function (data) {
									t.symbols_export[hz_year] = data;
									t.update('symbols', 'export');
								});
							} else {
								t.update('symbols', 'export');
							}
							$('#more a.close').click(function () {
								t.close();
							});
							break;

						default: // import
							$('#more').append('<a class="close" href="#close">x</a><h1>Import</h1><h2>Towary których Polska eksportowała najwięcej w ' + hz_year + ' roku</h2><ul class="list-group" id="list"></ul>');
							if (this.symbols_import[hz_year] === undefined) {
								this.get(hz_year, 'import', function (data) {
									t.symbols_import[hz_year] = data;
									t.update('symbols', 'import');
								});
							} else {
								t.update('symbols', 'import');
							}
							$('#more a.close').click(function () {
								t.close();
							});
							break;
					}
					break;

				default: // countries
					switch (type) {
						case 'export':
							moreEl.append('<a class="close" href="#close">x</a><h1>Eksport</h1><h2>Państwa do których Polska eksportowała najwięcej w ' + hz_year + ' roku</h2><ul class="list-group" id="list"></ul>');
							if (this.countries_export[hz_year] === undefined) {
								this.getCountries(hz_year, 'export', function (data) {
									t.countries_export[hz_year] = data;
									t.update('countries', 'export');
								});
							} else {
								t.update('countries', 'export');
							}
							moreEl.find('a.close').click(function () {
								t.close();
							});
							break;

						default: // import
							moreEl.append('<a class="close" href="#close">x</a><h1>Import</h1><h2>Państwa od których Polska importowała najwięcej w ' + hz_year + ' roku</h2><ul class="list-group" id="list"></ul>');
							if (this.countries_import[hz_year] === undefined) {
								this.getCountries(hz_year, 'import', function (data) {
									t.countries_import[hz_year] = data;
									t.update('countries', 'import');
								});
							} else {
								t.update('countries', 'import');
							}
							moreEl.find('a.close').click(function () {
								t.close();
							});
							break;
					}
					break;
			}

			$('#morebg').show();
			moreEl.show();
		},

		close: function () {
			$('#morebg').hide();
			$('#more').hide();
		},

		get: function (year, type, done_function) {
			$.getJSON(
				apiHost + 'handel_zagraniczny/stats/getSymbols.json' +
				'?parent_id=0' +
				'&year=' + year +
				'&type=' + type +
				'&limit=9999',
				done_function
			);
		},

		getCountries: function (year, type, done_function) {
			var _countries,
				l, i, c,
				c_import_max_i,
				c_eksport_max_i,
				is,
				max_i;

			switch (type) {
				case 'export':
					_countries = [];
					hz_getCountriesData(hz_year, function (countries) {
						c_eksport_max_i = [];
						is = false;
						for (l = 0; l < countries.length; l++) {
							max_i = 0;
							for (i = 0; i < countries.length; i++) {
								is = false;
								for (c = 0; c < c_eksport_max_i.length; c++) {
									if (i === c_eksport_max_i[c]) {
										is = true;
										break;
									}
								}
								if (!is && parseInt(countries[max_i].eksport, 0) < parseInt(countries[i].eksport, 0)) {
									max_i = i;
								}
							}
							c_eksport_max_i.push(max_i);
						}

						for (i = 0; i < c_eksport_max_i.length; i++) {
							if (c_eksport_max_i[i] === 0) {
								continue;
							}

							c = countries[c_eksport_max_i[i]];
							_countries.push(c);
						}

						done_function(_countries);
					});
					break;

				default:// import
					_countries = [];
					hz_getCountriesData(hz_year, function (countries) {
						c_import_max_i = [];
						is = false;
						for (l = 0; l < countries.length; l++) {
							max_i = 0;
							for (i = 0; i < countries.length; i++) {
								is = false;
								for (c = 0; c < c_import_max_i.length; c++) {
									if (i === c_import_max_i[c]) {
										is = true;
										break;
									}
								}
								if (!is && parseInt(countries[max_i].import, 0) < parseInt(countries[i].import, 0)) {
									max_i = i;
								}
							}
							c_import_max_i.push(max_i);
						}

						for (i = 0; i < c_import_max_i.length; i++) {
							if (c_import_max_i[i] === 0) {
								continue;
							}
							c = countries[c_import_max_i[i]];
							_countries.push(c);
						}

						done_function(_countries);
					});
					break;
			}
		}
	};

	var hz_getTopSymbolsData = function (year, doneFunction) {
		if (hz_top_symbols_data[year] === undefined) {
			$.getJSON(hz_api + 'getTopSymbolsData.json?year=' + year, function (d) {
				hz_top_symbols_data[year] = d;
				doneFunction(d);
			});
		} else {
			doneFunction(hz_top_symbols_data[year]);
		}
	};

	var hz_updateCountriesDetails = function (countries) {
		var limit = 5,
			c_import_max_i = [],
			c_eksport_max_i = [],
			is = false,
			l, i, c,
			max_i,
			hzImportCountries = $('#hzImportCountries');

		$('span.hzYearAttr').each(function () {
			$(this).html(hz_year);
		});


		for (l = 0; l < limit; l++) {
			max_i = 0;
			for (i = 0; i < countries.length; i++) {
				is = false;
				for (c = 0; c < c_import_max_i.length; c++) {
					if (i === c_import_max_i[c]) {
						is = true;
						break;
					}
				}
				if (!is && parseInt(countries[max_i].import, 0) < parseInt(countries[i].import, 0)) {
					max_i = i;
				}
			}
			c_import_max_i.push(max_i);
		}

		hzImportCountries.html('');
		for (i = 0; i < c_import_max_i.length; i++) {
			c = countries[c_import_max_i[i]];
			$('#hzImportCountries').append('<li class="list-group-item"><span class="badge">' + pl_currency_format(c.import) + '</span><img src="/img/flags/' + c.code + '.png"/> <a href="/dane/panstwa/' + c.id + '?y=' + hz_year + '">' + c.kraj + '</a></li>');
		}

		hzImportCountries.append('<li class="list-group-item text-center"><a class="more" href="#more">więcej</a></li>');

		hzImportCountries.find('a.more').click(function () {
			more.open('countries', 'import');
		});

		for (l = 0; l < limit; l++) {
			max_i = 0;
			for (i = 0; i < countries.length; i++) {
				is = false;
				for (c = 0; c < c_eksport_max_i.length; c++) {
					if (i === c_eksport_max_i[c]) {
						is = true;
						break;
					}
				}
				if (!is && parseInt(countries[max_i].eksport, 0) < parseInt(countries[i].eksport, 0)) {
					max_i = i;
				}
			}
			c_eksport_max_i.push(max_i);
		}

		$('#hzExportCountries').html('');
		for (i = 0; i < c_eksport_max_i.length; i++) {
			c = countries[c_eksport_max_i[i]];
			$('#hzExportCountries').append('<li class="list-group-item"><span class="badge">' + pl_currency_format(c.eksport) + '</span><img src="/img/flags/' + c.code + '.png"/> <a href="/dane/panstwa/' + c.id + '?y=' + hz_year + '">' + c.kraj + '</a></li>');
		}

		$('#hzExportCountries').append('<li class="list-group-item text-center"><a class="more" href="#more">więcej</a></li>');

		$('#hzExportCountries a.more').click(function () {
			more.open('countries', 'export');
		});
	};

	var hz_updateTopSymbolsDetails = function (symbols) {
		var hzImportSymbols = $('#hzImportSymbols'),
			i, s;

		hzImportSymbols.html('');
		for (i = 0; i < symbols.import.length; i++) {
			s = symbols.import[i];
			hzImportSymbols.append('<li class="list-group-item"><span class="badge">' + pl_currency_format(s.wartosc_pln) + '</span><a href="/dane/handel_zagraniczny_towary/' + s.id + '?y=' + hz_year + '">' + s.nazwa.trim() + '</a></li>');
		}

		hzImportSymbols.append('<li class="list-group-item text-center"><a class="more" href="#more">więcej</a></li>');

		hzImportSymbols.find('a.more').click(function () {
			more.open('symbols', 'import');
		});

		hzImportSymbols.html('');
		for (i = 0; i < symbols.export.length; i++) {
			s = symbols.export[i];
			hzImportSymbols.append('<li class="list-group-item"><span class="badge">' + pl_currency_format(s.wartosc_pln) + '</span><a href="/dane/handel_zagraniczny_towary/' + s.id + '?y=' + hz_year + '">' + s.nazwa.trim() + '</a></li>');
		}

		hzImportSymbols.append('<li class="list-group-item text-center"><a class="more" href="#more">więcej</a></li>');

		hzImportSymbols.find('a.more').click(function () {
			more.open('symbols', 'export');
		});
	};

	var hz_createHighChart = function () {
		if ((hz_type_last === hz_type && hz_year_last === hz_year) || !hz_map_data) {
			return false;
		}

		hz_getTopSymbolsData(hz_year, function (symbolsData) {
			hz_updateTopSymbolsDetails(symbolsData);
		});

		hz_getCountriesData(hz_year, function (countriesData) {
			var i;

			hz_updateCountriesDetails(countriesData);

			var hz_data = [];
			var hz_colors = false;
			var hz_colorAxis = {};
			var hz_tooltip = {};

			switch (hz_type) {
				case 'bilans':
					hz_colorAxis = false;
					hz_tooltip = {
						backgroundColor: 'none',
						borderWidth: 0,
						shadow: false,
						useHTML: true,
						padding: 0,
						headerFormat: '',
						pointFormat: '<h3>{point.nazwa}</h3><table><tr><th><b>Import:</b> {point.import} zł</th><th><b>Eksport:</b> {point.eksport} zł</th></tr>{point.symbole.wartosc_pln}</table>',
						formatter: function () {
							var h = '',
								import_nazwa,
								eksport_nazwa;

							h += '<img class="hzFlagIcon" src="/img/flags/' + this.point.code + '.png" alt="' + this.point.nazwa + '"/>';
							h += '<h3>' + this.point.nazwa + '</h3>';
							h += '<table><tr><th>Import: <b>' + this.point.import + ' zł</b></th><th>Eksport: <b>' + this.point.eksport + ' zł</b></th></tr>';
							for (i = 0; i < this.point.symbole.import.length; i++) {
								import_nazwa = short(this.point.symbole.import[i].nazwa, 30).capitalize();
								eksport_nazwa = short(this.point.symbole.eksport[i].nazwa, 30).capitalize();

								h += '<tr>';
								h += '<td><div>' + (i + 1) + '. ' + import_nazwa + ' <b>(' + number_format(this.point.symbole.import[i].wartosc_pln) + ' zł)</b></div></td>';
								h += '<td><div>' + (i + 1) + '. ' + eksport_nazwa + ' <b>(' + number_format(this.point.symbole.eksport[i].wartosc_pln) + ' zł)</b></div></td>';
								h += '</tr>';
							}
							h += '</table>';
							h += '<p class="more">Kliknij na państwo aby zobaczyć więcej informacji.</p>';
							return h;
						}
					};
					break;

				case 'import':
					hz_colorAxis = {
						min: 1,
						max: 100,
						minColor: '#ffffff',
						maxColor: '#006df0',
						type: 'logarithmic'
					};

					hz_tooltip = {
						useHTML: true,
						headerFormat: '',
						pointFormat: '',
						formatter: function () {
							var h = '';
							h += '<div>';
							h += '<img class="hzFlagIcon" src="/img/flags/' + this.point.code + '.png" alt="' + this.point.nazwa + '"/>';
							h += ' ' + this.point.nazwa;
							h += '</div>';
							h += '<ul>';
							h += '<li>Import: <b>' + this.point.import + ' zł</b></li>';
							h += '<li>Eksport: <b>' + this.point.eksport + ' zł</b></li>';
							h += '<li>Bilans: <b style="color: ' + this.point.c + ';">' + this.point.bilans + ' zł</b></li>';
							h += '<li>Wymiana: <b>' + this.point.wymiana + ' zł</b></li>';
							h += '</ul>';
							return h;
						}
					};
					break;

				case 'eksport':
					hz_colorAxis = {
						min: 1,
						max: 100,
						minColor: '#ffffff',
						maxColor: '#006df0',
						type: 'logarithmic'
					};

					hz_tooltip = {
						useHTML: true,
						headerFormat: '',
						pointFormat: '',
						formatter: function () {
							var h = '';
							h += '<div>';
							h += '<img class="hzFlagIcon" src="/img/flags/' + this.point.code + '.png" alt="' + this.point.nazwa + '"/>';
							h += ' ' + this.point.nazwa;
							h += '</div>';
							h += '<ul>';
							h += '<li>Import: <b>' + this.point.import + ' zł</b></li>';
							h += '<li>Eksport: <b>' + this.point.eksport + ' zł</b></li>';
							h += '<li>Bilans: <b style="color: ' + this.point.c + ';">' + this.point.bilans + ' zł</b></li>';
							h += '<li>Wymiana: <b>' + this.point.wymiana + ' zł</b></li>';
							h += '</ul>';
							return h;
						}
					};
					break;

				case 'wymiana':
					hz_colorAxis = {
						min: 1,
						max: 100,
						minColor: '#ffffff',
						maxColor: '#006df0',
						type: 'logarithmic'
					};

					hz_tooltip = {
						useHTML: true,
						headerFormat: '',
						pointFormat: '',
						formatter: function () {
							var h = '';
							h += '<div>';
							h += '<img class="hzFlagIcon" src="/img/flags/' + this.point.code + '.png" alt="' + this.point.nazwa + '"/>';
							h += ' ' + this.point.nazwa;
							h += '</div>';
							h += '<ul>';
							h += '<li>Import: <b>' + this.point.import + ' zł</b></li>';
							h += '<li>Eksport: <b>' + this.point.eksport + ' zł</b></li>';
							h += '<li>Bilans: <b style="color: ' + this.point.c + ';">' + this.point.bilans + ' zł</b></li>';
							h += '<li>Wymiana: <b>' + this.point.wymiana + ' zł</b></li>';
							h += '</ul>';
							return h;
						}
					};
					break;
			}
			var cd_max_import = max_import(countriesData);
			var cd_max_eksport = max_eksport(countriesData);

			$.each(countriesData, function () {
				var cd_import = parseInt(this.import, 0),
					cd_eksport = parseInt(this.eksport, 0),
					cd_char;

				switch (hz_type) {
					case 'bilans':
						cd_char = (cd_eksport >= cd_import) ? '+' : '-';
						if (cd_import > 0 && cd_eksport > 0) {
							hz_data.push({
								value: Math.abs(cd_import - cd_eksport),
								code: this.code,
								nazwa: this.kraj,
								import: number_format(cd_import),
								eksport: number_format(cd_eksport),
								symbole: this.symbole,
								bilans: cd_char + number_format(Math.abs(cd_import - cd_eksport)),
								color: (cd_eksport >= cd_import) ? '#1FAD32' : '#AD1F1F'
							});
						}
						break;

					case 'import':
						cd_char = (cd_eksport >= cd_import) ? '+' : '-';
						if (cd_import > 0) {
							hz_data.push({
								value: Math.abs((cd_import * 100) / cd_max_import),
								import: pl_currency_format(cd_import),
								eksport: pl_currency_format(cd_eksport),
								bilans: cd_char + ' ' + pl_currency_format(Math.abs(cd_import - cd_eksport)),
								wymiana: pl_currency_format(cd_import + cd_eksport),
								c: (cd_eksport >= cd_import) ? '#1FAD32' : '#AD1F1F',
								code: this.code,
								nazwa: this.kraj
							});
						}
						break;

					case 'eksport':
						cd_char = (cd_eksport >= cd_import) ? '+' : '-';
						if (cd_eksport > 0) {
							hz_data.push({
								value: Math.abs((cd_eksport * 100) / cd_max_eksport),
								import: pl_currency_format(cd_import),
								eksport: pl_currency_format(cd_eksport),
								bilans: cd_char + ' ' + pl_currency_format(Math.abs(cd_import - cd_eksport)),
								wymiana: pl_currency_format(cd_import + cd_eksport),
								c: (cd_eksport >= cd_import) ? '#1FAD32' : '#AD1F1F',
								code: this.code,
								nazwa: this.kraj
							});
						}
						break;

					case 'wymiana':
						cd_char = (cd_eksport >= cd_import) ? '+' : '-';
						if (cd_import > 0 || cd_eksport > 0) {
							hz_data.push({
								value: Math.abs(((cd_import + cd_eksport) * 100) / (cd_max_import + cd_max_eksport)),
								import: pl_currency_format(cd_import),
								eksport: pl_currency_format(cd_eksport),
								bilans: cd_char + ' ' + pl_currency_format(Math.abs(cd_import - cd_eksport)),
								wymiana: pl_currency_format(cd_import + cd_eksport),
								c: (cd_eksport >= cd_import) ? '#1FAD32' : '#AD1F1F',
								code: this.code,
								nazwa: this.kraj
							});
						}
						break;
				}

			});

			hz_map.highcharts('Map', {
				title: {
					text: ''
				},

				chart: {
					backgroundColor: null,
					borderColor: '#333',
					spacing: [0, 0, 0, 0]
				},

				mapNavigation: {
					enabled: true,
					buttonOptions: {
						verticalAlign: 'bottom'
					},
					enableMouseWheelZoom: false
				},

				colors: hz_colors,
				colorAxis: hz_colorAxis,

				credits: {
					enabled: false
				},

				legend: {
					enabled: false
				},

				tooltip: hz_tooltip,

				series: [{
					animation: {
						duration: 0
					},
					data: hz_data,
					mapData: hz_map_data,
					nullColor: '#ffffff',
					joinBy: ['iso-a2', 'code'],
					dataLabels: {
						enabled: false
					}
				}]
			});

		});

		hz_type_last = hz_type;
		hz_year_last = hz_year;
	};

	$.getJSON('/HandelZagraniczny/files/world.geo.json', function (j) {
		hz_map_data = Highcharts.geojson(j, 'map');
		hz_createHighChart();
	});

	$('.hzTypeMenu li a').click(function () {
		$('.hzTypeMenu li.active').toggleClass('active');
		$(this).parent('li').toggleClass('active');
		hz_type = $(this).text().toLowerCase();
		hz_createHighChart();
		return false;
	});

	$('select.hzYearSelect').change(function () {
		hz_year = parseInt($(this).find(':selected').text(), 0);
		hz_createHighChart();
		return false;
	});

	$('#maplabel').sticky();

});
