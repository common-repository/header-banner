<?php

namespace CDHeaderBanner\Admin\Fields;

/**
 * Dropdown field.
 *
 * @since 1.0.0
 */
class Dropdown extends Field {

	/**
	 * Get field HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function field() {

		?>
		<select
			id="<?php echo esc_attr( $this->get_name() ); ?>"
			name="<?php echo esc_attr( $this->get_name() ); ?>">

			<?php foreach ( $this->get_options() as $key => $value ) : ?>
				<option
					value="<?php echo esc_attr( $key ); ?>"
					<?php selected( $this->get_value(), $key ); ?>>
					<?php echo esc_html( $value ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	/**
	 * Get options.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	private function get_options(): array {

		if ( is_string( $this->args['options'] ) ) {
			$method = $this->args['options'];

			if ( method_exists( $this, $method ) ) {
				return $this->$method();
			}
		}

		return $this->args['options'] ?? [];
	}

	/**
	 * Get all posts options.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function all_posts_options(): array {

		/**
		 * Filter the post types for the dropdown field.
		 *
		 * @since 1.0.0
		 *
		 * @param array $post_types Post types.
		 */
		$post_types = apply_filters( 'cd_header_banner_admin_fields_dropdown_post_types', [ 'post', 'page' ] );

		$posts = get_posts(
			[
				'post_type'      => $post_types,
				'posts_per_page' => - 1,
			]
		);

		$options = [
			'everywhere' => esc_html__( 'Everywhere', 'cd-header-banner' ),
			'home'       => esc_html__( 'Home page', 'cd-header-banner' ),
			'blog'       => esc_html__( 'Blog page', 'cd-header-banner' ),
		];

		foreach ( $posts as $post ) {
			$options[ $post->ID ] = $post->post_title . ' (ID: ' . $post->ID . ' - ' . $post->post_type . ')';
		}

		return $options;
	}
}