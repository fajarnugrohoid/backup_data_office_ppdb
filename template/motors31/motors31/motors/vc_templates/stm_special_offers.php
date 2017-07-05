<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$args = array(
	'post_type' => stm_listings_post_type(),
	'post_status' => 'publish',
);

$args['meta_query'][] = array(
	'key'     => 'special_car',
	'value'   => 'on',
	'compare' => '='
);

$special_query = new WP_Query($args);

$labels = stm_get_car_listings();

$carousel_unique_class = 'special-carousel-'.rand(0,99999);

?>

<div class="special-offers">
	<div class="title heading-font">
		<?php echo esc_attr($title); ?>

		<?php if(!empty($show_all_link_specials) and $show_all_link_specials): ?>
			<a href="<?php echo esc_url(stm_get_listing_archive_link()); ?>" class="all-offers">
				<i class="stm-icon-label-reverse"></i>
				<span class="vt-top"><?php esc_html_e('all', 'motors'); ?></span>
				<span class="lt-blue"><?php esc_html_e('specials', 'motors'); ?></span>
			</a>
		<?php endif; ?>

	</div>
	<div class="colored-separator">
		<div class="first-long stm-base-background-color"></div>
		<div class="last-short stm-base-background-color"></div>
	</div>

	<?php if($special_query->have_posts()): ?>
		<div class="listing-car-items-units">
			<div class="listing-car-items listing-cars-carousel owl-carousel text-center clearfix <?php echo esc_attr($carousel_unique_class); ?>">
				<?php while($special_query->have_posts()): $special_query->the_post(); ?>
					<?php $spec_banner = get_post_meta(get_the_id(), 'special_image', true) ?>
					<?php if(empty($spec_banner)): ?>
						<div class="dp-in">
							<div class="listing-car-item">
								<div class="listing-car-item-inner">
									<a href="<?php the_permalink() ?>" class="rmv_txt_drctn" title="<?php esc_html_e('Watch full information about', 'motors'); echo esc_attr(' '.get_the_title()); ?>">
										<?php if(has_post_thumbnail()): ?>
											<div class="text-center">
												<div class="image dp-in">
													<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-350-205'); ?>
													<?php $img_2x = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-796-466'); ?>
													<img src="<?php echo esc_url($img[0]); ?>" data-retina="<?php echo esc_url($img_2x[0]); ?>" class="img-responsive" alt="<?php the_title(); ?>">
												</div>
											</div>
										<?php endif; ?>
										<div class="listing-car-item-meta">
											<div class="car-meta-top heading-font clearfix">
												<?php $car_price_form_label = get_post_meta(get_the_ID(), 'car_price_form_label', true); ?>
												<?php $price = get_post_meta(get_the_id(),'price',true); ?>
												<?php $sale_price = get_post_meta(get_the_id(),'sale_price',true); ?>
												<?php if(!empty($car_price_form_label)): ?>
													<div class="price">
															<div class="normal-price"><?php echo esc_attr($car_price_form_label); ?></div>
														</div>
												<?php else: ?>
													<?php if(!empty($price) and !empty($sale_price)):?>
														<div class="price discounted-price">
															<div class="regular-price">
																<?php echo esc_attr(stm_listing_price_view($price)); ?>
															</div>
															<div class="sale-price">
																<?php echo esc_attr(stm_listing_price_view($sale_price)); ?>
															</div>
														</div>
													<?php elseif(!empty($price)): ?>
														<div class="price">
															<div class="normal-price">
																<?php echo esc_attr(stm_listing_price_view($price)); ?>
															</div>
														</div>
													<?php endif; ?>
												<?php endif; ?>
												<div class="car-title">
													<?php echo esc_attr(trim(preg_replace( '/\s+/', ' ', substr(get_the_title(), 0, 35) ))); ?>
													<?php if(strlen(get_the_title()) > 35){
														echo esc_attr('...');
													} ?>
												</div>
											</div>
											<div class="car-meta-bottom">
												<?php $special_text = get_post_meta(get_the_id(),'special_text',true); ?>
												<?php if(empty($special_text)): ?>
													<?php if(!empty($labels)): ?>
														<ul>
															<?php foreach($labels as $label): ?>
																<?php $label_meta = get_post_meta(get_the_id(),$label['slug'],true); ?>
																<?php if(!empty($label_meta)): ?>
																	<li>
																		<?php if(!empty($label['font'])): ?>
																			<i class="<?php echo esc_attr($label['font']) ?>"></i>
																		<?php endif; ?>
																		
																		<?php if(!empty($label['numeric']) and $label['numeric']): ?>
																			<span><?php echo esc_attr($label_meta); ?></span>
																		<?php else: ?>
																			
																			<?php 
																				$data_meta_array = explode(',',$label_meta);
																				$datas = array();
																				
																				if(!empty($data_meta_array)){
																					foreach($data_meta_array as $data_meta_single) {
																						$data_meta = get_term_by('slug', $data_meta_single, $label['slug']);
																						if(!empty($data_meta->name)) {
																							$datas[] = esc_attr($data_meta->name);
																						}
																					}
																				}
																			?>
																			
																			<?php if(!empty($datas)): 
																				if(count($datas) > 1) { ?>
																					
																					<span 
																						class="stm-tooltip-link" 
																						data-toggle="tooltip"
																						data-placement="top"
																						title="<?php echo esc_attr(implode(', ', $datas)); ?>">
																						<?php echo $datas[0].'<span class="stm-dots dots-aligned">...</span>'; ?>
																					</span>
								
																				<?php } else { ?>
																					<span><?php echo implode(', ', $datas); ?></span>
																				<?php }
																			endif; ?>
																			
																		<?php endif; ?>
																	</li>
																<?php endif; ?>
															<?php endforeach; ?>
														</ul>
													<?php endif; ?>
												<?php else: ?>
													<ul>
														<li>
															<div class="special-text"><?php echo esc_attr($special_text); ?></div>
														</li>
													</ul>
												<?php endif; ?>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					<?php else: ?>
						<div class="dp-in">
							<div class="listing-car-item">
								<div class="listing-car-item-inner">
									<?php $banner_src = wp_get_attachment_image_src($spec_banner, 'stm-img-350-356'); ?>
									<?php $banner_src_retina = wp_get_attachment_image_src($spec_banner, 'full'); ?>
									<a href="<?php the_permalink() ?>">
										<img class="img-responsive" src="<?php echo esc_url($banner_src[0]); ?>" data-retina="<?php echo esc_url($banner_src_retina[0]); ?>" alt="<?php the_title(); ?>" />
									</a>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

