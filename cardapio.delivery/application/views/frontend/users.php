<div class="users_section homeSection mt-150">

	<div class="container">
		<form action="<?= base_url('home/users'); ?>" method="get" class="searchForm">
			<div class="formAreasearch">
				<div class="leftSearch">
					<div class="singleSearchUser">
						<h4><?= $this->common_m->count_total_user(); ?></h4>
						<p><?= !empty(lang('restaurants')) ? lang('restaurants') : "Restaurants"; ?></p>
					</div>
				</div>
				<div class="rightSearch">
					<div class=" custom-col">
						<div class=" user_right_btn_area">
							<input type="text" class="form-control" name="username" placeholder="<?= lang('search_with_username'); ?>" value="<?= isset($_GET['username']) ? $_GET['username'] : ""; ?>">
						</div>
					</div>

					<div class="custom-col hidden">
						<div class="user_right_btn_area">
							<select name="country" id="" class="form-control">
								<option value=""><?= lang('location'); ?></option>
								<option <?= isset($_GET['country']) && $_GET['country'] == 'all' ? "selected" : ""; ?> value=""><?= lang('all'); ?></option>
								<?php foreach ($countries as $key => $con) : ?>
									<option <?= isset($_GET['country']) && $_GET['country'] == $con['code'] ? "selected" : ""; ?> value="<?= $con['code']; ?>"> <?= $con['name']; ?> </option>
								<?php endforeach ?>
							</select>

						</div>
					</div>

					<div class=" custom-col">
						<div class="user_right_btn_area">
							<button type="submit" class="btn btn-primary c_btn"><i class="icofont-search-user"></i> <?= lang('search'); ?></button>

						</div>
					</div>

					<div class="custom-col">
						<div class="user_right_btn_area">
							<?php if ($this->admin_m->count_table('shop_location_list') > 0) : ?>
								<div class="findNearbys">
									<button type="button" class="btn btn-secondary c_btn" id="getLocation"><i class="icofont-google-map"></i> <?= lang('near_me'); ?></button>
								</div>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="restaurantList " id="shopList">
			<div class="row mt-20">
				<?php foreach ($users as $key => $row) : ?>
					<?php include VIEWPATH . "frontend/inc/shop_thumb.php"; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="row text-center">
			<div class="php-pagination">
				<?= $this->pagination->create_links();; ?>
			</div>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="qrImage">
					<img src="" alt="qrcode" class="Qrcode">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('ok'); ?></button>
			</div>
		</div>
	</div>
</div>


<script>
	function openQrcode(qr) {
		$('.Qrcode').attr('src', qr);
		$('#qrModal').modal('show');
	}
</script>