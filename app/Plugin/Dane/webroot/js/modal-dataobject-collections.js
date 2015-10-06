
$(document).ready(function() {

	var ManageAsComponent = function($this) {
		this.$this = $this;
		this.create();
	};

	ManageAsComponent.prototype = {

		constructor: ManageAsComponent,
		objects: null,

		create: function() {
			var _this = this, h = [
				'<span>',
					'Zarządzaj jako ',
				'</span>',
				'<select class="form-control">',
					'<option>',
						mPHeart.username,
					'</option>'
			];

			this.getObjects(function() {

				_this.objects.forEach(function(obj) {
					h.push([
						'<option>',
							obj.objects.slug,
						'</option>'
					].join(''));
				});
				h.push('</select>');

				_this.$this.html(
					h.join('')
				);

				_this.$this.find('select').change(function() {
					console.log($(this));
				});

			});
		},

		getObjects: function(onSuccess) {
			var _this = this;
			if(this.objects != null) {
				onSuccess();
			} else {
				$.get('/dane/getUserObjects.json', function(res) {
					if(res.response) {
						_this.objects = res.response;
						onSuccess();
					}
				});
			}
		}

	};

	var modal = $('#collectionsModal'),
		name = $('#collectionName'),
		header = $('.appHeader.dataobject').first(),
		id = header.data('global-id'),
		title = modal.data('object-title'),
		manageAs = 'user',
		data = [],
		list = modal.find('.list-group').first(),
		loading = false,
		spinner = '<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
		nameStr = '';

	modal.on('shown.bs.modal', function() {

		nameStr = '';
		name.val(nameStr).focus();

		reloadData(function() {
			updateList();
		});

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
			h.push('<button type="button" class="list-group-item new-collection"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Utwórz kolekcję: <b>' + nameStr + '</b></button>');
		}

		if(data.length) {
			for(var i in data) {
				if(data.hasOwnProperty(i)) {
					var row = data[i].Collection;
					if(nameStr.length === 0 || (nameStr.length && row.name.toLowerCase().indexOf(nameStr.toLowerCase()) > -1)) {
						h.push('<button type="button" data-collection-id="' + row.id + '" class="list-group-item ' + (typeof data[i].CollectionObject != 'undefined' && typeof data[i].CollectionObject.object_id == 'string' ? 'checked' : 'unchecked') + '"><i class="glyphicon glyphicon-ok" aria-hidden="true"></i><i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i> ' + row.name + '<span class="belongs">' + (typeof data[i].Object != 'undefined' && typeof data[i].Object.slug == 'string' ? data[i].Object.slug : mPHeart.username.toLowerCase()) + '</span></button>');
					}
				}
			}
		} else {
			h.push('<button type="button" class="list-group-item empty">Nie posiadasz jeszcze żadnej kolekcji</button>');
		}

		list.html(h.join(''));

		$('button.unchecked').click(function() {
			var collection = $(this).data('collection-id');
			$.get('/collections/collections/addObject/' + collection + '/' + id + '.json', function(res) {
				for(var d in data) {
					if(data.hasOwnProperty(d)) {
						var row = data[d];
						if(typeof row.Collection != 'undefined' && row.Collection.id == collection) {
							data[d].CollectionObject = {
								object_id: id.toString()
							};
							updateList();
							return false;
						}
					}
				}
			});
		});

		$('button.checked')
			.hover(function() {
				$(this).find('i')
					.first()
					.removeClass('glyphicon-ok')
					.addClass('glyphicon-remove');
			}, function() {
				$(this).find('i')
					.first()
					.removeClass('glyphicon-remove')
					.addClass('glyphicon-ok');
			})
			.click(function() {
				var collection = $(this).data('collection-id');
				$.get('/collections/collections/removeObject/' + collection + '/' + id + '.json', function(res) {
					for(var d in data) {
						if(data.hasOwnProperty(d)) {
							var row = data[d];
							if(typeof row.Collection != 'undefined' && row.Collection.id == collection) {
								data[d].CollectionObject = {
									object_id: null
								};
								updateList();
								return false;
							}
						}
					}
				});
			});

		$('button.new-collection').click(function() {
			//list.html(spinner);
			loading = true;
			$.post('/collections/collections/create.json', {
				name: nameStr
			}, function(res) {
				if(typeof res.response.Collection != 'undefined') {
					data.unshift(res.response);
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

	$('.ManageAsComponent').each(function() {
		new ManageAsComponent(
			$(this)
		);
	});

});
