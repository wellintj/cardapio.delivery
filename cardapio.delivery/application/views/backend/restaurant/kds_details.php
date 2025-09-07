<?php include "inc/kds_order_thumb.php";?>
<script type="text/javascript">
var text = '<?= lang('remaining') ;?>';
$(".get_time").each(function(i, e) {
    var id = $(this).data('id');
    var time = $(this).data('time');
    var countDownDate = new Date(time).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        if (days > 0) {
            $('#show_time_' + id).html(text + ': ' + days + "d " + hours + "h " + minutes + "m " +
                seconds + "s ");
            $('#preparingTime_' + id).slideDown();

        } else if (hours > 0) {
            $('#show_time_' + id).html(text + ': ' + hours + "h " + minutes + "m " + seconds + "s ");
            $('#preparingTime_' + id).slideDown();

        } else if (minutes > 0) {
            $('#show_time_' + id).html(text + ': ' + minutes + "m " + seconds + "s ");
            $('#preparingTime_' + id).slideDown();

        } else if (seconds > 0) {
            $('#show_time_' + id).html(text + ': ' + seconds + "s ");
            $('#preparingTime_' + id).slideDown();
        } else {
            $('#show_time_' + id).html('');
            $('#preparingTime_' + id).slideUp();
        }


        if (distance < 0) {
            clearInterval(x);
            $('#show_time_' + id).html('');
            $('#preparingTime_' + id).slideUp();
        }
    }, 1000);
});
</script>