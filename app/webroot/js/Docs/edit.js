/**
 * Created by tomaszdrazewski on 12/08/15.
 */

$(document).ready(function () {

	var doc = jQuery('.htmlexDoc .document');
	var id;

	doc.on('init', function (event) {

		var canvas = doc.find('.canvas');
		canvas.find('.pf:not(".i")').each(function () {

			var page = $(this);
			id = page.attr('id');
			var width = page.outerWidth();
			var marginTop = page.css('marginTop');

			var scale = page.attr('style').match(/scale\([0-9].?[0-9]*\)/)[0].match(/[0-9].?[0-9]*/)[0]; // pobieramy rzeczywistą wartość z .pf

			console.log('initializing page', page, width);

			var toolbar = $('<div class="pagetoolbar ' + id + '">' +
			'<div class="row"><div class="pull-left">' +
			'<input type="checkbox" class="input-checkbox">' +
			'<div class="btn-group">' +
			'<button type="button" class="btn btn-sm rotate-left" aria-label="rotate-left">' +
			'<i	class="fa fa-undo"></i>' +
			'</button>' +
			'<button type="button" class="btn btn-sm rotate-right" aria-label="rotate-right">' +
			'<i	class="fa fa-repeat"></i>' +
			'</button>' +
			'</div></div><div class="pull-right">' +
			'<button type="button" class="btn tb-btn btn-sm add-to-list" data-toggle="modal" data-target="#document_bookmark_modal">' +
			'<span class="glyphicon glyphicon-bookmark"></span>' +
			'</button>' +
			'</div>' +
			'</div><div class="row"><div class="pull-center">' +
			'<div class="tytul_zakladki text-center ' + id + '"></div>' +
			'<div class="opis_zakladki text-center ' + id + '"></div>' +
			'</div></div>' +
			'</div>');

			toolbar.find('.rotate-left').click(function (event) {

				var rotate_iteration = page.data('rotate_iteration') ? page.data('rotate_iteration') : 0;
				rotate_iteration = (rotate_iteration - 1) % 4;
				if (rotate_iteration < 0)
					rotate_iteration = 4 + rotate_iteration;

				page.data('rotate_iteration', rotate_iteration);

				var deg = 90 * rotate_iteration;

				page.css({
					transform: 'rotate(' + deg + 'deg)'
				}).removeClass('rescaled');

				jQuery('.htmlexDoc .document').trigger('scale');

				if (page.data('rotate_iteration') != 0) {
					page.addClass('rotated');
				} else {
					page.removeClass('rotated');
				}

			});

			toolbar.find('.rotate-right').click(function (event) {

				var rotate_iteration = page.data('rotate_iteration') ? page.data('rotate_iteration') : 0;
				rotate_iteration = (rotate_iteration + 1) % 4;
				if (rotate_iteration < 0)
					rotate_iteration = 4 + rotate_iteration;

				page.data('rotate_iteration', rotate_iteration);

				var deg = 90 * rotate_iteration;
				page.css({
					transform: 'rotate(' + deg + 'deg)'
				}).removeClass('rescaled');

				jQuery('.htmlexDoc .document').trigger('scale');

				if (page.data('rotate_iteration') != 0) {
					page.addClass('rotated');
				} else {
					page.removeClass('rotated');
				}

			});

			width *= scale;

			toolbar.css({
				width: width + 'px'
			});

			page.before(toolbar).addClass('i');

			toolbar.find('.input-checkbox').click(function () {
				if ($(this).is(':checked')) {
					$('.checked-counter').html(parseInt($('.checked-counter').html()) + 1);
					console.log()
					if ($('.checked-counter').html() == $('.input-checkbox').length) {
						$('#checkbox-main').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
					}
				} else {
					$('.checked-counter').html(parseInt($('.checked-counter').html()) - 1);
					if ($('#checkbox-main').hasClass('glyphicon-check')) {
						$('#checkbox-main').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
					}
				}
			});
			toolbar.find('.add-to-list').click(function () {
				id = page.attr('id');
				if ($('.spistresci').find('.' + id + '').length > 0) {
					var title = $('.spistresci').find('.' + id + '').html();
					$('.bookmark-title').val('' + title + '');
					$('.bookmark-desc').val($('.' + id + '').find('.opis_zakladki').html());
				} else {
					$('.bookmark-title').val('');
					$('.bookmark-desc').val('');
				}
			});

		});

	});

	$('.rotate-right-main').click(function () {
		var checked = $('.input-checkbox:checked');
		checked.each(function () {
			var page = $(this).parents('.pagetoolbar').next('.pf');
			var rotate_iteration = page.data('rotate_iteration') ? page.data('rotate_iteration') : 0;
			rotate_iteration = (rotate_iteration + 1) % 4;
			if (rotate_iteration < 0)
				rotate_iteration = 4 + rotate_iteration;

			page.data('rotate_iteration', rotate_iteration);

			var deg = 90 * rotate_iteration;
			page.css({
				transform: 'rotate(' + deg + 'deg)'
			}).removeClass('rescaled');

			jQuery('.htmlexDoc .document').trigger('scale');

			if (page.data('rotate_iteration') != 0) {
				page.addClass('rotated');
			} else {
				page.removeClass('rotated');
			}
		});
	});

	$('.rotate-left-main').click(function () {
		var checked = $('.input-checkbox:checked');
		checked.each(function () {
			var page = $(this).parents('.pagetoolbar').next('.pf');
			var rotate_iteration = page.data('rotate_iteration') ? page.data('rotate_iteration') : 0;
			rotate_iteration = (rotate_iteration - 1) % 4;
			if (rotate_iteration < 0)
				rotate_iteration = 4 + rotate_iteration;

			page.data('rotate_iteration', rotate_iteration);

			var deg = 90 * rotate_iteration;
			page.css({
				transform: 'rotate(' + deg + 'deg)'
			}).removeClass('rescaled');

			jQuery('.htmlexDoc .document').trigger('scale');

			if (page.data('rotate_iteration') != 0) {
				page.addClass('rotated');
			} else {
				page.removeClass('rotated');
			}
		});
	});

	$('.check-main').click(function () {
		var checkBoxes = $('.input-checkbox');
		var btn = $('#checkbox-main');
		if (btn.hasClass('glyphicon-unchecked')) {
			checkBoxes.prop('checked', true);
			$('.checked-counter').html(checkBoxes.length);
			btn.removeClass('glyphicon-unchecked');
			btn.addClass('glyphicon-check');
		} else {
			checkBoxes.prop('checked', false);
			$('.checked-counter').html('0');
			btn.removeClass('glyphicon-check');
			btn.addClass('glyphicon-unchecked');
		}
	});

	$('.cancel-modal').click(function () {
		$('.bookmark-title').val('');
		$('.bookmark-desc').val('');
	});

	$('.modal').on('shown.bs.modal', function () {
		$(this).find('input:text:visible:first').focus();
	});

	$('#bookmark-save-btn').click(function () {

		var tytul = $('.bookmark-title').val();
		var opis = $('.bookmark-desc').val();
		if ($('.spistresci').find('.' + id + '').length > 0) {
			$('.spistresci').find('.' + id + '').html(tytul);
		} else {
			$('.spistresci').append('<li><a href="#' + id + '" class="' + id + '">' + tytul + '</a></li>');
		}
		var items = $('.' + id + '');
		items.find('.opis_zakladki').html(opis);
		items.find('.tytul_zakladki').html(tytul);
		var tool = $('.' + id + '.pagetoolbar');
		tool.addClass('bookmarked');

		tool.css('margin-bottom', tool.find('.pull-center').outerHeight());


		$('.bookmark-counter').html(parseInt($('.bookmark-counter').html()) + 1)
		$('#document_bookmark_modal').modal('hide');
		$('.bookmark-title').val('');
		$('.bookmark-desc').val('');
	});


	$('.save-doc').click(function () {
		var doc_id = $('.htmlexDoc').attr('data-document-id');
		var data = {
			'document_id': doc_id,
			'pages': [],
			'bookmarks': []
		};
		$('.rotated').each(function () {
			var numer_strony = $(this).attr('data-page-no');

			var rotacja = $(this).data('rotate_iteration');
			if (numer_strony === 0) {
				return true;
			} else {
				var dane = {
					'numer': numer_strony,
					'rotate': rotacja
				};
				data['pages'].push(dane);
			}
		});
		$('.bookmarked').each(function () {

			var tytul = $(this).find('.tytul_zakladki').html();
			var opis = $(this).find('.opis_zakladki').html();
			var numer_strony = $(this).next('.pf').attr('data-page-no');

			if (numer_strony === 0) {
				return true;
			} else {
				var dane = {
					'strona_numer': numer_strony,
					'tytul': tytul,
					'opis': opis
				};
				data['bookmarks'].push(dane);
			}
		});

		$.ajax({
			url: "/docs/" + doc_id + ".json",
			method: "post",
			data: data,
			async: false,
			success: function (res) {
				if (res == false) {
					alert("Wystąpił błąd");
				} else {
					window.location.href = "docs/" + doc_id + "";
				}
			},
			error: function (xhr) {
				alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
			}
		});
	});

	$('.cancel-chagnes').click(function () {
		var doc_id = $('.htmlexDoc').attr('data-document-id');
		window.location.href = "docs/" + doc_id + "";
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
	 $('.checked-counter').html(parseInt($('.checked-counter').html()) + 1);
	 } else {
	 icon.removeClass('glyphicon-check');
	 icon.addClass('glyphicon-unchecked');
	 $('.checked-counter').html(parseInt($('.checked-counter').html()) - 1);
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
	 $('.checked-counter').html(checkBoxes.length - 1);
	 }

	 function UncheckAll() {
	 var checkBoxes = $(".altcheckbox");
	 checkBoxes.removeClass('glyphicon-check');
	 checkBoxes.addClass('glyphicon-unchecked');
	 $('.checked-counter').html('0');
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
