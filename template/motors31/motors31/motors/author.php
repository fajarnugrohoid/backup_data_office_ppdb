<?php
$user = wp_get_current_user();

$vars = get_queried_object();
?>

<?php get_header(); ?>

<?php
	$user = get_queried_object();
	$current_user = wp_get_current_user();

	$display_footer = '';
	if($user->ID === $current_user->ID and empty($_GET['view-myself'])) {?>
		<style type="text/css">
			footer#footer {
				display: none;
			}
		</style>

		<script>
			jQuery(document).ready(function(){
				stm_private_user_height();

				<?php if(!empty($_GET['stm_disable_user_car'])): ?>
					window.history.pushState('','','<?php echo esc_url(stm_get_author_link('')); ?>');
				<?php endif; ?>

				<?php if(!empty($_GET['stm_enable_user_car'])): ?>
					window.history.pushState('','','<?php echo esc_url(stm_get_author_link('')); ?>');
				<?php endif; ?>

				<?php if(!empty($_GET['stm_move_trash_car'])): ?>
					window.history.pushState('','','<?php echo esc_url(stm_get_author_link('')); ?>');
				<?php endif; ?>
			});

			jQuery(window).load(function(){
				stm_private_user_height();
			});

			jQuery(window).resize(function(){
				stm_private_user_height();
			});

			function stm_private_user_height() {
				var $ = jQuery;
				var windowH = $(window).outerHeight();
				var topBarH = $('#top-bar').outerHeight();
				var headerH = $('#header').outerHeight();

				var topH = 0;

				if(topBarH != null) {
					topH = topBarH;
				}

				if(headerH != null) {
					topH += headerH;
				}

				var minH = windowH - topH;

				$('.stm-user-private-sidebar').css({
					'min-height' : minH + 'px'
				})
			}
		</script>
	<?php }

	if(!empty($_GET['view-myself']) and $_GET['view-myself']) {
		get_template_part('partials/user/user-public-profile', 'route');
	} else {
		if ( is_user_logged_in() ) {
			get_template_part( 'partials/user/user-private-profile', 'route' );
		} else {
			get_template_part( 'partials/user/user-public-profile', 'route' );
		}
	}
?>

<!--JS translations-->
<script type="text/javascript">
	var stm_added_to_compare_text = "<?php esc_html_e('Added to compare', 'motors'); ?>";
	var stm_removed_from_compare_text = "<?php esc_html_e('was removed from compare', 'motors'); ?>";
	var stm_already_added_to_compare_text = "<?php esc_html_e('You have already added 3 cars', 'motors'); ?>";
</script>

<?php get_template_part('partials/single-car/single-car-compare-modal'); ?>

<?php get_footer(); ?>
