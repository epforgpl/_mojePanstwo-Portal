$(document).ready(function () {

    var wsk_id;
    var dim_name;
    var dim_id;

    function getWskz(url) {
        $.getJSON(url, function (data) {
            $('#bdl_user_wskaznik_modal .nazwa_wskaznika').html('<h3 class="text-center">' + data.BdlTempItem.tytul + '</h3>');

            $('.licznik_list').children().remove();
            $('.mianownik_list').children().remove();

            if (data.BdlTempItem.ingredients) {
                $.each(data.BdlTempItem.ingredients, function (key, val) {
                    remove_btn = '<button class="btn btn-xs btn-danger remove-btn hidden pull-right"><i class="icon glyphicon glyphicon-remove"></i></button>';

                    if (val.is_pos == 1) {
                        znak = '<span class="icon glyphicon glyphicon-plus is_pos" is_pos="1"></span>';
                    } else {
                        znak = '<span class="icon glyphicon glyphicon-minus  is_pos" is_pos="0"></span>';
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

    function pullList(on_success) {
        $.ajax({
            url: '/bdl/bdl_temp_items/listall',
            method: 'post',
            success: function (res) {
                if (res == false) {
                    alert("Błąd pobierania danych");
                } else {
                    if (res != null) {
                        $('#lista_wskaznikow').children().remove();

                        $.each(res, function (key, val) {
                            $('<option>').val(key).text(val).appendTo('#lista_wskaznikow');
                            wsk_id = key;
                        })
                        $('#lista_wskaznikow option:last').attr('selected', 'selected');
                        on_success();
                    }
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        })
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
                        $("#bdl_user_wskaznik_modal .info").html('Zapisano wskaźnik');
                        $('#bdl_user_wskaznik_modal .info').removeClass('hidden');
                    }
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    }


    function binding() {
        $("#bdl_user_wskaznik_modal li")
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
            if($(this).hasClass('glyphicon-minus')) {
                $(this).removeClass('glyphicon-minus').addClass('glyphicon-plus');
                $(this).attr('is_pos', 1);
            }else{
                $(this).removeClass('glyphicon-plus').addClass('glyphicon-minus');
                $(this).attr('is_pos', 0);
            }
        });
    }

    $("#bdl_temp_savebtn").click(function () {


        console.log('ABBB');
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
            id: $('#lista_wskaznikow').val(),
            ingredients: skladniki
        };
        saveData(dane);
    });

    $("#bdl_temp_cancelbtn").click(function () {
        $("#bdl_user_wskaznik_modal").modal('hide');
    });

    $(".add_to_item").click(function () {
        pullList(function () {
            var url = '/bdl/bdl_temp_items/' + wsk_id;
            getWskz(url);
            $("#bdl_user_wskaznik_modal").modal('show');
        });


        $("#bdl_temp_addbtn_m").removeClass('hidden');
        $("#bdl_temp_addbtn_l").removeClass('hidden');

        dim_name = $(this).parent().children('a').text();
        dim_id = $(this).parent().parent().attr('data-dim_id');
    })

    $("#bdl_temp_addbtn_m").click(function () {
        $("#bdl_temp_addbtn_m").addClass('hidden');
        $("#bdl_temp_addbtn_l").addClass('hidden');
        $(".mianownik_list").append('<li value="' + dim_id + '" class="list-group-item"><span class="icon glyphicon glyphicon-plus  is_pos" is_pos="1"></span> ' + dim_name + '<button class="btn btn-xs btn-danger remove-btn hidden pull-right"><i class="icon glyphicon glyphicon-remove"></i></button></li>')
        binding();
    });

    $("#bdl_temp_addbtn_l").click(function () {
        $("#bdl_temp_addbtn_m").addClass('hidden');
        $("#bdl_temp_addbtn_l").addClass('hidden');
        $(".licznik_list").append('<li value="' + dim_id + '" class="list-group-item"><span class="icon glyphicon glyphicon-plus  is_pos" is_pos="1"></span> ' + dim_name + '<button class="btn btn-xs btn-danger remove-btn hidden pull-right"><i class="icon glyphicon glyphicon-remove"></i></button></li>')
        binding();
    });

    $("#lista_wskaznikow").change(function () {

        var id = $(this).val();
        var url = '/bdl/bdl_temp_items/' + id;
        getWskz(url);

        $("#bdl_temp_addbtn_m").removeClass('hidden');
        $("#bdl_temp_addbtn_l").removeClass('hidden');

    });


});