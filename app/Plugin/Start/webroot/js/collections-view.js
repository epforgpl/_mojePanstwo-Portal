
$(document).ready(function() {

	var obj = $('.collectionObjects'),
		checkboxes = obj.find('input[type=checkbox].browserContentCheckbox'),
		deleteBtn = $('.deleteBtn').first(),
		checked = 0,
		id = obj.data('collection-id');

	checkboxes
		.each(function() {
			$(this).prop('checked', false);
		})
		.change(function() {
			if($(this).is(':checked')) {
				checked++;
				if(deleteBtn.hasClass('hide'))
					deleteBtn.removeClass('hide');
			} else {
				checked--;
				if(checked == 0)
					deleteBtn.addClass('hide');
			}
		});

	deleteBtn.click(function() {
		var ids = [];
		checkboxes
			.each(function() {
				if($(this).is(':checked')) {
					ids.push(
						$(this).val()
					);
				}
			});

		if(
			ids.length &&
			confirm('Czy na pewno chcesz usunąć ' + ids.length + ' dokument/ów z tej kolekcji?')
		) {
			$.post('', {
				ids: ids
			}, function() {
				window.location = '';
			});
		}
	});

});
