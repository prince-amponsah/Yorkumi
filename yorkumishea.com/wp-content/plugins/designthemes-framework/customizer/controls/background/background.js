jQuery(window).on("load", function() {
	jQuery('html').addClass('background-colorpicker-ready');
});

wp.customize.controlConstructor['dt-background'] = wp.customize.Control.extend({

	ready: function(){
		'use strict';
		var control = this;

		control.initBgControl();
	},

	initBgControl: function(){
		'use strict';
		var control = this,
			value   = control.setting._value,
			picker  = control.container.find( '.dt-color-control' );

		// Hide unnecessary controls if the value doesn't have an image.
		if ( _.isUndefined( value['background-image']) || '' === value['background-image']) {

			control.container.find( '.background-wrapper > .background-repeat' ).hide();
			control.container.find( '.background-wrapper > .background-position' ).hide();
			control.container.find( '.background-wrapper > .background-size' ).hide();
			control.container.find( '.background-wrapper > .background-attachment' ).hide();
		}			

		// Color.
		picker.wpColorPicker({
			change: function() {

				if ( jQuery('html').hasClass('background-colorpicker-ready') ) {
					setTimeout( function() {
						control.saveValue( 'background-color', picker.val() );
					}, 100 );
				}
			},

			clear: function (event) {

				var element = jQuery(event.target).closest('.wp-picker-input-wrap').find('.wp-color-picker')[0];
		        if (element) {
					control.saveValue( 'background-color', '' );
				}
		    }
		});

		// Background-Repeat.
		control.container.on( 'change', '.background-repeat select', function() {
			control.saveValue( 'background-repeat', jQuery( this ).val() );
		});

		// Background-Size.
		control.container.on( 'change click', '.background-size input', function() {
			control.saveValue( 'background-size', jQuery( this ).val() );
		});

		// Background-Position.
		control.container.on( 'change', '.background-position select', function() {
			control.saveValue( 'background-position', jQuery( this ).val() );
		});

		// Background-Attachment.
		control.container.on( 'change click', '.background-attachment input', function() {
			control.saveValue( 'background-attachment', jQuery( this ).val() );
		});

		// Background-Image.
		control.container.on( 'click', '.background-image-upload-button', function( e ) {

			var image = wp.media({ multiple: false }).open().on( 'select', function() {

				// This will return the selected image from the Media Uploader, the result is an object.
				var uploadedImage = image.state().get( 'selection' ).first(),
					previewImage   = uploadedImage.toJSON().sizes.full.url,
					imageUrl,
					imageID,
					imageWidth,
					imageHeight,
					preview,
					removeButton;

				if ( ! _.isUndefined( uploadedImage.toJSON().sizes.medium ) ) {
					previewImage = uploadedImage.toJSON().sizes.medium.url;
				} else if ( ! _.isUndefined( uploadedImage.toJSON().sizes.thumbnail ) ) {
					previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
				}

				imageUrl    = uploadedImage.toJSON().sizes.full.url;
				imageID     = uploadedImage.toJSON().id;
				imageWidth  = uploadedImage.toJSON().width;
				imageHeight = uploadedImage.toJSON().height;

				// Show extra controls if the value has an image.
				if ( '' !== imageUrl ) {
					control.container.find( '.background-wrapper > .background-repeat, .background-wrapper > .background-position, .background-wrapper > .background-size, .background-wrapper > .background-attachment' ).show();
				}

				control.saveValue( 'background-image', imageUrl );
				preview      = control.container.find( '.placeholder, .thumbnail' );
				removeButton = control.container.find( '.background-image-upload-remove-button' );

				if ( preview.length ) {
					preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
				}
				if ( removeButton.length ) {
					removeButton.show();
				}
			});

			e.preventDefault();
		});

		control.container.on( 'click', '.background-image-upload-remove-button', function( e ) {

			var preview,
				removeButton;

			e.preventDefault();

			control.saveValue( 'background-image', '' );

			preview      = control.container.find( '.placeholder, .thumbnail' );
			removeButton = control.container.find( '.background-image-upload-remove-button' );

			// Hide unnecessary controls.
			control.container.find( '.background-wrapper > .background-repeat' ).hide();
			control.container.find( '.background-wrapper > .background-position' ).hide();
			control.container.find( '.background-wrapper > .background-size' ).hide();
			control.container.find( '.background-wrapper > .background-attachment' ).hide();
			
			control.container.find( '.more-settings' ).attr('data-direction', 'down');
			control.container.find( '.more-settings' ).find('.message').html( dtthemeCustomizerControlBackground.moreSettings );
			control.container.find( '.more-settings' ).find('.icon').html( '↓' );

			if ( preview.length ) {
				preview.removeClass().addClass( 'placeholder' ).html( dtthemeCustomizerControlBackground.placeholder );
			}
			if ( removeButton.length ) {
				removeButton.hide();
			}
		});

		control.container.on( 'click', '.more-settings', function( e ) {
			// Hide unnecessary controls.
			control.container.find( '.background-wrapper > .background-repeat' ).toggle();
			control.container.find( '.background-wrapper > .background-position' ).toggle();
			control.container.find( '.background-wrapper > .background-size' ).toggle();
			control.container.find( '.background-wrapper > .background-attachment' ).toggle();

			if( 'down' === jQuery(this).attr( 'data-direction' ) )
			{
				jQuery(this).attr('data-direction', 'up');
				jQuery(this).find('.message').html( dtthemeCustomizerControlBackground.lessSettings )
				jQuery(this).find('.icon').html( '↑' );
			} else {
				jQuery(this).attr('data-direction', 'down');
				jQuery(this).find('.message').html( dtthemeCustomizerControlBackground.moreSettings )
				jQuery(this).find('.icon').html( '↓' );
			}
		});
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			input   = jQuery( '#customize-control-' + control.id.replace( '[', '-' ).replace( ']', '' ) + ' .background-hidden-value' ),
			val     = control.setting._value;

		val[ property ] = value;

		jQuery( input ).attr( 'value', JSON.stringify( val ) ).trigger( 'change' );
		control.setting.set( val );
	}	

});