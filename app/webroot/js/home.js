/*global mPHeart*/

function resizeControl() {
    var size = jQuery(this),
        $basicOptions = $('.windowSet .basicOptions ');

    $basicOptions.find('.mainBrick').css('height', 'auto');

    if (size.width() > 768) {/*Bootstrap Extra small devices */
        var setSize = 0;
        jQuery.each($basicOptions.find('.mainBrick'), function () {
            if (setSize < $(this).outerHeight()) setSize = $(this).outerHeight();
        });
        $basicOptions.find('.mainBrick').css('height', setSize);
    }
}

jQuery(function () {
    jQuery('#_mPCockpit ._mPSearch').click(function (e) {
        e.preventDefault()
    });
    resizeControl();
});

jQuery(window).on('resize', function () {
    resizeControl();
});