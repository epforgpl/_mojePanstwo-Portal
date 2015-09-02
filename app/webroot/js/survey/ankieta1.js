$(window).load(function () {
	var mPCookie = mPCookie || {},
		surveyAnkieta1 = $('#surveyAnkieta1');

	mPCookie.survey = {};
	mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));

	surveyAnkieta1.find('.modal-footer .submitBtn').click(function (e) {
		var that = $(this),
			data = surveyAnkieta1.find('form').serializeArray();

		e.preventDefault();

		for (var i = 0; i < data.length; i++) {
			if (data[i]['value'] == "") {
				data.splice(i, 1);
				i--;
			}
		}

		if (data.length == 0) {
			mPCookie.survey.ankieta1 = 'sended';
			Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
			surveyAnkieta1.addClass('finished');
		} else {
			$.ajax({
				type: "POST",
				url: '/survey.json',
				data: data,
				beforeSend: function () {
					that.addClass('disabled loading');
				},
				complete: function () {
					mPCookie.survey.ankieta1 = 'sended';
					Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
					surveyAnkieta1.addClass('finished');
				}
			});
		}
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
		if (mPCookie.survey.ankieta1 !== 'sended') {
			var data = surveyAnkieta1.find('form').serializeArray();

			for (var i = 0; i < data.length; i++) {
				if (data[i]['value'] == "") {
					data.splice(i, 1);
					i--;
				}
			}

			if (data.length == 0) {
				mPCookie.survey.ankieta1 = 'sended';
				Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
			} else {
				mPCookie.survey.ankieta1 = 'toSend';
				Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});

				$.ajax({
					type: "POST",
					url: '/survey.json',
					data: data,
					complete: function () {
						mPCookie.survey.ankieta1 = 'sended';
						Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
					}
				});
			}
		}
	});

	if (mPCookie.survey.ankieta1 == undefined || !(mPCookie.survey.ankieta1 == 'toSend' || mPCookie.survey.ankieta1 == 'sended')) {
		surveyAnkieta1.modal('show');
	} else if (mPCookie.survey.ankieta1 == 'toSend') {
		var data = surveyAnkieta1.find('form').serializeArray();

		for (var i = 0; i < data.length; i++) {
			if (data[i]['value'] == "") {
				data.splice(i, 1);
				i--;
			}
		}

		if (data.length == 0) {
			mPCookie.survey.ankieta1 = 'sended';
			Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
		} else {
			$.ajax({
				type: "POST",
				url: '/survey.json',
				data: data,
				complete: function () {
					mPCookie.survey.ankieta1 = 'sended';
					Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
				}
			});
		}
	}
});
