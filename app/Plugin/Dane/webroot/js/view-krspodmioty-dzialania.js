/*global $,JQuery, mPHeart, google, tinymce*/
var googleMap,
	geolocalizateMe,
	markers = [];

function initialize() {
	var polandLatlng = new google.maps.LatLng(51.919438, 19.145136),
		mapOptions = {
			zoom: 6,
			center: polandLatlng
		},
		markerImage = {
			url: 'http://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png',
			size: new google.maps.Size(71, 71),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(17, 34),
			scaledSize: new google.maps.Size(25, 25)
		};

	googleMap = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

	google.maps.event.addListenerOnce(googleMap, 'idle', function () {
		$('.googleMapElement').addClass('loaded');
		$('#loc').css({
			left: $('#pac-input').position().left + $('#pac-input').outerWidth() - 10
		});
	});


	google.maps.event.addListener(googleMap, "click", function (event) {
		clearMarkers();
		markers = [];

		var marker = new google.maps.Marker({
			map: googleMap,
			icon: markerImage,
			position: event.latLng
		});

		markers.push(marker);
	});

	var input = document.getElementById('pac-input');
	googleMap.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	var searchBox = new google.maps.places.SearchBox(input);
	google.maps.event.addListener(searchBox, 'places_changed', function () {
		var places = searchBox.getPlaces();

		if (places.length === 0) {
			return;
		}
		for (var i = 0, marker; marker = markers[i]; i++) {
			marker.setMap(null);
		}

		clearMarkers();
		markers = [];

		var bounds = new google.maps.LatLngBounds();
		for (var i = 0, place; place = places[i]; i++) {
			var marker = new google.maps.Marker({
				map: googleMap,
				icon: markerImage,
				title: place.name,
				position: place.geometry.location
			});

			markers.push(marker);
			bounds.extend(place.geometry.location);
		}
		googleMap.fitBounds(bounds);
	});

	var googleMapBlock = $('.googleMapElement'),
		lat = parseFloat(googleMapBlock.find('input[name="geo_lat"]').val()),
		lng = parseFloat(googleMapBlock.find('input[name="geo_lng"]').val());

	if (lat > 0 && lng > 0) {
		clearMarkers();
		markers = [];

		var marker = new google.maps.Marker({
			map: googleMap,
			icon: markerImage,
			position: {lat: lat, lng: lng}
		});

		markers.push(marker);
	}

	google.maps.event.addListener(googleMap, 'bounds_changed', function () {
		var bounds = googleMap.getBounds();
		searchBox.setBounds(bounds);
	});

	geolocalizateMe = function () {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function (position) {
				var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

				clearMarkers();
				markers = [];

				var bounds = new google.maps.LatLngBounds();
				var marker = new google.maps.Marker({
					map: googleMap,
					icon: markerImage,
					position: pos
				});

				markers.push(marker);

				bounds.extend(pos);
				googleMap.fitBounds(bounds);
			}, function () {
				handleNoGeolocation(true);
			});
		} else {
			// Browser doesn't support Geolocation
			handleNoGeolocation(false);
		}

		function handleNoGeolocation(errorFlag) {
			var content = '';

			if (errorFlag) {
				content = 'Błąd: System geolokalizacji nie odpowiada.';
			} else {
				content = 'Błąd: Twoja przeglądarka nie wspiera geolokalizacji.';
			}

			var options = {
				map: googleMap,
				position: polandLatlng,
				content: content,
				zoom: 6
			};

			var infowindow = new google.maps.InfoWindow(options);
			googleMap.setCenter(options.position);
		}
	};

	$('.googleRemoveBtn').click(function () {
		clearMarkers();
	});
}

function clearMarkers() {
	for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(null);
	}
}


//ASYNC INIT GOOGLE MAP JS//
function loadScript() {
	if ((typeof google !== "undefined") && google.maps) {
		initialize();
	} else {
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.src = 'https://maps.googleapis.com/maps/api/js?v=3.21&sensor=false&language=' + mPHeart.language.twoPerThreeDig + '&libraries=places&callback=initialize';
		document.body.appendChild(script);
	}
}

