$(function () {
    /* auto complete */
    $("#tags").autocomplete({
        source: "ajax/pelanggan.php",
        minLength: 2,
        select: function (event, ui) {
            $("#tags").val(ui.item.value);
            $("#search-pelanggan").attr("idPlg", ui.item.id);
        }
    });

    $('#tags').click(function () {
        $('#tags').val('');
        $("#search-pelanggan").attr("idPlg", '');
    });

    $('#search-pelanggan').click(function () {
        var Plg = $(this).attr("idPlg");
        $.ajax({
            url: "ajax/profile_plg.php"
            , type: 'POST'
            , data: {idPlg: Plg}
            , success: function (result) {
                $('#ajax-form').html(result);
            }
        });
    });

});

function form_register() {
    $.ajax({
        url: "ajax/register.php"
        , type: 'POST'
        , data: {Plg: $('#tags').val()}
        , success: function (result) {
            $('#ajax-form').html(result);
        }
    });
}

function antri_cs(id_client,id_pegawai) {

var keperluan=$('#kep-cs-'+id_client).val();

    $.ajax({
        url: "ajax/module/antri_cs.php"
        , type: 'POST'
        , data: {id_client: id_client,id_pegawai:id_pegawai,keperluan:keperluan}
        , success: function (result) {
          
            var status = parseInt(result);
            if (status == 1) {
                $.gritter.add({
                    title: 'Message',
                    text: 'Input data Berhasil',
                    class_name: 'growl-primary',
                    image: 'images/screen.png',
                    sticky: false,
                    time: ''
                });
                return false;
            } else {
                $.gritter.add({
                    title: 'Message',
                    text: 'Input data Gagal (data sebelumnya sudah diinput)',
                    class_name: 'growl-danger',
                    image: 'images/screen.png',
                    sticky: false,
                    time: ''
                });
                return false;
            }

        }
    });

}

function clearreseptionis(id_antrian,cf){
    //alert(id_client);
    window.location.href='index.php?proses_status=clear&id_antrian='+id_antrian+'&table='+cf;
}

function antri_fiting(id_client,id_pegawai) {
    var keperluan=$('#kep-cs-'+id_client).val();
    $.ajax({
        url: "ajax/module/antri_fitting.php"
        , type: 'POST'
        , data: {id_client: id_client,id_pegawai:id_pegawai,keperluan:keperluan}
        , success: function (result) {
            //$('#ajax-form').html(result);

            var status = parseInt(result);
            if (status == 1) {
                $.gritter.add({
                    title: 'Message',
                    text: 'Input data Berhasil',
                    class_name: 'growl-primary',
                    image: 'images/screen.png',
                    sticky: false,
                    time: ''
                });
                return false;
            } else {
                $.gritter.add({
                    title: 'Message',
                    text: 'Input data Gagal (data sebelumnya sudah diinput)',
                    class_name: 'growl-danger',
                    image: 'images/screen.png',
                    sticky: false,
                    time: ''
                });
                return false;
            }

        }
    });

}