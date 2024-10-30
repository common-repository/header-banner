<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Text input field.
 *
 * @since 1.0.0
 */
class TextInput extends Field {

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
			type="text"
			id="<?php echo esc_attr( $this->get_name() ); ?>"
			name="<?php echo esc_attr( $this->get_name() ); ?>"
			value="<?php echo esc_attr( $this->get_value() ); ?>"
		/>
		<?php
	}
}