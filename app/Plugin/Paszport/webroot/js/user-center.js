/*global translation:true*/

(function () {
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var birthDay = $('.dpYears').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? '' : 'disabled';
        }
    }).on('changeDate', function (ev) {
        if (ev.viewMode == 'days')
            birthDay.hide();
        var selectDate = ev.date;
        $('.dpYears input').val(selectDate.getDate() + '-' + (selectDate.getMonth() + 1) + '-' + selectDate.getFullYear());
    }).data('datepicker');

    $('.basic .editElement').each(function () {
        $(this).find('input').jqBootstrapValidation();
    });

    $('.userCenter .basic').find('.btn.doubleState').each(function () {
        $(this).click(function (e) {
            var el = $(e.target),
                switchOldText = el.val(),
                switchNewText = el.data('text'),
                form = el.parents('form');
            e.preventDefault();

            if (el.hasClass('save')) {
                var data = {};

                if (el.hasClass('block')) return false;

                if (el.hasClass('bDayButton')) {
                    var date = (form.find('.editElement .dpYears input').val()).split('-'),
                        newDate = date[2] + '-' + date[1] + '-' + date[0],
                        datePickerEl = $('div.datepicker');

                    if (form.find('.editElement .dpYears').data('date') != newDate)
                        form.find('.editElement .dpYears').data('date', newDate);

                    if (datePickerEl.is(':visible'))
                        datePickerEl.hide();

                    data = {'data[User][personal_bday]': form.find('.editElement .dpYears').data('date')};
                } else {
                    data = form.serialize()
                }

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: form.attr('action'),
                    data: data,
                    beforeSend: function () {
                        /*TODO: add twirl*/
                    },
                    success: function (data) {
                        var status = data.status;

                        if (status == '200') {
                            el.data('text', switchOldText).val(switchNewText).toggleClass('save');
                            form.find('.viewElement, .editElement').toggle();

                            if (el.hasClass('genderButton') || el.hasClass('languageButton')) {
                                form.find('.viewElement input').val(form.find('.editElement select option:selected').text());
                            } else {
                                form.find('.viewElement input').val(form.find('.editElement input').val());
                            }
                        } else if (status == 422) {
                            /*TODO: error dla pola/pól*/
                        } else if (status == 500) {
                            var errors = data.alerts.error;

                            for (var i = 0; i < errors.length; i++) {
                                globalAlert('alert-danger', eval('mPHeart.translation.' + errors[i]));
                            }
                        }
                    },
                    complete: function () {
                        /*TODO: remove twirl*/
                    }
                });
            } else {
                el.data('text', switchOldText).val(switchNewText).toggleClass('save');
                form.find('.viewElement, .editElement').toggle();
            }
        })
    });

    $('a.ago').tooltip();

    $('#UserPhoto, #ErrorReportScreenshot').customFileInput({
        button_position: 'left',
        feedback_text: mPHeart.translation.LC_PASZPORT_FILE_INPUT_NO_FILE,
        button_text: mPHeart.translation.LC_PASZPORT_FILE_INPUT_BROWSE,
        button_change_text: mPHeart.translation.LC_PASZPORT_FILE_INPUT_CHANGE
    });

}($));