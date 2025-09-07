<?php 
	if(isset($data) && !empty($data) && is_array($data)):
		$data = $data;
	else:
		$data = ['language'=>site_lang()];
	endif;

	if(isset($data['language']) && $data['language']==site_lang()){
		$site_ln = site_lang();
	}else{
		$site_ln = site_lang();
	}

 ?>
<select name="language" class="form-control <?= isset($is_prevent) && $is_prevent==1?"pointerEvent":'';?>" required >
	<?php foreach (shop_languages(auth('id')) as $key => $language): ?>
		<option value="<?= $language->slug ;?>" <?= isset($site_ln) && $site_ln==$language->slug?"selected":"" ;?>><?= $language->lang_name ;?></option>
	<?php endforeach;?>

</select>