
<div class="singleItemDetails">
	<div class="container">
		<div class="itemDetailsMenu">
			<ul>
				<li>
					<a href="<?= url($slug) ;?>"><i class="fa fa-arrow-left"></i> <?= lang('back');?></a>
				</li>
			</ul>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="singleItemDetailsBody">
					<?php $this->load->view('layouts/inc/item_details_thumb_2', ['is_close'=>0]); ?>
				</div>
			</div>
		</div>
	</div>
</div>

