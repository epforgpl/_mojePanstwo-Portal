/**
 * Created by tomaszdrazewski on 01/07/15.
 */
ObjectUsersManagement.prototype.onLoadUsers = function (res) {
    this.setUsers(res.response);

    var _this = this,
        instytucjaMerge = $('#instytucja-prawo-merge');

    instytucjaMerge.html(
        this.getAddInstitutionFormDOM()
    );

    $('#instytucja_wybierz_merge').autocomplete({
        serviceUrl: 'dane/suggest.json?dataset[]=instytucje',
        type: 'POST'
    });

    instytucjaMerge.find('form').bind('submit', function () {
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

};

ObjectUsersManagement.prototype.getAddInstitutionFormDOM = function () {
    return [
        '<form class="form-inline">',
        '<div class="form-group">',
        '<input type="text" class="form-control" id="instytucja_wybierz_merge" placeholder="Szukaj instytucji..." required>',
        '</div>',
        '<button type="submit" class="btn btn-default">Połącz</button>',
        '</form>'
    ].join('');
};

ObjectUsersManagement.prototype.setUsers = function (users) {
    this.users = users;
    $('#moderate-users').html(
        this.getUsersDOM()
    );
};


