<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$css_share_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_share, ' ' ) );
?>

<div class="blog-meta-bottom <?php echo esc_attr($css_class); ?>">
	<div class="clearfix">
		<div class="left">
			<!--Categories-->
			<?php $cats = get_the_category( get_the_id() ); //print_r($cats); ?>
			<?php if ( ! empty( $cats ) ): ?>
				<div class="post-cat">
					<span class="h6"><?php esc_html_e( 'Category:', 'motors' ); ?></span>
					<?php foreach ( $cats as $cat ): ?>
						<span class="post-category">
							<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><span><?php echo $cat->name; ?></span></a><span class="divider">,</span>
						</span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!--Tags-->
			<?php if( $tags = wp_get_post_tags( get_the_ID() ) ){ ?>
				<div class="post-tags">
					<span class="h6"><?php esc_html_e( 'Tags:', 'motors' ); ?></span>
					<span class="post-tag">
						<?php echo get_the_tag_list('', ', ', ''); ?>
					</span>
				</div>
			<?php } ?>
		</div>

		<div class="right">
			<div class="stm-shareble<?php echo esc_attr($css_share_class); ?>">
				<span class="st_sharethis_large" displaytext=""></span>
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({doNotHash: false, doNotCopy: false, hashAddressBar: false,onhover: false});</script>
				<a
					href="#"
					class="car-action-unit stm-share"
					title="<?php esc_html_e('Share this', 'motors'); ?>"
					download>
					<i class="stm-icon-share"></i>
					<?php esc_html_e('Share this', 'motors'); ?>
				</a>
			</div>
		</div>
	</div>
</div>