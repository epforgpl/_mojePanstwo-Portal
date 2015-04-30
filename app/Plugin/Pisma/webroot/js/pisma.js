/* global mPHeart */
var PISMA = Class.extend({
    preview: null,
    confirmExit: false,
    html: {
        stepper_div: $("#stepper")
    },
    methods: {
        stepper: null
    },
    objects: {
        szablony: null,
        adresaci: null,
        editor: null
    },
    cache: {
        szablony: {},
        adresaci: {},
        adresatInterval: null
    },
    keycode: {
        enter: 13,
        escape: 27,
        arrowUp: 38,
        arrowDown: 40
    },
    init: function () {
        if (this.html.stepper_div.hasClass('stepper')) {
            this.steps();
            this.stepsMarkers();
            this.checkStep();
            this.changeTitle();
            this.szablony();
            this.adresaci();
            this.editor();
            this.lastPageButtons();
            this.unsaveWarning();
        } else {
            this.stepsMarkers();
            this.changeTitle();
            this.adresaci();
            this.lastPageButtons();
        }
    },
    steps: function () {
        var self = this;

        self.methods.stepper = self.html.stepper_div.steps({
            step: 2,
            startIndex: 1,
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            enableAllSteps: true,
            enableKeyNavigation: false,
            enablePagination: false,
            suppressPaginationOnFocus: false,
            enableCancelButton: false,
            enableFinishButton: false,
            labels: {
                finish: "Zakończ",
                next: "Dalej",
                previous: "Cofnij",
                loading: "Ładowanie..."
            },
            onInit: function () {
                self.html.stepper_div.find('fieldset[class="final"] button').click(function (e) {
                    e.preventDefault();
                    self.scanEditor();
                    self.methods.stepper.steps("next");
                });
            },
            onStepChanged: function () {
                self.checkStep();
            }
        });
    },
    stepsMarkers: function () {
        this.html.szablony = this.html.stepper_div.find('.szablony');
        this.html.adresaci = this.html.stepper_div.find('.adresaci');
        this.html.editorTop = this.html.stepper_div.find('.editor-controls');
        this.html.editor = this.html.stepper_div.find('#editor');
    },
    checkStep: function () {
        var self = this;

        if (self.html.stepper_div.data('pismo') != undefined) {
            var preinit = self.html.stepper_div.data('pismo');

            if (preinit) {
                if (preinit.szablon_id)
                    self.szablonData(preinit.szablon_id);
                if (preinit.adresat_id)
                    self.adresatData(preinit.adresat_id);
                self.html.stepper_div.removeData('pismo');
            }
        }
        if (self.methods.stepper.data().state.currentIndex == 1) {
            self.editorDetail();
        }
    }
    ,
    changeTitle: function () {
        var self = this,
            pismoTitleBlock = $('.titleBlock '),
            pismoTitle = pismoTitleBlock.find('h1'),
            pismoTitleBtn = pismoTitle.find('.glyphicon'),
            pismoTitleEdit = pismoTitleBlock.find('.input-group');

        pismoTitle.data('title', $.trim(pismoTitle.text()));

        pismoTitleBtn.click(function (e) {
            e.preventDefault();

            if (pismoTitle.is(':visible')) {
                pismoTitle.hide();
                pismoTitleEdit.removeClass('hide').show();
            } else {
                pismoTitle.show();
                pismoTitleEdit.hide();
            }
        });

        pismoTitleEdit.find('.btn.save').click(function () {
            var newTitle = $.trim(pismoTitleEdit.find('input').val());
            $.ajax({
                url: '/pisma/' + pismoTitle.data('url') + '.json',
                method: 'PUT',
                data: {
                    name: newTitle
                },
                before: function () {
                    pismoTitleEdit.find('.btn').addClass('disable');
                },
                success: function () {
                    pismoTitleEdit.find('.btn').removeClass('disable');
                    pismoTitle.data('title', newTitle).find('a').text(newTitle);
                    pismoTitle.show();
                    pismoTitleEdit.hide();
                }
            })
        });

        pismoTitleEdit.find('.btn.cancel').click(function () {
            pismoTitle.find('a').text(pismoTitle.data('title'));
            pismoTitleEdit.find('input').val(pismoTitle.data('title'));
            pismoTitle.show();
            pismoTitleEdit.hide();
        });

        pismoTitleEdit.find('input').keydown(function (e) {
            if (e.keyCode == self.keycode.escape || e.which == self.keycode.escape) {
                pismoTitle.text(pismoTitle.data('title'));
            } else if (e.keyCode == self.keycode.enter || e.which == self.keycode.enter) {
                e.preventDefault();
                pismoTitleEdit.find('.btn.save').click();
            }
        })
    },

    szablonData: function (szablon_id) {
        var self = this;

        $.getJSON(mPHeart.constant.ajax.api + "/pisma/templates/" + szablon_id + ".json", function (d) {
            self.objects.szablony = {
                id: d.id,
                title: d.nazwa,
                content: d.tresc
            };
            self.objects.editor = {
                id: d.id,
                tytul: d.nazwa
            };
        });
    },
    szablony: function () {
        var self = this,
            confirmText = 'Zmiana szablonu spowoduje zastąpienie treści pisma nowym szablonem. Czy na pewno chcesz to zrobić?',
            confirmBtn = 'Zrozumiałem';

        self.html.szablony.find('input[type="radio"]').change(function () {
            if (self.objects.szablony.confirm != true) {
                if (self.objects.szablony && self.objects.szablony != $(this).val())
                    self.html.szablony.find('> label').popover({
                        html: true,
                        content: '<p>' + confirmText + '</p><p style="text-align:center; margin: 0"><button class="btn btn-sm btn-primary">' + confirmBtn + '</button></p>'
                    }).popover('show');
                self.objects.szablony.confirm = true;
                self.html.szablony.find('.popover .btn').click(function (e) {
                    e.preventDefault();
                    self.html.szablony.find('> label').popover('destroy');
                })
            }
        })
    }
    ,
    adresatData: function (adresat_id) {
        var self = this;

        $.getJSON(mPHeart.constant.ajax.api + "/dane/dataset/instytucje/search.json?conditions[id]=" + adresat_id + '&conditions[pisma]=1', function (d) {
            self.objects.adresaci = {
                id: d.search.dataobjects[0].id,
                title: d.search.dataobjects[0].data['instytucje.nazwa'],
                adres: d.search.dataobjects[0].data['instytucje.adres_str']
            };

            self.html.adresaci.find('#adresatSelect').val(self.objects.adresaci.title)
        });
    },
    adresaci: function () {
        var self = this;

        this.html.adresaci.keydown(function (event) {
            var charCode = event.which || event.keyCode;

            if (charCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        self.html.adresaci.find('#adresatSelect').on('keyup', function (e) {
            var adresatInput = $(this),
                charCode = e.which || e.keyCode,
                adresat = adresatInput.val();

            if (adresat.length > 0) {
                var adresaciList = self.html.adresaci.find('.adresaciList');

                if (charCode == self.keycode.enter) {
                    if (adresaciList.find('li.active').length)
                        self.adresaciListAccept(adresaciList.find('li.active'));
                    else {
                        self.html.adresaci.find('.list').hide();
                        adresatInput.val('');
                        adresatInput.blur();
                    }
                } else if (charCode == self.keycode.escape) {
                    if (adresaciList.is(':visible'))
                        self.html.adresaci.find('.list').hide();

                    adresatInput.val('');
                    adresatInput.blur();
                    return false;
                } else if (charCode == self.keycode.arrowUp) {
                    e.preventDefault();

                    if (adresaciList.is(':visible')) {
                        var previous = self.html.adresaci.find('.adresaciList li.active');

                        if (previous.prev().length) {
                            previous.prev().addClass('active');
                            previous.removeClass('active');
                        }
                    }
                } else if (charCode == self.keycode.arrowDown) {
                    e.preventDefault();

                    if (adresaciList.is(':visible')) {
                        var next = self.html.adresaci.find('.adresaciList li.active');

                        if (next.next().length) {
                            next.next().addClass('active');
                            next.removeClass('active');
                        }
                    }
                } else {
                    if (adresat in self.cache.adresaci) {
                        self.adresaciList(self.cache.adresaci[adresat]);
                    } else {
                        if (self.cache.adresatInterval)
                            clearTimeout(self.cache.adresatInterval);
                        self.cache.adresatInterval = setTimeout(function () {
                            $.getJSON(mPHeart.constant.ajax.api + "/dane/dataset/instytucje/search.json?conditions[q]=" + adresat, function (data) {
                                self.cache.adresaci[adresat] = data;
                                self.adresaciList(data);
                            });
                        }, 200);
                    }
                }
            } else {
                self.html.adresaci.find('.list').hide();
            }
        }).focusin(function () {
            $(this).val('');
            self.html.adresaci.find('.glyphicon.glyphicon-ok-circle').remove();
            self.html.adresaci.find('input[name="adresat_id"]').val('');
            self.html.szablony.find('.pisma-list-button').removeAttr('data-adresatid');
            self.adresaciReset(self);
        }).focusout(function () {
            setTimeout(function () {
                self.html.adresaci.find('.list').hide();
                if (self.html.adresaci.find('.glyphicon.glyphicon-ok-circle').length == 0) {
                    self.html.adresaci.find('#adresatSelect').val('');
                }
            }, 300);
        });

        if (self.objects.adresaci !== null && self.objects.adresaci.id) {
            $.getJSON(mPHeart.constant.ajax.api + "/dane/instytucje/" + self.objects.adresaci.id + ".json", function (d) {
                self.objects.adresaci = {
                    id: d.object.id,
                    title: d.object.data['instytucje.nazwa'],
                    adres: d.object.data['instytucje.adres']
                };

                self.html.adresaci.find('#adresatSelect').val(self.objects.adresaci.title).after($('<span></span>').addClass('glyphicon glyphicon-ok-circle'));
                self.html.adresaci.find('input[name="adresat_id"]').val('instytucje:' + self.objects.adresaci.id);
                self.html.szablony.find('.pisma-list-button').attr('data-adresatid', self.objects.adresaci.id);
            });
        }
    }
    ,
    adresaciList: function (data) {
        var self = this;

        self.html.adresaci.find('.glyphicon.glyphicon-ok-circle').remove();
        self.html.adresaci.find('input[name="adresat_id"]').val('');
        self.html.szablony.find('.pisma-list-button').removeAttr('data-adresatid');

        self.html.adresaci.find('.adresaciList').empty().append(
            $('<ul></ul>').addClass('ul-raw')
        ).show();

        if (data.search.dataobjects.length) {
            $.each(data.search.dataobjects, function () {
                var that = this;

                self.html.adresaci.find('.adresaciList .ul-raw').append(
                    $('<li></li>').addClass('row').data({
                        id: that.id,
                        title: that.data['instytucje.nazwa'],
                        adres: that.data['instytucje.adres_str']
                    }).mouseover(function () {
                        self.html.adresaci.find('.adresaciList .ul-raw li.active').removeClass('active');
                        $(this).addClass('active');
                    }).append(
                        $('<a></a>').attr('href', that._mpurl).text(that.data['instytucje.nazwa']).click(function (e) {
                            e.preventDefault();
                            self.adresaciListAccept($(this).parent('li'));
                        })
                    )
                );
            });
            self.html.adresaci.find('.adresaciList .ul-raw li:first').addClass('active');
        } else {
            self.html.adresaci.find('.adresaciList .ul-raw').append(
                $('<li></li>').addClass('row').append(
                    $('<p></p>').addClass('col-md-12').text('Brak wyników dla szukanej frazy')
                )
            )
        }
    }
    ,
    adresaciListAccept: function (that) {
        var self = this;

        self.adresaciReset(self);

        self.objects.adresaci = {
            id: that.data('id'),
            title: that.data('title'),
            adres: that.data('adres')
        };

        self.html.adresaci.find('#adresatSelect').val(self.objects.adresaci.title).after($('<span></span>').addClass('glyphicon glyphicon-ok-circle'));
        self.html.adresaci.find('input[name="adresat_id"]').val('instytucje:' + self.objects.adresaci.id);
        self.html.szablony.find('.pisma-list-button').attr('data-adresatid', self.objects.adresaci.id);

        self.html.adresaci.find('.adresaciList').hide();

        return false;
    }
    ,
    adresaciReset: function (self) {
        self.html.adresaci.find('.adresaciList .ul-raw .btn-default').removeClass('btn-default disabled').addClass('btn-success');
        self.objects.adresaci = null;
    }
    ,
    editor: function () {
        var self = this;

        $('textarea').autosize({
            append: false
        }).keyup(function () {
            var that = $(this);

            (that.val() == "") ? that.addClass('empty') : that.removeClass('empty');
        });

        self.html.editorTop.find('.control-addressee').click(function () {
            self.methods.stepper.steps("previous");
        }).end()
            .find('.control-template').click(function () {
                self.methods.stepper.steps("previous");
            });

        var months = ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'];
        var uDatepicker = $.datepicker._updateDatepicker;
        $.datepicker._updateDatepicker = function () {
            var ret = uDatepicker.apply(this, arguments);
            var $sel = this.dpDiv.find('select');
            $sel.find('option').each(function (i) {
                $(this).text(months[i]);
            });
            return ret;
        };
        $.datepicker.regional['pl'] = {
            closeText: 'Zamknij',
            prevText: '&#x3c;Poprzedni',
            nextText: 'Następny&#x3e;',
            currentText: 'Dzień',
            changeMonth: true,
            monthNames: months,
            monthNamesShort: ['Sty', 'Lu', 'Mar', 'Kw', 'Maj', 'Cze',
                'Lip', 'Sie', 'Wrz', 'Pa', 'Lis', 'Gru'],
            dayNames: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
            dayNamesShort: ['Nie', 'Pn', 'Wt', 'Śr', 'Czw', 'Pt', 'So'],
            dayNamesMin: ['N', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'],
            weekHeader: 'Tydz',
            dateFormat: 'd MM yy',
            altField: '#datepickerAlt',
            altFormat: "yy-mm-dd",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['pl']);

        var myDate = new Date();
        var prettyDate = myDate.getDate() + ' ' + $.datepicker.regional['pl'].monthNames[myDate.getMonth()] + ' ' + myDate.getFullYear();

        self.html.editorTop.find('.control-date .datepicker').val(prettyDate).datepicker();

        if (self.html.editor.length) {
            self.html.editor.wysihtml5({
                'events': {
                    'load': function () {
                        self.convertEditor();
                    }
                },
                toolbar: {
                    'image': false,
                    'emSmall': false
                },
                'html': true,
                'fa': true,
                'locale': 'pl-PL',
                parser: function (html) {
                    return html;
                }
            });

            self.html.stepper_div.find('.wysihtml5-toolbar').find('[data-wysihtml5-command="bold"]').html($('<span></span>').addClass('fa fa-bold'))
                .end()
                .find('[data-wysihtml5-command="italic"]').html($('<span></span>').addClass('fa fa-italic'))
                .end()
                .find('[data-wysihtml5-command="small"]').remove()
                .end()
                .find('[data-wysihtml5-command="underline"]').html($('<span></span>').addClass('fa fa-underline'))
                .end()
                .find('[data-wysihtml5-command="createLink"]').html($('<span></span>').addClass('glyphicon glyphicon-link'))
                /*
                 .end()
                 .prepend(
                 $('<li></li>').addClass('stepper-back').append(
                 $('<a></a>').addClass('btn  btn-default')
                 .attr({
                 'href': '#pismoBack',
                 'title': 'Zmień szablon lub adresata'
                 }).text('Zmień szablon lub adrestata').click(function (e) {
                 e.preventDefault();
                 self.methods.stepper.steps("previous")
                 })
                 ))
                 */;

            var wysightml5toolbar = self.html.stepper_div.find('.wysihtml5-toolbar').clone(true);
            self.html.stepper_div.find('.wysihtml5-toolbar').remove();
            $('.editPage .wysightml5Block').html(wysightml5toolbar.show());

        }
    }
    ,
    editorDetail: function () {
        var self = this,
            checkSzablon = self.html.szablony.find('.radio input:checked').val();

        if (self.objects.szablony != undefined && (checkSzablon != self.objects.szablony.id)) {
            self.html.editor.addClass('loading');
            self.szablonData(checkSzablon);

            $.getJSON(mPHeart.constant.ajax.api + "/pisma/templates/" + checkSzablon + ".json", function (data) {
                if (self.objects.editor !== null) {
                    if ($(self.objects.editor.text === self.html.editor.text()) || (self.html.editor.text() == '')) {
                        self.html.editor.empty().html(data.tresc);
                    }
                } else {
                    self.html.editor.empty().html(data.tresc);
                }
                self.convertEditor();
                self.html.editorTop.find('.control-template').text(data.nazwa);

                self.html.editor.removeClass('loading');
            });
        }
    }
    ,
    convertEditor: function () {
        var self = this,
            editor = self.html.editor;

        editor.find('.editable').each(function () {
            var that = $(this);

            if (that.hasClass('date')) {
                that.append(
                    $('<input>').addClass('datepicker').datepicker()
                );
            } else if (that.hasClass('daterange')) {
                that.append(
                    $('<label></label>').attr('for', 'from').text('od dnia ')
                ).append(
                    $('<input>').addClass('datepicker from').attr('name', 'from')
                        .datepicker({
                            onClose: function (selectedDate) {
                                that.find('.datepicker.to').datepicker("option", "minDate", selectedDate);
                            }
                        })
                ).append(
                    $('<label></label>').attr('for', 'to').text(' do dnia ')
                ).append(
                    $('<input>').addClass('datepicker to').attr('name', 'to')
                        .datepicker({
                            onClose: function (selectedDate) {
                                that.find('.datepicker.from').datepicker("option", "maxDate", selectedDate);
                            }
                        })
                );
            } else if (that.hasClass('email')) {
                that.addClass('mirrorable').append(
                    $('<input>').addClass('emailEnter').attr({
                        type: "email",
                        placeholder: "(podaj adres email)"
                    })
                )
            } else if (that.hasClass('currencypln')) {
                var rand = '',
                    randLength = 32,
                    randChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                for (var i = randLength; i > 0; --i) rand += randChars[Math.round(Math.random() * (randChars.length - 1))];

                that.addClass('mirrorable').attr('data-unique', rand).append(
                    $('<input>').addClass('kwota').attr('title', that.attr('title'))
                ).after(
                    $('<span></span>').addClass('slownie').attr('data-unique', rand)
                );
                that.removeAttr('title');
                that.find('input.kwota').keyup(function () {
                    var liczba = parseFloat($(this).val()),
                        jednosci = ["", " jeden", " dwa", " trzy", " cztery", " pięć", " sześć", " siedem", " osiem", " dziewięć"],
                        nascie = ["", " jedenaście", " dwanaście", " trzynaście", " czternaście", " piętnaście", " szesnaście", " siedemnaście", " osiemnaście", " dziewietnaście"],
                        dziesiatki = ["", " dziesięć", " dwadzieścia", " trzydzieści", " czterdzieści", " pięćdziesiąt", " sześćdziesiąt", " siedemdziesiąt", " osiemdziesiąt", " dziewięćdziesiąt"],
                        setki = ["", " sto", " dwieście", " trzysta", " czterysta", " pięćset", " sześćset", " siedemset", " osiemset", " dziewięćset"],
                        grupy = [
                            ["", "", ""],
                            [" tysiąc", " tysiące", " tysięcy"],
                            [" milion", " miliony", " milionów"],
                            [" miliard", " miliardy", " miliardów"],
                            [" bilion", " biliony", " bilionów"],
                            [" biliard", " biliardy", " biliardów"],
                            [" trylion", " tryliony", " tryliardów"]],
                        wynik = '',
                        znak = '';

                    if (liczba == 0)
                        wynik = "zero";
                    if (liczba < 0) {
                        znak = "minus";
                    }

                    var g = 0;
                    while (liczba > 0) {
                        var s = Math.floor((liczba % 1000) / 100);
                        var n = 0;
                        var d = Math.floor((liczba % 100) / 10);
                        var j = Math.floor(liczba % 10);
                        if (d == 1 && j > 0) {
                            n = j;
                            d = 0;
                            j = 0;
                        }

                        var k = 2;
                        if (j == 1 && s + d + n == 0)
                            k = 0;
                        if (j == 2 || j == 3 || j == 4)
                            k = 1;
                        if (s + d + n + j > 0)
                            wynik = setki[s] + dziesiatki[d] + nascie[n] + jednosci[j] + grupy[g][k] + wynik;

                        g++;
                        liczba = Math.floor(liczba / 1000);
                    }

                    self.html.editor.find('.slownie[data-unique="' + $(this).parent().data('unique') + '"]')
                        .html('&nbsp;PLN <span class="_slownie">(słownie: ' + znak + wynik + ' polskich złotych)</span>');
                });
            } else {
                if (that.attr('class').split(" ").length == 1)
                    that.html('<br type="_editor">');
            }

            if (that.hasClass('mirrorable')) {
                that.prepend($('<div></div>').addClass('mirror').css({
                    'visibility': 'hidden',
                    'position': 'absolute'
                }));
                self.convertEditorInputWidth(that);
            }

            if (that.attr('title'))
                that.tooltip({
                    delay: 0
                });

            self.cursorPosition();
        });
    }
    ,
    scanEditor: function () {
        var self = this,
            editorTop = this.html.editorTop,
            editor = this.html.editor;

        if (self.objects.szablony !== null && self.objects.szablony.id) {
            editorTop.find('.control-template').html(self.objects.szablony.title);
            editor.html(self.objects.szablony.content)
        } else {
            editorTop.find('.control-template').html('');
            editor.html('');
        }

        if (self.objects.adresaci !== null && self.objects.adresaci.id) {
            editorTop.find('.control-addressee').html('').append(
                $('<p></p>').html(self.objects.adresaci.title)
            ).append(
                $('<p></p>').html(self.objects.adresaci.adres)
            )
        } else {
            editorTop.find('.control-addressee').html('');
        }

        if (editor.text().trim() != '') {
            editor.find('.editable').each(function () {
                var that = $(this);

                if (that.hasClass('copyaddresee')) {
                    if (self.objects.adresaci)
                        that.html(self.objects.adresaci.title);
                    else
                        that.html('<br type="_editor">');
                }
            });
            self.cursorPosition();
        }
    }
    ,
    convertEditorInputWidth: function (that) {
        var mirror = that.find('.mirror'),
            input = that.find('input'),
            safePadding = 8;

        mirror.html((input.val() == '') ? input.attr('placeholder') : input.val());
        input.css('width', (mirror.outerWidth() < input.css('min-width')) ? input.css('min-width') : mirror.outerWidth() + safePadding);

        input.keydown(function () {
            mirror.html((input.val() == '') ? input.attr('placeholder') : input.val());
            input.attr('value', (input.val() == '') ? '' : input.val());
            input.css('width', (mirror.outerWidth() < input.css('min-width')) ? input.css('min-width') : mirror.outerWidth() + safePadding);
        });
    }
    ,
    cursorPosition: function () {
        var self = $(this),
            elEd = document.getElementById('editor');

        if (window.getSelection && elEd.getElementsByClassName('cursorhere').length) {
            var sel = window.getSelection(),
                elCr = elEd.getElementsByClassName('cursorhere')[0].parentNode,
                range = document.createRange();

            range.setStart(elCr, 1);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);

            $(elCr).find('span.cursorhere').remove();

            if ($(elCr).html() == '')
                $(elCr).html('<br>');
        }

        if (self.objects !== undefined && self.objects.editor !== null)
            self.objects.editor.text = editor.text();

        elEd.focus();
    }
    ,
    generateFormInsert: function () {
        var self = this,
            preview = $('<div></div>').addClass('hide').append(
                /*$('<input />').attr({'name': 'miejscowosc', 'maxlength': "127"})
                 ).append(*/
                $('<input />').attr({'name': 'data_pisma', 'maxlength': "10"})
            ).append(
                $('<input />').attr({'name': 'adresat_id'})
            ).append(
                $('<input />').attr({'name': 'adresat', 'maxlength': "511"})
            ).append(
                $('<input />').attr({'name': 'szablon_id'})
            ).append(
                $('<input />').attr({'name': 'tytul', 'maxlength': "511"})
            ).append(
                $('<input />').attr({'name': 'nazwa', 'value': "Nowe pismo"})
            ).append($('<div></div>').addClass('content'));

        self.html.stepper_div.find('#editor-cont').clone().appendTo(preview.find('.content'));

        preview.find('.wysihtml5-toolbar').remove()
            .end()
            .find('.control span.empty').remove()
            .end()
            .find('.control .empty').removeClass('empty')
            .end()
            .find('#editor').attr('contenteditable', false);

        if (preview.find('.control.control-date input.city').val() == '')
            preview.find('.control.control-date input.city').val(' ');

        self.html.stepper_div.find('.edit .col-md-10').find("textarea:not('.hide')").each(function (idx) {
            $(preview.find("textarea").eq(idx)).replaceWith('<div class="pre">' + $(this).val().replace(/\n/g, '<br/>') + '</div>');
        });

        preview.append(
            $('<textarea></textarea>').attr({name: 'tresc_html'}).val($.trim(preview.find('#editor').html()))
        );

        preview
            .find('br[type="_editor"]').remove()
            .end()
            .find('.mirror').remove()
            .end()
            .find('.editable').each(function () {
                var that = $(this);

                if (that.hasClass('date')) {
                    that.replaceWith(that.find('input.datepicker').val());
                } else if (that.hasClass('daterange')) {
                    that.replaceWith(that.find('label[for="from"]').html() + that.find('input[name="from"]').val() + that.find('label[for="to"]').html() + that.find('input[name="to"]').val())
                } else if (that.hasClass('email')) {
                    that.replaceWith(that.find('input[type="email"]').val());
                } else if (that.hasClass('currencypln')) {
                    var slownie = self.html.editor.find('.slownie[data-unique="' + that.data('unique') + '"]');

                    that.replaceWith(that.find('input.kwota').val());
                    slownie.replaceWith(slownie.html());
                } else {
                    that.replaceWith(that.html())
                }
            })
            .end()
            .find('input[name="nazwa"]').val($.trim($('.titleBlock h1').text()))
            .end()
            .find('input[name="data_pisma"]').val($.trim(preview.find('.control.control-date input#datepickerAlt').val()))
            .end()
            .find('input[name="miejscowosc"]').val($.trim(preview.find('.control.control-date input.city').val()))
            .end()
            .find('input[name="adresat_id"]').val((self.objects.adresaci) ? 'instytucje:' + self.objects.adresaci.id : '')
            .end()
            .find('input[name="adresat"]').val($.trim(preview.find('.control.control-addressee').html()))
            .end()
            .find('input[name="szablon_id"]').val((self.objects.szablony) ? self.objects.szablony.id : '')
            .end()
            .find('input[name="tytul"]').val($.trim(preview.find('.control.control-template').text()));

        preview.append(
            $('<textarea></textarea>').attr({name: 'tresc'}).val($.trim(preview.find('#editor').html()))
        ).append(
            $('<textarea></textarea>').attr({name: 'nadawca'}).val(self.html.stepper_div.find('.edit .col-md-10 .control.control-sender textarea.nadawca').val())
        ).append(
            $('<textarea></textarea>').attr({name: 'podpis'}).val(self.html.stepper_div.find('.edit .col-md-10 .control.control-signature textarea.podpis').val())
        );

        self.html.stepper_div.find('form.form-save').append(preview);
        self.html.stepper_div.find('form.form-save').submit();
    }
    ,
    lastPageButtons: function () {
        var self = this,
            modal = {};

        self.html.stepper_div.find('.editor-tooltip .sendPismo').click(function (e) {
            e.preventDefault();
            $('#sendPismoModal').modal('show');
        });

        if ((modal.sendPismo = $('#sendPismoModal')).length) {
            modal.sendPismo.find('.btn[type="submit"]').click(function () {
                if ($(this).hasClass('disabled'))
                    return false;
                $(this).addClass('disabled loading');
            });
        }

        self.html.stepper_div.find('.form-save .savePismo').click(function (e) {
            e.preventDefault();

            $(this).parent('form').find('input[name="_save"]').attr('name', 'save');
            self.generateFormInsert();
        });
    }
    ,
    unsaveWarning: function () {
        var self = this,
            btnActions = self.html.stepper_div.find('.editor-tooltip'),
            statusCheck = self.html.stepper_div.data('status-check');

        if (statusCheck != undefined) {
            self.confirmExit = true;

            btnActions.find('.btn.savePismo, a[name="cancel"], input[name="delete"]').click(function () {
                self.confirmExit = false;
            });
            $('.form-save .savePismo').click(function () {
                self.confirmExit = false;
            });

            $(window).bind('beforeunload', function () {
                if (self.confirmExit) {
                    if (statusCheck == 0)
                        return 'Pismo nie zostało jeszcze zapisane. Czy na pewno nie chcesz go zapisać?';
                    else if (statusCheck == 1)
                        return 'Czy chcesz opuścić tę stronę bez zapisywania zmian?';
                }
            });
        }
    }
});

var $P;
$(document).ready(function () {
    $P = new PISMA();

    $P.html.stepper_div.find('.more-buttons-switcher').click(function (event) {
        event.preventDefault();

        var switcher = $(event.target).parent('.more-buttons-switcher'),
            target_element = $P.html.stepper_div.find('.more-buttons-target'),
            mode = switcher.data('mode');

        if (mode == 'more') {
            switcher.attr('href', '#less').data('mode', 'less').find('.text').text('Mniej');
            switcher.find('.glyphicon').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            target_element.slideDown();
        } else if (mode == 'less') {
            target_element.slideUp();
            switcher.attr('href', '#more').data('mode', 'more').find('.text').text('Więcej');
            switcher.find('.glyphicon').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }
    });

    var client = new ZeroClipboard(document.getElementById("clipboardCopy"));

    client.on("ready", function (readyEvent) {
        client.on("aftercopy", function (event) {
            alert("Skopiowano do schowka: " + event.data["text/plain"]);
        });
    });
});