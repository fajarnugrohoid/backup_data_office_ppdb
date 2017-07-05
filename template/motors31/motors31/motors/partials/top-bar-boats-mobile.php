<?php
$top_bar = get_theme_mod('top_bar_enable', true);
$top_bar_login = get_theme_mod('top_bar_login', true);
$top_bar_wpml_switcher = get_theme_mod('top_bar_wpml_switcher', true);


if(!empty($top_bar) and $top_bar):
?>

	<div id="top-bar-mobile">

		<div class="stm-boats-top-bar-centered clearfix">

			<?php
			$top_bar_address = get_theme_mod( 'top_bar_address', '1010 Moon ave, New York, NY US' );
			$top_bar_address_mobile = get_theme_mod( 'top_bar_address_mobile', true );

			$top_bar_working_hours = get_theme_mod( 'top_bar_working_hours', 'Mon - Sat 8.00 - 18.00' );
			$top_bar_working_hours_mobile = get_theme_mod( 'top_bar_working_hours_mobile', true );

			$top_bar_phone = get_theme_mod( 'top_bar_phone', '+1 212-226-3126' );
			$top_bar_phone_mobile = get_theme_mod( 'top_bar_phone_mobile', true );

			$top_bar_menu = get_theme_mod('top_bar_menu', false);

			if( $top_bar_menu ): ?>
				<div class="top_bar_menu">
					<?php get_template_part('partials/top-bar', 'menu'); ?>
				</div>
			<?php endif;

			if( $top_bar_address || $top_bar_working_hours || $top_bar_phone ): ?>
				<ul class="top-bar-info clearfix">
					<?php if( $top_bar_working_hours ){ ?>
						<li <?php if(!$top_bar_working_hours_mobile){ ?>class="hidden-info"<?php } ?>><i class="fa fa-calendar-check-o"></i> <?php printf(esc_html__( '%s', 'motors' ), $top_bar_working_hours ); ?></li>
					<?php } ?>
					<?php if( $top_bar_address ){ ?>
						<?php $header_address_url = get_theme_mod('header_address_url'); ?>
						<li <?php if(!$top_bar_address_mobile){ ?>class="hidden-info"<?php } ?>>
									<span class="fancy-iframe" data-url="<?php echo esc_url($header_address_url); ?>">
										<i class="fa fa-map-marker"></i> <?php printf(esc_html__( '%s', 'motors' ),$top_bar_address ); ?>
									</span>
						</li>
					<?php } ?>
					<?php if( $top_bar_phone ){ ?>
						<li <?php if(!$top_bar_phone_mobile){ ?>class="hidden-info"<?php } ?>><i class="fa fa-phone"></i> <?php printf(esc_html__( '%s', 'motors' ),$top_bar_phone ); ?></li>
					<?php } ?>
				</ul>
			<?php endif; ?>

			<?php $socials = stm_get_header_socials('top_bar_socials_enable'); ?>
			<!-- Header top bar Socials -->
			<?php if( !empty($socials) ): ?>
				<div class="header-top-bar-socs">
					<ul class="clearfix">
						<?php foreach ( $socials as $key => $val ): ?>
							<li>
								<a href="<?php echo esc_url($val) ?>">
									<i class="fa fa-<?php echo esc_attr($key); ?>"></i>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

		</div>

		<?php if(function_exists('icl_get_languages')):
			$langs = icl_get_languages('skip_missing=1&orderby=id&order=asc');
		endif; ?>
			<div class="clearfix top-bar-wrapper">
			<!--LANGS-->
			<?php if(!empty($top_bar_wpml_switcher) and $top_bar_wpml_switcher): ?>
				<?php if(!empty($langs)): ?>
					<?php
					if(count($langs) > 1){
						$langs_exist = 'dropdown_toggle';
					} else {
						$langs_exist = 'no_other_langs';
					}
					?>
					<div class="language-switcher-unit">
						<div class="stm_current_language <?php echo esc_attr($langs_exist); ?>" <?php if(count($langs) > 1){ ?> id="lang_dropdown" data-toggle="dropdown" <?php } ?>><?php echo esc_attr(ICL_LANGUAGE_NAME); ?><?php if(count($langs) > 1){ ?><i class="fa fa-angle-down"></i><?php } ?></div>
						<?php if(count($langs) > 1): ?>
							<ul class="dropdown-menu lang_dropdown_menu" role="menu" aria-labelledby="lang_dropdown">
								<?php foreach($langs as $lang): ?>
									<?php if(!$lang['active']): ?>
										<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo esc_url($lang['url']); ?>"><?php echo esc_attr($lang['native_name']); ?></a></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		</div>
	</div>

<?php endif; ?>