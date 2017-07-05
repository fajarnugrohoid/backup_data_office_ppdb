<div class="stm-no-available-adds-overlay hidden"></div>
<div class="stm-no-available-adds hidden">
	<h3><?php esc_html_e('Posts Available:', 'motors'); ?> <span>0</span></h3>
	<p><?php esc_html_e('Your reached the limit of ads. Please upgrade your plan.', 'motors'); ?></p>
	<?php $stm_pricing_link = stm_pricing_link();
	if(!empty($stm_pricing_link)): ?>
		<div class="clearfix">
			<a href="<?php echo esc_url($stm_pricing_link); ?>" class="button stm-green" style="margin-right:0;">
				<?php esc_html_e('Upgrade', 'motors'); ?>
			</a>
		</div>
	<?php endif; ?>
</div>