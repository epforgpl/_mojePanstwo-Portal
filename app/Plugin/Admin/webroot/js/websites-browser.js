
(function($) {

    $(document).ready(function() {

        $('.objectRender.webpages').each(function() {

            var id = $(this).attr('oid'),
                content = $(this).find('.content').first(),
                aThumb = $(this).find('a.thumb_cont').first(),
                aTitle = $(this).find('.title a').first();

            aThumb.attr('target', 'blank');
            aTitle.attr('target', 'blank');

            content.append([
                '<div class="margin-top-10">',
                    '<a class="btn btn-link btn-sm" href="/admin/news/add/', id, '">Dodaj news</a>',
                    '<a class="btn btn-link btn-sm" href="/admin/websites/ignore/', id, '">Ignoruj</a>',
                '</div>'
            ].join(''));

        });

    });

})(jQuery);