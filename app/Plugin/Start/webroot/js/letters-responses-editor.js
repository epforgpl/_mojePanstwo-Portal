
var letterResponseEditors = [];
var LetterResponseEditor = function(obj, index) {
    var self = this;
    this.index = index;
    this.obj = obj;
    this.data = obj.data();
    this.previewCache = null;
    self.createPreviewListeners();
};

LetterResponseEditor.prototype = {

    constructor: LetterResponseEditor,

    editView: function() {
        var self = this, content = '<div class="well bs-component mp-form"><form class="letterResponseForm margin-top-10" method="post"><fieldset><legend>Edycja odpowiedzi</legend><div class="row margin-top-10"><div class="col-md-9"><div class="form-group"><label for="responseName">Tytuł:</label><input maxlength="195" type="text" class="form-control" value="' + self.data.title + '" name="name"></div></div><div class="col-md-3"><div class="form-group"><label for="responseDate">Data:</label><input type="text" value="' + self.data.date + '" class="form-control datepickerResponseDate" name="date"></div></div></div><div class="form-group"><label for="responseContent">Treść:</label><textarea class="form-control tinymceField" rows="7" name="content">' + self.data.content + '</textarea></div><div class="form-group"><label>Załączniki:</label>';

        if(self.data.files.length) {
            content += '<div class="files">';
            for(var f = 0; f < self.data.files.length; f++) {
                var file = self.data.files[f];
                if(typeof file['deleted'] !== 'undefined' && file['deleted'])
                    continue;

                content += '<div class="file-editable"><div class="file-name"><a href="/moje-pisma/' + self.data.letterId + ',' + self.data.letterSlug + '/attachment/' + file['ResponseFile']['id'] + '" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> ' + file['ResponseFile']['src_filename'] + '</a></div><div class="file-options"><button class="btn btn-default btn-sm removeResponseFile" data-index="' + f + '" data-filename="' + file['ResponseFile']['src_filename'] + '" data-id="' + file['ResponseFile']['id'] + '" type="button"><span class="glyphicon glyphicon-trash"></span></button></div></div>';
            }
            content += '</div>';
        }

		content += '<div class="dropzoneForm"><div class="actions"><button class="btn btn-sm btn-default btn-addfile" type="button">Dodaj załącznik</button></div><div class="dropzoneFormPreview" id="preview_' + self.index + '"></div></div></div><div class="form-group overflow-hidden text-center margin-top-20"><button class="btn btn-default abortChanges" type="button">Anuluj</button><button class="btn width-auto btn-primary btn-icon" type="submit"><span class="icon glyphicon glyphicon-edit"></span>Zapisz zmiany</button></div></fieldset></form></div>';

        self.createPreviewViewCache();
        self.obj.addClass('response-form');
        self.obj.html(content);

        self.obj.find('.datepickerResponseDate').first().bootstrapDP({
            language: 'pl',
            orientation: 'auto top',
            format: "yyyy-mm-dd",
            autoclose: true
        });

        tinymce.init({
            selector: ".tinymceField",
            language : 'pl',
            menubar: false,
            statusbar : false,
            content_css: [
                "/libs/bootstrap/3.3.4/css/bootstrap.min.css",
                "/css/main.css"
            ],
            valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
            + "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
            + "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
            + "name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,"
            + "#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
            + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
            + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
            + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
            + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
            + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
            + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
            + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
            + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
            + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
            + "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
            + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
            + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
            + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
            + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
            + "q[cite],samp,select[disabled|multiple|name|size],small,"
            + "textarea[cols|rows|disabled|name|readonly],tt,var,big,"
            + "iframe[src|title|width|height|allowfullscreen|frameborder]"
        });

        self.obj.find('.dropzoneForm').first().dropzone({
            url: '/moje-pisma/' + self.data.letterId + ',' + self.data.letterSlug + '/responses/' + self.data.id + '.json',
            clickable: '.btn-addfile',
            acceptedFiles: '.pdf,.docx,.doc,.tif,.html,.jpg,.xml,.xls,.xlsx,.rtf,.png',
            autoQueue: true,
            autoProcessQueue: true,
            previewsContainer: '#preview_' + self.index,
            previewTemplate: '<div class="file"><div class="title"><span class="name" data-dz-name></span><span class="size" data-dz-size></span><span class="error text-danger" data-dz-errormessage></span></div><div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div></div><div class="buttons"></div></div>',
            success: function(file, response){
                console.log(file);
                console.log(response);
            }
        });

        self.obj.find('button.abortChanges').click(function() {
            if(confirm('Czy na pewno chcesz anulować edycje?')) {
                self.obj.removeClass('response-form');
                self.obj.html(
                    self.previewCache
                );
                self.createPreviewListeners();
            }
        });

        self.obj.find('.removeResponseFile').each(function() {
            var btnSelf = $(this);
            $(this).click(function() {
                var data = btnSelf.data();
                if(confirm('Czy na pewno chcesz usunać załącznik o nazwie ' + data.filename + '?')) {
                    btnSelf.closest('.file-editable').slideToggle();
                    self.data.files[data.index]['deleted'] = true;
                }
            });
        });

        self.obj.find('form').first().submit(function() {
            var formData = [],
                serializeData = $(this).serializeArray();

            tinyMCE.triggerSave();

            for(var s = 0; s < serializeData.length; s++) {
                var formRow = serializeData[s];
                formData[formRow.name] = formRow.value;
            }

            formData['files'] = self.data.files;

            $.post(
                '/moje-pisma/' + self.data.letterId + ',' + self.data.letterSlug + '/responses/' + self.data.id + '.json',
                $.extend({}, formData),
                function(res) {
                    console.log(res);
                    location.reload();
                }
            );

            return false;
        });

    },

    createPreviewViewCache: function() {
        var self = this;
        if(self.previewCache == null)
            self.previewCache = self.obj.html();
    },

    createPreviewListeners: function() {
        var self = this;
        this.obj.find('.btn.editAction').first().click(function() {
            self.editView();
        });
    }

};

$(document).ready(function() {
    $('ul.responses li.response').each(function(index) {
        letterResponseEditors.push(
            new LetterResponseEditor($(this), index)
        );
    });
});
