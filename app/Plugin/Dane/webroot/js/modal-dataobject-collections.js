
$(document).ready(function() {

	var modal = $('#collectionsModal'),
		name = $('#collectionName'),
		data = [],
		list = modal.find('.list-group').first(),
		loading = false,
		spinner = '<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
		nameStr = '';

	modal.on('shown.bs.modal', function() {

		name.val(nameStr).focus();

		if(data.length == 0) {
			loading = true;
			list.html(spinner);

			$.get('/collections/collections/get.json', function(res) {
				if(typeof res.response != 'undefined') {
					loading = false;
					data = res.response;
					updateList();
				} else
					alert('Wystąpił błąd');
			});

		} else
			updateList();

	});

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
						h.push('<button type="button" class="list-group-item">' + row.name + '</button>');
					}
				}
			}
		} else {
			h.push('<button type="button" class="list-group-item">Nie posiadasz jeszcze żadnej kolekcji</button>');
		}

		list.html(h.join(''));

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
