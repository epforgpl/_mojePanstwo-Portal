/*global translation*/

var DataObjectesAjax = {
    ajaxRequest: null,

    init: function () {
        this.setLanguage();
        this.HistoryMagic();
        this.sniffForClick();
        this.sniffForWordChange();
        this.sorting();
        this.pageChange();
        this.submitChanger();
        this.datepickerForInputs();
        this.removeHiddenInput();
        this.buttonSearchWithoutPhrase();
    },
    /*WE ARE REMOVING HIDDEN INPUT NEED ONLY TO WORK CORRECTLY FORM WHEN PAGE DOESN'T PROVIDE JS */
    removeHiddenInput: function () {
        jQuery('#DatasetViewForm input[type="hidden"], .dataSortings input[type="hidden"]').remove();
    },
    setLanguage: function () {
        switch (mPHeart.language.threeDig) {
            case "pol":
                /*CHANGE DATEPICKER i18n LANGUAGE*/
                jQuery.datepicker.setDefaults(jQuery.datepicker.regional['pl']);
                break;
            case "eng":
                /*CHANGE DATEPICKER i18n LANGUAGE*/
                jQuery.datepicker.setDefaults(jQuery.datepicker.regional['']);
                break;
        }
    },
    HistoryMagic: function () {
        History.Adapter.bind(window, 'statechange', function () { // Note: We are using statechange instead of popstate
            var State = History.getState(); // Note: We are using History.getState() instead of event.state

            if (State.data.page == "Dane")
                DataObjectesAjax.ajaxReload(State.data.filters, State.data.focusInput);
        })
    },
    /*CREATING ADDITIONAL BUTTON TO RUN SEARCH WITHOUT LOOKING PHRASE (Q)*/
    buttonSearchWithoutPhrase: function () {
        var buttonExistance = jQuery('<span></span>').addClass('searchWithoutPhrase glyphicon glyphicon-remove'),
            filters = jQuery('#filters');

        filters.find('.filter input[type="text"]:not(".hide")').each(function () {
            var that = jQuery(this);

            if (that.val() != '') {
                var inputParent = that.parent();

                if (inputParent.find('.searchWithoutPhrase[data-connect="' + that.attr('name') + '"]').length == 0) {
                    inputParent.append(buttonExistance.clone().data('connect', that.attr('name')).css('top', Math.floor(that.position().top) + 10));
                }
            }
        });

        filters.find('.searchWithoutPhrase').each(function () {
            jQuery(this).click(function () {
                var that = jQuery(this),
                    parent = that.parent(),
                    date;

                parent.find('input[name="' + that.data('connect') + '"]').val('');

                if (parent.hasClass('daysMulti')) {
                    var from = parent.find('.multi.from').val(),
                        till = parent.find('.multi.till').val();

                    if (from !== '' || till !== '')
                        date = "[" + ((from !== '') ? from : "*") + "TO" + ((till !== '') ? till : "*") + "]";
                    else
                        date = null;
                } else {
                    date = null;
                }

                parent.parent().find('> .dates').val(date);

                setTimeout(DataObjectesAjax.objectsReload, 5);
            });
        });
    },
    /*CHECK IF ANY OPTION WASN'T CHANGE - BY CLICK*/
    sniffForClick: function () {
        var filters = jQuery('.dataBrowser').find('.dataFilters');

        filters.find('.option label').click(function (event) {
            var parent = jQuery(event.target).parent();

            if (parent.attr('class') && parent.attr('class') == 'radio-inline') {
                if (parent.find('#' + jQuery(event.target).attr('for')).prop("checked")) {
                    setTimeout(function () {
                        jQuery('#' + jQuery(event.target).attr('for')).prop("checked", false)
                    }, 0);
                }
            } else if (jQuery(event.target).attr('for').substr(0, 9) == 'switcher_') {
                if (parent.find('input').is(':checked')) {
                    setTimeout(function () {
                        parent.removeClass('active');
                        parent.find('input').prop("checked", false);
                    }, 0);
                } else {
                    parent.parents('.options').find('input').prop("checked", false);
                    parent.parents('.options .active').removeClass('active');
                }
            }

            /*HISTORY.JS CHANGE STATUS*/
            setTimeout(DataObjectesAjax.objectsReload, 5);
        });

        var dataDetailsToggle;
        if ((dataDetailsToggle = jQuery('.dataDetailsToggle')).length) {
            dataDetailsToggle.click(function (e) {
                e.preventDefault();

                if (jQuery(this).data('state') == 'more') {
                    jQuery(this).data('state', 'less').find('.text').text('Mniej szczegółów');
                    jQuery(this).find('.glyphicon').removeClass('glyphicon-plus').addClass('glyphicon-minus');
                    $('.dataBrowser .dataHighlights').stop(true, true).slideDown();
                } else {
                    jQuery(this).data('state', 'more').find('.text').text('Więcej szczegółów');
                    jQuery(this).find('.glyphicon').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                    $('.dataBrowser .dataHighlights').stop(true, true).slideUp();
                }
            });
        }
    },
    sniffForWordChange: function () {
        var innerSearch;

        if ((innerSearch = $('#innerSearch')).length) {
            innerSearch.focus();
            /*innerSearch.keyup(function (e) {
             if (innerSearch.val() != innerSearch.data('last') && (e.which != "13")) {
             innerSearch.data('last', innerSearch.val());
             setTimeout(DataObjectesAjax.objectsReload, 1000);
             }
             })*/
        }
    },
    submitChanger: function () {
        /*BLOCK SUBMIT OPTION AND SEND IT BY AJAX*/
        jQuery('#DatasetViewForm').submit(function (event) {
            event.preventDefault();

            setTimeout(DataObjectesAjax.objectsReload, 5);
        })
    },
    datepickerForInputs: function () {
        var filters = jQuery('.dataBrowser').find('.dataFilters'),
            dateRegex = new RegExp('\\[');

        jQuery.datepicker.setDefaults({
            'dateFormat': 'yy-mm-dd',
            'changeMonth': true,
            'changeYear': true,
            'yearRange': "1900:" + new Date().getFullYear(),
            'onSelect': function (date) {
                var that = this,
                    there = jQuery(that),
                    parent = there.parent();

                if (parent.hasClass('daysMulti')) {
                    var option = there.hasClass('from') ? "minDate" : "maxDate";
                    var instance = there.data("datepicker");
                    var rangeDate = jQuery.datepicker.parseDate(instance.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, date, instance.settings);

                    parent.find('.jquery-datepicker.multi').not(that).datepicker("option", option, rangeDate);

                    var from = jQuery('input[name="' + there.data('main') + 'DaysMultiFrom"]').val(),
                        till = jQuery('input[name="' + there.data('main') + 'DaysMultiTill"]').val();

                    date = "[" + ((from !== '') ? from : "*") + "TO" + ((till !== '') ? till : "*") + "]";

                }

                jQuery('input[name="' + there.data('main') + '"]').val(date);

                setTimeout(DataObjectesAjax.objectsReload, 5);
            }
        });

        filters.find('.jquery-datepicker').each(function () {
            jQuery(this).datepicker();
        });

        filters.find('.dates').each(function () {
            var that = jQuery(this),
                parents = that.parents('.filter'),
                d = that.val(),
                from = jQuery('input[name="' + that.attr('name') + 'DaysMultiFrom' + '"].multi.from'),
                till = jQuery('input[name="' + that.attr('name') + 'DaysMultiTill' + '"].multi.till');

            if (dateRegex.exec(d) != null) {
                d = d.substring(1, d.length - 1);
                d = d.split('TO');
                if (d[0] != '*') {
                    from.val(d[0]);

                    /*SET MINDATE FOR TILL INPUT*/
                    var instanceFrom = from.data("datepicker");
                    var rangeDataFrom = jQuery.datepicker.parseDate(instanceFrom.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, d[0], instanceFrom.settings);
                    parents.find('.daysMulti > input.till').datepicker("option", 'minDate', rangeDataFrom);
                }
                if (d[1] != '*') {
                    till.val(d[1]);

                    /*SET MAXDATE FOR FROM INPUT*/
                    var instanceTill = till.data("datepicker");
                    var rangeDataTill = jQuery.datepicker.parseDate(instanceTill.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, d[1], instanceTill.settings);
                    parents.find('.daysMulti > input.from').datepicker("option", 'maxDate', rangeDataTill);
                }

                parents.find('.daysButton .single').removeClass('disabled');
                parents.find('.daysButton .multi').addClass('disabled');

                parents.find('.daysSingle').addClass('hide');
                parents.find('.daysMulti').removeClass('hide');
            } else {
                jQuery('input[name="' + that.attr('name') + 'DaysSingle' + '"]').val(d);

                parents.find('.daysButton .single').addClass('disabled');
                parents.find('.daysButton .multi').removeClass('disabled');

                parents.find('.daysSingle').removeClass('hide');
                parents.find('.daysMulti').addClass('hide');
            }
        });
    },
    /*REDESIGN SORTING OPTION AND ADD AJAX REQUEST*/
    sorting: function () {
        var sorting = jQuery('.dataSortings');

        /*HIDE UNNECESSARY ELEMENTS*/
        sorting.find('.submit').hide();
        sorting.find('#DatasetDirection').hide();
        sorting.find('.sortingName').addClass('hidden');

        /*CREATE DROPDOWN MENU STRUCTURE*/
        var sortingChosen = (sorting.find('#DatasetSort option:selected').length > 0) ? sorting.find('#DatasetSort option:selected') : sorting.find('#DatasetSort option:first');

        jQuery('.dataSortingToggle').attr({'title': sortingChosen.attr('title')});
        var ul = jQuery('.dataSortingMenu');

        jQuery.each(sorting.find('#DatasetSort optgroup'), function () {
            var li = jQuery('<li></li>'),
                grp = jQuery(this);

            if (grp.data('special') == 'result') {
                li.addClass('special result').append(function () {
                    var that = jQuery(this);
                    jQuery.each(grp.find('option'), function () {
                        that.append(jQuery('<a></a>').attr({
                            'href': '#',
                            'title': jQuery.trim(jQuery(this).text()),
                            'value': jQuery(this).val()
                        }).text(jQuery.trim(jQuery(this).text())))
                    });
                });
            } else {
                li.append(
                    jQuery('<a></a>').text(grp.attr('label')).attr('href', '#')
                );
            }
            ul.append(li);
        });

        // ul.find('li a[value="' + sortingChosen.val() + '"]').addClass('active');
        DataObjectesAjax.sortingAddRemoveOptions();

        ul.find('a').click(function (event) {
            var sortingDirection = sorting.find('.DatasetSort');
            event.preventDefault();

            sortingDirection.data('sort', jQuery(this).attr('value')).text(jQuery(this).attr('title'));
            DataObjectesAjax.sortingReload();
        });


        var innerSearch;
        if ((innerSearch = jQuery('#innerSearch')).length) {
            innerSearch.keypress(function (e) {
                if (e.which == 13) {
                    e.preventDefault();

                    DataObjectesAjax.sortingReload();
                }
            });
        }
    },
    /*ADDING/REMOVING NEW OPTION NORMALY ADDED AT GENERATING PAGE*/
    sortingAddRemoveOptions: function () {
        var filtersInputQ = jQuery('#filters').find('input[name="q"]'),
            sortingGroup = jQuery('.dataSortings .sortingGroup'),
            sortingName = sortingGroup.find('.DatasetSort'),
            sortingList = sortingGroup.find('ul.dropdown-menu');

        /*WHEN "LOOKING PHRASE" EXIST - WE ADD NEW OPTIONS AT SORTING...*/
        if (((filtersInputQ.length > 0) && (filtersInputQ.val() != '')) && (sortingList.find('a[value="score desc"]').length == 0)) {
            sortingList.prepend(jQuery('<li></li>').addClass('special result').append(jQuery('<a></a>').attr({
                'href': '#',
                'title': mPHeart.translation.LC_DANE_SORTOWANIE_TRAFNOSC,
                'value': 'score desc'
            }).text(mPHeart.translation.LC_DANE_SORTOWANIE_TRAFNOSC)));
            sortingName.text(mPHeart.translation.LC_DANE_SORTOWANIE_TRAFNOSC);
        }

        /*... AND WHEN "LOOKING PHRASE" NOT EXIST - WE REMOVE IT*/
        if (((filtersInputQ.length == 0) || (filtersInputQ.val() == '')) && (sortingList.find('a[value="score desc"]').length != 0)) {
            sortingList.find('li.special.result').remove();
            sortingName.text(sortingList.find('a:first').attr('title'));
        }
    },
    /*FUNCTION RUN CHAGE PAGE BY AJAX*/
    pageChange: function () {
        var dataObject = jQuery('.dataBrowser').find('.dataObjects');

        dataObject.find('.pagination a').click(function (event) {
            event.preventDefault();

            DataObjectesAjax.pageReload(event.target);
        });
    },
    /*REORGANIZATE SERIALIZED FORM WITH REMOVING NOT NEEDED BLANK FIELDS + FORMATED DATES RANGE*/
    reorganizationSerialize: function (serialArray) {
        var formNewSerialize = [];

        /*FILTER REORGANIZATE + DATE INPUT FORMAT*/
        jQuery.grep(serialArray, function (n) {
            if ((n.name.match('DaysSingle') == null) && (n.name.match('DaysMultiFrom') == null) && (n.name.match('DaysMultiTill') == null)) {
                if (n.value !== '')
                    formNewSerialize.push(n.name + '=' + n.value)
            }
        });

        formNewSerialize = formNewSerialize.join('&');

        return formNewSerialize;
    },
    /*CLICKING ARROW SEND AJAX + CHANGE ARROW DIRECTION*/
    sortingReload: function () {
        var formSerialize = jQuery('#DatasetViewForm').serializeArray(),
            sortSerialize = ( (jQuery(".DatasetSort").data("sort") != undefined) ? '&order=' + jQuery(".DatasetSort").data("sort") : ''),
            innerSearch,
            filters;

        formSerialize = DataObjectesAjax.reorganizationSerialize(formSerialize);

        if ((innerSearch = jQuery('#innerSearch')).length) {
            innerSearch = jQuery('#innerSearch').val();
            if (innerSearch.length)
                innerSearch = '&q=' + innerSearch;
        }

        if (sortSerialize)
            formSerialize += '&' + sortSerialize;

        filters = formSerialize + innerSearch + '&search=web';

        while (filters.charAt(0) == '&') {
            filters = filters.substr(1);
        }

        History.pushState({
            filters: filters,
            reloadForm: 'sorting',
            page: "Dane"
        }, jQuery(document).find("title").html(), "?" + filters);
    },
    /*GATHER FILTER OPTION AND SEND RELOAD AJAX REQUEST*/
    objectsReload: function () {
        var formSerialize = jQuery('#DatasetViewForm').serializeArray(),
            innerSearch,
            filters;

        formSerialize = DataObjectesAjax.reorganizationSerialize(formSerialize);

        if ((innerSearch = jQuery('#innerSearch')).length) {
            innerSearch = jQuery('#innerSearch').val();
            if (innerSearch.length)
                innerSearch = '&q=' + innerSearch;
        }

        filters = formSerialize + innerSearch + '&search=web';

        while (filters.charAt(0) == '&') {
            filters = filters.substr(1);
        }

        History.pushState({
            filters: filters,
            reloadForm: 'object',
            page: "Dane",
            focusInput: $('.dataBrowser input[type="text"]:focus').attr('id')
        }, jQuery(document).find("title").html(), "?" + filters);
    },
    /*GATHER SORT AND FILTER OPTION AND SEND RELOAD AJAX REQUEST*/
    pageReload: function (target) {
        var paginationSerialize = jQuery(target).attr('href').split("?").pop(),
            innerSearch,
            filters;

        if ((innerSearch = jQuery('#innerSearch')).length) {
            innerSearch = jQuery('#innerSearch').val();
            if (innerSearch.length)
                innerSearch = '&q=' + innerSearch;
        }

        filters = paginationSerialize + innerSearch + '&search=web';

        while (filters.charAt(0) == '&') {
            filters = filters.substr(1);
        }

        History.pushState({
            filters: filters,
            reloadForm: 'page',
            page: "Dane"
        }, jQuery(document).find("title").html(), "?" + filters);
    },
    /*AJAX REQUEST AND RELOAD FILTER/RESULT CONTENT*/
    ajaxReload: function (formActualFilters, focusInput) {
        var main = jQuery('.dataBrowser'),
            filters = main.find('.dataFilters'),
            objects = main.find('.dataObjects'),
            formTarget = filters.find('form'),
            formAction = formTarget.attr('action').split("?").shift(),
            paramArray = formActualFilters.split('&'),
            redirectUrl = false,
            delay = 200;

        if (formAction.substr(formAction.length - 1) == '/') formAction = formAction.substring(0, formAction.length - 1);

        $.grep(paramArray, function (n) {
            if (n.match('dataset')) {
                var dataset = n.split('=');

                if (!redirectUrl) {
                    var fromActualFilterReplaced = formActualFilters.replace(/&?((dataset)|(dataset\[\])|(datachannel)|(search))=([^&]$|[^&]*)/gi, "");
                    while (fromActualFilterReplaced.charAt(0) == '&') {
                        fromActualFilterReplaced = fromActualFilterReplaced.substring(1);
                    }
                    redirectUrl = '/dane/' + dataset[1] + '?' + fromActualFilterReplaced;
                }
            }
        });

        if (redirectUrl)
            location.href = redirectUrl;

        if (typeof(paramArray) == 'object')
            paramArray = paramArray.join("&");

        DataObjectesAjax.ajaxRequest = jQuery.ajax({
            type: 'GET',
            url: formAction + '.json?' + paramArray,
            dataType: 'JSON',
            beforeSend: function () {
                if (DataObjectesAjax.ajaxRequest && DataObjectesAjax.ajaxRequest.readyState != 4) {
                    DataObjectesAjax.ajaxRequest.abort();
                }
                if (main.find('.spinner').length == 0) {
                    main.append(
                        jQuery('<div></div>').addClass('loadingBlock loadingTwirl').append(
                            jQuery('<div></div>').addClass('spinner').append(
                                jQuery('<div></div>').addClass('bounce1')
                            ).append(
                                jQuery('<div></div>').addClass('bounce2')
                            ).append(
                                jQuery('<div></div>').addClass('bounce3')
                            )
                        ).append(
                            jQuery('<p></p>').text("Ładowanie...")
                        )
                    );
                    objects.find('.innerContainer').children().animate({
                        opacity: 0.5
                    }, {duration: delay, queue: false});
                }
            },
            complete: function (status) {
                var modal,
                    data = status.responseJSON;

                if (DataObjectesAjax.ajaxRequest && (DataObjectesAjax.ajaxRequest.readyState == 4)) {
                    /*CLOSE ALL MODAL THINGS*/
                    if ((modal = jQuery('.modal')).is(':visible')) {
                        modal.modal('hide');
                        jQuery('.modal-backdrop').fadeOut(300, function () {
                            jQuery(this).remove();
                        });
                        jQuery('body').removeClass('modal-open');
                    }

                    /*REMOVE LOADING TWIRL*/
                    main.find('.loadingTwirl').remove();

                    /*RELOAD FILTERS CONTENT WITH DATA FROM AJAX*/
                    $('.update-filters').replaceWith(data.filters);
                    filtersController();

                    /*RELOAD HEADER CONTENT WITH DATA FROM AJAX*/
                    $('.update-header').html(data.header).end();
                    DataObjectesAjax.sorting();

                    /*CHANGE PAGINATION LIST*/
                    $('.update-pagination').html(data.pagination);

                    /*RELOAD OBJECT CONTENT WITH DATA FROM AJAX*/
                    objects.find('.innerContainer').children().animate({
                        opacity: 0
                    }, delay, function () {
                        if (data.objects == null) {
                            objects.find('.update-objects').html('<p class="noResults">' + mPHeart.translation.LC_DANE_BRAK_WYNIKOW + '</p>');
                        } else {
                            objects.find('.update-objects').html(data.objects);
                        }
                        objects.find('.innerContainer').children().css('opacity', 0).animate({
                            opacity: 1
                        }, {duration: delay});

                        /*RELOAD ASSIGNED FUNCTIONS*/
                        DataObjectesAjax.sniffForClick();
                        DataObjectesAjax.pageChange();
                        DataObjectesAjax.sniffForWordChange();
                        DataObjectesAjax.submitChanger();
                        DataObjectesAjax.datepickerForInputs();
                        DataObjectesAjax.removeHiddenInput();
                        DataObjectesAjax.buttonSearchWithoutPhrase();

                        DataObjectesAjax.sortingAddRemoveOptions();
                        DataObjectesAjax.specialCase();

                        if (focusInput !== undefined)
                            DataObjectesAjax.setCaretAtEnd(focusInput);
                    });

                    /*ANIMATE SCROLL TO TOP OF PAGE*/
                    jQuery('body, html').animate({
                        scrollTop: 0
                    }, 800);
                }
            }
        });
    },
    setCaretAtEnd: function (elemId) {
        var elem = document.getElementById(elemId),
            elemLen = elem.value.length;
        // For IE Only
        if (document.selection) {
            // Set focus
            elem.focus();
            // Use IE Ranges
            var oSel = document.selection.createRange();
            // Reset position to 0 & then set at end
            oSel.moveStart('character', -elemLen);
            oSel.moveStart('character', elemLen);
            oSel.moveEnd('character', 0);
            oSel.select();
        }
        else if (elem.selectionStart || elem.selectionStart == '0') {
            // Firefox/Chrome
            elem.selectionStart = elemLen;
            elem.selectionEnd = elemLen;
            elem.focus();
        } // if
    },
    /*IN SOME OF VIEW WE LOAD ADDITIONAL JS SO WE HAVE TO REINIT IT AFTER AJAX RELOAD RESULTS*/
    specialCase: function () {
        var objects = jQuery('.dataBrowser').find('.dataObjects');

        /*VIEW - sejm_glosowania*/
        if (objects.find('.highchart').length) {
            objects.find('.highchart').each(function () {
                if (jQuery(this).children().length == 0)
                    highchartInit();
            });
        }
    }
};

jQuery(function () {
    DataObjectesAjax.init();
});