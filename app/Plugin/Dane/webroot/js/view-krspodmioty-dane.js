
$(document).ready(function () {
    // http://convertcase.net/
    function sentencecase(a) {
        a = a.toLowerCase();
        var b= true;
        var c="";
        for(var d=0;d<a.length;d++){
            var e=a.charAt(d);
            if(/\.|>|\!|\?|\n|\r/.test(e)){
                b=true;
            } else if($.trim(e)!=""&&b==true){
                e=e.toUpperCase();b=false;
            }
            c+=e;
        }
        c=c.replace(/ i /g,' I ');
        return c;
    }

	var form = $('form.form-horizontal').first(),
        header = $('.appHeader.dataobject').first(),
        dataset = header.attr('data-dataset'),
        object_id = header.attr('data-object_id'),
        opis = $('#descriptionTextArea');

    tinymce.PluginManager.add('sentencecase', function(editor, url) {
        editor.addMenuItem('sentencecase', {
            text: 'Litery jak w zdaniu',
            context: 'format',
            onclick: function() {
                editor.setContent(
                    sentencecase(editor.getContent())
                );
            }
        });
    });

    tinymce.init({
		selector: ".tinymceField",
        language : 'pl',
        plugins: "media image sentencecase paste",
        paste_auto_cleanup_on_paste : true,
        paste_remove_styles: true,
        paste_remove_styles_if_webkit: true,
        paste_strip_class_attributes: true,
        paste_as_text: true,
        toolbar: 'undo redo | bold italic underline | bullist numlist',
        menubar: false,
        statusbar : false,
        content_css: [
            "/libs/bootstrap/3.3.4/css/bootstrap.min.css",
            "/css/main.css"
        ],
        valid_elements : "p,b,i,u,ul,ol,li"
    });

    // Source: http://blog.mmx3.pl/2010/11/16/javascript-walidator-numeru-rachunku-bankowego-nrb/
    /**
     * @return {boolean}
     */
    function NRBvalidatior(nrb) {
        nrb = nrb.replace(/[^0-9]+/g, '');
        var wagi = [1, 10, 3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51, 25, 56, 75, 71, 31, 19, 93, 57];

        if (nrb.length == 26) {
            nrb = nrb + "2521";
            nrb = nrb.substr(2) + nrb.substr(0, 2);
            var Z = 0;
            for(var i = 0; i < 30; i++) {
                Z += nrb[29 - i] * wagi[i];
            }

            return Z % 97 == 1;
        }

        return false;
    }

    form.submit(function() {
        var bankAccountInput = $(this).find('#bankAccountNumber').first();
        if(bankAccountInput.length && bankAccountInput.val().length) {
            if(NRBvalidatior(bankAccountInput.val()) == false) {
                alert('Podałeś/aś nieprawidłowy numer konta');
                return false;
            }
        }

        tinyMCE.triggerSave();

        $(this)
            .find('.submitBtn')
            .addClass('loading disabled');
    });

    $('.btnImport').click(function() {
        tinymce.activeEditor.setContent(
            $(this).attr('data-opis')
        );
    });

    $('.sticky').sticky();

    /* Tags autocomplete input */
    $(function () {

        var elements = $('.tags input.tagit');
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
