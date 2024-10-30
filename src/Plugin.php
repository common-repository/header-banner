<?php

namespace CDHeaderBanner;

use CDHeaderBanner\Admin\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Plugin that loads the whole plugin.
 *
 * @since 1.0.0
 */
final class Plugin {

	/**
	 * Get a single instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Plugin
	 */
	public static function get_instance(): Plugin {

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

		Admin::get_instance();
		Frontend::get_instance();

		$this->includes();
	}

	/**
	 * Include files.
	 *
	 * @since 1.0.0
	 */
	protected function includes() {

		require_once CD_HEADER_BANNER_PLUGIN_PATH . 'includes/functions.php';
	}
}
