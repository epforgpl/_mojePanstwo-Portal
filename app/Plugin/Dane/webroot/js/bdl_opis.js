$(document).ready(function () {
	
	$('#bdl_opis_form').submit(function(e){
		
		e.preventDefault();
		var form = $('#bdl_opis_form');
		
		$.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function (res) {
                if (res == false) {
                    alert("Błąd zapisu");
                } else {
                    if (res != null) {
                        $("#bdl_opis_modal .info").html('Zmieniono opis i nazwę.');
                    }
                    $('#bdl_opis_modal .info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });		
		
	});
	
	/*
    function saveData(dane) {
        $.ajax({
            url: decodeURIComponent(($('.appHeader.dataobject').attr('data-url')+'').replace(/\+/g, '%20')) + '.json',
            method: 'post',
            data: dane,
            success: function (res) {
                if (res == false) {
                    alert("Błąd zapisu");
                } else {
                    if (res != null) {
                        $("#bdl_opis_modal .info").html('Zmieniono opis i nazwę.');
                    }
                    $('#bdl_opis_modal .info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    }

    $("#bdl_savebtn").click(function () {

        dane = {
            _action: 'opis',
            tytul: $("#bdl_opis_modal .nazwa").val(),
            opis: $("#bdl_opis_modal .opis").val()
        };
        saveData(dane);
    });
    
    */

});
