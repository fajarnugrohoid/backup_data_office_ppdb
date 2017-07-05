<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$css_class_icon = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css_icon, ' ' ) );
$link = vc_build_link( $link );

$icon_unique_class = 'icon_box_'.rand(0,99999);

if(empty($box_bg_color)) {
	$box_bg_color = '#fab637';
	$rgba = '250,182,55';
} else {
	$rgba = stm_hex2rgb($box_bg_color);
}

if(empty($box_text_color)){
	$box_text_color = '#232628';
}

if(empty($icon_size)) {
	$icon_size = '54';
	if(stm_is_boats()) {
		$icon_size = '48';
	}
}

if(empty($style_layout)) {
	$style_layout = 'car_dealer';
}

?>


<?php if(!empty($link['url'])): ?>
	<a
	class="icon-box-link"
	href="<?php echo esc_url($link['url']) ?>"
	title="<?php if(!empty($link['title'])){ echo esc_attr($link['title']); }; ?>"
	<?php if(!empty($link['target'])): ?>
		target="_blank"
	<?php endif; ?>>
<?php endif; ?>

	<div
		class="icon-box<?php echo esc_attr($css_class.' '.$icon_unique_class); ?> stm-layout-box-<?php echo esc_attr($style_layout); ?>"
		style="color:<?php echo esc_attr($box_text_color); ?>">
		<div class="boat-line"></div>
		<?php if(!empty($icon)): ?>
			<div
				class="icon<?php echo esc_attr($css_class_icon); ?> boat-third-color"
				style="font-size:<?php echo esc_attr($icon_size); ?>px;<?php if(!empty($icon_color)){ echo esc_attr('color:'.$icon_color.'; '); } if(!empty($icon_width)){ echo esc_attr($icon_width); } if(!empty($icon_bg_color)){ echo esc_attr('background-color:'.$icon_bg_color); } ?>">
				<i class="<?php echo esc_attr($icon); ?>"></i>
			</div>
		<?php endif; ?>
		<div class="icon-text">
			<?php if(!empty($title)): ?>
				<<?php echo esc_attr($title_holder); ?> class="title heading-font" style="color:<?php echo esc_attr($box_text_color); ?>">
					<?php echo esc_attr($title); ?>
				</<?php echo esc_attr($title_holder); ?>>
			<?php endif; ?>
			<?php if(!empty($content)): ?>
				<div class="content" <?php if(!empty($line_height)){ echo esc_attr('style=line-height:'.$line_height.'px;', 'motors'); } ?>>
					<?php echo wpb_js_remove_wpautop($content, true); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if(!empty($bottom_triangle) and $bottom_triangle): ?>
			<div class="icon-box-bottom-triangle">

			</div>
		<?php endif; ?>
	</div>

<?php if(!empty($link['url'])): ?>
	</a>
<?php endif; ?>


<style>
	<?php if(!empty($box_bg_color)): ?>
		.<?php echo esc_attr($icon_unique_class) ?>:after,
		.<?php echo esc_attr($icon_unique_class) ?>:before {
			<?php if($box_bg_color != 'rgba(255,255,255,0.01)') { ?>
				background-color: <?php echo esc_attr($box_bg_color); ?>;
			<?php } ?>
			}
		}
		.<?php echo esc_attr($icon_unique_class) ?> .icon-box-bottom-triangle {
			 border-right-color:rgba(<?php echo esc_attr($rgba); ?>,0.9);
		}
		.<?php echo esc_attr($icon_unique_class) ?>:hover .icon-box-bottom-triangle {
			border-right-color:rgba(<?php echo esc_attr($rgba); ?>,1);
		}
	<?php endif; ?>
	<?php if(!empty($box_text_color)): ?>
		.icon-box .icon-text .content a {
			color: <?php echo esc_attr($box_text_color); ?>;
		}
	<?php endif; ?>
	<?php if(!empty($box_text_color_hover)): ?>
	.<?php echo esc_attr($icon_unique_class) ?>:hover .icon-text .content span,
	.<?php echo esc_attr($icon_unique_class) ?>:hover .icon-text .content p {
		color: <?php echo esc_attr($box_text_color_hover); ?> !important;
	}
	<?php endif; ?>
</style>