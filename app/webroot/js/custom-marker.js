/*global infowindow*/

function CustomMarker(latlng, map, args) {
	this.latlng = latlng;
	this.args = args;
	this.setMap(map);
	this.maxZoom = 15;
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
			if (map.getZoom() == self.maxZoom) {
				var infoWindowBlock,
					ngoPlaceBlock = '';

				$.get('/dane/krs_podmioty.json?conditions[geohash]=' + self.args.data.key, function (data) {
					$.each(data.hits, function () {
						var detailBlock = '',
							info = this;

						if (info.data.krs.length > 0) {
							detailBlock += '<li class="dataHighlight">' +
								'<p class="_label">Numer KRS</p>' +
								'<p class="_value">' + info.data.krs + '</p>' +
								'<li>';
						}
						if (info.data.nip.length > 0) {
							detailBlock += '<li class="dataHighlight">' +
								'<p class="_label">Numer NIP</p>' +
								'<p class="_value">' + info.data.nip + '</p>' +
								'<li>';
						}
						if (info.data.regon.length > 0) {
							detailBlock += '<li class="dataHighlight">' +
								'<p class="_label">Numer REGON</p>' +
								'<p class="_value">' + info.data.regon + '</p>' +
								'<li>';
						}
						if (info.data.data_rejestracji.length > 0) {
							detailBlock += '<li class="dataHighlight">' +
								'<p class="_label">Data rejestracji</p>' +
								'<p class="_value">' + info.data.data_rejestracji + '</p>' +
								'<li>';
						}
						if (info.data.sygnatura_akt.length > 0) {
							detailBlock += '<li class="dataHighlight">' +
								'<p class="_label">Sygnatura akt</p>' +
								'<p class="_value">' + info.data.sygnatura_akt + '</p>' +
								'<li>';
						}

						ngoPlaceBlock += '<div class="ngoPlace">' +
							'<div class="title">' +
							'<a href="/dane/krs_podmioty/' + info.id + ',' + info.slug + '">' +
							'<i class="object-icon icon-datasets-krs_podmioty"></i>' +
							'<div itemprop="name" class="titleName">' + info.data.nazwa + '</div>' +
							'</a>' +
							'</div>' +
							'<ul class="detail dataHighlights oneline">' + detailBlock + '</ul>' +
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
				map.setCenter(self.latlng);
			} else {
				map.setCenter(self.latlng);
				map.setZoom(map.getZoom() + 2);
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
