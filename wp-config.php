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
define( 'DB_NAME', 'wordpress_581' );

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
define( 'AUTH_KEY',         'ko{7q>`d8Gxp2A(i^]T(#q4&JD2T-M6]sFm=DGtS5aX^ y z(n]Q>)E2lWS5!OH|' );
define( 'SECURE_AUTH_KEY',  'RaGC~|pG-d6T?$)50N!GGoQ/ggunM($;951k0[lr129&IuI1&NjuFfT.e`t<9.kq' );
define( 'LOGGED_IN_KEY',    'CNB[49~(M17skq!,->?lTXb@MN!j7}P3J8-}ZgPaK/R$=p>0.)]BuQt=K?qDB?q)' );
define( 'NONCE_KEY',        'v[|js:t;?s:_t7xZ7WX4~RQ#j8]Po:NT.XhY#4>z^lVDc,zYG&_e=qDc j7R,Fc}' );
define( 'AUTH_SALT',        '^`UE}0fu.k. ;A3C*vUkF?AhT>E}V|na<lrPbv2-rYF#KPThe)V-D[rz=+L!owG3' );
define( 'SECURE_AUTH_SALT', 'Y9**E`Hi4dBSzS[weEq8(zq8]Gk?T?bt.Or3Vw`[-sc]>Xj~vZ(y]?` $nk77VF4' );
define( 'LOGGED_IN_SALT',   'O`;;=wJH.lj|u^tHn5uz;Y(,nD_+K^ucp2Hju=[b+EA?Aq+bds-IH}v95-V,Dg{k' );
define( 'NONCE_SALT',       'OefSNuEXNgY6S9}ck@Vu:7SfdKsiP<G.?]NfH(k{lAUa|ea7d=`XMF*yrZcQ-nu ' );

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
