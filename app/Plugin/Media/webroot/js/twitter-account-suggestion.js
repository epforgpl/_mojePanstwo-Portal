
$(document).ready(function() {

	var md = $('#twitterAccountSuggestionModal'),
		form = md.find('form');

	form.submit(function() {

		$.ajax({
			url: '/media/Twitter/suggestNewAccount.json',
			method: 'POST',
			data: $(this).serializeArray(),
			success: function(res) {

				if(typeof res.response === 'string') {
					alert(res.response);
					return false;
				} else {
					alert('Dziękujemy za złożenie propozycji');
					md.modal('hide');
				}

			}
		});

		return false;

	});


});

