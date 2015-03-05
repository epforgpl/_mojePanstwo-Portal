(function ($) {
    var $box = $(".boxSize"),
        maxHeight = Math.max.apply(null, $box.map(function () {
            return $(this).outerHeight();
        }).get());

    console.log($box, maxHeight);

    $box.css('height', maxHeight);
}(jQuery));