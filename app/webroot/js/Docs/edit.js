/**
 * Created by tomaszdrazewski on 12/08/15.
 */

$(document).ready(function () {

	var interval;

	function InsertMenu(pages) {
		clearInterval(interval);
		pages.each(function (page) {
			var id = $(this).attr('id');
			var toolbar = '<div class="pagetoolbar hidden ' + id + '">' +
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
			/*$(this)
			 .bind('mouseenter', function () {
			 $(this).parent().find('.'+id+'').removeClass('hidden');
			 })
			 .bind('mouseleave', function () {
			 $(this).parent().find('.'+id+'').addClass('hidden');
			 });*/
		});
		$('.canvas')
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
				$('.btn-counter').html(parseInt($('.btn-counter').html())+1);
			} else {
				icon.removeClass('glyphicon-check');
				icon.addClass('glyphicon-unchecked');
				$('.btn-counter').html(parseInt($('.btn-counter').html())-1);
				if($('#checkbox-main').hasClass('glyphicon-check')){
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

		$('.add-to-list').click(function(){
			var id=$(this).parent('div').next('.pf').attr('id');
			$('.spistresci').append('<li><a href="#'+id+'">'+id+'</a></li>')

		});
	}

	function CheckAll() {
		var checkBoxes = $(".altcheckbox");
		checkBoxes.removeClass('glyphicon-unchecked');
		checkBoxes.addClass('glyphicon-check');
		$('.btn-counter').html(checkBoxes.length-1);
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


	interval = setInterval(function () {
		var pages = $('.pf');
		if (pages.length > 0) {
			InsertMenu(pages);
		}
	}, 500);
});
