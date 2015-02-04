$(function() {

    'use strict';

    var hz_map = $('#hzMap'),
        hz_api = 'http://mojepanstwo.pl:4444/handel_zagraniczny/stats/',
        hz_type = 'import',
        hz_countries_data = [],
        hz_top_symbols_data = [],
        hz_year = 2014,
        hz_type_last,
        hz_year_last,
        hz_map_data;

    $.getJSON('/HandelZagraniczny/files/world.geo.json', function(j) {
        hz_map_data = Highcharts.geojson(j, 'map');
        hz_createHighChart();
    });

    $('.hzTypeMenu li a').click(function() {
        $('.hzTypeMenu li.active').toggleClass('active');
        $(this).parent('li').toggleClass('active');
        hz_type = $(this).text().toLowerCase();
        hz_createHighChart();
        return false;
    });

    $('select.hzYearSelect').change(function() {
        hz_year = parseInt($(this).find(':selected').text());
        hz_createHighChart();
        return false;
    });

    var hz_getCountriesData = function(year, doneFunction) {
        if(hz_countries_data[year] === undefined) {
            $.getJSON(hz_api + 'getCountriesData.json?year=' + year, function(d) {
                hz_countries_data[year] = d;
                doneFunction(d);
            });
        } else {
            doneFunction(hz_countries_data[year]);
        }
    };

    var hz_getTopSymbolsData = function(year, doneFunction) {
        if(hz_top_symbols_data[year] === undefined) {
            $.getJSON(hz_api + 'getTopSymbolsData.json?year=' + year, function(d) {
                hz_top_symbols_data[year] = d;
                doneFunction(d);
            });
        } else {
            doneFunction(hz_top_symbols_data[year]);
        }
    };

    var hz_updateCountriesDetails = function(countries) {
        var limit = 5;
        $('span.hzYearAttr').each(function() {
            $(this).html(hz_year);
        });

        var c_import_max_i = [];
        var is = false;
        for(var l = 0; l < limit; l++) {
            var max_i = 0;
            for(var i = 0; i < countries.length; i++) {
                is = false;
                for(var c = 0; c < c_import_max_i.length; c++) {
                    if(i === c_import_max_i[c]) {
                        is = true;
                        break;
                    }
                }
                if(!is && parseInt(countries[max_i].import) < parseInt(countries[i].import))
                    max_i = i;
            }
            c_import_max_i.push(max_i);
        }

        $('#hzImportCountries').html('');
        for(var i = 0; i < c_import_max_i.length; i++) {
            var c = countries[c_import_max_i[i]];
            $('#hzImportCountries').append('<li class="list-group-item"><span class="badge">' + pl_currency_format(c.import) + ' zł</span><img src="/img/flags/' + c.code + '.png"/> <a href="/dane/panstwa/' + c.id + '?y=' + hz_year + '">' + c.kraj + '</a></li>');
        }

        var c_eksport_max_i = [];
        var is = false;
        for(var l = 0; l < limit; l++) {
            var max_i = 0;
            for(var i = 0; i < countries.length; i++) {
                is = false;
                for(var c = 0; c < c_eksport_max_i.length; c++) {
                    if(i === c_eksport_max_i[c]) {
                        is = true;
                        break;
                    }
                }
                if(!is && parseInt(countries[max_i].eksport) < parseInt(countries[i].eksport))
                    max_i = i;
            }
            c_eksport_max_i.push(max_i);
        }

        $('#hzExportCountries').html('');
        for(var i = 0; i < c_eksport_max_i.length; i++) {
            var c = countries[c_eksport_max_i[i]];
            $('#hzExportCountries').append('<li class="list-group-item"><span class="badge">' + pl_currency_format(c.eksport) + ' zł</span><img src="/img/flags/' + c.code + '.png"/> <a href="/dane/panstwa/' + c.id + '?y=' + hz_year + '">' + c.kraj + '</a></li>');
        }

    };

    var hz_updateTopSymbolsDetails = function(symbols) {

        $('#hzImportSymbols').html('');
        for(var i = 0; i < symbols.import.length; i++) {
            var s = symbols.import[i];
            $('#hzImportSymbols').append('<li class="list-group-item"><span class="badge">' + pl_currency_format(s.wartosc_pln) + ' zł</span><a href="/dane/handel_zagraniczny_towary/' + s.id + '?y=' + hz_year + '">' + s.nazwa.trim() + '</a></li>');
        }

        $('#hzImportSymbols li.list-group-item a.more').click(function() {
            $(this).hide();
            var parent_id = $(this).attr('id');
            var $li = $(this).parent('li');
            if($li.find('ul').length > 0) {
                return false;
            }
            var content = '<ul class="list-group symbolChild">';
            $.getJSON(hz_api + 'getSymbols.json?year=' + hz_year + '&type=import&parent_id=' + parent_id, function(j) {
                for(var k = 0; k < j.length; k++) {
                    var s = j[k];
                    content +=  '<li class="list-group-item"><span class="badge">' + pl_currency_format(s.wartosc_pln) + '</span> <a href="/dane/handel_zagraniczny_towary/' + s.id + '?y=' + hz_year + '">' + s.nazwa.trim() + '</a></li>';
                }
                content += '</ul>';
                $li.append(content);
            });
            return false;
        });

        $('#hzExportSymbols').html('');
        for(var i = 0; i < symbols.export.length; i++) {
            var s = symbols.export[i];
            $('#hzExportSymbols').append('<li class="list-group-item"><span class="badge">' + pl_currency_format(s.wartosc_pln) + ' zł</span><a href="/dane/handel_zagraniczny_towary/' + s.id + '?y=' + hz_year + '">' + s.nazwa.trim() + '</a></li>');
        }

        $('#hzExportSymbols li.list-group-item a.more').click(function() {
            $(this).hide();
            var parent_id = $(this).attr('id');
            var $li = $(this).parent('li');
            if($li.find('ul').length > 0) {
                return false;
            }
            var content = '<ul class="list-group symbolChild">';
            $.getJSON(hz_api + 'getSymbols.json?year=' + hz_year + '&type=export&parent_id=' + parent_id, function(j) {
                for(var k = 0; k < j.length; k++) {
                    var s = j[k];
                    content +=  '<li class="list-group-item"><span class="badge">' + pl_currency_format(s.wartosc_pln) + '</span> <a href="/dane/handel_zagraniczny_towary/' + s.id + '?y=' + hz_year + '">' + s.nazwa.trim() + '</a></li>';
                }
                content += '</ul>';
                $li.append(content);
            });
            return false;
        });

    };

    var hz_createHighChart = function() {
        if((hz_type_last === hz_type && hz_year_last === hz_year) || !hz_map_data)
            return false;

        hz_getTopSymbolsData(hz_year, function(symbolsData) {
            hz_updateTopSymbolsDetails(symbolsData);
        });

        hz_getCountriesData(hz_year, function(countriesData) {

            hz_updateCountriesDetails(countriesData);

            var hz_data = [];
            var hz_colors = false;
            var hz_colorAxis = {};
            var hz_tooltip_format = '';
            var hz_tooltip = {};

            switch(hz_type) {
                case 'bilans':
                    hz_colorAxis = false;
                    hz_tooltip = {
                        backgroundColor: 'none',
                        borderWidth: 0,
                        shadow: false,
                        useHTML: true,
                        padding: 0,
                        headerFormat: '',
                        pointFormat: '<h3>{point.nazwa}</h3><table><tr><th><b>Import:</b> {point.import} zł</th><th><b>Eksport:</b> {point.eksport} zł</th></tr>{point.symbole.wartosc_pln}</table>',
                        formatter: function() {
                            var h = '';
                            h += '<img class="hzFlagIcon" src="/img/flags/' + this.point.code + '.png" alt="' + this.point.nazwa + '"/>';
                            h += '<h3>' + this.point.nazwa + '</h3>';
                            h += '<table><tr><th>Import: <b>' + this.point.import + ' zł</b></th><th>Eksport: <b>' + this.point.eksport + ' zł</b></th></tr>';
                            for(var i = 0; i < this.point.symbole.import.length; i++) {
                                var import_nazwa = short(this.point.symbole.import[i].nazwa, 30).capitalize();
                                var eksport_nazwa = short(this.point.symbole.eksport[i].nazwa, 30).capitalize();
                                h += '<tr>';
                                h += '<td><div>' + (i + 1) + '. ' + import_nazwa + ' <b>(' + number_format(this.point.symbole.import[i].wartosc_pln) + ' zł)</b></div></td>';
                                h += '<td><div>' + (i + 1) + '. ' + eksport_nazwa + ' <b>(' + number_format(this.point.symbole.eksport[i].wartosc_pln) + ' zł)</b></div></td>';
                                h += '</tr>';
                            }
                            h += '</table>';
                            h += '<p class="more">Kliknij na państwo aby zobaczyć więcej informacji.</p>';
                            return h;
                        }
                    };

                    /*
                    hz_tooltip = {
                        headerFormat: '',
                        pointFormat: '<b>{point.nazwa}</b><br/><b>Bilans:</b> {point.bilans} zł<br/><b>Import:</b> {point.import} zł<br/><b>Eksport:</b> {point.eksport} zł'
                    }; */
                break;

                case 'import':
                    hz_colorAxis = {
                        min: 1,
                        max: 100,
                        minColor: '#ffffff',
                        maxColor: '#006df0',
                        type: 'logarithmic'
                    };

                    hz_tooltip = {
                        useHTML: true,
                        headerFormat: '',
                        pointFormat: '',
                        formatter: function() {
                            var h = '';
                            h += '<div>';
                            h += '<img class="hzFlagIcon" src="/img/flags/' + this.point.code + '.png" alt="' + this.point.nazwa + '"/>';
                            h += ' ' + this.point.nazwa;
                            h += '</div>';
                            h += '<ul>';
                            h += '<li>Import: <b>' + this.point.import + ' zł</b></li>';
                            h += '<li>Eksport: <b>' + this.point.eksport + ' zł</b></li>';
                            h += '<li>Bilans: <b style="color: ' + this.point.c + ';">' + this.point.bilans + ' zł</b></li>';
                            h += '<li>Wymiana: <b>' + this.point.wymiana + ' zł</b></li>';
                            h += '</ul>';
                            return h;
                        }
                    };
                break;

                case 'eksport':
                    hz_colorAxis = {
                        min: 1,
                        max: 100,
                        minColor: '#ffffff',
                        maxColor: '#006df0',
                        type: 'logarithmic'
                    };

                    hz_tooltip = {
                        useHTML: true,
                        headerFormat: '',
                        pointFormat: '',
                        formatter: function() {
                            var h = '';
                            h += '<div>';
                            h += '<img class="hzFlagIcon" src="/img/flags/' + this.point.code + '.png" alt="' + this.point.nazwa + '"/>';
                            h += ' ' + this.point.nazwa;
                            h += '</div>';
                            h += '<ul>';
                            h += '<li>Import: <b>' + this.point.import + ' zł</b></li>';
                            h += '<li>Eksport: <b>' + this.point.eksport + ' zł</b></li>';
                            h += '<li>Bilans: <b style="color: ' + this.point.c + ';">' + this.point.bilans + ' zł</b></li>';
                            h += '<li>Wymiana: <b>' + this.point.wymiana + ' zł</b></li>';
                            h += '</ul>';
                            return h;
                        }
                    };
                break;

                case 'wymiana':
                    hz_colorAxis = {
                        min: 1,
                        max: 100,
                        minColor: '#ffffff',
                        maxColor: '#006df0',
                        type: 'logarithmic'
                    };

                    hz_tooltip = {
                        useHTML: true,
                        headerFormat: '',
                        pointFormat: '',
                        formatter: function() {
                            var h = '';
                            h += '<div>';
                            h += '<img class="hzFlagIcon" src="/img/flags/' + this.point.code + '.png" alt="' + this.point.nazwa + '"/>';
                            h += ' ' + this.point.nazwa;
                            h += '</div>';
                            h += '<ul>';
                            h += '<li>Import: <b>' + this.point.import + ' zł</b></li>';
                            h += '<li>Eksport: <b>' + this.point.eksport + ' zł</b></li>';
                            h += '<li>Bilans: <b style="color: ' + this.point.c + ';">' + this.point.bilans + ' zł</b></li>';
                            h += '<li>Wymiana: <b>' + this.point.wymiana + ' zł</b></li>';
                            h += '</ul>';
                            return h;
                        }
                    };
                break;
            };

            var cd_max_import = max_import(countriesData);
            var cd_max_eksport = max_eksport(countriesData);

            $.each(countriesData, function () {
                var cd_import = parseInt(this.import);
                var cd_eksport = parseInt(this.eksport);

                switch(hz_type) {
                    case 'bilans':
                        var cd_char = (cd_eksport >= cd_import) ? '+' : '-';
                        if (cd_import > 0 && cd_eksport > 0) {
                            hz_data.push({
                                value: Math.abs(cd_import - cd_eksport),
                                code: this.code,
                                nazwa: this.kraj,
                                import: number_format(cd_import),
                                eksport: number_format(cd_eksport),
                                symbole: this.symbole,
                                bilans: cd_char + '' + number_format(Math.abs(cd_import - cd_eksport)),
                                color: (cd_eksport >= cd_import) ? '#1FAD32' : '#AD1F1F'
                            });
                        }
                    break;

                    case 'import':
                        var cd_char = (cd_eksport >= cd_import) ? '+' : '-';
                        if (cd_import > 0) {
                            hz_data.push({
                                value: Math.abs((cd_import * 100) / cd_max_import),
                                import: pl_currency_format(cd_import),
                                eksport: pl_currency_format(cd_eksport),
                                bilans: cd_char + ' ' + pl_currency_format(Math.abs(cd_import - cd_eksport)),
                                wymiana: pl_currency_format(cd_import + cd_eksport),
                                c: (cd_eksport >= cd_import) ? '#1FAD32' : '#AD1F1F',
                                code: this.code,
                                nazwa: this.kraj
                            });
                        }
                    break;

                    case 'eksport':
                        var cd_char = (cd_eksport >= cd_import) ? '+' : '-';
                        if (cd_eksport > 0) {
                            hz_data.push({
                                value: Math.abs((cd_eksport * 100) / cd_max_eksport),
                                import: pl_currency_format(cd_import),
                                eksport: pl_currency_format(cd_eksport),
                                bilans: cd_char + ' ' + pl_currency_format(Math.abs(cd_import - cd_eksport)),
                                wymiana: pl_currency_format(cd_import + cd_eksport),
                                c: (cd_eksport >= cd_import) ? '#1FAD32' : '#AD1F1F',
                                code: this.code,
                                nazwa: this.kraj
                            });
                        }
                    break;

                    case 'wymiana':
                        var cd_char = (cd_eksport >= cd_import) ? '+' : '-';
                        if (cd_import > 0 || cd_eksport > 0) {
                            hz_data.push({
                                value: Math.abs(((cd_import + cd_eksport) * 100) / (cd_max_import + cd_max_eksport)),
                                import: pl_currency_format(cd_import),
                                eksport: pl_currency_format(cd_eksport),
                                bilans: cd_char + ' ' + pl_currency_format(Math.abs(cd_import - cd_eksport)),
                                wymiana: pl_currency_format(cd_import + cd_eksport),
                                c: (cd_eksport >= cd_import) ? '#1FAD32' : '#AD1F1F',
                                code: this.code,
                                nazwa: this.kraj
                            });
                        }
                        break;
                }

            });

            hz_map.highcharts('Map', {
                title: {
                    text: ''
                },

                chart: {
                    backgroundColor: '#142026',
                    borderColor: '#333',
                    spacing: [0, 0, 0, 0]
                },

                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    },
                    enableMouseWheelZoom: false
                },

                colors: hz_colors,
                colorAxis: hz_colorAxis,

                credits: {
                    enabled: false
                },

                legend: {
                    enabled: false
                },

                tooltip: hz_tooltip,

                series: [{
                    animation: {
                        duration: 0
                    },
                    data: hz_data,
                    mapData: hz_map_data,
                    nullColor: '#142026',
                    joinBy: ['iso-a2', 'code'],
                    dataLabels: {
                        enabled: false
                    }
                }]
            });

        });

        hz_type_last = hz_type;
        hz_year_last = hz_year;
    };

    function max_eksport(countries) {
        var max = parseInt(countries[0].eksport);
        for(var i = 0; i < countries.length; i++) {
            if(parseInt(countries[i].eksport) > max)
                max = parseInt(countries[i].eksport);
        }

        return max;
    };

    function max_import(countries) {
        var max = parseInt(countries[0].import);
        for(var i = 0; i < countries.length; i++) {
            if(parseInt(countries[i].import) > max)
                max = parseInt(countries[i].import);
        }

        return max;
    };

    function min_import(countries) {
        var min = parseInt(countries[0].import);
        for(var i = 0; i < countries.length; i++) {
            if(parseInt(countries[i].import) < min)
                min = parseInt(countries[i].import);
        }

        return min;
    }

    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    };

    function short(s, len) {
        if(s.length > len) {
            return s.substr(0, len) + '..';
        } else {
            return s;
        }
    }

    function pl_currency_format(n) {
        var str = '';
        var mld = 0;
        var mln = 0;
        var tys = 0;

        if(n > 1000000000) {
            mld = Math.floor(n / 1000000000);
            n -= mld * 1000000000;
        }

        if(n > 1000000) {
            mln = Math.floor(n / 1000000);
            n -= mln * 1000000;
        }

        if(n > 1000) {
            tys = Math.floor(n / 1000);
            n -= tys * 1000;
        }

        if(mld > 0)
            str += mld + ' mld ';
        if(mln  > 0)
            str += mln + ' mln ';
        if(tys > 0 && mld === 0)
            str += tys + ' tys';

        if(mld === 0 && mln === 0 && tys === 0)
            str += number_format(n);

        return str.trim();
    };

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
                .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                .join('0');
        }
        return s.join(dec);
    }

});