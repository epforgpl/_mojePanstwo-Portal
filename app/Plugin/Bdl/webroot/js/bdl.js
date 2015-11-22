/*global mPHeart*/

$(document).ready(function () {
    
    var lastChoose,
        $bdl = lastChoose = $('#bdl');
		
	var click = function (block) {
		
		block = $(block);
		var items = block.parent('.items');
		
        var next = block.next(),
            targetPos = block.position().top,
            slideMark,
            data = block.data();

        if (block[0] === lastChoose[0]) {
            lastChoose = false;
            items.removeClass('focus-control');
            items.find('.block.focus').removeClass('focus');
            $bdl.find('.infoBlock').addClass('old').css({
                'height': 0,
                'border-width': 0
            }).stop(true, true).animate({'margin-top': 0}, 500, function () {
                $bdl.find('.infoBlock.old').remove();
                var offset = block.offset();
	    		$('html').animate({scrollTop: offset['top']});
            });

            return;
        } else {
            items.find('.block.focus').removeClass('focus');
            items.addClass('focus-control');
            block.addClass('focus');
            lastChoose = block;
        }

        if (next.length == 0) {
            slideMark = block;
        } else {
            while (next.length != 0) {
                if (next.next().length == 0) {
                    slideMark = next;
                    break;
                } else {
                    if (next.position().top != targetPos) {
                        slideMark = next.prev();
                        break;
                    }
                    next = next.next();
                }
            }
        }

        var infoBlock = $('<div></div>').addClass('infoBlock current active col-xs-12').css('height', 0).append(
            $('<div></div>').addClass('arrow')
        ).append(
            $('<div></div>').addClass('content').append(
                $('<div></div>').addClass('container')
            )
        );
		
					
        if ($bdl.find('.infoBlock').length !== 0) {
            if ($bdl.find('.infoBlock').data('marker')[0] === slideMark[0]) {
                infoBlock = $bdl.find('.infoBlock');
                infoBlock.addClass('current active');
            } else {
                $bdl.find('.infoBlock').addClass('old').removeClass('active').css({
                    'height': 0,
                    'border-width': 0
                }).stop(true, true).animate({'margin-top': 0}, 500, function () {
                    $bdl.find('.infoBlock.old').remove()
                });
                slideMark.after(infoBlock);
            }
        } else {
            slideMark.after(infoBlock);
        }

        infoBlock.data('marker', slideMark).find('.container').empty().append(function () {
            
            var slug = $(this), title = $.trim(data.title), info = data.info;
            var leftCol = $('<div></div>').addClass('leftSide col-xs-12');
            var content = block.find('.text').html();
            
            leftCol.append( content.replace(/span/g, 'a') );
            slug.append(leftCol);
            
        });

        if (infoBlock.position().left != 0) {
            infoBlock.css({'margin-left': -infoBlock.position().left, width: $(window).width()})
        }
        infoBlock.find('.arrow').css('left', block.position().left + (block.outerWidth() / 2) + 'px');
        infoBlock.removeClass('current').css('height', infoBlock.find('.container').outerHeight(true));
        
        var offset = block.offset();
		$('html').animate({scrollTop: offset['top']});
        
    }
	
	if( window.location.hash ) {
		
		var hash = window.location.hash.substring(1);
		if( hash.length ) {
			
			var parts = hash.split(',');
			hash = parts[0];
			
			var item = $bdl.find('.item[name=' + hash + ']');
			if( item.length ) {
				
				click(item.parents('.block')[0]);
				
			} else {
				
				history.pushState("", document.title, window.location.pathname);
				
			}
			
		}
		
	}
	
	$bdl.find('.item a').click(function(e){
		click($(e.target).parents('.block')[0]);
	});
	
});