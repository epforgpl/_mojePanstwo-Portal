$(window).load(function () {
	var mPCookie = mPCookie || {},
		surveyAnkieta1 = $('#surveyAnkieta1');

	mPCookie.survey = {};
	mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));

	surveyAnkieta1.find('button[type="submit"]').click(function (e) {
		var that = $(this),
			fastEnd = true;

		e.preventDefault();
		mPCookie.survey.ankieta1 = surveyAnkieta1.find('form').serializeArray();

		$.ajax({
			type: "POST",
			url: '/survey',
			data: mPCookie.survey.ankieta1,
			beforeSend: function (e) {
				if (that.hasClass('submitBtn')) {
					fastEnd = false;
					that.addClass('disabled loading');
				}
			},
			complete: function () {
				surveyAnkieta1.find('.btn[type="submit"]').unbind('click');
				surveyAnkieta1.addClass('finished');
			}
		});

		Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365});

		if (fastEnd)
			surveyAnkieta1.modal('hide');
	});
	surveyAnkieta1.find('.modal-footer .btn[type="button"]').click(function (e) {
		e.preventDefault();

		var page = surveyAnkieta1.find('.page:not(".hide")'),
			pageNo = parseInt(page.attr('data-pageno')) + 1;

		if (page.next('.page').attr('data-pageno') == "4") {
			surveyAnkieta1.find('.btn').addClass('hide');
			surveyAnkieta1.find('.btn[type="submit"]').removeClass('hide');
		}

		page.addClass('hide').next('.page').removeClass('hide');
		surveyAnkieta1.find('.modal-footer .progressBar li:lt(' + pageNo + ')').addClass('active');
	});
	surveyAnkieta1.modal({backdrop: 'static', keyboard: false});
	surveyAnkieta1.modal('show');
});
