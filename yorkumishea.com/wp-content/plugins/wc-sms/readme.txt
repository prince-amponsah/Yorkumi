=== SMS for WooCommerce ===
Contributors: theafricanboss, freemius
Donate Link: https://gurastores.com/get-cash
Tags: woocommerce, sms, order notifications, twilio, bulk sms
Stable tag: 2.8.1.1
Requires PHP: 5.0
Requires at least: 5.0
Tested up to: 6.7.1
WC requires at least: 6.0.0
WC tested up to: 9.4.3
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Order SMS Notifications for Woocommerce

== Description ==

**Free Designated number or your own number**

Use your own **Twilio number** or just setup without a number and one will be designated for your store (only PRO users get a free number).

**SMS Order updates to admins, customers and more**

With SMS for Woocommerce, you can send SMS notifications to your customers when an order is placed, cancelled, or refunded, etc.

But that's just the beginning. There are 4 kinds of SMS groups you can send:

    - Admin SMS - Order updates sent to admin(s)
    - Bulk SMS - personalized SMS/Email to multiple users at once
    - Customer SMS - Order updates sent to customers
    - Marketing SMS - Upsells, cross-sells, order again SMS, single order to subscriptions, etc

Wait! There is more.

**SMS Order updates for the right orders to the right people**

You can specify what kinds of orders you want to send SMS notifications for.

    - Send SMS for specific Payment Methods
    - Send SMS for specific Order Status

**SMS templates, Shortcodes and Personalization**

Use shortcode templates like **[first_name]** to send personalized SMS messages to your customers.

**Bulk SMS/Emails to user roles, order statuses**

Our robust Bulk SMS/Emails allows you to send bulk SMS to all your users and customers.

But wait! You get to specify whether you want to send to all but can also send to specific users and groups.

    - Need to send personalized SMS/Email to all administrators or authors, etc on your site? We got you.
    - Need to send personalized SMS/Email to all customers whose orders are still pending payment? We got you.
    - How about selecting some users out of the groups above? We got you.

**HPOS compatibility & WooCommerce Blocks support**

**Demo**

An example of the plugin in use [here](https://gurastores.com/test)

See the screenshots

== Installation ==

= From Dashboard ( WordPress admin ) =

- Go to Plugins -> Add New
- Search for SMS for WooCommerce
- Click on Install Now
- Activate the plugin through the “Plugins” menu in WordPress.

= Using cPanel or FTP =

- Download ‘SMS for WooCommerce’ from [The African Boss](https://theafricanboss.com/wc-sms)
- Unzip wc-sms.zip file and
- Upload wc-sms folder to the “/wp-content/plugins/” directory.
- Activate the plugin through the “Plugins” menu in WordPress.

= After Plugin Activation =

Find and click WC SMS in your admin dashboard left sidebar to access WC SMS settings

**or**

Go to ‘Woocommerce > Settings > Payments’ screen to configure the plugin

Also _you can visit_ the [plugin page](https://theafricanboss.com/wc-sms) for further setup instructions.

== Screenshots ==

1. Main SMS plugin settings
2. General SMS plugin settings
3. Send SMS plugin settings
4. SMS shortcodes
5. Customer SMS templates
6. Admin SMS templates
7. Marketing SMS templates

== Frequently Asked Questions ==

= Learn More =

For more details about this plugin, **please visit [The African Boss](https://theafricanboss.com/wc-sms)**

= Internalization =

SMS for Woocommerce is compatible with all the major Translation plugins (like Loco, WPML, etc).

= PRO or customized version =

Please reach out to theafricanboss@gmail.com for a custom version of this plugin.
Visit [The African Boss](https://theafricanboss.com/wc-sms) for more details

== Usage ==

After activating the plugin, add your Twilio settings such as your Admin Phone Number, Twilio Account SID, Twilio Auth Token, Twilio Phone Number to start sending SMS notifications.
You can also use a designated number for your store if you do not have a Twilio account.

**Unlock more great features for you and your customers and priority support with a PRO license. [Upgrade](https://theafricanboss.com/wc-sms)**

== Upgrade Notice ==

= 2.8.1.1 =
This update is a security, stability, maintenance, and compatibility release. Updating is highly recommended.

== Changelog ==

= 2.8.1-2.8.1.1 Nov 15-Dec 15, 2024 =
- HPOS compatibility & WooCommerce Blocks support
- Improved all around code
- Updated Woocommerce and Wordpress compatibility
- Updated Freemius to v2.9.0+

= 2.8 Sep 15th, 2024 =

- Improved plus_on_phone_number
- get_order_phone_number
- Improved twilio-send
- Added wcsms_log
- Removed apilayer number validation
- Updated Woocommerce, WordPress, and Freemius compatibility

= 2.7 Aug 15th, 2023 =

- Using wp_remote for the create/read API instead of the Twilio SDK
- Updated the Twilio single & bulk send message function
- Updated from Freemius global wcsms_fs to function
- Removed the Twilio SDK and SplClassLoader
- Removed admin jquery modal
- Extracting domain from site URL
- Internalizate phone number
- Updated Freemius to v2.5.10
- Updated Woocommerce and Wordpress compatibility

= 2.6 Feb 9th, 2023 =

- Added the [order_number] SMS shortcode
- Use order_number instead of order_id in SMS message for Cash App, Venmo, Zelle
- Added "Reply STOP to stop alerts" to the SMS messages

= 2.4.1-2.5 Aug-Oct 14th, 2022 =

- Better Bulk SMS list presentation with numbering
- Bulk SMS dialog box with where to start sending messages
- Bulk SMS set_time_limit(0)
- plus_on_phone_number
- Better phone vs email selection when sending out message
- get_order_number to get_id in replace_order_keyword
- Fetch the most recent 1000 Twilio Messages
- filtering woocommerce shop_order
- fixed amount currency in message sent
- Do not show empty Zelle info
- Better inclusion for registered vs guest customers
- Removed no longer relevant admin assets
- Updated Woocommerce, WordPress, and Freemius compatibility

= 2.3-2.4 July 7-17th, 2022 =

- Added reply to email option for admin signature to the SMS message
- Added select all/unselect all option for bulk SMS/Email to users
- Bulk sending with select all enabled will now check off each user that was processed
- Fixed a bug that was causing bulk SMS to stop instead of skipping users without phone numbers
- Selected users for bulk sending will unselect after processing
- Bulk SMS now supports MMS with the ability to send images
- Made 'Preview before sending' clearer
- If phone number is not provided, an email will be sent to the customer with the SMS message
- In case of timeout issues, the SMS messages can be sent in batches
- Better error handling
- Added a counter for selected users for bulk SMS/Email
- Added a character counter for text area fields
- Fixed buttons that link to corresponding tabs
- Added select dialog box for bulk SMS/Email to users
- Added count to bulk SMS/Email preview page

= 2.0-2.2 May 1st-10th, 2022 =

- Added Bulk SMS and Emails feature
- Better shortcodes and shortcodes display
- Better error handling
- Improved bulk SMS/Emails for customers to include guest customers
- Added admin signature to the SMS message
- Improved amount total shortcode with get_formatted_order_total() in the SMS message

= 1.1 Mar 15th, 2022 =

- Added designated store number available for PRO users
- Free 3 days trial for PRO users
- More internalization

= 1.0 Aug 1st, 2021 =

- Initial Release

<?php code();?>
