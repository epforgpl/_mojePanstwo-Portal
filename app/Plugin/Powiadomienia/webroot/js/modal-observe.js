/*global $*/
$(document).ready(function () {
    "use strict";
    var subsBlock = $('.data-subs'),
        observeModal = $('#observeModal'),
        observeModalOptions = observeModal.find('.modal-body .options');

    subsBlock.find('.list-subs li > .options').on('click', function () {
        var that = $(this),
            thatParent = that.parent(),
            data = thatParent.data();

        observeModal.find('.modal-body .header > span').empty().append(thatParent.find('.title > a').clone());
        observeModal.find('.modal-body >input[name="dataset"]').val(data.dataset);
        observeModal.find('.modal-body >input[name="object_id"]').val(data.id);

        observeModalOptions.addClass('loading').empty();

        observeModal.modal('show');

        $.get('/dane/' + data.dataset + '/' + data.id + '.json', function (result) {
            var rslt = result.layers,
                subsChannelId = [];

            $.each(rslt.subscription.SubscriptionChannel, function (key, value) {
                subsChannelId.push(value.channel)
            });

            observeModal.find('.modal-footer >a.unobserve').attr('data-subscription-id', rslt.subscription.Subscription.id);

            if (rslt.channels.length > 0) {
                observeModalOptions.append(
                    $('<div></div>').addClass('checkbox first').append(
                        $('<input/>').attr({
                            'type': 'checkbox',
                            'id': 'checkbox_all',
                            'name': 'channel[]'
                        }).val('')
                    ).append(
                        $('<label></label>').attr('for', 'checkbox_all').text('Wszystkie dane')
                    )
                );
                if (rslt.subscription.SubscriptionChannel.length == 0) {
                    observeModalOptions.find('.checkbox.first input').prop('checked', 'checked')
                }
                $.each(rslt.channels, function (key, value) {
                    observeModalOptions.append(
                        $('<div></div>').addClass('checkbox').append(
                            $('<input/>').attr({
                                'type': 'checkbox',
                                'id': 'checkbox_' + value.DatasetChannel.subject_dataset + '_' + value.DatasetChannel.channel,
                                'name': 'channel[]',
                                value: value.DatasetChannel.channel,
                                'checked': (($.inArray(value.DatasetChannel.channel, subsChannelId) > -1) || (rslt.subscription.SubscriptionChannel.length == 0)) ? 'checked' : false,
                                'disabled': (rslt.subscription.SubscriptionChannel.length == 0) ? 'disabled' : false
                            })
                        ).append(
                            $('<label></label>').attr('for', 'checkbox_' + value.DatasetChannel.subject_dataset + '_' + value.DatasetChannel.channel).text(value.DatasetChannel.title)
                        )
                    )
                });

                observeModalOptions.removeClass('loading');

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
        observeModal.find('a.unobserve').click(function (e) {
            var that = $(this);

            e.preventDefault();
            that.addClass('disabled');
            $.post('/dane/subscriptions/' + that.attr('data-subscription-id') + '/delete', function () {
                window.location.reload();
            })
        })
    });
});