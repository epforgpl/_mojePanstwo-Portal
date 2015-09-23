
$(document).ready(function() {

	var form = $('form.collectionsForm'),
		imageEditor = form.find('.image-editor'),
		imageAlert = form.find('.alert.alert-danger'),
		imageChoosed = form.find('input[name="cover_photo"]');

	var cropItErrorMsg = function (error) {
		var alert = el.find('.alert.alert-danger');

		if (mPHeart.language.twoDig == 'pl') {
			if (error.code === 0) {
				error.message = 'Błąd ładowowania zdjęcia - proszę spróbować inne.'
			} else if (error.code === 1) {
				error.message = 'Zdjęcie nie spełnia zalecanej wielkości (min. 810x320px).'
			}
		}

		if (alert.length) {
			alert.text(error.message);
		} else {
			$('.image-editor:visible').parent('.form-group').prepend(
				$('<div></div>').addClass('alert alert-danger').text(error.message).slideDown()
			)
		}
	};

	if (imageEditor.length) {
		var imageWidth = 810,
			imageHeight = 320,
			imgEditorWidth = imageEditor.width(),
			imgEditorHeight = imageHeight * (imageEditor.width() / imageWidth),
			exportZoom = imageWidth / imageEditor.width(),
			src = imageEditor.attr('data-image');

		imageEditor.css({'width': imgEditorWidth, height: imgEditorHeight}).cropit({
			imageState: {
				src: (src !== "") ? src : ''
			},
			smallImage: 'allow',
			width: imgEditorWidth,
			height: imgEditorHeight,
			exportZoom: exportZoom,
			onImageLoaded: function () {
				imageEditor.find('.alert').slideUp("normal", function () {
					$(this).remove();
				});
			},
			onFileReaderError: function (evt) {
				cropItErrorMsg(evt);
			},
			onImageError: function (evt) {
				cropItErrorMsg(evt);
			}
		});
	}

	form.submit(function() {
		if(typeof imageEditor.cropit('zoom') !== "undefined") {
			var cropitFields = ['imageSrc', 'offset', 'zoom'];
			for (var m = 0; m < cropitFields.length; m++) {
				var v = cropitFields[m];
				if (v == 'offset') {

					$('<input />').attr('type', 'hidden')
						.attr('name', "x")
						.attr('value', imageEditor.cropit(v).x)
						.appendTo(form);

					$('<input />').attr('type', 'hidden')
						.attr('name', "y")
						.attr('value', imageEditor.cropit(v).y)
						.appendTo(form);

				} else {

					$('<input />').attr('type', 'hidden')
						.attr('name', v == 'imageSrc' ? 'image' : v)
						.attr('value', imageEditor.cropit(v))
						.appendTo(form);

				}
			}
		}
	});

});
