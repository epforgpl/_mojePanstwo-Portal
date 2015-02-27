$(function () {


    var API = 'http://mojepanstwo.pl:4444/',
        geoAPI = API + 'geo/geojson/get?',
        indicators = [],
        map = [],
        mapLevel = 0;

    var spinner = {
        show: function() {
            if($('#bankDanychLokalny').find('.loadingBlock').length == 0) {
                $('#bankDanychLokalny').append('<div class="loadingBlock loadingTwirl"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div><p>Ładowanie...</p></div>');
            }
        },
        hide: function() {
            $('#bankDanychLokalny .loadingBlock').remove();
        }
    };

    var map = {

        data: [],
        seriesData: [],
        i: 0,
        unit: '',

        lt: ['', '', 'wojewodztwa', '', 'powiaty', 'gminy'],
        types: ['', '', 'wojewodztwo', '', 'powiat', 'gmina'],

        getTypeStr: function() {
            return types[i];
        },

        setUnit: function(u) {
            this.unit = u;
        },

        setType: function(i, doneFunction) {
            var i = parseInt(i);
            if(this.data[i] !== undefined) {
                this.i = i;
                if(doneFunction !== undefined) {
                    doneFunction();
                }
            } else {
                this.i = i;
                var t = this;
                $.getJSON(geoAPI + 'quality=4&types=' + this.lt[t.i], function(d) {
                    t.data[t.i] = Highcharts.geojson(d, 'map');
                    if(doneFunction !== undefined) {
                        doneFunction();
                    }
                });
            }
        },

        setSeriesData: function(data) {
            var t = this;
            t.seriesData = data;
            spinner.show();
            this.setType(this.i, function() {
                t.draw();
                spinner.hide();
            });
        },

        draw: function() {
            var d = this.data[this.i];
            var min = parseFloat(this.seriesData[0].v);
            var max = parseFloat(this.seriesData[0].v);
            for(var m = 0; m < this.seriesData.length; m++) {
                var v = parseFloat(this.seriesData[m].v);
                d[m].value = v;
                if(v < min) min = v;
                if(v > max) max = v;
            }

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
                tooltip: {
                    pointFormat: '{point.name}: {point.value} ' + (this.unit !== undefined ? this.unit : '')
                },
                colorAxis: {
                    min: min,
                    max: max,
                    minColor: '#ffffff',
                    maxColor: '#006df0',
                    type: (min > 0 && max > 0) ? 'logarithmic' : 'linear'
                },
                series: [{
                    data: d,
                    nullColor: '#000'
                }]
            });
        }
    };

    $('.leftSide').css('max-height', ($(window).height() - 80) + 'px');

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

        var lt = ['', '', 'wojewodztwo', '', 'powiat', 'gmina'];
        var type = lt[map.i];

        _get += '&type=' + type;

        spinner.show();

        $.getJSON(API + 'bdl/getDataForIndicatorSet' + _get, function(data) {
            spinner.hide();
            // $('#loader').hide();
            // var years = data.years;
            map.setUnit(data.unit);
            map.setSeriesData(data.data);
            $('#desc').html('').append('Rocznik ' + data.year + ', ' + data.value + ' ' + data.unit);
            /* $('#year').html('');
            for(var i = 0; i < years.length; i++) {
                $('#year').append('<option value="' + years[i] + '">' + years[i] + '</option>');
            } */
        });
    };

    // Zmiana wyświetlanego wskaźnika
    var setIndicator = function(indicator) {
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

        var ls = [undefined, undefined, 'Województwo', undefined, 'Powiat', 'Gmina'];
        var lt = ['', '', 'wojewodztwa', '', 'powiaty', 'gminy'];
        var l = parseInt(indicator.data['bdl_wskazniki.poziom_id']);
        $('#levels').html('');
        for(var i = 0; i <= l; i++) {
            if(ls[i] === undefined) continue;
            $('#levels').append('<button type="button" data-id="' + i + '" class="btn btn-default">' + ls[i] + '</button>');
        }

        $('#indicator .row select').change(function() {
            setIndicatorOption();
            return false;
        });

        $('#levels button').click(function() {
            var l = parseInt($(this).data('id'));
            map.i = l;
            setIndicatorOption();
        });

        $('#levels button:first-child').click();
        // setIndicatorOption();
    };

    spinner.show();

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

        spinner.hide();

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

                $('#categories li').each(function() {
                    $(this).removeClass('active');
                });
                $(node.element).addClass('active');

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

});