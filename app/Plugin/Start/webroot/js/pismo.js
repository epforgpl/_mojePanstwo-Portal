var PISMO = Class.extend({
	init: function () {

		var self = this;

		// SEND

		this.lettersSendDiv = $('.lettersSend');
		this.lettersSendButton = this.lettersSendDiv.find('button[data-action="send"]');
		this.lettersSendModal = $('#sendPismoModal');

		this.lettersSendButton.click($.proxy(this.showSendModal, this));


		// RESPONSES

		this.responsesDiv = $('.lettersResponses');
		this.responsesList = this.responsesDiv.find('.responses');
		this.responsesButtons = this.responsesDiv.find('.buttons');
		this.addResponseButton = this.responsesDiv.find('button[data-action=add_response]').first();
		this.letterAlphaId = this.addResponseButton.data('letter-alphaid');
		this.letterSlug = this.addResponseButton.data('letter-slug');

		// SET NAME
		var self = this;
		$('.h1-editable').each(function () {
			if ($(this).attr('contenteditable')) {
				$(this).blur(function () {
					$.post($(this).data('url') + '.json', {
						nazwa: $(this).text(),
						edit_from_inputs: 1
					}, function (res) {
						// @todo error handler
						console.log(res);
					});
				});
			} else {
				$(this).change(function () {
					$.post($(this).data('url') + '.json', {
						nazwa: $(this).val(),
						edit_from_inputs: 1
					}, function (res) {
						// @todo error handler
						console.log(res);
					});
					$(this).blur();
				});
			}
		});

		this.addResponseButton.click($.proxy(this.addResponseForm, this));

	},
	showSendModal: function (event) {

		event.preventDefault();

		// this.lettersSendModal.find('#senderName').val($.trim(self.html.stepper_div.find('.control.control-sender').text()).split('\n')[0]);
		this.lettersSendModal.modal('show');

		/*
		 this.lettersSendButton.click(function (e) {
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
		 */


	},
	addResponseForm: function () {

		var li = $('<li class="response response-form"><div class="well bs-component mp-form"><form class="letterResponseForm margin-top-10" method="post"  data-url="/moje-pisma/' + this.letterAlphaId + ',' + this.letterSlug + '/responses.json" action="/moje-pisma/' + this.letterAlphaId + ',' + this.letterSlug + '/responses.json"><fieldset>      <legend>Dodaj odpowiedź na to pismo:</legend><div class="row margin-top-10">                             <div class="col-md-9">                                 <div class="form-group">                                     <label for="responseName">Tytuł:</label>                                     <input maxlength="195" type="text" class="form-control" id="responseName" name="name">                                 </div>                             </div>                             <div class="col-md-3">                                 <div class="form-group">                                     <label for="responseDate">Data:</label>                                     <input type="text" value="" class="form-control datepickerResponseDate" id="responseDate"  name="date">                                 </div>                             </div>                         </div>                         <div class="form-group">                             <label for="responseContent">Treść:</label>                             <textarea class="form-control tinymceField" rows="7" id="responseContent" name="content"></textarea>                         </div>                         <div class="form-group">                             <label for="collectionDescription">Załączniki:</label>                             <div class="dropzoneForm">                                 <div class="actions">                                     <a class="btn btn-sm btn-default btn-addfile">Dodaj załącznik</a>                                 </div>                                 <div class="dropzoneFormPreview" id="preview"></div>                             </div>                         </div>                         <div class="form-group overflow-hidden text-center margin-top-20"><button data-action="cancel" class="btn btn-default" type="button">Anuluj</button><button class="btn width-auto btn-primary btn-icon" type="submit">                                 <span class="icon glyphicon glyphicon-ok"></span>                                 Zapisz odpowiedź</button>                         </div></fieldset></form></div></li>');
		this.responsesList.append(li.hide());

		li.slideDown(function () {

		});

		tinymce.init({
			selector: ".tinymceField",
			language : 'pl',
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
			+ "iframe[src|title|width|height|allowfullscreen|frameborder]"
		});

		$('html').animate({scrollTop: li.offset()['top']});

		this.responsesButtons.slideUp();
		li.find('button[data-action=cancel]').click($.proxy(function (event) {

			event.preventDefault();
			li.slideUp(function () {

				li.remove();

			});
			this.responsesButtons.slideDown();

		}, this));

		$('form.letterResponseForm').each(function () {

			var form = $(this),
				url = form.data('url'),
				dropzone = form.find('.dropzoneForm').first(),
				DropZone = {},
				datepicker = form.find('.datepickerResponseDate').first(),
				btn = form.find('.btn-addfile').first();

			datepicker.bootstrapDP({
				language: 'pl',
				orientation: 'auto top',
				format: "yyyy-mm-dd",
				autoclose: true
			});

			DropZone = new Dropzone(dropzone[0], {
				url: url,
				init: function () {
					var self = this;
					self.on('success', function (file, response) {
						if (response === true) {
							$(file.previewElement)
								.find('.progress-bar')
								.first()
								.addClass('progress-bar-success');
						}
					});

					self.on('error', function (file, response) {
						$(file.previewElement)
							.find('.progress-bar')
							.first()
							.addClass('progress-bar-danger');
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

			$(this).submit(function() {

				tinyMCE.triggerSave();

			});

		});

	}
});

var $P;
$(document).ready(function () {

	"use strict";
	$.fn.bootstrapDP = $.fn.datepicker.noConflict();
	$P = new PISMO();

	/*
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
	 */

	var fv = $('#form-visibility');
	var fvd = fv.find('.form-visibility-display');
	if (fv.length) {

		fv.find('input[name=is_public]').change(function (e) {

			var input = $(e.currentTarget);
			if (input.val() == '1') {

				fvd.slideDown();

			} else {

				fvd.slideUp();

			}

		});

		var radio_inputs_div = $('#visibility_inputs');
		var radio_value = radio_inputs_div.data('value');
		radio_inputs_div.find('input').filter('[value=' + radio_value + ']').prop('checked', true);

	}

});
