/*global mPHeart, document, window, $, google, Geohash*/

function MapaWarstwy(map) {
	this.markers = {
		instytucje: {},
		biznes: {},
		ngo: {},
		komisje_wyborcze: {}
	};
	//this.warstwyMarkers = [];

	this.pendingArea = {tl: false, br: false, zoom: false};
	this.lastArea = {tl: false, br: false, zoom: false};
	this.mapUpdateTimer = null;
	this.xhr = null;
	this.layer = null;
	this.map = map;
	this.cacheAjax = {};
	this.infowindow = null;
}

MapaWarstwy.prototype.setLayer = function (layer) {
	var self = this;

	self.layer = layer;

	google.maps.event.clearListeners(self.map, 'idle');
	if (self.layer !== false) {
		google.maps.event.addDomListener(self.map, 'idle', function () {
			self.mapUpdate(self.layer);
		});
		self.mapUpdate(self.layer);
	} else {
		$('.accord.warstwy').attr('data-layer', self.layer);
		self.mapUpdateClear();
	}
};

MapaWarstwy.prototype.showPlaces = function (data) {
	var icon = {
			path: 'M-8,0a8,8 0 1,0 16,0a8,8 0 1,0 -16,0',
			fillColor: 'red',
			strokeColor: 'red',
			fillOpacity: 1
		},
		self = this;

	for (var i = 0; i < data.grid.buckets.length; i++) {
		var cell = data.grid.buckets[i],
			center = Geohash.decode(cell.key),
			f = 0.5,
			term = 'marker-' + center.lat + '-' + center.lon;

		if (!(term in self.markers[self.layer])) {
			if (cell.doc_count === 1) {
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(cell.location.lat, cell.location.lon),
					icon: icon,
					map: self.map,
					data: cell.data
				});

				self.markers[self.layer][term] = marker;

				marker.addListener('click', (function (marker) {
					return function () {
						if (self.infowindow) {
							self.infowindow.close();
						}
						self.infowindow = new google.maps.InfoWindow();

						self.infowindow.setContent('<div class="infoWindowNgo">' +
							'<div class="ngoPlace">' +
							'<div class="title">' +
							'<a href="/dane/krs_podmioty/' + marker.data['krs_podmioty.id'] + '">' +
							'<span class="object-icon icon-datasets-krs_podmioty"></span>' +
							'<div class="titleName">' + marker.data['krs_podmioty.nazwa'] + '</div>' +
							'</a>' +
							'</div>' +
							'</div>' +
							'</div>');

						self.infowindow.open(self.map, marker);
						self.map.setCenter(marker.latlng);
					};
				})(marker, content, self.infowindow));
			} else {
				var inner_center = Geohash.decode(cell.inner_key),
					centerLat = center.lat + (inner_center.lat - center.lat) * f,
					centerLng = center.lon + (inner_center.lon - center.lon) * f;

				this.markers[self.layer][term] = new CustomMarker(self, new google.maps.LatLng(centerLat, centerLng), self.map, {
					title: cell.doc_count,
					data: cell
				});
			}
		}
	}
};


MapaWarstwy.prototype.getArea = function () {
	var self = this,
		bounds = self.map.getBounds(),
		precision = self.map.getZoom(),
		ne_lat = bounds.getNorthEast().lat(),
		sw_lng = bounds.getSouthWest().lng(),
		sw_lat = bounds.getSouthWest().lat(),
		ne_lng = bounds.getNorthEast().lng(),
		f = 0.1,
		ne_lat_fixed = ne_lat + ((ne_lat - sw_lat) * f),
		ne_lng_fixed = ne_lng + ((ne_lng - sw_lng) * f),
		sw_lat_fixed = sw_lat - ((ne_lat - sw_lat) * f),
		sw_lng_fixed = sw_lng - ((ne_lng - sw_lng) * f);

	return {
		tl: Geohash.encode(ne_lat_fixed, sw_lng_fixed, precision),
		br: Geohash.encode(sw_lat_fixed, ne_lng_fixed, precision),
		zoom: self.map.getZoom()
	};
};

MapaWarstwy.prototype.mapUpdateClear = function () {
	var self = this;

	$.each(self.markers, function (k, v) {
		$.each(v, function (key, value) {
			value.setMap(null);
		});
	});

	self.lastArea = {tl: false, br: false, zoom: false};
	self.markers = {
		instytucje: {},
		biznes: {},
		ngo: {},
		komisje_wyborcze: {}
	};
};

