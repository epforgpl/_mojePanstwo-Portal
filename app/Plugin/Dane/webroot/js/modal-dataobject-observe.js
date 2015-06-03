/*global $*/
$(document).ready(function () {
    "use strict";
    var observeModal = $('#observeModal');

    if (observeModal.length > 0) {
        observeModal.find('#checkbox_all').change(function () {
            if ($('#checkbox_all').prop('checked')) {
                observeModal.find('.checkbox input:not(#checkbox_all)').prop({
                    'checked': 'checked',
                    'disabled': 'disabled'
                });
            } else {
                observeModal.find('.checkbox input').prop('disabled', false);
            }
        });
        observeModal.find('.checkbox input').change(function () {
            if (observeModal.find('.alert').is(':visible')) {
                observeModal.find('.alert').slideUp('fast');
            }
        });
        observeModal.find('a.submit').click(function (e) {
            e.preventDefault();
            if (observeModal.find('.checkbox input:checked').length === 0) {
                observeModal.find('.alert').slideDown('fast');
            } else {
                observeModal.find('form').submit();
            }
        });
    }
});