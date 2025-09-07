 <?php $days = get_days(); ?>
 <?php $available_type = isset($shop['available_type']) ? $shop['available_type'] : 'close'; ?>
 <?php if (isset($days) && !empty($days)) : ?>
 <?php $icon = isset($available_type) && $available_type == 'open' ? 'icofont-wall-clock' : 'icofont-close-line text-danger'; ?>
 <!-- Modal -->
 <div class="modal fade" id="availableDays" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title"><?= lang('available_days'); ?></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body pt-5">
                <div class="availableDayList">
                    <?php $i = 0;
                    foreach ($days as $key => $day) : ?>
                     <?php $my_days = $this->common_m->get_single_appoinment($key, $shop_id); ?>
                     <?php $getTimes = $this->admin_m->get_time_config(@$my_days['id']); ?>
                     <div class="singleDayList <?= $available_type; ?>Time">
                         <?php if (isset($my_days['is_24']) && html_escape($my_days['is_24']) == 1) : ?>
                         <div class="initialTime">
                             <span><b> <i class="icofont-check-alt text-success "></i> <?= !empty(lang($day)) ? lang($day) : $day; ?></b></span>
                             <span><i class="icofont-wall-clock"></i> <?= lang('open_24_hours'); ?></span>
                         </div>
                         <?php if (isset($getTimes) && !empty($getTimes) && $available_type == 'close') : ?>
                         <ul>
                             <?php foreach ($getTimes as  $keys => $times) : ?>
                                 <li>
                                     <div class="breakTime">
                                         <i class="<?= $icon; ?> "></i> <span class="stime"><?= time_format($times->start_time, $shop_id); ?></span> <i class="icofont-long-arrow-right"></i> <span class="etime"><?= time_format($times->end_time, $shop_id); ?></span>
                                     </div>
                                 </li>
                             <?php endforeach; ?>
                         </ul>
                         <?php endif; ?> <!-- getTimes -->
                     <?php else : ?>

                         <?php if (isset($my_days['days']) && $my_days['days'] == $key) : ?>
                             <div class="initialTime">
                                 <span><b><i class="icofont-check-alt text-success "></i> <?= !empty(lang($day)) ? lang($day) : $day; ?></b></span>
                                 <span> <i class="icofont-wall-clock"></i> <?= time_format($my_days['start_time'], $shop_id); ?> - <?= time_format($my_days['end_time'], $shop_id); ?></span>

                             </div>
                             <?php if (isset($getTimes) && !empty($getTimes)) : ?>
                             <ul>
                                 <?php foreach ($getTimes as  $keys => $times) : ?>
                                     <li>

                                         <div class="breakTime">
                                             <i class="<?= $icon; ?> "></i> <span class="stime"><?= time_format($times->start_time, $shop_id); ?></span> <i class="icofont-long-arrow-right"></i> <span class="etime"><?= time_format($times->end_time, $shop_id); ?></span>
                                         </div>
                                     </li>
                                 <?php endforeach; ?>
                             </ul>
                             <?php endif; ?> <!-- getTimes -->
                         <?php else : ?>
                             <div class="initialTime">
                                 <span><b><i class="<?= $icon; ?> "></i> <?= !empty(lang($day)) ? lang($day) : $day; ?></b></span>
                                 <span class="text-danger"> <?= lang('close'); ?></span>

                             </div>
                         <?php endif; ?>
                     <?php endif; ?>
                 </div>

             <?php endforeach; ?>
         </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><?= lang('close'); ?></button>
     </div>
 </div>
</div>
</div>

<script>
         // $(document).ready(function() {
         //      $('#availableDays').modal('show');
         // });
</script>
<?php endif; ?>