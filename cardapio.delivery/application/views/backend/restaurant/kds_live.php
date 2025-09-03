<link rel="stylesheet" href="<?= asset_url("public/admin/kds.css")?>?t=<?= time();?>">
<a href="<?= lang('are_you_sure');?>" id="are_you_sure"></a>
<a href="<?= lang('yes');?>" id="yes"></a>
<a href="<?= lang('no');?>" id="no"></a>
<div class="section_kds" style="background-color: #f2f2f2;">
    <div class="container-fluid">
        <div class="kds_shop_area">
            <div id="kdsView">
                <div class="view_kds">
                    <?php include 'inc/kds_order_thumb.php'; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="pinModal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang('kds_pin');?></h4>
            </div>
            <form action="<?= base_url("admin/kds/check_pin/{$id}");?>" method="post" class="kds-form-submit">
                <?= csrf();?>
                <div class="modal-body">
                    <span class="reg_msg"></span>
                    <div class="form-group">
                        <label for=""><?= lang('enter_pin');?></label>
                        <input type="text" name="kds_pin" id="" class="form-control"
                            placeholder="<?= lang('enter_pin');?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary submit_btn"><?= lang('submit');?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<style>
#pinModal .modal-backdrop {
    background-color: gray !important;
    opacity: 0.9;
}

#pinModal.modal {
    background-color: rgba(255, 255, 255, .9) !important;
}
</style>
<a href="<?php echo asset_url() ?>" id="base_url"></a>
<a href="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>
<a href="<?php echo $id; ?>" id="id"></a>




<?php if(shop($id)->is_kds_pin==1): ?>
<?php if(auth('is_kds_login')==1): ?>
<?php else: ?>
<script>
$(document).ready(function() {
    $('#pinModal').modal('show');
});
</script>
<?php endif ?>
<?php endif ?>
<script src="<?php echo asset_url()?>public/admin/kds_pusher.js?v=<?= settings()['version'];?>&time=<?= time();?>"></script>