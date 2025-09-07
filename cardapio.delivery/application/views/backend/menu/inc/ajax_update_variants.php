<?php $get_price = !empty($data['price']) && isJson($data['price'])?json_decode($data['price']):''; ?>
<?php if(isset($get_price->variant_name) && !empty($get_price->variant_name)): ?>
<div class="table-responsive">
	<table class="table table-bordered table-striped mb-0">
		<thead>
			<tr>
				<th><?= $get_price->variant_name;?></th>
				<th><?= lang('price');?></th>
			</tr>
		</thead>
		<tbody>
			 <?php foreach ($get_price->variant_options as $key => $v): ?>
				<tr>
					<td><input type="text" class="form-control" name="variants[<?= $key;?>][name]" value="<?= $v->name;?>"></td>
					<td><input type="text" class="form-control number" name="variants[<?= $key;?>][price]" value="<?= $v->price;?>"></td>
				</tr>
				<input type="hidden" name="variants[<?= $key;?>][slug]" value="<?= $v->slug;?>">
			<?php endforeach ?>
			<input type="hidden" name="variant_name" value="<?= $get_price->variant_name??'untitled';?>">
		</tbody>
	</table>
</div>
<?php endif; ?>