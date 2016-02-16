/*global $,jQuery,window,document*/
(function ($) {
	var _mPCockpit = $('#portal-header'),
		login = _mPCockpit.find('.user-icons li.login'),
		loginOption = login.find('#mPUserOptions'),
		apps = _mPCockpit.find('.app-icons li.apps'),
		appList = apps.find('.appsList'),
		_mPSearch = $('.suggesterBlockModal.directBlock');

	_mPCockpit.find('._mPSearch').click(function (e) {
		var _mPSearchOutside = $('._mPSearchOutside'),
			suggesterBlockModal = $('.suggesterBlockModal');

		e.preventDefault();

		if (_mPSearchOutside.length) {
			_mPSearchOutside.find('input').focus();
			if ($(window).scrollTop() > _mPSearchOutside.position().top) {
				$('html, body').animate({
					scrollTop: Math.floor(_mPSearchOutside.position().top)
				}, 500);
			}
		} else {
			if (_mPSearch.length) {
				if (appList.is(':visible')) {
					appList.hide();
					appList.find('.appListMore').show();
					appList.find('.appListLess').hide();
					appList.find('.appListUl.moreList').hide();
				}
				if (loginOption.is(':visible')) {
					loginOption.hide();
				}
				_mPSearch.toggle();
				_mPSearch.find('input').val('');
				_mPSearch.find('input').focus();
			} else {
				suggesterBlockModal.modal('toggle');
			}

		}
		if (!(_mPSearch.length)) {
			suggesterBlockModal.on('shown.bs.modal', function () {
				suggesterBlockModal.find('input').focus();
			}).on('hidden.bs.modal', function () {
				suggesterBlockModal.find('input').val('');
			});
		}
	});
	login.click(function () {
		var el = $(this);
		if (el.find('._specialCaseLoginButton').length === 0) {
			loginOption.toggle();

			if (appList.is(':visible')) {
				appList.hide();
				appList.find('.appListMore').show();
				appList.find('.appListLess').hide();
				appList.find('.appListUl.moreList').hide();
			}

			if (_mPSearch.is(':visible')) {
				_mPSearch.hide();
			}
		}
	});
	apps.find('> a').click(function (e) {
		e.preventDefault();

		appList.toggle();

		if (appList.is(':hidden')) {
			appList.find('.appListMore').show();
			appList.find('.appListLess').hide();
			appList.find('.appListUl.moreList').hide();
		}
		if (loginOption.is(':visible')) {
			loginOption.hide();
		}

		if (_mPSearch.is(':visible')) {
			_mPSearch.hide();
		}
	});
	appList.find('.appListMore').click(function (e) {
		e.preventDefault();

		$(this).hide();
		appList.find('.appListLess').show();
		appList.find('.appListUl.moreList').show();
	});
	appList.find('.appListLess').click(function (e) {
		e.preventDefault();

		$(this).hide();
		appList.find('.appListMore').show();
		appList.find('.appListUl.moreList').hide();
	});

	$(document).mouseup(function (e) {
		if (appList.is(':visible')) {
			if (!appList.is(e.target) && appList.has(e.target).length === 0) {
				appList.hide();
				appList.find('.appListMore').show();
				appList.find('.appListLess').hide();
				appList.find('.appListUl.moreList').hide();
			}
		}
		if (loginOption.is(':visible')) {
			loginOption.hide();
		}

		if (_mPSearch.is(':visible')) {
			_mPSearch.hide();
		}
	});
})(jQuery);
