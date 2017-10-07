 $(function () {
        $('#datepickersss').datepicker();
        $('select option:first-child').text('');

        $("select").select2({
            minimumResultsForSearch: -1
        });

        $('#valWizard').bootstrapWizard({
            onTabShow: function (tab, navigation, index) {
                tab.prevAll().addClass('done');
                tab.nextAll().removeClass('done');
                tab.removeClass('done');

                var $total = navigation.find('li').length;
                var $current = index + 1;

                if ($current >= $total) {
                    $('#valWizard').find('.wizard .next').addClass('hide');
                    $('#valWizard').find('.wizard .finish').removeClass('hide');
                } else {
                    $('#valWizard').find('.wizard .next').removeClass('hide');
                    $('#valWizard').find('.wizard .finish').addClass('hide');
                }
            },
            onTabClick: function (tab, navigation, index) {
                return false;
            },
            onNext: function (tab, navigation, index) {
                var $valid = $('#valWizard').valid();
                if (!$valid) {
                    $validator.focusInvalid();
                    return false;
                }
            }
        });

        // Wizard With Form Validation
        var $validator = $("#valWizard").validate({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });


        $('.panel-wizard').submit(function () {
        var Ncpw=$('#Ncpw').val()
           ,rtu_cpw=$('#rtu_cpw').val()
           ,tlp_cpw=$('#tlp_cpw').val()
           ,hp_cpw=$('#hp_cpw').val()
           ,alamat_cpw=$('#alamat_cpw').val()
           
           ,Ncpp=$('#Ncpp').val()
           ,ortu_cpp=$('#ortu_cpp').val()
           ,tlp_cpp=$('#tlp_cpp').val()
           ,hp_cpp=$('#hp_cpp').val()
           ,alamat_cpp=$('#alamat_cpp').val()
           ,datepickersss=$('#datepickersss').val()
           
           ,email=$('#email').val()
           ,facebook=$('#facebook').val()
           ,twitter=$('#twitter').val()
           ,catatan=$('#catatan').val()
           ,petugas=$('#petugas').val()
           ,sts_aktif=$('#sts_aktif').val()
           ;    
        
            $.ajax({
                url: "ajax/module/register.php"
                , type: 'POST'
                , data: {
                    Ncpw: Ncpw,rtu_cpw:rtu_cpw,tlp_cpw:tlp_cpw,hp_cpw:hp_cpw,alamat_cpw:alamat_cpw
                   ,Ncpp:Ncpp,ortu_cpp:ortu_cpp,tlp_cpp:tlp_cpp,hp_cpp:hp_cpp,alamat_cpp:alamat_cpp,datepickersss:datepickersss
                   ,email:email,facebook:facebook,twitter:twitter,catatan:catatan,petugas:petugas,sts_aktif:sts_aktif 
                }
                , success: function (result) {
                    var status = parseInt(result);
                    if(status==1){
                        alert('Data berhasil di input !!!');
                        location.reload();
                    }else{
                        alert('Data Gagal di input !!!');
                        return false;
                    }
                     

                }
            });
         return false;

           //alert('This will submit the form wizard');
           // return false // remove this to submit to specified action url
        });
    });