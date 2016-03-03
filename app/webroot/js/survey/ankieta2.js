/*global window, document, $, Cookies, mPCookie, mPHeart*/

$(window).load(function () {

	var mPCookie = mPCookie || {},
		surveyAnkieta2 = $('#surveyAnkieta2'),
		ankieta2Interval,
		ankieta2EndDate = new Date(Date.parse("30 March 2016"));

	mPCookie.survey = {};
	mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
	if ((typeof mPHeart.user_id !== "undefined" && mPHeart.user_id !== "") && (new Date() <= ankieta2EndDate)) {
		surveyAnkieta2.find('.modal-footer .submitBtn').click(function (e) {
			var that = $(this),
				data = surveyAnkieta2.find('form').serializeArray();

			e.preventDefault();

			for (var i = 0; i < data.length; i++) {
				if (data[i].value === "") {
					data.splice(i, 1);
					i--;
				}
			}

			if (data.length === 0) {
				mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
				mPCookie.survey.Ankieta2 = 'sended';
				Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
				surveyAnkieta2.addClass('finished');
			} else {
				$.ajax({
					type: "POST",
					url: '/survey.json',
					data: data,
					beforeSend: function () {
						that.addClass('disabled loading');
					},
					complete: function () {
						mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
						mPCookie.survey.ankieta2 = 'sended';
						Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
						surveyAnkieta2.addClass('finished');
					}
				});
			}
		});
		surveyAnkieta2.find('.modal-footer .nextBtn').click(function (e) {
			e.preventDefault();

			var page = surveyAnkieta2.find('.page:not(".hide")'),
				pageNo = parseInt(page.attr('data-pageno')) + 1;

			if (page.next('.page').attr('data-pageno') === "3") {
				surveyAnkieta2.find('.btn').addClass('hide');
				surveyAnkieta2.find('.submitBtn').removeClass('hide');
			}

			page.addClass('hide').next('.page').removeClass('hide');
			surveyAnkieta2.find('.modal-footer .progressBar li:lt(' + pageNo + ')').addClass('active');
		});
		surveyAnkieta2.on('hidden.bs.modal', function () {
			if (mPCookie.survey.ankieta2 !== 'sended') {
				var data = surveyAnkieta2.find('form').serializeArray();

				for (var i = 0; i < data.length; i++) {
					if (data[i].value === "") {
						data.splice(i, 1);
						i--;
					}
				}

				if (data.length === 0) {
					mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
					mPCookie.survey.ankieta2 = 'sended';
					Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
				} else {
					mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
					mPCookie.survey.ankieta2 = 'toSend';
					Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});

					$.ajax({
						type: "POST",
						url: '/survey.json',
						data: data,
						complete: function () {
							mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
							mPCookie.survey.ankieta2 = 'sended';
							Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
						}
					});
				}
			}
		});

		if (typeof mPCookie.survey.ankieta2 === "undefined" || !(mPCookie.survey.ankieta2 === 'toSend' || mPCookie.survey.ankieta2 === 'sended')) {

			if (mPCookie.survey.ankieta2 > 60) {
				surveyAnkieta2.modal('show');
			} else {
				ankieta2Interval = setInterval(function () {
					if (mPCookie.survey.ankieta2 > 60) {
						surveyAnkieta2.modal('show');
						clearInterval(ankieta2Interval);
					}
					mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
					mPCookie.survey.ankieta2 = (typeof mPCookie.survey.ankieta2 !== "undefined") ? mPCookie.survey.ankieta2 + 1 : 1;
					Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
				}, 1000);
			}
		} else if (mPCookie.survey.ankieta2 === 'toSend') {
			var data = surveyAnkieta2.find('form').serializeArray();

			for (var i = 0; i < data.length; i++) {
				if (data[i].value === "") {
					data.splice(i, 1);
					i--;
				}
			}

			if (data.length === 0) {
				mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
				mPCookie.survey.ankieta2 = 'sended';
				Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
			} else {
				$.ajax({
					type: "POST",
					url: '/survey.json',
					data: data,
					complete: function () {
						mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
						mPCookie.survey.ankieta2 = 'sended';
						Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
					}
				});
			}
		}
	}
});
