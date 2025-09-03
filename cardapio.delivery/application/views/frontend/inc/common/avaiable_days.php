 <?php $my_days = $this->common_m->get_single_appoinment($key, restaurant($id)->id); ?>
 <?php $getTimes = $this->admin_m->get_time_config(@$my_days['id']); ?>
 <?php if (isset($my_days['is_24']) && html_escape($my_days['is_24']) == 1) : ?>
     <li>
         <div class="flexTime">
             <div class="timeLeft <?= $available_type??'closeTime'?>">
                 <span><?= !empty(lang($day)) ? lang($day) : $day; ?></span>
             </div>
             <div class="timeRight">
                 <div class="timeRightTop">
                     <span class="timeFormat"><i class="icofont-wall-clock"></i> &nbsp;<?= lang('open_24_hours'); ?></span>
                 </div>
             </div>
         </div>
         <?php if (isset($shop_info->available_type) && $shop_info->available_type == 'close') : ?>
             <div class="timeRightBottom">
                 <?php if (isset($getTimes) && !empty($getTimes)) : ?>
                     <?php foreach ($getTimes as  $keys => $times) : ?>
                         <span class="breakTime"> <i class="icofont-close-line text-danger "></i> <span class="stime"><?= time_format($times->start_time, $shop_id); ?> </span> <i class="icofont-long-arrow-right"></i> <span class="etime"><?= time_format($times->end_time, $shop_id); ?></span></span>
                     <?php endforeach; ?>
                 <?php endif; ?> <!-- getTimes -->
             </div>
         <?php endif; ?>
     </li>
 <?php else : ?>
     <?php if (isset($my_days['days']) && html_escape($my_days['days']) == $key) : ?>

         <li>
             <div class="flexTime">
                 <div class="timeLeft <?= $available_type??'closeTime'?>">
                     <span><?= !empty(lang($day)) ? lang($day) : $day; ?></span>
                 </div>
                 <div class="timeRight <?= isset($shop_info->available_type) ? $shop_info->available_type : ''; ?>">
                     <div class="timeRightTop">
                         <span class="timeFormat"><i class="icofont-wall-clock"></i> &nbsp; <span class="stime"><span><?= time_format($my_days['start_time'], restaurant($id)->id); ?></span> <span class="icofont-long-arrow-right timeArrow"></span> <span><?= time_format($my_days['end_time'], restaurant($id)->id); ?></span></span></span>
                     </div>

                     <?php if (isset($shop_info->available_type) && $shop_info->available_type == 'open') : ?>
                         <?php if (isset($getTimes) && !empty($getTimes)) : ?>
                             <?php foreach ($getTimes as  $keys => $times) : ?>
                                 <div class="timeRightTop">
                                     <span class="timeFormat"><i class="icofont-wall-clock"></i> &nbsp; <span class="stime"><span><?= time_format($times->start_time, $shop_id); ?></span> <span class="icofont-long-arrow-right timeArrow"></span> <span><?= time_format($times->end_time, $shop_id); ?></span></span></span>
                                 </div>
                             <?php endforeach; ?>
                         <?php endif; ?>
                     <?php endif; ?>
                 </div>
             </div>

             <?php if (isset($shop_info->available_type) && $shop_info->available_type == 'close') : ?>
                 <div class="timeRightBottom">
                     <?php if (isset($getTimes) && !empty($getTimes)) : ?>
                         <?php foreach ($getTimes as  $keys => $times) : ?>
                             <span class="breakTime"> <i class="icofont-close-line text-danger "></i> <span class="stime"><?= time_format($times->start_time, $shop_id); ?> </span> <i class="icofont-long-arrow-right"></i> <span class="etime"><?= time_format($times->end_time, $shop_id); ?></span></span>
                         <?php endforeach; ?>
                     <?php endif; ?> <!-- getTimes -->
                 </div>
             <?php endif; ?>
         </li>
     <?php else : ?>

         <li>
             <div class="flexTime">
                 <div class="timeLeft <?= $available_type??'closeTime'?>">
                     <span><?= !empty(lang($day)) ? lang($day) : $day; ?></span>
                 </div>
                 <div class="timeRight">
                     <div class="timeRightTop">
                         <span class="timeFormat"><i class="icofont-close-line c_red"></i> &nbsp; <?= lang('close'); ?></span>
                     </div>
                 </div>
             </div>
             <div class="timeRightBottom">
             </div>
         </li>

     <?php endif; ?>
 <?php endif; ?>
 <?php $i++; ?>
