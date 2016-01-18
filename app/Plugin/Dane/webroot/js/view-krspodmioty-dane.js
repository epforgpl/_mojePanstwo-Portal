
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

	var form = $('section.content form'),
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
        plugins: "media image sentencecase",
        toolbar: 'undo redo | bold italic underline | bullist numlist',
        menubar: false,
        statusbar : false,
        content_css: [
            "/libs/bootstrap/3.3.4/css/bootstrap.min.css",
            "/css/main.css"
        ],
        valid_elements : "p,b,i,u,ul,ol,li"
    });

    form.submit(function() {
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

});
