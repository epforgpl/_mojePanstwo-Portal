/*global map, infowindow*/
var cacheAjax = {},
	infowindow = infowindow || null;

function CustomMarker(latlng, map, args) {
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
			if (self.map.getZoom() == self.maxZoom) {
				var infoWindowBlock,
					ngoPlaceBlock = '';

				$.get('/dane/krs_podmioty.json?conditions[geohash]=' + self.args.data.key, function (data) {
					$.each(data.hits, function () {
						var info = this;

						ngoPlaceBlock += '<div class="ngoPlace">' +
							'<div class="title">' +
							'<a href="/dane/krs_podmioty/' + info.id + ',' + info.slug + '">' +
							'<i class="object-icon icon-datasets-krs_podmioty"></i>' +
							'<div itemprop="name" class="titleName">' + info.data.nazwa + '</div>' +
							'</a>' +
							'</div>' +
							'</div>';
					});
					infoWindowBlock = '<div class="infoWindowNgo">' + ngoPlaceBlock + '</div>';

					infowindow.setContent(infoWindowBlock)
				});
				if (infowindow)
					infowindow.close();

				infowindow = new google.maps.InfoWindow({
					position: self.latlng,
					content: '<div class="spinner grey">' +
					'<div class="bounce1"></div>' +
					'<div class="bounce2"></div>' +
					'<div class="bounce3"></div>' +
					'</li>'
				});
				infowindow.open(map);
				self.map.setCenter(self.latlng);
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


function mapaWarstwy(map) {
	this.markers = {
		biznes: [],
		ngo: [],
		komitety: []
	};

	this.pendingArea = {tl: false, br: false, zoom: false};
	this.lastArea = {tl: false, br: false, zoom: false};
	this.mapUpdateTimer = null;
	this.xhr = null;
	this.layer = null;

	this.map = map;
}

mapaWarstwy.prototype.setLayer = function (layer) {
	google.maps.event.addDomListener(this.map, 'idle', this.mapUpdate(layer));
};

mapaWarstwy.prototype.showNgo = function (data) {
	var ngoIcon = {
		path: 'M-8,0a8,8 0 1,0 16,0a8,8 0 1,0 -16,0',
		fillColor: 'red',
		strokeColor: 'red',
		fillOpacity: 1
	};
	for (var i = 0; i < data.grid.buckets.length; i++) {
		var cell = data.grid.buckets[i],
			center = Geohash.decode(cell.key),
			f = .5,
			term = 'marker-' + center.lat + '-' + center.lon;

		if (!(term in this.markers.ngo)) {
			if (cell.doc_count == 1) {
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(cell.location.lat, cell.location.lon),
					icon: ngoIcon,
					map: map,
					data: cell.data
				});

				this.markers.ngo[term] = marker;

				marker.addListener('click', (function (marker) {
					var self = this;
					return function () {
						if (infowindow)
							infowindow.close();

						infowindow = new google.maps.InfoWindow();

						infowindow.setContent('<div class="infoWindowNgo">' +
							'<div class="ngoPlace">' +
							'<div class="title">' +
							'<a href="/dane/krs_podmioty/' + marker.data['krs_podmioty.id'] + '">' +
							'<i class="object-icon icon-datasets-krs_podmioty"></i>' +
							'<div class="titleName">' + marker.data['krs_podmioty.nazwa'] + '</div>' +
							'</a>' +
							'</div>' +
							'</div>' +
							'</div>');
						infowindow.open(map, marker);
						self.map.setCenter(marker.latlng);
					};
				})(marker, content, infowindow));
			} else {
				var inner_center = Geohash.decode(cell.inner_key),
					centerLat = center.lat + (inner_center.lat - center.lat) * f,
					centerLng = center.lon + (inner_center.lon - center.lon) * f;

				this.markers.ngo[term] = new CustomMarker(new google.maps.LatLng(centerLat, centerLng), map, {
					title: cell.doc_count,
					data: cell
				});
			}
		}
	}
};


mapaWarstwy.prototype.getArea = function () {
	var bounds = this.map.getBounds(),
		precision = this.map.getZoom();

	console.log(bounds, typeof bounds, typeof bounds == "undefined");

	if (typeof bounds == "undefined") {
		return {tl: false, br: false, zoom: false};
	} else {
		var ne_lat = bounds.getNorthEast().lat(),
			sw_lng = bounds.getSouthWest().lng(),
			sw_lat = bounds.getSouthWest().lat(),
			ne_lng = bounds.getNorthEast().lng(),

			f = .1,

			ne_lat_fixed = ne_lat + ((ne_lat - sw_lat) * f),
			ne_lng_fixed = ne_lng + ((ne_lng - sw_lng) * f),
			sw_lat_fixed = sw_lat - ((ne_lat - sw_lat) * f),
			sw_lng_fixed = sw_lng - ((ne_lng - sw_lng) * f);

		return {
			tl: Geohash.encode(ne_lat_fixed, sw_lng_fixed, precision),
			br: Geohash.encode(sw_lat_fixed, ne_lng_fixed, precision),
			zoom: this.map.getZoom()
		};
	}
};

mapaWarstwy.prototype.mapUpdateResults = function (data, area) {
	if (area.zoom !== this.astArea.zoom) {
		$.each(mapaWarstwy.markers.ngo, function (key, value) {
			value.setMap(null);
		});

		mapaWarstwy.markers.ngo = {};
	}
	this.lastArea = area;

	this.showNgo(data);
};

mapaWarstwy.prototype.mapUpdate = function (layer) {
	var self = this;

	self.layer = layer;

	if (infowindow === null || infowindow.getMap() === null) {
		self.pendingArea = self.getArea();

		window.clearTimeout(self.mapUpdateTimer);
		self.mapUpdateTimer = window.setTimeout(function () {
			var area = self.getArea();

			if ((area.tl == self.pendingArea.tl) && (area.br == self.pendingArea.br)) {
				mapInit = true;
				if ((area.tl != self.lastArea.tl) || (area.br != self.lastArea.br)) {
					var areaParms = area.tl + ',' + area.br + '&layer=' + layer;

					if (areaParms in cacheAjax) {
						self.mapUpdateResults(cacheAjax[areaParms], area);
					} else {
						if (self.xhr && self.xhr.readystate != 4) {
							self.xhr.abort();
						}

						self.xhr = $.get('/mapa/grid.json', {
							area: area.tl + ',' + area.br,
							layer: layer
						}, function (data) {
							cacheAjax[areaParms] = data;
							self.mapUpdateResults(data, area);
						}, 'json');
					}
				}
			}
		}, 400);
	}
};
