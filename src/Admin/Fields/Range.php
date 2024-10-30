<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Range field.
 *
 * @since 1.0.0
 */
class Range extends Field {

	/**
	 * Render a field.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function field() {

		?>
		<input
			class="cd-header-banner-range"
			type="range"
			id="<?php echo esc_attr( $this->get_name() ); ?>"
			name="<?php echo esc_attr( $this->get_name() ); ?>"
			value="<?php echo esc_attr( $this->get_value() ); ?>"
			min="<?php echo esc_attr( $this->get_attribute( 'min' ) ); ?>"
			max="<?php echo esc_attr( $this->get_attribute( 'max' ) ); ?>"
			step="<?php echo esc_attr( $this->get_attribute( 'step' ) ); ?>"
		/>

		<input
			class="cd-header-banner-range-value"
			type="number"
			value="<?php echo esc_attr( $this->get_value() ); ?>"
			min="<?php echo esc_attr( $this->get_attribute( 'min' ) ); ?>"
			max="<?php echo esc_attr( $this->get_attribute( 'max' ) ); ?>"
			step="<?php echo esc_attr( $this->get_attribute( 'step' ) ); ?>"
		/>
		<?php
	}
}