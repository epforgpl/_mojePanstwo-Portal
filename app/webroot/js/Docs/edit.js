/**
 * Created by tomaszdrazewski on 12/08/15.
 */

$(document).ready(function () {
	
	var doc = jQuery('.htmlexDoc .document');
	
	doc.on('init', function(event){
		
		var canvas = doc.find('.canvas');
		canvas.find('.pf:not(".i")').each(function () {
		
			var page = $(this);
			var width = page.outerWidth();
			var marginTop = page.css('marginTop');
			var scale = 1; // pobieramy rzeczywistą wartość z .pf
						
			console.log('initializing page', page, width);
			
			var toolbar = $('<div class="pagetoolbar">' +
				'<div class="row"><div class="pull-left">' + 
					'<input class="input-checkbox" type="checkbox" />' +
					'<div class="btn-group">' +
						'<button type="button" class="btn btn-sm rotate-left" aria-label="rotate-left">' +
							'<i	class="fa fa-undo"></i>' +
						'</button>' +
						'<button type="button" class="btn btn-sm rotate-right" aria-label="rotate-right">' +
							'<i	class="fa fa-repeat"></i>' + 
						'</button>' +
					'</div>' +
				'</div>' + 
				'<div class="pull-right">' + 
					'<button type="button" class="btn tb-btn btn-sm add-to-list" data-toggle="modal" data-target="#document_bookmark_modal">' +
						'<span class="glyphicon glyphicon-bookmark"></span>' +
					'</button>' + 
				'</div>' + 
			'</div><div class="row">' +
			
			// dane zakładki
			
			'</div></div>');
			
			toolbar.find('.rotate-left').click(function(event){
									
				var rotate_iteration = page.data('rotate_iteration') ? page.data('rotate_iteration') : 0;
				rotate_iteration = (rotate_iteration-1) % 4;
				if( rotate_iteration<0 )
					rotate_iteration = 4 + rotate_iteration;
								
				page.data('rotate_iteration', rotate_iteration);
				
				var deg = 90 * rotate_iteration;
				page.css({
					transform: 'rotate(' + deg + 'deg)'
				});
				
				jQuery('.htmlexDoc .document').trigger('scale');
				
			});
			
			toolbar.find('.rotate-right').click(function(event){
									
				var rotate_iteration = page.data('rotate_iteration') ? page.data('rotate_iteration') : 0;
				rotate_iteration = (rotate_iteration+1) % 4;
				if( rotate_iteration<0 )
					rotate_iteration = 4 + rotate_iteration;
								
				page.data('rotate_iteration', rotate_iteration);
				
				var deg = 90 * rotate_iteration;
				page.css({
					transform: 'rotate(' + deg + 'deg)'
				});	
				
				jQuery('.htmlexDoc .document').trigger('scale');			
				
			});
						
			width *= scale;
			
			toolbar.css({
				width: width + 'px'
			});
				
			page.before(toolbar).addClass('i').css({
				marginTop: '100px'
			});			
		
		});
		
	});

	/*
	function InsertMenu(pages) {
		clearInterval(interval);
		pages.each(function (page) {
			var idk = $(this).attr('id');
			var toolbar = '<div class="pagetoolbar hidden ' + idk + '">' +
				'<button type="button" class="btn tb-btn btn-primary check">' +
				'<span class="glyphicon glyphicon-unchecked side altcheckbox"></span>' +
				'</button>' +
				'<div class="btn-group">' +
				'<button type="button" class="btn btn-primary rotate-left" aria-label="rotate-left">' +
				'<i	class="fa fa-undo"></i>' +
				'</button>' +
				'<button type="button" class="btn btn-primary rotate-right" aria-label="rotate-right">' +
				'<i	class="fa fa-repeat"></i></button>' +
				'</div>' +
				'<button type="button" class="btn tb-btn btn-primary add-to-list" data-toggle="modal" data-target="#document_bookmark_modal">' +
				'<span class="glyphicon glyphicon-list"></span>' +
				'</button></div>'
			$(this).before(toolbar);
		});
		$('.canvas')
			.bind('mouseover', function () {
				$('.pagetoolbar').removeClass('hidden');
			})
			.bind('mouseenter', function () {
				$('.pagetoolbar').removeClass('hidden');
			})
			.bind('mouseleave', function () {
				$('.pagetoolbar').addClass('hidden');
			});


		$('.check').bind('click', function () {
			var icon = $(this).find('span');
			if (icon.hasClass('glyphicon-unchecked')) {
				icon.removeClass('glyphicon-unchecked');
				icon.addClass('glyphicon-check');
				$('.btn-counter').html(parseInt($('.btn-counter').html()) + 1);
			} else {
				icon.removeClass('glyphicon-check');
				icon.addClass('glyphicon-unchecked');
				$('.btn-counter').html(parseInt($('.btn-counter').html()) - 1);
				if ($('#checkbox-main').hasClass('glyphicon-check')) {
					$('#checkbox-main').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
				}

			}
		})

		$('.rotate-left').bind('click', function () {
			var img = $(this).parent('div').parent('div').next('.pf');
			var rot = img.attr('style');
			var toRot = 'rotate(-90deg)';
			if (rot == 'transform: rotate(-90deg);') {
				toRot = 'rotate(180deg)';
			} else if (rot == 'transform: rotate(180deg);') {
				toRot = 'rotate(90deg)';
			} else if (rot == 'transform: rotate(90deg);') {
				toRot = 'rotate(0deg)';
			}
			img.css('transform', toRot);
		});

		$('.rotate-right').bind('click', function () {
			var img = $(this).parent('div').parent('div').next('.pf');
			var rot = img.attr('style');
			var toRot = 'rotate(90deg)';
			if (rot == 'transform: rotate(-90deg);') {
				toRot = 'rotate(0deg)';
			} else if (rot == 'transform: rotate(180deg);') {
				toRot = 'rotate(-90deg)';
			} else if (rot == 'transform: rotate(90deg);') {
				toRot = 'rotate(180deg)';
			}
			img.css('transform', toRot);
		});

		$('.rotate-right-main').click(function () {
			var checked = $('.glyphicon-check');
			checked.each(function () {
				var img = $(this).parents('.pagetoolbar').next('.pf');
				var rot = img.attr('style');
				var toRot = 'rotate(90deg)';
				if (rot == 'transform: rotate(-90deg);') {
					toRot = 'rotate(0deg)';
				} else if (rot == 'transform: rotate(180deg);') {
					toRot = 'rotate(-90deg)';
				} else if (rot == 'transform: rotate(90deg);') {
					toRot = 'rotate(180deg)';
				}
				img.css('transform', toRot);
			});
		});

		$('.rotate-left-main').click(function () {
			var checked = $('.glyphicon-check');
			checked.each(function () {
				var img = $(this).parents('.pagetoolbar').next('.pf');
				var rot = img.attr('style');
				var toRot = 'rotate(-90deg)';
				if (rot == 'transform: rotate(-90deg);') {
					toRot = 'rotate(180deg)';
				} else if (rot == 'transform: rotate(180deg);') {
					toRot = 'rotate(90deg)';
				} else if (rot == 'transform: rotate(90deg);') {
					toRot = 'rotate(0deg)';
				}
				img.css('transform', toRot);
			});
		});

		$('.add-to-list').click(function () {
			id = $(this).parent('div').next('.pf').attr('id');
			if ($('.spistresci').find('.' + id + '').length > 0) {
				var title = $('.spistresci').find('.' + id + '').html();
				console.log(title);
				$('.bookmark-title').val('' + title + '');
			}else{
				$('.bookmark-title').val('');
			}
		});

		$('#bookmark-save-btn').click(function () {
			var tytul = $('.bookmark-title').val();
			$('.spistresci').append('<li><a href="#' + id + '" class="' + id + '">' + tytul + '</a></li>');
			$('#document_bookmark_modal').modal('hide');
			$('.bookmark-title').val('');
			$('.bookmark-desc').val('');
		});

		$('.cancel-modal').click(function () {
			$('.bookmark-title').val('');
			$('.bookmark-desc').val('');
		});

		$('.modal').on('shown.bs.modal', function () {
			$(this).find('input:text:visible:first').focus();
		})

	}

	function CheckAll() {
		var checkBoxes = $(".altcheckbox");
		checkBoxes.removeClass('glyphicon-unchecked');
		checkBoxes.addClass('glyphicon-check');
		$('.btn-counter').html(checkBoxes.length - 1);
	}

	function UncheckAll() {
		var checkBoxes = $(".altcheckbox");
		checkBoxes.removeClass('glyphicon-check');
		checkBoxes.addClass('glyphicon-unchecked');
		$('.btn-counter').html('0');
	}

	$('.check-main').click(function () {
		if ($('#checkbox-main').hasClass('glyphicon-unchecked')) {
			CheckAll();
		} else {
			UncheckAll();
		}
	});
	
	
	*/
	
});
