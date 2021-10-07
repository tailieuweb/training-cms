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
define( 'DB_PASSWORD', 'mysql' );

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
define( 'AUTH_KEY',         'v pNWb_|OL=_RWXL=E+C&w8C2D._`{nawkwCs,#8#noa/.tC#4v8C8.!8416+LaJ' );
define( 'SECURE_AUTH_KEY',  'C*zbG1Hy90L4Z6x_a2n-.1(hl#TIUc.Cy>NdwG5?o90cZ&$D_bBA`!5PJ0l-EXnC' );
define( 'LOGGED_IN_KEY',    '~Vtu/(FVrJvD5a/u-k3{xbSViw^-;$9U4S1Xxht ~qAhUp.53C$>U@*QnsS:BFHc' );
define( 'NONCE_KEY',        ' CGUu(+x3YF^-=H1:Zx<Y:7DWNvU(9vW1]H@7DlLJdq[-i~meuZ{o<tga6`F|3=|' );
define( 'AUTH_SALT',        'soJC}<l._bb@OG1Q$gbgwTx;}6==uik+E}1,N FfP!Th0Ft-*`Gq*4QJ.[?/NnLx' );
define( 'SECURE_AUTH_SALT', '9%Zg=$X3(qk(`0~NP%T`gr7=hB{OMn31B>Z #ht_uAvVdN7w9wX*S3@KYf[3]7?n' );
define( 'LOGGED_IN_SALT',   'VW:I~_Ds6=zB$qd*I9ReNHHR5e*&,qMASF6]Ma~wOl]1AMk+Xtcw5Ask}9r,%=s2' );
define( 'NONCE_SALT',       '?k8Io_<<VCTDeQ);tK7J.lz~wzKs9g6|$9WY@m~d{(UVW{({rE((9`HMrwkzA$Iq' );

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
