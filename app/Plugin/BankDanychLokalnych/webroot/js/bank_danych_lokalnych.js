$(function () {

	var API = mPHeart.constant.ajax.api,
		geoAPI = API + '/geo/geojson/get?',
        indicators = [],
        map = [],
        mapLevel = 0,
        $tree,
        trueIds = [],
        spinner;

    var BDLHistory = {

        data: [0, 0, 0],

        init: function () {
            var state = History.getState();
            if (state.data[0] != undefined) {
                this.changeState(state.data);
            } else {
                var data = {};
                location.search.substr(1).split("&").forEach(function (item) {
                    data[item.split("=")[0]] = item.split("=")[1]
                });
                if (data['s1'] != undefined && data['s2'] != undefined && data['s3'] != undefined) {
                    this.changeState([
                        parseInt(data['s1']),
                        parseInt(data['s2']),
                        parseInt(data['s3'])
                    ]);
                }
            }
        },

        setTreeState: function (s1, s2, s3) {
            this.data = [s1, s2, s3];
            this.pushState();
        },

        pushState: function () {
            History.pushState(this.data, "", "?s1=" + this.data[0] + "&s2=" + this.data[1] + "&s3=" + this.data[2]);
        },

        changeState: function (data) {
            spinner.show();
            this.data = data;
            this.updateChanges();
        },

        updateChanges: function () {
            $tree.tree(
                'setState',
                {
                    open_nodes: [this.data[0], this.data[1]],
                    selected_node: []
                }
            );

            var node = $tree.tree('getNodeById', this.data[2]);
            $tree.tree('scrollToNode', node);
            setTreeNode(node);
        }

    };

    History.Adapter.bind(window, 'statechange', function () {
        var State = History.getState();
        BDLHistory.changeState(State.data);
    });

    var setTreeNode = function (node) {
        $('#categories li').each(function () {
            $(this).removeClass('active');
        });

        $(node.element).addClass('active');
        $('#indicator h3').html(node.name);

        if (indicators[node.id] === undefined) {
			$.getJSON(API + '/dane/bdl_wskazniki/' + trueIds[parseInt(node.id)] + '.json?layers[]=dimennsions', function (data) {
                indicators[node.id] = data.object;
                setIndicator(indicators[node.id]);
            });
        } else {
            setIndicator(indicators[node.id]);
        }
    };

    spinner = {
        show: function () {
            if ($('#bankDanychLokalny').find('.loadingBlock').length == 0) {
                $('#bankDanychLokalny').append('<div class="loadingBlock loadingTwirl"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div><p>Ładowanie...</p></div>');
            }
        },
        hide: function () {
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

        getTypeStr: function () {
            return types[i];
        },

        setUnit: function (u) {
            this.unit = u;
        },

        setType: function (i, doneFunction) {
            var i = parseInt(i);
            if (this.data[i] !== undefined) {
                this.i = i;
                if (doneFunction !== undefined) {
                    doneFunction();
                }
            } else {
                this.i = i;
                var t = this;
                $.getJSON(geoAPI + 'quality=4&types=' + this.lt[t.i], function (d) {
                    t.data[t.i] = Highcharts.geojson(d, 'map');
                    if (doneFunction !== undefined) {
                        doneFunction();
                    }
                });
            }
        },

        setSeriesData: function (data) {
            /*
             Dopiero w tym miejscu powinien zapisywać się stan w historii
             ponieważ mamy już wybraną kategorię, wskaźniki oraz
             rodzaj mapy którą chcemy wyświetlić.
             */
            var t = this;
            t.seriesData = data;
            spinner.show();
            this.setType(this.i, function () {
                t.draw();
                spinner.hide();
            });
        },

        draw: function () {
            var d = this.data[this.i];
            var fields = ['', '', 'wojewodztwo_id', '', 'powiat_id', 'gmina_id'];
            var field = fields[this.i];
            var max = 0, min = 100000;
            for (var i = 0; i < d.length; i++) {
                var found = false;
                for (var s = 0; s < this.seriesData.length; s++) {
                    if (d[i].properties.id == this.seriesData[s][field]) {
                        d[i].value = parseFloat(this.seriesData[s].v);
                        found = true;
                        break;
                    }
                }

                if (!found)
                    d[i].value = 0;

                if (d[i].value > max)
                    max = d[i].value;

                if (d[i].value < min)
                    min = d[i].value;
            }

            var type = 'logarithmic';
            if (min == 0)
                type = 'linear';

            if (min == 0 && max == 0)
                max = 1;

            $('#map').css('width', (
            $(window).width() - $('.leftSide').width() - 40
            ) + 'px');

            $('#map').css('height', (
            $(window).height() - $('#indicator').height() - 100
            ) + 'px');

            $('#levels').css('margin-top', (
            $('#map').height() - 34
            ) + 'px');

            $('#map').highcharts('Map', {
                title: {
                    text: ' '
                },
                chart: {
                    backgroundColor: '#fff'
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
                    minColor: '#ffffff',
                    maxColor: '#006df0',
                    min: min,
                    max: max,
                    type: type
                },
                series: [{
                    data: d,
                    nullColor: '#ffffff'
                }]
            });

            //$('#map').highcharts().mapZoom(0.5);
        }
    };

    $('.leftSide').css('max-height', ($(window).height() - 80) + 'px');
    $('#scrollbar').css('height', ($(window).height() - 100) + 'px');

    // Nazwy klas w zależności od ilości wskaźników danego wymiaru
    var classes = [
        '',
        'col-md-12',    // 1
        'col-md-6',     // 2
        'col-md-4',     // 3
        'col-md-3',     // 4
        'col-md-2'      // 5 (przy czym ostatnie 2 mają col-md-3)
    ];

    var setIndicatorOption = function () {
        var w = [];
        var _get = '?a';

        $('#indicator .row select').each(function () {
            w.push(parseInt($(this).val()));
        });

        for (var i = 0; i < w.length; i++) {
            _get += '&w' + (i + 1) + '=' + w[i];
        }

        var lt = ['', '', 'wojewodztwo', '', 'powiat', 'gmina'];
        var type = lt[map.i];

        _get += '&type=' + type;

        spinner.show();

		$.getJSON(API + '/bdl/getDataForIndicatorSet' + _get, function (data) {
            spinner.hide();
            // $('#loader').hide();
            // var years = data.years;
            map.setUnit(data.unit);
            map.setSeriesData(data.data);
            $('#desc').html('').append(data.value + ' ' + data.unit + ' w ' + data.year + ' r.');
            /* $('#year').html('');
             for(var i = 0; i < years.length; i++) {
             $('#year').append('<option value="' + years[i] + '">' + years[i] + '</option>');
             } */
        });
    };

    // Zmiana wyświetlanego wskaźnika
    var setIndicator = function (indicator) {
        var c = classes[indicator.layers.dimennsions.length];

        $('#indicator .row').html('');
        for (var i = 0; i < indicator.layers.dimennsions.length; i++) {
            var dimension = indicator.layers.dimennsions[i];

            // ostatnia kolumna przy 5 wskaźnikach jest szersza
            if (indicator.layers.dimennsions.length == 5 && i >= indicator.layers.dimennsions.length - 2)
                c = 'col-md-3';

            $('#indicator .row').append('<div class="' + c + '"><div class="form-group"><label for="w' + i + '">' + dimension.label + '</label><select class="form-control" id="w' + i + '"></select></div></div>');
            for (var d = 0; d < dimension.options.length; d++) {
                var option = dimension.options[d];
                $('#indicator .row select#w' + i).append('<option value="' + option.id + '">' + option.value + '</option>');
            }
        }

        var ls = [undefined, undefined, 'Województwo', undefined, 'Powiat', 'Gmina'];
        var lt = ['', '', 'wojewodztwa', '', 'powiaty', 'gminy'];
        var l = parseInt(indicator.data['bdl_wskazniki.poziom_id']);
        if (l == 0)
            l = 2;
        $('#levels').html('');
        for (var i = 0; i <= l; i++) {
            if (ls[i] === undefined) continue;
            $('#levels').append('<button type="button" data-id="' + i + '" class="btn btn-default">' + ls[i] + '</button>');
        }

        $('#indicator .row select').change(function () {
            setIndicatorOption();
            return false;
        });

        $('#levels button').click(function () {
            $('#levels button').each(function () {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            var l = parseInt($(this).data('id'));
            map.i = l;
            setIndicatorOption();
        });

        $('#levels button:first-child').click();
        // setIndicatorOption();
    };

    spinner.show();

	$.getJSON(API + '/bdl/getCategories', function (categories) {
        categoriesData = [];
        var id = 0;
        for (var i = 0; i < categories.length; i++) {
            groupsData = [];
            for (var s = 0; s < categories[i].groups.length; s++) {
                subGroupsData = [];
                for (var m = 0; m < categories[i].groups[s].subgroups.length; m++) {
                    subGroupsData.push({
                        label: categories[i].groups[s].subgroups[m].tytul,
                        id: id
                    });
                    trueIds.push(categories[i].groups[s].subgroups[m].id);
                    id++;
                }
                groupsData.push({
                    label: categories[i].groups[s].tytul + '&nbsp;<span class="small">(' + subGroupsData.length + ')</span>',
                    id: id,
                    children: subGroupsData
                });
                trueIds.push(categories[i].groups[s].id);
                id++;
            }

            categoriesData.push({
                label: (categories[i].w_tytul == '' ? categories[i].tytul : categories[i].w_tytul) + '&nbsp;<span class="small">(' + groupsData.length + ')</span>',
                id: id,
                children: groupsData
            });
            trueIds.push(categories[i].id);
            id++;
        }

        spinner.hide();

        $tree = $('#categories').tree({
            data: categoriesData,
            selectable: false,
            autoEscape: false
        });

        BDLHistory.init();

        $('#categories').bind(
            'tree.click',
            function (event) {
                var node = event.node;
                if (node.children.length > 0) {
                    $tree.tree('toggle', node);
                    return false;
                }

                BDLHistory.setTreeState(
                    parseInt(node.parent.parent.id),
                    parseInt(node.parent.id),
                    parseInt(node.id)
                );
            }
        );
    });

});
