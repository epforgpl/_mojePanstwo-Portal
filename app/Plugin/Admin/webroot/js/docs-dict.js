
$(document).ready(function() {


    var b = $('body');

    b.on('click', 'button.removeDict', function() {
        var id = $(this).data('id');
        $.post('/admin/docs/removeDict', {
            id: id
        }, function() {
            b.find('tr[data-id="' + id + '"]').fadeOut(300, function() {
                $(this).remove();
            });
        }, 'json');
    });

    b.on('click', '#addDict button', function() {
        var from = $('#addDictFrom'),
            to = $('#addDictTo');
        $.post('/admin/docs/addDict', {
            from: from.val(),
            to: to.val()
        }, function(res) {
            var id = res['DoctableDict']['id'],
                fromTxt = res['DoctableDict']['from'],
                toTxt = res['DoctableDict']['to'];

            $('#mainTable tr:last').before('<tr data-id="' + id + '"><td><input type="text" name="from" data-id="' + id + '" class="form-control editable" value="' + fromTxt + '"></td><td><input type="text" name="to" data-id="' + id + '" class="form-control editable" value="' + toTxt + '"></td><td><button data-id="' + id + '" class="btn btn-danger removeDict">Usuń</button></td></tr>');
        }, 'json');

        from.val('');
        to.val('');
    });

    b.on('change', 'input.editable', function() {
        var id = $(this).data('id'),
            name = $(this).attr('name'),
            val = $(this).val();

        var data = {};
        data[name] = val;
        data['id'] = id;

        $.post('/admin/docs/addDict', data, function() {

        }, 'json');
    });

});