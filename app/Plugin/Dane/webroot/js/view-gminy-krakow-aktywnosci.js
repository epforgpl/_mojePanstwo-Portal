
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
            field = $(this).data('field'),
            chart,
            categories = [],
            data = [];

        aggs.forEach(function(row) {
            categories.push(row['radni_gmin.nazwa']);
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
                /*labels: {
                    formatter: function () {
                        var el = this.value,
                            v = el.name;

                        if (v.length > (((labelWidth / 10) * 2) - 2))
                            v = v.substring(0, ((labelWidth / 10) * 2) - 5) + '...';

                        if (image_field) {
                            return [
                                '<a href="' + choose_request + el.id + '" target="_self">',
                                '<div class="text-center" style="line-height: 1em">',
                                columns_horizontal_images.hasOwnProperty(el.name) ? '<img style="margin-bottom: 5px; margin-right: 5px; float: left; max-width: 30px;" src="' + columns_horizontal_images[el.name] + '"/><br/>' : '<div style="width: 30px; height: 30px; margin-bottom: 5px; margin-right: 5px; float: left;"></div><br/>',
                                v,
                                '</div>',
                                '</a>'
                            ].join('');
                        }

                        return '<a href="' + choose_request + el.id + '" target="_self">' + v + '</a>';
                    },
                    style: labelsStyle,
                    useHTML: true
                }*/
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
            //tooltip: tooltip,
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
                name: 'Liczba',
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