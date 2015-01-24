$(document).ready(function () {
    var pismoBtn = $('.pisma-list-button');

    if (pismoBtn.length) {
        var pismoModal = $('<div></div>').addClass('modal fade').attr({
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
                    $('<div></div>').addClass('modal-body').css({'height': '65vh', 'overflow-y': 'auto'}).append(
                        $('<div></div>').addClass('loadingBlock').css({
                            'background': 'none',
                            'color': '#555'
                        }).append(
                            $('<div></div>').addClass('spinner').append(
                                $('<div></div>').css('background-color', '#555').addClass('bounce1')
                            ).append(
                                $('<div></div>').css('background-color', '#555').addClass('bounce2')
                            ).append(
                                $('<div></div>').css('background-color', '#555').addClass('bounce3')
                            )
                        ).append(
                            $('<p></p>').css('text-align', 'center').text("Ładowanie...")
                        )
                    )
                ).append(
                    $('<div></div>').addClass('modal-footer').append(
                        $('<button></button>').addClass('btn btn-default').attr('data-dismiss', 'modal').text('Zamknij')
                    ).append(
                        $('<button></button>').addClass('btn btn-primary disabled').text('Zatwierdź').click(function (e) {
                            var btn = $(this);

                            e.preventDefault();
                            if (btn.hasClass('disabled'))
                                return false;
                            $(this).css('width', $(this).outerWidth()).addClass('loading disabled').text('');
                            szablonChosen(pismoModal.find('ul.ul-raw li.active a >span').text(), pismoModal.find('ul.ul-raw li.active a').attr('data-szablonid'));
                        })
                    )
                )
            )
        );

        pismoBtn.click(function (e) {
            e.preventDefault();

            if (pismoModal.data('cache') == undefined) {
                var adresat_id = (pismoBtn.data('adresatid') != undefined) ? '?adresat_id=' + pismoBtn.data('adresatid') : '';
                $.get('http://mojepanstwo.pl:4444/pisma/templates/grouped.json' + adresat_id, function (data) {
                    pismoModal.data('cache', data);
                    szablonList(data)
                });
            } else {
                szablonList(pismoModal.data('cache'));
            }

            pismoModal.modal('show')
        });
    }

    function szablonList(data) {
        var list = $('<div></div>').addClass('list');

        $.each(data, function (key, value) {
            var listBlock = $('<div></div>').addClass('listBlock').append(
                $('<h4></h4>').text(value['nazwa'])
            ).append(
                $('<ul></ul>').addClass('ul-raw').css({
                    'list-style-type': 'none',
                    'padding': 0,
                    'line-height': '1em'
                })
            );
            $.each(value['templates'], function (name, obj) {
                listBlock.find('ul.ul-raw').append(
                    $('<li></li>').css({
                        'padding-top': '10px',
                        'border-top': '1px solid #ededed',
                        'padding': '8px 2%'
                    }).append(
                        $('<a></a>').attr({
                            'data-szablonId': obj['id'],
                            'href': '#' + value['nazwa'] + '-' + obj['nazwa']
                        }).css({
                            'display': 'block',
                            'color': '#555'
                        }).append(
                            $('<span></span>').css({'font-size': '13px', 'font-weight': 'bold'}).text(obj['nazwa'])
                        ).append(
                            $('<p></p>').css('font-size', '12px').text(obj['opis'])
                        )
                    )
                )
            });
            list.append(listBlock);
            list.find('ul.ul-raw li a').click(function (e) {
                e.preventDefault();
                pismoModal
                    .find('ul.ul-raw li.active').removeClass('active').css('background', 'none')
                    .end()
                    .find('.modal-footer .btn-primary.disabled').removeClass('disabled');
                $(this).parent('li').addClass('active').css('background', '#ededed');
            })
        });
        pismoModal.find('.modal-body').html(list);
    }

    function szablonChosen(szablon_name, szablon_id) {
        if (pismoBtn.hasClass('pisma-list-button-no-jump')) {
            if (szablon_name !== undefined && szablon_id != undefined) {
                var radios = $('.szablony .radio');
                radios.find('input').prop('checked', false);
                if (radios.find('input[name="szablon_id"][value="' + szablon_id + '"]').length > 0) {
                    radios.find('input[name="szablon_id"][value="' + szablon_id + '"]').prop('checked', 'checked')
                } else {
                    radios.last().after($('<div></div>').addClass('radio').append(
                        $('<label></label>').text(szablon_name).prepend(
                            $('<input>').attr({
                                'type': 'radio',
                                'value': szablon_id,
                                'name': 'szablon_id'
                            }).prop('checked', 'checked')
                        )
                    ));
                }
            }
            pismoModal.modal('hide');
            pismoModal.find('.modal-footer .btn.btn-primary').removeClass('loading').addClass('disabled').text('Zatwierdź');
            pismoModal.find('ul.ul-raw li.active').removeClass('active').css('background', 'none');
        } else {
            var method = (szablon_id !== undefined && pismoBtn.attr('data-adresatid') !== undefined) ? 'post' : 'get';
            var form = $('<form></form>').attr({
                'action': '/pisma',
                'method': method
            }).css('height', 0).append(
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
            form.submit();
        }
    }
});