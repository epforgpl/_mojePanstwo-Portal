
$(document).ready(function() {

	var modal = $('#collectionsModal'),
		name = $('#collectionName'),
		header = $('.appHeader.dataobject').first(),
		id = header.data('global-id'),
		data = [],
		list = modal.find('.list-group').first(),
		loading = false,
		spinner = '<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
		nameStr = '';

	modal.on('shown.bs.modal', function() {

		name.val(nameStr).focus();

		if(data.length == 0) {
			reloadData(function() {
				updateList();
			});
		} else
			updateList();

	});

	function reloadData(onSuccess) {
		loading = true;
		list.html(spinner);

		$.get('/collections/collections/get/' + id + '.json', function(res) {
			if(typeof res.response != 'undefined') {
				loading = false;
				data = res.response;
				onSuccess();
			} else
				alert('Wystąpił błąd');
		});
	}

	function updateList() {
		if(loading)
			return false;

		var h = [];
		if(nameStr.length) {
			h.push('<button type="button" class="list-group-item new-collection"><i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i> Utwórz kolekcję: <b>' + nameStr + '</b></button>');
		}

		if(data.length) {
			for(var i in data) {
				if(data.hasOwnProperty(i)) {
					var row = data[i].Collection;
					if(nameStr.length === 0 || (nameStr.length && row.name.toLowerCase().indexOf(nameStr.toLowerCase()) > -1)) {
						h.push('<button type="button" data-collection-id="' + row.id + '" class="list-group-item ' + (typeof data[i].CollectionObject != 'undefined' && typeof data[i].CollectionObject.object_id == 'string' ? 'checked' : 'unchecked') + '"><i class="glyphicon glyphicon-ok" aria-hidden="true"></i> ' + row.name + '</button>');
					}
				}
			}
		} else {
			h.push('<button type="button" class="list-group-item">Nie posiadasz jeszcze żadnej kolekcji</button>');
		}

		list.html(h.join(''));

		$('button.unchecked').click(function() {
			var collection = $(this).data('collection-id');
			$.get('/collections/collections/addObject/' + collection + '/' + id + '.json', function(res) {
				reloadData(function() {
					updateList();
				});
			});
		});

		$('button.checked').click(function() {
			var collection = $(this).data('collection-id');
			$.get('/collections/collections/removeObject/' + collection + '/' + id + '.json', function(res) {
				reloadData(function() {
					updateList();
				});
			});
		});

		$('button.new-collection').click(function() {
			list.html(spinner);
			loading = true;
			$.post('/collections/collections/create.json', {
				name: nameStr
			}, function(res) {
				if(typeof res.response.Collection != 'undefined') {
					data.push(res.response);
				} else if(typeof res.response.name != 'undefined') {
					alert(res.response.name[0]);
				} else
					alert('Wystąpił błąd');

				nameStr = '';
				name.val(nameStr).focus();
				loading = false;
				updateList();
			});
		});
	}

	name.keyup(function() {
		nameStr = $(this).val().trim();
		updateList();
	});

});
