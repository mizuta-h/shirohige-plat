<?php
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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_wm6iw' );

/** Database username */
define( 'DB_USER', 'wp_qrd52' );

/** Database password */
define( 'DB_PASSWORD', 'Kj$gLb6*2a4cIu3L' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY', '((JyAY;71Mb~2(1CFQKk8wv%di!%kVwa+]u%GZVUn[45Vg9A!94WBFFb5v7@So)9');
define('SECURE_AUTH_KEY', '82L6d/1#1~v)J59%5|na@-lTx*6L/lk4o_t--u5-L*:s%UWmQ**1C7/aN]BB4;+x');
define('LOGGED_IN_KEY', 'R+1:61Ar615n()jdT1a55O/&5Gp|ZbSuW4FkM|h[/:P|6AUAU)n*K!2Nqle[06%P');
define('NONCE_KEY', '0p~;PHe:7Ptr7uJ9)2S!BPD[(%lcV1Rt407F0l)zm(8%rZ1c*hvB%LXcX%up7h:x');
define('AUTH_SALT', 'XyF978:#HknW37%77z1;k1n0-:8:%F%xKWF@p]V#/G4t-B#~Uxv7-Bmg!l58vSo(');
define('SECURE_AUTH_SALT', 'tV(9yd8d4O|2*x(F:V:c(w&cfv/4Oi97Lx5d56i~Fv0BhFMTu/[5D5L8HKT!&&hg');
define('LOGGED_IN_SALT', '*iI34[2qh2k_O#96%*B5P1adX_04sin2[3a6:01Vr4K~v61:B!k75a5E1g!10A6L');
define('NONCE_SALT', 'BHpZG1pNR9fO~CoH76e8[(Qf2SK:]01i0|ql!7#4lPB8RG3:Zi75PZyv9+Ycz*+x');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'LZ4CJWP_';


/* Add any custom values between this line and the "stop editing" line. */

define('WP_ALLOW_MULTISITE', true);
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'CONCATENATE_SCRIPTS', true );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
