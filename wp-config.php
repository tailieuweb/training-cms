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
define( 'DB_HOST', 'localhost:3309' );

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
define( 'AUTH_KEY',         'S&Mx5RtAh&k4n:9v)/Z|rzr9Q5#>1Ow1Msf*kvl]XO,{Ytm(0BH/jjcTS-WS_5VG' );
define( 'SECURE_AUTH_KEY',  'KJ(}n&{0*C-{G}Jz*WZLa+?A+{~5gbjgfn2s`%3]l2<G)]QpkUbZz]wWvQA#h*r7' );
define( 'LOGGED_IN_KEY',    't,QX!]9tx%z[FIjo)2vm|?v)i92!AE&/1;rOymlePC!V7l2_w!k~t~6Ej18G=*f3' );
define( 'NONCE_KEY',        ';ZXYx8tRl{ZA$P,Td}jOH,[D]k6RUs?xnwp  cRuSD_;QT_YU8+(FvqOl uv!o{F' );
define( 'AUTH_SALT',        '!%QJT=Lc[m);=Foy!T(,8f?,<+vd|fLqM.RLgK@JpN4H([ek8yelB+G,9y7GFc@y' );
define( 'SECURE_AUTH_SALT', '*+hJ;7/+_PS-%=IW=s]qg/2zZ`05e1a,s9=QTJ}R5Hjm$Mw4E6(/?Lf.<oCXRlJs' );
define( 'LOGGED_IN_SALT',   '3I[X&58o]K4j@6M!*t;j616{8P2:f&kiEYG^DSof{<*6y<=P~2j~h<zh@,<StvnS' );
define( 'NONCE_SALT',       'VJyqk1tM<Tyb&RHF%xMM) Jm^l1qo0;9_]y[es8Q,5FCiY37MJ5:JfI.R:]8~CPr' );

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
