<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Upload field.
 *
 * @since 1.0.0
 */
class Upload extends Field {

	/**
	 * Render a field.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function field() {

		$hide      = $this->get_value() ? ' style=display:none;' : '';
		$show      = $this->get_value() ? ' style=display:block;' : '';
		$image     = wp_get_attachment_image_src( $this->get_value() );
		$image_src = $image[0] ?? '';

		?>
		<div class="cd-header-banner-upload">
			<img class="cd-header-banner-upload-preview" src="<?php echo esc_url( $image_src ); ?>" alt="<?php esc_html_e( 'Header banner upload preview', 'cd-header-banner' ); ?>"<?php echo esc_attr( $show ); ?>>

			<button class="cd-header-banner-upload-button"<?php echo esc_attr( $hide ); ?>>
				<?php esc_html_e( 'Upload image', 'cd-header-banner' ); ?>
			</button>

			<input
				class="cd-header-banner-upload-input"
				type="hidden"
				id="<?php echo esc_attr( $this->get_name() ); ?>"
				name="<?php echo esc_attr( $this->get_name() ); ?>"
				value="<?php echo esc_attr( $this->get_value() ); ?>"
			/>

			<button class="cd-header-banner-upload-remove"<?php echo esc_attr( $show ); ?>>
				<?php esc_html_e( 'Remove image', 'cd-header-banner' ); ?>
			</button>
		</div>
		<?php
	}
}