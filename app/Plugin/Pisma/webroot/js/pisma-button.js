/*global $,jQuery*/

$(document).ready(function () {
    "use strict";

    var pismoBtn = $('.pisma-list-button'),
        obserwujBtn = $('.obserwuj-button'),
        pismoModal,
        obserwujModal,
        method,
        form;

    function szablonList(data) {
        var list = $('<div></div>').addClass('list');

        $.each(data, function (key, value) {
            var listBlock = $('<div></div>').addClass('listBlock').append(
                $('<h4></h4>').text(value.nazwa)
            ).append(
                $('<ul></ul>').addClass('ul-raw')
            );
            $.each(value.templates, function (name, obj) {
                listBlock.find('ul.ul-raw').append(
                    $('<li></li>').append(
                        $('<a></a>').attr({
                            'data-szablonId': obj.id,
                            'href': '#' + value.nazwa + '-' + obj.nazwa
                        }).append(
                            $('<span></span>').text(obj.nazwa)
                        ).append(
                            $('<p></p>').text(obj.opis)
                        )
                    )
                );
            });
            list.append(listBlock);
            list.find('ul.ul-raw li a').click(function (e) {
                e.preventDefault();
                pismoModal
                    .find('ul.ul-raw li.active').removeClass('active')
                    .end()
                    .find('.modal-footer .btn-primary.disabled').removeClass('disabled');
                $(this).parent('li').addClass('active');

                szablonChosen(pismoModal.find('ul.ul-raw li.active a >span').text(), pismoModal.find('ul.ul-raw li.active a').attr('data-szablonid'));
            });
        });
        pismoModal.find('.modal-body').html(list);
    }

    function szablonChosen(szablon_name, szablon_id) {
        if (pismoBtn.hasClass('pisma-list-button-no-jump')) {
            if (szablon_name !== undefined && szablon_id !== undefined) {
                var radios = $('.szablony .radio');
                radios.find('input').prop('checked', false);
                if (radios.find('input[name="szablon_id"][value="' + szablon_id + '"]').length > 0) {
                    radios.find('input[name="szablon_id"][value="' + szablon_id + '"]').prop('checked', 'checked');
                } else {
                    radios.last().after($('<div></div>').addClass('radio').append(
                        $('<input>').attr({
                            'id': 'wniosek_' + szablon_id,
                            'type': 'radio',
                            'value': szablon_id,
                            'name': 'szablon_id'
                        }).prop('checked', 'checked')
                    ).append(
                        $('<label></label>').attr('for', 'wniosek_' + szablon_id).text(szablon_name)
                    ));
                }
            }
            pismoModal.modal('hide');
            pismoModal.find('.modal-footer .btn.btn-primary').removeClass('loading').addClass('disabled').text('Zatwierdź');
            pismoModal.find('ul.ul-raw li.active').removeClass('active');
        } else {
            method = (szablon_id !== undefined && pismoBtn.attr('data-adresatid') !== undefined) ? 'post' : 'get';
            form = $('<form></form>').attr({
                'action': '/pisma',
                'method': method,
                'class': 'pismaGenerateModalForm'
            }).append(
                $('<input>').attr({
                    'name': 'szablon_id',
                    'type': 'text',
                    'value': szablon_id
                })
            ).append(
                $('<input>').attr({
                    'name': 'adresat_id',
                    'type': 'text',
                    'value': pismoBtn.data('adresatid')
                })
            );
            pismoModal.append(form);

            pismoModal.find('form').submit();
        }
    }

    if (pismoBtn.length) {
        pismoModal = $('<div></div>').addClass('modal fade').attr({
            'id': 'pismaGenerateModal',
            'tabindex': '-1',
            'role': 'dialog',
            'aria-labelledby': 'pismaGenerateModalHandle',
            'aria-hidden': 'hidden'
        }).append(
            $('<div></div>').addClass('modal-dialog').append(
                $('<div></div>').addClass('modal-content').append(
                    $('<div></div>').addClass('modal-header').append(
                        $('<button></button>').addClass('close').attr({
                            'type': 'button',
                            'data-dismiss': 'modal',
                            'arial-label': 'Close'
                        }).append(
                            $('<span></span>').attr('aria-hidden', 'true').html('&times;')
                        )
                    ).append(
                        $('<h4></h4>').addClass('modal-title').attr('id', 'pismaGenerateModalHandle').text('Wybierz szablon')
                    )
                ).append(
                    $('<div></div>').addClass('modal-body').append(
                        $('<div></div>').addClass('loadingBlock').append(
                            $('<div></div>').addClass('spinner').append(
                                $('<div></div>').addClass('bounce1')
                            ).append(
                                $('<div></div>').addClass('bounce2')
                            ).append(
                                $('<div></div>').addClass('bounce3')
                            )
                        ).append(
                            $('<p></p>').text("Ładowanie...")
                        )
                    )
                ).append(
                    $('<div></div>').addClass('modal-footer').append(
                        $('<button></button>').addClass('btn btn-default').attr('data-dismiss', 'modal').text('Zamknij')
                    )
                )
            )
        );

        pismoBtn.click(function (e) {
            e.preventDefault();

            if (pismoModal.data('cache') === undefined) {
                var adresat_id = (pismoBtn.data('adresatid') !== undefined) ? '?adresat_id=' + pismoBtn.data('adresatid') : '';
                $.get('http://mojepanstwo.pl:4444/pisma/templates/grouped.json' + adresat_id, function (data) {
                    pismoModal.data('cache', data);
                    szablonList(data);
                });
            } else {
                szablonList(pismoModal.data('cache'));
            }

            pismoModal.modal('show');
        });
    }


    if (obserwujBtn.length) {
        obserwujModal = $('<div></div>').addClass('modal fade').attr({
            'id': 'obserwujGenerateModal',
            'tabindex': '-1',
            'role': 'dialog',
            'aria-labelledby': 'obserwujGenerateModalHandle',
            'aria-hidden': 'hidden'
        }).append(
            $('<div></div>').addClass('modal-dialog').append(
                $('<div></div>').addClass('modal-content').append(
                    $('<div></div>').addClass('modal-header').append(
                        $('<button></button>').addClass('close').attr({
                            'type': 'button',
                            'data-dismiss': 'modal',
                            'arial-label': 'Close'
                        }).append(
                            $('<span></span>').attr('aria-hidden', 'true').html('&times;')
                        )
                    ).append(
                        $('<h4></h4>').addClass('modal-title').attr('id', 'obserwujGenerateModalHandle').text('Obserwowanie')
                    )
                ).append(
                    $('<div></div>').addClass('modal-body').append(
                        $('<div></div>').addClass('loadingBlock').append(
                            $('<p></p>').html("Po kliknięciu przycisku <b>\"Obserwuj\"</b>, Twój personalny feed powiadomień będzie zawierał dane pochodzące od Ministerstwo. W każdej chwili będziesz mógł wyłączyć tę funkcję, klikając na tej stronie przycisk <b>\"Przestań obserwować\"</b>")
                        )
                    )
                ).append(
                    $('<div></div>').addClass('modal-footer').append(
                        $('<button></button>').addClass('btn btn-default').attr('data-dismiss', 'modal').text('Zamknij')
                    ).append(
                        $('<button></button>').addClass('btn btn-primary btn-subscribe').text('Obserwuj').click(function (e) {
                            var btn = $(this);

                            e.preventDefault();

                            if (!btn.hasClass('disabled')) {
                                btn.addClass('disabled');
                                $.post('/dane/dataobjects/' + btn.attr('data-objectid') + '/subscribe.json', function () {
                                    btn.removeClass('disabled');
                                });
                            }
                        })
                    )
                )
            )
        );

        obserwujBtn.click(function (e) {
            e.preventDefault();
            obserwujModal.modal('show').find('.btn-subscribe').attr('data-objectid', obserwujBtn.attr('data-objectid'));
        });
    }
});