<div class="stm-delete-confirmation-popup stm-disabled">
	<i class="fa fa-close"></i>
	<div class="stm-confirmation-text heading-font">
		<span class="stm-danger"><?php esc_html_e('Delete', 'motors'); ?></span>
		<span class="stm-car-title"></span>
	</div>
	<div class="actions">
		<a href="#" class="button stm-red-btn"><?php esc_html_e('Delete', 'motors'); ?></a>
		<a href="#" class="button stm-grey-btn"><?php esc_html_e('Cancel', 'motors'); ?></a>
	</div>
</div>
<div class="stm-delete-confirmation-overlay stm-disabled"></div>

<h4 class="stm-seller-title stm-main-title"><?php esc_html_e('My Inventory', 'motors'); ?></h4>
<div class="stm-sort-private-my-cars">
	<div class="select-type">
		<div class="stm-label-type"><?php esc_html_e('Sort by', 'motors'); ?></div>
		<select>
			<option value="all"><?php esc_html_e('All', 'motors'); ?></option>
			<option value="pending"><?php esc_html_e('Pending', 'motors'); ?></option>
			<option value="draft"><?php esc_html_e('Disabled', 'motors'); ?></option>
		</select>
	</div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var $ = jQuery;
		$('.stm-sort-private-my-cars select').select2().on('change', function(){
			var opt_val = $(this).val();
			if(opt_val == 'all') {
				$('.listing-list-loop-edit').removeClass('stm-invisible');
			} else if(opt_val == 'pending') {
				$('.listing-list-loop-edit').removeClass('stm-invisible');
				$('.listing-list-loop-edit:not(.' + opt_val + ')').addClass('stm-invisible');
			} else if(opt_val == 'draft') {
				$('.listing-list-loop-edit').removeClass('stm-invisible');
				$('.listing-list-loop-edit:not(.' + opt_val + ')').addClass('stm-invisible');
			}

		});

		/*Stm confirmation before delete*/
		var urlToProceed = '';
		//Open confirmation
		$('.stm-delete-confirmation').on('click', function(e){
			e.preventDefault();

			urlToProceed = $(this).attr('href');
			var carTitle = $(this).data('title');

			$('.stm-delete-confirmation-popup').removeClass('stm-disabled');
			$('.stm-delete-confirmation-overlay').removeClass('stm-disabled');

			$('.stm-confirmation-text .stm-car-title').text(carTitle);
		});

		//Delete
		$('.stm-delete-confirmation-popup .actions .stm-red-btn').on('click', function(e){
			e.preventDefault();
			window.location = urlToProceed;
		});

		//Cancel delete
		$('.stm-delete-confirmation-popup .actions .stm-grey-btn, .stm-delete-confirmation-overlay, .stm-delete-confirmation-popup .fa-close').on('click', function(e) {
			e.preventDefault();
			$('.stm-delete-confirmation-popup').addClass('stm-disabled');
			$('.stm-delete-confirmation-overlay').addClass('stm-disabled');
		});
	});
</script>