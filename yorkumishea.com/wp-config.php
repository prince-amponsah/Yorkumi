<?php
define( 'WP_CACHE', true );







































































































































/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dpluhwal_wp504' );

/** Database username */
define( 'DB_USER', 'dpluhwal_wp504' );

/** Database password */
define( 'DB_PASSWORD', 'S7@.58(!SuC2Wp!6' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'xwhqln2revid3cr2ma4jjbxzke4oekx3ktv0ccdczn7j4bv1d7be7ykc4nifukag' );
define( 'SECURE_AUTH_KEY',  'zze220aombukdqmzxw05cto5dy8uwrs9p8ax4aw3a2enzqmuji3s9yaodgpipkuk' );
define( 'LOGGED_IN_KEY',    '5yllel1fvdvtp9tjijzfhzynuscovxa26ihk5kvxjhhww81wqkimfbzslgthqwk5' );
define( 'NONCE_KEY',        'un2ig09npc0btswxrrsico6wrzafwrqehrdowbvlnkssrtx0d9vnvjpdw5hmx6q9' );
define( 'AUTH_SALT',        'iupodsjvaizpamcixd3af3qyanegohnsmkvcprn3aofsam6oqvpyngoxh9qpvcvl' );
define( 'SECURE_AUTH_SALT', 'zunnyz4uwdeojmp1qy0y5kllpi51sx5denrmwmzjevwl5vds66pfhg7d2k0jzpfb' );
define( 'LOGGED_IN_SALT',   '4u4izdrbihdyghrjrfplpvxotkdhcvs1xare6qzdefrbn6picgu62ejsvsozomu2' );
define( 'NONCE_SALT',       '4xtx6o3d7bt0o8winp1wjc29g0xmm3mztvfu0qmlqdnvpyz3tca1gbm8heoonsez' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp8v_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
