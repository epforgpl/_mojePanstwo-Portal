$(document).on('change', '.btn-file :file', function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

$(document).ready(function () {
    var radioType = $('.form-group .radio'),
        domainBlock = $('.domainBlock');

    radioType.find('input[type="radio"]').change(function () {
        var inp = $(this);

        if (inp.val() === 'web') {
            domainBlock.removeClass('hide').find('input:disabled').removeAttr('disabled');
        } else {
            domainBlock.addClass('hide').find('input:disabled').attr('disabled', 'disabled');
        }
    });

    if (radioType.find('input[type="radio"]:checked').val() === 'domain')
        domainBlock.addClass('hide').find('input:disabled').attr('disabled', 'disabled');
});