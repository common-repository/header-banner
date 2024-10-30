<?php

namespace CDHeaderBanner\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Admin that handles the admin area.
 *
 * @since 1.0.0
 */
class Admin {

	/**
	 * Get a single instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Admin
	 */
	public static function get_instance(): Admin {

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

		PostType::get_instance();
		Metabox::get_instance();
	}

	/**
	 * Hooks.
	 *
	 * @since 1.0.0
	 */
	protected function hooks() {

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Enqueue styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		if ( ! $this->is_header_banner_page() ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style(
			'cd-header-banner-admin',
			CD_HEADER_BANNER_URL . 'assets/css/admin/styles.min.css',
			[],
			CD_HEADER_BANNER_VERSION
		);
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		if ( ! $this->is_header_banner_page() ) {
			return;
		}

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script(
			'wp-color-picker-alpha',
			CD_HEADER_BANNER_URL . 'assets/js/admin/wp-color-picker-alpha.min.js',
			[ 'wp-color-picker' ],
			CD_HEADER_BANNER_VERSION,
			[ 'in_footer' => true ]
		);
		wp_enqueue_script(
			'cd-header-banner-admin',
			CD_HEADER_BANNER_URL . 'assets/js/admin/scripts.min.js',
			[ 'jquery' ],
			CD_HEADER_BANNER_VERSION,
			[ 'in_footer' => true ]
		);
	}

	/**
	 * Check if the current page is the header banner page.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private function is_header_banner_page(): bool {

		$current_screen = get_current_screen();

		if ( is_null( $current_screen ) ) {
			return false;
		}

		if ( $current_screen->post_type !== 'cd_header_banner' ) {
			return false;
		}

		return true;
	}
}
