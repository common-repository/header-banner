const CDHeaderBannerAdmin = window.CDHeaderBannerAdmin || ( function( document, window, $ ) {
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
			app.initColorPicker();
			app.rangeSliderField();
			app.uploadField();
		},

		/**
		 * Events.
		 *
		 * @since 1.0.0
		 */
		events() {
		},

		/**
		 * Initialize color picker.
		 *
		 * @since 1.0.0
		 */
		initColorPicker() {
			$( '.cd-header-banner-color-picker' ).wpColorPicker();
		},

		/**
		 * Range slider.
		 */
		rangeSliderField() {
			$( '.cd-header-banner-range' ).each( function() {
				const $this = $( this );
				const $input = $this.siblings( '.cd-header-banner-range-value' );

				$this.on( 'input', function() {
					$input.val( $this.val() );
				} );

				$input.on( 'input', function() {
					$this.val( $input.val() );
				} );

				$input.val( $this.val() );
			} );

		},

		uploadField() {
			$( '.cd-header-banner-upload' ).each( function() {
				const $field = $( this );
				const $input = $field.find( '.cd-header-banner-upload-input' );
				const $button = $field.find( '.cd-header-banner-upload-button' );
				const $preview = $field.find( '.cd-header-banner-upload-preview' );
				const $remove = $field.find( '.cd-header-banner-upload-remove' );

				$remove.on( 'click', function( e ) {
					e.preventDefault();

					$preview.attr( 'src', '' ).hide();
					$input.val( '' );
					$remove.hide();
					$button.show();
				} );

				$button.on( 'click', function( e ) {
					e.preventDefault();

					const frame = wp.media( {
						multiple: false
					} );

					frame.on( 'select', function() {
						const attachment = frame.state().get( 'selection' ).first().toJSON();

						console.log(attachment);

						$preview.attr( 'src', attachment.url ).show();
						$remove.show();
						$input.val( attachment.id );
						$button.hide();
					} );

					frame.open();
				} );
			} );
		}
	};

	return app;
}( document, window, jQuery ) );

// Initialize.
CDHeaderBannerAdmin.init();
