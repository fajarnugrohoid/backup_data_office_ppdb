<?php
if ( ! class_exists( 'STM_Customizer_Font_Weight_Control' ) ) {

	class STM_Customizer_Font_Weight_Control extends WP_Customize_Control {

		public $type = 'stm-font-weight';

		public function render_content() {


			$weights = array(
				'100'       => __( 'Ultra Light', 'motors' ),
				'100italic' => __( 'Ultra Light Italic', 'motors' ),
				'200'       => __( 'Light', 'motors' ),
				'200italic' => __( 'Light Italic', 'motors' ),
				'300'       => __( 'Book', 'motors' ),
				'300italic' => __( 'Book Italic', 'motors' ),
				'400'       => __( 'Regular', 'motors' ),
				'400italic' => __( 'Regular Italic', 'motors' ),
				'500'       => __( 'Medium', 'motors' ),
				'500italic' => __( 'Medium Italic', 'motors' ),
				'600'       => __( 'Semi-Bold', 'motors' ),
				'600italic' => __( 'Semi-Bold Italic', 'motors' ),
				'700'       => __( 'Bold', 'motors' ),
				'700italic' => __( 'Bold Italic', 'motors' ),
				'800'       => __( 'Extra Bold', 'motors' ),
				'800italic' => __( 'Extra Bold Italic', 'motors' ),
				'900'       => __( 'Ultra Bold', 'motors' ),
				'900italic' => __( 'Ultra Bold Italic', 'motors' )
			);


			$input_args = array(
				'type'    => 'select',
				'label'   => $this->label,
				'name'    => '',
				'id'      => $this->id,
				'value'   => $this->value(),
				'link'    => $this->get_link(),
				'options' => $weights
			);

			?>

			<div id="stm-customize-control-<?php echo esc_attr( $this->id ); ?>" class="stm-customize-control stm-customize-control-<?php echo esc_attr( str_replace( 'stm-', '', $this->type ) ); ?>">

				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>

				<div class="stm-form-item">
					<div class="stm-font-weight-wrapper">
						<?php stm_input( $input_args ); ?>
					</div>
				</div>

				<?php if ( '' != $this->description ) : ?>
					<div class="description customize-control-description">
						<?php echo esc_html( $this->description ); ?>
					</div>
				<?php endif; ?>

			</div>
			<?php
		}
	}
}