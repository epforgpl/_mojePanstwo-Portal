$(function() {

    $('.form-user-edit').each(function() {

        var form = $(this);
        var field = form.attr('data-field');

        form.find('a').first().click(function() {

            var a = $(this);
                a.hide();

            var value = a.text().trim();

            form.append(
                '<div class="input-group">' +
                    '<input type="text" class="form-control" name="' + field + '" value="' + value + '">' +
                    '<span class="input-group-btn">' +
                        '<button class="btn btn-default" type="button">Zapisz</button>' +
                    '</span>' +
                '</div>'
            );

            var group = form.find('input-group').first();
            var input = form.find('input').first();
                input.focus();

            form.find('button').first().click(function() {

                var newValue = input.val();



                a.find('b')
                    .first()
                    .text(newValue);

                form.find('.input-group')
                    .first()
                    .remove();

                a.show();
            });

            return false;
        });

    });

    $('#form-user-edit-password a').click(function() {

        var form = $('#form-user-edit-password');
        var a = form.find('a').first();
            a.hide();

        var closeForm = function() {
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

        group.find('button.edit-password-cancel').first().click(function() {
            closeForm();
            return false;
        });

        group.find('button.edit-password-submit').first().click(function() {

            return false;
        });

        return false;
    });

});