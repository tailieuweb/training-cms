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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         ';UHNAMusME^!QN*B`X19dJ9=AG#jJ1sn73rYT]0~N$/n;VF=y)dL:fL^| uNn[,6' );
define( 'SECURE_AUTH_KEY',  '%EG8z>4`kPD@jGIr8_i}<r8Ine?N4SR$P+_M(u36/$J-DOoLiytWholp^N]q_Y+u' );
define( 'LOGGED_IN_KEY',    'nwRW2Md~xT_0mi~5qj;`QInnlM5<Z/#*o-rNAU9k,nG0BT5BK3*!xkX< /[l{ZcX' );
define( 'NONCE_KEY',        '7`9K4AZ)ju9J$iJpD8JqWS@2Qq*~&||2dEa-)Q l_JTfU_@&we06]wb~AFh>J20h' );
define( 'AUTH_SALT',        'f^S.gN;?:P,y{<!^xE=qz%i3{76.3#B6^@<k`M-EA`ZV9TnhT?s<PB2FR9h/u|ld' );
define( 'SECURE_AUTH_SALT', 'Vehx;FONXQbvHz{}Y#2gvU`m<eJ.!}@e9d%+oOnfq[#/!K1Rz8~ELtyA@D}^Il)T' );
define( 'LOGGED_IN_SALT',   'WAGp*P`A]p!FYbWq~2woNH=+[hWd-VPOn0YN<)Jl~WemPeRsHXD@/Hut4ivI^ZP*' );
define( 'NONCE_SALT',       'kt;<3H8a!^NyNsr64S86Ba!mg&~r-TT+dLNvG@kDl vV}O4tH/`SwqebVR@ tLIU' );

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
