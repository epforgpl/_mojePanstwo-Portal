(function ($) {
    var pismoBtn = $('.pisma-button');

    if (pismoBtn.length) {
        var pismoModal = $('<div></div>').addClass('modal fade').id('pismaGenerateModal').attr({
            'tabindex': '-1',
            'role': 'dialog',
            'aria-labelledby': 'pismaGenerateModalHandle',
            'aria-hidden': 'hidden'
        }).append(
            $('<div></div>').addClass('modal-dialog').append(
                $('<div></div>').addClass('modal-content').append(
                    $('<div></div>').addClass('modal-header').append(
                        $('<button></button>').addClass('close').attr({
                            'type': 'button',
                            'data-dismiss': 'modal',
                            'arial-label': 'Close'
                        }).append(
                            $('<span></span>').attr('aria-hidden', 'true').html('&times;')
                        )
                    ).append(
                        $('<h4></h4>').addClass('modal-title').id('pismaGenerateModalHandle').text('Napisz do...')
                    )
                ).append(
                    $('<div></div>').addClass('modal-body').append(
                        $('<div></div>').addClass('loadingBlock loadingTwirl').append(
                            $('<div></div>').addClass('spinner').append(
                                $('<div></div>').addClass('bounce1')
                            ).append(
                                $('<div></div>').addClass('bounce2')
                            ).append(
                                $('<div></div>').addClass('bounce3')
                            )
                        ).append(
                            $('<p></p>').text("Ładowanie...")
                        )
                    )
                ).append(
                    $('<div></div>').addClass('modal-footer').append(
                        $('<button></button>').addClass('btn btn-default').attr('data-dismiss', 'modal').text('Zamknij')
                    ).append(
                        $('<button></button>').addClass('btn btn-primary').text('Stwórz')
                    )
                )
            )
        );

        //http://api.mojepanstwo.pl/pisma/templates/grouped.json


    }
}(jQuery));