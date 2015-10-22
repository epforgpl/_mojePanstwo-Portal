
$(document).ready(function() {

    function normalize(aggs) {
        var data = [];
        if(aggs && aggs.length) {
            aggs.forEach(function(row) {
                data.push(row.fields.source[0].data);
            });
        }

        return data;
    }

    $('.radniRankingChart').each(function() {
        var aggs = normalize($(this).data('aggs')),
            request = $(this).data('request'),
            field = $(this).data('field'),
            chart,
            categories = [],
            data = [];

        aggs.forEach(function(row) {
            categories.push({
                name: row['radni_gmin.nazwa'],
                id: row['radni_gmin.id'],
                avatar: row['radni_gmin.avatar_id']
            });
            data.push(parseInt(row[field]));
        });

        $(this).append('<div class="chart"></div>');
        chart = $(this).find('.chart');

        chart.highcharts({
            chart: {
                type: 'bar',
                spacingRight: 60,
                backgroundColor: null
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: categories,
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        var el = this.value,
                            v = el.name;

                        return [
                            '<a href="' + request + '' + el.id + '" target="_self">',
                                '<div class="text-center" style="line-height: 0.7em">',
                                    '<img style="margin-bottom: 5px; margin-right: 5px; float: left; max-width: 30px;" src="http://resources.sejmometr.pl/avatars/1/' + el.avatar + '.jpg"/><br/><br/>',
                                v,
                                '</div>',
                            '</a>'
                        ].join('');
                    },
                    style: {
                        width: '150px',
                        'min-width': '150px'
                    },
                    useHTML: true
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size: 10px">{point.key.name}</span><br/>'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                },
                series: {
                    pointWidth: 15
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Ilość punktów',
                data: data,
                point: {
                    events: {
                        click: function (e) {
                            // window.location.href = choose_request + columns_horizontal_keys[this.index];
                            return false;
                        }
                    }
                }
                /* dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return _this.getAsPLNumber(this.y);
                    }
                } */
            }]
        });

    });

});