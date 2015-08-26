/**
 * Created by tomaszdrazewski on 29/06/15.
 */
$(document).ready(function () {
	var editor = $('#editor');

	editor.wysihtml5.locale['pl-PL'].emphasis = {
		bold: "B",
		italic: "I",
		underline: "U"
	};

	editor.wysihtml5({
        toolbar: {
            "font-styles": true, //Font styling, e.g. h1, h2, etc.
            "emphasis": true, //Italics, bold, etc.
            "lists": false, //(Un)ordered lists, e.g. Bullets, Numbers.
            "html": false, //Button which allows you to edit the generated HTML.
            "link": true, //Button to insert a link.
            "image": false, //Button to insert an image.
            "color": false, //Button to change color of font
            "blockquote": false
        },
		'locale': 'pl-PL',
        parser: function (html) {
            return html;
        }
    });

    var wsk_id;
    var dim_name;
    var dim_id;

    var id = $('.wskz_id').val();
    var url = '/bdl/bdl_temp_items/' + id;
    getWskz(url);


    function getWskz(url) {
        $.getJSON(url, function (data) {

            $('.licznik_list').children().remove();
            $('.mianownik_list').children().remove();

            if (data.BdlTempItem.ingredients) {
                $.each(data.BdlTempItem.ingredients, function (key, val) {
                    remove_btn = '<button class="btn btn-xs btn-danger remove-btn hidden pull-right"><i class="icon glyphicon glyphicon-remove"></i></button>';

                    if (val.is_pos == 1) {
                        znak = '<span class="icon sign glyphicon glyphicon-plus is_pos" is_pos="1"></span>';
                    } else {
                        znak = '<span class="icon sign glyphicon glyphicon-minus  is_pos" is_pos="0"></span>';
                    }

                    if (val.is_l == 1) {
                        $(".licznik_list").append('<li value="' + val.dim_id + '" class="list-group-item">' + znak + val.nazwa + remove_btn + '</li>')
                    } else {
                        $(".mianownik_list").append('<li value="' + val.dim_id + '" class="list-group-item">' + znak + val.nazwa + remove_btn + '</li>')
                    }
                })
            }
            binding();
        });

    }

    function saveData(dane) {
        $.ajax({
            url: '/bdl/bdl_temp_items/addingredients',
            method: 'post',
            data: dane,
            success: function (res) {
                if (res == false) {
                    alert("Błąd zapisu");
                } else {
                    if (res != null) {
                        $(".temp_items .info").html('Zapisano składniki');
                        $('.temp_items .info').removeClass('hidden');
                    }
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    }


    function binding() {
        $(".skladniki_list li")
            .bind('mouseenter', function () {
                $(this).children(".remove-btn").removeClass('hidden');
            })
            .bind('mouseleave', function () {
                $(this).children(".remove-btn").addClass('hidden');
            });

        $("li>.remove-btn").bind('click', function () {
            $(this).parent('li').remove();
        });

        $(".is_pos").bind('click', function () {
            if ($(this).hasClass('glyphicon-minus')) {
                $(this).removeClass('glyphicon-minus').addClass('glyphicon-plus');
                $(this).attr('is_pos', 1);
            } else {
                $(this).removeClass('glyphicon-plus').addClass('glyphicon-minus');
                $(this).attr('is_pos', 0);
            }
        });
    }

    function makeData() {

        var skladniki = [];

        $(".licznik_list").find('li').each(function () {
            skladniki.push({
                nazwa: $(this).text(),
                dim_id: $(this).attr('value'),
                is_pos: $(this).children('.is_pos').attr('is_pos'),
                is_l: 1
            });
        });

        $(".mianownik_list").find('li').each(function () {
            skladniki.push({
                nazwa: $(this).text(),
                dim_id: $(this).attr('value'),
                is_pos: $(this).children('.is_pos').attr('is_pos'),
                is_l: 0
            });
        });

        var dane = {
            id: id,
            ingredients: skladniki
        };

        return dane;

    }

    $("#bdl_temp_savebtn").click(function () {
        var dane = makeData();
        saveData(dane);
    });

    $("#bdl_temp_save_all_btn").click(function () {
        var dane = makeData();
        saveData(dane);
            $('.temp_items').find('form').first().submit();
    });

});
