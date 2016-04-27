/*global $,jQuery,Class,mPHeart,ZeroClipboard,alert*/
var PISMA = Class.extend({
		preview: null,
		confirmExit: false,
		html: {
			stepper_div: $("#stepper")
		},
		methods: {
			stepper: null
		},
		objects: {
			szablony: null,
			adresaci: null,
			editor: null
		},
		cache: {
			szablony: {},
			adresaci: {},
			adresatInterval: null
		},
		keycode: {
			enter: 13,
			escape: 27,
			arrowUp: 38,
			arrowDown: 40
		},
		init: function () {
			"use strict";
			if (this.html.stepper_div.hasClass('stepper')) {
				this.stepsMarkers();
				this.changeTitle();
				this.szablony();
				this.editor();
				this.lastPageButtons();
				this.unsaveWarning();
			} else {
				this.stepsMarkers();
				this.changeTitle();
				this.lastPageButtons();
			}
		},
		stepsMarkers: function () {
			"use strict";
			this.html.szablony = this.html.stepper_div.find('.szablony');
			this.html.adresaci = this.html.stepper_div.find('.adresaci');
			this.html.editorTop = this.html.stepper_div.find('.editor-controls');
			this.html.editor = this.html.stepper_div.find('#editor');
		},
		changeTitle: function () {
			"use strict";
			var self = this,
				pismoTitleBlock = $('.titleBlock '),
				pismoTitle = pismoTitleBlock.find('h1'),
				pismoTitleBtn = pismoTitle.find('.glyphicon'),
				pismoTitleEdit = pismoTitleBlock.find('.input-group');

			pismoTitle.data('title', $.trim(pismoTitle.text()));

			pismoTitleBtn.click(function (e) {
				e.preventDefault();

				if (pismoTitle.is(':visible')) {
					pismoTitle.hide();
					pismoTitleEdit.removeClass('hide').show();
				} else {
					pismoTitle.show();
					pismoTitleEdit.hide();
				}
			});

			pismoTitleEdit.find('.btn.save').click(function () {
				var newTitle = $.trim(pismoTitleEdit.find('input').val());
				$.ajax({
					url: '/moje-pisma/' + pismoTitle.data('url') + '.json',
					method: 'PUT',
					data: {
						name: newTitle
					},
					before: function () {
						pismoTitleEdit.find('.btn').addClass('disable');
					},
					success: function () {
						pismoTitleEdit.find('.btn').removeClass('disable');
						pismoTitle.data('title', newTitle).find('a').text(newTitle);
						pismoTitle.show();
						pismoTitleEdit.hide();
					}
				});
			});

			pismoTitleEdit.find('.btn.cancel').click(function () {
				pismoTitle.find('a').text(pismoTitle.data('title'));
				pismoTitleEdit.find('input').val(pismoTitle.data('title'));
				pismoTitle.show();
				pismoTitleEdit.hide();
			});

			pismoTitleEdit.find('input').keydown(function (e) {
				if (e.keyCode === self.keycode.escape || e.which === self.keycode.escape) {
					pismoTitle.text(pismoTitle.data('title'));
				} else if (e.keyCode === self.keycode.enter || e.which === self.keycode.enter) {
					e.preventDefault();
					pismoTitleEdit.find('.btn.save').click();
				}
			});
		},

		szablonData: function (szablon_id) {
			"use strict";
			var self = this;

			$.getJSON(mPHeart.constant.ajax.api + "/moje-pisma/templates/" + szablon_id + ".json", function (d) {
				self.objects.szablony = {
					id: d.id,
					title: d.nazwa,
					content: d.tresc
				};
				self.objects.editor = {
					id: d.id,
					tytul: d.nazwa
				};
			});
		},
		szablony: function () {
			"use strict";
			var self = this,
				confirmText = 'Zmiana szablonu spowoduje zastąpienie treści pisma nowym szablonem. Czy na pewno chcesz to zrobić?',
				confirmBtn = 'Zrozumiałem';

			self.html.szablony.find('input[type="radio"]').change(function () {
				if (self.objects.szablony.confirm !== true) {
					if (self.objects.szablony && self.objects.szablony !== $(this).val()) {
						self.html.szablony.find('> label').popover({
							html: true,
							content: '<p>' + confirmText + '</p><p style="text-align:center; margin: 0"><button class="btn btn-sm btn-primary">' + confirmBtn + '</button></p>'
						}).popover('show');
					}
					self.objects.szablony.confirm = true;
					self.html.szablony.find('.popover .btn').click(function (e) {
						e.preventDefault();
						self.html.szablony.find('> label').popover('destroy');
					});
				}
			});
		},
		editor: function () {
			"use strict";
			var prettyDate,
				myDate,
				self = this;

			$('textarea').autosize({
				append: false
			}).keyup(function () {
				var that = $(this);

				if (that.val() === "") {
					that.addClass('empty');
				} else {
					that.removeClass('empty');
				}
			});

			myDate = new Date();
			prettyDate = myDate.getDate() + ' ' + $.datepicker.regional.pl.monthNames[myDate.getMonth()] + ' ' + myDate.getFullYear();

			self.html.editorTop.find('.control-date .datepicker').val(prettyDate).datepicker();

			if (self.html.editor.length) {
				self.html.editor.wysihtml5({
					'events': {
						'load': function () {
							self.html.stepper_div.find('.wysihtml5-toolbar').find('[data-wysihtml5-command="bold"]').html($('<span></span>').addClass('fa fa-bold'))
								.end()
								.find('[data-wysihtml5-command="italic"]').html($('<span></span>').addClass('fa fa-italic'))
								.end()
								.find('[data-wysihtml5-command="small"]').remove()
								.end()
								.find('[data-wysihtml5-command="underline"]').html($('<span></span>').addClass('fa fa-underline'))
								.end()
								.find('[data-wysihtml5-command="createLink"]').html($('<span></span>').addClass('glyphicon glyphicon-link'));

							self.convertEditor();
						}
					},
					toolbar: {
						'image': false,
						'emSmall': false,
						'link': false
					},
					'html': true,
					'fa': true,
					'locale': 'pl-PL',
					parser: function (html) {
						return html;
					}
				});
			}
		},
		editorDetail: function () {
			"use strict";
			var self = this,
				checkSzablon = self.html.szablony.find('.radio input:checked').val();

			if (self.objects.szablony !== null && (checkSzablon !== self.objects.szablony.id)) {
				self.html.editor.addClass('loading');
				self.szablonData(checkSzablon);

				$.getJSON(mPHeart.constant.ajax.api + "/moje-pisma/templates/" + checkSzablon + ".json", function (data) {
					if (self.objects.editor !== null) {
						if ($(self.objects.editor.text === self.html.editor.text()) || (self.html.editor.text() === '')) {
							self.html.editor.empty().html(data.tresc);
						}
					} else {
						self.html.editor.empty().html(data.tresc);
					}
					self.convertEditor();
					self.html.editorTop.find('.control-template').text(data.nazwa);

					self.html.editor.removeClass('loading');
				});
			}
		}
		,
		convertEditor: function () {
			"use strict";
			var self = this,
				editor = self.html.editor,
				rand = '',
				randLength = 32,
				randChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
				i;

			editor.find('.editable:not(.r)').each(function () {
				var that = $(this);

				if (that.hasClass('date')) {
					that.append(
						$('<input>').addClass('datepicker').datepicker()
					);
					that.addClass('r');
				} else if (that.hasClass('daterange')) {
					that.append(
						$('<label></label>').attr('for', 'from').text('od dnia ')
					).append(
						$('<input>').addClass('datepicker from').attr('name', 'from')
							.datepicker({
								onClose: function (selectedDate) {
									that.find('.datepicker.to').datepicker("option", "minDate", selectedDate);
								}
							})
					).append(
						$('<label></label>').attr('for', 'to').text(' do dnia ')
					).append(
						$('<input>').addClass('datepicker to').attr('name', 'to')
							.datepicker({
								onClose: function (selectedDate) {
									that.find('.datepicker.from').datepicker("option", "maxDate", selectedDate);
								}
							})
					);
					that.addClass('r');
				} else {
					if (that.hasClass('email')) {
						that.addClass('mirrorable').append(
							$('<input>').addClass('emailEnter').attr({
								type: "email",
								placeholder: "(podaj adres email)"
							})
						);
						that.addClass('r');
					} else if (that.hasClass('currencypln')) {
						for (i = randLength; i > 0; --i) {
							rand += randChars[Math.round(Math.random() * (randChars.length - 1))];
						}

						that.addClass('mirrorable').attr('data-unique', rand).append(
							$('<input>').addClass('kwota').attr('title', that.attr('title'))
						).after(
							$('<span></span>').addClass('slownie').attr('data-unique', rand)
						);
						that.removeAttr('title');
						that.find('input.kwota').keyup(function () {
							var k, j, d, n, s, g,
								liczba = parseFloat($(this).val()),
								jednosci = ["", " jeden", " dwa", " trzy", " cztery", " pięć", " sześć", " siedem", " osiem", " dziewięć"],
								nascie = ["", " jedenaście", " dwanaście", " trzynaście", " czternaście", " piętnaście", " szesnaście", " siedemnaście", " osiemnaście", " dziewietnaście"],
								dziesiatki = ["", " dziesięć", " dwadzieścia", " trzydzieści", " czterdzieści", " pięćdziesiąt", " sześćdziesiąt", " siedemdziesiąt", " osiemdziesiąt", " dziewięćdziesiąt"],
								setki = ["", " sto", " dwieście", " trzysta", " czterysta", " pięćset", " sześćset", " siedemset", " osiemset", " dziewięćset"],
								grupy = [
									["", "", ""],
									[" tysiąc", " tysiące", " tysięcy"],
									[" milion", " miliony", " milionów"],
									[" miliard", " miliardy", " miliardów"],
									[" bilion", " biliony", " bilionów"],
									[" biliard", " biliardy", " biliardów"],
									[" trylion", " tryliony", " tryliardów"]],
								wynik = '',
								znak = '';

							if (liczba === 0) {
								wynik = "zero";
							}
							if (liczba < 0) {
								znak = "minus";
							}

							g = 0;
							while (liczba > 0) {
								liczba = Math.floor(liczba / 1000);
								s = Math.floor((liczba % 1000) / 100);
								n = 0;
								d = Math.floor((liczba % 100) / 10);
								j = Math.floor(liczba % 10);
								if (d === 1 && j > 0) {
									n = j;
									d = 0;
									j = 0;
								}

								k = 2;
								if (j === 1 && s + d + n === 0) {
									k = 0;
								}
								if (j === 2 || j === 3 || j === 4) {
									k = 1;
								}
								if (s + d + n + j > 0) {
									wynik = setki[s] + dziesiatki[d] + nascie[n] + jednosci[j] + grupy[g][k] + wynik;
								}

								g++;
							}

							self.html.editor.find('.slownie[data-unique="' + $(this).parent().data('unique') + '"]')
								.html('&nbsp;PLN <span class="_slownie">(słownie: ' + znak + wynik + ' polskich złotych)</span>');
							that.addClass('r');
						});
					} else {

					}
				}

				if (that.hasClass('mirrorable')) {
					that.prepend($('<div></div>').addClass('mirror').css({
						'visibility': 'hidden',
						'position': 'absolute'
					}));
					self.convertEditorInputWidth(that);
				}

				if (that.attr('title')) {
					that.tooltip({
						delay: 0
					});
				}

				self.cursorPosition();
			});
		}
		,
		scanEditor: function () {
			"use strict";
			var self = this,
				editorTop = this.html.editorTop,
				editor = this.html.editor;

			if (self.objects.szablony !== null && self.objects.szablony.id) {
				editorTop.find('.control-template').html(self.objects.szablony.title);
				editor.html(self.objects.szablony.content);
			} else {
				editorTop.find('.control-template').html('');
				editor.html('');
			}

			if (self.objects.adresaci !== null && self.objects.adresaci.id) {
				editorTop.find('.control-addressee').html('').append(
					$('<p></p>').html(self.objects.adresaci.title)
				)/*.append(
				 $('<p></p>').html(self.objects.adresaci.adres)
				 )*/;
			} else {
				editorTop.find('.control-addressee').html('');
			}

			if (editor.text().trim() !== '') {
				editor.find('.editable').each(function () {
					var that = $(this);

					if (that.hasClass('copyaddresee')) {
						if (self.objects.adresaci) {
							that.html(self.objects.adresaci.title);
						} else {
							//that.html('<br type="_editor">');
						}
					}
				});
				self.cursorPosition();
			}
		}
		,
		convertEditorInputWidth: function (that) {
			"use strict";
			var mirror = that.find('.mirror'),
				input = that.find('input'),
				safePadding = 8;

			mirror.html((input.val() === '') ? input.attr('placeholder') : input.val());
			input.css('width', (mirror.outerWidth() < input.css('min-width')) ? input.css('min-width') : mirror.outerWidth() + safePadding);

			input.keydown(function () {
				mirror.html((input.val() === '') ? input.attr('placeholder') : input.val());
				input.attr('value', (input.val() === '') ? '' : input.val());
				input.css('width', (mirror.outerWidth() < input.css('min-width')) ? input.css('min-width') : mirror.outerWidth() + safePadding);
			});
		}
		,
		cursorPosition: function () {
			"use strict";
			var self = $(this),
				elEd = document.getElementById('editor'),
				sel,
				elCr,
				range;

			if (window.getSelection && elEd.getElementsByClassName('cursorhere').length) {
				sel = window.getSelection();
				elCr = elEd.getElementsByClassName('cursorhere')[0].parentNode;
				range = document.createRange();

				range.setStart(elCr, 1);
				range.collapse(true);
				sel.removeAllRanges();
				sel.addRange(range);

				$(elCr).find('span.cursorhere').remove();

				if ($(elCr).html() === '') {
					$(elCr).html('<br>');
				}
			}

			if (self.objects !== undefined && self.objects.editor !== null) {
				self.objects.editor.text = editor.text();
			}
			elEd.focus();
		}
		,
		requiredInputs: function () {
			var nadawca = $('#editor-cont .control.control-sender textarea.nadawca');

			if (nadawca.length > 0 && nadawca.val() == "" && nadawca.attr('data-req') != 0) {
				nadawca.val('');
				return false
			}

			return true;
		}
		,
		generateFormInsert: function () {
			"use strict";
			var self = this,
				preview = $('<div></div>').addClass('hide').append(
					$('<input />').attr({'name': 'data_pisma', 'maxlength': "10"})
				).append(
					$('<input />').attr({'name': 'adresat_id'})
				).append(
					$('<input />').attr({'name': 'adresat', 'maxlength': "511"})
				).append(
					$('<input />').attr({'name': 'szablon_id'})
				).append(
					$('<input />').attr({'name': 'tytul', 'maxlength': "511"})
				).append(
					$('<input />').attr({'name': 'nazwa', 'value': "Nowe pismo"})
				).append($('<div></div>').addClass('content'));

			self.html.stepper_div.find('#editor-cont').clone().appendTo(preview.find('.content'));

			preview.find('.wysihtml5-toolbar').remove()
				.end()
				.find('.control span.empty').remove()
				.end()
				.find('.control .empty').removeClass('empty')
				.end()
				.find('#editor').attr('contenteditable', false);

			if (preview.find('.control.control-date input.city').val() === '') {
				preview.find('.control.control-date input.city').val(' ');
			}

			self.html.stepper_div.find('.edit textarea:not(.hide)').each(function (idx) {
				$(preview.find("textarea").eq(idx)).replaceWith('<div class="pre">' + $(this).val().replace(/\n/g, '<br/>') + '</div>');
			});

			preview.find('span:not([class]),div:not([class])').contents().unwrap();

			preview.append(
				$('<textarea></textarea>').attr({name: 'tresc_html'}).val($.trim(preview.find('#editor').html()))
			);

			preview
				.find('br[type="_editor"]').remove()
				.end()
				.find('.mirror').remove()
				.end()
				.find('.editable').each(function () {
					var that = $(this),
						slownie;

					if (that.hasClass('date')) {
						that.replaceWith(that.find('input.datepicker').val());
					} else if (that.hasClass('daterange')) {
						that.replaceWith(that.find('label[for="from"]').html() + that.find('input[name="from"]').val() + that.find('label[for="to"]').html() + that.find('input[name="to"]').val());
					} else {
						if (that.hasClass('email')) {
							that.replaceWith(that.find('input[type="email"]').val());
						} else if (that.hasClass('currencypln')) {
							slownie = self.html.editor.find('.slownie[data-unique="' + that.data('unique') + '"]');

							that.replaceWith(that.find('input.kwota').val());
							slownie.replaceWith(slownie.html());
						} else {
							that.replaceWith(that.html());
						}
					}
				})
				.end()
				.find('input[name="nazwa"]').val($.trim($('.titleBlock h1').text()))
				.end()
				.find('input[name="data_pisma"]').val($.trim(preview.find('.control.control-date input#datepickerAlt').val()))
				.end()
				.find('input[name="miejscowosc"]').val($.trim(preview.find('.control.control-date input.city').val()))
				.end()
				.find('input[name="adresat_id"]').val((self.objects.adresaci) ? self.objects.adresaci.dataset + ':' + self.objects.adresaci.id : '')
				.end()
				.find('input[name="adresat"]').val($.trim(preview.find('.control.control-addressee').html()))
				.end()
				.find('input[name="szablon_id"]').val((self.objects.szablony) ? self.objects.szablony.id : '')
				.end()
				.find('input[name="tytul"]').val($.trim(preview.find('.control.control-template').text()));

			if ($('.form-group.widocznosc').length > 0) {
				preview.append(
					$('<radio></radio>').attr({name: 'access'}).val($('.form-group.widocznosc input[name="access"]:checked').val())
				);
			}

			preview.append(
				$('<textarea></textarea>').attr({name: 'tresc'}).val($.trim(preview.find('#editor').html()))
			).append(
				$('<textarea></textarea>').attr({name: 'nadawca'}).val(self.html.stepper_div.find('.edit .control.control-sender textarea.nadawca').val())
			).append(
				$('<textarea></textarea>').attr({name: 'podpis'}).val(self.html.stepper_div.find('.edit .control.control-signature textarea.podpis').val())
			);

			if (self.html.stepper_div.find('form.form-save > .hide').length > 0)
				self.html.stepper_div.find('form.form-save > .hide').remove();

			self.html.stepper_div.find('form.form-save').append(preview);
			self.html.stepper_div.find('form.form-save').submit();
		}
		,
		lastPageButtons: function () {
			"use strict";
			var self = this,
				$sendPismoModal = $('#sendPismoModal'),
				modal = {
					sendPismo: $sendPismoModal
				};

			self.html.stepper_div.find('.editor-tooltip .sendPismo').click(function (e) {
				e.preventDefault();

				$sendPismoModal.find('#senderName').val($.trim(self.html.stepper_div.find('.control.control-sender').text()).split('\n')[0]);
				$sendPismoModal.modal('show');
			});

			if (modal.sendPismo.length) {
				modal.sendPismo.find('.btn[type="submit"]').click(function () {
					var correct = true;
					$.each(modal.sendPismo.find('input:required'), function () {
						if ($(this).val() == "") {
							$(this).val('');
							correct = false;
							return false;
						} else {
							if ($(this).attr('type') == "email") {
								var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

								if (!emailReg.test($(this).val())) {
									$(this).focus();
									correct = false;
									return false;
								}
							}
						}
					});
					if ($(this).hasClass('loading')) {
						correct = false;
						return false;
					}
					if (correct) {
						$(this).addClass('loading');
					}
				});
			}

			self.html.stepper_div.find('.form-save .savePismo').click(function (e) {
				e.preventDefault();

				if (self.requiredInputs()) {
					$(this).parent('form').find('input[name="_save"]').attr('name', 'save');
					self.generateFormInsert();
				}
			});
		}
		,
		unsaveWarning: function () {
			"use strict";
			var self = this,
				btnActions = self.html.stepper_div.find('.editor-tooltip'),
				statusCheck = self.html.stepper_div.data('status-check');

			if (statusCheck !== undefined) {
				self.confirmExit = true;

				btnActions.find('.btn.savePismo, a[name="cancel"], input[name="delete"]').click(function () {
					if ($(this).hasClass('savePismo')) {
						if (self.requiredInputs()) {
							self.confirmExit = false;
						}
					} else {
						self.confirmExit = false;
					}
				});
				$('.form-save .savePismo').click(function () {
					if (self.requiredInputs()) {
						self.confirmExit = false;
					}
				});

				$(window).bind('beforeunload', function () {
					if (self.confirmExit) {
						if (statusCheck === 0) {
							return 'Pismo nie zostało jeszcze zapisane. Czy na pewno nie chcesz go zapisać?';
						} else if (statusCheck === 1) {
							return 'Czy chcesz opuścić tę stronę bez zapisywania zmian?';
						}
					}
				});
			}
		}
	})
	;

