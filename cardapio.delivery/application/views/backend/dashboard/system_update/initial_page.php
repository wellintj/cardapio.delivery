<style>
	.updateAlert p {
		margin: 0;
		padding: 0;
	}
</style>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">New Version Installer</h4>
</div>
<div class="modal-body text-center">
	<div class="modalBody">
		<h4><i class="fa fa-smile-o fa-3x"></i></h4>
		<h4>A New Version Found v<?= $this->config->item('app_version'); ?></h4>
		<p class="text-muted">Currently You are using Version v<?= settings()['version']; ?></p>

		<div class="updateAlert">
			<p>* Make sure you have backup your database and files <a href="<?= base_url("admin/settings/app_info"); ?>"><u>click here for backup your database</u></a></p>
			<p class="text-purple">* We have changed database table for customer. We have merge customer's information for pos and online order.</p>
			<?php if ($this->config->item('app_version') <= '3.1.9'): ?>
				<hr>
				<p><b>Version: 3.1.9</b></p>
				<p class="text-danger mb-5"> - we have changed the addons/Extras for an item. after update this script every restaurant have to update their product/items addons/extras</p>
				<p class="text-purple"> - After update you have to add Cities for your restaurant/shops and delivery boys. <code>admin > home > cities</code></p>
				<label class="custom-checkbox"> <input type="checkbox" name="approve" value="1"> Agree with the terms of <b> version 3.1.9</b> </label>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="modal-footer" style="display:none;">
	<button type="button" class="btn btn-primary startUpdate" data-update="1" <?= $this->config->item('app_version') <= '3.1.9'?"disabled":"";?>>Start Updating</button>
</div>

<script>
	$(document).on("change", "[name='approve']", function() {
		if ($(this).is(":checked") && $(this).val() == 1) {
			$('.startUpdate').prop('disabled', false);
		} else {
			$('.startUpdate').prop('disabled', true);
		}
	});
</script>