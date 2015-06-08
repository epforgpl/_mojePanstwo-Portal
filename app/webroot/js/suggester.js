/*global $, jQuery, ui, mPHeart*/
(function ($) {
    "use strict";

    var suggesterBlock = $('.suggesterBlock');

    if (suggesterBlock.length) {
        $.each(suggesterBlock, function (index, block) {
            var suggesterInput = $(block).find('input.form-control'),
                suggesterBtn = $(block).find('.input-group-btn .btn'),
                suggesterCache = {};

            suggesterInput.autocomplete({
                minLength: 2,
                delay: 200,
                source: function (request, response) {
                    var term = request.term;

                    suggesterBtn = this.element.parents('form').find('.input-group-btn .btn');
                    if (term in suggesterCache) {
                        response(suggesterCache[term]);
                    } else {
                        suggesterBtn.addClass('loading');

                        $.get('/dane/suggest.json', {
                            'q': term,
                            'dataset[]': (suggesterInput.data('dataset')) ? suggesterInput.attr('data-dataset').split(',') : '*'
                        }).done(function (data) {
                            var results = $.map(data.options, function (item) {
                                var shortTitleLimit = 200,
                                    shortTitle = '';

                                if (item.payload.dataset === 'twitter') {
                                    shortTitle = item.text.replace(/(<([^>]+)>)/ig, "");
                                } else {
                                    if (item.text.length > shortTitleLimit) {
                                        shortTitle = item.text.substr(0, shortTitleLimit);
                                        shortTitle = shortTitle.substr(0, Math.min(shortTitle.length, shortTitle.lastIndexOf(" "))) + '...';
                                    } else {
                                        shortTitle = item.text;
                                    }
                                }

                                return {
                                    type: 'item',
                                    title: item.text,
                                    shortTitle: shortTitle,
                                    value: item.payload.object_id,
                                    link: item.payload.dataset + '/' + item.payload.object_id + ((item.payload.slug) ? ',' + item.payload.slug : ''),
                                    dataset: item.payload.dataset
                                };
                            });

                            suggesterCache[term] = results;

                            if (results.length === 0) {
                                $('.ui-autocomplete').hide();
                                suggesterInput.removeClass('open');
                                suggesterBtn.removeClass('loading');
                            } else {
                                results.push({
                                    type: 'button',
                                    q: request.term
                                });
                                response(results);
                            }
                        });
                    }
                },
                open: function () {
                    var $ui = $('#ui-id-' + index);

                    $ui.css({
                        'margin-top': Math.floor((suggesterInput.offset().top + suggesterInput.outerHeight()) - parseInt($ui.css('top'), 10) - parseInt($ui.css('border-bottom-left-radius'), 10)) + 'px',
                        'width': suggesterInput.outerWidth() - 2,
                        'left': parseInt($ui.css('left'), 10) + 1 + 'px'
                    });
                    suggesterInput.addClass('open');
                    suggesterBtn.removeClass('loading');
                },
                close: function () {
                    suggesterInput.removeClass('open');
                },
                focus: function () {
                    return false;
                },
                select: function (ui) {
                    if (ui.item) {
                        suggesterInput.val(ui.item.title);
                    }
                    window.location.href = ui.item.link;
                    return false;
                }
            }).autocomplete('widget').addClass("autocompleteSuggester");

            suggesterInput.data("ui-autocomplete")._renderItem = function (ul, item) {
                if (item.type === 'item') {
                    return $('<li></li>').addClass("row").append(
                        $('<a></a>').attr({'href': '/dane/' + item.link, 'target': '_self'}).append(
                            $('<div></div>').addClass('col-xs-2 col-md-1 _label').append(
                                $('<i></i>').addClass('icon icon-applications-' + item.dataset)
                            )
                        ).append(
                            $('<div></div>').addClass('col-md-10 col-md-11 _title').append(
                                $('<span></span>').text(item.shortTitle)
                            )
                        )
                    ).appendTo(ul);
                } else if (item.type === 'button') {
                    var suggesterForm = suggesterInput.parents('form'),
                        params = '?q=' + item.q;

                    suggesterForm.find('input[name="dataset[]"]').each(function () {
                        params += '&dataset[]=' + $(this).val();
                    });

                    return $('<li></li>').addClass("row button").append(
                        $('<a></a>').addClass('btn btn-success').attr({
                            'href': ((suggesterForm.attr('action').length > 0) ? suggesterForm.attr('action') : ((suggesterInput.attr('data-url').length > 0) ? suggesterInput.attr('data-url') : '')) + params,
                            'target': '_self'
                        }).html('<span class="glyphicon glyphicon-search"> </span> ' + mPHeart.suggester.fullSearch)
                    ).appendTo(ul);
                }
            };
        });
    }
}(jQuery));