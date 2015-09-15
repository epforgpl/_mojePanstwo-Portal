/**
 * Created by tomaszdrazewski on 15/09/15.
 */
var map,
	markers = [],
	mapUpdateTimer;

$(document).ready(function () {
	var options = {
			zoom: 12,
			center: new google.maps.LatLng(50.0467656, 20.0048731),
			panControl: true,
			zoomControl: true,
			mapTypeControl: true,
			scaleControl: true,
			streetViewControl: false,
			overviewMapControl: false,
			scrollwheel: false,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.RIGHT_TOP
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			backgroundColor: '#FFFFFF',
			minZoom: 11,
			maxZoom: 20
		},
		style = [
			{
				featureType: "administrative.country",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}, {
				featureType: "poi",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}, {
				featureType: "water",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}, {
				featureType: "road",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}
		];


	map = new google.maps.Map(document.getElementById('map'), options);
	map.mapTypes.set('style', new google.maps.StyledMapType(style, {name: 'My Style'}));


	if ($(window).outerWidth() > 728) {
		var mapa = $('#map'),
			fundatorzy = $('#fundatorzy').outerHeight(true),
			header=$('.appHeader').outerHeight(true),
			submenu=$('.appMenu').outerHeight(true);
		var size = $(window).outerHeight() - fundatorzy-header-submenu;

		mapa.css('min-height', size);
	}
});
