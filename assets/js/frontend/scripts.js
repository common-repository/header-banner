const CDHeaderBannerFrontend = window.CDHeaderBannerFrontend || ( function( document, window, $ ) {
	/**
	 * Elements holder.
	 *
	 * @since 1.0.0
	 *
	 * @type {Object}
	 */
	const el = {};

	/**
	 * Public functions and properties.
	 *
	 * @since 1.0.0
	 *
	 * @type {Object}
	 */
	const app = {

		/**
		 * Start the engine.
		 *
		 * @since 1.0.0
		 */
		init() {
			$( app.ready );
		},

		/**
		 * Document ready.
		 *
		 * @since 1.0.0
		 */
		ready() {
			app.events();

			app.headerBanner();
		},

		/**
		 * Events.
		 *
		 * @since 1.0.0
		 */
		events() {
		},

		headerBanner() {
			if ( typeof Cookies === 'undefined' ) {
				return;
			}

			$( '.cd-header-banner' ).each( function() {
				const $banner = $( this );
				const bannerVersion = $banner.data( 'version' );
				const bannerID = $banner.data( 'id' );
				const bannerCookieName = 'cd_header_banner_' + bannerVersion + '_' + bannerID;
				const $bannerCloseBtn = $banner.find( '.cd-header-banner-close' );

				if ( 'closed' === Cookies.get( bannerCookieName ) ) {
					return;
				}

				$bannerCloseBtn.on( 'click', function() {
					$banner.slideUp();

					Cookies.set(bannerCookieName, 'closed', {
						expires: 60,
						path   : '/',
					});
				} );
			} );
		}
	};

	return app;
}( document, window, jQuery ) );

// Initialize.
CDHeaderBannerFrontend.init();
