<?php

namespace CDHeaderBanner;

defined( 'ABSPATH' ) || exit;

/**
 * Class Frontend that handles the frontend area.
 *
 * @since 1.0.0
 */
final class Frontend {

	/**
	 * Get a single instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Frontend
	 */
	public static function get_instance(): Frontend {

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

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'wp_body_open', [ $this, 'render_banner' ] );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			'cd-header-banner-frontend',
			CD_HEADER_BANNER_URL . 'assets/js/frontend/scripts.min.js',
			[ 'jquery' ],
			CD_HEADER_BANNER_VERSION,
			[ 'in_footer' => true ]
		);

		wp_enqueue_script(
			'js.cookie',
			CD_HEADER_BANNER_URL . 'assets/js/frontend/js.cookie.min.js',
			[],
			CD_HEADER_BANNER_VERSION,
			[ 'in_footer' => true ]
		);
	}

	/**
	 * Enqueue styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		if ( ! $this->is_page_with_banner() ) {
			return;
		}

		wp_enqueue_style( 'dashicons' );

		wp_enqueue_style(
			'cd-header-banner-frontend',
			CD_HEADER_BANNER_URL . 'assets/css/frontend/styles.min.css',
			[],
			CD_HEADER_BANNER_VERSION
		);
	}

	/**
	 * Get the banners.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	private function get_banners(): array {

		return get_posts(
			[
				'post_type'      => 'cd_header_banner',
				'posts_per_page' => 10,
				'post_status'    => 'publish',
			]
		);
	}

	/**
	 * Check if the current page is a blog archive.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private function is_page_with_banner(): bool { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh

		$banners = $this->get_banners();

		if ( empty( $banners ) ) {
			return false;
		}

		foreach ( $banners as $banner ) {
			if ( $this->is_show_banner( $banner->ID ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if the banner is closed.
	 *
	 * @since 1.0.0
	 *
	 * @param int $banner_id The banner ID.
	 * @param int $version   The banner version.
	 *
	 * @return bool
	 */
	private function is_banner_closed( int $banner_id, int $version ): bool {

		$cookie_name = 'cd_header_banner_' . $version . '_' . $banner_id;

		return isset( $_COOKIE[ $cookie_name ] );
	}

	/**
	 * Generate the styles.
	 *
	 * @since 1.0.0
	 *
	 * @param int $banner_id The banner ID.
	 *
	 * @return string
	 */
	private function generate_styles( int $banner_id ): string { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh

		ob_start();

		$background_color = get_post_meta( $banner_id, 'background_color', true );
		$background_image = get_post_meta( $banner_id, 'background_image', true );
		$text_color       = get_post_meta( $banner_id, 'text_color', true );
		$height_desktop   = get_post_meta( $banner_id, 'height_desktop', true );
		$height_tablet    = get_post_meta( $banner_id, 'height_tablet', true );
		$height_mobile    = get_post_meta( $banner_id, 'height_mobile', true );

		?>
		<style>
			<?php if ( $background_color || $text_color || $height_desktop || $background_image ) : ?>
				.cd-header-banner {
					<?php if ( $background_color ) : ?>
						background-color: <?php echo esc_attr( $background_color ); ?>;
					<?php endif; ?>

					<?php if ( $background_image ) : ?>
						<?php
						$image     = wp_get_attachment_image_src( $background_image, 'full' );
						$image_src = $image[0] ?? '';
						?>
						<?php if ( $image_src ) : ?>
							background-image: url( <?php echo esc_attr( $image_src ); ?> );
							background-size: cover;
							background-repeat: no-repeat;
							background-position: center center;
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $text_color ) : ?>
						color: <?php echo esc_attr( $text_color ); ?>;
					<?php endif; ?>

					<?php if ( $height_desktop ) : ?>
						height: <?php echo esc_attr( $height_desktop ); ?>px;
					<?php endif; ?>
				}
			<?php endif; ?>

			<?php if ( $height_tablet ) : ?>
				@media (max-width: 768px) {
					.cd-header-banner {
						height: <?php echo esc_attr( $height_tablet ); ?>px;
					}
				}
			<?php endif; ?>

			<?php if ( $height_mobile ) : ?>
				@media (max-width: 768px) {
					.cd-header-banner {
						height: <?php echo esc_attr( $height_mobile ); ?>px;
					}
				}
			<?php endif; ?>
		</style>
		<?php

		return ob_get_clean();
	}

	/**
	 * Check if the banner should be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @param int $banner_id The banner ID.
	 *
	 * @return bool
	 */
	private function is_show_banner( int $banner_id ): bool { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh

		$show_banner       = get_post_meta( $banner_id, 'show', true );
		$post_id_condition = get_post_meta( $banner_id, 'show_on', true );
		$version           = get_post_meta( $banner_id, 'version', true );

		if ( $this->is_banner_closed( $banner_id, $version ) ) {
			return false;
		}

		if ( ! $show_banner ) {
			return false;
		}

		if ( $post_id_condition !== 'everywhere' ) {
			if ( $post_id_condition === 'home' && ! is_front_page() ) {
				return false;
			}

			if ( $post_id_condition === 'blog' && ! cd_header_banner_is_blog_archive() ) {
				return false;
			}

			if ( $post_id_condition !== 'home' && $post_id_condition !== 'blog' && $post_id_condition !== get_the_ID() ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Output the banner.
	 *
	 * @since 1.0.0
	 */
	public function render_banner() { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh, Generic.Metrics.CyclomaticComplexity.MaxExceeded

		$banners = $this->get_banners();

		if ( empty( $banners ) ) {
			return;
		}

		foreach ( $banners as $banner ) {
			if ( ! $this->is_show_banner( $banner->ID ) ) {
				continue;
			}

			$banner_text  = get_post_meta( $banner->ID, 'text', true );
			$banner_link  = get_post_meta( $banner->ID, 'link', true );
			$close_button = get_post_meta( $banner->ID, 'close_button', true );
			$target       = get_post_meta( $banner->ID, 'target_blank', true );
			$version      = get_post_meta( $banner->ID, 'version', true );

			echo $this->generate_styles( $banner->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			?>

			<div class="cd-header-banner" data-id="<?php echo esc_attr( $banner->ID ); ?>" data-version="<?php echo esc_attr( $version ); ?>">
				<a class="cd-header-banner-link" href="<?php echo esc_url( $banner_link ); ?>" target="<?php echo esc_attr( $target ? '_blank' : '_self' ); ?>"></a>

				<div class="cd-header-banner-text">
					<?php echo do_shortcode( $banner_text ); ?>
				</div>

				<?php if ( $close_button ) : ?>
					<div class="cd-header-banner-close" title="<?php esc_attr_e( 'Close banner', 'cd-header-banner' ); ?>">
						<span class="dashicons dashicons-no-alt"></span>
					</div>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}
