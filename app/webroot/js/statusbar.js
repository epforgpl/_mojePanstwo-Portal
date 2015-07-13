/* Pure Javascript cause _mojePanstwo User Cockpit (top bar) will be portable on others sites where there's can be no jQuery, Prototype, etc */
var _mojePanstwoCockpitSlider = {
    dialog: {
        'boxName': 'mojePanstwoCockpitDialogBox',
        'invisibleName': 'mojePanstwoCockpitInvisibleDialogBox',
        'appMenu': 'hidden'
    },
    data: {
        collection: null,
        controllersCollection: null,
        menuWidth: null,
        totalSlides: null
    },
    setting: {
        'prefix': "mojePanstwoCockpit-prefix-",
        'prefixhighlightClass': "_mojePanstwoCockpitMenuUpSubMenuListActive",
        'controlPrefix': "mojePanstwoCockpit-control-",
        'controlPrefixhighlightClass': "_mojePanstwoCockpitMenuUpSubMenuControlsListActive",
        'containerID': "_mojePanstwoCockpitMenuUpSubMenuList",
        'controlsID': "_mojePanstwoCockpitMenuUpSubMenuControlsList",
        'controlsArrowLeft': "_mojePanstwoCockpitMenuUpSubMenuControlsArrowLeft",
        'controlsArrowRight': "_mojePanstwoCockpitMenuUpSubMenuControlsArrowRight",
        'delay': 3000,
        'animationInterval': 20,
        'transitionSteps': 30
    },
    transStat: {
        'crtStep': 0,
        'timeout': 0,
        'crtIndex': 1,
        'nextSlideIndex': 1
    },

    init: function () {
        // collect the slides and the controls
        _mojePanstwoCockpitSlider.data.collection = document.getElementById(_mojePanstwoCockpitSlider.setting.containerID).children;
        _mojePanstwoCockpitSlider.data.totalSlides = _mojePanstwoCockpitSlider.data.collection.length;
        if (_mojePanstwoCockpitSlider.data.totalSlides >= 2) {
            for (var i = 0; i < _mojePanstwoCockpitSlider.data.collection.length; i++) {
                // give IDs to slides and controls
                _mojePanstwoCockpitSlider.data.collection[i].id = _mojePanstwoCockpitSlider.setting.prefix + (i + 1);

                //create DOM element: anchor node
                var node = document.createElement('a');
                node.innerHTML = i;
                node.id = _mojePanstwoCockpitSlider.setting.controlPrefix + (i + 1);
                node.onclick = function (event) {
                    event.preventDefault();
                    _mojePanstwoCockpitSlider.clickSlide(this);
                };
                document.getElementById(_mojePanstwoCockpitSlider.setting.controlsID).appendChild(node);
            }

            _mojePanstwoCockpitSlider.data.controllersCollection = document.getElementById(_mojePanstwoCockpitSlider.setting.controlsID).children;

            document.getElementById(_mojePanstwoCockpitSlider.setting.prefix + '1').className = _mojePanstwoCockpitSlider.setting.prefixhighlightClass;
            document.getElementById(_mojePanstwoCockpitSlider.setting.controlPrefix + '1').className = _mojePanstwoCockpitSlider.setting.controlPrefixhighlightClass;
        }

        _mojePanstwoCockpitSlider.initDialogBox();
        _mojePanstwoCockpitSlider.transComplete();
    },

    clickSlide: function (control) {
        _mojePanstwoCockpitSlider.changeSlide(Number(control.id.substr(control.id.lastIndexOf("-") + 1)));
    },

    prevSlide: function () {
        _mojePanstwoCockpitSlider.changeSlide(Number((_mojePanstwoCockpitSlider.transStat.crtIndex - 1 <= 0) ? 1 : _mojePanstwoCockpitSlider.transStat.crtIndex - 1));

        return false;
    },

    nextSlide: function () {
        _mojePanstwoCockpitSlider.changeSlide(Number((_mojePanstwoCockpitSlider.transStat.crtIndex + 1 > _mojePanstwoCockpitSlider.data.totalSlides) ? _mojePanstwoCockpitSlider.data.totalSlides : _mojePanstwoCockpitSlider.transStat.crtIndex + 1));

        return false;
    },

    changeSlide: function (slideNo) {
        // don't do any action while a transition is in progress
        if (_mojePanstwoCockpitSlider.transStat.crtStep != 0 || slideNo == _mojePanstwoCockpitSlider.transStat.crtIndex)
            return;

        clearTimeout(_mojePanstwoCockpitSlider.transStat.timeout);

        // get references to the current slide and to the one to be shown next
        _mojePanstwoCockpitSlider.transStat.nextSlideIndex = slideNo;
        _mojePanstwoCockpitSlider.transStat.crtSlide = document.getElementById(_mojePanstwoCockpitSlider.setting.prefix + _mojePanstwoCockpitSlider.transStat.crtIndex);
        _mojePanstwoCockpitSlider.transStat.nextSlide = document.getElementById(_mojePanstwoCockpitSlider.setting.prefix + _mojePanstwoCockpitSlider.transStat.nextSlideIndex);
        _mojePanstwoCockpitSlider.transStat.crtStep = 0;

        _mojePanstwoCockpitSlider.transSlide();
    },

    transSlide: function () {
        // setup subMenu width (if not set yet)
        if (!_mojePanstwoCockpitSlider.data.menuWidth)
            _mojePanstwoCockpitSlider.data.menuWidth = document.getElementById(_mojePanstwoCockpitSlider.setting.containerID).offsetWidth;

        // make sure the next slide is visible (albeit transparent)
        _mojePanstwoCockpitSlider.transStat.nextSlide.style.display = "block";

        // calculate new move position
        if ((_mojePanstwoCockpitSlider.transStat.crtStep += _mojePanstwoCockpitSlider.setting.transitionSteps) > _mojePanstwoCockpitSlider.data.menuWidth)
            _mojePanstwoCockpitSlider.transStat.crtStep = _mojePanstwoCockpitSlider.data.menuWidth;

        // set direction of move (to the right)
        if (_mojePanstwoCockpitSlider.transStat.crtIndex < _mojePanstwoCockpitSlider.transStat.nextSlideIndex) {
            if (_mojePanstwoCockpitSlider.transStat.nextSlide.style.position != 'absolute')
                _mojePanstwoCockpitSlider.transStat.nextSlide.style.position = 'absolute';

            _mojePanstwoCockpitSlider.transStat.crtSlide.style.marginLeft = "-" + _mojePanstwoCockpitSlider.transStat.crtStep + "px";
            _mojePanstwoCockpitSlider.transStat.nextSlide.style.left = (_mojePanstwoCockpitSlider.data.menuWidth - _mojePanstwoCockpitSlider.transStat.crtStep) + "px";

        }// set direction of move (to the left)
        else if (_mojePanstwoCockpitSlider.transStat.crtIndex > _mojePanstwoCockpitSlider.transStat.nextSlideIndex) {
            if (_mojePanstwoCockpitSlider.transStat.nextSlide.style.position != 'absolute')
                _mojePanstwoCockpitSlider.transStat.nextSlide.style.position = 'absolute';

            _mojePanstwoCockpitSlider.transStat.crtSlide.style.marginLeft = _mojePanstwoCockpitSlider.transStat.crtStep + "px";
            _mojePanstwoCockpitSlider.transStat.nextSlide.style.left = "-" + (_mojePanstwoCockpitSlider.data.menuWidth - _mojePanstwoCockpitSlider.transStat.crtStep) + "px";
        }

        // if not completed, do this step again after a short delay
        if (_mojePanstwoCockpitSlider.transStat.crtStep < _mojePanstwoCockpitSlider.data.menuWidth)
            _mojePanstwoCockpitSlider.transStat.timeout = setTimeout("_mojePanstwoCockpitSlider.transSlide()", _mojePanstwoCockpitSlider.setting.animationInterval);
        else {
            // complete
            _mojePanstwoCockpitSlider.transStat.crtSlide.style.display = "none";
            _mojePanstwoCockpitSlider.transStat.crtSlide.style.marginLeft = "";
            _mojePanstwoCockpitSlider.transStat.nextSlide.style.position = "";
            _mojePanstwoCockpitSlider.transStat.nextSlide.style.left = "";
            _mojePanstwoCockpitSlider.transComplete();
        }
    },

    transComplete: function () {
        _mojePanstwoCockpitSlider.transStat.crtStep = 0;
        _mojePanstwoCockpitSlider.transStat.crtIndex = _mojePanstwoCockpitSlider.transStat.nextSlideIndex;

        if (_mojePanstwoCockpitSlider.data.totalSlides >= 2) {
            //unhighlight all controls
            for (var i = 0; i < _mojePanstwoCockpitSlider.data.controllersCollection.length; i++) {
                _mojePanstwoCockpitSlider.data.collection[i].className = "";
                _mojePanstwoCockpitSlider.data.controllersCollection[i].className = "";
            }

            // highlight the control for the next slide
            document.getElementById(_mojePanstwoCockpitSlider.setting.prefix + _mojePanstwoCockpitSlider.transStat.crtIndex).className = _mojePanstwoCockpitSlider.setting.prefixhighlightClass;
            document.getElementById(_mojePanstwoCockpitSlider.setting.controlPrefix + _mojePanstwoCockpitSlider.transStat.crtIndex).className = _mojePanstwoCockpitSlider.setting.controlPrefixhighlightClass;
        }
        // change arrow status
        if (_mojePanstwoCockpitSlider.transStat.crtIndex - 1 <= 0) {
            document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowLeft)[0].childNodes[0].style.opacity = "0.3";
            document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowLeft)[0].childNodes[0].style.filter = 'alpha(opacity="30")';
        } else {
            document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowLeft)[0].childNodes[0].style.opacity = "1";
            document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowLeft)[0].childNodes[0].style.filter = 'alpha(opacity="100")';

            // for IE filters, removing filters reenables cleartype
            if (document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowLeft)[0].childNodes[0].style.removeAttribute)
                document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowLeft)[0].childNodes[0].style.removeAttribute("filter");
        }

        if (_mojePanstwoCockpitSlider.transStat.crtIndex + 1 > _mojePanstwoCockpitSlider.data.totalSlides) {
            document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowRight)[0].childNodes[0].style.opacity = "0.3";
            document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowRight)[0].childNodes[0].style.filter = 'alpha(opacity="30")';
        } else {
            document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowRight)[0].childNodes[0].style.opacity = "1";
            document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowRight)[0].childNodes[0].style.filter = 'alpha(opacity="100")';

            // for IE filters, removing filters reenables cleartype
            if (document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowRight)[0].childNodes[0].style.removeAttribute)
                document.getElementsByClassName(_mojePanstwoCockpitSlider.setting.controlsArrowRight)[0].childNodes[0].style.removeAttribute("filter");
        }
    },

    initDialogBox: function () {
        var appFolders = document.getElementById('_mojePanstwoCockpitMenuUpSubMenuList').getElementsByClassName('appFolder');

        for (var i = 0; i < appFolders.length; i++) {
            appFolders[i].onclick = function (event) {
                event.preventDefault();
                _mojePanstwoCockpitSlider.showDialogBox(event);
            };
        }
    },

    showDialogBox: function (event) {
        var nodeMain = event.target;
        event.preventDefault();
        event.stopPropagation();

        //Closing menu list
        document.getElementById('_mojePanstwoCockpitMenuUpSubMenu').style.display = 'none';
        document.getElementById('_mojePanstwoCockpitMenuUpSubMenuTopArrow').style.display = 'none';

        while (nodeMain.className != 'appContruct appFolder') {
            nodeMain = nodeMain.parentNode;
        }

        // Check if invisible box exist - if not, we create it
        if (document.contains(document.getElementById(_mojePanstwoCockpitSlider.dialog.invisibleName))) {
            document.getElementById(_mojePanstwoCockpitSlider.dialog.invisibleName).style.display = 'block';
        } else {
            var invisibleBox = document.createElement('div');
            invisibleBox.id = _mojePanstwoCockpitSlider.dialog.invisibleName;
            document.body.appendChild(invisibleBox);
            invisibleBox.style.display = 'block';
        }

        // Check if application list dialog exist - if yes, we destroy it before create new one
        if (document.contains(document.getElementById(_mojePanstwoCockpitSlider.dialog.boxName)))
            _mojePanstwoCockpitSlider.destroyDialogBox();

        var appListDialog = document.createElement('div'),
            appListClone = nodeMain.getElementsByClassName('appList')[0].cloneNode(true);

        appListDialog.id = _mojePanstwoCockpitSlider.dialog.boxName;
        appListDialog.appendChild(appListClone);
        document.body.appendChild(appListDialog);

        //center dialog box
        var padding = 20,
            boxHeight = appListDialog.getElementsByClassName('appList')[0].offsetHeight + padding;

        if (boxHeight < ((window.outerHeight * 0.9) - document.getElementsByTagName('header')[0].offsetHeight))
            appListDialog.style.height = boxHeight + "px";
        appListDialog.style.marginTop = "-" + ((appListDialog.offsetHeight / 2) - document.getElementsByTagName('header')[0].offsetHeight - padding / 2 ) + "px";
        appListDialog.style.marginLeft = "-" + (appListDialog.offsetWidth / 2) + "px";

        _mojePanstwoCockpitSlider.animateDialogBox();

        document.getElementById(_mojePanstwoCockpitSlider.dialog.invisibleName).onclick = function () {
            _mojePanstwoCockpitSlider.hideDialogBox();
        }
    },

    animateDialogBox: function () {
        var dialogBox = document.getElementById(_mojePanstwoCockpitSlider.dialog.boxName),
            done = true;

        //Setting opacity to 0
        dialogBox.style.opacity = 0;
        dialogBox.style.filter = 'alpha(opacity=0)';

        //setting top position at 0;
        dialogBox.style.top = "0";

        if (done && dialogBox.style.opacity !== '1') {
            done = false;
            for (var i = 1; i <= 100; i++) {
                setTimeout((function (x) {
                    return function () {
                        dialogBox.style.opacity = x / 100;
                        dialogBox.style.filter = 'alpha(opacity=' + x + ')';

                        dialogBox.style.top = ((100 - x) / 5) + (x / 2) + "%";

                        if (x == 1) {
                            dialogBox.style.display = 'block';
                        }
                        if (x == 100) {
                            done = true;
                        }
                    };
                })(i), i * 4);
            }
        }
    },

    hideDialogBox: function () {
        if (document.contains(document.getElementById(_mojePanstwoCockpitSlider.dialog.invisibleName)))
            document.getElementById(_mojePanstwoCockpitSlider.dialog.invisibleName).style.display = 'none';
        _mojePanstwoCockpitSlider.destroyDialogBox();
    },

    destroyDialogBox: function () {
        if (document.contains(document.getElementById(_mojePanstwoCockpitSlider.dialog.boxName))) {
            var element = document.getElementById(_mojePanstwoCockpitSlider.dialog.boxName);
            element.parentNode.removeChild(element);
        }
    },
    slideDown: function (elem) {
        elem.style.maxHeight = '290px';
        elem.style.opacity = '1';
        document.getElementById('_mojePanstwoCockpitMenuUpSubMenuTopArrow').style.display = 'block';
        _mojePanstwoCockpitSlider.dialog.appMenu = 'visible';
    },
    slideUp: function (elem) {
        elem.style.maxHeight = '0';
        document.getElementById('_mojePanstwoCockpitMenuUpSubMenuTopArrow').style.display = 'none';
        _mojePanstwoCockpitSlider.once(1, function () {
            elem.style.opacity = '0';
            _mojePanstwoCockpitSlider.dialog.appMenu = 'hidden';

        });
    },
    once: function (seconds, callback) /* Execute once after the specified interval */ {
        var counter = 0;
        var time = window.setInterval(function () {
            counter++;
            if (counter >= seconds) {
                callback();
                window.clearInterval(time);
            }
        }, 800);
    }
};

