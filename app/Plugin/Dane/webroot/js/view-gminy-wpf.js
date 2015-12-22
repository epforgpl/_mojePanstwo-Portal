/*global $, document, google*/

$(document).ready(function () {
	// DRAW HIGHCHART

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
					height: 150
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

	// DRAW MAP
	var $krakowWpfPlaceMarker = $('.krakowWpfPlaceMarker'),
		googleMap = $('#map'),
		init_lat = googleMap.attr('data-lat'),
		init_lon = googleMap.attr('data-lon'),
		marker = null,
		form = $('#map_form'),
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 50.0467656, lng: 20.0048731},
			zoom: (googleMap.attr('data-zoom') !== "0") ? Number(googleMap.attr('data-zoom')) : 11,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false
		});

	// EXTEND MAP FUNCTIONS FOR ADMIN
	function mapMarkerCleaner() {
		if (marker !== null) {
			marker.setMap(null);
		}
		$krakowWpfPlaceMarker.find('form input').val('');

	}

	function mapMarkerRemover() {
		$('.krakowWpfPlace .removeMarker').remove();
		mapMarkerCleaner();
	}

	function mapMarkerDragEnd() {
		form.find('input[name=lat]').val(this.position.lat());
		form.find('input[name=lon]').val(this.position.lng());
	}

	// CREATING MARKER ON STARTUP IF EXIST LAT/LNG
	if (init_lat && init_lon) {
		var position = {lat: Number(init_lat), lng: Number(init_lon)};

		marker = new google.maps.Marker({
			map: map,
			title: 'Marker',
			position: position,
			draggable: (form.length) ? true : false
		});

		if (form.length) {
			google.maps.event.addListener(marker, 'dragend', mapMarkerDragEnd);
		}

		map.setCenter(position);
	}

	// EXTEND MAP FOR ADMIN
	if (form.length) {
		var pacInput = $('#pac-input'),
			input = document.getElementById('pac-input');

		form.submit(function (event) {
			var lat = form.find('input[name=lat]').val(),
				lon = form.find('input[name=lon]').val();

			if (lat && lon) {
				form.submit();
			} else {
				event.preventDefault();
				alert('Najpierw ustal marker');
				return false;
			}
		});

		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

		if (init_lat && init_lon) {
			$('.removeMarker').click(mapMarkerRemover);
		}

		if (pacInput.length) {
			var searchBox = new google.maps.places.SearchBox(input);

			map.addListener('bounds_changed', function () {
				searchBox.setBounds(map.getBounds());
			});

			map.addListener('zoom_changed', function () {
				form.find('input[name=zoom]').val(map.getZoom());
			});

			searchBox.addListener('places_changed', function () {
				var places = searchBox.getPlaces();

				if (places.length === 0) {
					return;
				}

				mapMarkerCleaner();

				var bounds = new google.maps.LatLngBounds();

				marker = new google.maps.Marker({
					map: map,
					title: 'Marker',
					position: places[0].geometry.location,
					draggable: true
				});

				form.find('input[name=lat]').val(places[0].geometry.location.lat());
				form.find('input[name=lon]').val(places[0].geometry.location.lng());

				if (places[0].geometry.viewport) {
					bounds.union(places[0].geometry.viewport);
				} else {
					bounds.extend(places[0].geometry.location);
				}

				google.maps.event.addListener(marker, 'dragend', mapMarkerDragEnd);

				if ($('.krakowWpfPlace .removeMarker').length === 0) {
					$('.krakowWpfPlace header').append(
						$('<div></div>').addClass('removeMarker btn btn-danger btn-xs margin-sides-10').append(
							$('<span></span>').addClass('glyphicon glyphicon-remove')
						)
					).click(mapMarkerRemover);
				}

				map.fitBounds(bounds);
			});
		}
	}
});
