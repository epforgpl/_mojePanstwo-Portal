/**
 * Created by tomaszdrazewski on 30/09/15.
 */
$(document).ready(function () {
	$('.btn-accept').click(function () {
		var $this = $(this);
		var form_data = {
			kandydat_id: $(this).parents('li.kandydat').data('kandydat-id'),
			krs_kandydat_id: $(this).parents('li.krs_osoba').data('krs-kandydat-id'),
			type: 'accept'
		};

		console.log(form_data);

		$.ajax({
			url: "/admin/krs_candidates/decide",
			method: "post",
			data: form_data,
			success: function (res) {
				if (res == false) {
					alert("Wystąpił błąd");
				} else if (res == 1) {
					$this.parents('li.kandydat').addClass('hidden');
				}
			},
			error: function (xhr) {
				alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
			}
		});
	});
	$('.btn-remove').click(function () {
		var $this = $(this);
		var form_data = {
			kandydat_id: $(this).parents('li.kandydat').data('kandydat-id'),
			krs_kandydat_id: $(this).parents('li.krs_osoba').data('krs-kandydat-id'),
			type: 'remove'
		};
		$.ajax({
			url: "/admin/krs_candidates/decide",
			method: "post",
			data: form_data,
			success: function (res) {
				if (res == false) {
					alert("Wystąpił błąd");
				} else if (res == 1) {
					$this.parents('li.krs_osoba').addClass('hidden');
					console.log($this.parents('li.krs_osoba'));
					if($this.parents('li.kandydat').find('li.krs_osoba').length==$this.parents('li.kandydat').find('li.krs_osoba.hidden').length){
						$this.parents('li.kandydat').addClass('hidden');
					}
				}
			},
			error: function (xhr) {
				alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
			}
		});
	});
	$('.btn-consider').click(function () {
		var $this = $(this);
		var form_data = {
			kandydat_id: $(this).parents('li.kandydat').data('kandydat-id'),
			krs_kandydat_id: $(this).parents('li.krs_osoba').data('krs-kandydat-id'),
			type: 'reconsider'
		};
		$.ajax({
			url: "/admin/krs_candidates/decide",
			method: "post",
			data: form_data,
			success: function (res) {
				if (res == false) {
					alert("Wystąpił błąd");
				} else if (res == 1) {
					$this.parents('li.kandydat').addClass('hidden');
				}
			},
			error: function (xhr) {
				alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
			}
		});
	});
})
