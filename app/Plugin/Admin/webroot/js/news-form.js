
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

});