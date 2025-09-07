<div class="table-responsive">
	<table class="table table-bordered table-striped mb-0">
		<thead>
			<tr>
				<th><?= $variant_name;?></th>
				<th><?= lang('price');?></th>
			</tr>
		</thead>
		<tbody>
			 <?php foreach ($variant_options as $key => $v): ?>
				<tr>
					<td><input type="text" class="form-control" name="variants[<?= $key;?>][name]" value="<?= $v;?>"></td>
					<td><input type="text" class="form-control number" name="variants[<?= $key;?>][price]"></td>
				</tr>
				<input type="hidden" name="variants[<?= $key;?>][slug]" value="slug_<?= $key;?>">
			<?php endforeach ?>
			<input type="hidden" name="variant_name" value="<?= $variant_name??'untitled';?>">
		</tbody>
	</table>
</div>