$(document).ready(function () {

    $('#bdl_opis_modal #editor').wysihtml5({
        toolbar: {
            "font-styles": true, //Font styling, e.g. h1, h2, etc.
            "emphasis": true, //Italics, bold, etc.
            "lists": false, //(Un)ordered lists, e.g. Bullets, Numbers.
            "html": false, //Button which allows you to edit the generated HTML.
            "link": true, //Button to insert a link.
            "image": false, //Button to insert an image.
            "color": false, //Button to change color of font
            "blockquote": false
        },
        'locale': 'pl-NEW',
        parser: function (html) {
            return html;
        }
    });

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
            opis: $("#bdl_opis_modal .editor").html()
        };
        saveData(dane);
    });

});