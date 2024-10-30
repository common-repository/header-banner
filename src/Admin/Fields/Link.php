<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Link field.
 *
 * @since 1.0.0
 */
class Link extends Field {

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
			type="url"
			id="<?php echo esc_attr( $this->get_name() ); ?>"
			name="<?php echo esc_attr( $this->get_name() ); ?>"
			value="<?php echo esc_attr( $this->get_value() ); ?>"
		/>
		<?php
	}
}