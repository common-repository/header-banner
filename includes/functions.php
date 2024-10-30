<?php

/**
 * Get the settings from the database.
 *
 * @since 1.0.0
 *
 * @param string $key           The key to get.
 * @param mixed  $default_value The default value.
 * @param string $option        The option name.
 *
 * @return mixed
 */
function cd_header_banner_get_settings( string $key, $default_value, string $option = 'cd_header_banner' ) {

	$options = get_option( $option );

	return ! empty( $options[ $key ] ) ? $options[ $key ] : $default_value;
}

/**
 * Get the post meta.
 *
 * @since 1.0.0
 *
 * @param string $key           The key to get.
 * @param mixed  $default_value The default value.
 *
 * @return mixed
 */
function cd_header_banner_get_post_meta( string $key, $default_value ) {

	$db_value = get_post_meta( get_the_ID(), $key, true );

	return ! empty( $db_value ) ? $db_value : $default_value;
}

/**
 * Check if the current page is a blog archive.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function cd_header_banner_is_blog_archive(): bool {

	return is_home() || is_search() || is_tag() || is_category() || is_date() || is_author();
}
