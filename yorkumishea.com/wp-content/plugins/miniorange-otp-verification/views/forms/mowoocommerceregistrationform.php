<?php
/**
 * Load admin view for WooCommerceRegistrationForm.
 *
 * @package miniorange-otp-verification/views/forms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '	<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '">
	        <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
	                id="wc_default" 
	                data-toggle="wc_default_options" 
	                class="app_enable" 
	                name="mo_customer_validation_wc_default_enable" 
	                value="1"
		            ' . esc_attr( $woocommerce_registration ) . ' />
            <strong>' . esc_html( $form_name ) . '</strong>';

echo '		<div class="mo_registration_help_desc" id="wc_default_options">
				<b>' . esc_html( mo_( 'Choose between Phone or Email Verification' ) ) . '</b>
				<div>
				     <input type ="checkbox" ' . esc_attr( $disabled ) . ' 
				            id ="wcreg_mo_view" 
				            data-toggle = "wcreg_mo_ajax_view_option" 
				            class="app_enable" 
                            name = "mo_customer_validation_wc_is_ajax_form" 
                            value= "1" ' . esc_attr( $is_ajax_mode_enabled ) . '/>
                     <Strong>' . esc_html( mo_( 'Do not show a popup. Validate user on the form itself.' ) ) . '</strong>
                     <div   ' . ( esc_attr( $is_ajax_form ) ? '' : 'style=display:none' ) . ' 
                            id="wcreg_mo_ajax_view_option" 
                            class="mo_registration_help_desc_internal">
                        <div class="mo_otp_note" style="color:red">
                            ' . esc_html( mo_( 'This mode does not work with Let the user choose option. Please use either phone or email only.' ) ) . ' </div>                           
						<div>
							<div class="pt-mo-4">
								<div class="mo-input-wrapper">
									<label class="mo-input-label">' . esc_html( mo_( 'Verification Button text' ) ) . '</label>
									<input class=" mo-form-input" 
										placeholder="Enter the verification button text" 
										value="' . esc_attr( $wc_button_text ) . '" 
										type="text" name="mo_customer_validation_wc_button_text" >
								</div>
							</div>
					    </div>
                     </div>
                </div>
				<div>
					<input  type="radio" ' . esc_attr( $disabled ) . ' 
					        id="wc_phone" 
					        class="app_enable" 
					        data-toggle="wc_phone_options" 
					        name="mo_customer_validation_wc_enable_type" 
					        value="' . esc_attr( $wc_reg_type_phone ) . '"
						    ' . ( esc_attr( $wc_enable_type ) === esc_attr( $wc_reg_type_phone ) ? 'checked' : '' ) . '/>
                    <strong> ' . esc_html( mo_( 'Enable Phone Verification' ) ) . '</strong>
				</div>
				<div    ' . ( esc_attr( $wc_enable_type ) !== esc_attr( $wc_reg_type_phone ) ? 'style=display:none' : '' ) . ' 
                        class="mo_registration_help_desc_internal" 
						id="wc_phone_options" >
                    <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
                            name="mo_customer_validation_wc_restrict_duplicates" value="1"
                            ' . esc_attr( $wc_restrict_duplicates ) . ' />
                    <strong>' . esc_html( mo_( 'Do not allow users to use the same phone number for multiple accounts.' ) ) . '</strong>
				</div>
				<div>
					<input  type="radio" ' . esc_attr( $disabled ) . ' 
					        id="wc_email" 
					        class="app_enable" 
					        name="mo_customer_validation_wc_enable_type" 
					        value="' . esc_attr( $wc_reg_type_email ) . '"
						    ' . ( esc_attr( $wc_enable_type ) === esc_attr( $wc_reg_type_email ) ? 'checked' : '' ) . '/>
                    <strong>' . esc_html( mo_( 'Enable Email Verification' ) ) . '</strong>
				</div>
				<div>
					<input  type="radio" 
					        ' . esc_attr( $disabled ) . ' 
					        id="wc_both" 
					        class="app_enable" 
					        data-toggle="wc_both_options" 
					        name="mo_customer_validation_wc_enable_type" 
					        value="' . esc_attr( $wc_reg_type_both ) . '"
						    ' . ( esc_attr( $wc_enable_type ) === esc_attr( $wc_reg_type_both ) ? 'checked' : '' ) . '/>
                    <strong>' . esc_html( mo_( 'Let the user choose' ) ) . '</strong>';


					echo '			</div>

				<div ' . ( esc_attr( $wc_enable_type ) !== esc_attr( $wc_reg_type_both ) ? 'style=display:none' : '' ) . ' class="mo_registration_help_desc_internal" 
						id="wc_both_options" >
                    <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
                            name="mo_customer_validation_wc_restrict_duplicates" value="1"
                            ' . esc_attr( $wc_restrict_duplicates ) . ' />
                    <strong>' . esc_html( mo_( 'Do not allow users to use the same phone number for multiple accounts.' ) ) . '</strong>
				</div>
				<div >
					<input type ="checkbox" ' . esc_attr( $disabled ) . ' 
				            id ="wcreg_mo_redirect_after_registration" 
				            data-toggle = "wcreg_mo_rediect_page" 
				            class="app_enable" 
                            name = "mo_customer_validation_wcreg_redirect_after_registration" 
                            value= "1" ' . esc_attr( $is_redirect_after_registration_enabled ) . '/>
                     <Strong>' . esc_html( mo_( 'Redirect User to a specific page after registration.' ) ) . '</strong>
                    <div class="mo_registration_help_desc_internal" ' . esc_attr( $wc_hidden ) . ' id="wcreg_mo_rediect_page">
					<b>' . esc_html( mo_( 'Select page to redirect to after registration' ) ) . ': </b>';
					wp_dropdown_pages(
						array(
							'name'     => 'mo_wc_reg_page_id',
							'selected' => esc_attr( $redirect_page_id ),
						)
					);
					echo '					</div>	
				</div>';
					echo '		</div>
					
		</div>';
