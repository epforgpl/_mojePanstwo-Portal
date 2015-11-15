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
		$podatki.find('.closeAdditional:not(".closeEffect")').addClass('closeEffect').on('click', function () {
			var parent = $(this).parent();
			$(this).parent().slideUp(function () {
				parent.remove();
			})
		})
	}

	btnAction();

	$podatki.find('.section').each(function () {
		var sect = $(this);

		sect.find('button').click(function (e) {
			var $btn = $(this),
				btnType = $btn.attr('data-type'),
				$parent = $btn.parent(),
				number = Number($parent.attr('data-number')) + 1,
				content = $('<div></div>').addClass('additional').css('display', 'none');

			e.preventDefault();

			var id, name;

			if (btnType == 'przychody_umowa_o_prace') {
				id = 'przychody_umowa_o_prace_' + number;
				name = 'umowa_o_prace[]';
			} else if (btnType == 'przychody_umowa_zlecenie') {
				id = 'przychody_umowa_zlecenie_' + number;
				name = 'umowa_zlecenie[]';
			} else {
				id = 'przychody_umowa_o_dzielo_' + number;
				name = 'umowa_o_dzielo[]';
			}

			content.attr('data-number', number).append(
				$('<div></div>').addClass('form-group col-xs-10 col-sm-11').append(
					$('<input />').addClass('form-control').attr({
						'type': "number",
						'patern': "[0-9]+([\.|,][0-9]{2}+)?",
						'step': '0.01',
						'name': name,
						'title': mPHeart.translation.LC_PODATKI_INPUT_FLOAT,
						'id': id
					})
				)
			);

			content.append(
				$('<span></span>').addClass("closeAdditional glyphicon glyphicon-remove col-xs-2 col-sm-1").attr('aria-hidden', "true")
			);

			$parent.attr('data-number', number);
			$btn.before(content);
			content.slideDown();
			btnAction();
		})
	});
});
