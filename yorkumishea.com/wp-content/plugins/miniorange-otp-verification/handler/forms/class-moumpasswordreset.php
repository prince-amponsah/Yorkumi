<?php
/**
 * Handler Functions for Ultimate Member Password Reset Form.
 *
 * @package miniorange-otp-verification/handler/forms
 */

namespace OTP\Handler\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoFormDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use \WP_User;

/**
 * Password Reset Handler handles sending an OTP to the user instead of
 * the link that usually gets sent out to the user's email address.
 */
if ( ! class_exists( 'MoUMPasswordReset' ) ) {
	/**
	 * MoUMPasswordReset class
	 */
	class MoUMPasswordReset extends FormHandler implements IFormHandler {

		use Instance;

		/**
		 * Used to get username field key.
		 *
		 * @var string $field_key username field key.
		 */
		private $field_key;

		/**
		 * Check for only Phone verification.
		 *
		 * @var boolean $is_only_phone_reset if only phone allowed
		 */
		private $is_only_phone_reset;
		/**
		 * Initializes values
		 */
		protected function __construct() {

			$this->is_ajax_form        = true;
			$this->form_session_var    = FormSessionVars::UM_PASS_RESET;
			$this->type_phone_tag      = 'mo_um_phone_enable';
			$this->type_email_tag      = 'mo_um_email_enable';
			$this->phone_form_id       = '';
			$this->field_key           = 'username_b';
			$this->form_key            = 'UM_PASS_RESET';
			$this->form_name           = mo_( 'Ultimate Member Password Reset Form' );
			$this->is_form_enabled     = get_option( 'mo_um_pr_pass_enable' ) ? true : false;
			$this->phone_key           = get_option( 'mo_um_pr_passphone_key' );
			$this->phone_key           = $this->phone_key ? $this->phone_key : 'mobile_number';
			$this->form_documents      = MoFormDocs::UM_PASS_RESET_FORM_LINK;
			$this->generate_otp_action = 'mo_umpr_send_otp';
			$this->validate_otp_action = 'mo_umpr_validate_otp';
			$this->button_text         = get_option( 'mo_um_pr_pass_button_text' );
			$this->button_text         = ! MoUtility::is_blank( $this->button_text ) ? $this->button_text : mo_( 'Send OTP' );

			parent::__construct();
		}

		/**
		 * Function checks if form has been enabled by the admin and initializes
		 * all the class variables. This function also defines all the hooks to
		 * hook into to make OTP Verification possible.
		 */
		public function handle_form() {

			$this->otp_type            = get_option( 'mo_um_pr_enabled_type' );
			$this->is_only_phone_reset = get_option( 'mo_um_pr_only_phone_reset' );

			if ( $this->is_only_phone_reset ) {
				$this->phone_form_id = 'input#username_b';
			}
			add_action( 'wp_ajax_nopriv_' . $this->generate_otp_action, array( $this, 'send_ajax_otp_request' ) );
			add_action( 'wp_ajax_' . $this->generate_otp_action, array( $this, 'send_ajax_otp_request' ) );

			add_action( 'wp_ajax_nopriv_' . $this->validate_otp_action, array( $this, 'mo_verify_ajax_otp_request' ) );
			add_action( 'wp_ajax_' . $this->validate_otp_action, array( $this, 'mo_verify_ajax_otp_request' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'miniorange_register_um_script' ) );

			add_action( 'um_reset_password_errors_hook', array( $this, 'um_reset_password_errors_hook' ), 99 );
			add_action( 'um_reset_password_process_hook', array( $this, 'um_reset_password_process_hook' ), 1 );
		}

		/**
		 * Send an OTP to the user's phone or email.
		 *
		 * @throws \ReflectionException On error.
		 */
		public function send_ajax_otp_request() {
			if ( ! check_ajax_referer( $this->nonce, $this->nonce_key ) ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::UNKNOWN_ERROR ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
				exit;
			}
			MoUtility::initialize_transaction( $this->form_session_var );
			$data     = MoUtility::mo_sanitize_array( $_POST );
			$username = MoUtility::sanitize_check( 'username', $data );
			$user     = $this->getUser( $username );
			SessionUtils::add_user_in_session( $this->form_session_var, $username );

			if ( ! $user ) {
				if ( $this->is_only_phone_reset ) {
					wp_send_json(
						MoUtility::create_json(
							MoMessages::showMessage( MoMessages::RESET_LABEL_OP ),
							MoConstants::ERROR_JSON_TYPE
						)
					);
				} else {
					wp_send_json(
						MoUtility::create_json(
							MoMessages::showMessage( MoMessages::USERNAME_NOT_EXIST ),
							MoConstants::ERROR_JSON_TYPE
						)
					);
				}
			} else {
				SessionUtils::add_user_in_session( $this->form_session_var, $username );
				$phone = get_user_meta( $user->ID, $this->phone_key, true );
				$this->startOtpTransaction( $user->user_email, $phone, $data );
			}
		}

		/**
		 * The function is called to start the OTP Transaction based on the OTP Type
		 * set by the admin in the settings.
		 *
		 * @param string $email        - the email associted with the user.
		 * @param string $phone_number - the phone number associted with the user.
		 * @param array  $data   - the data submitted during ajax call.
		 */
		private function startOtpTransaction( $email, $phone_number, $data ) {
			if ( strcasecmp( $this->otp_type, $this->type_phone_tag ) === 0 ) {
				if ( empty( $phone_number ) ) {
					wp_send_json(
						MoUtility::create_json(
							MoMessages::showMessage( MoMessages::PHONE_NOT_FOUND ),
							MoConstants::ERROR_JSON_TYPE
						)
					);
				}
				$this->send_challenge( $data['username'], $email, null, $phone_number, VerificationType::PHONE );
			} else {
				$this->send_challenge( $data['username'], $email, null, $phone_number, VerificationType::EMAIL );
			}
		}

		/**
		 * This function registers the js file for enabling OTP Verification
		 * for Ultimate Member using AJAX calls.
		 */
		public function miniorange_register_um_script() {
			wp_register_script( 'moumpr', MOV_URL . 'includes/js/moumpassreset.min.js', array( 'jquery' ), MOV_VERSION, true );
			wp_localize_script(
				'moumpr',
				'moumprvar',
				array(
					'siteURL'        => wp_ajax_url(),
					'nonce'          => wp_create_nonce( $this->nonce ),
					'buttontext'     => mo_( $this->button_text ),
					'action'         => array( 'send' => $this->generate_otp_action ),
					'vaction'        => $this->validate_otp_action,
					'fieldKey'       => $this->field_key,
					'resetLabelText' => MoMessages::showMessage(
						$this->is_only_phone_reset
										? MoMessages::RESET_LABEL_OP : MoMessages::RESET_LABEL
					),
					'phText'         => $this->is_only_phone_reset
										? mo_( 'Enter Your Phone Number' ) : mo_( 'Enter Your Email, Username or Phone Number' ),
				)
			);
			wp_enqueue_script( 'moumpr' );
		}

		/**
		 * Checks if the verification has started or not and then validates the
		 * OTP submitted.
		 */
		public function mo_verify_ajax_otp_request() {
			if ( ! check_ajax_referer( $this->nonce, $this->nonce_key ) ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::INVALID_OP ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
				exit;
			}

			$data = MoUtility::mo_sanitize_array( $_POST );
			$this->checkIfOTPSent();
			$this->checkIntegrityAndValidateOTP( $data );
		}

		/**
		 * The function is used to check if user has provided
		 * OTP to initiate OTP verification.
		 */
		private function checkIfOTPSent() {
			if ( ! SessionUtils::is_otp_initialized( $this->form_session_var ) ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::ENTER_VERIFY_CODE ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
			}
		}

		/**
		 * Call function for the um_reset_password_error_hook to
		 * check if the user has started the password reset flow.
		 * Check if user is entering his phone number and fetch user
		 * based off on that.
		 * <br/><br/>
		 * If all checks pass then validate the OTP as well.
		 */
		public function um_reset_password_errors_hook() {
			$form     = $this->getum_formObj();
			$data     = MoUtility::mo_sanitize_array( $_POST );  // phpcs:ignore WordPress.Security.NonceVerification.Missing -- No need for nonce verification as the function is called on third party plugin hook.
			$username = MoUtility::sanitize_check( $this->field_key, $data );

			if ( isset( $form->errors ) ) {
				if ( strcasecmp( $this->otp_type, $this->type_phone_tag ) === 0
				&& MoUtility::validate_phone_number( $username ) ) {
					$user = $this->getUserFromPhoneNumber( $username );
					if ( ! $user ) {
						$form->add_error(
							$this->field_key,
							MoMessages::showMessage( MoMessages::USERNAME_NOT_EXIST )
						);
					} else {
						$form->errors = null;
						if ( ! isset( $form->errors ) ) {
							$this->check_reset_password_limit( $form, $user->ID );
						}
					}
				}
			}
		}

		/**
		 * Check Integrity of the email or phone number. i.e. Ensure that the Email or
		 * Phone that the OTP was sent to is the same Email or Phone that is being submitted
		 * with the form.
		 * Once integrity check passes validate the OTP to ensure that the user has entered
		 * the correct OTP.
		 *
		 * @param array $data to get the data of the ajax request.
		 */
		private function checkIntegrityAndValidateOTP( $data ) {

			$otp_ver_type = $this->get_verification_type();
			$this->checkIntegrity( $data );
			$this->validate_challenge( $otp_ver_type, null, $data['otp_token'] );

			if ( SessionUtils::is_status_match( $this->form_session_var, self::VALIDATED, $otp_ver_type ) ) {
				wp_send_json(
					MoUtility::create_json(
						( 'Success! Redirecting to the password reset page....' ),
						MoConstants::SUCCESS_JSON_TYPE
					)
				);
				$this->get_user_and_reset_password( $data );
			} else {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::INVALID_OTP ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
			}
		}

		/**
		 * This function checks the integrity of the phone or email value that was submitted
		 * with the form. It needs to match with the email or value that the OTP was
		 * initially sent to.
		 *
		 * @param array $data - Data passed in the ajax call.
		 */
		private function checkIntegrity( $data ) {
			$session_var = SessionUtils::get_user_submitted( $this->form_session_var );
			if ( $session_var !== $data['username'] ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::USERNAME_MISMATCH ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
			}
		}

		/**
		 * Function to check errors and redirect user on password reset page.
		 *
		 * @param array $data - Data if the user.
		 */
		private function get_user_and_reset_password( $data ) {
			$username = $data['username'];
			$user     = $this->getUser( $username );
			$user_id  = $user->ID;
			$key      = get_password_reset_key( $user );
			if ( ! empty( $key->errors ) ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::INVALID_USERNAME ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
			}
			$current_url = $_SERVER['HTTP_ORIGIN'] . $_SERVER['REQUEST_URI'] . '?key=' . $key . '&id=' . $user_id; //phpcs:ignore
			wp_safe_redirect( $current_url );
			exit();
		}

		/**
		 * Callback function for the um_reset_password_process_hook to
		 * redirect the user to the password change page using the
		 * password reset URL generated by Ultimate Member.
		 */
		public function um_reset_password_process_hook() {
			$user    = MoUtility::sanitize_check( 'username_b', $_POST ); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- No need for nonce verification as the function is called on third party plugin hook.
			$user    = $this->getUser( trim( $user ) );
			$pwd_obj = $this->getUmpwd_obj();
						um_fetch_user( $user->ID );  // phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate member plugin.
			$this->getUmUserObj()->password_reset();
			wp_safe_redirect( $pwd_obj->reset_url() );
			exit();
		}

		/**
		 * Get User based on the username passed
		 *
		 * @param string $username for the username.
		 * @return bool|WP_User
		 */
		public function getUser( $username ) {
			if ( strcasecmp( $this->otp_type, $this->type_phone_tag ) === 0 && MoUtility::validate_phone_number( $username ) ) {
				$username = MoUtility::process_phone_number( $username );
				$user     = $this->getUserFromPhoneNumber( $username );
			} elseif ( $this->is_only_phone_reset && ! MoUtility::validate_phone_number( $username ) ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::RESET_LABEL_OP ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
			} elseif ( is_email( $username ) && ! $this->is_only_phone_reset ) {
				$user = get_user_by( 'email', $username );
			} else {
				$user = get_user_by( 'login', $username );
			}
			return $user;
		}


		/**
		 * Get form data. Checks to see which version of the Ultimate Member
		 * is installed and return form data accordingly.
		 *
		 * @return \UM\Core\Form
		 */
		private function getum_formObj() {
			if ( $this->isUltimateMemberV2Installed() ) {
				return UM()->form();  //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate member plugin.
			} else {

				global $ultimatemember;
				return $ultimatemember->form;
			}
		}

		/**
		 * Get Ultimate Member Password. Checks to see which version of the Ultimate Member
		 * is installed and return form data accordingly.
		 *
		 * @return Password
		 */
		private function getUmpwd_obj() {
			if ( $this->isUltimateMemberV2Installed() ) {
				return UM()->password();  //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate member plugin.
			} else {
				global $ultimatemember;
				return $ultimatemember->password;
			}
		}

		/**
		 * Get User Obj. Checks to see which version of the Ultimate Member
		 * is installed and return form data accordingly.
		 *
		 * @return User
		 */
		private function getUmUserObj() {
			if ( $this->isUltimateMemberV2Installed() ) {
				return UM()->user();  //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate member plugin.
			} else {

				global $ultimatemember;
				return $ultimatemember->user;
			}
		}


		/**
		 * Get Options data. Checks to see which version of the Ultimate Member
		 * is installed and return form data accordingly.
		 *
		 * @return Options
		 */
		private function getUmOptions() {
			if ( $this->isUltimateMemberV2Installed() ) {
				return UM()->options();  //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate member plugin.
			} else {
				global $ultimatemember;
				return $ultimatemember->options;
			}
		}


		/**
		 * This functions fetches the user associated with a phone number
		 *
		 * @param string $username - the user's username.
		 * @return bool|WP_User
		 */
		private function getUserFromPhoneNumber( $username ) {
			global $wpdb;
			$results = $wpdb->get_row( $wpdb->prepare( "SELECT `user_id` FROM `{$wpdb->prefix}usermeta` WHERE `meta_key` = %s AND `meta_value` = %s", array( $this->phone_key, $username ) ) );// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery, Direct database call without caching detected -- DB Direct Query is necessary here.
			return ! MoUtility::is_blank( $results ) ? get_userdata( $results->user_id ) : false;
		}

		/**
		 * This function checks the reset password limit set by the
		 * admin in the Ultimate Member option.
		 *
		 * @param object $form form value.
		 * @param string $user_id WP user id.
		 */
		public function check_reset_password_limit( $form, $user_id ) {
			$attempts = (int) get_user_meta( $user_id, 'password_rst_attempts', true );
			$is_admin = user_can( intval( $user_id ), 'manage_options' );

			if ( $this->getUmOptions()->get( 'enable_reset_password_limit' ) ) {
				if ( $this->getUmOptions()->get( 'disable_admin_reset_password_limit' ) && $is_admin ) {
					return;
					// Triggers this when a user has admin capabilities and when reset password limit is disabled for admins.
				} else {
					$limit = $this->getUmOptions()->get( 'reset_password_limit_number' );
					if ( $attempts >= $limit ) {
						$form->add_error(
							$this->field_key,
							__(
								'You have reached the limit for requesting password ".
                    "change for this user already. Contact support if you cannot open the email',
								'miniorange-otp-verification'
							)
						);
					} else {
						update_user_meta( $user_id, 'password_rst_attempts', $attempts + 1 );
					}
				}
			}
		}


		/**
		 * Checks if the plugin is installed or not. Returns true or false.
		 *
		 * @return boolean
		 */
		private function isUltimateMemberV2Installed() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			return is_plugin_active( 'ultimate-member/ultimate-member.php' );
		}

		/**
		 * Unset all the session variables so that a new form submission starts
		 * a fresh process of OTP verification.
		 */
		public function unset_otp_session_variables() {
			SessionUtils::unset_session( array( $this->tx_session_id, $this->form_session_var ) );
		}

		/**
		 * This function hooks into the otp_verification_successful hook. This function is
		 * details what needs to be done if OTP Verification is successful.
		 *
		 * @param string $redirect_to the redirect to URL after new user registration.
		 * @param string $user_login the username posted by the user.
		 * @param string $user_email the email posted by the user.
		 * @param string $password the password posted by the user.
		 * @param string $phone_number the phone number posted by the user.
		 * @param string $extra_data any extra data posted by the user.
		 * @param string $otp_type the verification type.
		 */
		public function handle_post_verification( $redirect_to, $user_login, $user_email, $password, $phone_number, $extra_data, $otp_type ) {

			SessionUtils::add_status( $this->form_session_var, self::VALIDATED, $otp_type );
		}


		/**
		 * This function hooks into the otp_verification_failed hook. This function
		 * details what is done if the OTP verification fails.
		 *
		 * @param string $user_login the username posted by the user.
		 * @param string $user_email the email posted by the user.
		 * @param string $phone_number the phone number posted by the user.
		 * @param string $otp_type the verification type.
		 */
		public function handle_failed_verification( $user_login, $user_email, $phone_number, $otp_type ) {

			SessionUtils::add_status( $this->form_session_var, self::VERIFICATION_FAILED, $otp_type );
		}

		/**
		 * To update form option.
		 */
		public function handle_form_options() {
			if ( ! MoUtility::are_form_options_being_saved( $this->get_form_option() ) ) {
				return;
			}

			$this->is_form_enabled     = $this->sanitize_form_post( 'um_pass_reset_enable' );
			$this->otp_type            = $this->sanitize_form_post( 'um_pass_reset_enable_type' );
			$this->phone_key           = $this->sanitize_form_post( 'um_pass_reset_field_key' );
			$this->is_only_phone_reset = $this->sanitize_form_post( 'um_pass_reset_only_phone' );
			$this->button_text         = $this->sanitize_form_post( 'um_pr_button_text' );

			update_option( 'mo_um_pr_pass_enable', $this->is_form_enabled );
			update_option( 'mo_um_pr_enabled_type', $this->otp_type );
			update_option( 'mo_um_pr_pass_button_text', $this->button_text );
			update_option( 'mo_um_pr_passphone_key', $this->phone_key );
			update_option( 'mo_um_pr_only_phone_reset', $this->is_only_phone_reset );

		}


		/**
		 * This function is called by the filter mo_phone_dropdown_selector
		 * to return the Jquery selector of the phone field. The function will
		 * push the formID to the selector array if OTP Verification for the
		 * form has been enabled.
		 *
		 * @param  array $selector - the Jquery selector to be modified.
		 * @return array
		 */
		public function get_phone_number_selector( $selector ) {

			if ( $this->is_form_enabled() && strcasecmp( $this->otp_type, $this->type_phone_tag ) === 0 ) {
				array_push( $selector, $this->phone_form_id );
			}
			return $selector;
		}

		/** Getter for $is_only_phone_reset */
		public function getIsOnlyPhoneReset() {
			return $this->is_only_phone_reset; }
	}
}
