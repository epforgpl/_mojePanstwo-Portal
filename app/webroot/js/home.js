/*global _mPHeart*/

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
    /*jQuery('#home').find('.apps .appFolder').click(function (event) {
     event.preventDefault();
     _mojePanstwoCockpitSlider.showDialogBox(event);
     });*/
    resizeControl();
});

jQuery(window).on('resize', function () {
    resizeControl();
});