MapaWarstwy.prototype.mapUpdateResults = function (data, area) {
	var self = this,
		accordWarstwy = $('.accord.warstwy');

	if (accordWarstwy.attr('data-layer') !== self.layer) {
		accordWarstwy.attr('data-layer', self.layer);
		self.mapUpdateClear();
	} else if (area.zoom !== self.lastArea.zoom) {
		self.mapUpdateClear();

		if (self.infowindow) {
			self.infowindow.close();
		}
	}

	self.lastArea = area;

	if (self.layer) {
		self.showPlaces(data);
	}

	self.complete();
};

MapaWarstwy.prototype.mapUpdate = function (layer) {
	var self = this;

	self.loading();

	if (self.map.getBounds()) {
		self.pendingArea = self.getArea();
	}

	window.clearTimeout(self.mapUpdateTimer);

	self.mapUpdateTimer = window.setTimeout(function () {
		var area = self.getArea();

		if ((area.tl === self.pendingArea.tl) && (area.br === self.pendingArea.br)) {
			var areaParms = area.tl + ',' + area.br + '&layer=' + layer;

			if (areaParms in self.cacheAjax) {
				self.mapUpdateResults(self.cacheAjax[areaParms], area);
			} else {
				if (self.xhr && self.xhr.readystate !== 4) {
					self.xhr.abort();
				}

				self.xhr = $.get('/mapa/grid.json', {
					area: area.tl + ',' + area.br,
					layer: layer
				}, function (data) {
					self.cacheAjax[areaParms] = data;
					self.mapUpdateResults(data, area);
				}, 'json');
			}
		}
	}, 400);

};

MapaWarstwy.prototype.loading = function () {

};

MapaWarstwy.prototype.complete = function () {

};


function CustomMarker(mapaWarstwy, latlng, map, args) {
	this.mapaWarstwy = mapaWarstwy;
	this.latlng = latlng;
	this.args = args;
	this.setMap(map);
	this.maxZoom = 17;
}

CustomMarker.prototype = new google.maps.OverlayView();

CustomMarker.prototype.draw = function () {
	var self = this,
		div = this.div;

	if (!div) {
		div = self.div = document.createElement('div');
		div.className = 'btn btn-xs btn-primary cluster';
		div.innerHTML = self.args.title;

		if (typeof(self.args.marker_id) !== 'undefined') {
			div.dataset.marker_id = self.args.marker_id;
		}

		google.maps.event.addDomListener(div, "click", function () {
			if (self.map.getZoom() === self.maxZoom) {
				var infoWindowBlock,
					ngoPlaceBlock = '';

				$.get('/dane/krs_podmioty.json?conditions[geohash]=' + self.args.data.key, function (data) {
					$.each(data.hits, function () {
						var info = this;

						ngoPlaceBlock += '<div class="ngoPlace">' +
							'<div class="title">' +
							'<a href="/dane/krs_podmioty/' + info.id + ',' + info.slug + '">' +
							'<span class="object-icon icon-datasets-krs_podmioty"></span>' +
							'<div itemprop="name" class="titleName">' + info.data.nazwa + '</div>' +
							'</a>' +
							'</div>' +
							'</div>';
					});
					infoWindowBlock = '<div class="infoWindowNgo">' + ngoPlaceBlock + '</div>';

					self.mapaWarstwy.infowindow.setContent(infoWindowBlock);
				});
				if (self.mapaWarstwy.infowindow) {
					self.mapaWarstwy.infowindow.close();
				}
				self.mapaWarstwy.infowindow = new google.maps.InfoWindow({
					position: self.latlng,
					content: '<div class="spinner grey">' +
					'<div class="bounce1"></div>' +
					'<div class="bounce2"></div>' +
					'<div class="bounce3"></div>' +
					'</li>'
				});
				self.mapaWarstwy.infowindow.open(self.map);
				self.map.setCenter(self.latlng);
				google.maps.event.addListener(self.mapaWarstwy.infowindow, 'domready', function () {
					self.mapaWarstwy.map.setCenter(self.mapaWarstwy.infowindow.getPosition());
				});
			} else {
				self.map.setCenter(self.latlng);
				self.map.setZoom(self.map.getZoom() + 2);
			}
		});

		var panes = self.getPanes();
		panes.overlayImage.appendChild(div);
	}

	var point = self.getProjection().fromLatLngToDivPixel(self.latlng);

	if (point) {
		div.style.left = (point.x - div.offsetWidth / 2) + 'px';
		div.style.top = (point.y - div.offsetHeight / 2) + 'px';
	}
};

CustomMarker.prototype.remove = function () {
	if (this.div) {
		this.div.parentNode.removeChild(this.div);
		this.div = null;
	}
};

CustomMarker.prototype.getPosition = function () {
	return this.latlng;
};
