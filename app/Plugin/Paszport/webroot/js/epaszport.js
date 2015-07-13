jQuery(document).ready(function () {
    (function (window) {
        'use strict';

        function classReg(className) {
            return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
        }

        // classList support for class management
        // altho to be fair, the api sucks because it won't accept multiple classes at once
        var hasClass, addClass, removeClass;

        if ('classList' in document.documentElement) {
            hasClass = function (elem, c) {
                return elem.classList.contains(c);
            };
            addClass = function (elem, c) {
                elem.classList.add(c);
            };
            removeClass = function (elem, c) {
                elem.classList.remove(c);
            };
        } else {
            hasClass = function (elem, c) {
                return classReg(c).test(elem.className);
            };
            addClass = function (elem, c) {
                if (!hasClass(elem, c)) {
                    elem.className = elem.className + ' ' + c;
                }
            };
            removeClass = function (elem, c) {
                elem.className = elem.className.replace(classReg(c), ' ');
            };
        }

        function toggleClass(elem, c) {
            var fn = hasClass(elem, c) ? removeClass : addClass;
            fn(elem, c);
        }

        var classie = {
            // full names
            hasClass: hasClass,
            addClass: addClass,
            removeClass: removeClass,
            toggleClass: toggleClass,
            // short names
            has: hasClass,
            add: addClass,
            remove: removeClass,
            toggle: toggleClass
        };

        // transport
        if (typeof define === 'function' && define.amd) {
            // AMD
            define(classie);
        } else {
            // browser global
            window.classie = classie;
        }

    })(window);

    /**
     * modalEffects.js v1.0.0
     * http://www.codrops.com
     *
     * Licensed under the MIT license.
     * http://www.opensource.org/licenses/mit-license.php
     *
     * Copyright 2013, Codrops
     * http://www.codrops.com
     */
    var ModalEffects = (function () {
        function init() {
            var overlay = document.querySelector('.epaszportOverlay');
            [].slice.call(document.querySelectorAll('.epaszportTrigger')).forEach(function (el) {

                var modal = document.querySelector('#' + el.getAttribute('data-modal')),
                    close = modal.querySelector('.md-close');

                function removeModal(hasPerspective) {
                    classie.remove(modal, 'md-show');
                    classie.remove(overlay, 'md-show');

                    if (hasPerspective) {
                        classie.remove(document.documentElement, 'md-perspective');
                    }
                }

                function removeModalHandler() {
                    removeModal(classie.has(el, 'md-setperspective'));
                }

                el.addEventListener('click', function () {
                    classie.add(modal, 'md-show');
                    classie.add(overlay, 'md-show');
                    overlay.removeEventListener('click', removeModalHandler);
                    overlay.addEventListener('click', removeModalHandler);

                    if (classie.has(el, 'md-setperspective')) {
                        setTimeout(function () {
                            classie.add(document.documentElement, 'md-perspective');
                        }, 25);
                    }
                });

                close.addEventListener('click', function (ev) {
                    ev.stopPropagation();
                    removeModalHandler();
                });

            });
        }

        init();

    })();

    (function Pinger() {
        var pingerUrl = 'http://paszport.epf.org.pl/api/users/ping',
//            delay = 30000,
            ePaszport = jQuery('#epaszport'),
            pingerStatus = ePaszport.data('status');

        var checkStatus = function () {
            jQuery.ajax({
                url: pingerUrl,
                xhrFields: {
                    withCredentials: true
                },
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (parseInt(pingerStatus) !== parseInt(obj['status'])) {
                        if (parseInt(obj['status']) == 0) {
                            location.reload();
                        }
                    }
                }
            });
        };

//        checkStatus();
//        var pingerCheck = setInterval(checkStatus, delay);

    }());

    jQuery('#epaszport').find('.epaszportUser > nav > a.epaszportTrigger, .epaszportList > nav a.active').click(function (e) {
        e.preventDefault();
    });

    jQuery('#epaszportLogIn').find('.logInVia a').click(function (e) {
        if ($(this).hasClass('disabled')) {
            e.preventDefault();
        }
    })
});