
	<div class="row">
		<div class="col-md-9 col-sm-12 col-xs-12">
			<div class="stm-single-car-content">
				<h2 class="title"><?php the_title(); ?></h2>

				<!--Actions-->
				<?php get_template_part('partials/single-car/car', 'actions'); ?>

				<!--Gallery-->
				<?php get_template_part('partials/single-car/car', 'gallery'); ?>

				<?php the_content(); ?>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="stm-single-car-side">

				<!--Prices-->
				<?php get_template_part('partials/single-car/car', 'price'); ?>

				<!--Data-->
				<?php get_template_part('partials/single-car/car', 'data'); ?>

				<!--MPG-->
				<?php get_template_part('partials/single-car/car', 'mpg'); ?>

				<!--Calculator-->
				<?php get_template_part('partials/single-car/car', 'calculator'); ?>

			</div>
		</div>
	</div>