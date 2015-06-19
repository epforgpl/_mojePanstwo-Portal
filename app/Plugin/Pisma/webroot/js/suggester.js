/*global $, jQuery, ui, mPHeart*/
(function ($) {
    "use strict";

    var suggesterBlock = $('.suggesterBlockPisma');

    if (suggesterBlock.length) {
        $.each(suggesterBlock, function (index, block) {
            var suggesterCache = {},
                suggesterInput = $(block).find('input.form-control'),
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
                                        link: '/dane/' + item.payload.dataset + '/' + item.payload.object_id + ((item.payload.slug) ? ',' + item.payload.slug : ''),
                                        dataset: item.payload.dataset,
                                        image: (item.payload.image_url !== undefined) ? item.payload.image_url : false
                                        //sub_dataset: (item.payload.sub_dataset) ? item.payload.sub_dataset : false,
                                        //sub_id: (item.payload.sub_id) ? item.payload.sub_id : false
                                    };
                                }
                            });

                            suggesterCache[term] = results;

                            if (results.length === 0) {
                                $('.ui-autocomplete').hide();
                                suggesterInput.removeClass('open loader');
                            } else {
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
                select: function (evt, ui) {
                    if (ui.item) {
                        suggesterInput.val(ui.item.title);
                        $('#stepper .adresaci input[name="adresat_id"]').val(ui.item.dataset + ':' + ui.item.value);
                        $('#stepper .szablony .pisma-list-button').attr('data-adresatid', ui.item.value);
                        $P.objects.adresaci = {
                            id: ui.item.value,
                            dataset: ui.item.dataset,
                            title: ui.item.title
                        };
                    }
                    return false;
                }
            }).autocomplete('widget').addClass("autocompleteSuggester");

            suggesterInput.data("ui-autocomplete")._renderItem = function (ul, item) {
                if (item.type == 'item') {
                    var title = $('<span></span>').text(item.shortTitle),
                        image;

                    if (item.image.length > 0) {
                        image = $('<img />').addClass('doc').attr('src', item.image);
                    } else {
                        image = $('<i></i>').addClass('icon icon-datasets-' + ((item.dataset) ? item.dataset : item.dataset));
                    }

                    if (item.detail) {
                        title.append($('<small></small>').text(item.detail));
                    } else {
                        title.addClass('vertical-center');
                    }

                    return $('<li></li>').addClass("row").attr({
                        'data-subid': item.id,
                        'data-subdataset': item.dataset
                    }).append(
                        $('<a></a>').append(
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