(function () {
    _mojePanstwoCockpitSlider.init();

    document.getElementById('_mojePanstwoCockpitMenuUpContent').onclick = function (e) {
        e.stopPropagation();
        if (_mojePanstwoCockpitSlider.dialog.appMenu == 'hidden') {
            _mojePanstwoCockpitSlider.slideDown(document.getElementById('_mojePanstwoCockpitMenuUpSubMenu'));
        }
    };
    document.getElementsByClassName('_mojePanstwoCockpitMenuUpContentButton')[0].onclick = function () {
        if (_mojePanstwoCockpitSlider.dialog.appMenu == 'visible') {
            _mojePanstwoCockpitSlider.slideUp(document.getElementById('_mojePanstwoCockpitMenuUpSubMenu'));
        }
    };
    document.getElementsByTagName('html')[0].onclick = function () {
        if (_mojePanstwoCockpitSlider.dialog.appMenu == 'visible') {
            _mojePanstwoCockpitSlider.slideUp(document.getElementById('_mojePanstwoCockpitMenuUpSubMenu'));
        }
    }

    /*TEMPORARY HACK FOR LOGO CHANGE*/
    if (jQuery('._mojePanstwoCockpitLogo.firstTime').length > 0) {
        window.setTimeout(function () {
            jQuery('._mojePanstwoCockpitLogo.firstTime .morph').animate({
                width: '0'
            }, 1000, function () {
                jQuery('._mojePanstwoCockpitLogo.firstTime .morph').remove();
            });
            jQuery('._mojePanstwoCockpitLogo.firstTime').animate({
                'width': '140px'
            }, 1100, function () {
                jQuery('._mojePanstwoCockpitLogo.firstTime').removeClass('firstTime')
            })
            jQuery.cookie('_mPFirstTime', 0, {expires: 365, path: '/'});
        }, 5000);
    }
})();