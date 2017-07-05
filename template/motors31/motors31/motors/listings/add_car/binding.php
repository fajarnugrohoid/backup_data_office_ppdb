<?php $bind_tax = stm_data_binding(); ?>

<script type="text/javascript">
	var stmTaxRelations = <?php echo $bind_tax; ?>

		jQuery(document).ready(function () {
			var $ = jQuery;
			$('.stm_add_car_form .stm_add_car_form_1 .stm-form-1-selects select:not(.hide)').select2().on('change', function () {

				/*Remove disabled*/

				var stmCurVal = $(this).val();
				var stmCurSelect = $(this).attr('name');
				stmCurSelect = stmCurSelect.match(/\[(.*?)\]/)[1];

				if (stmTaxRelations[stmCurSelect]) {


					var key = stmTaxRelations[stmCurSelect]['dependency'];
					$('select[name="stm_f_s[' + key + ']"]').val('');
					if (stmCurVal == '') {
						$('select[name="stm_f_s[' + key + ']"] > option').each(function () {
							$(this).removeAttr('disabled');
						});
					} else {
						var allowedTerms = stmTaxRelations[stmCurSelect][stmCurVal];

						if (typeof(allowedTerms) == 'object') {
							$('select[name="stm_f_s[' + key + ']"] > option').removeAttr('disabled');

							$('select[name="stm_f_s[' + key + ']"] > option').each(function () {
								var optVal = $(this).val();
								if (optVal != '' && $.inArray(optVal, allowedTerms) == -1) {
									$(this).attr('disabled', '1');
								}
							});
						} else {
							$('select[name="stm_f_s[' + key + ']"]').val(allowedTerms);
						}
					}

					if ($('.stm_add_car_form .stm_add_car_form_1 .stm-form-1-selects select[name="stm_f_s[' + key + ']"]').length > 0) {
						$('.stm_add_car_form .stm_add_car_form_1 .stm-form-1-selects select[name="stm_f_s[' + key + ']"]').select2("destroy");
					}
					if ($('.stm_add_car_form .stm_add_car_form_1 .stm-form1-intro-unit select[name="stm_f_s[' + key + ']"]')) {
						$('.stm_add_car_form .stm_add_car_form_1 .stm-form1-intro-unit select[name="stm_f_s[' + key + ']"]').select2();
					}
				}
			});
		});
</script>