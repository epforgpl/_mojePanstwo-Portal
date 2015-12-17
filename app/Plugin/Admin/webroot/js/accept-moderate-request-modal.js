
var AcceptModerateRequestModal = function(options) {
    this.dataset = options.dataset;
    this.object_id = options.object_id;
    this.user_id = options.user_id || 0;
    this.page_request_id = options.page_request_id || 0;
    this.user_email = options.user_email || false;
    this.success = options.success || false;
    this.role = options.role;
    this.username = false;
    this.title = false;
    this.send_email = false;
    this.create();
};

AcceptModerateRequestModal.prototype.roles = [
    '',
    'Właściciel',
    'Administrator'
];

AcceptModerateRequestModal.prototype.create = function() {
    $('body').append(this.getDOM());

    var t = this,
        md = $('.accept-moderate-request-modal');

    md.modal({
        show: true
    });

    $.post(
        '/dane/dataobjects/' + t.object_id + '.json',
        {
            _action: 'before_accept_moderate_request',
            user_id: t.user_id,
            user_email: t.user_email,
            dataset: t.dataset,
            object_id: t.object_id
        },
        function(res) {
            t.username = res.response.username;
            t.title = res.response.title;
            t.reloadBody();
        }
    );

    md.on('hidden.bs.modal', function(e) {
        md.remove();
    });
};

AcceptModerateRequestModal.prototype.reloadBody = function() {
    var t = this,
        md = $('.accept-moderate-request-modal'),
        bd = md.find('.modal-body'),
        r = t.roles[parseInt(t.role)],
        sub = md.find('button.submit');

    bd.html([
        '<p>',
            'Użytkownik <strong>' + t.username +
                '</strong> będzie miał prawo zarządzania profilem <strong>' + t.title +
                '</strong> jako <strong>' + r + '</strong>.',
        '</p>',
        '<label>',
            '<input type="checkbox" checked> Wyślij użytkownikowi email z zaproszeniem do edycji profilu.',
        '</label>'
    ].join(''));

    sub.click(function() {
        t.send_email = bd.find('input[type="checkbox"]').is(':checked');
        console.log(t.send_email);
        bd.html(t.getSpinnerDOM());
        $.post(
            '/dane/dataobjects/' + t.object_id + '.json',
            {
                _action: 'accept_moderate_request',
                user_id: t.user_id,
                user_email: t.user_email,
                username: t.username,
                title: t.title,
                page_request_id: t.page_request_id,
                dataset: t.dataset,
                object_id: t.object_id,
                send_email: t.send_email
            },
            function(res) {
                if(t.success === false) {
                    md.modal('hide');
                    window.location.reload();
                } else {
                    md.modal('hide');
                    t.success(res);
                }
            }
        );
    });
};

AcceptModerateRequestModal.prototype.getSpinnerDOM = function() {
    return '<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
};

AcceptModerateRequestModal.prototype.getDOM = function() {
    return [
        '<div class="modal fade accept-moderate-request-modal margin-top-10" tabindex="-1" role="dialog" aria-hidden="true">',
            '<div class="modal-dialog">',
                '<div class="modal-content">',
                    '<div class="modal-header">',
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
                        '<h4 class="modal-title" id="observeModalLabel">',
                            'Dodawawnie użytkownika',
                        '</h4>',
                    '</div>',
                    '<div class="modal-body">',
                        this.getSpinnerDOM(),
                    '</div>',
                    '<div class="modal-footer">',
		'<button class="btn btn-primary btn-icon width-auto submit">',
		'<span class="icon" data-icon="&#xe604;"></span>Zapisz',
                        '</button>',
                        '<a href="#" class="btn btn-link" data-dismiss="modal">Anuluj</a>',
                    '</div>',
                '</div>',
            '</div>',
        '</div>'
    ].join('');
};

$(document).ready(function() {

    $('.accept-moderate-request-modal-open').each(function() {

        $(this).click(function() {
            new AcceptModerateRequestModal({
                dataset: $(this).attr('data-dataset'),
                object_id: $(this).attr('data-object-id'),
                user_id: $(this).attr('data-user-id'),
                page_request_id: $(this).attr('data-page-request-id'),
                role: $(this).attr('data-role')
            });
        });

    });

});
