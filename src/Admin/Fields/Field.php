<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Field.
 *
 * @since 1.0.0
 */
abstract class Field {
	/**
	 * Arguments.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $args;

	/**
	 * Option name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $option_name = 'cd_header_banner_settings';

	/**
	 * Saving type.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $saving_type;

	/**
	 * Field constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $args        Field arguments.
	 * @param string $saving_type Saving type.
	 */
	public function __construct( array $args, string $saving_type ) {

		$this->args        = $args;
		$this->saving_type = $saving_type;

		$this->render();
	}

	/**
	 * Render a field.
	 *
	 * @since 1.0.0
	 */
	public function render() {

		?>
		<div class="cd-header-banner-field">
			<?php $this->label(); ?>

			<div class="cd-header-banner-control">
				<?php $this->field(); ?>
			</div>

			<?php $this->description(); ?>
		</div>
		<?php
	}

	/**
	 * Render a label.
	 *
	 * @since 1.0.0
	 */
	public function label() {

		?>
		<label class="cd-header-banner-field-title" for="<?php echo esc_attr( $this->get_name() ); ?>"><?php echo esc_html( $this->args['label'] ); ?></label>
		<?php
	}

	/**
	 * Render a field.
	 *
	 * @since 1.0.0
	 */
	abstract public function field();

	/**
	 * Render a description.
	 *
	 * @since 1.0.0
	 */
	public function description() {

		if ( $this->args['description'] ) {
			?>
			<p class="cd-header-banner-field-description">
				<?php echo esc_html( $this->args['description'] ); ?>
			</p>
			<?php
		}
	}

	/**
	 * Get the field value.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_value(): string {

		if ( $this->saving_type === 'metabox' ) {
			return cd_header_banner_get_post_meta( $this->args['id'], $this->get_default_value() );
		}

		return cd_header_banner_get_settings( $this->args['id'], $this->get_default_value() );
	}

	/**
	 * Get the default value.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_default_value(): string {

		return $this->args['default'] ?? '';
	}

	/**
	 * Get the field name.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_name(): string {

		return $this->option_name . '[' . $this->args['id'] . ']';
	}

	/**
	 * Get the field attribute.
	 *
	 * @since 1.0.0
	 *
	 * @param string $attribute Attribute.
	 *
	 * @return string
	 */
	protected function get_attribute( string $attribute ): string {

		return $this->args[ $attribute ] ?? '';
	}
}