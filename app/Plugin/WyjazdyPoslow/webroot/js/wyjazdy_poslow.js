/*global $,document,window,Highcharts*/

$(function () {
	$.getJSON('/WyjazdyPoslow/files/world.geo.json', function (geojson) {

		// Prepare the geojson
		var mapData = Highcharts.geojson(geojson, 'map'),
			$wyjazdyPoslowMap = $('#wyjazdyPoslowMap'),
			$detailInfo;

		$.getJSON('https://api-v3.mojepanstwo.pl/wyjazdyposlow/world8', function (statsData) {
			$.each(statsData, function () {
				this.value = this.ilosc_wyjazdow;
				this.laczna_kwota = this.laczna_kwota.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1 ');
			});

			// Initiate the chart
			$wyjazdyPoslowMap.highcharts('Map', {
				title: {
					text: ' '
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

				colorAxis: {
					min: 1,
					minColor: '#EEEEFF',
					maxColor: '#006df0'
				},

				credits: {
					enabled: false
				},

				legend: {
					enabled: false
				},

				series: [{
					animation: {
						duration: 1000
					},
					data: statsData,
					mapData: mapData,
					nullColor: 'transparent',
					joinBy: ['iso-a2', 'code'],
					dataLabels: {
						enabled: false
					},
					tooltip: {
						headerFormat: '',
						pointFormat: '<h3>{point.kraj}</h3><br>Ilość wyjazdów: <b>{point.ilosc_wyjazdow}</b><br/>Łączna kwota: <b>{point.laczna_kwota}</b>'
					},
					events: {
						click: function (e) {
							if (e.point) {
								if ($wyjazdyPoslowMap.find('.detailInfo').length === 0) {
									$detailInfo = $('<div></div>').addClass('detailInfo').append(
										$('<span></span>').addClass('detailInfoClose glyphicon glyphicon-remove')
									).append(
										$('<div></div>').addClass('content loading')
									);
									$wyjazdyPoslowMap.append($('<div></div>').addClass('detailInfoBackground'));
									$wyjazdyPoslowMap.append($detailInfo);
									$wyjazdyPoslowMap.find('.detailInfoClose, .detailInfoBackground').click(function () {
										$detailInfo.remove();
										$wyjazdyPoslowMap.find('.detailInfoBackground').remove();
									});
								} else {
									$detailInfo.find('.content').empty();
								}

								$.getJSON('https://api-v3.mojepanstwo.pl/wyjazdyposlow/countryDetails8/' + e.point.code.toLowerCase(), function (detail) {
									$detailInfo.find('.content').removeClass('loading').append(
										$('<div></div>').addClass('row').addClass('detail-header').append(
											$('<div></div>').addClass('ilosc col-xs-12 col-sm-6 col-md-4').html("Państwo:&nbsp;<b>" + e.point.kraj + "</b>")
										).append(
											$('<div></div>').addClass('ilosc col-xs-12 col-sm-6 col-md-4').html("Ilość&nbsp;wyjazdów:&nbsp;<b>" + e.point.ilosc_wyjazdow + "</b>")
										).append(
											$('<div></div>').addClass('koszt col-xs-12 col-sm-6 col-md-4').html("Łączna&nbsp;kwota:&nbsp;<b>" + e.point.laczna_kwota + "</b>")
										)
									);

									$.each(detail, function () {
										var that = this;

										//console.log(that);

										$detailInfo.find('.content').append(
											$('<div></div>').addClass('slice').append(
												$('<div></div>').addClass('nazwa col-xs-12 row').html("<p class=\"delegacja\"><a href=\"/dane/poslowie_wyjazdy_wydarzenia8/" + that.wydarzenie_id + "\">" + that.delegacja + "</a></p>")
											).append(
												$('<table></table>').addClass('table table-condensed col-xs-12').append(
													$('<thead></thead>').append(
														$('<td>').text('Osoba')
													).append(
														$('<td>').html('Transport')
													).append(
														$('<td>').html('Diety')
													).append(
														$('<td>').html('Hotele')
													).append(
														$('<td>').html('Dojazdy')
													).append(
														$('<td>').html('Ubezpieczenie')
													).append(
														$('<td>').html('Pobrane<br>zaliczki')
													).append(
														$('<td>').html('Koszt całkowity')
													)
												)
											)
										);

										$.each(that.poslowie, function () {
											
											var name = this.osoba;
											
											if( this.posel ) {
												name = this.posel;
												
												if( this.klub_skrot ) {
													name += ' (' + this.klub_skrot + ')';
												}
											}
																						
											$detailInfo.find('table:last').append(
												$('<tr></tr>').append(
													$('<td></td>').text(name)
												).append(
													$('<td></td>').text(this.koszt_transport)
												).append(
													$('<td></td>').text(this.koszt_dieta)
												).append(
													$('<td></td>').text(this.koszt_hotel)
												).append(
													$('<td></td>').text(this.koszt_dojazd)
												).append(
													$('<td></td>').text(this.koszt_kurs)
												).append(
													$('<td></td>').text(this.koszt_zaliczki)
												).append(
													$('<td></td>').html('<b>' + this.koszt_suma + '</b>')
												)
											);
										});
									});
								});
							}
						}
					}
				}]
			});
		});
	});

	var pieKlubowo = $('.pieChartKlubowo'),
		kluby = {},
		pieData = pieKlubowo.data('kluby');

	$.each(pieData, function () {
		kluby[this.name] = this.image;
	});

	// Build the chart
	pieKlubowo.highcharts({
		chart: {
			type: 'column',
			backgroundColor: null
		},
		xAxis: {
			type: 'category',
			labels: {
				rotation: -45,
				formatter: function () {
					var text = '<div class="klubyTitle">';
					if (kluby[this.value] !== '') {
						text += '<img src="' + kluby[this.value] + '"/>';
					}
					text += '<span>' + this.value + '</span></div>';

					return text;
				},
				useHTML: true
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Wartość [PLN]'
			}
		},
		credits: {
			enabled: false
		},
		legend: {
			enabled: false
		},
		title: {
			text: ''
		},
		tooltip: {
			headerFormat: '',
			pointFormat: '<b>{point.fullname}</b><br>Liczba wyjazdów: <b>{point.ilosc}<br>Koszt wyjazdów: <b>{point.sum}<br>Średnio na posła: <b>{point.avg}</b>'
		},
		series: [{
			data: pieData,
			dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				x: 4,
				y: 10,
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif',
					textShadow: '0 0 3px black'
				}
			}
		}]
	});
});
