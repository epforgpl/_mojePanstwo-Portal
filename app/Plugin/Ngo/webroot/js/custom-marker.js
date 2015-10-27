/*global infowindow*/

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
			if (map.getZoom() == self.maxZoom) {
				var infoWindowBlock,
					ngoPlaceBlock = '';

				$.get('/dane/krs_podmioty.json?conditions[geohash]=' + self.args.data.key, function (data) {
					$.each(data.hits, function () {
						var detailBlock = '',
							info = this;

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
