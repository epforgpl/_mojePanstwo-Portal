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
		$podatki.find('.closeAdditional:not(".closeEffect")').addClass('closeEffect').on('click', function (e) {
			e.preventDefault();
			var parent = $(this).closest('.row.additional');
			$(this).parent().slideUp(function () {
				parent.remove();
			})
		})
	}

	btnAction();

	$podatki.find('.section').each(function () {
		var sect = $(this);

		sect.find('.btn').click(function (e) {
			
			e.preventDefault();
			
			var $btn = $(this),
				btnType = $btn.attr('data-type'),
				row = $btn.closest('.row'),
				section = $btn.closest('.section');
				number = Number(row.attr('data-number')) + 1,
				content = $('<div></div>').addClass('additional').addClass('row').css('display', 'none'),
				
			console.log('row', row);
			console.log('section', section);

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
				$('<div class="col-xs-2 text-center nopadding col-xs-offset-5"></div>').append(
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
			
			
			
			content.append('<div class="col-xs-3"><a href="#" aria-hidden="true" class="closeAdditional glyphicon glyphicon-remove"></a></button>');

			// $parent.attr('data-number', number);
			section.append(content);
			content.slideDown();
			btnAction();
		})
	});
});
