
var $P = {
    objects: {
        adresaci: {}
    }
};

$(document).ready(function() {

    var $checkboxIsNGO = $('#UserIsNgo'),
        $selectOrganizationForm = $('.inputForm.selectOrganization').first(),
        $form = $('#UserRegisterForm'),
        $inputKrsName = $('input[name=krs_pozycje_nazwa]').first(),
        $inputObjectId = $('input[name=organization_object_id]').first();

    $checkboxIsNGO.click(function() {
        if($(this).is(':checked') === true) {
            $selectOrganizationForm.slideDown('slow', function() {});
        } else {
            $selectOrganizationForm.slideUp('slow', function() {});
        }
    });

    $form.submit(function() {
        if(typeof $P.objects.adresaci.object_id != 'undefined') {
            $inputKrsName.val($P.objects.adresaci.title);
            $inputObjectId.val($P.objects.adresaci.object_id);
        }
    });

});