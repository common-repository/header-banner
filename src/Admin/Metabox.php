<?php

namespace CDHeaderBanner\Admin;

use CDHeaderBanner\Admin\Fields\Fields;

/**
 * Metabox class.
 *
 * @since 1.0.0
 */
class Metabox {

	/**
	 * The metabox name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $metabox_name = 'cd_header_banner_settings';

	/**
	 * Get a single instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Metabox
	 */
	public static function get_instance(): Metabox {

		static $instance;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->hooks();
	}

	/**
	 * Hooks.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {

		add_action( 'add_meta_boxes', [ $this, 'register_metabox' ] );
		add_action( 'save_post', [ $this, 'save_metabox' ] );
	}

	/**
	 * Get the nonce.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function nonce(): string {

		return $this->metabox_name . '_nonce';
	}

	/**
	 * Save the metabox.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The post ID.
	 */
	public function save_metabox( int $post_id ) {

		if ( ! isset( $_POST[ $this->nonce() ] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_key( $_POST[ $this->nonce() ] ), $this->nonce() ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( ! isset( $_POST[ $this->metabox_name ] ) ) {
			return;
		}

		$data = wp_unslash( $_POST[ $this->metabox_name ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		if ( isset( $data['show'] ) ) {
			update_post_meta( $post_id, 'show', 1 );
		} else {
			update_post_meta( $post_id, 'show', 0 );
		}

		$this->save_single_field( $post_id, 'close_button' );
		$this->save_single_field( $post_id, 'version' );
		$this->save_single_field( $post_id, 'background_color' );
		$this->save_single_field( $post_id, 'text_color' );
		$this->save_single_field( $post_id, 'background_image' );
		$this->save_single_field( $post_id, 'height_desktop' );
		$this->save_single_field( $post_id, 'height_mobile' );
		$this->save_single_field( $post_id, 'text' );
		$this->save_single_field( $post_id, 'link' );
		$this->save_single_field( $post_id, 'target_blank' );
		$this->save_single_field( $post_id, 'show_on' );
	}

	/**
	 * Save a single field.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $post_id  The post ID.
	 * @param string $field_id The field ID.
	 */
	private function save_single_field( int $post_id, string $field_id ) {

		if ( ! isset( $_POST[ $this->nonce() ] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_key( $_POST[ $this->nonce() ] ), $this->nonce() ) ) {
			return;
		}

		if ( ! isset( $_POST[ $this->metabox_name ] ) ) {
			return;
		}

		$data = wp_unslash( $_POST[ $this->metabox_name ] ) ?? []; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		if ( isset( $field_id, $data[ $field_id ] ) ) {
			update_post_meta( $post_id, $field_id, sanitize_text_field( $data[ $field_id ] ) );
		}
	}

	/**
	 * Register the metabox.
	 *
	 * @since 1.0.0
	 */
	public function register_metabox() {

		add_meta_box(
			'cd-header-banner-settings',
			esc_html__( 'Banner Settings', 'cd-header-banner' ),
			[ $this, 'render_metabox' ],
			'cd_header_banner',
			'normal'
		);
	}

	/**
	 * Render the metabox.
	 *
	 * @since 1.0.0
	 */
	public function render_metabox() {

		?>
		<?php wp_nonce_field( $this->nonce(), $this->nonce() ); ?>

		<div class="cd-header-banner-metabox">
			<?php

			Fields::get_fields(
				[
					[
						'id'          => 'show',
						'type'        => 'switcher',
						'label'       => esc_html__( 'Show Banner', 'cd-header-banner' ),
						'description' => esc_html__( 'Check this box to show the banner.', 'cd-header-banner' ),
						'default'     => false,
					],
				],
				'metabox'
			);

			Fields::get_section(
				[
					'label' => esc_html__( 'Settings', 'cd-header-banner' ),
				],
				[
					[
						'id'          => 'close_button',
						'type'        => 'switcher',
						'label'       => esc_html__( 'Close button', 'cd-header-banner' ),
						'description' => esc_html__( 'Check this box to show the close button.', 'cd-header-banner' ),
						'default'     => true,
					],
					[
						'id'          => 'version',
						'type'        => 'number_input',
						'label'       => esc_html__( 'Banner version', 'cd-header-banner' ),
						'description' => esc_html__( 'If you make any changes to your banner settings or content, you may want to display the updated banner to all visitors who previously closed it. To do this, simply increase the banner version.', 'cd-header-banner' ),
						'default'     => 1,
					],
				],
				'metabox'
			);

			Fields::get_section(
				[
					'label' => esc_html__( 'Styles', 'cd-header-banner' ),
				],
				[
					[
						'id'          => 'background_color',
						'type'        => 'color_picker',
						'label'       => esc_html__( 'Background color', 'cd-header-banner' ),
						'description' => esc_html__( 'Select the background color of the banner.', 'cd-header-banner' ),
						'default'     => 'rgb(196,196,196)',
					],
					[
						'id'          => 'text_color',
						'type'        => 'color_picker',
						'label'       => esc_html__( 'Text color', 'cd-header-banner' ),
						'description' => esc_html__( 'Select the text color of the banner.', 'cd-header-banner' ),
						'default'     => 'rgb(239,239,239)',
					],
					[
						'id'          => 'background_image',
						'type'        => 'upload',
						'label'       => esc_html__( 'Background image', 'cd-header-banner' ),
						'description' => esc_html__( 'Upload the background image of the banner.', 'cd-header-banner' ),
					],
					[
						'id'          => 'height_desktop',
						'type'        => 'range',
						'label'       => esc_html__( 'Banner height (Desktop)', 'cd-header-banner' ),
						'description' => esc_html__( 'Enter the height of the banner in pixels.', 'cd-header-banner' ),
						'min'         => 10,
						'max'         => 500,
						'step'        => 1,
						'default'     => 70,
					],
					[
						'id'          => 'height_mobile',
						'type'        => 'range',
						'label'       => esc_html__( 'Banner height (Mobile)', 'cd-header-banner' ),
						'description' => esc_html__( 'Enter the height of the banner in pixels.', 'cd-header-banner' ),
						'min'         => 10,
						'max'         => 500,
						'step'        => 1,
						'default'     => 50,
					],
				],
				'metabox'
			);

			Fields::get_section(
				[
					'label' => esc_html__( 'Content', 'cd-header-banner' ),
				],
				[
					[
						'id'          => 'text',
						'type'        => 'textarea',
						'label'       => esc_html__( 'Banner Text', 'cd-header-banner' ),
						'description' => esc_html__( 'Enter the text for the banner.', 'cd-header-banner' ),
					],
					[
						'id'          => 'link',
						'type'        => 'link',
						'label'       => esc_html__( 'Banner Link', 'cd-header-banner' ),
						'description' => esc_html__( 'Enter the URL for the banner.', 'cd-header-banner' ),
					],
					[
						'id'          => 'target_blank',
						'type'        => 'switcher',
						'label'       => esc_html__( 'Open link in a new tab', 'cd-header-banner' ),
						'description' => esc_html__( 'Check this box to open the link in a new tab.', 'cd-header-banner' ),
						'default'     => true,
					],
				],
				'metabox'
			);

			Fields::get_section(
				[
					'label' => esc_html__( 'Conditional logic', 'cd-header-banner' ),
				],
				[
					[
						'id'          => 'show_on',
						'type'        => 'dropdown',
						'label'       => esc_html__( 'Show on', 'cd-header-banner' ),
						'description' => esc_html__( 'Select post to display banner.', 'cd-header-banner' ),
						'options'     => 'all_posts_options',
					],
				],
				'metabox'
			);
			?>
		</div>
		<?php
	}
}