var $P;
$(document).ready(function () {
	"use strict";
	$P = new PISMA();

	$P.html.stepper_div.find('.more-buttons-switcher').click(function (event) {
		event.preventDefault();

		var switcher = $(event.target).parent('.more-buttons-switcher'),
			target_element = switcher.parent().find('.more-buttons-target'),
			mode = switcher.data('mode');

		if (mode === 'more') {
			switcher.attr('href', '#less').data('mode', 'less').find('.text').text('Mniej');
			switcher.find('.glyphicon').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
			target_element.slideDown();
		} else if (mode === 'less') {
			target_element.slideUp();
			switcher.attr('href', '#more').data('mode', 'more').find('.text').text('Więcej');
			switcher.find('.glyphicon').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		}
	});

	if ($('#clipboardCopyBtn').length) {
		var client = new ZeroClipboard(document.getElementById("clipboardCopyBtn"));

		client.on("ready", function (readyEvent) {
			if (readyEvent) {
				client.on("aftercopy", function (event) {
					alert("Skopiowano do schowka: " + event.data["text/plain"]);
				});
			}
		});
	}

	function sentencecase(a) {
		a = a.toLowerCase();
		var b = true;
		var c = "";
		for (var d = 0; d < a.length; d++) {
			var e = a.charAt(d);
			if (/\.|>|\!|\?|\n|\r/.test(e)) {
				b = true;
			} else if ($.trim(e) != "" && b == true) {
				e = e.toUpperCase();
				b = false;
			}
			c += e;
		}
		c = c.replace(/ i /g, ' I ');
		return c;
	}

	if( typeof(tinymce)!='undefined' ) {

		tinymce.PluginManager.add('sentencecase', function (editor, url) {
			editor.addMenuItem('sentencecase', {
				text: 'Litery jak w zdaniu',
				context: 'format',
				onclick: function () {
					editor.setContent(
						sentencecase(editor.getContent())
					);
				}
			});
		});

		tinymce.init({
			selector: ".tinymceField",
			language: 'pl',
			plugins: "media image sentencecase",
			menubar: false,
			statusbar: false,
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

	}

});
