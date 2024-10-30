<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * NumberInput field.
 *
 * @since 1.0.0
 */
class NumberInput extends Field {

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
			type="number"
			id="<?php echo esc_attr( $this->get_name() ); ?>"
			name="<?php echo esc_attr( $this->get_name() ); ?>"
			value="<?php echo esc_attr( $this->get_value() ); ?>"
			min="0"
		/>
		<?php
	}
}