/*global powiadomieniaModal*/

(function ($) {
    var dataContent = $('.dataContent'),
        keywords = $('.keywords'),
        newNotification = dataContent.find('.objects .powiadomienia'),
        checkTime = 3000,
        newNotificationIntervalMain,
        addNewPhrase,
        phraseContent,
        alertsButtons,
        tryNumbers = 4,
        appList = {};

    function _changeMarkStatus(newNotify, mode) {
        $.ajax({
            type: "GET",
            url: '/powiadomienia/flagObjects.json?action=' + mode + '&id=' + newNotify.attr('gid'),
            beforeSend: function () {
                newNotify.find('.alertsButtons > input').addClass('disabled');
            },
            success: function (data) {
                /*MARK SEEN ELEMENT AS READED TO NOT TRIGGER FUNCTION AGAIN AT SAME ELEMENT*/
                if (data.status == "OK") {
                    if (mode == 'read') {
                        newNotify.removeClass('unreaded').addClass('readed');
                        newNotify.find('.alertsButtons .unread').hide();
                        newNotify.find('.alertsButtons .read').show();
                    } else {
                        newNotify.removeClass('readed').addClass('unreaded');
                        newNotify.find('.alertsButtons .read').hide();
                        newNotify.find('.alertsButtons .unread').show();
                    }

                    $.each(data.groups_alerts_counts, function () {
                        var badge = $('.keywords').find('li[data-id="' + this.group_id + '"]').find('.badge');

                        (Number(this.alerts_unread_count) == 0) ? badge.removeClass('nonzero') : badge.addClass('nonzero');
                        badge.text(Number(this.alerts_unread_count));
                    })
                }
            },
            error: function () {
                var dataCount = (newNotify.data('count')) ? newNotify.data('count') + 1 : 1;
                newNotify.data('count', dataCount);
                if (newNotify.data('count') > tryNumbers)
                    newNotify.addClass('readed');
            },
            complete: function () {
                newNotify.find('.alertsButtons > input').removeClass('disabled');
            }
        });
    }


    function addAlertsButtonEvent(dom) {
        $.each(dom, function () {
            dom.find('.alertsButtons > input').unbind().click(function () {
                var btn = $(this),
                    parent = btn.parents('.objectRender');

                if (btn.hasClass('disabled')) return;

                if (btn.hasClass('read')) {
                    _changeMarkStatus(parent, 'unread');
                } else {
                    _changeMarkStatus(parent, 'read');
                }
            });
        })
    }

    function optionsMarkAsRead() {
        if (newNotification.find('.objectRender').length > 0 && $('.additionalOptions .markReadAfterThreeSec input').is(':checked')) {
            newNotificationIntervalMain = setInterval(function () {
                $.each(newNotification.find('.objectRender:not(.readed)'), function () {
                    if (isElementVisibled(this)) {
                        /*RUN FUNCTION AT SEEN EACH ELEMENTS*/
                        _changeMarkStatus($(this), 'read');
                    }
                });

                /*IS ALL ELEMENTS ARE READED - STOP FUNCTION*/
                if (newNotification.find('.objectRender:not(.readed)').length == 0)
                    clearInterval(newNotificationIntervalMain);
            }, checkTime);
        }
    }

    function optionsMarkAllAsRead(button) {
        var parm = (button.data('groupid') != "") ? "&group_id=" + button.data('groupid') : "";

        $.ajax({
            url: "/powiadomienia/flagObjects.json?action=read" + parm,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                /*MARK SEEN ELEMENT AS READED TO NOT TRIGGER FUNCTION AGAIN AT SAME ELEMENT*/
                if (data.status == "OK") {
                    $('.dataContent .objectRender').addClass('readed');
                    $.each(data.groups_alerts_counts, function () {
                        var badge = $('.keywords').find('li[data-id="' + this.group_id + '"]').find('.badge');

                        (Number(this.alerts_unread_count) == 0) ? badge.removeClass('nonzero') : badge.addClass('nonzero');
                        badge.text(Number(this.alerts_unread_count));
                    })
                }
            },
            error: function () {
                var dataCount = (button.data('count')) ? button.data('count') + 1 : 1;
                button.data('count', dataCount);
                if (button.data('count') > tryNumbers) {
                    newNotification.find('.objectRender:not(.readed)').addClass('readed');
                } else {
                    optionsMarkAllAsRead(button);
                }
            }
        });
    }

    function serializePowiadomieniaFind(serialize, purposeName) {
        return $.grep(serialize.group.apps, function (item) {
            return item.name == purposeName;
        });
    }

    function serializePowiadomienia() {
        var serialize = powiadomieniaModal.options.modal.find('form').serializeArray(),
            parm = {
                group: {
                    PowiadomieniaGroup: {
                        title: null
                    },
                    phrases: [],
                    apps: []
                }
            };

        /*GETHER APPS LIST WITH STATUS MARKER*/
        powiadomieniaModal.options.modal.find('form .datasets .datasetsContent > .switchCheckbox > .bootstrap-switch input').map(function () {
            var name = this.name.match(/\[(.*?)\]/);

            parm.group.apps.push({name: name[1], id: this.value, status: this.checked ? true : false, datasets: []})
        });

        $.each(serialize, function (index, data) {
            if (data.name == "title")
                parm.group.PowiadomieniaGroup.title = data.value.replace(/<\/?[^>]+>/gi, '');
            if (data.name == "data[Dataobject][ids]")
                parm.group.PowiadomieniaGroup.id = data.value;
            if (data.name == "keywords") {
                parm.group.phrases = data.value.split(',');
                $.each(parm.group.phrases, function (index, value) {
                    parm.group.phrases[index] = value.replace(/<\/?[^>]+>/gi, '')
                })
            }

            if (data.name.indexOf("subapps[") === 0) {
                var m = data.name.match(/\[(.*?)\]\[(.*?)\]/);

                var subapp = {
                    id: data.value,
                    name: m[2]
                };
                serializePowiadomieniaFind(parm, m[1])[0].datasets.push(subapp);
            }
        });

        return parm;
    }

    function serializePowiadomieniaSave(parm) {
        var appStatus = false;
        $.each(parm.group.apps, function (index, data) {
            if (data.status == true && data.datasets.length > 0) {
                appStatus = true;
                return false;
            }
        });

        if (!(parm.group.PowiadomieniaGroup.title != null && parm.group.PowiadomieniaGroup.title != "" && parm.group.PowiadomieniaGroup.title != _mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_TITLE_PLACEHOLDER))
            serializePowiadomieniaSaveAlert('title');
        else if (!(parm.group.phrases.length != 0 && !(parm.group.phrases.length == 1 && parm.group.phrases[0] == "")))
            serializePowiadomieniaSaveAlert('phrase');
        else if (!(appStatus))
            serializePowiadomieniaSaveAlert('apps');

        return (
        (
        parm.group.PowiadomieniaGroup.title != null
        && parm.group.PowiadomieniaGroup.title != ""
        && parm.group.PowiadomieniaGroup.title != _mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_TITLE_PLACEHOLDER
        ) && (
        parm.group.phrases.length != 0 && !(parm.group.phrases.length == 1 && parm.group.phrases[0] == "")
        ) &&
        appStatus
        )
    }

    function serializePowiadomieniaSaveAlert(status) {
        var modalAlert;

        if ((modalAlert = powiadomieniaModal.options.modal.find('.modal-alert')).length == 0) {
            modalAlert = $('<div></div>').addClass('modal-alert');
            modalAlert.insertAfter(powiadomieniaModal.options.modal.find('.modal-footer'));
        }
        switch (status) {
            case('title'):
                modalAlert.text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_ALERT_TITLE);
                break;
            case('phrase'):
                modalAlert.text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_ALERT_PHRASE);
                break;
            case('apps'):
                modalAlert.text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_ALERT_APPS);
                break;
            case('timeout'):
                modalAlert.text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_ALERT_ERROR_TIMEOUT);
                break;
            default:
                modalAlert.text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_ALERT_DEFAULT);
                break;
        }
    }

    function phrase() {
        if ((phraseContent = $('#powiadomienia').find('.frazy')).length > 0) {
            phraseContent.find('.keywords ul li a.options').click(function (e) {
                var that = $(this),
                    parent = that.parents('li'),
                    modalBottom = $('<div></div>');

                e.preventDefault();

                modalBottom.addClass('modal-footer').append(
                    $('<div></div>').addClass('btn-group pull-left show').append(
                        $('<button></button>').addClass('btn btn-default dropdown-toggle').attr({
                            'data-toggle': 'dropdown',
                            'type': 'button'
                        }).text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_WIECEJ).append(
                            $('<span></span>').addClass("caret")
                        )
                    ).append(
                        $('<ul></ul>').addClass('dropdown-menu').attr('role', 'menu')
                            /*.append(
                             $('<li></li>').append(
                             $('<a></a>').addClass('duplicate').attr('href', '#').text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_DUPLIKUJ)
                             )
                             ).append(
                             $('<li></li>').addClass('divider')
                             )*/.append(
                            $('<li></li>').append(
                                $('<a></a>').addClass('delete').attr('href', '#').text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_USUN)
                            )
                        )
                    )
                ).append(
                    $('<button></button>').addClass('btn save btn-primary pull-right').attr({'type': 'button'}).text(_mPHeart.translation.LC_POWIADOMIENIA_POWIADOMENIA_MODAL_ZAPISZ)
                );

                /*DELETE*/
                modalBottom.find('a.delete').click(function () {
                    if ($(this).hasClass('disabled')) return;

                    var parm = serializePowiadomienia();

                    $.ajax({
                        type: 'DELETE',
                        url: '/powiadomienia/groups/' + parm.group.PowiadomieniaGroup.id + '.json',
                        dataType: "json",
                        beforeSend: function () {
                            modalBottom.find('.btn', '.btn-group').addClass('disabled');
                            modalBottom.find('.btn.delete').addClass('loading');
                        },
                        complete: function () { /*TODO: zamienic na success gdy beda juz AJAX REQUEST gotowe*/
                            powiadomieniaModal.options.modal.modal('toggle');
                            parent.addClass('hide');
                        }
                    })
                });

                /*DUPLICATE*/
                modalBottom.find('a.duplicate').click(function () {
                    if ($(this).hasClass('disabled')) return;

                    var parm = serializePowiadomienia();

                    $.ajax({
                        type: 'GET',
                        url: '/',
                        data: {
                            id: parent.data('id'),
                            action: 'duplicate'
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                            modalBottom.find('.btn', '.btn-group').addClass('disabled');
                            modalBottom.find('.btn.duplicate').addClass('loading');
                        },
                        success: function (data) {
                            if (data.status) {
                                $.ajax({
                                    type: 'GET',
                                    url: '/powiadomienia/groups.json',
                                    dataType: "json",
                                    success: function (data) {
                                        keywords.find('> ul').html(data);
                                        phrase();
                                        powiadomieniaModal.options.modal.modal('toggle');
                                    }
                                });

                                var page = Number(loadMoreContent.data('currentpage')) + 1,
                                    groupId = (loadMoreContent.data('groupid') !== '') ? '&groupid=' + Number(loadMoreContent.data('groupid')) : '',
                                    mode = '&mode=' + Number(loadMoreContent.data('mode'));

                                loadMoreContentIntervalRunable = false;

                                $.ajax({
                                    type: "GET",
                                    url: "powiadomienia/powiadomienia.json?page=" + page + mode + groupId,
                                    beforeSend: function () {
                                        loadMoreContent.addClass('loading');
                                    },
                                    success: function (data) {
                                        loadMoreContent.removeClass('loading');
                                        if (data) {
                                            loadMoreContent.data('currentpage', page);
                                            showData.html(data);
                                            addAlertsButtonEvent(showData);
                                            loadMoreContentIntervalRunable = true;
                                        } else {
                                            clearInterval(loadMoreContentIntervalMain);
                                            if (showData.children().length == 0)
                                                showData.addClass('text-center').text(_mPHeart.translation.LC_POWIADOMIENIA_DANE_NO_KEYWORDS);
                                            loadMoreContent.remove();

                                        }
                                    },
                                    complete: function () {
                                        loadMoreContent.removeClass('loading');
                                    }
                                });
                            } else {
                                modalBottom.find('.btn').removeClass('disabled');
                                modalBottom.find('.btn.save').removeClass('loading');
                                /*ERROR - OTHER ERROR*/
                                serializePowiadomieniaSaveAlert();
                            }
                        },
                        error: function (x, t, m) {
                            if (t === "timeout") {
                                /*ERROR - TIMEOUT*/
                                serializePowiadomieniaSaveAlert('timeout');
                            } else {
                                /*ERROR - OTHER ERROR*/
                                serializePowiadomieniaSaveAlert();
                            }
                        }
                    })
                });

                /*SAVE*/
                modalBottom.find('.btn.save').click(function () {
                    if ($(this).hasClass('disabled')) return;

                    var parm = serializePowiadomienia();

                    if (serializePowiadomieniaSave(parm)) {
                        $.ajax({
                            type: 'POST',
                            url: '/powiadomienia/groups/' + parm.group.PowiadomieniaGroup.id + '.json',
                            data: parm,
                            dataType: "json",
                            beforeSend: function () {
                                modalBottom.find('.btn', '.btn-group').addClass('disabled');
                                modalBottom.find('.btn.save').addClass('loading');
                            },
                            success: function (data) {
                                if (data.status) {
                                    $.ajax({
                                        type: 'GET',
                                        url: '/powiadomienia/groups.json',
                                        dataType: "json",
                                        success: function (data) {
                                            keywords.find('> ul').html(data);
                                            phrase();
                                            powiadomieniaModal.options.modal.modal('toggle');
                                        }
                                    });

                                    var page = Number(loadMoreContent.data('currentpage')) + 1,
                                        groupId = (loadMoreContent.data('groupid') !== '') ? '&groupid=' + Number(loadMoreContent.data('groupid')) : '',
                                        mode = '&mode=' + Number(loadMoreContent.data('mode'));

                                    loadMoreContentIntervalRunable = false;

                                    $.ajax({
                                        type: "GET",
                                        url: "powiadomienia/powiadomienia.json?page=" + page + mode + groupId,
                                        beforeSend: function () {
                                            loadMoreContent.addClass('loading');
                                        },
                                        success: function (data) {
                                            loadMoreContent.removeClass('loading');
                                            if (data) {
                                                loadMoreContent.data('currentpage', page);
                                                showData.html(data);
                                                addAlertsButtonEvent(showData);
                                                loadMoreContentIntervalRunable = true;
                                            } else {
                                                clearInterval(loadMoreContentIntervalMain);
                                                if (showData.children().length == 0)
                                                    showData.addClass('text-center').text(_mPHeart.translation.LC_POWIADOMIENIA_DANE_NO_KEYWORDS);
                                                loadMoreContent.remove();

                                            }
                                        },
                                        complete: function () {
                                            loadMoreContent.removeClass('loading');
                                        }
                                    });
                                } else {
                                    modalBottom.find('.btn').removeClass('disabled');
                                    modalBottom.find('.btn.save').removeClass('loading');
                                    /*ERROR - OTHER ERROR*/
                                    serializePowiadomieniaSaveAlert();
                                }
                            },
                            error: function (x, t, m) {
                                if (t === "timeout") {
                                    /*ERROR - TIMEOUT*/
                                    serializePowiadomieniaSaveAlert('timeout');
                                } else {
                                    /*ERROR - OTHER ERROR*/
                                    serializePowiadomieniaSaveAlert();
                                }
                            }
                        })
                    } else {
                        /*ERROR - BRAK TITLE, KEYWORDS, APPS*/
                        serializePowiadomieniaSaveAlert('title');
                    }
                });
                powiadomieniaModal.init({
                    footer: modalBottom,
                    title: $.trim(parent.find('label a.wrap').text()),
                    hiddenInput: {
                        'data[Dataobject][ids]': parent.data('id')
                    },
                    additionalInfoList: appList,
                    ajax: {
                        saveUrl: '/',
                        saveParm: {id: parent.data('id')},
                        additionalUrl: '/powiadomienia/groups/' + parent.data('id') + '.json'
                    }
                })
            });
        }
    }

    if ($('.loadMoreContent').length) {
        var loadMoreContentIntervalRunable = true,
            loadMoreContent = $('.dataContent .loadMoreContent'),
            showData = $('.dataContent .powiadomienia'),
            loadMoreContentIntervalMain = null;

        loadMoreContentIntervalMain = setInterval(function () {
            if (isElementVisibled('.loadMoreContent') && loadMoreContentIntervalRunable) {
                var page = Number(loadMoreContent.data('currentpage')) + 1,
                    groupId = (loadMoreContent.data('groupid') !== '') ? '&groupid=' + Number(loadMoreContent.data('groupid')) : '',
                    mode = '&mode=' + Number(loadMoreContent.data('mode'));

                loadMoreContentIntervalRunable = false;

                $.ajax({
                    type: "GET",
                    url: "powiadomienia/powiadomienia.json?page=" + page + mode + groupId,
                    beforeSend: function () {
                        loadMoreContent.addClass('loading');
                    },
                    success: function (data) {
                        loadMoreContent.removeClass('loading');
                        if (data) {
                            loadMoreContent.data('currentpage', page);
                            showData.append(data);
                            addAlertsButtonEvent(showData);
                            loadMoreContentIntervalRunable = true;
                        } else {
                            clearInterval(loadMoreContentIntervalMain);
                            if (showData.children().length == 0)
                                showData.addClass('text-center').text(_mPHeart.translation.LC_POWIADOMIENIA_DANE_NO_KEYWORDS);
                            loadMoreContent.remove();

                        }
                    },
                    complete: function () {
                        loadMoreContent.removeClass('loading');
                    }
                });
            }

        }, 1500);
    }

    $.ajax({
        url: "/powiadomienia/apps.json",
        type: "GET",
        dataType: "JSON",
        beforeSend: function () {
            appList.status = 'pending';
        },
        success: function (data) {
            appList.list = data;
            appList.status = 'success';
        },
        error: function () {
            appList.status = 'error';
        }
    });

    if ((addNewPhrase = $('#powiadomienia').find('.addphrase')).length > 0) {
        addNewPhrase.click(function (e) {
            var modalBottom = $('<div></div>');

            e.preventDefault();

            modalBottom.addClass('modal-footer').append(
                $('<button></button>').addClass('btn save btn-primary pull-left').attr({'type': 'button'}).text('Zapisz')
            );

            powiadomieniaModal.init({
                footer: modalBottom,
                additionalInfoList: appList
            });

            modalBottom.find('.btn.save').click(function () {
                if ($(this).hasClass('disabled')) return;

                var parm = serializePowiadomienia();

                if (serializePowiadomieniaSave(parm)) {
                    $.ajax({
                        type: 'POST',
                        url: '/powiadomienia/groups.json',
                        data: serializePowiadomienia(),
                        dataType: "json",
                        beforeSend: function () {
                            modalBottom.find('.btn').addClass('disabled');
                            modalBottom.find('.btn.save').addClass('loading');
                        },
                        success: function (data) {
                            if (data.status) {
                                $.ajax({
                                    type: 'GET',
                                    url: '/powiadomienia/groups.json',
                                    dataType: "json",
                                    success: function (data) {
                                        keywords.find('> ul').html(data);
                                        phrase();
                                        powiadomieniaModal.options.modal.modal('toggle');
                                    }
                                })
                            } else {
                                modalBottom.find('.btn').removeClass('disabled');
                                modalBottom.find('.btn.save').removeClass('loading');
                                /*ERROR - OTHER ERROR*/
                                serializePowiadomieniaSaveAlert();
                            }
                        },
                        error: function (x, t, m) {
                            if (t === "timeout") {
                                /*ERROR - TIMEOUT*/
                                serializePowiadomieniaSaveAlert('timeout');
                            } else {
                                /*ERROR - OTHER ERROR*/
                                serializePowiadomieniaSaveAlert();
                            }
                        }
                    })

                }
            });
        });
    }

    $('.additionalOptions .markReadAfterThreeSec').change(function () {
        if ($(this).find('input').is(':checked')) {
            optionsMarkAsRead();
        } else {
            clearInterval(newNotificationIntervalMain);
        }
    });

    $('.additionalOptions .markAllAsRead').click(function () {
        optionsMarkAllAsRead($(this));
    });

    phrase();
    optionsMarkAsRead();
    addAlertsButtonEvent($('.showResults .objectRender'));
}(jQuery));