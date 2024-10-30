<?php

namespace CDHeaderBanner\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class PostType that handles the post type.
 *
 * @since 1.0.0
 */
class PostType {

	/**
	 * Get a single instance.
	 *
	 * @since 1.0.0
	 *
	 * @return PostType
	 */
	public static function get_instance(): PostType {

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
	protected function hooks() {

		add_action( 'init', [ $this, 'register_post_type' ] );
	}

	/**
	 * Register the post type.
	 *
	 * @since 1.0.0
	 */
	public function register_post_type() {

		$args = [
			'labels'    => [
				'name'           => esc_attr_x( 'Header Banners', 'post type general name', 'cd-header-banner' ),
				'all_items'      => esc_html__( 'All Banners', 'cd-header-banner' ),
				'add_new'        => esc_html__( 'Add New', 'cd-header-banner' ),
				'item_updated'   => esc_html__( 'Banner updated.', 'cd-header-banner' ),
				'item_published' => esc_html__( 'Banner published.', 'cd-header-banner' ),
				'add_new_item'   => esc_html__( 'Add New Banner', 'cd-header-banner' ),
				'item_trashed'   => esc_html__( 'Banner trashed.', 'cd-header-banner' ),
			],
			'public'    => false,
			'show_ui'   => true,
			'supports'  => [ 'title' ],
			'menu_icon' => 'dashicons-format-image',
		];

		register_post_type( 'cd_header_banner', $args );
	}
}
