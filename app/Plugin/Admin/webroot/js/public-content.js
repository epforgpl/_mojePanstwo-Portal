
$(document).ready(function() {

    $('.publicContentOptions .promoted').each(function() {

        var data = $(this).find('input').first().data();

        $(this).click(function() {
            $.getJSON('/admin/public_content/promote', {
                id: data.id,
                type: data.type,
                is_promoted: !$(this).hasClass('active') ? 1 : 0
            }, function(res) {
                if(!res)
                    alert('Wystąpił błąd');
            });
        });

    });

});