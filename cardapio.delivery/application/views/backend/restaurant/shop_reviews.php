<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header"> <?= lang('shop_reviews');?> <h4 class="m-0 mr-5"> </h4></div>
			<div class="card-body p-5">
				<div class="card-content">
					<div class="shopReviews">
						<ul>
							<?php foreach ($review_list as $row): ?>
								<li>
									<div class="ratingArea">
										<div  class="ratingInfo">
											<a href="<?= url($row['username']);?>" target="blank">
												<h5><?= !empty($row['name'])?$row['name']:$row['username'];?></h5>
												<p><?= lang('by');?> : <?= $row['customer_name'];?></p>
											</a>

											<div class="ratings">
												<span class="ratings"><?= $row['customer_rating'];?></span> 
												<div class="star_area">
													<?php for ($i=1; $i <=5 ; $i++) { ?>
														<?php if($i > $row['customer_rating']): ?>
															<i class="fa fa-star-o"></i>
														<?php else: ?>
															<i class="fa fa-star"></i>
														<?php endif;?>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="comments">
											<p><?= $row['customer_review'];?></p>
										</div>
									</div>
									
								</li>	
							<?php endforeach ?>
						</ul>
					</div>
				</div><!-- card-content -->
			</div><!-- card-body -->
			
		</div><!-- card -->
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="author_rating card-body">
				<?php $avg = $total_rating!=0 ?number_format($total_rating/$total_review,1):0; ?>
				<h4><?= !empty(lang('rating'))?lang('rating'):'Rating' ;?> <span class="jstars" data-value="<?= $avg ;?>" data-total-stars="5" data-color="#FF912C" data-empty-color="#ddd" data-size="25px"></span></h4>
				<p><?= $avg ;?> <?= !empty(lang('average_based_on'))?lang('average_based_on'):'average based on' ;?>  <?=  $total_review;?> <?= !empty(lang('rating'))?lang('rating'):'Rating' ;?>.</p>
			</div>
		</div>
	</div>
</div>

<script src="<?= asset_url()?>assets/frontend/plugins/jstars.js" defer="true"></script>