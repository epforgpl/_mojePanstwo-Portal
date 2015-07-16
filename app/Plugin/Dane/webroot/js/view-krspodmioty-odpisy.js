
$(document).ready(function() {

    $('.btnUpdate').click(function() {

        var self = $(this),
            header = $('.appHeader.dataobject').first(),
            object_id = header.attr('data-object_id');

        $.ajax({

            url: '/dane/krs_podmioty/' + object_id + '/pobierz_nowy_odpis.json',
            method: 'GET',

            beforeSend: function() {
                self.addClass('loading disabled')
            },

            success: function(res) {
                self.removeClass('loading disabled');
            }

        });

    });

});