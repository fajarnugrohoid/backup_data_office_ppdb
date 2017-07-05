<?php
	$features = get_post_meta(get_the_id(), 'additional_features', true);
	$features = explode(',', $features);
?>


<?php if(!empty($features)): ?>
	<div class="stm-single-listing-car-features">
		<div class="lists-inline">
			<ul class="list-style-2" style="font-size: 13px;">
				<?php foreach($features as $key=>$feature): ?>
				<?php if($key%4 == 0 and $key !=0): ?>
					</ul><ul class="list-style-2" style="font-size: 13px;">
				<?php endif; ?>
					<li><?php echo esc_attr($feature); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>