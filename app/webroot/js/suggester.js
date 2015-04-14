(function ($) {
    var suggesterBlock;

    if ((suggesterBlock = $('.suggesterBlock')).length && false) {
        $.each(suggesterBlock, function (index, block) {
            var suggesterInput = $(block).find('input.form-control'),
                suggesterBtn = $(block).find('.input-group-btn .btn'),
                suggesterData = {
                    'app': suggesterInput.data('app')
                },
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
                        var parm = "q=" + request.term;
                        if (suggesterData.app)
                            parm += "&app=" + suggesterData.app;
                        $.getJSON("/dane/suggest.json?" + parm, function (data) {
                            var results = $.map(data.hits, function (item) {
                                var shortTitleLimit = 200,
                                    shortTitle = '';

                                if (item.dataset == 'twitter') {
                                    shortTitle = item.title.replace(/(<([^>]+)>)/ig, "");
                                } else {
                                    if (item.title.length > shortTitleLimit) {
                                        shortTitle = item.title.substr(0, shortTitleLimit);
                                        shortTitle = shortTitle.substr(0, Math.min(shortTitle.length, shortTitle.lastIndexOf(" "))) + '...';
                                    } else {
                                        shortTitle = item.title;
                                    }
                                }

                                return {
                                    type: 'item',
                                    title: item.title,
                                    shortTitle: shortTitle,
                                    value: item.id,
                                    link: item.dataset + '/' + item.id,
                                    label: item.label
                                };
                            });

                            suggesterCache[term] = results;

                            if (results.length == 0) {
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
                open: function (ui) {
                    var $ui = $('#ui-id-' + (index + 1));

                    $ui.css({
                        'margin-top': Math.floor((suggesterInput.offset().top + suggesterInput.outerHeight()) - parseInt($ui.css('top')) - parseInt($ui.css('border-bottom-left-radius'))) + 'px',
                        'width': suggesterInput.outerWidth() - 2,
                        'left': parseInt($ui.css('left')) + 1 + 'px'
                    });
                    suggesterInput.addClass('open');
                    suggesterBtn.removeClass('loading');
                },
                close: function () {
                    suggesterInput.removeClass('open');
                },
                focus: function (event, ui) {
                    if (ui.item)
                        suggesterInput.val(ui.item.title);
                    return false;
                },
                select: function (event, ui) {
                    if (ui.item)
                        suggesterInput.val(ui.item.title);

                    window.location.href = ui.item.link;
                    return false;
                }
            }).autocomplete("widget").addClass("autocompleteSuggester");

            suggesterInput.data("ui-autocomplete")._renderItem = function (ul, item) {
                if (item.type == 'item') {
                    return $('<li></li>').addClass("row")
                        .append(
                        $('<a></a>').attr({'href': '/dane/' + item.link, 'target': '_self'})
                            .append(
                            $('<p></p>').addClass('col-xs-3 col-md-2').addClass('_label').html('<span class="label label-default label-sm">' + item.label + '</span>')
                        )
                            .append(
                            $('<p></p>').addClass('col-md-9 col-md-10').addClass('_title').text(item.shortTitle)
                        )
                    )
                        .appendTo(ul)
                } else if (item.type == 'button') {
                    return $('<li></li>').addClass("row button").append(
                        $('<a></a>').addClass('btn btn-success').attr({
                            'href': '/dane/szukaj?q=' + item.q,
                            'target': '_self'
                        }).html('<span class="glyphicon glyphicon-search"> </span> ' + _mPHeart.suggester.fullSearch)
                    ).appendTo(ul);
                }
            }
        });
    }
}(jQuery));