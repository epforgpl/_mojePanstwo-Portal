/**
 * Created by tomekdrazewski on 17/06/15.
 */
$(document).ready(function () {

    $('#savebtn').click(function () {
        console.log();
        var form_data = {
            id: $('#id').text(),
            organ_wydajacy_str: $('#organ_wydajacy_str').val(),
            rocznik: $('#rocznik').val(),
            data_wydania: $('#data_wydania').val(),
            data_poprawiona: $('#data_poprawiona').val()
        }
        $.ajax({
            url: "./../update",
            method: "post",
            data: form_data,
            success: function (res) {
                if (res == false) {
                    alert("Wystąpił błąd");
                } else if (res == form_data.id) {
                    $('#info').html('Wpis w tablicy został zmieniony.');
                    $('#info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    });
});