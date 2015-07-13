jQuery(document).ready(function () {
    var btn;
    if (btn = $('#archive_btn')) {
        btn.click(function () {

            $('#archive').slideDown();
            $('#archive_btn').slideUp();

        });
    }
});