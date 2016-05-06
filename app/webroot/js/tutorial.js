/*global $,jQuery,window,document,mpHeart,Cookies*/

$(document).ready(function () {
	var tutorialLogic = {
			'obserwuj': [
				{
					url: '/',
					steps: [{
						type: 'modal',
						text: '<p>Zyskaj bieżące informacje wcześniej niż inni, bądź poinformowany w waznych sprawach!</p><p>Powiadomienia pomogą Ci być na bieżąco z inicjatywami, gminami i ustawami, które chcesz obserwować. Pokażemy Ci teraz, jak to zrobić.</p><p>"Dzięki powiadomieniom, dowiedzieliśmy się, że nasz potencjany partner jest w stanie likwidacji. Dzieki temu uniknęliśmy przesięwzięcia skazanego na straty" Jacek Siadkowski z Fundacji Highlight/inaczej</p>',
						footer: '<button class="margin-bottom-5 btn btn-default" data-dismiss="modal">Anuluj samouczek</button><button class="margin-bottom-5 btn btn-primary nextStep">Przejdź dalej</button>'
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
						text: '<p>Oto twoje pierwsze powiadomienie! Możesz dodawać kolejne strony do powiadomień, oraz przeglądać swoje obecne powiadomienia.</p><div class="text-center"><button class="margin-bottom-5 btn btn-default btn-xs nextStep">OK</button></div>',
						background: false,
						exit: '.popover .nextStep'
					}, {
						type: 'modal',
						text: '<p>Brawo!</p><p>Nauczyłeś się jak dodawać powiadomienia. Zdobywasz informacje u źródła i oszczędzasz czas - wszystko co ważne trafia do powiadomień!</p><p class="text-center margin-top-30"><img src="/img/tutorial/obserwuj.png" alt="" /></p>',
						footer: '<button class="margin-bottom-5 btn btn-default" data-dismiss="modal">Zakończ ten samouczek</button><a href="/" target="_self" class="margin-bottom-5 btn btn-primary tutorialRepeat">Chcę dodać nowe powiadomienia</a><a href="/" target="_self" class="margin-bottom-5 btn btn-primary">Naucz się innego narzędzia</a>'
					}]
				}
			],
			'ngo_finanse': [
				{
					url: '/',
					steps: [{
						type: 'modal',
						text: '<p>Zyskaj dodatkową możliwość zbierania środków na działania Twojej organizacji! To narzędzie pomoże Ci w zbieraniu darowizn na Waszą aktywność. Wystarczy uzupełnić dane organizacji i podać nr konta. Pokażemy Ci, jak to zrobić :)</p>',
						footer: '<button class="margin-bottom-5 btn btn-default" data-dismiss="modal">Anuluj samouczek</button><button class="margin-bottom-5 btn btn-primary nextStep">Przejdź dalej</button>'
					}, {
						el: '#homepage ._mPSearchOutside .input-group',
						text: 'Wpisz w wyszukiwarce nazwę organizacji pozarządowej, którą reprezentujesz. Następnie wyszukaj NGO, klikając niebieski przycisk.',
						background: true
					}]
				}, {
					urlType: 'search',
					url: '?q=',
					steps: [{
						el: '.dataBrowser .app-row:first .col-md-8',
						text: 'Czy tego właśnie szukałeś? Jeśli tak - kliknij na daną organizację, a dowiesz się o niej więcej.',
						background: true,
						exit: '.dataBrowser .app-row:first .col-md-8'
					}]
				}, {
					url: null,
					steps: [{
						el: '.krsPodmioty .uprawnienia',
						text: '<p>Znajdujesz się na profilu swojej organizacji. Aby mieć możliwość edytowania znajdujących się tutaj danych, dodawania działań czy uzupełnienia nr konta, poproś o uprawnienia do zarządzania tym profilem.</p>',
						background: false,
						exit: '.krsPodmioty .uprawnienia .btn-primary'
					}, {
						el: '#uprawnieniaModal .modal-footer .btn-primary',
						text: '<p>Wypełnij swoje dane i raz jeszcze nazwę organizacji. W ciągu 72 godzin zwerfikujemy dane i przyznamy Ci dostęp do konta organizacji. Dzięki niemu bez dużego nakładu pracyzyskasz potencjalne źródło finansowania.</p><div class="text-center"><button class="margin-bottom-5 btn btn-default btn-xs popoverClose">Zamknij</button></div>',
						background: false,
						exit: '#uprawnieniaModal .modal-footer .btn-primary'
					}]
				}, {
					url: null,
					steps: [{
						type: 'modal',
						text: '<p>Super!</p><p>Przeszedłeś pierwszy etap uzupełniania konta swojej organizacji. Poczekaj teraz na maila z akeptacją Twojego zgłoszenia i uzupełnij konto o wybrane dane.</p><p class="text-center margin-top-30"><img src="/img/tutorial/ngo_finanse.png" alt="" /></p>',
						footer: '<button class="margin-bottom-5 btn btn-default" data-dismiss="modal">Zakończ ten samouczek</button><a href="/" target="_self" class="margin-bottom-5 btn btn-primary">Nauczy się innego narzędzia</a>'
					}]
				}
			],
			'konkursy_granty': [
				{
					url: '/',
					steps: [{
						type: 'modal',
						text: '<p>Dowiedz się pierwszy o konkursach dla Twojej organizacji i wysyłaj zgłoszenia na nie. Dzięki aplikacji wszystkie konkursy i granty znajdują się w jednym miejscu i nie musisz śledzić wielu stron. Pokażemy Ci, jak to zrobić!</p>',
						footer: '<button class="margin-bottom-5 btn btn-default" data-dismiss="modal">Anuluj samouczek</button><button class="margin-bottom-5 btn btn-primary nextStep">Przejdź dalej</button>'
					}, {
						el: '.appContent .appsList a[href="/ngo"]',
						text: 'Wejdź do aplikacji NGO i zobacz, najnowsze konkursy i granty.',
						background: false,
						exit: '.appContent .appsList a[href="/ngo"]'
					}]
				}, {
					url: '/ngo',
					steps: [{
						el: '.dataBrowserContent .buttons.larger',
						text: '<p>Kliknij "Subskrybuj" i otrzymuj powiadomienia o każdym nowym konkursie z kategorii, która Cię interesuje.',
						background: false,
						exit: '.dataBrowserContent .buttons.larger'
					}, {
						el: '#observeModal .modal-footer .btn-primary',
						text: '<p>Wybierz kategorie konkursów, które Cię interesują i kliknij "Zapisz".</p>',
						background: false,
						exit: '#observeModal .modal-footer .submit'
					}]
				}, {
					url: null,
					steps: [{
						type: 'modal',
						text: '<p>Gratulacje!</p><p>Teraz nie ominą Cię żadne informacje o nowych konkursach i grantach! Informacje o nich otrzymasz w zakładce "Powiadomienia" na stronie głównej.</p><p class="text-center margin-top-30"><img src="/img/tutorial/konkursy_granty.png" alt="" /></p>',
						footer: '<button class="margin-bottom-5 btn btn-default" data-dismiss="modal">Zakończ ten samouczek</button><a href="/" target="_self" class="margin-bottom-5 btn btn-primary">Nauczy się innego narzędzia</a>'
					}]
				}
			],
			'pisma_dostep_do_informacji': [
				{
					url: '/',
					steps: [{
						type: 'modal',
						text: '<p>Poznaj narzędzie, które upraszcza załatwianie spraw w instytucjach publicznych i w łatwy sposób pokazuje, jak wysłać wniosek o dostęp do informacji publicznej. Pokażemy Ci, jak to zrobić!</p>',
						footer: '<button class="margin-bottom-5 btn btn-default" data-dismiss="modal">Anuluj samouczek</button><button class="margin-bottom-5 btn btn-primary nextStep">Przejdź dalej</button>'
					}, {
						el: '.app-sidebar .app-list a[href="moje-pisma"]',
						text: 'Skorzystaj z przygotowanego kreatora pism i usprawnij wysyłanie pism, do posiadanej przez nas bazy instytucji!',
						background: false,
						exit: '.app-sidebar .app-list a[href="moje-pisma"]'
					}]
				}, {
					url: '/moje-pisma',
					steps: [{
						el: '.objectsPage .btn-success.btn-icon.submit',
						text: '<p>Kliknij "Stworz nowe pismo", aby przejść do kreatora pism.</p>',
						background: false,
						exit: '.objectsPage .btn-success.btn-icon.submit'
					}]
				}, {
					url: '/moje-pisma/nowe',
					steps: [{
						el: '.form-group.form-row:first .radio:nth(1)',
						text: '<p>Wybierz szablon dotyczący wniosku do informacji publicznej.</p>',
						background: false,
						exit: '.form-group.form-row:first .radio:nth(1)'
					}, {
						el: '.objectsPage .suggesterBlockPisma',
						text: '<p>Rozpocznij wpisywanie adresata, a system podpowie Ci sugestie.</p>',
						background: false,
						exit: '.objectsPage .suggesterBlockPisma'
					}, {
						el: '.objectsPage .createBtn',
						text: '<p>Wciśnij "Stwórz pismo" aby przejść do drugiego kroku pozwalającego uzupełnić m.in. nadawcę, formę, treści.</p>',
						background: false,
						exit: '.objectsPage .createBtn'
					}]
				}, {
					url: null,
					steps: [{
						el: '.form-letter .mp-form-letter:first',
						text: '<p>Wpisz, jakich informacji potrzebujesz od instytucji publicznej. Nasz kreator umieści ten akapit we właściwym miejscu pisma. Uzupełnij również adres mailowy, na który powinna zostać wysłana odpowiedź z instytucji, do której składasz wniosek. W obszarze "Dodatkowe informacje o piśmie" znajdziesz pola, które nie są obowiązkowe do uzupełnienia.</p>',
						background: false,
						exit: '.objectsPage .createBtn'
					}]
				}, {
					url: null,
					steps: [{
						el: '.objectsPage .lettersSend i',
						text: '<p>Jeśli wszelkie informacje są poprawne kliknij "Wyślij pismo".</p>',
						background: false,
						exit: '.objectsPage .lettersSend'
					}, {
						el: '#sendPismoModal .modal-footer .btn-primary i',
						text: '<p>Pismo zostanie wysłane na podane dane - kliknij "Wyślij pismo" aby zakończyć ostatni krok.</p>',
						background: false,
						exit: '#sendPismoModal .modal-footer .btn-primary'
					}]
				}, {
					url: null,
					steps: [{
						type: 'modal',
						text: '<p>Brawo!</p><p>Udało Ci się wysłać pismo do instytucji publicznej w ważnej dla Ciebie sprawie! Przed upływem 14 dni wyślemy na Twój adres mailowy przypomnienie o upływie terminu oraz o możliwych dalszych krokach. Jeśli natomiast otrzymasz odpowiedz, możesz ją opublikować na naszym portalu. Wystarczy w zakładce "Moje Pisma" na stronie głównej odnaleźć właściwe pismo i dodać do niego odpowiedź.</p><p class="text-center margin-top-30"><img src="/img/tutorial/pisma_dostep_do_informacji.png" alt="" /></p>',
						footer: '<button class="margin-bottom-5 btn btn-default" data-dismiss="modal">Zakończ ten samouczek</button><a href="/" target="_self" class="margin-bottom-5 btn btn-primary">Nauczy się innego narzędzia</a>'
					}]
				}
			]
		},
		mPCookie,
		checkExist;

	if (Cookies.get('mojePanstwo') !== undefined) {
		mPCookie = $.extend(true, {}, Cookies.getJSON('mojePanstwo'));
	}

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

		if ($('.popover .popoverClose').length) {
			$('.popover .popoverClose').click(function () {
				$(this).parents('.popover').popover('hide');
			});
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

	var userStatus = function () {
		$.ajax({
			url: '/paszport/tutoriale.json',
			type: 'GET',
			success: function (res) {
				for (var i = 0; i < res.length; i++) {
					if (res[i].completed == false) {
						console.log(mPCookie);
						mPCookie.tutorial = {
							id: res[i].id,
							step: 0,
							option: res[i].slug
						};
						console.log(mPCookie, res[i], res[i].slug);
						Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
						runTutorial();
						break;
					}
					console.log(res[i]);
				}

				if (typeof mPCookie.tutorial == 'undefined') {
					mPCookie.tutorial = {
						step: 0,
						option: null
					};
					Cookies.set('mojePanstwo', JSON.stringify(mPCookie), {expires: 365, path: '/'});
				}
			}
		});
	};

	var runTutorial = function () {
		var stepNumber = mPCookie.tutorial.step,
			logic = tutorialLogic[mPCookie.tutorial.option],
			step = logic[stepNumber];

		if (typeof step === "undefined") {
			$.ajax({
				url: '/paszport/tutoriale/' + mPCookie.tutorial.id + '.json',
				type: 'POST',
				data: {
					completed: true
				},
				success: function (res) {
					if (res == true) {
						userStatus();
					} else {
						//TODO: error trigger
					}
				}
			});
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
	};

	console.log(mPCookie, typeof mPCookie.tutorial);

	if (typeof mPCookie.tutorial !== "undefined" && mPCookie.tutorial.option !== null) {
		runTutorial();
	} else {
		userStatus();
	}
});
