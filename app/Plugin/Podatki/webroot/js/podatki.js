/*global mPHeart*/

$(document).ready(function () {
	var $podatki = $('#podatki');

	function btnAction() {
		$podatki.find('input[type="number"]:not(".blurEffect")').addClass('blurEffect').on('blur', function () {
			var el = $(this);
			el.val(Number(el.val()).toFixed(2).replace(',', '.'));
		});
		$podatki.find('.checkbox:not(".checkEffect")').addClass('checkEffect').on('click', function () {
			var el = $(this);
			if (el.find('input[type="checkbox"]').is(':checked'))
				el.find('input[type="hidden"]').attr('disabled', 'disabled');
			else
				el.find('input[type="hidden"]').removeAttr('disabled');
		});
	}

	btnAction();

	$podatki.find('.section').each(function () {
		var sect = $(this);

		sect.find('button').click(function (e) {
			var $btn = $(this),
				btnType = $btn.attr('data-type'),
				$parent = $btn.parent(),
				number = Number($parent.attr('data-number')) + 1,
				content = $('<div></div>').addClass('additional').css('display', 'none').append(
					$('<span></span>').addClass("closeAdditional glyphicon glyphicon-remove").attr('aria-hidden', "true").on('click', function () {
						var parent = $(this).parent();
						$(this).parent().slideUp(function () {
							parent.remove();
						})
					})
				);

			e.preventDefault();

			if (btnType == 'przychody_dzialalnosc_gospodarcza') {
				content.attr('data-number', number).append(
					$('<div></div>').addClass('form-group').append(
						$('<label></label>').attr('for', 'przychody_dzialalnosc_gospodarcza_' + number).text(mPHeart.translation.LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA)
					).append(
						$('<input />').addClass('form-control').attr({
							'type': "number",
							'patern': "[0-9]+([\.|,][0-9]{2}+)?",
							'step': '0.01',
							'name': 'dzialalnosc_gospodarcza[]',
							'title': mPHeart.translation.LC_PODATKI_INPUT_FLOAT,
							'id': 'przychody_dzialalnosc_gospodarcza_' + number
						})
					)
				).append(
					$('<span></span>').addClass('info').text(mPHeart.translation.LC_PODATKI_INFO_FULL)
				).append(
					$('<div></div>').addClass('checkbox').append(
						$('<input/>').attr({
							'type': 'hidden',
							'id': 'warunki_preferencyjne_' + number + '_hidden',
							'name': 'warunki_preferencyjne[]',
							'value': 'N'
						})
					).append(
						$('<input/>').attr({
							'type': 'checkbox',
							'id': 'warunki_preferencyjne_' + number,
							'name': 'warunki_preferencyjne[]',
							'value': 'Y'
						})
					).append(
						$('<label></label>').attr('for', 'warunki_preferencyjne_' + number).text(mPHeart.translation.LC_PODATKI_WARUNKI_PREFERENCYJNE)
					)
				).append(
					$('<div></div>').addClass('form-group').append(
						$('<label></label>').attr('for', 'przychody_dzialalnosc_gospodarcza_koszt_' + number).text(mPHeart.translation.LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA_KOSZT)
					).append(
						$('<input />').addClass('form-control').attr({
							'type': "number",
							'patern': "[0-9]+([\.|,][0-9]{2}+)?",
							'step': '0.01',
							'name': 'dzialalnosc_gospodarcza_koszt[]',
							'title': mPHeart.translation.LC_PODATKI_INPUT_FLOAT,
							'id': 'przychody_dzialalnosc_gospodarcza_koszt_' + number
						})
					)
				)
			} else {
				var id, label, name;
				if (btnType == 'przychody_umowa_o_prace') {
					id = "przychody_umowa_o_prace_" + number;
					label = mPHeart.translation.LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE;
					name = "umowa_o_prace[]";
				} else {
					if (btnType == 'przychody_umowa_zlecenie') {
						id = 'przychody_umowa_zlecenie_' + number;
						label = mPHeart.translation.LC_PODATKI_PRZYCHODY_UMOWA_ZLECENIE;
						name = 'umowa_zlecenie[]';
					} else {
						id = 'przychody_umowa_o_dzielo_' + number;
						label = mPHeart.translation.LC_PODATKI_PRZYCHODY_UMOWA_DZIELO;
						name = 'umowa_o_dzielo[]';
					}
				}
				content.attr('data-number', number).append(
					$('<div></div>').addClass('form-group').append(
						$('<label></label>').attr('for', id).text(label)
					).append(
						$('<input />').addClass('form-control').attr({
							'type': "number",
							'patern': "[0-9]+([\.|,][0-9]{2}+)?",
							'step': '0.01',
							'name': name,
							'title': mPHeart.translation.LC_PODATKI_INPUT_FLOAT,
							'id': id
						})
					)
				).append(
					$('<span></span>').addClass('info').text(mPHeart.translation.LC_PODATKI_INFO_FULL)
				)
			}

			$parent.attr('data-number', number);
			$btn.before(content);
			content.slideDown();
			btnAction();
		})
	});
});
