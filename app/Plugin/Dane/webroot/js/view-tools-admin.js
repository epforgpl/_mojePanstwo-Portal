
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
                location.reload();
            }
        });

        return false;

    });

});