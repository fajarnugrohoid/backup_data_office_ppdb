<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );


?>

<div id="container" class="intro-effect-fadeout modify <?php echo esc_attr($css_class); ?>">
	<header class="header">
		<div class="bg-img">
			<?php if(has_post_thumbnail()) {
				the_post_thumbnail(); 
			} ?>
		</div>
		<div class="title container">
			<h1><?php the_title(); ?></h1>
			<?php if(!empty($subtitle)): ?>
				<p class="subline"><?php echo esc_attr($subtitle); ?></p>
			<?php endif; ?>

			<div class="blog-meta clearfix">
				<div class="left">
					<div class="clearfix">
						<div class="blog-meta-unit h6">
							<i class="stm-icon-date"></i>
							<span><?php echo get_the_date(); ?></span>
						</div>
						<div class="blog-meta-unit h6">
							<i class="stm-icon-author"></i>
							<span><?php esc_html_e( 'Posted by:', 'motors' ); ?></span>
							<span><?php the_author(); ?></span>
						</div>
					</div>
				</div>
				<div class="left">
					<div class="blog-meta-unit h6">
						<a href="<?php comments_link(); ?>" class="post_comments h6">
							<i class="stm-icon-message"></i> <?php comments_number(); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</header>
</div>	


<style type="text/css">
	#animated-blog-wrapper .intro-effect-fadeout .header {
		max-height: 400px;
	}
</style>

<script>
	
	jQuery('.stm-single-post').attr('id', 'animated-blog-wrapper');
	
	jQuery(document).ready(function(){
		var $ = jQuery;
		$('.stm-single-post').attr('id', 'animated-blog-wrapper');
		$('#animated-blog-wrapper .intro-effect-fadeout .header').height($(window).height() - 140);
	});
	
	jQuery(window).resize(function(){
		jQuery('#animated-blog-wrapper .intro-effect-fadeout .header').height(jQuery(window).height() - 140);
	});

	jQuery(document).ready(function(){
		jQuery('#blog-animated-content').addClass('modify');
	})
</script>