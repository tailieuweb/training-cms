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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_groupb' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'k#<WY+m<%NkVd/)D;6eutaB$I6E43lbk8,; `.)N0`_eBFo/H=1^3l>ZU&B654+#' );
define( 'SECURE_AUTH_KEY',  '_sjx(yUs+zfEPJa|3yJ4Oy7@kmbIy5o#&0GbKKF,%*Hk.Ke6=@@e7s:mZ% 9(2}<' );
define( 'LOGGED_IN_KEY',    '/j}{Po`F|at[!,5XPyK_-*URMWOwCVhfXG#r~~=T^[-<$l>WL_T+cxolL{Jk*k{H' );
define( 'NONCE_KEY',        'hvw}G8.1-%d3ULCOBzsCqvvk|.fy .Ek~nM#7}v|!7S6s`hZ?/l5ic&9nbR=/P5S' );
define( 'AUTH_SALT',        ';|6)a($A{%c`bkL9$O0)iza{q] O.sh(dTC3}^qQNh*pS5?tZjYe,#;DEmI}uY,x' );
define( 'SECURE_AUTH_SALT', 'vh6F4`gi$^tIQqXj%YiidI*n)1o`]c4sL>!timp%RWIB+VkW,*2A%!_|g:u/JY!Z' );
define( 'LOGGED_IN_SALT',   '2YhET!|MbE|Q 3]uBPL3vhb[zO1AJC?g(+$JZFk2oGY9`E,E(cj86%EW/zmFrCXs' );
define( 'NONCE_SALT',       '*utf2{3m~=Jsi^wjfY3COrHmJ~=r+J_;Tvs^|_8t%jeHtA1&.G98Xo7vsaYQYd[;' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
