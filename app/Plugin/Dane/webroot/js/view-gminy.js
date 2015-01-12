/*global googleMapAdres: true*/

function initialize() {
    //SETTING DEFAULT CENTER TO GOOGLE MAP AT POLAND//
    var polandLatlng = new google.maps.LatLng(51.919438, 19.145136),
        mapOptions = {
            zoom: 15,
            center: polandLatlng
        },
        map = new google.maps.Map(document.getElementById('googleMap'), mapOptions),
        geocoder = new google.maps.Geocoder(),
        contentString = document.createElement("div");
    contentString.innerHTML = googleMapAdres + '<a href="https://maps.google.com/maps?daddr=' + googleMapAdres.replace(/ /g, '+') + '&t=m" target="_blank" class="btn btn-info">Dojazd</a>';
    contentString.id = "googleMapsContent";
    contentString.style.width = "360px";

    /*GETTING HEIGHT OF CONTENT*/
    var contentStringHeightTemp = contentString.cloneNode(true);
    contentStringHeightTemp.style.visibility = "hidden";
    document.body.appendChild(contentStringHeightTemp);

    /*ADDING HEIGHT TO ORIGIN NODE*/
    contentString.style.height = contentStringHeightTemp.clientHeight;

    /*REMOVING CLONED NODE*/
    var element = document.getElementById("googleMapsContent");
    element.parentNode.removeChild(element);

    infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    geocoder.geocode({'address': googleMapAdres}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });

            //CENTER ON MARKER
            map.setCenter(results[0].geometry.location);

            google.maps.event.addListener(marker, 'click', function () {
                infowindow.open(map, marker);
            });

            //NEED TO WAIT A LITTLE UNTIL MAP IDLE AND CAN CENTER ON AUTO OPEN INFOWINDOW//
            google.maps.event.addListenerOnce(map, 'idle', function () {
                setTimeout(function () {
                    google.maps.event.trigger(marker, 'click');
                }, 2000);
            });
        }
    });
}

//ASYNC INIT GOOGLE MAP JS//
function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=' + _mPHeart.language.twoDig + '&' + 'callback=initialize';
    document.body.appendChild(script);
}

$(document).ready(function () {

    $('.objectTagsCloud').cloud({
        hwratio: .3,
        fog: .4
    });

    var banner = $('.profile_baner'),
        menu = $('.objectsPageContent .objectMenu'),
        menuAutoScroll = true,
        headerHeight = $('header').outerHeight();

    if (banner.length > 0) {
        banner.find('.bg img').css('width', banner.width() + 'px');

        /*ASYNCHRONIZE ACTION FOR GOOGLE MAP*/

        window.onload = loadScript();

        /*
         banner.find('.bg .btn').click(function () {
         banner.find('.bg').fadeOut()
         });
         */
    }

    /*STICKY MENU*/
    menu.attr('id', 'stickyMenu').css('width', menu.outerWidth() + 'px');
    sticky('#stickyMenu');

    menu.find('.nav a').click(function (event) {
        var target = jQuery(this).attr('href'),
            padding = 10;
        event.preventDefault();

        menuAutoScroll = false;
        menu.find('li.active').removeClass('active');
        jQuery(this).parent('li').addClass('active');

        jQuery('body, html').stop(true, true).animate({
            scrollTop: jQuery(target).offset().top - jQuery('header').outerHeight() - padding
        }, 800, function () {
            menuAutoScroll = true;
        });
    });
    $(window).scroll(function () {
        if (menuAutoScroll) {
            var windscroll = $(window).scrollTop(),
                searchHeight = ($('._mojePanstwoCockpitSearchInput:visible') ? $('._mojePanstwoCockpitSearchInput').outerHeight() : 0);
            if (windscroll >= 100) {
                $('.objectsPageContent .object > .block').each(function (i) {
                    if ($(this).position().top <= windscroll + headerHeight + searchHeight + 60) {
                        menu.find('li.active').removeClass('active');
                        menu.find('li').eq(i).addClass('active');
                    }
                });
            } else {
                menu.find('li.active').removeClass('active');
                menu.find('li:first').addClass('active');
            }
        }
    }).scroll();
});


$(function () {

    if (typeof(wyniki_wyborow) == 'undefined' || !wyniki_wyborow)
        return false;

    var data = [];
    for (var i = 0; i < wyniki_wyborow.length; i++) {

        var d = wyniki_wyborow[i];
        data.push({
            name: d['nazwa'],
            y: Number(wyniki_wyborow[i][0]['count']),
            url: 'radni/?komitet_id[]=' + wyniki_wyborow[i]['pl_gminy_radni']['komitet_id'] + '&q=&search=web'
        });

    }

    $('#komitety_chart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            height: 130
        },
        title: {
            text: ''
        },
        tooltip: {
            enabled: false
        },
        plotOptions: {
            pie: {
                size: 70,
                allowPointSelect: true,
                cursor: 'pointer',
                center: ["50%", "20%"],
                dataLabels: {
                    enabled: false,
                    format: '{point.name}: <b>{point.y}</b>',
                    style: {
                        color: '#157AB5'
                    }
                },
                showInLegend: true
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            location.href = this.options.url;
                        }
                    }
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [
            {
                type: 'pie',
                name: 'Liczba radnych',
                data: data
            }
        ],
        legend: {
            align: 'right',
            verticalAlign: 'top'
        }
    });
});