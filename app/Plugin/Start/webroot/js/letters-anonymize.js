/*global window, document, $, rangy*/

var highlighter;

function unSelect() {
	var t = false;

	if (window.getSelection) {
		t = window.getSelection();
	} else if (document.getSelection) {
		t = document.getSelection();
	} else if (document.selection) {
		t = document.selection.createRange().htmlText;
	}
	t.removeAllRanges();
}

function highlightSelectedText() {
	highlighter.highlightSelection("anonim");
	unSelect();
}

String.prototype.setCharAt = function (idx) {
	if (idx > this.length - 1) {
		return this.toString();
	} else {
		if (this.substr(idx) === " ") {
			return this.substr(0, idx) + " " + this.substr(idx + 1);
		} else {
			var numberChart = Math.floor(Math.random() * 3),
				anonymizeTxt = '',
				possible = " abcdefghijklmnopqrstuvwxyz0123456789 ";

			if (idx === 0 && numberChart === 0) {
				numberChart = Math.floor(Math.random() * 2) + 1;
			}

			for (var i = 0; i < numberChart; i++) {
				anonymizeTxt += possible.charAt(Math.floor(Math.random() * possible.length));
			}

			return this.substr(0, idx) + anonymizeTxt + this.substr(idx + 1);
		}
	}
};

window.onload = function () {
	var anonymizeBlock = $('.anonymize');

	rangy.init();
	highlighter = rangy.createHighlighter();
	highlighter.addClassApplier(rangy.createClassApplier("anonim", {
		ignoreWhiteSpace: true,
		tagNames: ["span", "a"],
		onElementCreate: function (evt) {
			$(evt).on('click', function (e) {
				e = e || window.event;
				var target = e.target || e.srcElement;
				var highlight = highlighter.getHighlightForElement(target);
				if (highlight) {
					highlighter.removeHighlights([highlight]);
					unSelect();
				}
			});
		}
	}));

	anonymizeBlock.on('mouseup', function () {
		highlightSelectedText();
	});
	

	$('.anonimizePublicBtn').click(function(e){
		
		var that = $(this);
		e.preventDefault();
		
		console.log('anonymizeBlock', anonymizeBlock);
		
		var content = $.trim(anonymizeBlock.html()),
			public_content = anonymizeBlock.clone(),
			anonimBlock = public_content.find('.anonim'),
			data = {
				'content': content,
				'public_content': content
			};

		if (anonimBlock.length > 0) {
			$.each(anonimBlock, function () {
				var txt = $(this).text();

				for (var j = 0; j < txt.length; j++) {
					txt = txt.setCharAt(j);
				}
				$(this).text(txt);
			});
			data.public_content = $.trim(public_content.html());
		}
		
		$('#public_content_input').val(data.public_content);
		$('#anonimizePublicForm').submit();
		
	});
	
	/*
	$('.anonimizePublicBtn').click(function (e) {
		var that = $(this);

		e.preventDefault();

		if (!that.hasClass('loading')) {
			

			that.addClass('disabled');

			$.ajax({
				url: that.attr('data-ajax'),
				data: data,
				dataType: 'json',
				async: false,
				success: function () {
					window.location.href = that.attr('data-ajax');
				}
			});
		}
	});
	*/
};
