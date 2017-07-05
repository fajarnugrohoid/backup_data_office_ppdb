<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>

<?php
	$body_custom_image = get_theme_mod('custom_bg_image');
	$boats_header_layout = get_theme_mod('boats_header_layout', 'boats');
	$motorcycle_header_layout = get_theme_mod('motorcycle_header_layout', 'motorcycle');
	$top_bar_layout = '';
	if(stm_is_boats()) {
		$top_bar_layout = '-boats';
	}


?>

<body <?php body_class(); ?> <?php if(!empty($body_custom_image)): ?> style="background-image: url('<?php echo esc_url($body_custom_image); ?>')" <?php endif; ?> ontouchstart="">


	<div id="wrapper">

		<?php if(stm_is_boats()): ?>
			<div id="stm-boats-header">
		<?php endif; ?>

			<?php if(!is_404() and !is_page_template('coming-soon.php')){ ?>
				<?php get_template_part('partials/top', 'bar' . $top_bar_layout); ?>
				<div id="header">
					<?php
						if(stm_get_current_layout() == 'listing') {
							get_template_part( 'partials/header/header-listing' );
						} elseif(stm_get_current_layout() == 'boats' and $boats_header_layout == 'boats') {
							get_template_part( 'partials/header/header-boats' );
						} elseif(stm_is_motorcycle() and $motorcycle_header_layout == 'motorcycle') {
							get_template_part( 'partials/header/header-motorcycle' );
						} else {
							get_template_part('partials/header/header');
							get_template_part('partials/header/header-nav');
						}
					?>
				</div> <!-- id header -->
			<?php } elseif(is_page_template('coming-soon.php')) {
				get_template_part('partials/header/header-coming','soon');
			} else {
				get_template_part('partials/header/header','404');
			}; ?>

		<?php if(stm_is_boats()): ?>
			</div>
			<?php get_template_part('partials/header/header-boats-mobile'); ?>
		<?php endif; ?>

		<div id="main">