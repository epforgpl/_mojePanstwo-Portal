function CustomMarker(latlng, map, args) {
	this.latlng = latlng;
	this.args = args;
	this.setMap(map);
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
			map.setCenter(self.latlng);
			map.setZoom(map.getZoom() + 2);
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
