<?php if(is_feature($id,'reservation')==1 && is_active($id,'reservation')): ?>
<section class="sectionDefault">
    <?php include "include/banner.php"; ?>
    <?php include APPPATH."views/layouts/reservation_form.php";?>
</section>
<?php endif;?>