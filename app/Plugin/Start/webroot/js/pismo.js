var PISMO = Class.extend({
	init: function () {
		
		var self = this;
		
		this.responsesDiv = $('.lettersResponses');
		this.responsesList = this.responsesDiv.find('.responses');
		this.responsesButtons = this.responsesDiv.find('.buttons');
		
		
		this.responsesDiv.find('button[data-action=add_response]').click( $.proxy(this.addResponseForm, this) );
		
	},
	addResponseForm: function() {

		var li = $('<li class="response response-form"><div class="well bs-component mp-form"><form class="letterResponseForm margin-top-10" method="post" data-url="/moje-pisma/responses.json"><fieldset>      <legend>Dodaj odpowiedź na to pismo:</legend><div class="row margin-top-10">                             <div class="col-md-9">                                 <div class="form-group">                                     <label for="responseName">Tytuł:</label>                                     <input maxlength="195" type="text" class="form-control" id="responseName" name="name">                                 </div>                             </div>                             <div class="col-md-3">                                 <div class="form-group">                                     <label for="responseDate">Data:</label>                                     <input type="text" value="" class="form-control datepickerResponseDate" id="responseDate"  name="date">                                 </div>                             </div>                         </div>                         <div class="form-group">                             <label for="responseContent">Treść:</label>                             <textarea class="form-control" rows="7" id="responseContent" name="content"></textarea>                         </div>                         <div class="form-group">                             <label for="collectionDescription">Załączniki:</label>                             <div class="dropzoneForm">                                 <div class="actions">                                     <a class="btn btn-default btn-addfile" href="#" role="button">Dodaj załącznik</a>                                 </div>                                 <div id="preview"></div>                             </div>                         </div>                         <div class="form-group overflow-hidden text-center margin-top-20"><button data-action="cancel" class="btn btn-default" type="button">Anuluj</button><button class="btn auto-width btn-primary btn-icon" type="submit">                                 <i class="icon glyphicon glyphicon-ok"></i>                                 Zapisz odpowiedź</button>                         </div></fieldset></form></div></li>');
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
