/*global mPHeart*/

jQuery(document).ready(function () {
    if (jQuery("#timeline-embed").length > 0) {
        createStoryJS({
            start_at_end: true,
            width: "100%",
            height: Math.max($('#_wrapper').height() - 30, 400),
            source: '/sejmometr/posiedzenia_timeline.json',
            embed_id: 'timeline-embed',
            css: '/plugins/TimelineJS/build/css/timeline-2rows.css',
            js: '/plugins/TimelineJS/build/js/timeline-2rows.js',
            lang: mPHeart.language.twoDig
        });

        $(window).on('DATAREADY', function () {
            var vcoSlider = jQuery('.vco-slider');

            vcoSlider.on("FINISH", function () {
                if (window.timelinejs_current_slide !== null)
                    prepare_slide(window.timelinejs_current_slide);
            });
        });
    }
});

function prepare_slide(current_slide) {
    var slide_div, slide_content;

    if (( slide_div = jQuery(jQuery('.slider-item-container').children()[current_slide]) ) && !(slide_div.hasClass('prepared')) && ( slide_content = slide_div.find('.slide_content') ) && slide_content.length) {
        var h = $('body').height() - $('header').outerHeight() - $('footer').outerHeight(),
            $timelineEmbed = jQuery("#timeline-embed"),
            posiedzenie_id = slide_content.data('posiedzenie_id'),
            title_element = jQuery(slide_div.find('h3')[0]),
            title_element_text = title_element.text();

        slide_div.addClass('prepared');
        $timelineEmbed.find(".content-container").height(h + 'px');
        $timelineEmbed.find('.vco-feature .vco-slider >div').height(h - $timelineEmbed.find('.vco-navigation').outerHeight() - 10 + 'px');

        title_element.html(
            jQuery('<a></a>').attr('href', '/dane/sejm_posiedzenia/' + posiedzenie_id).text('Posiedzenie Sejmu ' + title_element_text)
        );

        $.ajax({
            url: "/sejmometr/posiedzenie/" + posiedzenie_id + ".json",
            dataType: "json"
        }).done(function (data) {
            var div = $timelineEmbed.find('.slide_content[data-posiedzenie_id="' + data.id + '"]');

            if ($timelineEmbed.data('h') == undefined) {
                var slideH = $timelineEmbed.find('.vco-feature .vco-slider').outerHeight();
                $timelineEmbed.data('h', slideH);
            }

            if (div) {
                div.html(data.projekty_html);

                div.find(".projekty:not('.rendered')").each(function () {
                    var projekt = $(this),
                        projektH = 0;

                    div.parents('.slider-item').height($timelineEmbed.data('h') + 'px');
                    div.parents('.slider-item').find('.content-container').height($timelineEmbed.data('h') + 'px');

                    projekt.parents('.container').children().each(function () {
                        projektH += $(this).height();
                    });
                    projekt.addClass('rendered').height(slideH - (projektH - projekt.parent().height()) + 'px');
                })
            }
        });
    }
}