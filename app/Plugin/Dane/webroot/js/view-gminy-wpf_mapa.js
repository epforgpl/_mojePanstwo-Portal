/*global $, document, window, google, pl_number_format,number_format*/

$(document).ready(function () {
	var $wpfMapa = $('#wpfMapa'),
		base = ($wpfMapa.attr('data-pk')) ? '/wpf/' : '/dane/gminy/903,krakow/wpf/',
		$places = $.parseJSON($wpfMapa.attr('data-json')),
		markers = [],
		infowindow = null,
		map = new google.maps.Map(document.getElementById('wpfMapa'), {
			center: {lat: 50.0467656, lng: 20.0048731},
			zoom: 11,
			scrollwheel: false,
			navigationControl: true,
			panControl: false,
			zoomControl: true,
			zoomControlOptions: {
				position: google.maps.ControlPosition.RIGHT_CENTER
			},
			mapTypeControl: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scaleControl: false,
			streetViewControl: false,
			overviewMapControl: false
		});

	function mapSize() {
		$wpfMapa.css('height', 'auto');
		$wpfMapa.css('height', $('#_wrapper').height() - $('.appHeader ').outerHeight() - $('.appMenu').outerHeight() - $('footer.footer').height());
	}

	infowindow = new google.maps.InfoWindow({
		content: "..."
	});

	if ($places.length) {
		for (var j = 0, len = $places.length; j < len; j++) {
			var el = $places[j],
				position = {lat: Number(el.lat), lng: Number(el.lon)};

			markers.push(new google.maps.Marker({
				map: map,
				title: el.nazwa,
				position: position,
				data: {
					id: el.id,
					title: el.nazwa,
					kwota: number_format(el.laczne_naklady_fin, 0)
					//kwota: pl_number_format(el.laczne_naklady_fin,1)
				}
			}));
		}

		for (var i = 0; i < markers.length; i++) {
			var marker = markers[i];
			google.maps.event.addListener(marker, 'click', function () {
				var contentString = '<div id="wpfInfoContent">' +
					'<div class="title">' +
					'<a href="' + base + this.data.id + '">' + this.data.title + '</a>' +
					'</div>' +
					'<div class="cost">Wartość inwestycji: <strong>' + this.data.kwota + ' zł</strong></div>' +
					'</div>';

				infowindow.setContent(contentString);
				infowindow.open(map, this);
			});
		}
	}
	window.onresize = mapSize;

	mapSize();
});
