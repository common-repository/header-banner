<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Checkbox field.
 *
 * @since 1.0.0
 */
class Checkbox extends Field {

	/**
	 * Get field HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function field() {

		?>
		<input
			type="checkbox"
			id="<?php echo esc_attr( $this->get_name() ); ?>"
			name="<?php echo esc_attr( $this->get_name() ); ?>"
			value="1"
			<?php checked( $this->get_value(), '1' ); ?>
		/>
		<?php
	}
}