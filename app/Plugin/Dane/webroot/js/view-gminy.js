/*global $,jQuery,sticky,mPHeart,google,googleMapAdres,wyniki_wyborow*/

function initialize() {
    "use strict";
    //SETTING DEFAULT CENTER TO GOOGLE MAP AT POLAND//
    var contentStringHeightTemp,
        infowindow,
        element,
        polandLatlng = new google.maps.LatLng(51.919438, 19.145136),
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
    contentStringHeightTemp = contentString.cloneNode(true);
    contentStringHeightTemp.style.visibility = "hidden";
    document.body.appendChild(contentStringHeightTemp);

    /*ADDING HEIGHT TO ORIGIN NODE*/
    contentString.style.height = contentStringHeightTemp.clientHeight;

    /*REMOVING CLONED NODE*/
    element = document.getElementById("googleMapsContent");
    element.parentNode.removeChild(element);

    infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    geocoder.geocode({'address': googleMapAdres}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
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
    "use strict";
    if ((typeof google !== "undefined") && google.maps) {
        initialize();
    } else {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&language=' + mPHeart.language.twoDig + '&callback=initialize';
        document.body.appendChild(script);
    }
}

$(function () {
    "use strict";
    if (typeof wyniki_wyborow !== "undefined") {
        var data = [], i, d;
        for (i = 0; i < wyniki_wyborow.length; i++) {
            d = wyniki_wyborow[i];
            /** @namespace wyniki_wyborow[i].pl_gminy_radni */
            /** @namespace wyniki_wyborow[i].pl_gminy_radni.komitet_id */
            data.push({
                name: d.nazwa,
                y: Number(wyniki_wyborow[i][0].count),
                url: 'radni/?komitet_id[]=' + wyniki_wyborow[i].pl_gminy_radni.komitet_id + '&q=&search=web'
            });
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
        }
    }
});