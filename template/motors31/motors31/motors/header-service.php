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
?>

<body <?php body_class(); ?> <?php if(!empty($body_custom_image)): ?> {style="background-image: url('<?php echo esc_url($body_custom_image); ?>')" <?php endif; ?>>

	<div id="wrapper">


		<?php get_template_part('partials/top', 'bar'); ?>
		<div id="header">
			<?php get_template_part('partials/service/header', 'service'); ?>
		</div> <!-- id header -->

		<div id="main">