$(document).ready(function () {
	var objectMain = $('.objectMain'),
		form = $('form.dzialanie'),
		imageEditor = objectMain.find('.image-editor'),
		googleLocMeBtn = $('#loc'),
		googleMapBlock = $('.googleMapElement'),
		header = $('.appHeader.dataobject').first(),
		dataset = header.attr('data-dataset'),
		object_id = header.attr('data-object_id'),
		opis = $('#dzialanieOpis');

	tinymce.init({
		language: 'pl',
		plugins: "media image link code paste",
		paste_auto_cleanup_on_paste : true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		paste_as_text: true,
		menubar: "edit format insert tools",
		statusbar: false,
		inline_styles: false,
		selector: "textarea.tinymce",
		content_css: [
			"/libs/bootstrap/3.3.4/css/bootstrap.min.css",
			"/css/main.css"
		],
		valid_elements: "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
		+ "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
		+ "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
		+ "name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,"
		+ "#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
		+ "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
		+ "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
		+ "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
		+ "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
		+ "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
		+ "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
		+ "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
		+ "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
		+ "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
		+ "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
		+ "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
		+ "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
		+ "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
		+ "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
		+ "q[cite],samp,select[disabled|multiple|name|size],small,"
		+ "textarea[cols|rows|disabled|name|readonly],tt,var,big,"
		+ "iframe[src|title|width|height|allowfullscreen|frameborder]"
	});

	cropItErrorMsg = function (error) {
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
			);
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

	googleLocMeBtn.click(function () {
		geolocalizateMe();
	});

	$('.deleteBtn').click(function () {
		form.append('<input type="hidden" name="deleted" value="1"/>');
		form.submit();
	});

	form.submit(function () {
		if (typeof imageEditor.cropit('zoom') !== "undefined") {
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
						.attr('name', v == 'imageSrc' ? 'cover_photo' : v)
						.attr('value', imageEditor.cropit(v))
						.appendTo(form);

				}
			}
		}

		if (markers.length) {
			googleMapBlock.find('input[name="geo_lat"]').val(markers[0].getPosition().lat());
			googleMapBlock.find('input[name="geo_lng"]').val(markers[0].getPosition().lng());
		}

		tinyMCE.triggerSave();

		var content = $(this).find('#dzialanieOpis').val();

		if (content.length > 16383) {
			alert("Opis jest za długi. (maksymalnie 16383 znaków, twój opis ma " + content.length + " znaków)");
			return false;
		}

		if ($('input[name="deleted"]').length === 0) {
			$(this)
				.find('.submitBtn')
				.addClass('loading disabled');
		}
	});

	$('.cancelBtn').click(function () {
		window.location = '/dane/' + dataset + '/' + object_id;
	});

	/* Tags autocomplete input */
	$(function () {

		var elements = $('.tags input.tagit');
		for (var i = 0; i < elements.length; i++) {

			var el = $(elements[i]);

			el.tagit({
				allowSpaces: true,
				removeConfirmation: true,
				beforeTagAdded: function (event, ui) {

					if (ui.duringInitialization)
						return false;

					return (ui.tagLabel.length >= 2);
				},
				autocomplete: {
					source: function (request, response) {
						$.getJSON("/dane/suggest.json?q=" + request.term + "&dataset[]=tematy", function (res) {
							var data = [];
							for (var i = 0; i < res.options.length; i++)
								data.push(res.options[i].text);

							response(data);
						});
					},
					minLength: 1
				}
			}).tagit('removeAll');

			var data = el.data('value');
			if (data && data.length) {
				for (var j = 0; j < data.length; j++) {
					el.tagit('createTag', data[j]);
				}
			}

		}
	});

	$('.sticky').sticky();

	$('.activitiesResponse').each(function () {
		var form = $(this),
			url = $(this).data('url'),
			dropzone = form.find('.dropzoneForm').first(),
			DropZone,
			btn = form.find('.btn-addfile').first();

		DropZone = new Dropzone(dropzone[0], {
			url: url,
			init: function () {
				var self = this;
				self.on('success', function (file, response) {
					if (
						response === true || (
							typeof response.response !== 'undefined' &&
							response.response === true
						)
					) {
						$(file.previewElement)
							.find('.progress-bar')
							.first()
							.addClass('progress-bar-success')
							.removeClass('active');
					}
				});

				self.on('error', function (file, response) {
					$(file.previewElement)
						.find('.progress-bar')
						.first()
						.addClass('progress-bar-danger')
						.removeClass('active');
				});
			},
			clickable: '.btn-addfile',
			createImageThumbnails: false,
			acceptedFiles: '.pdf,.docx,.doc,.tif,.html,.jpg,.xml,.xls,.xlsx,.rtf,.png',
			autoQueue: true,
			autoProcessQueue: true,
			previewsContainer: '#preview',
			previewTemplate: [
				'<div class="file">',
				'<div class="title">',
				'<span class="name" data-dz-name></span>',
				'<span class="size" data-dz-size></span>',
				'<span class="error text-danger" data-dz-errormessage></span>',
				'</div>',
				'<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">',
				'<div class="progress-bar" style="width:0%;" data-dz-uploadprogress>',
				'</div>',
				'</div>',
				'<div class="buttons">',
				'</div>',
				'</div>'
			].join('')
		});

	});

	/*ASYNCHRONIZE ACTION FOR GOOGLE MAP*/
	window.onload = loadScript();
});
