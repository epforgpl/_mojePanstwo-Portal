$(document).ready(function () {
    var $modal;

    $('.wynik_klubowy_wyjatki').click(function (e) {
        var that = $(this);

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
                            $('<h4></h4>').addClass('modal-title').attr('id', 'wynikKlubowyWyjatkiLabel').html('&nbsp;')
                        )
                    ).append(
                        $('<div></div>').addClass('modal-body').append(
                            $('<div></div>').addClass('loading')
                        )
                    )
                )
            );

            $('.dataFeed-ul').append($modal);
        }

        //console.log(that);
        $modal.modal('show');

        /*$.ajax({
         url: that,
         type: 'GET',
         success: function(data){
         console.log(data);
         }
         });*/
    });
});