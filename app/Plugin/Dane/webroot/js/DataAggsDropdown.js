

var DataAggsDropdown = function(li) {
	var _this = this;
	this.li = $(li);
	this.skin = this.li.data('skin');
	this.aggs = this.li.data('aggs');
	this.isCreated = false;

	this.li.click(function() {
		_this.onClick();
	});
};

DataAggsDropdown.prototype.create = function() {
	if(this.isCreated)
		return false;

	switch(this.skin) {
		case 'list':
			this.createList();
		break;
	}

	this.isCreated = true;
};

DataAggsDropdown.prototype.createList = function() {
	var h = [
		'<div class="dropdown">',

		'</div>'
	];

	this.li.append(h.join(''));
};

DataAggsDropdown.prototype.show = function() {

};

DataAggsDropdown.prototype.onClick = function() {
	this.create();
	this.show();
};

var dataAggsDropdown;

$(document).ready(function () {

	window.DataAggsDropdowns = [];

	$('li.dataAggsDropdown').each(function() {
		dataAggsDropdown = new DataAggsDropdown($(this));
		window.DataAggsDropdowns.push(dataAggsDropdown);
	});

});
