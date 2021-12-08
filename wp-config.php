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
define( 'AUTH_KEY',         'V(ZXU,8wP.5c7i[vyvqdFe?~t]bwW4xlS13e=.>@<<&:#Zdic5}m_oe#ZHFyQe*=' );
define( 'SECURE_AUTH_KEY',  'd:f>&ygV`(OZHxdbACUB]2szJ/QG-D[G(vOgi>2wXk=+k$&w~<&g^_we;c8Wsh(z' );
define( 'LOGGED_IN_KEY',    ' U ~Jv-Xbn/_p r?fg`GzRnLsD;yjZ6/<VL^b`67I_8$GhQr;XMeuvYc-*NrMz4h' );
define( 'NONCE_KEY',        'CpB%e9B}}69GNm;%[Q7,zv/15Td9)R)4kKc:ROb.f;: 3_zw`cEtZ]UpmVm#c3Rl' );
define( 'AUTH_SALT',        'r|pqn-nGi$*))V`ltY#cPm(eUl6DPQRw)r^MI^`en%7N8TOYC~COuW;WeZ;J>,Qz' );
define( 'SECURE_AUTH_SALT', 'N-MJ7.@cYygnLqz$z5uIV0nf?}Qv(a,|#9R_hA&E}=gPesS@0HU4XKzu<m#BlOk#' );
define( 'LOGGED_IN_SALT',   'O3;#zkJn0sd-vvJWR*0sklDb0brH9H$TZMdBc0@o%+ #I.M?WsM6]E})cK$1wud8' );
define( 'NONCE_SALT',       ';K,mCWv{)W4s%&JRTaodSM$p]@$7;I&ffo_t//H{X^X?Yqr& ![oBJ=J6[.*(Q)r' );

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
