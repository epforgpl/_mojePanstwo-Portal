var FeedTimeline = Class.extend({
    init: function (div) {
	    
	    this.div = $(div);
	    this.timelineDiv = this.div.find('.feed-timeline');
	    this.contentDiv = this.div.find('.feed-content');
	    this.contentHeight = this.contentDiv.height() - 55;
	    
	    this.line = $('<div class="line"></div>');
	    this.timelineDiv.html( this.line );
	    
	    this.line.css('height', this.contentHeight + 'px');
	    
	    var objects = this.contentDiv.find('.objectRender');
	    for( var i=0; i<objects.length; i++ ) {
		    
		    var obj = $(objects[i]);
		    var pos = obj.position();
			var top = Math.round( pos['top'] ) + 40;
					    
		    var point = $('<p class="point"></p>');
		    point.css('top', top + 'px');
		    this.line.append(point);
		    
	    }
	    
	}
});

var _ftl;

$(document).ready(function(){
	_ftl = new FeedTimeline('.feed-content');
});