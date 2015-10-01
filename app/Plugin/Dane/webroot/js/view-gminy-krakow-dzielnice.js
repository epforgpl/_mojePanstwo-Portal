var map,
	featureStyle = {
		fillColor: '#0000aa',
		fillOpacity: 0.05,
		strokeWeight: 2,
		strokeColor: '#0000aa'
	},
	featureHoverStyle = {
		fillColor: '#0000aa',
		fillOpacity: 0.3,
		strokeWeight: 2,
		strokeColor: '#0000aa'
	};

function mapHoverIn(dzielnicaName) {
	map.data.setStyle(function (feature) {
		var featureName = null;
		if (feature['A'] !== undefined)
			featureName = feature['A']['Name'];
		else if (feature['G'] !== undefined)
			featureName = feature['G']['Name'];
		else if (feature['H'] !== undefined)
			featureName = feature['H']['Name'];

		if (featureName == dzielnicaName) {
			return featureHoverStyle;
		} else {
			return featureStyle;
		}
	});
}
function mapHoverOut() {
	map.data.setStyle(function () {
		return featureStyle;
	});
}

function initialize() {
	var mapOptions = {
		zoom: 11,
		center: {lat: 50.0467656, lng: 20.0048731},
		draggable: true,
		scrollwheel: false,
		navigationControl: true,
		panControl: false,
		zoomControl: true,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.SMALL
		},
		mapTypeControl: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scaleControl: false,
		streetViewControl: false,
		overviewMapControl: false
	};

	map = new google.maps.Map(document.getElementById('dzielnice_map'), mapOptions);
	map.data.loadGeoJson('/Dane/files/krakow_dzielnice.geojson');
	map.data.setStyle(featureStyle);

	google.maps.event.addListenerOnce(map, 'idle', function () {
		map.setZoom(11);
	});

	google.maps.event.addListener(map.data, 'click', function (event) {
		var name = null;
		if (event.feature['A'] !== undefined)
			name = event.feature['A']['Name'];
		else if (event.feature['G'] !== undefined)
			name = event.feature['G']['Name'];
		else if (event.feature['H'] !== undefined)
			name = event.feature['H']['Name'];

		$('.dzielniceList a[data-dzielnica="' + name + '"]')[0].click();
	});

	google.maps.event.addListener(map.data, 'mouseover', function (event) {
		var name = null;
		if (event.feature['A'] !== undefined)
			name = event.feature['A']['Name'];
		else if (event.feature['G'] !== undefined)
			name = event.feature['G']['Name'];
		else if (event.feature['H'] !== undefined)
			name = event.feature['H']['Name'];

		$('.dzielniceList a[data-dzielnica="' + name + '"]').addClass('hover');
		mapHoverIn(name);
	});

	google.maps.event.addListener(map.data, 'mouseout', function () {
		$('.dzielniceList a.hover').removeClass('hover');
		mapHoverOut();
	});
}

google.maps.event.addDomListener(window, 'load', initialize);

$(document).ready(function () {
	if ($(window).outerWidth() > 728) {
		var dzielniceMap = $('#dzielnice_map'),
			holder = dzielniceMap.parent().find('.holder'),
			fundatorzy = $('#fundatorzy').outerHeight(true),
			header = $('.appHeader').outerHeight(true),
			submenu = $('.appMenu').outerHeight(true),
			size = $(window).outerHeight() - fundatorzy - header - submenu,
			dzielniceListHeight = $('.dzielniceList').outerHeight() + 40;

		if (size < dzielniceListHeight)
			size = dzielniceListHeight;

		holder.css('min-height', size);
		dzielniceMap.css('min-height', size);
	}

	$('.dzielniceList a').mouseover(function () {
		mapHoverIn($(this).data('dzielnica'));
	}).mouseout(function () {
		mapHoverOut();
	});
});
