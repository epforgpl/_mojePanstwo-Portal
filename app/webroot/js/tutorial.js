/*global $,jQuery,window,document,mpHeart,Cookies*/

$(document).ready(function () {
	var tutorialLogic = {
			'obserwuj': [
				{
					url: '/',
					steps: [{
						type: 'modal',
						text: '<p>Zyskaj bieżące informacje wcześniej niż inni, bądź poinformowany w waznych sprawach!</p><p>Powiadomienia pomogą Ci być na bieżąco z inicjatywami, gminami i ustawami, które chcesz obserwować. Pokażemy Ci teraz, jak to zrobić.</p><p>"Dzięki powiadomieniom, dowiedzieliśmy się, że nasz potencjany partner jest w stanie likwidacji. Dzieki temu uniknęliśmy przesięwzięcia skazanego na straty" Jacek Siadkowski z Fundacji Highlight/inaczej</p>',
						footer: '<button class="btn btn-default" data-dismiss="modal">Anuluj samouczek</button><button class="btn btn-primary nextStep">Przejdź dalej</button>'
					}, {
						el: '#homepage ._mPSearchOutside .input-group',
						text: 'Wpisz w wyszukiwarce gminę z której pochodzisz lub NGO, którego działalność Cię interesuje. Ważne, by był to podmiot, którego działalność chcesz obserwować. Następnie wyszukaj wpisane hasło, klikając niebieski przycisk lupy.',
						background: true
					}]
				},
				{
					urlType: 'search',
					url: '?q=',
					steps: [{
						el: '.dataBrowser .app-row:first .col-md-8',
						text: 'Czy tego właśnie szukałeś? Jeśli tak - kliknij hasło, a dowiesz się o nim więcej.',
						background: true,
						exit: '.dataBrowser .app-row:first .col-md-8'
					}]
				}, {
					url: null,
					steps: [{
						el: '.DataObjectOptions .option:first',
						text: '<p>Kliknij teraz "Obserwuj". Od tej pory wiesz jako pierwszy o ważnych aktualizacjach na tej stronie.</p><p>Dzięki powiadomieniom będziesz zawsze na bieżąco w najważniejszych dla Ciebie sprawach.</p>',
						background: false,
						exit: '.DataObjectOptions .option:first'
					}, {
						el: '#observeModal .modal-footer .submit',
						text: '<p>Kliknij teraz "Zapisz" by obserwować tę stronę.</p><p>Możesz później tu wrócić, by wybrać szczegółowo dane, których potrzebujesz.</p>',
						background: false,
						exit: '#observeModal .modal-footer .submit'
					}]
				}, {
					url: null,
					steps: [{
						el: '#portal-header .mpLogoBlock',
						text: 'Wróć teraz do strony głównej.',
						background: true
					}]
				}, {
					url: '/',
					steps: [{
						el: '.app-sidebar .app-list a[href="moje-powiadomienia"]',
						text: 'Kliknij "moje powiadomienia" by zobaczyć nowe powiadomienia.',
						background: false,
						exit: '.app-sidebar .app-list a[href="moje-powiadomienia"]'
					}]
				}, {
					url: '/moje-powiadomienia',
					steps: [{
						el: '.dataObjects .objectRender:first',
						text: '<p>Oto twoje pierwsze powiadomienie! Możesz dodawać kolejne strony do powiadomień, oraz przeglądać swoje obecne powiadomienia.</p><div class="text-center"><button class="btn btn-default btn-xs nextStep">OK</button></div></button>',
						background: false,
						exit: '.popover .nextStep'
					}, {
						type: 'modal',
						text: '<p>Brawo!</p><p>Nauczyłeś się jak dodawać powiadomienia. Zdobywasz informacje u źródła i oszczędzasz czas - wszystko co ważne trafia do powiadomień!</p><p class="text-center margin-top-30"><img src="/img/tutorial/obserwuj.png" alt="" /></p>',
						footer: '<button class="btn btn-default" data-dismiss="modal">Zakończ ten samouczek</button><a href="/" target="_self" class="btn btn-primary tutorialRepeat">Przejdź go jeszcze raz</a>'
					}]
				}
			]
		},
		mPCookie = {
			tutorial: {
				step: 0,
				option: 'obserwuj'
			}
		},
		checkExist;

	var showModal = function (pos, steps) {
		var step = steps[pos],
			modal = $('<div></div>').addClass('modal fade gamification').attr({
				id: 'tutorialModal',
				tabindex: '-1',
				role: 'dialog'
			}).append(
				$('<div></div>').addClass('modal-dialog').append(
					$('<div></div>').addClass('modal-content').append(
						$('<div></div>').addClass('modal-body').html(step.text)
					)
				)
			);

		if (step.footer !== "undefined") {
			modal.find('.modal-dialog .modal-content').append($('<div></div>').addClass('modal-footer text-center').html(step.footer));
		}

		if ($('.modal-backdrop').length) {
			$('.modal-backdrop').remove();
		}

		if ($('#tutorialModal').length) {
			$('#tutorialModal').remove();
		}

		$('body').append(modal);

		modal.modal({backdrop: 'static', keyboard: false});
		modal.modal('show');

		if (modal.find('.nextStep').length) {
			modal.find('.nextStep').one("click", function (e) {
				var next = steps[pos + 1];

				e.preventDefault();

				modal.modal('hide');

				if (typeof next !== "undefined") {
					if (typeof next.type !== "undefined" && next.type === "modal") {
						showModal(pos + 1, steps);
					} else {
						showPopup(pos + 1, steps);
					}
				} else {
					if (typeof steps[pos + 1] === "undefined") {
						mPCookie.tutorial.step++;
						Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
					}
				}
			});
		} else {
			if (typeof steps[pos + 1] === "undefined") {
				mPCookie.tutorial.step++;
				Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
			}
		}

		if ($('.tutorialRepeat').length) {
			$('.tutorialRepeat').click(function () {
				mPCookie.tutorial.step = 0;
				Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
			});
		}
	};

	var showPopup = function (pos, steps) {
		var step = steps[pos];

		if ($('.popup-backdrop').length === 0 && step.background !== false) {
			$('body').append(
				$('<div></div>').addClass('popup-backdrop')
			);
		}

		checkExist = setInterval(function () {
			if ($(step.el).is(':visible')) {
				clearInterval(checkExist);

				if (step.background === true) {
					$(step.el).css({
						'position': 'relative',
						'z-index': 9990
					});
				}

				$(step.el).attr({
					'data-container': "body",
					'data-toggle': "popover",
					'data-placement': "top auto",
					'data-trigger': "manual",
					'data-html': "true",
					'data-content': step.text
				}).popover('show');

				if (typeof step.exit !== "undefined") {
					$(step.exit).one("click", function () {
						var next = steps[pos + 1];

						$(step.el).popover('destroy');

						if (typeof next !== "undefined") {
							if (typeof next.type !== "undefined" && next.type === "modal") {
								if ($('.popup-backdrop').length) {
									$('.popup-backdrop').remove();
								}
								showModal(pos + 1, steps);

							} else {
								showPopup(pos + 1, steps);
							}
						} else {
							if (typeof steps[pos + 1] === "undefined") {
								mPCookie.tutorial.step++;
								Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
							}
						}
					});
				} else {
					if (typeof steps[pos + 1] === "undefined") {
						mPCookie.tutorial.step++;
						Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
					}
				}

				if ($('.tutorialRepeat').length) {
					$('.tutorialRepeat').click(function () {
						mPCookie.tutorial.step = 0;
						Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
					});
				}
			}
		}, 1000);
	};

	if (Cookies.get('mojePanstwo') !== undefined) {
		mPCookie = $.extend(true, mPCookie, Cookies.getJSON('mojePanstwo'));
	}

	if (typeof mPCookie.tutorial !== "undefined" && mPCookie.tutorial.option !== null) {
		var stepNumber = mPCookie.tutorial.step,
			logic = tutorialLogic[mPCookie.tutorial.option],
			step = logic[stepNumber];

		if (typeof step === "undefined") {
			mPCookie.tutorial = {
				step: 0,
				option: null
			};
			Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
		} else {
			if ((typeof step.urlType !== "undefined" && step.urlType === "search" && window.location.search.substring(0, step.url.length) === step.url) || (step.url === window.location.pathname) || step.url === null) {
				var s = 0;

				if (typeof step.steps[s].type !== "undefined" && step.steps[s].type === "modal") {
					showModal(s, step.steps);
				} else {
					showPopup(s, step.steps);
				}
			}
		}
	}
});
