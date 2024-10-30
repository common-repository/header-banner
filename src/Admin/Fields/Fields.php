<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Fields.
 *
 * @since 1.0.0
 */
class Fields {

	/**
	 * Get fields.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $fields_data Fields data.
	 * @param string $saving_type Saving type.
	 *
	 * @return array
	 */
	public static function get_fields( array $fields_data, string $saving_type = 'options' ): array {

		$fields = [];

		foreach ( $fields_data as $field_data ) {
			$fields[] = self::get_field( $field_data, $saving_type );
		}

		return $fields;
	}

	/**
	 * Get section.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $section_args Section arguments.
	 * @param array  $fields_data  Fields data.
	 * @param string $saving_type  Saving type.
	 */
	public static function get_section( array $section_args, array $fields_data, string $saving_type = 'options' ) {
		?>

		<div class="cd-header-banner-section">
			<div class="cd-header-banner-section-title">
				<?php echo esc_html( $section_args['label'] ); ?>
			</div>

			<div class="cd-header-banner-section-content">
				<?php self::get_fields( $fields_data, $saving_type ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get field.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $data        Field data.
	 * @param string $saving_type Saving type.
	 *
	 * @return Checkbox|Link|TextInput|null
	 */
	private static function get_field( array $data, string $saving_type ) { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.MaxExceeded

		$field = null;

		switch ( $data['type'] ) {
			case 'text_input':
				$field = new TextInput( $data, $saving_type );
				break;

			case 'number_input':
				$field = new NumberInput( $data, $saving_type );
				break;

			case 'checkbox':
				$field = new Checkbox( $data, $saving_type );
				break;

			case 'link':
				$field = new Link( $data, $saving_type );
				break;

			case 'dropdown':
				$field = new Dropdown( $data, $saving_type );
				break;

			case 'textarea':
				$field = new Textarea( $data, $saving_type );
				break;

			case 'color_picker':
				$field = new ColorPicker( $data, $saving_type );
				break;

			case 'range':
				$field = new Range( $data, $saving_type );
				break;

			case 'switcher':
				$field = new Switcher( $data, $saving_type );
				break;

			case 'upload':
				$field = new Upload( $data, $saving_type );
				break;
		}

		return $field;
	}
}
