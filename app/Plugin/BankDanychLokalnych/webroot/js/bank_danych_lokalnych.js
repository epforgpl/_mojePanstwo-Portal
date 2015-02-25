$(function () {


    var API = 'http://mojepanstwo.pl:4444/',
        indicators = [];

    $('.leftSide').css('max-height', ($(window).height() - 80) + 'px');

    // Poziomy obszarów
    var levels = [
        '',
        'kraj',
        'wojewodztwo',
        'powiat',
        'gmina'
    ];

    var level = 1; // Domyślnie 'kraj'

    // Nazwy klas w zależności od ilości wskaźników danego wymiaru
    var classes = [
        '',
        'col-md-12',    // 1
        'col-md-6',     // 2
        'col-md-4',     // 3
        'col-md-3',     // 4
        'col-md-2'      // 5 (przy czym ostatni ma col-md-3)
    ];

    var setIndicatorOption = function() {
        var w = [];
        var _get = '?a';
        $('#indicator .row select').each(function() {
            w.push(parseInt($(this).val()));
        });

        for(var i = 0; i < w.length; i++) {
            _get += '&w' + (i + 1) + '=' + w[i];
        }

        $.getJSON(API + 'bdl/getDataForIndicatorSet' + _get, function (data) {
            console.log(data);
        });
    };

    // Zmiana wyświetlanego wskaźnika
    var setIndicator = function(indicator) {
        level = parseInt(indicator.data['bdl_wskazniki.poziom_id']);
        var c = classes[indicator.layers.dimennsions.length];
        $('#indicator .row').html('');
        for(var i = 0; i < indicator.layers.dimennsions.length; i++) {
            var dimension = indicator.layers.dimennsions[i];

            // ostatnia kolumna przy 5 wskaźnikach jest szersza
            if(indicator.layers.dimennsions.length == 5 && i >= indicator.layers.dimennsions.length - 2)
                c = 'col-md-3';

            $('#indicator .row').append('<div class="' + c + '"><div class="form-group"><label for="w' + i + '">' + dimension.label + '</label><select class="form-control" id="w' + i + '"></select></div></div>');
            for(var d = 0; d < dimension.options.length; d++) {
                var option = dimension.options[d];
                $('#indicator .row select#w' + i).append('<option value="' + option.id + '">' + option.value + '</option>');
            }
        }

        $('#indicator .row select').change(function() {
            setIndicatorOption();
            return false;
        });

        // Na początku wyświetlamy mapę dla domyślnych wartości
        setIndicatorOption();
    };

    $.getJSON(API + 'bdl/getCategories', function(categories) {
        categoriesData = [];
        for(var i = 0; i < categories.length; i++) {
            groupsData = [];
            for(var s = 0; s < categories[i].groups.length; s++) {
                subGroupsData = [];
                for(var m = 0; m < categories[i].groups[s].subgroups.length; m++) {
                    subGroupsData.push({
                        label:      categories[i].groups[s].subgroups[m].tytul,
                        id:         categories[i].groups[s].subgroups[m].id
                    });
                }
                groupsData.push({
                    label:      categories[i].groups[s].tytul + ' (' + subGroupsData.length + ')',
                    id:         categories[i].groups[s].id,
                    children:   subGroupsData
                });
            }

            categoriesData.push({
                label:      (categories[i].w_tytul == '' ? categories[i].tytul : categories[i].w_tytul) + ' (' + groupsData.length + ')',
                id:         categories[i].id,
                children:    groupsData
            });
        }

        $('#bankDanychLokalny .leftSide').removeClass('loading');

        $('#categories').tree({
            data: categoriesData,
            selectable: false
        });

        $('#categories').bind(
            'tree.click',
            function(event) {
                var node = event.node;
                if(node.children.length > 0)
                    return false;

                if(indicators[node.id] === undefined) {
                    $.getJSON(API + 'dane/bdl_wskazniki/' + node.id + '.json?layers[]=dimennsions', function (data) {
                        indicators[node.id] = data.object;
                        setIndicator(indicators[node.id]);
                    });
                } else {
                    setIndicator(indicators[node.id]);
                }
            }
        );
    });


    /* $.getJSON('http://mojepanstwo.pl:4444/geo/geojson/pl', function (geojson) {

        // Prepare the geojson
        var states = Highcharts.geojson(geojson, 'map'),
            rivers = Highcharts.geojson(geojson, 'mapline'),
            cities = Highcharts.geojson(geojson, 'mappoint');

        // Initiate the chart
        $('#map').highcharts('Map', {
            title: {
                text: ' '
            },

            chart: {
                backgroundColor: '#000000'
            },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },

            credits: {
                enabled: false
            },

            legend: {
                enabled: false
            },

            series: [{
                data: states,

                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
                    style: {
                        width: '80px' // force line-wrap
                    }
                },
                tooltip: {
                    pointFormat: '{point.name}'
                }
            }, {
                name: 'Rivers',
                type: 'mapline',
                data: rivers,
                color: Highcharts.getOptions().colors[0],
                tooltip: {
                    pointFormat: '{point.properties.NAME}'
                }
            }, {
                name: 'Cities',
                type: 'mappoint',
                data: cities,
                color: 'black',
                marker: {
                    radius: 2
                },
                dataLabels: {
                    align: 'left',
                    verticalAlign: 'middle'
                },
                animation: false,
                tooltip: {
                    pointFormat: '{point.name}'
                }
            }]
        });
    }); */
});