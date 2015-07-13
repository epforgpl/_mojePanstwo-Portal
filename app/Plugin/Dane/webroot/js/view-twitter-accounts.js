$(function () {
    $('.right-panel .url').each(function (i, val) {
        $.ajax({
            url: document.location.pathname + '/getpagetitle.json',
            data: {'url': val.dataset.url},
            type: 'POST',
            success: function (data) {
                if (data != null) {
                    $(val).html(data);
                }
            }
        })
    })
});