wp.customize.controlConstructor['dt-responsive-number'] = wp.customize.Control.extend({
	ready: function() {

		'use strict';
		var control = this,
			value;

		this.container.on( 'change keyup paste', 'input.dt-responsive-input, select.dt-responsive-select', function() {

			value = jQuery( this ).val();
			control.updateValue();
		});

		control.resetValue();
	},

	updateValue: function() {

		'use strict';
		var	control  = this,
			newValue = {};

		control.responsiveContainer = control.container.find( '.wrapper' ).first();
		control.responsiveContainer.find( 'input.dt-responsive-input' ).each( function(){
			var $input = jQuery(this),
				$item = $input.data( 'id' ),
				$item_value =$input.val();

			newValue[$item] = $item_value;
		});

		control.responsiveContainer.find( 'select.dt-responsive-select' ).each( function(){
			var $input = jQuery(this),
				$item = $input.data( 'id' ),
				$item_value =$input.val();

			newValue[$item] = $item_value;
		});

		control.setting.set( newValue );					
	},

	resetValue: function(){

		'use strict';
		var	control = this;
		
		control.container.find(".item-reset").on('click', function(){
			
			control.container.find('input[data-id="desktop"]').attr('value', control.params.value.desktop );
			control.container.find('select[data-id="desktop-unit"]').find("option:selected").removeAttr("selected");
			control.container.find('select[data-id="desktop-unit"]').find('option[value="'+control.params.value['desktop-unit']+'"]').prop("selected", true);

			control.container.find('input[data-id="tablet"]').attr('value', control.params.value.tablet );
			control.container.find('select[data-id="tablet-unit"]').find("option:selected").removeAttr("selected");
			control.container.find('select[data-id="tablet-unit"]').find('option[value="'+control.params.value['tablet-unit']+'"]').prop("selected", true);

			control.container.find('input[data-id="tablet-landscape"]').attr('value', control.params.value.tablet );
			control.container.find('select[data-id="tablet-ls-unit"]').find("option:selected").removeAttr("selected");
			control.container.find('select[data-id="tablet-ls-unit"]').find('option[value="'+control.params.value['tablet-ls-unit']+'"]').prop("selected", true);
			
			control.container.find('input[data-id="mobile"]').attr('value', control.params.value.mobile );
			control.container.find('select[data-id="mobile-unit"]').find("option:selected").removeAttr("selected");
			control.container.find('select[data-id="mobile-unit"]').find('option[value="'+control.params.value['mobile-unit']+'"]').prop("selected", true);

			control.setting.set( control.params.value );			
		});
	}	
});