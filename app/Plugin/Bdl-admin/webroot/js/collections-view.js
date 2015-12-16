
$(document).ready(function() {

	var obj = $('.collectionObjects'),
		checkboxes = obj.find('input[type=checkbox].browserContentCheckbox'),
		btnRemove = $('.btnCollectionRemove').first(),
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

	var _helperDiv = $('<span />').text('M').appendTo('body'),
		_helperSize = _helperDiv.width();
	_helperDiv.detach();

	$('input.h1-editable').each(function() {
		$(this).change(function() {
			$.post('/collections/collections/edit/' + id + '.json', {
				name: $(this).val()
			}, function(res) {
				// @todo error handler
				console.log(res);
			});
		});
	});

	$('.note-editable').each(function() {

		var el = $(this),
			isEmpty = $(this).hasClass('empty'),
			content = $(this).find('.content').first();

		var cancel = function() {
			if(isEmpty) {
				el.html([
					'<p class="text-center">',
					'<a href="#addnote" class="btn btn-link create-note">Dodaj notatkę</a>',
					'</p>'
				].join(''));
			} else {
				if(confirm('Zmiany zostaną odrzucone. Jesteś pewny/a, że chcesz anulować edycję?')) {
					el.html([
                        '<div class="content">',
						content.html(),
						'</div>',
						'<button class="btn btn-sm pull-right btn-default btnNoteEdit btn" type="submit">',
						'Edytuj',
						'</button>'
					].join(''));
				} else
					return false;
			}
		};

		var save = function() {
			tinyMCE.triggerSave();
			var val = $('#noteContent').val();
			if(val.length == 0) {
				if(!isEmpty) {
					el.addClass('empty');
					isEmpty = true;
				}

				cancel();
			} else {
				if(isEmpty) {
					el.removeClass('empty');
					isEmpty = false;
				}

				el.html([
					'<button type="submit" data-tooltip="true" data-original-title="Edytuj" data-placement="bottom" class="btn btn-default btnNoteEdit btn"><i class="glyphicon glyphicon-edit" title="Edytuj notatkę" aria-hidden="true"></i></button>',
					'<div class="content">',
					val,
					'</div>'
				].join(''));
			}

			$.post('/collections/collections/edit/' + id + '.json', {
				name: $('input.h1-editable').val(),
				description: val
			}, function(res) {
				// @todo error handler
				console.log(res);
			});

			content = el.find('.content').first();
		};

		var create = function() {
			el.html([
				'<textarea id="noteContent">',
				!isEmpty ? content.html() : '',
				'</textarea>',
				'<div class="overflow-hidden">',
				'<button class="btn margin-top-10 pull-right auto-width btn-primary submitBtn" type="submit">',
				'Zapisz',
				'</button>',
				'<button class="btn margin-top-10 margin-sides-10 pull-right auto-width btn-default cancelBtn" type="submit">',
				'Anuluj',
				'</button>',
				'</div>',
			].join(''));
			tinymce.init({
				selector: "#noteContent",
				language : 'pl',
				plugins: "media image",
				menubar: false,
				statusbar : false,
				content_css: [
					"/libs/bootstrap/3.3.4/css/bootstrap.min.css",
					"/css/main.css"
				],
				valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
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
				+ "iframe[src|title|width|height|allowfullscreen|frameborder]",
				auto_focus: "noteContent"
			});

			el.find('textarea').focus();
		};

		$(this).on('click', '.submitBtn', function() {
			save();
			return false;
		});

		$(this).on('click', '.cancelBtn', function() {
			cancel();
			return false;
		});

		$(this).on('click', '.create-note', function() {
			create();
			return false;
		});

		$(this).on('click', '.btnNoteEdit', function() {
			create();
			return false;
		});
	});

	/* COLLECTION OBJECTS NOTES */

	var CollectionObjectNote = function(e) {
		var self = this;
		self.e = e;
		self.editor = false;
		self.btn = e.find('.editCollectionNote')[0];
		self.savePostAction = $(self.btn).data('save-post-action');
		self.note = e.find('.collections-note')[0];
		self.noteContent = self.getNoteContent();
		$(self.btn).click(function() {
			self.editNote();
		});
	};

	CollectionObjectNote.prototype = {
		constructor: CollectionObjectNote,

		editNote: function() {
			var self = this;
			if(self.editor) {
				$(self.note).find('textarea').focus();
				return false;
			}

			$(self.note).html([
				'<textarea class="form-control margin-bottom-5" rows="2">',
				self.noteContent,
				'</textarea>',
				'<div class="overflow-hidden margin-bottom-10">',
					'<button class="btn btn-sm margin-top-10 pull-right auto-width saveNote btn-primary" type="submit">',
						'Zapisz',
					'</button>',
					'<button class="btn btn-sm margin-top-10 margin-sides-10 pull-right closeNoteEditor auto-width btn-default" type="submit">',
						'Anuluj',
					'</button>',
				'</div>'
			].join(''));

			$(self.note).find('textarea').focus();
			$(self.note).find('.closeNoteEditor').click(function() {
				self.closeNoteEditor();
			});
			$(self.note).find('.saveNote').click(function() {
				self.saveNote();
			});

			self.editor = true;
		},

		closeNoteEditor: function() {
			var self = this;
			if(!self.editor || !confirm('Zmiany zostaną odrzucone. Jesteś pewny/a, że chcesz anulować edycję?'))
				return false;

			$(self.note).html(null);
			self.editor = false;
		},

		saveNote: function() {
			var self = this;
			if(!self.editor)
				return false;

			self.noteContent = $(self.note).find('textarea').val();

			$.post(self.savePostAction, {
				_action: 'edit',
				note: self.noteContent
			}, function(res) {
				// @todo error handler
			});

			if(self.noteContent !== '') {
				$(self.note).html([
					'<div class="alert alert-info">',
					self.escape(self.noteContent),
					'</div>'
				].join(''));
			} else $(self.note).html(null);
			self.editor = false;
		},

		getNoteContent: function() {
			var c = $(this.note).find('.alert.alert-info');
			if(c.length)
				return c.html();
			else return null;
		},

		escape: function(text) {
			var map = {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#039;'
			};

			return text.replace(/[&<>"']/g, function(m) { return map[m]; });
		}

	};

	$('.collectionObjectNote').each(function() {
		new CollectionObjectNote($(this));
	});

	$('.btnRemoveObject').click(function() {
		if(!confirm('sure?'))
			return false;
	});

});
