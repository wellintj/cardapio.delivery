(function ($) {
    "use strict";


    var base_url = $('#base_url').attr('href');
    var csrf_value = $('#csrf_value').attr('href');
    var shop_id = $('#id').attr('href');
    var are_you_sure = $('#are_you_sure').attr('href');
    var yes = $('#yes').attr('href');
    var no = $('#no').attr('href');


    $(function () {
        $(document).on('click', '.changeStatus', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var This = $(this);
            swal({
                title: are_you_sure,
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: yes,
                cancelButtonText: no,
                closeOnConfirm: false,
            }, function () {
                $.get(url, { 'csrf_test_name': csrf_value }, function (json) {
                    if (json.st == 1) {
                        swal({
                            title: "Success",
                            text: json.msg,
                            type: "success",
                            showCancelButton: false
                        }, function () {
                            console.log(json.status);
                            if (json.status == 'done') {
                                $('.Itemicon').html('<i class="icofont-verification-check text-success"></i>');
                                $(This).removeClass('bg-success-soft changeStatus').addClass('success-light-active');
                                $(This).attr('href', '#');
                            } else if (json.status == 'cancle') {
                                $('.Itemicon').html('<i class="icofont-close text-danger"></i>')
                                $(This).removeClass('bg-danger-soft changeStatus').addClass('danger-light-active');
                                $(This).attr('href', '#');
                            }
                        });
                    }
                }, 'json');

                return false;
            });
        });
    });



    /*----------------------------------------------
      kds order status
    ----------------------------------------------*/

    $(document).on('click', '.kdsOrder', function () {
        var id = $(this).data('id');
        var shop_id = $(this).data('shop');
        var url = $(this).attr('href');
        $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
            if (json.st == 1) {
                $('.view_kds').html(json.load_data);
            }
        }, 'json');
        return false;
    });




    $(document).on("click", ".KDSsidebarHeading", function () {
        $('.kdsSidebar').slideToggle();
    })



}(jQuery)); 