</div>

<script type="text/javascript">
	(function($) {
		"use strict";

		var owl = $('.<?php echo esc_js($carousel_unique_class); ?>');

		$(document).ready(function () {
			owl.on('initialized.owl.carousel', function(e){
				owl.find('.owl-dots').before('<div class="stm-owl-prev"><i class="fa fa-angle-left"></i></div>');
				owl.find('.owl-dots').after('<div class="stm-owl-next"><i class="fa fa-angle-right"></i></div>');
			});

			var owlRtl = false;
			if( $('body').hasClass('rtl') ) {
				owlRtl = true;
			}

			owl.owlCarousel({
				rtl: owlRtl,
				items: 3,
				dots: true,
				autoplay: false,
				slideBy: 3,
				loop: true,
				responsive:{
					0:{
						items:1,
						slideBy: 1
					},
					768:{
						items:2,
						slideBy: 2
					},
					992:{
						items:3,
						slideBy: 3
					}
				}
			});
			owl.on('click','.stm-owl-prev', function(){
				console.log('prev');
				owl.trigger('prev.owl.carousel');
			})
			owl.on('click','.stm-owl-next', function(){
				console.log('next');
				owl.trigger('next.owl.carousel');
			});

			<?php if(!empty($colored_first_word) and $colored_first_word): ?>
			owl.find('.car-title').each(function(){
				var html = $(this).html();
				var word = html.substr(0, html.indexOf(" "));
				var rest = html.substr(html.indexOf(" "));
				$(this).html(rest).prepend($("<span/>").html(word).addClass("stm-base-color"));
			});
			<?php endif; ?>
		});
	})(jQuery);
</script>