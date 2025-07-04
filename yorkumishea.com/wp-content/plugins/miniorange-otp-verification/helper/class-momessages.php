<?php
/**Load adminstrator changes for MoMessages
 *
 * @package miniorange-otp-verification/helper
 */

namespace OTP\Helper;

use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This is the constant class which lists all the messages
 * to be shown in the plugin.
 */
if ( ! class_exists( 'MoMessages' ) ) {
	/**
	 * MoMessages class
	 */
	final class MoMessages extends BaseMessages {

		use Instance;

		/**Constructor
		 */
		public function __construct() {
			$messages = maybe_serialize(
				array(

					// General Messages.
					self::BLOCKED_COUNTRY               => mo_( 'This country is blocked by the admin. Please enter another phone number or contact site admin.' ),
					self::NEED_TO_REGISTER              => mo_( 'You need to login with the miniOrange account in the plugin in order to send the OTP Code.' ),
					self::GLOBALLY_INVALID_PHONE_FORMAT => mo_(
						'##phone## is not a Globally valid phone number.
														Please enter a valid Phone Number.'
					),
					self::VOIP_PHONE_FORMAT             => mo_( '##phone## is not a valid phone number. Please enter a valid Phone Number.' ),
					self::INVALID_SCRIPTS               => mo_( 'You cannot add script tags in the pop up template.' ),

					self::OTP_SENT_PHONE                => mo_(
						'A OTP (One Time Passcode) has been sent to ##phone##.
														Please enter the OTP in the field below to verify your phone.'
					),

					self::OTP_SENT_EMAIL                => mo_(
						'A One Time Passcode has been sent to ##email##.
														Please enter the OTP below to verify your Email Address. 
														If you cannot see the email in your inbox, make sure to check 
														your SPAM folder.'
					),

					self::ERROR_OTP_EMAIL               => mo_(
						'There was an error in sending the OTP.
														Please enter a valid email id or contact site Admin.'
					),

					self::ERROR_OTP_PHONE               => mo_(
						'There was an error in sending the OTP to the given Phone.
														Please Try Again or contact site Admin.'
					),

					self::ERROR_PHONE_FORMAT            => mo_(
						'##phone## is not a valid phone number.
														Please enter a valid Phone Number. E.g:+1XXXXXXXXXX'
					),

					self::ERROR_EMAIL_FORMAT            => mo_(
						'##email## is not a valid email address.
														Please enter a valid Email Address. E.g:abc@abc.abc'
					),

					self::INVALID_EMAIL                 => mo_(
						"Invalid Email address.
										Please register using a valid Email Address or contact us at <b><i><a style='cursor:pointer;' onClick='otpSupportOnClick();'> <u>otpsupport@xecurify.com</u></a></i></b> to know more."
					),

					self::INVALID_USER                  => mo_( 'The customer is not valid' ),

					self::INVALID_PASSWORD              => mo_( 'Invalid username or password. Please try again.' ),

					self::CHOOSE_METHOD                 => mo_(
						'Please select one of the methods below to verify your account.
														A One time passcode will be sent to the selected method.'
					),

					self::PLEASE_VALIDATE               => mo_( 'You need to verify yourself in order to submit this form' ),

					self::ERROR_PHONE_BLOCKED           => mo_(
						'##phone## has been blocked by the admin.
														Please Try a different number or Contact site Admin.'
					),

					self::ERROR_EMAIL_BLOCKED           => mo_(
						'##email## has been blocked by the admin.
														Please Try a different email or Contact site Admin.'
					),

					self::REGISTER_WITH_US              => mo_(
						"<u><i><a href='{{url}}'>Register or Login with miniOrange</a></i></u> to get the free Email Transactions."
					),

					self::ACTIVATE_PLUGIN               => mo_(
						"<a href='{{url}}'><u><i>Complete plugin activation process</i></u></a>
														to enable OTP Verification"
					),

					self::CONFIG_GATEWAY                => mo_(
						"<a href='{{url}}'><u><i>Please Configure Gateway</i></u></a>
															 to enable OTP Verification"
					),
					self::FORM_NOT_AVAIL_HEAD           => mo_( 'MY FORM IS NOT IN THE LIST' ),

					self::FORM_NOT_FOUND                => mo_( 'Not able to find your form.' ),
					self::FORM_NOT_AVAIL_BODY           => mo_(
						'We are continuously adding support for more forms. Contact us via the support form or email us at <a onClick=\'otpSupportOnClick();\'><span style=\'color:white;\'><u>'
						. esc_html( MoConstants::FEEDBACK_EMAIL ) . '</u></span></a> with details about your form and its usage.'
					),
					self::CHANGE_SENDER_ID_BODY         => mo_(
						'SenderID/Number is gateway specific.
														You will need to use your own SMS gateway for this.'
					),

					self::CHANGE_SENDER_ID_HEAD         => mo_( 'CHANGE SENDER ID / NUMBER' ),

					self::CHANGE_EMAIL_ID_BODY          => mo_(
						'Sender Email is gateway specific.
														You will need to use your own Email gateway for this.'
					),

					self::CHANGE_EMAIL_ID_HEAD          => mo_( 'CHANGE SENDER EMAIL ADDRESS' ),

					self::INFO_HEADER                   => mo_( 'WHAT DOES THIS MEAN?' ),

					self::META_KEY_HEADER               => mo_( 'WHAT IS A META KEY?' ),

					self::META_KEY_BODY                 => mo_(
						'WordPress stores addtional user data like phone number, username
														etc in the usermeta table in a key value pair. Phone Meta Key is
														the key against which the users phone number is stored in the 
														usermeta table.'
					),

					self::ENABLE_BOTH_BODY              => mo_(
						'New users can validate their Email or Phone Number using
														either Email or Phone verification. They will be prompted
														during registration to choose one of the two verification methods.'
					),

					self::EMAIL_SENDER_HEADER           => mo_( 'Change From Email Address?' ),

					self::EMAIL_SENDER_BODY             => mo_(
						'Upgrading to the premium plan allows you to change the from email address, which is currently set as no-reply@xecurify.com.'
					),

					self::COUNTRY_CODE_HEAD             => mo_( "DON'T WANT USERS TO ENTER THEIR COUNTRY CODE?" ),

					self::COUNTRY_CODE_BODY             => mo_(
						'Choose the default country code that will be appended to the
														phone number entered by the users. This will allow your 
														users to enter their phone numbers in the phone field without 
														a country code.'
					),

					self::WC_GUEST_CHECKOUT_HEAD        => mo_( 'WHAT IS GUEST CHECKOUT?' ),

					self::WC_GUEST_CHECKOUT_BODY        => mo_( 'Verify customer only when he is not logged in during checkout.' ),

					self::SUPPORT_FORM_VALUES           => mo_( 'Please submit your query along with email.' ),

					self::SUPPORT_FORM_SENT             => mo_( 'Thanks for getting in touch! We shall get back to you shortly.' ),

					self::PREM_SUPPORT_FORM_SENT        => mo_( 'Thanks for getting in touch! We shall get back to you shortly. You can also purchase the support plan to raise the priority of the ticket.' ),

					self::SUPPORT_FORM_ERROR            => mo_( 'Your query could not be submitted. Please try again.' ),

					self::FEEDBACK_SENT                 => mo_( 'Thank you for your feedback.' ),

					self::FEEDBACK_ERROR                => mo_( "Your feedback couldn't be submitted. Please try again" ),

					self::SETTINGS_SAVED                => mo_(
						'Settings saved successfully.
														You can go to your registration form page to test the plugin.'
					),

					self::REG_ERROR                     => mo_(
						'Please register an account before trying to enable
														OTP verification for any form.'
					),

					self::MSG_TEMPLATE_SAVED            => mo_( 'Settings saved successfully.' ),

					self::SMS_TEMPLATE_SAVED            => mo_( 'Your SMS configurations are saved successfully.' ),

					self::SMS_TEMPLATE_ERROR            => mo_( 'Please configure your gateway URL correctly.' ),

					self::TEMPLATE_GUIDELINE_ALERT      => mo_(
						'We have released some changes to our miniOrange gateway guidelines.
						       							According to the new guidelines, you cannot add any special character without spaces around it.'
					),

					self::EMAIL_TEMPLATE_SAVED          => mo_( 'Your email configurations are saved successfully.' ),

					self::CUSTOM_MSG_SENT               => mo_( 'Message sent successfully' ),

					self::CUSTOM_MSG_SENT_FAIL          => mo_( 'Error in sending message.' ),

					self::EXTRA_SETTINGS_SAVED          => mo_( 'Settings saved successfully.' ),

					self::NINJA_FORM_FIELD_ERROR        => mo_( 'Please fill in the form id and field id of your Ninja Form' ),

					self::NINJA_CHOOSE                  => mo_( 'Please choose a Verification Method for Ninja Form.' ),

					self::EMAIL_MISMATCH                => mo_(
						'The email OTP was sent to and the email in contact
														submission do not match.'
					),

					self::PHONE_MISMATCH                => mo_(
						'The phone number OTP was sent to and the phone number in
														contact submission do not match.'
					),

					self::ENTER_PHONE                   => mo_( 'You will have to provide a Phone Number before you can verify it.' ),

					self::ENTER_EMAIL                   => mo_( 'You will have to provide an Email Address before you can verify it.' ),

					self::USERNAME_MISMATCH             => mo_( 'Username that the OTP was sent to and the username submitted do not match' ),

					self::CF7_PROVIDE_EMAIL_KEY         => mo_(
						'Please Enter the name of the email address field you created
														in Contact Form 7.'
					),

					self::CF7_CHOOSE                    => mo_( 'Please choose a Verification Method for Contact Form 7.' ),

					self::BP_PROVIDE_FIELD_KEY          => mo_(
						'Please Enter the Name of the phone number field you
														created in BuddyPress.'
					),

					self::BP_CHOOSE                     => mo_(
						'Please choose a Verification Method for BuddyPress
														Registration Form.'
					),

					self::UM_CHOOSE                     => mo_(
						'Please choose a Verification Method for
														Ultimate Member Registration Form.'
					),

					self::UM_PROFILE_CHOOSE             => mo_(
						'Please choose a Verification Method for
														Ultimate Member Profile/Account Form'
					),

					self::EVENT_CHOOSE                  => mo_( 'Please choose a Verification Method for Event Registration Form.' ),

					self::UULTRA_PROVIDE_FIELD          => mo_(
						'Please Enter the Field Key of the phone number field you
														created in Users Ultra Registration form.'
					),

					self::UULTRA_CHOOSE                 => mo_( 'Please choose a Verification Method for Users Ultra Registration Form.' ),

					self::CRF_PROVIDE_PHONE_KEY         => mo_(
						'Please Enter the label name of the phone number field you
														created in Custom User Registration form.'
					),
					self::CRF_PROVIDE_EMAIL_KEY         => mo_(
						'Please Enter the label name of the email number field you
														created in Custom User Registration form.'
					),

					self::CRF_CHOOSE                    => mo_( 'Please choose a Verification Method for Custom User Registration Form.' ),

					self::SMPLR_PROVIDE_FIELD           => mo_(
						'Please Enter the Field Key of the phone number field you
														created in Simplr User Registration form.'
					),

					self::SIMPLR_CHOOSE                 => mo_(
						'Please choose a Verification Method for
														Simplr User Registration Form.'
					),

					self::UPME_PROVIDE_PHONE_KEY        => mo_(
						'Please Enter the Field Key of the phone number field you
														created in User Profile Made Easy Registration form.'
					),

					self::UPME_CHOOSE                   => mo_(
						'Please choose a Verification Method for User Profile Made
														Easy Registration Form.'
					),

					self::PB_PROVIDE_PHONE_KEY          => mo_(
						'Please Enter the Field Key of the phone number field you
														created in Profile Builder Registration form.'
					),

					self::PB_CHOOSE                     => mo_(
						'Please choose a Verification Method for Profile
														Builder Registration Form.'
					),

					self::PIE_PROVIDE_PHONE_KEY         => mo_( 'Please Enter the Meta Key of the phone field.' ),

					self::PIE_CHOOSE                    => mo_( 'Please choose a Verification Method for Pie Registration Form.' ),

					self::ENTER_PHONE_CODE              => mo_( 'Please enter the verification code sent to your phone' ),

					self::ENTER_EMAIL_CODE              => mo_( 'Please enter the verification code sent to your email address' ),

					self::ENTER_VERIFY_CODE             => mo_( 'Please verify yourself before submitting the form.' ),

					self::ENTER_PHONE_VERIFY_CODE       => mo_( 'Please verify your phone number before submitting the form.' ),

					self::ENTER_EMAIL_VERIFY_CODE       => mo_( 'Please verify your email address before submitting the form.' ),

					self::PHONE_VALIDATION_MSG          => mo_( 'Enter your mobile number below for verification :' ),

					self::WC_CHOOSE_METHOD              => mo_(
						'Please choose a Verification Method for Woocommerce
														Default Registration Form.'
					),

					self::WC_CHECKOUT_CHOOSE            => mo_(
						'Please choose a Verification Method for Woocommerce
														Checkout Registration Form.'
					),

					self::TMLM_CHOOSE                   => mo_(
						'Please choose a Verification Method for
														Theme My Login Registration Form.'
					),

					self::ENTER_PHONE_DEFAULT           => mo_( 'ERROR: Please enter a valid phone number.' ),

					self::WP_CHOOSE_METHOD              => mo_(
						'Please choose a Verification Method for
														WordPress Default Registration Form.'
					),

					self::AUTO_ACTIVATE_HEAD            => mo_( 'WHAT DO YOU MEAN BY AUTO ACTIVATE?' ),

					self::AUTO_ACTIVATE_BODY            => mo_(
						'By default WordPress sends out a confirmation email to new
														registrants to complete their registration process. The 
														plugin would add a password and confirm password field on
														the registration page and auto-activate the users after 
														registration.'
					),

					self::USERPRO_CHOOSE                => mo_(
						'Please choose a Verification Method for
														UserPro Registration Form.'
					),

					self::PASS_LENGTH                   => mo_( 'Choose a password with minimum length 6.' ),

					self::PASS_MISMATCH                 => mo_( 'Password and Confirm Password do not match.' ),

					self::OTP_SENT                      => mo_(
						'A passcode has been sent to {{method}}. Please enter the otp
														below to verify your account.'
					),

					self::ERR_OTP                       => mo_(
						'There was an error in sending OTP. Please click on Resend
														OTP link to resend the OTP.'
					),

					self::REG_SUCCESS                   => mo_( 'Your account has been retrieved successfully.' ),

					self::ACCOUNT_EXISTS                => mo_(
						'You already have an account with miniOrange.
														Please enter a valid password.'
					),

					self::REG_COMPLETE                  => mo_( 'Registration complete!' ),

					self::INVALID_OTP                   => mo_( 'Invalid one time passcode. Please enter a valid passcode.' ),

					self::RESET_PASS                    => mo_(
						'You password has been reset successfully and sent to your
														registered email. Please check your mailbox.'
					),

					self::REQUIRED_FIELDS               => mo_( 'Please enter all the required fields' ),

					self::REQUIRED_OTP                  => mo_( 'Please enter a value in OTP field.' ),

					self::INVALID_SMS_OTP               => mo_( 'There was an error in sending sms. Please Check your phone number.' ),

					self::NEED_UPGRADE_MSG              => mo_(
						'You have not upgraded yet.
														Check licensing tab to upgrade to premium version.'
					),

					self::VERIFIED_LK                   => mo_( 'Your license is verified. You can now setup the plugin.' ),

					self::LK_IN_USE                     => mo_(
						'License key you have entered has already been used. Please
														enter a key which has not been used before on any other
														instance or if you have exhausted all your keys then check 
														licensing tab to buy more.'
					),

					self::INVALID_LK                    => mo_(
						'You have entered an invalid license key.
														Please enter a valid license key.'
					),

					self::REG_REQUIRED                  => mo_( 'Please complete your registration to save configuration.' ),

					self::UNKNOWN_ERROR                 => mo_( 'Error processing your request. Please try again.' ),
					self::INVALID_OP                    => mo_( 'Invalid Operation. Please Try Again' ),

					self::MO_REG_ENTER_PHONE            => mo_( 'Phone with country code eg. +1xxxxxxxxxx' ),

					self::UPGRADE_MSG                   => mo_( 'Thank you. You have upgraded to {{plan}}. <br><b>You can follow this <u><a href="https://faq.miniorange.com/knowledgebase/premium-plugin-installation/" target="_blank">guide</a></u> to install the premium plugin.</b>' ),
					self::REMAINING_TRANSACTION_MSG     => mo_( 'Thank you. You have upgraded to {{plan}}. <br>You have <b>{{sms}}</b> SMS and <b>{{email}}</b> Email remaining.' ),

					self::FREE_PLAN_MSG                 => mo_( 'You are on our FREE plan. Check Licensing Tab to learn how to upgrade.' ),

					self::TRANS_LEFT_MSG                => mo_(
						'You have <b><i>{{email}} Email Transactions</i></b> and
														<b><i>{{phone}} Phone Transactions</i></b> remaining.'
					),

					self::YOUR_GATEWAY_HEADER           => mo_( 'WHAT DO YOU MEAN BY CUSTOM GATEWAY? WHEN DO I OPT FOR THIS PLAN?' ),

					self::YOUR_GATEWAY_BODY             => mo_(
						"Custom Gateway means that you have your own SMS or Email
														Gateway for delivering OTP to the user's email or phone. 
														The plugin will handle OTP generation and verification but 
														your existing gateway would be used to deliver the message to 
														the user. <br/><br/>Hence, the One Time Cost of the plugin. 
														<b><i>NOTE:</i></b> You will still need to pay SMS and Email 
														delivery charges to your gateway separately."
					),

					self::MO_GATEWAY_HEADER             => mo_( 'WHAT DO YOU MEAN BY miniOrange GATEWAY? WHEN DO I OPT FOR THIS PLAN?' ),

					self::MO_GATEWAY_BODY               => mo_(
						"miniOrange Gateway means that you want the complete package
														of OTP generation, delivery ( to user's phone or email ) and
														verification. Opt for this plan when you don't have your own 
														SMS or Email gateway for message delivery. <br/><br/>
														<b><i>NOTE:</i></b> SMS Delivery charges depend on the 
														country you want to send the OTP to. Click on the Upgrade
														Now button below and select your country to see the full pricing."
					),
					self::INSTALL_PREMIUM_PLUGIN        => mo_(
						"You have Upgraded to the Custom Gateway Plugin. You will need to
														install the premium plugin from the 
														<a target='_blank' href='" . MOV_PORTAL . "/downloads'>
														miniOrange dashboard</a>."
					),
					self::MO_PAYMENT                    => mo_( 'Payment Methods which we support' ),

					self::GRAVITY_CHOOSE                => mo_( 'Please choose a Verification Method for Gravity Form.' ),
					self::PLUGIN_INSTALL                => mo_( 'Please install the {{formname}} plugin' ),
					self::PHONE_NOT_FOUND               => mo_( "Sorry, but you don't have a registered phone number." ),

					self::REGISTER_PHONE_LOGIN          => mo_(
						'A new security system has been enabled for you. Please
														register your phone to continue.'
					),

					self::WP_MEMBER_CHOOSE              => mo_( 'Please choose a Verification Method for WP Member Form.' ),

					self::UMPRO_CHOOSE                  => mo_(
						'Please choose a verification method for
														Ultimate Membership Pro form.'
					),

					self::CLASSIFY_THEME                => mo_( 'Please choose a Verification Method for Classify Theme.' ),

					self::REALES_THEME                  => mo_( 'Please choose a Verification Method for Reales WP Theme.' ),

					self::LOGIN_MISSING_KEY             => mo_( 'Please provide a meta key value for users phone numbers.' ),

					self::PHONE_EXISTS                  => mo_( 'Phone Number is already in use. Please use another number.' ),

					self::EMAIL_EXISTS                  => mo_( 'Email is already in use. Please use another email.' ),

					self::WP_LOGIN_CHOOSE               => mo_( 'Please choose a Verification Method for WordPress Login Form' ),

					self::WPCOMMNENT_CHOOSE             => mo_( 'Please choose a Verification Method for WordPress Comments Form' ),
					self::WPCOMMNENT_PHONE_ENTER        => mo_(
						'Error: You did not add a phone number. Hit the Back button on
														your Web browser and resubmit your comment with a phone number.'
					),
					self::WPCOMMNENT_VERIFY_ENTER       => mo_(
						'Error: You did not add a Verification Code. Hit the Back button
														on your Web browser and resubmit your comment with a verification code.'
					),

					self::FORMCRAFT_CHOOSE              => mo_( 'Please choose a Verification Method for FormCraft Form' ),

					self::FORMCRAFT_FIELD_ERROR         => mo_( 'Please fill in the form id and field id of your FormCraft Form' ),

					self::WPEMEMBER_CHOOSE              => mo_( 'Please choose a Verification Method for WpEmember Registration Form' ),

					self::DOC_DIRECT_CHOOSE             => mo_( 'Please choose a Verification Method for DocDirect Theme.' ),

					self::WPFORM_FIELD_ERROR            => mo_(
						'Please check if you have provided all the required
														information for WP Forms.'
					),

					self::CALDERA_FIELD_ERROR           => mo_(
						'Please check if you have provided all the required
														information for Caldera Forms.'
					),

					self::INVALID_USERNAME              => mo_( 'Please enter a valid username or email.' ),

					self::UM_LOGIN_CHOOSE               => mo_(
						'Please choose a verification method for
														Ultimate Member Login form.'
					),

					self::MEMBERPRESS_CHOOSE            => mo_( 'Please choose a verification method for Memberpress form.' ),

					self::REQUIRED_TAGS                 => mo_(
						'NOTE: Please make sure that the template has the {{TAG}} tag.
														It is necessary for the popup to work.'
					),

					self::TEMPLATE_SAVED                => mo_( 'Template Saved Successfully.' ),
					self::TEMPLATE_RESET                => mo_( 'Template has been Reset to Default Successfully.' ),

					self::DEFAULT_SMS_TEMPLATE          => mo_(
						'Dear Customer, Your OTP is ##otp##. Use this Passcode to complete your transaction. Thank you - miniorange'
					),

					self::EMAIL_SUBJECT                 => mo_( 'Your Requested One Time Passcode' ),

					self::DEFAULT_EMAIL_TEMPLATE        => mo_(
						"Dear Customer, \n\nYour One Time Passcode for completing
														your transaction is: ##otp##\nPlease use this Passcode to
														complete your transaction. Do not share this Passcode with 
														anyone.\n\nThank You,\nminiOrange Team."
					),

					self::ADD_ON_VERIFIED               => mo_( 'Thank you for the upgrade. AddOn Settings have been verified.' ),

					self::INVALID_PHONE                 => mo_( 'Please enter a valid phone number' ),

					self::ERROR_SENDING_SMS             => mo_( 'There was an error sending SMS to the user' ),

					self::SMS_SENT_SUCCESS              => mo_( 'SMS was sent successfully.' ),

					self::VISUAL_FORM_CHOOSE            => mo_( 'Please Choose a verification method for Visual Form Builder' ),

					self::FORMIDABLE_CHOOSE             => mo_( 'Please Choose a verification method for Formidable Forms' ),

					self::FORMMAKER_CHOOSE              => mo_( 'Please Choose a verification method for FormMaker Forms.' ),

					self::WC_BILLING_CHOOSE             => mo_( 'Please Choose a verification method for Woocommerce Billing Form' ),
					self::ENTERPRIZE_EMAIL              => mo_( "Please use Enterprize Email for registration or contact us at <b><i><a style='cursor:pointer;' onClick='otpSupportOnClick();'> <u>otpsupport@xecurify.com</u></a></i></b> to know more." ),
					self::REGISTRATION_ERROR            => mo_( "There is some issue proccessing the request. Please try again or contact us at <b><i><a onClick='otpSupportOnClick();'> <u>otpsupport@xecurify.com</u></a></i></b> to know more. " ),
					self::FORGOT_PASSWORD_MESSAGE       => mo_( "Please<a href='https://portal.miniorange.com/forgotpassword ' target='_blank'> Click here </a>to reset your password" ),

					self::CUSTOM_CHOOSE                 => mo_( 'Please choose a Verification Method for Your Own Form.' ),

					self::GATEWAY_PARAM_NOTE            => mo_(
						'You will need to place your SMS gateway URL in the above field.<br><br>Example:-http://alerts.sinfini.com/api/web2sms.php?username=XYZ&password=password& to=<b>##phone##</b>&sender=senderid& message=<b>##message##</b>'
					),
					self::CUSTOM_FORM_MESSAGE           => mo_( "<b>Your test was succesful!</b> <br> Please contact us at <a style='cursor:pointer;' href='mailto:otpsupport@xecurify.com'>otpsupport@xecurify.com</a> for full integration of your form." ),
					self::LOW_TRANSACTION_ERROR         => mo_( 'There was an error in sending the OTP. Please try again or contact site admin.' ),
					self::LOW_TRANSACTION_ALERT         => mo_( 'You will get the below error once you exhaust your remaining transactions:' ),
					self::ZERO_TRANSACTION_ALERT        => mo_( "You will get the below error while sending SMS OTP as you don't have SMS Transactions in your account:" ),

					self::RESET_LABEL_OP                => mo_( 'To reset your password, please enter your registered phone number.' ),
					self::USERNAME_NOT_EXIST            => mo_( "We can't find an account registered with that address or username or phone number." ),
					self::RESET_LABEL                   => mo_( 'To reset your password, please enter your email address, username or phone number.' ),

					self::ENTER_VERIFICATION_CODE       => mo_( 'Please enter a verification code to verify yourself' ),
					self::REMOVE_PLUS_MESSAGE           => mo_( 'For some gateways, a + is automatically inserted into the SMS template. You can enable this option to remove the "+" if needed.' ),
					self::REMOVE_PLUS_MESSAGE_HEADER    => mo_( 'When to Use the "+" Removal Option' ),
					self::USER_IS_BLOCKED               => mo_( 'You have exceeded the limit to send OTP. Please wait for <span id ="mo-time-remain" value = "{{remaining_time}}">{{remaining_time}}</span>' ),
					self::LIMIT_OTP_SENT                => mo_( 'Your OTP has been sent. The next OTP can be sent after {minutes}:{seconds} minutes' ),
					self::USER_IS_BLOCKED_AJAX          => mo_( 'You have exceeded the limit to send OTP. Please wait for {minutes}:{seconds} minutes' ),
					self::ENTER_VALID_INT               => mo_( 'Please enter a valid integer in the fields.' ),
					self::ENTER_VALID_BLOCK_TIME        => mo_( 'The block timer should be greater than resend OTP timer' ),
					self::ERROR_OTP_VERIFY              => mo_( 'The next OTP can be sent after {minutes}:{seconds} minutes' ),
					self::VOIP_PHONE_TITLE              => mo_( 'What are VOIP Phone numbers?' ),
					self::VOIP_PHONE_BODY               => mo_( 'A VOIP phone number is a virtual number that uses the internet for calls, not tied to a physical location.' ),
					self::USE_YOUR_SMTP                 => mo_( 'You can configure your SMTP gateway from any third party SMTP plugin( For e.g <u><i><a href="https://wordpress.org/plugins/wp-mail-smtp/" target="_blank" >WP SMTP</a></i></u> ) or php.ini file.<br><b>Note:</b> You don\'t need to configure any extra settings in our plugin.' ),
					self::USE_YOUR_SMTP_HEADER          => mo_( 'CONFIGURE YOUR OWN SMTP' ),
					self::NEW_ACCOUNT_NOTIF_SMS         => mo_( 'Thanks for creating an account on {site-name}. Your username is {username} -miniorange' ),
					self::USER_LOGGING_IN               => mo_( 'Verified. Logging in..' ),
					self::USER_LOGGED_IN                => mo_( 'You are already logged in!' ),
					self::NEW_USER_REGISTERED           => mo_( 'Verified. Registering your account.' ),
					self::DISABLE_WC_REG                => mo_( 'Please disable WooCommerce Registration form in order to enable this form.' ),
					self::DISABLE_DOKAN_REG             => mo_( 'Please disable Dokan Registration form in order to enable this form.' ),
					self::INVALID_FORM_DETAILS          => mo_( 'Enter valid form details.' ),
					self::INVALID_PHONE_EMAIL_LABEL     => mo_( 'Invalid or incomplete form IDs: {{form_ids}}. Check labels and form existence.' ),
				)
			);

			$frontend_messages = maybe_serialize(
				array(

					// General Messages.
					self::BLOCKED_COUNTRY               => mo_( 'This country is blocked by the admin. Please enter another phone number or contact site admin.' ),
					self::GLOBALLY_INVALID_PHONE_FORMAT => mo_(
						'##phone## is not a Globally valid phone number.
														Please enter a valid Phone Number.'
					),

					self::OTP_SENT_PHONE                => mo_(
						'A OTP (One Time Passcode) has been sent to ##phone##.
														Please enter the OTP in the field below to verify your phone.'
					),

					self::OTP_SENT_EMAIL                => mo_(
						'A One Time Passcode has been sent to ##email##.
														Please enter the OTP below to verify your Email Address. 
														If you cannot see the email in your inbox, make sure to check 
														your SPAM folder.'
					),

					self::ERROR_OTP_EMAIL               => mo_(
						'There was an error in sending the OTP.
														Please enter a valid email id or contact site Admin.'
					),

					self::ERROR_OTP_PHONE               => mo_(
						'There was an error in sending the OTP to the given Phone.
														Number. Please Try Again or contact site Admin.'
					),

					self::ERROR_PHONE_FORMAT            => mo_(
						'##phone## is not a valid phone number.
														Please enter a valid Phone Number. E.g:+1XXXXXXXXXX'
					),

					self::ERROR_EMAIL_FORMAT            => mo_(
						'##email## is not a valid email address.
														Please enter a valid Email Address. E.g:abc@abc.abc'
					),

					self::INVALID_EMAIL                 => mo_(
						"Invalid Email address.
										Please register using a valid Email Address or contact us at <b><i><a style='cursor:pointer;' onClick='otpSupportOnClick();'> <u>otpsupport@xecurify.com</u></a></i></b> to know more."
					),

					self::CHOOSE_METHOD                 => mo_(
						'Please select one of the methods below to verify your account.
														A One time passcode will be sent to the selected method.'
					),

					self::PLEASE_VALIDATE               => mo_( 'You need to verify yourself in order to submit this form' ),

					self::ERROR_PHONE_BLOCKED           => mo_(
						'##phone## has been blocked by the admin.
														Please Try a different number or Contact site Admin.'
					),

					self::ERROR_EMAIL_BLOCKED           => mo_(
						'##email## has been blocked by the admin.
														Please Try a different email or Contact site Admin.'
					),
					self::EMAIL_MISMATCH                => mo_(
						'The email OTP was sent to and the email in contact
														submission do not match.'
					),

					self::PHONE_MISMATCH                => mo_(
						'The phone number OTP was sent to and the phone number in
														contact submission do not match.'
					),

					self::ENTER_PHONE                   => mo_( 'You will have to provide a Phone Number before you can verify it.' ),

					self::ENTER_EMAIL                   => mo_( 'You will have to provide an Email Address before you can verify it.' ),

					self::USERNAME_MISMATCH             => mo_( 'Username that the OTP was sent to and the username submitted do not match' ),

					self::ENTER_PHONE_CODE              => mo_( 'Please enter the verification code sent to your phone' ),

					self::ENTER_EMAIL_CODE              => mo_( 'Please enter the verification code sent to your email address' ),

					self::ENTER_VERIFY_CODE             => mo_( 'Please verify yourself before submitting the form.' ),

					self::ENTER_PHONE_VERIFY_CODE       => mo_( 'Please verify your phone number before submitting the form.' ),

					self::ENTER_EMAIL_VERIFY_CODE       => mo_( 'Please verify your email address before submitting the form.' ),

					self::PHONE_VALIDATION_MSG          => mo_( 'Enter your mobile number below for verification :' ),

					self::ENTER_PHONE_DEFAULT           => mo_( 'ERROR: Please enter a valid phone number.' ),

					self::OTP_SENT                      => mo_(
						'A passcode has been sent to {{method}}. Please enter the otp
														below to verify your account.'
					),

					self::ERR_OTP                       => mo_(
						'There was an error in sending OTP. Please click on Resend
														OTP link to resend the OTP.'
					),

					self::INVALID_OTP                   => mo_( 'Invalid one time passcode. Please enter a valid passcode.' ),

					self::REQUIRED_OTP                  => mo_( 'Please enter a value in OTP field.' ),

					self::UNKNOWN_ERROR                 => mo_( 'Error processing your request. Please try again.' ),
					self::INVALID_OP                    => mo_( 'Invalid Operation. Please Try Again' ),

					self::MO_REG_ENTER_PHONE            => mo_( 'Phone with country code eg. +1xxxxxxxxxx' ),

					self::PHONE_NOT_FOUND               => mo_( "Sorry, but you don't have a registered phone number." ),

					self::REGISTER_PHONE_LOGIN          => mo_(
						'A new security system has been enabled for you. Please
														register your phone to continue.'
					),
					self::PHONE_EXISTS                  => mo_( 'Phone Number is already in use. Please use another number.' ),

					self::EMAIL_EXISTS                  => mo_( 'Email is already in use. Please use another email.' ),

					self::INVALID_USERNAME              => mo_( 'Please enter a valid username or email.' ),

					self::INVALID_PHONE                 => mo_( 'Please enter a valid phone number' ),

					self::ERROR_SENDING_SMS             => mo_( 'There was an error sending SMS to the user' ),

					self::SMS_SENT_SUCCESS              => mo_( 'SMS was sent successfully.' ),

					self::ENTER_VERIFICATION_CODE       => mo_( 'Please enter a verification code to verify yourself' ),

					self::USER_IS_BLOCKED               => mo_( 'You have exceeded the limit to send OTP. Please wait for <span id ="mo-time-remain" value = "{{remaining_time}}">{{remaining_time}}</span>' ),

					self::LIMIT_OTP_SENT                => mo_( 'Your OTP has been sent. The next OTP can be sent after {minutes}:{seconds} minutes' ),

					self::USER_IS_BLOCKED_AJAX          => mo_( 'You have exceeded the limit to send OTP. Please wait for {minutes}:{seconds} minutes' ),

					self::ERROR_OTP_VERIFY              => mo_( 'The next OTP can be sent after {minutes}:{seconds} minutes' ),

					self::VOIP_PHONE_FORMAT             => mo_( '##phone## is not a valid phone number. Please enter a valid Phone Number.' ),
					self::USER_LOGGING_IN               => mo_( 'Verified. Logging in..' ),
					self::USER_LOGGED_IN                => mo_( 'You are already logged in!' ),
					self::NEW_USER_REGISTERED           => mo_( 'Verified. Registering your account.' ),

				)
			);

			/** Created an array instead of messages instead of constant variables for Translation reasons. */
			define(
				'MO_MESSAGES',
				$this->update_message_list( $messages )
			);

			/** Created an array instead of messages instead of constant variables for Translation reasons. */
			define(
				'MO_FRONTEND_MESSAGES',
				$this->update_message_list( $frontend_messages )
			);

			/** Created an array instead of messages instead of constant variables for Translation reasons. */
			define(
				'MO_ORIGINAL_MESSAGES',
				$messages
			);
		}



		/**
		 * This function is used to fetch and process the Messages to
		 * be shown to the user. It was created to mostly show dynamic
		 * messages to the user.
		 *
		 * @param string $message_keys    Message Key.
		 * @param array  $data           The  key value pair to be replaced in the message.
		 *
		 * @return string
		 */
		public static function showMessage( $message_keys, $data = array() ) {
			$display_message = '';
			$message_keys    = explode( ' ', $message_keys );
			$messages        = maybe_unserialize( MO_MESSAGES );
			foreach ( $message_keys as $message_key ) {
				if ( MoUtility::is_blank( $message_key ) ) {
					return $display_message;
				}
				$format_message = mo_( $messages[ $message_key ] );
				foreach ( $data as $key => $value ) {
					$format_message = str_replace( '{{' . $key . '}}', $value, $format_message );
				}
				$display_message .= $format_message;
			}
			return $display_message;
		}

		/**
		 * This function is used to fetch the original message list.
		 *
		 * @return array
		 */
		public static function get_original_message_list() {
			$messages = maybe_unserialize( MO_ORIGINAL_MESSAGES );
			return $messages;
		}
		/**
		 * This function is used to fetch the original message list.
		 *
		 * @return array
		 */
		public static function get_frontend_message_list() {
			$messages = maybe_unserialize( MO_FRONTEND_MESSAGES );
			return $messages;
		}
		/**
		 * This function is used to return the updated message list.
		 *
		 * @param array $msg_list - The original message list .
		 * @return array
		 */
		public static function update_message_list( $msg_list ) {
			$messages = maybe_unserialize( $msg_list );
			foreach ( $messages as $key => $value ) {
				$changed_template = get_mo_option( $key, 'mo_otp_' );
				if ( $changed_template ) {
					$messages[ $key ] = str_replace( $value, $changed_template, $messages[ $key ] );
				}
			}
			return $messages;
		}
	}
}
