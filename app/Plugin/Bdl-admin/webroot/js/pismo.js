/*global $,Class,document*/
var PISMO = Class.extend({
	init: function () {
		var self = this;

		// SEND
		self.lettersSendButton = $('.lettersSend');
		self.lettersSendModal = $('#sendPismoModal');

		self.lettersSendButton.click($.proxy(this.showSendModal, this));

		// RESPONSES
		self.responsesDiv = $('.lettersResponses');
		self.responsesList = self.responsesDiv.find('.responses');
		self.responsesButtons = self.responsesDiv.find('.buttons');
		self.addResponseButton = self.responsesDiv.find('button[data-action=add_response]').first();
		self.letterAlphaId = self.addResponseButton.data('letter-alphaid');
		self.letterSlug = self.addResponseButton.data('letter-slug');

		self.addResponseButton.click($.proxy(self.addResponseForm, this));

	},
	showSendModal: function(event) {
		event.preventDefault();

		/*this.lettersSendModal.find('#senderName').val($.trim(self.html.stepper_div.find('.control.control-sender').text()).split('\n')[0]);*/
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
	addResponseForm: function() {

		var li = $('<li class="response response-form">' +
			'<div class="well bs-component mp-form">' +
			'<form class="letterResponseForm margin-top-10" method="post"  data-url="/moje-pisma/' + this.letterAlphaId + ',' + this.letterSlug + '/responses.json" action="/moje-pisma/' + this.letterAlphaId + ',' + this.letterSlug + '/responses.json">' +
			'<fieldset>' +
			'<legend>Dodaj odpowiedź na to pismo:</legend>' +
			'<div class="row margin-top-10">' +
			'<div class="col-md-9">' +
			'<div class="form-group">' +
			'<label for="responseName">Tytuł:</label>' +
			'<input maxlength="195" type="text" class="form-control" id="responseName" name="name">' +
			'</div>' +
			'</div>' +
			'<div class="col-md-3">' +
			'<div class="form-group">' +
			'<label for="responseDate">Data:</label>' +
			'<input type="text" value="" class="form-control datepickerResponseDate" id="responseDate"  name="date">' +
			'</div>' +
			'</div>' +
			'</div>' +
			'<div class="form-group">' +
			'<label for="responseContent">Treść:</label>' +
			'<textarea class="form-control" rows="7" id="responseContent" name="content"></textarea>' +
			'</div>' +
			'<div class="form-group">' +
			'<label for="collectionDescription">Załączniki:</label>' +
			'<div class="dropzoneForm">' +
			'<div class="actions">' +
			'<button class="btn btn-sm btn-default btn-addfile" type="button">Dodaj załącznik</button>' +
			'</div>' +
			'<div id="preview"></div>' +
			'</div>' +
			'</div>' +
			'<div class="form-group overflow-hidden text-center margin-top-20">' +
			'<button data-action="cancel" class="btn btn-default" type="button">Anuluj</button>' +
			'<button class="btn width-auto btn-primary btn-icon" type="submit">' +
			'<span class="icon glyphicon glyphicon-ok"></span> Zapisz odpowiedź' +
			'</button>' +
			'</div>' +
			'</fieldset>' +
			'</form>' +
			'</div>' +
			'</li>');
		this.responsesList.append(li.hide());

		li.slideDown(function(){

		});

		$('html').animate({scrollTop: li.offset()['top']});

		this.responsesButtons.slideUp();
		li.find('button[data-action=cancel]').click($.proxy(function(event){

			event.preventDefault();
			li.slideUp(function(){

				li.remove();

			});
			this.responsesButtons.slideDown();

		}, this));

		$('form.letterResponseForm').each(function() {

			var form = $(this),
				url = form.data('url'),
				dropzone = form.find('.dropzoneForm').first(),
				datepicker = form.find('.datepickerResponseDate').first();

			$.fn.bootstrapDP = $.fn.datepicker.noConflict();

			datepicker.bootstrapDP({
				language: 'pl',
				orientation: 'auto top',
				format: "yyyy-mm-dd",
				autoclose: true
			});

			dropzone.dropzone({
				url: url,
				clickable: '.btn-addfile',
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
					'<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress>',
					'</div>',
					'</div>',
					'<div class="buttons">',
					'</div>',
					'</div>'
				].join(''),
                success: function(file, response){
                    console.log(file);
                    console.log(response);
                }
			});

		});

	}
});

var $P;
$(document).ready(function () {

	"use strict";
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

});
