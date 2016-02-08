
(function($) {

    $(document).ready(function() {

        $('.objectsPage').first().append([
            '<div class="sticky" style="position: fixed; top: 150px; right: 100px;">',
                '<button class="btn btn-default ignoreChecked">Ignoruj zaznaczone</button>',
            '</div>'
        ].join(''));

        $('.objectRender.webpages').each(function() {

            var id = $(this).attr('oid'),
                content = $(this).find('.content').first(),
                aThumb = $(this).find('a.thumb_cont').first(),
                aTitle = $(this).find('.title a').first();

            aThumb.attr('target', 'blank');
            aTitle.attr('target', 'blank');

            content.append([
                '<div class="margin-top-10">',
                    '<input type="checkbox" name="ids[]" value="', id, '"/>',
                    '<a class="btn btn-link btn-sm" href="/admin/news/add/', id, '">Dodaj news</a>',
                    '<a class="btn btn-link btn-sm" href="/admin/websites/ignore/', id, '">Ignoruj</a>',
                '</div>'
            ].join(''));

        });

        $('.ignoreChecked').first().click(function() {
            var ids = [];
            $('input[name="ids[]"]').each(function() {
                if($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });

            $.post('/admin/websites/ignoreMultiples.json', {
                ids: ids
            }, function() {
                window.location.href = '/admin/websites';
            });
        });

    });

})(jQuery);