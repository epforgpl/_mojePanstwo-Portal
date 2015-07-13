var highchartInit = function () {
    var __charts_colors = {
        'z': '#109618',
        'p': '#DC3912',
        'w': '#3366CC',
        'n': '#DDDDDD'
    };

    /*RUN HIGHCHART FUNCTION ON EACH SPECIFY ELEMENT*/
    $('.highchart').each(function () {
        var data = $(this).data('wynikiklubowe'),
            series_data = [],
            charColor = (jQuery(this).parents('.objectRender').hasClass('bg') ? "#FCFCFC" : "#FFFFFF");

        for (var i = 0; i < data.length; i++) {
            var d = data[i];
            series_data.push({
                name: d['label'],
                y: Number(d['count']),
                color: __charts_colors[d['id']]
            });
        }

        /*HIGHCHART - CREATE CHART*/
        $(this).highcharts({
            credits: {
                enabled: false
            },
            chart: {
                backgroundColor: charColor,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                height: 140,
                width: 380,
                spacing: [0, 0, 0, 0],
                margin: [0, 0, 0, 0],
                style: {
                    padding: '0px',
                    margin: '0px'
                },
                animation: false
            },
            legend: {
                enabled: false,
                align: 'left'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b> <em>({point.percentage:.1f}%)</em>'
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        connectorColor: '#666666',
                        format: '<b>{point.name}</b>: {point.y}'
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%'],
                    allowPointSelect: true,
                    cursor: 'pointer',
                    size: '60%'
                }
            },

            series: [
                {
                    type: 'pie',
                    name: '',
                    innerSize: '30%',
                    data: series_data
                }
            ]
        });
    });
};

(function ($) {
    var tableClub = $('.clubTable'),
        tableInd = $('.indywidualneTable'),
        tableIndResults = tableInd.find('.results'),
        searchVote = false,
        searchClub = false;

    highchartInit();

    var searchInTableInd = function () {
        if ((searchClub == false) && (searchVote == false)) {
            tableIndResults.find('.slide:hidden').show();
        } else if ((searchClub != false) && (searchVote == false)) {
            tableIndResults.find('.slide').hide();
            tableIndResults.find('.clubName[data-club-id="' + searchClub + '"]').parents('.slide').show();
        } else if ((searchVote != false) && (searchClub == false)) {
            tableIndResults.find('.slide').hide();
            tableIndResults.find('.voted[data-glos="' + searchVote + '"]').parents('.slide').show();
        } else {
            tableIndResults.find('.slide').hide();
            tableIndResults.find('.clubName[data-club-id="' + searchClub + '"]').parents('.slide').show();
            tableIndResults.find('.slide:visible .voted[data-glos!="' + searchVote + '"]').parents('.slide').hide();
        }
    };

    tableClub.find('thead .searchableVote').click(function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            tableClub.find('colgroup > col').css('background', 'none');
            searchVote = false;
            searchInTableInd();
        } else {
            var search = $(this).data('search');

            tableClub.find('thead th.active').removeClass('active');
            $(this).addClass('active');
            tableClub.find('colgroup > col').css('background', 'none');
            tableClub.find('colgroup .colSearch-' + search).css('background-color', '#EEEEEE');
            searchVote = search;
            searchInTableInd();
        }
    });

    tableClub.find('tbody .club').click(function () {
        var row = $(this).parents('tr');

        if (row.hasClass('active')) {
            row.removeClass('active');
            searchClub = false;
            searchInTableInd();
        } else {
            tableClub.find('tbody tr.active').removeClass('active');
            row.addClass('active');
            searchClub = $(this).data('club-id');
            searchInTableInd();
        }
    });

    tableInd.find('.searchName input').keyup(function () {
        var input = $(this).val();

        if (input != '') {
            tableIndResults.find('.slide').hide();
            tableIndResults.find('.poselName:contains(' + input + ')').each(function () {
                $(this).parents('.slide').show();
            });
        } else {
            tableIndResults.find('.slide:hidden').show();
        }
    });

    tableInd.find('.searchName .btn').click(function (e) {
        var input = tableInd.find('.searchName input');
        e.preventDefault();

        if (input.val() != '') {
            input.val('');
            tableIndResults.find('.slide:hidden').show();
        }
    })
})(jQuery);