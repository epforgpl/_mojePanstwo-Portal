/*global $, document, google*/

$(document).ready(function () {
	$('.krakowWpfProgramStatic').each(function () {
		var data = $(this).data(),
			from = -1,
			to = -1,
			categories = [],
			years = [],
			i;

		if (typeof data.static === 'undefined' || typeof data.static.years === 'undefined') {
			return false;
		}

		for (i = 0; i < data.static.years.length; i++) {
			if (data.static.years[i][1] !== '0') {
				from = i;
				break;
			}
		}

		for (i = data.static.years.length - 1; i >= 0; i--) {
			if (data.static.years[i][1] !== '0') {
				to = i;
				break;
			}
		}

		data.static.years.forEach(function (value, index) {
			if (index >= from && index <= to) {
				categories.push(value[0]);
				years.push({
					name: value[0],
					y: parseInt(value[1], 0)
				});
			}
		});

		if (years.length > 1) {
			$(this).highcharts({
				chart: {
					type: 'line',
					backgroundColor: null,
					height: 120
				},
				title: {
					text: ''
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					categories: categories,
					title: {
						text: null
					},
					labels: {
						rotation: -45,
						style: {"color": "#778899"}
					},
					gridLineColor: "#EEEEEE"
				},
				yAxis: {
					min: 0,
					title: {
						text: null
					},
					labels: {
						overflow: 'justify',
						style: {"color": "#778899"}
					},
					gridLineColor: "#EEEEEE"
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
					name: 'Kwota w zł',
					data: years,
					color: '#3CB371'
				}]
			});
		}
	});

	var $krakowWpfPlaceMarker = $('.krakowWpfPlaceMarker');
	if ($krakowWpfPlaceMarker.length) {
		var googleMap = $('#map'),
			pacInput = $('#pac-input');

		var map = new google.maps.Map(document.getElementById('map'), {
				center: {lat: 50.0467656, lng: 20.0048731},
				zoom: (googleMap.attr('data-place') !== undefined) ? 16 : 11,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}),
			input = document.getElementById('pac-input'),
			markers = [];

		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

		if (pacInput.length) {
			var searchBox = new google.maps.places.SearchBox(input);
			map.addListener('bounds_changed', function () {
				searchBox.setBounds(map.getBounds());
			});

			searchBox.addListener('places_changed', function () {
				var places = searchBox.getPlaces();

				if (places.length === 0) {
					return;
				}

				markers.forEach(function (marker) {
					marker.setMap(null);
				});

				$krakowWpfPlaceMarker.find('form input[name="place[]"]').remove();

				var bounds = new google.maps.LatLngBounds();
				places.forEach(function (place) {
					var icon = {
						url: place.icon,
						size: new google.maps.Size(71, 71),
						origin: new google.maps.Point(0, 0),
						anchor: new google.maps.Point(17, 34),
						scaledSize: new google.maps.Size(25, 25)
					};

					markers.push(new google.maps.Marker({
						map: map,
						icon: icon,
						title: place.name,
						position: place.geometry.location
					}));

					if ($krakowWpfPlaceMarker.find('form').length) {
						$krakowWpfPlaceMarker.find('form').append(
							$('<input/>').attr({
								name: 'place[]',
								type: 'hidden'
							}).val(JSON.stringify(place))
						);
					}

					if (place.geometry.viewport) {
						bounds.union(place.geometry.viewport);
					} else {
						bounds.extend(place.geometry.location);
					}
				});
				map.fitBounds(bounds);
			});
		}

		if (googleMap.attr('data-place') !== undefined) {
			var place = JSON.parse(googleMap.attr('data-place'));

			var icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25)
			};

			markers.push(new google.maps.Marker({
				map: map,
				icon: icon,
				title: place.name,
				position: {lat: place.geometry.location.G, lng: place.geometry.location.K}
			}));

			map.setCenter({lat: place.geometry.location.G, lng: place.geometry.location.K});

			if ($krakowWpfPlaceMarker.find('form').length) {
				$krakowWpfPlaceMarker.find('form').append(
					$('<input/>').attr({
						name: 'place[]',
						type: 'hidden'
					}).val(JSON.stringify(place))
				);
			}
			if (pacInput.length) {
				pacInput.val(place.formatted_address);
			}
		}
	}
});
