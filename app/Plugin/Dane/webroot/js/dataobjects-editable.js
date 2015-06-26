
var ObjectUsersManagement = function(dataset, id) {
    this.users = [];
    this.dataset = dataset;
    this.id = id;
    this.initialize();
};

ObjectUsersManagement.prototype.initialize = function() {
    $('body').append(
        this.getDOM()
    );

    $('#moderate-add').hide();

    var _this = this;

    $('a.btn-open-moderate').bind('click', function() {
        $('#moderate-modal').modal('show');
        _this.reLoadUsers();
    });
};

ObjectUsersManagement.prototype.reLoadUsers = function() {
    var _this = this;
    this.getSpinner().show();
    $.getJSON('/dane/' + _this.dataset + '/' + _this.id + '/users/index.json', function(res) {
        _this.onLoadUsers(res);
    });
};

ObjectUsersManagement.prototype.getSpinner = function() {
    return $('#moderate-modal .spinner').first();
};

ObjectUsersManagement.prototype.onLoadUsers = function(res) {
    this.getSpinner().hide();
    this.setUsers(res.response);

    var _this = this;

    $('#moderate-add').html(
        this.getAddUserFormDOM()
    );

    $('#moderate-add-email').autocomplete({
        serviceUrl: '/paszport/users/email.json',
        type: 'POST'
    });

    $('#moderate-users select').change(function() {
        var tr = $(this).closest('tr').first();
        var index = tr.attr('data-user-index');
        var role = $(this).val();
        var user = false;
        for(var i = 0; i < _this.users.length; i++) {
            if(i == index) {
                user = _this.users[i];
                break;
            }
        }

        if(!user)
            return false;

        if(role == '3') { // remove
            if(user.id == mPHeart.user_id) {
                if(!confirm('Jesteś pewien, że chcesz usunąć siebie samego z listy moderatorów? (Usunięcie jest nieodwracalne)'))
                    return false;
            }

            _this.getSpinner().show();

            $.ajax({
                url: '/dane/' + _this.dataset + '/' + _this.id + '/users/' + user.id + '.json',
                type: 'DELETE',
                success: function(res) {
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
            success: function(res) {
                _this.reLoadUsers();
            }
        });

        return false;
    });

    $('#moderate-add form').bind('submit', function() {
        var email = $(this).find('input[type=email]').first();
        var role = $(this).find('select').first();
        _this.getSpinner().show();
        $.post('/dane/' + _this.dataset + '/' + _this.id + '/users/index.json', {
            email: email.val(),
            role: role.val()
        }, function(res) {
            email.val(null);
            _this.reLoadUsers();
        });

        return false;
    });

    $("#moderate-users img").error(function(){
        $(this).attr('src', 'https://placeholdit.imgix.net/~text?txtsize=22&bg=ddd&txtclr=ddd%26text%3Davatar&txt=Avatar&w=80&h=80');
    });
};

ObjectUsersManagement.prototype.setUsers = function(users) {
    this.users = users;
    $('#moderate-users').html(
        this.getUsersDOM()
    );
};

ObjectUsersManagement.prototype.getDOM = function() {
    return [
        '<a class="btn btn-primary btn-open-moderate">',
            '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>',
        '</a>',
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
    ].join('');
};

ObjectUsersManagement.prototype.getUsersDOM = function() {
    var h = [];

    if(this.users.length > 0) {
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

ObjectUsersManagement.prototype.getAddUserFormDOM = function() {
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

ObjectUsersManagement.prototype.getSpinnerDOM = function() {
    return '<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
};

ObjectUsersManagement.prototype.roles = [
    {id: '1', label: 'Właściciel'},
    {id: '2', label: 'Administrator'},
    {id: '3', label: 'Usuń uprawnienia'}
];

ObjectUsersManagement.prototype.getRolesSelectDOM = function(selected_id) {
    var h = ['<select class="form-control">'];
    for(var i = 0; i < this.roles.length; i++) {
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

$(document).ready(function() {
    var header = $('.appHeader.dataobject').first();
    var dataset = header.attr('data-dataset');
    var object_id = header.attr('data-object_id');
    new ObjectUsersManagement(dataset, object_id);

    $('#moderate-btn-add').bind('click', function() {
        $('#moderate-add').slideToggle();
        return false;
    });
});