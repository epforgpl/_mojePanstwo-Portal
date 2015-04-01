$(function() {

    var $sections = $('#wpf-sections');
    var _data = JSON.parse($sections.attr('data-json'));
    var sectionsData = [];
    var name;
    var value;
    var $histogram;

    for(var year = 2015; year <= 2052; year++) {
        for(name in _data[year]) {
            if(_data[year].hasOwnProperty(name) && name != '971-Informacja o spełnieniu wskaźnika spłaty zobowiązań określonego w art. 243 ustawy, po uwzględnieniu zobowiązań związku współtworzonego przez jednostkę samorządu terytorialnego oraz po uwzględnieniu ustawowych wyłączeń, obliczonego w oparciu o wykonanie roku poprzedzającego rok budżetowy') {
                value = _data[year][name];

                if(!sectionsData[name])
                    sectionsData[name] = [];

                sectionsData[name].push(value);
            }
        }
    }

    var h = ['<div class="mpanel" id="sections"><ul id="sections">'];
    for(name in sectionsData) {
        if(sectionsData.hasOwnProperty(name)) {
            h.push('<li class="section"><div class="row"><div class="col-md-12">');
                h.push('<div class="row row-header">');
                    h.push('<div class="title col-md-12">');
                        h.push('<h3 class="name">');
                        h.push(name);
                        h.push('</h3>');
                        h.push('<div id="' + name + '" class="col-md-12 histogram"></div>');
                    h.push('</div>');
                h.push('</div>');
            h.push('</div></div></li>');
        }
    }
    h.push('</ul></div>');
    $sections.html(h.join(''));

    for(name in sectionsData) {
        if(sectionsData.hasOwnProperty(name)) {
            var _debugValues = [];
            var _histogramData = [];
            var _year = 2015;
            var _max = -999999999;
            var _min = 999999999;
            for(var i = 0; i < sectionsData[name].length; i++) {
                value = parseInt(sectionsData[name][i]);
                _debugValues.push(sectionsData[name][i]);
                _histogramData.push([
                    Date.UTC(_year, 0, 0),
                    value
                ]);
                if(value > _max)
                    _max = value;
                if(value < _min)
                    _min = value;
                _year++;
            }

            $histogram = $('#' + name);

            // ukrywamy wykresy które zawierają same 0 (a jest ich sporo)
            if(_max <= 0) {
                $histogram.parents('li.section').hide();
                continue;
            }

            $histogram.highcharts({
                chart: {
                    zoomType: 'x',
                    backgroundColor: null,
                    height: 200
                },
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    type: 'datetime'
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    min: _min,
                    max: _max
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },

                series: [{
                    type: 'area',
                    name: 'Liczba',
                    data: _histogramData
                }]
            });
        }
    }

});