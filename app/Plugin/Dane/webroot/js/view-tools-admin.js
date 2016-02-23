
$(document).ready(function() {

    var modal = $('#uprawnieniaModal'),
        form = modal.find('form');

    form.submit(function() {

        var header = $('.appHeader.dataobject').first(),
            dataset = header.attr('data-dataset'),
            object_id = header.attr('data-object_id'),
            inputs = $(this).serializeArray();

        $.ajax({
            url: '/dane/' + dataset + '/' + object_id + '.json',
            method: 'POST',
            data: inputs,
            success: function (res) {
                var undefined_error = 'Wystąpił nieznany błąd. Skontaktuj się z nami w celu rozwiązania problemu.';
                if(typeof res.response != 'undefined') {
                    if(typeof res.response.error != 'undefined') {
                        alert('Błąd: ' + res.response.error);
                        return false;
                    } else if(typeof res.response.row != 'undefined') {
                        alert('Dziękujemy za zgłoszenie! Wkrótce dostaniesz wiadomość email ze szczegółami.');
                        location.reload();
                    } else {
                        alert(undefined_error);
                    }
                } else {
                    alert(undefined_error)
                }
            }
        });

        return false;

    });

});