jQuery(document).ready(function () {
    var $followers = $('.followers'),
        dataJSON = $followers.data('json'),
        dataArray = [],
        dataFollowersMin = Number(dataJSON[0].count),
        $objectSideInner = $('.objectSideInner'),
        $showHideSide = $('.showHideSide');

    $.each(dataJSON, function (index, data) {
        var d = data.date.split('-');
        dataArray.push([Date.UTC(Number(d[0]), Number(d[1]) - 1, Number(d[2])), Number(data.count)]);
        if (dataFollowersMin > Number(data.count))
            dataFollowersMin = Number(data.count)
    });

    $followers.highcharts({
        chart: {
            type: 'spline',
            height: 250,
            backgroundColor: 'rgba(255, 255, 255, 0)'
        },
        title: {
            text: ''
        },
        legend: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: false,
            labels: {
                rotation: 270,
                x: 2,
                y: 25
            }
        },
        yAxis: {
            min: dataFollowersMin,
            title: false
        },
        credits: {
            enabled: false
        },
        series: [
            {
                name: 'Obserwujących',
                data: dataArray
            }
        ]
    });

    $showHideSide.find('> a').click(function () {
        var that = $(this);
        $showHideSide.find('>a').removeClass('hide');
        that.addClass('hide');
        if (that.hasClass('a-more')) {
            $objectSideInner.find('.dataHighlights.hide').removeClass('hide').hide().addClass('unhide').slideDown();
        } else if (that.hasClass('a-less')) {
            $objectSideInner.find('.dataHighlights.unhide').slideUp(function () {
                $objectSideInner.find('.dataHighlights.unhide').removeClass('uhhide').addClass('hide');
            });
        }
    })
});