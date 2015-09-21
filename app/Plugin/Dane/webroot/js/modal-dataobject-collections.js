
$(document).ready(function() {

	var modal = $('#collectionsModal'),
		name = $('#collectionName'),
		list = modal.find('.list-group').first(),
		nameStr = null;

	name.val(null);

	function updateList() {
		var h = [];
		if(nameStr.length)
			h.push('<button type="button" class="list-group-item new-collection"><i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i> Utwórz kolekcję: <b>' + nameStr + '</b></button>');

		list.html(h.join(''));
	}

	name.keyup(function() {
		nameStr = $(this).val();
		updateList();
	});

});
