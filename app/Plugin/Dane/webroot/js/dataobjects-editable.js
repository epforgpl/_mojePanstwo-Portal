/*global $,jQuery,mPHeart*/

var ObjectUsersManagement = function (header, dataset, id, editables) {
    this.users = [];
    this.header = header;
    this.dataset = dataset;
    this.id = id;
    this.editables = editables;
    this.initialize();
};

ObjectUsersManagement.prototype.initialize = function () {
    var _this = this;

    $('body').append(
        $('<div></div>').addClass('editablePanel dropdown').append(
            this.getDOM()
        ).append(
            this.getDOMModals()
        )
    );

    $('#moderate-add').hide();

    var editablePanel = $('.editablePanel'),
        moderateModal = $('#moderate-modal'),
        changeLogo = $('#modalAdminAddLogo'),
        changeBackground = $('#modalAdminAddBackground'),
        bdl_opis = $('#bdl_opis_modal');

    var editablePanel = $('.editablePanel'),
        moderateModal = $('#moderate-modal'),
        changeLogo = $('#modalAdminAddLogo'),
        changeBackground = $('#modalAdminAddBackground');

    if (moderateModal.length) {
        editablePanel.find('.users').click(function (evt) {
            evt.preventDefault();
            moderateModal.modal('show');
            _this.reLoadUsers();
        });
    }

    if (changeLogo.length) {
        var logoImage = changeLogo.find('.cropit-image-preview').attr('data-image');

        editablePanel.find('.logo').click(function (evt) {
            evt.preventDefault();
            changeLogo.modal('show').on('hidden.bs.modal', function () {
                changeLogo.find('.alert').remove();
            });
        });
        changeLogo.find('.image-editor').cropit({
            imageState: {
                src: (logoImage) ? logoImage : ''
            },
            width: 180,
            height: 180,
            onImageLoaded: function () {
                changeLogo.find('.alert').slideUp("normal", function () {
                    $(this).remove();
                });
            },
            onFileReaderError: function (evt) {
                _this.cropItErrorMsg(changeLogo, evt);
            },
            onImageError: function (evt) {
                _this.cropItErrorMsg(changeLogo, evt);
            }
        });
        changeLogo.find('.export').click(function () {
            var self = $(this),
                imageData = changeLogo.find('.image-editor').cropit('export', {
                    type: 'image/png'
                });
            $.ajax({
                url: '/dane/' + _this.dataset + '/' + _this.id + '/page/logo.json',
                method: "POST",
                data: {'image': imageData},
                beforeSend: function () {
                    self.addClass('loading disabled')
                },
                success: function () {
                    location.reload(true)
                },
                error: function () {
                    //location.reload(true)
                }
            });
        });
    }

    if (changeBackground.length) {
        var backgroundImage = changeBackground.find('.cropit-image-preview').attr('data-image');

        editablePanel.find('.cover').click(function (evt) {
            evt.preventDefault();
            changeBackground.modal('show').on('hidden.bs.modal', function () {
                changeBackground.find('.alert').remove();
            });
        });
        changeBackground.find('.image-editor').cropit({
            imageState: {
                src: (backgroundImage) ? backgroundImage : ''
            },
            width: 750,
            height: 150,
            exportZoom: 2,
            onImageLoaded: function () {
                changeBackground.find('.alert').slideUp("normal", function () {
                    $(this).remove();
                });
            },
            onFileReaderError: function (evt) {
                _this.cropItErrorMsg(changeBackground, evt);
            },
            onImageError: function (evt) {
                _this.cropItErrorMsg(changeBackground, evt);
            }
        });
        changeBackground.find('.export').click(function () {
            var self = $(this),
                imageData = changeBackground.find('.image-editor').cropit('export', {
                    type: 'image/jpeg',
                    quality: .9
                });

            $.ajax({
                url: '/dane/' + _this.dataset + '/' + _this.id + '/page/cover.json',
                method: "POST",
                data: {'image': imageData},
                beforeSend: function () {
                    self.addClass('loading disabled')
                },
                success: function () {
                    location.reload(true)
                },
                error: function () {
                    //location.reload(true)
                }
            });
        });
    }
    if (changeLogo.length || changeBackground.length) {
        $.each([changeLogo, changeBackground], function () {
            $(this).on('change', '.btn-file :file', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            $(this).find('.delete').click(function () {
                var self = $(this);

                $.ajax({
                    url: '/dane/' + _this.dataset + '/' + _this.id + '/page/' + $(this).attr('data-type') + '.json',
                    method: "DELETE",
                    beforeSend: function () {
                        self.addClass('loading disabled')
                    },
                    success: function () {
                        location.reload(true)
                    },
                    error: function () {
                        //location.reload(true)
                    }
                });
            });
        });
    }
    if (bdl_opis.length) {
        editablePanel.find('.bdl_opis').click(function (evt) {
            evt.preventDefault();
            bdl_opis.modal("show");
        });
    }
};

ObjectUsersManagement.prototype.cropItErrorMsg = function (el, error) {
    var alert = el.find('.alert.alert-danger');

    if (mPHeart.language.twoDig == 'pl') {
        if (error.code === 0) {
            error.message = 'Błąd ładowowania zdjęcia - proszę spróbować inne.'
        } else if (error.code === 1) {
            error.message = 'Zdjęcie nie spełnia zalecanej wielkości.'
        }
    }

    if (alert.length) {
        alert.text(error.message);
    } else {
        el.find('.image-editor').prepend(
            $('<div></div>').addClass('alert alert-danger').text(error.message).slideDown()
        )
    }
};

ObjectUsersManagement.prototype.reLoadUsers = function () {
    var _this = this;
    this.getSpinner().show();
    $.getJSON('/dane/' + _this.dataset + '/' + _this.id + '/users/index.json', function (res) {
        _this.onLoadUsers(res);
    });
};

ObjectUsersManagement.prototype.getSpinner = function () {
    return $('#moderate-modal').find('.spinner').first();
};

ObjectUsersManagement.prototype.onLoadUsers = function (res) {
    this.getSpinner().hide();
    this.setUsers(res.response);

    var _this = this,
        moderateAdd = $('#moderate-add'),
        moderateUsers = $('#moderate-users');

    moderateAdd.html(
        this.getAddUserFormDOM()
    );

    $('#moderate-add-email').autocomplete({
        serviceUrl: '/paszport/users/email.json',
        type: 'POST'
    });

    moderateUsers.find('select').change(function () {
        var tr = $(this).closest('tr').first();
        var index = tr.attr('data-user-index');
        var role = $(this).val();
        var user = false;
        for (var i = 0; i < _this.users.length; i++) {
            if (i == index) {
                user = _this.users[i];
                break;
            }
        }

        if (!user)
            return false;

        if (role == '3') { // remove
            if (user.id == mPHeart.user_id) {
                if (!confirm('Jesteś pewien, że chcesz usunąć siebie samego z listy moderatorów? (Usunięcie jest nieodwracalne)'))
                    return false;
            }

            _this.getSpinner().show();

            $.ajax({
                url: '/dane/' + _this.dataset + '/' + _this.id + '/users/' + user.id + '.json',
                type: 'DELETE',
                success: function () {
                    _this.reLoadUsers();
                }
            });

            return false;
        }

        _this.getSpinner().show();

        $.ajax({
            url: '/dane/' + _this.dataset + '/' + _this.id + '/users/' + user.id + '.json',
            type: 'PUT',
            data: {
                role: role
            },
            success: function () {
                _this.reLoadUsers();
            }
        });

        return false;
    });

    moderateAdd.find('form').bind('submit', function () {
        var email = $(this).find('input[type=email]').first();
        var role = $(this).find('select').first();
        _this.getSpinner().show();
        $.post('/dane/' + _this.dataset + '/' + _this.id + '/users/index.json', {
            email: email.val(),
            role: role.val()
        }, function () {
            email.val(null);
            _this.reLoadUsers();
        });

        return false;
    });

    moderateUsers.find("img").error(function () {
        $(this).attr('src', 'https://placeholdit.imgix.net/~text?txtsize=22&bg=ddd&txtclr=ddd%26text%3Davatar&txt=Avatar&w=80&h=80');
    });
};

ObjectUsersManagement.prototype.setUsers = function (users) {
    this.users = users;
    $('#moderate-users').html(
        this.getUsersDOM()
    );
};

ObjectUsersManagement.prototype.getDOM = function () {
    return [
        '<button class="btn btn-primary btn-open-moderate dropdown-toggle" type="button" id="moderatePanelModal" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">',
        '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>',
        '</button>'
    ].join('');
};

ObjectUsersManagement.prototype.getDOMModals = function () {
    var list = [
            '<ul class="dropdown-menu" aria-labelledby="moderatePanelModal">'
        ],
        modal = [];

    if (jQuery.inArray("users", this.editables) !== -1) {
        $.merge(list, [
            '<li><a class="users" href="#">Moderatorzy strony...</a></li>'
        ]);
        $.merge(modal, [
            '<div class="modal fade" id="moderate-modal" tabindex="-1" role="dialog">',
            '<div class="modal-dialog modal-lg" role="document">',
            '<div class="modal-content">',
            '<div class="modal-header">',
            '<h4 class="modal-title">',
            'Moderatorzy tej strony',
            '<button id="moderate-btn-add" type="button" class="btn btn-link"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>',
            '</h4>',
            this.getSpinnerDOM(),
            '</div>',
            '<div class="modal-body">',
            '<div id="moderate-add"></div>',
            '<div id="moderate-users"></div>',
            '</div>',
            '<div class="modal-footer">',
            '<button type="button" class="btn btn-md btn-primary btn-icon" data-dismiss="modal">',
            '<i class="icon glyphicon glyphicon-ok"></i>Gotowe',
            '</button>',
            '</div>',
            '</div>',
            '</div>',
            '</div>'
        ]);
    }
    if (jQuery.inArray("logo", this.editables) !== -1) {
        $.merge(list, [
            '<li><a class="logo" href="#">' + (this.header.hasClass('cover-logo') ? 'Zmień' : 'Dodaj') + ' logo</a></li>'
        ]);
        $.merge(modal, [
            '<div class="modal modalAdmin fade" id="modalAdminAddLogo" tabindex="-1" role="dialog" aria-labelledby="modalAdminAddLogoLabel">',
            '<div class="modal-dialog" role="document">',
            '<div class="modal-content">',
            '<div class="modal-header">',
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">',
            '<span aria-hidden="true">&times;</span>',
            '</button>',
            '<h4 class="modal-title" id="myModalLabel">' + (this.header.hasClass('cover-logo') ? 'Zmień' : 'Dodaj') + ' logo</h4>',
            '</div>',
            '<div class="modal-body">',
            '<div class="image-editor">',
            '<div class="cropit-image-preview"' + (this.header.hasClass('cover-logo') ? ' data-image="/pages/logo/' + this.dataset + '/' + this.id + '.png"' : '') + '></div>',
            '<p>Zalecany rozmiar: 180x180px</p>',
            '<span class="btn btn-default btn-file">Przeglądaj<input type="file" class= "cropit-image-input" /></span>',
            '</div>',
            '</div>',
            '<div class="modal-footer">' + (this.header.hasClass('cover-logo') ? '<button type="button" class= "btn btn-link delete" data-type="logo">Usuń logo</button>' : ''),
            '<button type="button" class="btn btn-primary export">Dodaj</button>',
            '</div>',
            '</div>',
            '</div>',
            '</div>'
        ]);
    }

    if (jQuery.inArray("cover", this.editables) !== -1) {
        $.merge(list, [
            '<li><a class="cover" href="#">' + (this.header.hasClass('cover-background') ? 'Zmień' : 'Dodaj') + ' obrazek tła</a></li>'
        ]);
        $.merge(modal, [
            '<div class="modal modalAdmin fade" id="modalAdminAddBackground" tabindex="-1" role="dialog" aria-labelledby="modalAdminAddBackgroundLabel">',
            '<div class="modal-dialog" role="document">',
            '<div class="modal-content">',
            '<div class="modal-header">',
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">',
            '<span aria-hidden="true">&times;</span>',
            '</button>',
            '<h4 class="modal-title" id="myModalLabel">' + (this.header.hasClass('cover-background') ? 'Zmień' : 'Dodaj') + ' obrazek tła</h4>',
            '</div>',
            '<div class="modal-body">',
            '<div class="image-editor">',
            '<div class="cropit-image-preview"' + (this.header.hasClass('cover-background') ? ' data-image="/pages/cover/' + this.dataset + '/' + this.id + '.jpg"' : '') + '></div>',
            '<p>Zalecany rozmiar: 1500x300px</p>',
            '<span class="btn btn-default btn-file">Przeglądaj<input type="file" class= "cropit-image-input" /></span>',
            '</div>',
            '</div>',
            '<div class="modal-footer">' + (this.header.hasClass('cover-background') ? '<button type="button" class="btn btn-link delete" data-type="cover">Usuń obrazek tła</button>' : ''),
            '<button type="button" class="btn btn-primary export">Dodaj</button>',
            '</div>',
            '</div>',
            '</div>',
            '</div>'
        ]);
    }

    if (jQuery.inArray("bdl_opis", this.editables) !== -1) {
        $.merge(list, [
            '<li><a class="bdl_opis" href="#">Zmiana opisu i nazwy</a></li>'
        ]);
    }

    $.merge(list, ['</ul>']);
    $.merge(list, modal);

    return list.join('');
};

ObjectUsersManagement.prototype.getUsersDOM = function () {
    var h = [];

    if (this.users.length > 0) {
        h.push('<table class="table table-striped">');
        for (var i = 0; i < this.users.length; i++) {
            if (this.users.hasOwnProperty(i)) {
                var user = this.users[i];
                var img_src = user.photo_small != '' ? user.photo_small : 'https://placeholdit.imgix.net/~text?txtsize=22&bg=ddd&txtclr=ddd%26text%3Davatar&txt=Avatar&w=80&h=80';
                h.push([
                    '<tr data-user-index="' + i + '">',
                    '<td>',
                    '<img class="img-circle" src="' + img_src + '"/>',
                    '</td>',
                    '<td>',
                    user.username,
                    '</td>',
                    '<td>',
                    user.email,
                    '</td>',
                    '<td>',
                    this.getRolesSelectDOM(user.role),
                    '</td>',
                    '</tr>'
                ].join(''));
            }
        }
        h.push('</table>');
    } else {
        h.push('<p class="help-block">Brak użytkowników</p>');
    }

    return h.join('');
};

ObjectUsersManagement.prototype.getAddUserFormDOM = function () {
    return [
        '<form class="form-inline">',
        '<div class="form-group">',
        '<input type="email" class="form-control" id="moderate-add-email" placeholder="Adres e-mail" required>',
        '</div>',
        '<div class="form-group">',
        this.getRolesSelectDOM(1),
        '</div>',
        '<button type="submit" class="btn btn-default">Dodaj</button>',
        '</form>'
    ].join('');
};

ObjectUsersManagement.prototype.getSpinnerDOM = function () {
    return '<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
};

ObjectUsersManagement.prototype.roles = [
    {id: '1', label: 'Właściciel'},
    {id: '2', label: 'Administrator'},
    {id: '3', label: 'Usuń uprawnienia'}
];

ObjectUsersManagement.prototype.getRolesSelectDOM = function (selected_id) {
    var h = ['<select class="form-control">'];
    for (var i = 0; i < this.roles.length; i++) {
        var role = this.roles[i];
        h.push([
            '<option value="' + role.id + '"',
            role.id == selected_id ? ' selected' : '',
            '>',
            role.label,
            '</option>'
        ].join(''));
    }
    h.push('</select>');
    return h.join('');
};

$(document).ready(function () {
    var header = $('.appHeader.dataobject').first(),
        dataset = header.attr('data-dataset'),
        object_id = header.attr('data-object_id'),
        editables = header.attr('data-editables');
    new ObjectUsersManagement(header, dataset, object_id, jQuery.parseJSON(editables));
});