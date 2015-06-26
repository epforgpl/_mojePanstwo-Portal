$(document).ready(function () {

    $('#editor').wysihtml5({
        'locale': 'pl-PL',
        parser: function (html) {
            return html;
        }
    });

    function saveData(dane) {
        $.ajax({
            method: 'post',
            data: dane,
            success: function (res) {
                if (res == false) {
                    alert("Błąd zapisu");
                } else {
                    if (res != null) {
                        $("#info").html('Zmieniono opis i nazwę.');
                    }
                    $('#info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }

        });
    }

    $("#bdl_savebtn").click(function () {

        var dane = {
            nazwa: $("#nazwa").val(),
            opis: $("#editor").html()
        };
        saveData(dane);
    });

});