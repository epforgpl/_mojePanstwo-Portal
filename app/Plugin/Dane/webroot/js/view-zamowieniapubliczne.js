$(document).ready(function () {

    var links = [];

    for (var i = 0; i < sources.length; i++) {

        var source = sources[i];
        links.push('<a target="_blank" href="http://bzp1.portal.uzp.gov.pl/index.php?ogloszenie=show&pozycja=' + source['numer'] + '&rok=' + source['data'] + '">' + source['numer'] + '</a>');

    }

    $('#sources').html(links.join(', '));


    $(".open_modal").click(function(){
        var numer=$(this).attr('numer');
       $('#'+numer+'').modal('show');
    });
});
