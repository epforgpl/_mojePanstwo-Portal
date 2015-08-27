/**
 * Created by tomaszdrazewski on 29/06/15.
 */
$(document).ready(function () {
	$("#new_temp_item").click(function () {
		$('#temp_item_opis_modal').modal('show');
	});
	var editor = $('#temp_item_opis_modal #editor');

	editor.wysihtml5.locale['pl-PL'].emphasis = {
		bold: "B",
		italic: "I",
		underline: "U"
	};

	editor.wysihtml5({
		toolbar: {
			"font-styles": true, //Font styling, e.g. h1, h2, etc.
			"emphasis": true, //Italics, bold, etc.
			"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers.
			"html": false, //Button which allows you to edit the generated HTML.
			"link": true, //Button to insert a link.
			"image": false, //Button to insert an image.
			"color": false, //Button to change color of font
			"blockquote": false
		},
		'locale': 'pl-PL',
		parser: function (html) {
			return html;
		}
	});

	$(".lista_wskz li")
		.bind('mouseenter', function () {
			$(this).find(".remove_btn").removeClass('hidden');
		})
		.bind('mouseleave', function () {
			$(this).find(".remove_btn").addClass('hidden');
		});

	$("#temp_item_savebtn").click(function () {
		$('#temp_item_opis_modal').modal('hide');
	});

});
