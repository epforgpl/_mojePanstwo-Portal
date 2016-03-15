
var $P = {
    objects: {
        adresaci: {}
    }
};

$(document).ready(function() {

    var $modal = $('#ngo1Modal'),
        $ngoModalNo = $('#ngo1ModalNo'),
        $ngoModalYes = $('#ngo1ModalYes'),
        $form = $modal.find('.selectOrganization').first(),
        $submit = $('#ngo1ModalSubmit'),
        is_ngo = false;

    $modal.modal('show');

    $ngoModalNo.change(function() {
        $form.slideUp('slow', function() {});
        is_ngo = false;
    });

    $ngoModalYes.change(function() {
        $form.slideDown('slow', function() {});
        is_ngo = true;
    });

    $submit.click(function() {

        $.post('/paszport/user/setIsNgo', {
            is_ngo: is_ngo ? '1' : '0'
        }, function(data) {
            console.log(data);
        });

        if(is_ngo && $P.objects.adresaci.hasOwnProperty('object_id')) {

            $.post('/dane/krs_podmioty/' + $P.objects.adresaci.object_id + '.json', {
                _action: 'moderate_request',
                firstname: $('#ngo1ModalFirstNameInput').val(),
                lastname: $('#ngo1ModalLastNameInput').val(),
                organization: $P.objects.adresaci.title,
                position: $('#ngo1ModalFunctionInput').val(),
                email: $('#ngo1ModalEmailInput').val(),
                phone: $('#ngo1ModalPhoneNumberInput').val()
            }, function (res) {
                var undefined_error = 'Wystąpił nieznany błąd. Skontaktuj się z nami w celu rozwiązania problemu.';
                if(typeof res.response != 'undefined') {
                    if(typeof res.response.error != 'undefined') {
                        alert('Błąd: ' + res.response.error);
                        return false;
                    } else if(typeof res.response.row != 'undefined') {
                        alert('Dziękujemy za zgłoszenie! Wkrótce dostaniesz wiadomość email ze szczegółami.');
                        $modal.modal('hide');
                    } else {
                        alert(undefined_error);
                    }
                } else {
                    alert(undefined_error)
                }
            });
        } else {
            alert('Dziękujemy za odpowiedź');
            $modal.modal('hide');
        }

    });

});