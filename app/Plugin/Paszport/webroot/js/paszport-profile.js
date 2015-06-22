$(function () {

    $('.form-user-edit').each(function () {

        var form = $(this);
        var field = form.attr('data-field');
        var type = (field == 'email' ? 'email' : 'text');
        var action = (field == 'email' ? 'setEmail' : 'setUserName');

        form.find('a').first().click(function () {

            var a = $(this);
            a.hide();

            var value = a.text().trim();

            form.append(
                '<div class="input-group">' +
                '<input type="' + type + '" class="form-control" name="' + field + '" value="' + value + '">' +
                '<span class="input-group-btn">' +
                '<button class="btn btn-default saveDataField" type="button">Zapisz</button>' +
                '<button class="btn btn-default cancelDataField" type="button">Anuluj</button>' +
                '</span>' +
                '</div>'
            );

            var group = form.find('.input-group').first();
            var input = form.find('input').first();
            input.focus();

            form.find('button.cancelDataField').first().click(function () {
                form.find('.input-group')
                    .first()
                    .remove();

                a.show();
            });

            form.find('button.saveDataField').first().click(function () {

                var newValue = input.val();

                if (newValue.length < 3) {
                    group.addClass('has-error');
                    return false;
                }

                $.post("/paszport/user/" + action, {value: newValue}, function (data) {

                    if (data == 'true') {

                        a.find('b')
                            .first()
                            .text(newValue);

                        form.find('.input-group')
                            .first()
                            .remove();

                        a.show();

                        return false;
                    } else {
                        group.addClass('has-error');
                        return false;
                    }
                });

            });

            return false;
        });

    });

    $('#form-user-edit-password a').click(function () {

        var form = $('#form-user-edit-password');
        var a = form.find('a').first();
        a.hide();

        var closeForm = function () {
            a.show();
            form.find('.edit-password-form-groups').first().remove();
        };

        form.append(
            '<div class="edit-password-form-groups">' +
            '<div class="form-group">' +
            '<label for="inputOldPassword">Aktualne hasło</label>' +
            '<input id="inputOldPassword" value="" type="password" class="form-control" name="oldPassword">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="inputNewPassword">Nowe hasło</label>' +
            '<input id="inputNewPassword" value="" type="password" class="form-control" name="newPassword">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="inputConfirmNewPassword">Potwierdź nowe hasło</label>' +
            '<input id="inputConfirmNewPassword" value="" type="password" class="form-control" name="confirmNewPassword">' +
            '</div>' +
            '<button type="submit" class="btn btn-link edit-password-cancel"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Anuluj</button> ' +
            '<button type="submit" class="btn btn-link edit-password-submit"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Zapisz</button>' +
            '</div>'
        );

        var group = form.find('.edit-password-form-groups').first();
        group.find('.form-group input').first().focus();

        group.find('button.edit-password-cancel').first().click(function () {
            closeForm();
            return false;
        });

        group.find('button.edit-password-submit').first().click(function () {

            var oldPassword = $('#inputOldPassword').val();
            var confirmNewPassword = $('#inputConfirmNewPassword').val();
            var newPassword = $('#inputNewPassword').val();

            if (oldPassword.length < 6 || newPassword.length < 6 || newPassword != confirmNewPassword) {
                group.find('.form-group').each(function () {
                    $(this).addClass('has-error');
                });
                return false;
            }

            $.post("/paszport/user/setPassword", {
                old_password: oldPassword,
                new_password: newPassword
            }, function (data) {

                if (data == 'true') {
                    closeForm();
                } else {
                    group.find('.form-group').each(function () {
                        $(this).addClass('has-error');
                    });
                }

                return false;

            });

            return false;
        });

        return false;
    });

    $('#form-user-create-password a').click(function () {

        var form = $('#form-user-create-password');
        var a = form.find('a').first();
        a.hide();

        var closeForm = function () {
            a.show();
            form.find('.create-password-form-groups').first().remove();
        };

        form.append(
            '<div class="create-password-form-groups">' +
            '<div class="form-group">' +
            '<label for="inputPassword">Hasło</label>' +
            '<input id="inputPassword" value="" type="password" class="form-control" name="password">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="inputConfirmPassword">Potwierdź hasło</label>' +
            '<input id="inputConfirmPassword" value="" type="password" class="form-control" name="confirmPassword">' +
            '</div>' +
            '<button type="submit" class="btn btn-link create-password-cancel"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Anuluj</button> ' +
            '<button type="submit" class="btn btn-link create-password-submit"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Zapisz</button>' +
            '</div>'
        );

        var group = form.find('.create-password-form-groups').first();
        group.find('.form-group input').first().focus();

        group.find('button.create-password-cancel').first().click(function () {
            closeForm();
            return false;
        });

        group.find('button.create-password-submit').first().click(function () {

            var confirmPassword = $('#inputConfirmPassword').val();
            var password = $('#inputPassword').val();

            if (password.length < 6 || password.length < 6 || password != confirmPassword) {
                group.find('.form-group').each(function () {
                    $(this).addClass('has-error');
                });
                return false;
            }

            $.post("/paszport/user/createNewPassword", {
                password: password,
                confirm_password: confirmPassword
            }, function (data) {

                if (data == 'true') {
                    closeForm();
                    location.reload();
                } else {
                    group.find('.form-group').each(function () {
                        $(this).addClass('has-error');
                    });
                }

                return false;

            });

            return false;
        });

        return false;
    });

    $('#submitDeletePaszport').click(function () {
        var password = $('#inputDeletePassword').val();

        if (password == '') {
            $('#inputDeletePassword').parent('.form-group').addClass('has-error');
            return false;
        }

        $.post("/paszport/user/delete", {password: password}, function (data) {

            if (data == 'true') {
                $(location).attr('href', '/paszport/users/logout');
            } else {
                $('#inputDeletePassword').parent('.form-group').addClass('has-error');
            }

            return false;

        });
    });

});