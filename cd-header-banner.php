<?php
/**
 * Plugin Name: Header Banner
 * Description: This plugin adds a banner to the header of your website.
 * Author: Ernest Behinov
 * Version: 1.0.0
 * Author URI: https://profiles.wordpress.org/ernest35
 * Text Domain: cd-header-banner
 * Requires at least: 6.3
 * Requires PHP: 7.0
 * License: GPLv2 or later
 */

use CDHeaderBanner\Plugin;

defined( 'ABSPATH' ) || exit;

/**
 * Plugin file.
 *
 * @since 1.0.0
 */
const CD_HEADER_BANNER_FILE = __FILE__;

/**
 * Plugin URL.
 *
 * @since 1.0.0
 */
define( 'CD_HEADER_BANNER_URL', plugin_dir_url( CD_HEADER_BANNER_FILE ) );

/**
 * Plugin path.
 *
 * @since 1.0.0
 */
define( 'CD_HEADER_BANNER_PLUGIN_PATH', plugin_dir_path( CD_HEADER_BANNER_FILE ) );

/**
 * Plugin version.
 *
 * @since 1.0.0
 */
const CD_HEADER_BANNER_VERSION = '1.0.0';

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

Plugin::get_instance();
