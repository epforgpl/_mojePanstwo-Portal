(function ($) {
    var autocomplete = $("#cityv"),
        autocompleteBtn = autocomplete.parents('form').find('.btn'),
        cache = {};

    autocomplete.autocomplete({
        minLength: 2,
        source: function (request, response) {
            var term = request.term;
            if (term in cache) {
                response(cache[term]);
                return;
            }
            autocompleteBtn.addClass('loading');
            $.getJSON("/kody_pocztowe/adres.json?q=" + request.term, function (data, status, xhr) {
                autocompleteBtn.removeClass('loading');
                var results = $.map(data.search, function (item) {
                    return {
                        label: item.text,
                        value: item.id
                    }
                });
                if (results.length == 0)
                    results = [
                        {label: _mPHeart.translation.LC_SEARCH_BRAK_WYNIKOW, value: null}
                    ];
                cache[term] = results;
                response(results);
            });
        },
        focus: function (event, ui) {
            if (ui.item.value !== null)
                autocomplete.val(ui.item.label);
            return false;
        },
        select: function (event, ui) {
            if (ui.item.value !== null) {
                autocomplete.val(ui.item.label);
                window.location = '/kody_pocztowe/adres/' + ui.item.value;
            }
            return false;
        }
    }).autocomplete("widget").addClass("autocompleteKodyPocztowe");

    autocomplete.parents('form').on('submit', function (e) {
        e.preventDefault();

        window.location = '/kody_pocztowe/adres/' + $(this).find('.input.text > span').text();
    })
}(jQuery));
