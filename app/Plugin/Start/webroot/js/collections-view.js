
$(document).ready(function() {

	var obj = $('.collectionObjects'),
		checkboxes = obj.find('input[type=checkbox].browserContentCheckbox'),
		btnRemove = $('.btnRemove').first(),
		nav = $('ul.nav.dataAggsDropdownList').first(),
		counterSpan = $('.dataAggsDropdownList .dataCounter span').first(),
		checked = 0,
		id = obj.data('collection-id');

	checkboxes
		.each(function() {
			$(this).prop('checked', false);
		})
		.change(function() {
			if($(this).is(':checked')) {
				checked++;
			} else {
				checked--;
			}

			if(checked > 0) {
				counterSpan.html('Zaznaczono ' + checked + ' z ' + checkboxes.length + ' dokumentów');

				if(!nav.find('.deleteBtn').length) {
					nav.append('<li class="deleteBtn"><button data-tooltip="true" data-original-title="Usuń zaznaczone" data-placement="right" class="btn btn-default btn" type="submit"><i class="glyphicon glyphicon-trash" title="Usuń zaznaczone" aria-hidden="true"></i></button></li>');

					$('[data-tooltip="true"]').tooltip({
						delay: {
							hide: 1
						}
					});
				}

				nav.find('.deleteBtn').click(function() {
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

			} else {
				if(nav.find('.deleteBtn').length)
					nav.find('.deleteBtn').first().remove();

				counterSpan.html(checkboxes.length + ' dokumentów');
			}
		});

	btnRemove.click(function() {
		if(!confirm('Czy na pewno chcesz usunać tą kolekcje?'))
			return false;
	});

});
