<?php 
    $_id = isset($shop_id)?$shop_id:0;
    if(isset($_id) && !empty($_id)){
      $reject_reason = $this->admin_m->get_vendor_reason_list($_id,$type);
    }else{
      $reject_reason = [];
    }
 ?>
<div id="reasonModal" class="modal fade customModal" role="dialog" class="customModal">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <form action="" method="post" id="ajaxAccept" class="rejectUrl">
      <?= csrf();?>
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?= lang('reject_reasons');?></h4>
        </div>
        <div class="modal-body pb-5">
          <div class="rejectReason">
            <?php if(sizeof($reject_reason) > 0): ?>
              <ul>
                <?php foreach ($reject_reason as $reason): ?>
                  <li>
                    <label class="custom-checkbox"><input type="checkbox" name="reason_id[]" value="<?= $reason->id;?>"> <?= $reason->title;?></label>
                  </li>
                <?php endforeach ?>
              </ul>
            <?php endif; ?>

            <div class="form-group mt-10">
              <textarea name="reason_msg" id="reason_msg" class="form-control" cols="5" rows="5" placeholder="<?= lang('comments');?>"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
          <button type="submit" class="btn btn-success"><?= lang('submit');?></button>
        </div>
      </div>
    </form>

  </div>
</div>

<script>
  $(document).on('click','.rejectModal',function(){

    var url = $(this).data('url');
    var isAjax = $(this).data('ajax');
    if(isAjax==0 || isAjax==undefined){
      $('.rejectUrl').removeAttr('id');
    }
    $('#reasonModal').modal('show');
    $('.rejectUrl').attr('action',url);
  });
</script>