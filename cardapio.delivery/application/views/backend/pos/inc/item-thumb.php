<div class="row">
	<div class="col-md-12 mt-10">
		<div class="productareas row">
			<?php if (isset($is_item) && $is_item == 1) : ?>
				<?php include 'item-thumbs.php'; ?>
			<?php else : ?>
				<?php include 'package-thumb.php'; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="row text-center">
	<div class="ci-paginationArea">
		<div class="ci-pagination-link">
			<div id="pagination"><?= $this->pagination->create_links(); ?></div>
		</div>
	</div>
</div>





<!-- Modal -->
<div id="itemModal" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document" id="item_details">


	</div>
</div>