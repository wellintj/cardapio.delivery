 <ul>
     <?php foreach ($message_list as  $key => $row) : ?>
         <?php if (auth('id') == $row->receiver_id) : ?>
             <li class="sent">
                 <img src="<?= avatar($row->thumb);?>" alt="" />
                 <p><?= $row->message;?></p>
             </li>
         <?php else : ?>
             <li class="replies">
                  <img src="<?= avatar($row->thumb);?>" alt="" />
                 <p><?= $row->message;?></p>
             </li>
         <?php endif; ?>
     <?php endforeach; ?>

 </ul>