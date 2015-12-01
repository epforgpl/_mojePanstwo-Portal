$(document).ready(function() {

    $('.krakowWpfProgramStatic').each(function() {
        var data = $(this).data(),
            from = -1,
            to = -1,
            categories = [],
            years = [],
            i;

        if(typeof data['static'] == 'undefined' ||
            typeof data['static']['years'] == 'undefined')
            return false;

        for(i = 0; i < data['static']['years'].length; i++)
            if(data['static']['years'][i][1] != '0') {
                from = i;
                break;
            }

        for(i = data['static']['years'].length - 1; i >= 0; i--)
            if(data['static']['years'][i][1] != '0') {
                to = i;
                break;
            }

        data['static']['years'].forEach(function(value, index) {
            if(index >= from && index <= to) {
                categories.push(value[0]);
                years.push({
                    name: value[0],
                    y: parseInt(value[1])
                });
            }
        });

        if(years.length > 1)
            $(this).highcharts({
                chart: {
                    type: 'area',
                    backgroundColor: null,
                    height: 200
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
                        rotation: -45
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
                    valueSuffix: ' '
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Kwota w zł',
                    data: years
                }]
            });

    });

});