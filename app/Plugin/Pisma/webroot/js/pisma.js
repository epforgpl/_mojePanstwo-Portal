var PISMA = Class.extend({
    html: {
        stepper_div: $("#stepper")
    },
    methods: {
        stepper: null
    },
    objects: {
        starter: null,
        szablon: null,
        adresaci: null,
        editor: null
    },
    cache: {
        adresaci: {}
    },
    init: function () {
        if (this.html.stepper_div.length) {
            this.steps();
            this.stepsMarkers();

            this.checkStep();

            this.szablon();
            this.adresaci();
            this.editor();

            this.lastPageButtons();
        }
    },
    stepsMarkers: function () {
        this.html.szablony = this.html.stepper_div.find('.szablony');
        this.html.adresaci = this.html.stepper_div.find('.adresaci');
        this.html.editorTop = this.html.stepper_div.find('.editor-controls');
        this.html.editor = this.html.stepper_div.find('#editor');
        this.html.finalForm = this.html.stepper_div.find('#finalForm');
        this.objects.starter = this.html.stepper_div.data('pismo');
    },
    steps: function () {
        var self = this;

        self.methods.stepper = self.html.stepper_div.steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            enableAllSteps: true,
            enableKeyNavigation: false,
            enablePagination: true,
            suppressPaginationOnFocus: false,
            enableCancelButton: false,
            enableFinishButton: false,
            saveState: true,
            labels: {
                finish: "Zakończ",
                next: "Dalej",
                previous: "Cofnij",
                loading: "Ładowanie..."
            },
            onInit: function () {
                var activeMenu = $('#shortcuts li.active'),
                    activeMenuPos = Math.floor(activeMenu.offset().left),
                    activeMenuWidth = activeMenu.outerWidth();

                self.html.stepper_div.find('ul[role="tablist"]').addClass('container');
                self.html.stepper_div.find('ul.container > li').each(function () {
                    var that = $(this);

                    that.append(
                        $('<div></div>').addClass('arrow')
                    );

                    if (activeMenu) {
                        var liPos = Math.floor(that.offset().left);
                        that.find('.arrow').css('left', activeMenuPos - liPos + (activeMenuWidth / 2));
                    }

                })
            },
            onStepChanged: function () {
                self.checkStep();
            }
        });
    },
    checkStep: function () {
        if (this.methods.stepper.data().state.currentIndex == 2) {
            this.editorDetail();
        } else if (this.methods.stepper.data().state.currentIndex == 3) {
            this.lastPage();
        }
    },
    szablon: function () {
        var self = this;

        self.html.szablony.find('#chosen-template .btn-danger').click(function () {
            self.html.szablony.find('#chosen-template').slideUp(function () {
                self.szablonReset(self);
            });
        });
        self.html.szablony.find('.list .ul-raw li .title a').click(function (e) {
            var parent = $(this).parents('li');
            e.preventDefault();

            parent.find('.desc').stop(true, false).slideToggle();

        });
        self.html.szablony.find('.list .ul-raw li .btn').click(function () {
            var that = $(this),
                slice = that.parents('li');

            if (that.hasClass('btn-success')) {
                self.szablonReset(self);

                that.removeClass('btn-success').addClass('btn-default disabled');
                self.objects.szablon = {
                    id: slice.data('id'),
                    title: slice.data('title')
                };
                self.html.editorTop.find('.control-template').text(self.objects.szablon.title);

                self.html.szablony.find('#chosen-template ul').empty().append(
                    $('<li></li>').addClass('row').append(
                        $('<div></div>').append(
                            $('<p></p>').text(self.objects.szablon.title)
                        )
                    )
                );

                if (self.html.szablony.find('#chosen-template').is(':hidden'))
                    self.html.szablony.find('#chosen-template').slideDown();

                self.editorDetail();

                self.methods.stepper.steps("next");
            }
        });
        if (self.objects.starter.szablon_id) {
            var choosen = self.html.szablony.find('.list .ul-raw li[data-id="' + self.objects.starter.szablon_id + '"]');

            choosen.find('.btn').removeClass('btn-success').addClass('btn-default disabled');
            self.objects.szablon = {
                id: choosen.data('id'),
                title: choosen.data('title')
            };
            self.html.editorTop.find('.control-template').text(self.objects.szablon.title);

            self.html.szablony.find('#chosen-template ul').empty().append(
                $('<li></li>').addClass('row').append(
                    $('<div></div>').append(
                        $('<p></p>').text(self.objects.szablon.title)
                    )
                )
            );

            if (self.html.szablony.find('#chosen-template').is(':hidden'))
                self.html.szablony.find('#chosen-template').slideDown();

            self.editorDetail();
        }
    },
    szablonReset: function (self) {
        self.html.szablony.find('.list .ul-raw .btn-default').removeClass('btn-default disabled').addClass('btn-success');
        self.objects.szablon = null;
    },
    adresaci: function () {
        var self = this;

        self.html.adresaci.find('#chosen-addressee .btn-danger').click(function () {
            self.html.adresaci.find('#chosen-addressee').slideUp(function () {
                self.adresaciReset(self);
            });
        });
        self.html.adresaci.find('.search').on('keyup', function () {
            var adresat = $(this).val();

            if (adresat.length > 0) {
                if (adresat in self.cache.adresaci) {
                    self.adresaciList(self.cache.adresaci[adresat]);
                } else {
                    $.getJSON("http://api.mojepanstwo.pl/dane/dataset/instytucje/search.json?conditions[q]=" + adresat, function (data) {
                        self.cache.adresaci[adresat] = data;
                        self.adresaciList(data);
                    });
                }
            } else {
                self.html.adresaci.find('.list').hide();
            }
        });

        if (self.objects.starter.adresat_id) {
            $.getJSON("http://api.mojepanstwo.pl/dane/instytucje/" + self.objects.starter.adresat_id + ".json", function (d) {
                self.objects.adresaci = {
                    id: d.object.id,
                    title: d.object.data['instytucje.nazwa'],
                    adres: d.object.data['instytucje.adres']
                };

                self.html.editorTop.find('.control-addressee').empty().append(
                    $('<p></p>').text(self.objects.adresaci.title)
                ).append(
                    $('<p></p>').text(self.objects.adresaci.adres)
                );

                self.html.adresaci.find('#chosen-addressee ul').empty().append(
                    $('<li></li>').addClass('row').append(
                        $('<div></div>').append(
                            $('<p></p>').text(self.objects.adresaci.title)
                        )
                    )
                );

                if (self.html.adresaci.find('#chosen-addressee').is(':hidden'))
                    self.html.adresaci.find('#chosen-addressee').slideDown();

            });
        }
    },
    adresaciList: function (data) {
        var self = this;

        self.html.adresaci.find('.list').empty().append(
            $('<ul></ul>').addClass('ul-raw')
        ).show();

        if (data.search.dataobjects.length) {
            $.each(data.search.dataobjects, function () {
                var that = this;

                self.html.adresaci.find('.list .ul-raw').append(
                    $('<li></li>').addClass('row').data({
                        id: that.id,
                        title: that.data['instytucje.nazwa'],
                        adres: that.data['instytucje.adres_str']
                    }).append(
                        $('<div></div>').addClass('pull-left col-md-11').append(
                            $('<p>').append(
                                $('<a></a>').attr('href', that._mpurl).text(that.data['instytucje.nazwa'])
                            )
                        )
                    ).append(
                        $('<div></div>').addClass('pull-right col-md-1').append(
                            $('<button></button>').addClass('btn btn-success btn-xs').text('Wybierz').click(function () {
                                var that = $(this),
                                    slice = that.parents('li');

                                if (that.hasClass('btn-success')) {
                                    self.adresaciReset(self);

                                    that.removeClass('btn-success').addClass('btn-default disabled');
                                    self.objects.adresaci = {
                                        id: slice.data('id'),
                                        title: slice.data('title'),
                                        adres: slice.data('adres')
                                    };
                                    self.html.editorTop.find('.control-addressee').empty().append(
                                        $('<p></p>').text(self.objects.adresaci.title)
                                    ).append(
                                        $('<p></p>').text(self.objects.adresaci.adres)
                                    );

                                    self.html.adresaci.find('#chosen-addressee ul').empty().append(
                                        $('<li></li>').addClass('row').append(
                                            $('<div></div>').append(
                                                $('<p></p>').text(self.objects.adresaci.title)
                                            )
                                        )
                                    );

                                    if (self.html.adresaci.find('#chosen-addressee').is(':hidden'))
                                        self.html.adresaci.find('#chosen-addressee').slideDown();
                                }

                                self.scanEditor();
                                self.methods.stepper.steps("next");
                                self.html.adresaci.find('.search').val('').end().find('.list').hide();
                            })
                        )
                    )
                );
            });
        } else {
            self.html.adresaci.find('.list .ul-raw').append(
                $('<li></li>').addClass('row').append(
                    $('<p></p>').addClass('col-md-12').text('Brak wyników dla szukanej frazy')
                )
            )
        }
    },
    adresaciReset: function (self) {
        self.html.adresaci.find('.list .ul-raw .btn-default').removeClass('btn-default disabled').addClass('btn-success');
        self.objects.adresaci = null;
    },
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
            monthNames: ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca',
                'lipca', 'sierpnia', 'wrzesienia', 'października', 'listopada', 'grudnia'],
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
                toolbar: {
                    "image": false,
                    "emSmall": false
                },
                "fa": true,
                locale: 'pl-PL'
            });
            self.html.editor.removeClass('loading');
            self.html.stepper_div.find('.wysihtml5-toolbar').find('[data-wysihtml5-command="bold"]').html($('<span></span>').addClass('fa fa-bold'))
                .end()
                .find('[data-wysihtml5-command="italic"]').html($('<span></span>').addClass('fa fa-italic'))
                .end()
                .find('[data-wysihtml5-command="small"]').remove()
                .end()
                .find('[data-wysihtml5-command="underline"]').html($('<span></span>').addClass('fa fa-underline'))
                .end()
                .find('[data-wysihtml5-command="createLink"]').html($('<span></span>').addClass('glyphicon glyphicon-link'));
        }
    },
    editorDetail: function () {
        var self = this;

        if (self.objects.szablon != null && (self.objects.editor == null || (self.objects.editor.id != self.objects.szablon.id))) {
            self.html.editor.addClass('loading');
            $.getJSON("/pisma/szablony/" + self.objects.szablon.id + ".json", function (data) {
                if (self.objects.editor !== null) {
                    if ($(self.objects.editor.text === self.html.editor.text()) || (self.html.editor.text() == '')) {
                        self.html.editor.empty().html(data.tresc);
                    }
                } else {
                    self.html.editor.empty().html(data.tresc);
                }
                self.objects.editor = {
                    id: data.id,
                    tytul: data.nazwa
                };
                self.html.editorTop.find('.control-template').text(data.nazwa);
                self.convertEditor();
            });
        }
    },
    convertEditor: function () {
        var self = this,
            editor = this.html.editor;

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
                    var liczba = parseFloat($(this).val());

                    var jednosci = ["", " jeden", " dwa", " trzy", " cztery", " pięć", " sześć", " siedem", " osiem", " dziewięć"];
                    var nascie = ["", " jedenaście", " dwanaście", " trzynaście", " czternaście", " piętnaście", " szesnaście", " siedemnaście", " osiemnaście", " dziewietnaście"];
                    var dziesiatki = ["", " dziesięć", " dwadzieścia", " trzydzieści", " czterdzieści", " pięćdziesiąt", " sześćdziesiąt", " siedemdziesiąt", " osiemdziesiąt", " dziewięćdziesiąt"];
                    var setki = ["", " sto", " dwieście", " trzysta", " czterysta", " pięćset", " sześćset", " siedemset", " osiemset", " dziewięćset"];
                    var grupy = [
                        ["", "", ""],
                        [" tysiąc", " tysiące", " tysięcy"],
                        [" milion", " miliony", " milionów"],
                        [" miliard", " miliardy", " miliardów"],
                        [" bilion", " biliony", " bilionów"],
                        [" biliard", " biliardy", " biliardów"],
                        [" trylion", " tryliony", " tryliardów"]];

                    var wynik = '';
                    var znak = '';
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
                that.prepend($('<div></div>').addClass('mirror').css({'visibility': 'hidden', 'position': 'absolute'}));
                self.convertEditorInputWidth(that);
            }

            self.scanEditor();

            if (that.attr('title'))
                that.tooltip();
        });
    },
    scanEditor: function () {
        var self = this,
            editor = this.html.editor;

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

            editor.removeClass('loading');
            self.cursorPosition();
        }
    },
    convertEditorInputWidth: function (that) {
        var mirror = that.find('.mirror'),
            input = that.find('input');

        mirror.html((input.val() == '') ? input.attr('placeholder') : input.val());
        input.css('width', (mirror.outerWidth() < input.css('min-width')) ? input.css('min-width') : mirror.outerWidth());

        input.keydown(function () {
            mirror.html((input.val() == '') ? input.attr('placeholder') : input.val());
            input.attr('value', (input.val() == '') ? '' : input.val());
            input.css('width', (mirror.outerWidth() < input.css('min-width')) ? input.css('min-width') : mirror.outerWidth());
        });
    },
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
    },
    lastPage: function () {
        var self = this,
            prev = self.html.stepper_div.find('.edit .col-md-10').clone();

        /*CLEAN UP*/
        prev.find('.wysihtml5-toolbar').remove()
            .end()
            .find('.control span.empty').remove()
            .end()
            .find('.control .empty').removeClass('empty')
            .end()
            .find('.control input, .control textarea').attr('disabled', 'disabled')
            .end()
            .find('#editor').attr('contenteditable', false);

        self.html.stepper_div.find('.preview .previewRender .col-md-10').remove();
        self.html.stepper_div.find('.preview .previewRender').prepend(prev);

        /*COPY TEXTAREA VALUE*/
        if (prev.find('.control.control-date input.city').val() == '')
            prev.find('.control.control-date input.city').val(' ');

        self.html.stepper_div.find('.edit .col-md-10').find("textarea:not('.hide')").each(function (idx) {
            $(self.html.stepper_div.find('.preview .previewRender').find("textarea").eq(idx)).replaceWith('<div class="pre">' + $(this).val().replace(/\n/g, '<br/>') + '</div>');
        });

        self.html.finalForm
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
                    var slownie = self.html.finalForm.find('.slownie[data-unique="' + that.data('unique') + '"]');

                    that.replaceWith(that.find('input.kwota').val());
                    slownie.replaceWith(slownie.html());
                } else {
                    that.replaceWith(that.html())
                }
            })
            .end()
            .find('input[name="data_pisma"]').val(prev.find('.control.control-date input#datepickerAlt').val())
            .end()
            .find('input[name="miejscowosc"]').val(prev.find('.control.control-date input.city').val())
            .end()
            .find('textarea[name="nadawca"]').val(self.html.stepper_div.find('.edit .col-md-10 .control.control-sender textarea.nadawca').val())
            .end()
            .find('input[name="adresat_id"]').val((self.objects.adresaci) ? self.objects.adresaci.id : '')
            .end()
            .find('input[name="adresat"]').val(prev.find('.control.control-addressee').html())
            .end()
            .find('input[name="szablon_id"]').val((self.objects.szablon) ? self.objects.szablon.id : '')
            .end()
            .find('input[name="tytul"]').val(prev.find('.control.control-template').text())
            .end()
            .find('input[name="tresc"]').val(prev.find('#editor').html())
            .end()
            .find('textarea[name="podpis"]').val(self.html.stepper_div.find('.edit .col-md-10 .control.control-signature textarea.podpis').val());
    },

    lastPageButtons: function () {
        var self = this,
            form = $('#finalForm'),
            buttons = form.find('.editor-tooltip .btn');

        $.each(buttons, function () {
            if ($(this).attr('name') == 'send' || $(this).attr('name') == 'save') {
                var button = $(this),
                    pismoConfirm = $('#pismoConfirm');

                button.attr('type', 'button');
                button.on('click', function () {
                    if (self.validateLastForm(this))
                        pismoConfirm.find('input').val('').end().modal('show');
                });

                pismoConfirm.find('.saveTemplate').on('click', function (e) {
                    e.preventDefault();

                    if ($.trim(pismoConfirm.find('#pismoTitle').val()) == '') {
                        pismoConfirm.find('.form-group').addClass('has-error').removeClass('has-success').find('.errorMsg').removeClass('hide');
                    } else {
                        pismoConfirm.find('.form-group').removeClass('has-error').addClass('has-success').find('.errorMsg').addClass('hide');
                        form.find('input[name="nazwa"]').val(pismoConfirm.find('#pismoTitle').val());
                        $(this).addClass('loading');
                        form.submit();
                    }
                });
            }
        })
    },
    validateLastForm: function (button) {
        var form = $('#finalForm'),
            errors = [],
            status = true;

        $.each(form.serializeArray(), function () {
            if (button.name == 'send') {
                var value = this.value.replace(/\r?\n|\r|^\s+|\s+$/g, '');

                if (value == '' || value == undefined) {
                    errors.push(this.name);
                    status = false;
                }
            }
        });

        if (!status) {
            if ($('.alert.pismoError').length == 0)
                $('#finalForm #editor-cont').before($('<div></div>').addClass('alert alert-danger pismoError').attr("role", "alert").hide());

            $('.pismoError').empty().append(
                $('<p></p>').text('Aby móc wysłać pismo prosze o wprowadzenie brakujących elementów:')
            ).append(
                $('<ul></ul>').append(function () {
                    var ul = $(this);

                    $.each(errors, function (index, value) {
                        var errorText = '';

                        /*if (value == 'miejscowosc')
                         errorText = 'miejscowość obok daty utworzenie pisma';
                         else */
                        if (value == 'data_pisma')
                            errorText = 'daty utworzenia pisma';
                        else if (value == 'nadawca')
                            errorText = 'dane nadawcy pisma';
                        else if (value == 'adresat')
                            errorText = 'dane odbiorcy pisma';
                        else if (value == 'tytul')
                            errorText = 'tytuł w składanym piśmie';
                        else if (value == 'tresc')
                            errorText = 'treść w składanym piśmie';
                        else if (value == 'podpis')
                            errorText = 'podpis składającego pismo';

                        if (errorText !== '')
                            ul.append(
                                $('<li></li>').text(errorText)
                            )
                    })
                })
            );
            $('.alert.pismoError').slideDown();
        }

        return status;
    }
});

var $P;

$(document).ready(function () {
    $P = new PISMA();
});