var $SG;

var _SG = Class.extend({
    init: function () {
        this.update();
    },
    update: function () {
        var elements = $('.sejm_glosowanie-voting.sgvq');
        for (var i = 0; i < elements.length; i++)
            this.process(elements[i]);
    },
    process: function (el) {
        el = $(el);

        el.find('.highchart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                spacing: [0, 0, 0, 0],
                backgroundColor: 'rgba(0,0,0,0)'
            },
            title: {
                text: ''
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
                type: 'pie',
                name: 'Liczba głosów',
                data: el.data('stats')
            }],
            credits: {
                enabled: false
            },
            colors: ['#109618', '#DC3912', '#3366CC', '#DDDDDD']
        });

        el.removeClass('sgvq');
    }
});

$(document).ready(function () {
    $SG = new _SG();

    var $modal;

    $('.wynik_klubowy_wyjatki').click(function (e) {
        var that = $(this);

        var nazwa_klubu=that.parent().siblings().text();
        var tytul='Posłowie '+nazwa_klubu+' głosujący inaczej niż reszta klubu.'

        e.preventDefault();
        if ($modal == undefined) {
            $modal = $('<div></div>').addClass('modal fade').attr({
                'id': 'wynikKlubowyWyjatkiModal',
                'tabindex': '-1',
                'role': 'dialog',
                'aria-labelledby': 'wynikKlubowyWyjatkiLabel',
                'aria-hidden': 'true'
            }).append(
                $('<div></div>').addClass('modal-dialog').append(
                    $('<div></div>').addClass('modal-content').append(
                        $('<div></div>').addClass('modal-header').append(
                            $('<button></button>').addClass('close').attr({
                                'type': 'button',
                                'data-dismiss': 'modal',
                                'aria-label': 'Close'
                            }).append(
                                $('<span></span>').attr('aria-hidden', 'true').html('&times;')
                            )
                        ).append(
                            $('<h5></h5>').addClass('modal-title').attr('id', 'wynikKlubowyWyjatkiLabel').html(tytul)
                        )
                    ).append(
                        $('<div></div>').addClass('modal-body').append(
                            $('<div></div>').addClass('loading')
                        )
                    )
                )
            );

            $('.dataFeed-ul').append($modal);
        }else{
            $("#wynikKlubowyWyjatkiModal .innerContainer").remove();
            $('.modal-title').html(tytul);
            $('.modal-body').append($('<div></div>').addClass('loading'));
        }

        $modal.modal('show');

        $.ajax({
            url: that.attr('href'),
            type: 'GET',
            success: function (data) {
                var toModal = $(data).find(".dataObjects");
                $('.modal-body').html(toModal.html());
                $('.loading').remove();
            }
        });
    });

});