/*global TweenMax,TimelineMax,ScrollMagic*/
var infoController;

jQuery(function ($) {
    var
        $window = $(window),
        $html = $('html'),
        $body = $('body'),
        $htmlBody = $('html, body'),
        $header = $body.find('header'),

        $story = $('#storyLine'),
        $far = $story.find('.far'),
        $medium = $story.find('.medium'),
        $near = $story.find('.near'),

        minScreenWidth = 1000,
        screenWidth = ($body.innerWidth() < minScreenWidth) ? minScreenWidth : $body.innerWidth(),

        posMap,
        scrollDest = 0,
        duration = 1000,

        transformOrigin,
        center = $window.width() / 2 | 0,

        smallJump = '20%',
        keyMap = {
            33: '-100%', // pageUp
            34: '+100%', // pageDown
            35: 1 / 0, // end
            36: 0, // home
            37: '-' + smallJump, // left
            38: '-' + smallJump, // up
            39: '+' + smallJump, // right
            40: '+' + smallJump // down
        },
        keyThrottle = true,
        controller,
        lastCloudsOffset;

    $.easing.easeOutExpo = function (x, t, b, c, d) {
        return t === d ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
    };

    function introAnimation() {
        var offset = $story.offset().left,
            sl = $window.scrollLeft(),
            value = sl - 2 * offset,
            sejmLoc = $medium.find('.scene.sejm .building').offset().left,
            base = $medium.find('.scene.intro .scrollHint'),
            poselPoslankaSize = 411,
            poselPoslankaSizeLimit = 110,
            poselPoslankaWalkStart = 40,
            poselWalkScale = .3,
            poslankaWalkScale = .15,
            poselPoslankaWalkBond = 106,
            poslanka = base.find('.poslankaBckgrnd'),
            posel = base.find('.poselBckgrnd');

        if (value < sejmLoc) {
            poslanka.css({
                left: (value * 1.4 < sejmLoc) ? value * 1.4 : (poslanka.offset().left > sejmLoc) ? value * 1.4 : poslanka.offset().left,
                bottom: (Math.floor(poselPoslankaWalkStart + value * poslankaWalkScale) < poselPoslankaWalkBond) ? Math.floor(poselPoslankaWalkStart + value * poslankaWalkScale) : poselPoslankaWalkBond,
                height: (poselPoslankaSize - value > poselPoslankaSizeLimit) ? (poselPoslankaSize - value) : poselPoslankaSizeLimit
            });
            posel.css({
                right: (value * .9 < sejmLoc) ? -value * .9 : (poslanka.offset().left > sejmLoc) ? -value * 0.9 : -sejmLoc,
                bottom: (Math.floor(poselPoslankaWalkStart + value * poselWalkScale) < poselPoslankaWalkBond) ? Math.floor(poselPoslankaWalkStart + value * poselWalkScale) : poselPoslankaWalkBond,
                height: (poselPoslankaSize - value > poselPoslankaSizeLimit) ? (poselPoslankaSize - value) : poselPoslankaSizeLimit
            });

            (poslanka.offset().left > sejmLoc) ? poslanka.css('visibility', 'hidden') : poslanka.css('visibility', 'visible');
            (posel.offset().left > sejmLoc) ? posel.css('visibility', 'hidden') : posel.css('visibility', 'visible');
        }
    }

    function calculateOffsets() {
        posMap = [];
        $medium.find('.scene').each(function () {
            posMap.push({
                elem: $(this),
                pos: $(this).prop('offsetLeft') - $window['width']() / 2 | 0
            });
        });
        posMap.sort(function (a, b) {
            return b.pos - a.pos;
        });
        $window.triggerHandler('scroll');
    }

    function repeatButton() {
        $medium.find('.scene.stats .repeat').click(function (e) {
            e.preventDefault();

            scrollTo(0);
            setTimeout(function () {
                onResize();
            }, 1050);
        });
    }

    function scrollTo(dest) {
        var obj = {}, multiplier, realStep,
            max = $story.find('.medium').outerWidth() - screenWidth;

        if (!$htmlBody.is(':animated')) {
            scrollDest = $window['scrollLeft']();
        }
        if (typeof dest === 'string') {
            multiplier = dest.indexOf('-') >= 0 ? -1 : 1;
            realStep = +smallJump || +String(smallJump).replace(/[^\d]/g, '') / 100 * screenWidth;
            dest = scrollDest + (dest.indexOf('%') >= 0 ? multiplier * realStep : +dest || 0);
        }
        scrollDest = Math.max(0, Math.min(max, dest));
        obj['scrollLeft'] = scrollDest;
        $htmlBody.stop(true).animate(obj, {
            duration: duration,
            easing: 'easeOutExpo',
            queue: false
        });
    }

    function keyHandler(e) {
        var keyCode = e.which || e.keyCode || e.originalEvent.keyCode;

        if (!keyThrottle) return undefined;

        keyThrottle = false;
        if (keyMap[keyCode] != null) {
            e.preventDefault();
            scrollTo(keyMap[keyCode]);
            setTimeout(function () {
                keyThrottle = true;
            }, 0);
        }
    }

    function tickHandler() {
        var offset = $story.offset().left,
            sl = $window.scrollLeft(),
            value = sl - 2 * offset;
        if (lastCloudsOffset !== value) {
            lastCloudsOffset = value;
            $far.find('.clouds').css('left', (value / 14300 * 3000) * 1.5 | 0);
        }
    }

    function onResize() {
        transformOrigin = center + 'px ' + center * 6 + 'px';

        if (controller) {
            controller.destroy();
        }

        /*SET SCREEN SIZE*/
        $medium.find('.scene:first, .scene.stats .screen').css('width', screenWidth);
        //$medium.find('.scene.stats').css('width', screenWidth * 2);
        $medium.find('.scene.stats').css('width', screenWidth);

        $far.find('.clouds').css('marginLeft', screenWidth);

        $story.css({'width': screenWidth, 'height': $body.innerHeight() - $header.outerHeight(true)});
        $story.find('.far, .medium, .near').css({'width': $medium.outerWidth(true)});

        infoController = controller = new ScrollMagic({
            vertical: false,
            loglevel: 2
        });

        /*SETTING POSITION OF ANIMATED ELEMENTS*/
        $near.find('.posel').removeClass('outfit').css({
            left: $medium.find('.scene.sejm').position().left + 600,
            height: "",
            bottom: ""
        });
        $near.find('.samochod').removeClass('in').css({left: $medium.find('.scene.spotkanie').position().left + 700});
        $near.find('.taxi').removeClass('in').css({
            left: $medium.find('.scene.tlumaczenia').position().left,
            opacity: 0
        });
        $near.find('.samolot').css({
            left: $medium.find('.scene.lotnisko').position().left + 215,
            bottom: "",
            transform: ""
        });

        /*SEJM POSEL*/
        var sejmPosel = new TimelineMax()
            .add(TweenMax.fromTo($medium.find('.scene.sejm .stat.wyplacane'), 0.25, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.fromTo($medium.find('.scene.sejm .stat.diety'), 0.25, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.fromTo($near.find('.posel'), 3, {
                left: $medium.find('.scene.sejm').position().left + 600
            }, {left: $medium.find('.scene.sejm').position().left + 900}));


        new ScrollScene({
            duration: ($medium.find('.scene.sejm').width())
        }).on("end", function () {
                $medium.find('.scene.sejm .stat').addClass('out');
            })
            .triggerElement($medium.find('.scene.sejm'))
            .setTween(sejmPosel)
            .reverse(false)
            .addTo(controller);

        /*POSEL WALK - BIURO + INSIDE*/
        var biuroPosel = new TimelineMax()
            .add(TweenMax.to($near.find('.posel'), 0.5, {left: $medium.find('.scene.biuro').position().left + 470}))
            .add(TweenMax.fromTo($medium.find('.scene.biuro .stat.biura'), 0.25, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.fromTo($medium.find('.scene.biuro .stat.pracownikow'), 0.25, {opacity: 0}, {opacity: 1}));
        // .add(TweenMax.fromTo($medium.find('.scene.biuro .stat.konserwacje'), 0.25, {opacity: 0}, {opacity: 1}))
        // .add(TweenMax.fromTo($medium.find('.scene.biuro .stat.naprawy'), 0.25, {opacity: 0}, {opacity: 1}));

        new ScrollScene({
            duration: $medium.find('.scene.biuro').width() * .7
        }).on("end", function () {
                $medium.find('.scene.biuro').find('.stat').addClass('out');
            })
            .triggerElement($medium.find('.scene.biuro'))
            .setTween(biuroPosel)
            .reverse(false)
            .addTo(controller);

        /*POSEL WALK - BIURO + SKLEP*/
        var biuroSklep = new TimelineMax()
            .add(TweenMax.to($near.find('.posel'), 2, {left: $medium.find('.scene.sklep').position().left + $medium.find('.scene.sklep').width() - 480}))
            .add(TweenMax.fromTo($medium.find('.scene.sklep .stat.materialy'), 0.25, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.fromTo($medium.find('.scene.sklep .stat.srodki'), 0.25, {opacity: 0}, {opacity: 1}));

        new ScrollScene({
            duration: $medium.find('.scene.sklep').width() * .7
        }).on("end", function () {
                $medium.find('.scene.sklep').find('.stat').addClass('out');
            })
            .triggerElement($medium.find('.scene.biuro .marker'))
            .setTween(biuroSklep)
            .reverse(false)
            .addTo(controller);

        /*POSEL WALK - SKLEP, SZPITAL, BANK, SPOTKANIE*/
        var poselWalk = new TimelineMax()
            .add(TweenMax.fromTo($near.find('.posel'), 0.5, {left: $medium.find('.scene.sklep').position().left + $medium.find('.scene.sklep').width() - 480}, {left: $medium.find('.scene.spotkanie').position().left + 20}))

            /*
             .add(TweenMax.fromTo($medium.find('.scene.szpital .stat.korespondencja'), 0.5, {opacity: 0}, {opacity: 1}))
             .add(TweenMax.to($near.find('.posel'), 0.5, {left: $medium.find('.scene.szpital').position().left + $medium.find('.scene.szpital').width() - 250}))
             .add(TweenMax.fromTo($medium.find('.scene.szpital .stat.badania'), 0.25, {opacity: 0}, {opacity: 1}))
             .add(TweenMax.fromTo($medium.find('.scene.szpital .stat.swiadczenia'), 0.25, {opacity: 0}, {opacity: 1}))
             .add(TweenMax.to($near.find('.posel'), 0.5, {left: $medium.find('.scene.bank').position().left + $medium.find('.scene.bank').width() / 2}))
             .add(TweenMax.fromTo($medium.find('.scene.bank .stat.rachunki'), 0.5, {opacity: 0}, {opacity: 1}))
             */
            .add(TweenMax.to($near.find('.posel'), 0.5, {left: $medium.find('.scene.spotkanie').position().left + 490}))
            .add(TweenMax.fromTo($medium.find('.scene.spotkanie .stat.sala'), 0.5, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.to($near.find('.posel'), 0.2, {left: $near.find('.samochod').position().left + 80}))
            .add(TweenMax.to($near.find('.posel'), 0.1, {bottom: 107}))
            .add(TweenMax.to($near.find('.posel'), 0.1, {bottom: 122, height: 50}));

        new ScrollScene({
            duration: ($medium.find('.scene.sklep').width() / 2 + $medium.find('.scene.spotkanie').width() / 2)
        }).on("end", function () {
                $medium.find('.scene.spotkanie').find('.stat').addClass('out');
                $near.find('.posel').css('visibility', 'hidden');
                $near.find('.samochod').addClass('in');
            })
            .triggerElement($medium.find('.scene.sklep .marker'))
            .setTween(poselWalk)
            .reverse(false)
            .addTo(controller);

        /*POSEL SAMOCHOD - SPOTKANIE, TLUMACZENIE*/
        var spotkanieSamochod = new TimelineMax()
            .add(TweenMax.fromTo($medium.find('.scene.tlumaczenia .stat.przejazd'), 0.25, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.fromTo($near.find('.samochod'), 3, {left: $medium.find('.scene.spotkanie').position().left + 700}, {left: $medium.find('.scene.tlumaczenia').position().left + $medium.find('.scene.tlumaczenia').width() - 400}));

        new ScrollScene({
            duration: minScreenWidth / 2
        }).on("end", function () {
                $medium.find('.scene.spotkanie .stat').addClass('out');
            })
            .triggerElement($medium.find('.scene.spotkanie .marker'))
            .setTween(spotkanieSamochod)
            .reverse(false)
            .addTo(controller);

        /*POSEL WALK - TLUMACZENIE*/
        var poselTlumaczenia = new TimelineMax()
            .add(TweenMax.to($near.find('.posel'), 0.1, {bottom: 107, height: 110, opacity: 1}))
            .add(TweenMax.to($near.find('.posel'), 0.1, {bottom: 122}))
            .add(TweenMax.fromTo($medium.find('.scene.tlumaczenia .stat.ekspertyzy'), 0.25, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.fromTo($medium.find('.scene.tlumaczenia .stat.zlecenia'), 0.25, {opacity: 0}, {opacity: 1}));

        new ScrollScene({
            duration: ($medium.find('.scene.tlumaczenia').width())
        }).on("start", function () {
                $near.find('.samochod').removeClass('in');
                $near.find('.posel').addClass('outfit phone').css({
                    left: $medium.find('.scene.tlumaczenia').position().left + $medium.find('.scene.tlumaczenia').width() - 320,
                    visibility: 'visible'
                });
            })
            .on("end", function () {
                $medium.find('.scene.tlumaczenia .stat').addClass('out');
            })
            .triggerElement($medium.find('.scene.tlumaczenia .marker'))
            .setTween(poselTlumaczenia)
            .reverse(false)
            .addTo(controller);


        /*POSEL WALK - TLUMACZENIE, DOM*/
        var poselDom = new TimelineMax()
            .add(TweenMax.to($near.find('.posel'), 2, {left: $medium.find('.scene.dom').position().left + 290}))
            // .add(TweenMax.fromTo($medium.find('.scene.dom .stat.telefonDom'), 0.5, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.fromTo($medium.find('.scene.dom .stat.telefonPosel'), 0.5, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.to($near.find('.posel'), 2, {left: $medium.find('.scene.dom').position().left + $medium.find('.scene.dom').width() - 290}))
            .add(TweenMax.fromTo($medium.find('.scene.dom .stat.prywatny'), 0.25, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.fromTo($medium.find('.scene.dom .stat.dom'), 0.25, {opacity: 0}, {opacity: 1}));


        new ScrollScene({
            duration: ($medium.find('.scene.dom').width())
        }).on("end", function () {
                $medium.find('.scene.dom .stat').addClass('out');
            })
            .triggerElement($medium.find('.scene.dom'))
            .setTween(poselDom)
            .reverse(false)
            .addTo(controller);

        /*POSEL TAXI - CALL*/
        var poselTaxi = new TimelineMax()
            .add(TweenMax.fromTo($near.find('.taxi'), 10, {
                left: $medium.find('.scene.tlumaczenia').position().left,
                opacity: 0
            }, {left: $medium.find('.scene.tlumaczenia').position().left, opacity: 1}))
            .add(TweenMax.to($near.find('.taxi'), 6, {left: $medium.find('.scene.dom').position().left + $medium.find('.scene.dom').width() - 300}))
            .add(TweenMax.to($near.find('.posel'), 1.5, {left: $medium.find('.scene.dom').position().left + $medium.find('.scene.dom').width() - 220}))
            .add(TweenMax.to($near.find('.posel'), 0.1, {bottom: 107}))
            .add(TweenMax.to($near.find('.posel'), 0.1, {bottom: 125, height: 50}));

        new ScrollScene({
            duration: ($medium.find('.scene.dom').width())
        }).on("end", function () {
                $near.find('.posel').css({visibility: 'hidden'});
                $near.find('.posel').removeClass('phone');
                $near.find('.taxi').addClass('in');
            })
            .triggerElement($medium.find('.scene.dom'))
            .setTween(poselTaxi)
            .reverse(false)
            .addTo(controller);

        /*POSEL TAXI - RIDE*/
        var poselTaxiRide = new TimelineMax()
            .add(TweenMax.fromTo($near.find('.taxi'), 1, {left: $medium.find('.scene.dom').position().left + $medium.find('.scene.dom').width() - 300}, {left: $medium.find('.scene.droga').position().left + ($medium.find('.scene.droga').width() / 2) - 100}))
            .add(TweenMax.fromTo($medium.find('.scene.droga .stat.taksowka'), 0.5, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.to($near.find('.taxi'), 1, {left: $medium.find('.scene.lotnisko').position().left - 80}));

        new ScrollScene({
            duration: ($medium.find('.scene.droga').width() / 2)
        }).on("end", function () {
                $medium.find('.scene.droga').find('.stat').addClass('out');
            })
            .triggerElement($medium.find('.scene.droga .marker'))
            .setTween(poselTaxiRide)
            .reverse(false)
            .addTo(controller);

        /*POSEL LOTNISKO - WALK*/
        var poselLotnisko = new TimelineMax()
            .add(TweenMax.fromTo($near.find('.posel'), 0.1, {left: $medium.find('.scene.lotnisko').position().left}, {
                left: $medium.find('.scene.lotnisko').position().left,
                bottom: 107,
                height: 110
            }))
            .add(TweenMax.to($near.find('.posel'), 0.1, {bottom: 122}))
            .add(TweenMax.fromTo($medium.find('.scene.lotnisko .stat.loty'), 0.5, {opacity: 0}, {opacity: 1}))
            .add(TweenMax.to($near.find('.posel'), 1, {left: $medium.find('.scene.lotnisko').position().left + 200}))
            .add(TweenMax.to($near.find('.posel'), 0.5, {opacity: 0}));

        new ScrollScene({
            duration: ($medium.find('.scene.lotnisko').width() / 2)
        }).on("start", function () {
                $near.find('.posel').css({
                    visibility: 'visible',
                    left: $medium.find('.scene.lotnisko').position().left
                });
                $near.find('.taxi').removeClass('in');
            })
            .on("end", function () {
                $near.find('.posel').css({visibility: 'hidden'});
                $medium.find('.scene.lotnisko').find('.stat').addClass('out');
            })
            .triggerElement($medium.find('.scene.lotnisko'))
            .setTween(poselLotnisko)
            .reverse(false)
            .addTo(controller);

        /*POSEL LOT*/
        var poselLot = new TimelineMax()
            .add(TweenMax.fromTo($near.find('.samolot'), 5, {
                left: $medium.find('.scene.lotnisko').position().left + 215,
                rotation: 0
            }, {
                left: $medium.find('.scene.stats').position().left,
                bottom: "+=" + $window.height() / 2,
                rotation: -15
            }));

        new ScrollScene({
            duration: ($medium.find('.scene.lot').width())
        })
            .triggerElement($medium.find('.scene.lotnisko .marker'))
            .setTween(poselLot)
            .reverse(false)
            .addTo(controller);
    }

    $window.scroll(function () {
        if (posMap) {
            var i, pos = $window['scrollLeft']() + $html['width']() / 2;

            for (i = 0; i < posMap.length; i += 1) {
                if (posMap[i].pos < pos) {
                    break;
                }
            }
        }
    });

    $body.on('mousewheel DOMMouseScroll', function (e) {
        var delta = 0;
        e = e.originalEvent;
        if (e.wheelDelta) {
            delta = -e.wheelDelta;
        }
        if (e.detail) {
            delta = e.detail * 40;
        }

        if ((delta > minScreenWidth * .02) || (delta < -(minScreenWidth * .2)))
            delta = Math.floor(minScreenWidth * .02);

        scrollTo(String(Math.floor(delta)));

        return false;
    });

    $body.keydown(keyHandler);
    $body.keypress(keyHandler);
    $window.resize(calculateOffsets);
    $window.resize(onResize);

    introAnimation();
    repeatButton();
    scrollTo(0);
    setTimeout(function () {
        onResize();
        calculateOffsets();
        TweenLite.ticker.addEventListener('tick', introAnimation);
    }, 1050);

    TweenLite.ticker.addEventListener('tick', tickHandler);

    // wykopywarka wersja standardowa (72x65)
    var wykop_url = "http://mojepanstwo.pl/wydatki_poslow",
        wykop_title = encodeURIComponent('Wydatki posłów'),
        wykop_desc = encodeURIComponent('Sprawdź na co posłowie wydają publiczne pieniądze'),
        widget_bg = '7CAD2B',
        widget_type = 'normal';
    var widget_url = 'http://www.wykop.pl/dataprovider/diggerwidget/?url=' + encodeURIComponent(wykop_url) + '&title=' + (wykop_title) + '&desc=' + (wykop_desc) + '&bg=' + (widget_bg) + '&type=' + (widget_type);
    $('.social').append(
        $('<iframe></iframe>').attr({
            'src': widget_url,
            'frameborder': "0",
            'border': "0"
        }).css({
            border: 'none',
            width: '72px',
            height: '65px',
            overflow: 'hidden',
            margin: 0,
            padding: 0
        })
    );
});