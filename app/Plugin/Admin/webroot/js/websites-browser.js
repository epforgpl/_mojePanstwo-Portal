
(function($) {

    $(document).ready(function() {

        $('.objectRender.webpages').each(function() {

            var id = $(this).attr('oid'),
                content = $(this).find('.content').first();

            content.append([
                '<div class="margin-top-10">',
                    '<a class="btn btn-link btn-sm" href="/admin/news/add/', id, '">Dodaj news</a>',
                '</div>'
            ].join(''));

        });

    });

})(jQuery);