<div class="row">
    <div class="col-md-8">
        <form action="<?= base_url('admin/restaurant/add_edit_reservation') ;?>" method="post" autocomplete="off"
            class="card">
            <?php if(!empty($data['uid'])):?>
            <div class="card-header">
                <h4>#<?= $data['uid'] ;?></h4>
            </div>
            <?php endif;?>
            <!-- csrf token -->
            <?= csrf(); ?>
            <div class="card-body reservation_form">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for=""><?= lang('name'); ?> <span class="error">*</span></label>
                        <input type="text" name="name" class="form-control"
                            value="<?= !empty($data['name'])?$data['name']:''?>">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 pr-5">
                        <label for=""><?= lang('email'); ?> <span class="error">*</span></label>
                        <input type="text" name="email" class="form-control"
                            value="<?= !empty($data['email'])?$data['email']:''?>">
                    </div>

                    <div class="form-group col-md-6 pl-5">
                        <label for=""><?= lang('phone'); ?> <span class="error">*</span></label>
                        <input type="text" name="phone" class="form-control"
                            value="<?= !empty($data['phone'])?$data['phone']:''?>">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 pr-5">
                        <label for=""><?= lang('number_of_guest'); ?> <span class="error">*</span></label>
                        <input type="number" name="total_guest" class="form-control"
                            value="<?= !empty($data['total_person'])?$data['total_person']:''?>">
                    </div>

                    <div class="form-group col-md-6 pl-5">
                        <label for=""><?= lang('table_reservation'); ?> <span class="error">*</span></label>
                        <select name="is_table" id="is_table" class="form-control">
                            <option value="" <?= !empty($data['is_table']) && $data['is_table']==''?"selected":"" ;?>>
                                <?= lang('select'); ?></option>
                            <option value="1" <?= !empty($data['is_table']) && $data['is_table']==1?"selected":"" ;?>>
                                <?= lang('yes'); ?></option>
                            <option value="0" <?= !empty($data['is_table']) && $data['is_table']==0?"selected":"" ;?>>
                                <?= lang('no'); ?></option>
                        </select>
                    </div>


                </div>
                <div class="row">
                    <div class="form-group col-md-6 pr-5">
                        <label for=""><?= lang('reservation_date'); ?> <span class="error">*</span></label>
                        <div class="ci-input-group" id="datetimepicker1" data-target-input="nearest">
                            <input type="text" name="reservation_date" class="form-control datetimepicker"
                                data-target="#datetimepicker-1"
                                data-input="<?= !empty($data['reservation_date'])?$data['reservation_date']:''?>"
                                value="<?= !empty($data['reservation_date'])?$data['reservation_date']:''?>" />
                            <div class="input-group btn btn btn-secondary" data-target="#datetimepicker-1"
                                data-toggle="datetimepicker">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>

                    </div>
                    <div class="form-group col-md-6 pl-5">
                        <label for=""><?= lang('reservation_type'); ?> <span class="error">*</span></label>
                        <select name="reservation_type" class="form-control">
                            <option value=""><?= lang('select');?></option>
                            <?php foreach ($reservation_types as $key => $row): ?>
                            <option value="<?= $row['id'] ;?>"
                                <?= !empty($data['reservation_type']) && $data['reservation_type']==$row['id']?"selected":"" ;?>>
                                <?= html_escape($row['name']) ;?>
                            </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for=""><?= lang('any_special_request'); ?></label>
                        <textarea name="comments" id="comments" class="form-control" cols="5"
                            rows="5"><?= !empty($data['comments'])?$data['comments']:''?></textarea>
                    </div>
                </div>

            </div>
            <div class="card-footer  space-between">
                <a href="<?= base_url("admin/restaurant/reservation_list");?>" class="btn btn-default"><i
                        class="fa fa-arrow-left"></i> <?= lang('back');?></a>
                <input type="hidden" name="shop_id"
                    value="<?= !empty($data['shop_id'])?$data['shop_id']:restaurant()->id?>">
                <input type="hidden" name="id" value="<?= !empty($data['id'])?$data['id']:0?>">
                <input type="hidden" name="uid" value="<?= !empty($data['uid'])?$data['uid']:''?>">
                <button type="submit" class="btn btn-secondary"><?= lang('submit'); ?></button>
            </div>
        </form>
    </div>

    <?php if(!empty($data)): ?>
    <div class="col-md-4">
        <form action="<?= base_url("admin/restaurant/send_mail/reservation");?>" method="post" class="ajaxForm">
            <?= csrf() ;?>
            <div class="card">
                <div class="card-header">
                    <h4>#<?= !empty($data['uid'])?$data['uid']:'';?> <?= lang('message');?> </h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><?= lang('email');?></label>
                        <input type="email" name="email" class="form-control"
                            value="<?= !empty($data['email'])?$data['email']:''?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for=""><?= lang('subject');?> <span class="error">*</span></label>
                        <input type="text" name="subject" class="form-control" placeholder="<?= lang('subject');?>">
                    </div>
                    <div class="from-group">
                        <label for=""><?= lang('message');?> <span class="error">*</span></label>
                        <div class="">
                            <textarea name="message" class="form-control data_textarea" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="from-group">

                        <div class="">
                            <label class="custom-checkbox"><input type="checkbox"
                                    name="is_mail"><?= lang('mail_change_details');?></label>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <input type="hidden" name="id" value="<?= auth('id');?>">
                    <input type="hidden" name="uid" value="<?= !empty($data['uid'])?$data['uid']:'';?>">
                    <button type="submit" name="button" class="btn btn-success btn-block"><?= lang('submit');?></button>
                </div>
            </div>
        </form>
    </div>
    <?php endif;?>
</div>