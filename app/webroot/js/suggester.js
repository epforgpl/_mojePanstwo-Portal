/*global $, jQuery, ui, mPHeart*/
(function ($) {
    "use strict";

    var suggesterBlock = $('.suggesterBlock');
    //var suggesterBlock = $('input[data-autocompletion]');

    if (suggesterBlock.length) {
        $.each(suggesterBlock, function (index, block) {
            var suggesterCache = {},
                suggesterInput = $(block).find('input.form-control'),
            //suggesterInput = $(block),
                suggesterForm = suggesterInput.parents('form'),
                params;

            suggesterInput.autocomplete({
                minLength: 2,
                delay: 300,
                source: function (request, response) {
                    var term = request.term;
                    if (term in suggesterCache) {
                        response(suggesterCache[term]);
                    } else {
                        suggesterInput.addClass('loader');
                        $.get('/dane/suggest.json', {
                            'q': term,
                            'dataset[]': (suggesterInput.data('dataset')) ? suggesterInput.attr('data-dataset').split(',') : '*'
                        }).done(function (data) {
                            var results = $.map(data.options, function (item) {
                                var shortTitleLimit = 150,
                                    shortTitle = '';

                                if (item.payload !== undefined) {
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
                                        dataset: item.payload.dataset,
                                        image: (item.payload.image_url !== undefined) ? item.payload.image_url : false
                                    };
                                }
                            });

                            suggesterCache[term] = results;

                            if (results.length === 0) {
                                $('.ui-autocomplete').hide();
                                suggesterInput.removeClass('open loader');
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
                    suggesterInput.removeClass('loader');
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
                        window.location.href = ui.item.link;
                    }
                    return false;
                }
            }).autocomplete('widget').addClass("autocompleteSuggester");

            suggesterInput.data("ui-autocomplete")._renderItem = function (ul, item) {
                if (item.type !== 'item') {
                    if (item.type === 'button') {
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
                } else {
                    var title = $('<span></span>').text(item.shortTitle),
                        image;

                    if (item.image.length > 0) {
                        image = $('<img />').addClass('doc').attr('src', item.image);
                    } else {
                        image = $('<i></i>').addClass('icon icon-datasets-' + item.dataset);
                    }


                    if (item.detail) {
                        title.append($('<small></small>').text(item.detail));
                    } else {
                        title.addClass('vertical-center');
                    }

                    return $('<li></li>').addClass("row").append(
                        $('<a></a>').attr({'href': '/dane/' + item.link, 'target': '_self'}).append(
                            $('<div></div>').addClass('col-xs-2 col-md-1 _label').append(image)
                        ).append(
                            $('<div></div>').addClass('col-md-10 col-md-11 _title').append(title)
                        )
                    ).appendTo(ul);
                }
            };
        });
    }
}(jQuery));