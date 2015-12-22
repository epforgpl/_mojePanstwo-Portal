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
	
	var googleMap = $('#map');
	var init_lat = googleMap.attr('data-lat');
	var init_lon = googleMap.attr('data-lon');
	
	console.log(init_lat, init_lon);
	
	if( init_lat && init_lon ) {
		
		init_lat = Number(init_lat);
		init_lon = Number(init_lon);
		
		var map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 50.0467656, lng: 20.0048731},
			zoom: (googleMap.attr('data-place') !== undefined) ? 16 : 11,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false
		});
		var markers = [];
		
		var position = {lat: init_lat, lng: init_lon};
		
		markers.push(new google.maps.Marker({
			map: map,
			title: 'Marker',
			position: position
		}));
		map.setCenter(position);

	}
	
	
	
	
	
	// EXTEND MAP FOR ADMIN
	
	var form = $('#map_form');
	if( form.length ) {
		
		form.submit(function(event){
			
			
			
			var lat = form.find('input[name=lat]').val();
			var lon = form.find('input[name=lon]').val();
			
			if( lat && lon ) {
				
				form.submit();
			
			} else {
				
				event.preventDefault();
				alert('Najpierw ustal marker');
				return false;
				
			}			
			
		});
		
		var $krakowWpfPlaceMarker = $('.krakowWpfPlaceMarker');
		var pacInput = $('#pac-input');

				
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

				// $krakowWpfPlaceMarker.find('form input[name="place[]"]').remove();

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
									
					console.log(place.geometry.location);
					
					// TODO: find out a better way to retrieve lattidude and longitude
					form.find('input[name=lat]').val( place.geometry.location.lat() );
					form.find('input[name=lon]').val( place.geometry.location.lng() );
					form.find('input[name=zoom]').val( map.getZoom() );

					if (place.geometry.viewport) {
						bounds.union(place.geometry.viewport);
					} else {
						bounds.extend(place.geometry.location);
					}
					
					return false;
					
				});
				
				map.fitBounds(bounds);
				
			});
		}
		
	}
	
});
