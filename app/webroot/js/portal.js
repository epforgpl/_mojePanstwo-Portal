/*global jQuery*/
(function ($) {
	var _mPCockpit = $('#portal-header'),
		login = _mPCockpit.find('.user-icons li.login'),
		loginOption = login.find('#mPUserOptions'),
		apps = _mPCockpit.find('.app-icons li.apps'),
		appList = apps.find('.appsList');

	_mPCockpit.find('._mPSearch').click(function (e) {
		var suggesterBlockModal = $('.suggesterBlockModal');

		e.preventDefault();

		if ($('._mPSearchOutside').length) {
			$('._mPSearchOutside input').focus();
		} else {
			$('.suggesterBlockModal').modal('toggle');
		}

		suggesterBlockModal.on('shown.bs.modal', function () {
			suggesterBlockModal.find('input').focus();
		}).on('hidden.bs.modal', function () {
			suggesterBlockModal.find('input').val('');
		});
	});
	login.click(function (e) {
		var el = $(this);
		if (el.find('._specialCaseLoginButton').length === 0) {
			e.preventDefault();

			loginOption.toggle();

			if (appList.is(':visible')) {
				appList.hide();
				appList.find('.appListMore').show();
				appList.find('.appListUl.moreList').hide();
			}
		}
	});
	apps.find('> a').click(function (e) {
		e.preventDefault();

		appList.toggle();

		if (appList.is(':hidden')) {
			appList.find('.appListMore').show();
			appList.find('.appListUl.moreList').hide();
		}
		if (loginOption.is(':visible')) {
			loginOption.hide();
		}
	});
	appList.find('.appListMore').click(function (e) {
		e.preventDefault();

		$(this).hide();
		appList.find('.appListUl.moreList').show();
	});
})(jQuery);
