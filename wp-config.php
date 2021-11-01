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
define( 'AUTH_KEY',         '[0QE_C(Clc:{&;&NY7XedBymf8Rv<sMQU2 #@*f@}=Xl?bspdRsjFlP:U}[,@a}s' );
define( 'SECURE_AUTH_KEY',  'ldrvj94?JjzHm57i-w|wLaHpVeL5;Xj#v<9gvpao<|u5;gV9(`({Hp(Ey~x<N.H|' );
define( 'LOGGED_IN_KEY',    ',00J.Uv-<-&Zx{ZG`>sI*:+{euk7|&j&>kGXF)t.1?0t<?YwU6@;_~$y-OIV1DbV' );
define( 'NONCE_KEY',        ':SlN9%u,wT.cV2}37ofJ;qSDB,! zBd/m6*K3?+ MLp.?|SgPjZJ[]q*dT<_RQD@' );
define( 'AUTH_SALT',        'zAlH %oz)_m)E!.8HyxC~N)i:i;HqeHKsYHIL};fa0}h>!s2hSYK_P@xwJ =h,jc' );
define( 'SECURE_AUTH_SALT', 'c9I.IZ6|),5,H33&!=0}Sox>x3[=uLfW;3*p)Z5 AYCb3|:P-9QwQ 7N,fg]zra8' );
define( 'LOGGED_IN_SALT',   '^osHma+w7_}HnTaVc=Q:TVK6bLNO~{Rf-f~:ks1,wig S=p?R8zNp[s(Yr_o{Ve)' );
define( 'NONCE_SALT',       'BJz6*1ik7P.<eNRvFl9,$= aj&rp<cQ3:I$EK23zmp]f0&;0~~94b7Fdc}pa@Arg' );

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
