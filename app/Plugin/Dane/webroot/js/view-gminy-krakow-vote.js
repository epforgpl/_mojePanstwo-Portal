/*global $, jQuery, mPHeart*/
(function ($) {
    var main = $('.user_options_votes'),
        docId = $('.htmlexDoc').attr('data-document-id');

    main.find('.options .vote').click(function () {
        var that = $(this);
        if (!that.hasClass('disabled')) {
            var vote = that.attr('data-vote');
            $.ajax({
                url: '/dane/druki/' + docId + '/vote.json',
                method: 'POST',
                data: {
                    vote: vote
                },
                beforeSend: function () {
                    main.find('.options .vote').addClass('disabled')
                },
                success: function () {
                    main.find('.options .vote').removeClass('disabled');
                    main.find('.options .vote[data-vote="' + vote + '"]').addClass('disabled');
                }
            })
        }
    });

    if (main.find('.poll').length && !main.find('.poll').hasClass('.rendered')) {
        $.ajax({
            url: '/dane/druki/' + docId + '/vote.json',
            method: 'GET',
            success: function (res) {
                var res = res.response,
                    data = [];

                if (res.votes.length) {
                    res.votes.forEach(function (item) {
                        var vote = null;

                        if (item.vote == 1) {
                            vote = {
                                name: "Za",
                                color: '#4fb100'
                            }
                        } else if (item.vote == 2) {
                            vote = {
                                name: "Przeciw",
                                color: '#e50606'
                            }
                        } else if (item.vote == 3) {
                            vote = {
                                name: "Wstrzymali sie",
                                color: '#c1c1c1'
                            }
                        }
                        vote.y = parseInt(item.count);
                        data.push(vote);
                    });

                    main.find('.poll').addClass('.rendered');
                    main.find('.poll').highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: ' '
                        },
                        tooltip: {
                            pointFormat: 'Ilość głosów: <b>{point.y}</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: false
                            }
                        },
                        series: [{
                            colorByPoint: true,
                            data: data,
                            dataLabels: {
                                enabled: true,
                                format: '{y}',
                                distance: -30,
                                color: 'white'
                            }
                        }],
                        credits: {
                            enabled: false
                        }
                    });
                }

                if (res.user !== 0) {
                    main.find('.options .vote[data-vote="' + res.user + '"]').addClass('disabled');
                }
            }
        })
    }
}(jQuery));