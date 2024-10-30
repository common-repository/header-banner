<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * ColorPicker field.
 *
 * @since 1.0.0
 */
class ColorPicker extends Field {

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
			class="cd-header-banner-color-picker"
			data-alpha-enabled="true"
			type="text"
			id="<?php echo esc_attr( $this->get_name() ); ?>"
			name="<?php echo esc_attr( $this->get_name() ); ?>"
			value="<?php echo esc_attr( $this->get_value() ); ?>"
		/>
		<?php
	}
}