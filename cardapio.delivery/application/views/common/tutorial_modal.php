
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?= $tutorial['title']??'';?></h4>
	</div>
	<div class="modal-body tutorialModalContent">
		<?= $tutorial['details']??'';?>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
