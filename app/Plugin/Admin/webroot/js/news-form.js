
$(document).ready(function() {

    tinymce.init({
        selector: ".tinymceField",
        language : 'pl',
        toolbar: 'undo redo | bold italic underline | bullist numlist | removeformat',
        menubar: false,
        statusbar : false,
        content_css: [
            "/libs/bootstrap/3.3.4/css/bootstrap.min.css",
            "/css/main.css"
        ],
        valid_elements : "p,b,i,u,ul,ol,li"
    });

    $(function() {

        var elements = $('input.tagit');
        for (var i = 0; i < elements.length; i++) {

            var el = $(elements[i]);

            el.tagit({
                allowSpaces: true,
                removeConfirmation: true,
                beforeTagAdded: function (event, ui) {

                    if (ui.duringInitialization)
                        return false;

                    return (ui.tagLabel.length >= 2);
                },
                autocomplete: {
                    source: function (request, response) {
                        $.getJSON("/dane/suggest.json?q=" + request.term + "&dataset[]=tematy", function (res) {
                            var data = [];
                            for (var i = 0; i < res.options.length; i++)
                                data.push(res.options[i].text);

                            response(data);
                        });
                    },
                    minLength: 1
                }
            }).tagit('removeAll');

            var data = el.data('value');
            if (data && data.length) {
                for (var j = 0; j < data.length; j++) {
                    el.tagit('createTag', data[j]);
                }
            }

        }
    });

});