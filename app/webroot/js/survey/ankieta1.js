$(window).load(function () {
	var mPCookie = mPCookie || {},
		surveyAnkieta1 = $('#surveyAnkieta1'),
		cockpit = $('#_mPCockpit ._mPBasic ._mPSystem ._mPRunning');

	mPCookie.survey = {};
	mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));

	surveyAnkieta1.find('.modal-footer .submitBtn').click(function (e) {
		var that = $(this),
			data = surveyAnkieta1.find('form').serializeArray();

		e.preventDefault();

		$.ajax({
			type: "POST",
			url: '/survey.json',
			data: data,
			beforeSend: function () {
				that.addClass('disabled loading');
			},
			complete: function () {
				mPCookie.survey.ankieta1 = 'all';
				Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365});
				surveyAnkieta1.addClass('finished');
				cockpit.find('.surveyPoll').remove();
			}
		});
	});
	surveyAnkieta1.find('.modal-footer .nextBtn').click(function (e) {
		e.preventDefault();

		var page = surveyAnkieta1.find('.page:not(".hide")'),
			pageNo = parseInt(page.attr('data-pageno')) + 1;

		if (page.next('.page').attr('data-pageno') == "4") {
			surveyAnkieta1.find('.btn').addClass('hide');
			surveyAnkieta1.find('.submitBtn').removeClass('hide');
		}

		page.addClass('hide').next('.page').removeClass('hide');
		surveyAnkieta1.find('.modal-footer .progressBar li:lt(' + pageNo + ')').addClass('active');
	});
	surveyAnkieta1.on('hidden.bs.modal', function () {
		cockpit.find('.surveyPoll.hide').removeClass('hide');
		if (mPCookie.survey.ankieta1 !== 'all') {
			mPCookie.survey.ankieta1 = 'half';
			Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365});
		}
	});

	if (!cockpit.find('.surveyPoll').length) {
		cockpit.append(
			$('<a></a>').addClass('_appBlock _appBlockBackground surveyPoll hide').append(
				$('<div></div>').addClass('_mPTitle').append(
					$('<p></p>').addClass('_mPAppLabel').text('Ankieta')
				)
			).click(function () {
					$(this).addClass('hide');
					surveyAnkieta1.modal('show');
				})
		)
	}

	if (mPCookie.survey.ankieta1 == undefined)
		surveyAnkieta1.modal('show');

	if (mPCookie.survey.ankieta1 == 'half')
		cockpit.find('.surveyPoll.hide').removeClass('hide');
});