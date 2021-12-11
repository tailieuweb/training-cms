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
define( 'DB_NAME', 'blog_dulich' );

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
define( 'AUTH_KEY',         'R^W18e%qhJM,3e0<ES0Lnm?RM:u,@ie~Xentk.qE7sa,V~1cY=>cN]h$M|iBHCNC' );
define( 'SECURE_AUTH_KEY',  '_@P7/e7?wh1][Cb$=%kfI^RT]NS<J>P(1ickIFn[wI=Mn84khe]XL-gP$1wx1Mo4' );
define( 'LOGGED_IN_KEY',    'FU8^AVyUkspd,bo@Y;rPO9li/<2XjaJH3Asu>W~UenrF:Q^Q1ne%1Wu:sH>ewJoI' );
define( 'NONCE_KEY',        '<PKN)xt;R+|Uk8gyU>57P^R)-=/RRmETKhB=.hK` %p8&_oeYLu>c@)qdQ]9pSDU' );
define( 'AUTH_SALT',        'RXN:Cj@oeLngZw`J9/ yM&;%IqSwHl;91Kd8/M`Y?}IX8T$f/9&2+mJp{O;B0LvP' );
define( 'SECURE_AUTH_SALT', '/h>I>h.Bz 5YYt=A23N`zoIiJG9(1y6%VGZa{NDoS-.K[+yF4c?l[a-:+PGI+F9|' );
define( 'LOGGED_IN_SALT',   'VNyeXTsn%{}&wZ/h8FYeR`k](qZHn}^kqj{|A!!>r-(`Ub/ng+<-8t1[B105^|oi' );
define( 'NONCE_SALT',       '~!ZU$6QGa8@E-yxIaZtGLE,j2a1C6Zkm[kiv^xtAbs5UJ/~h+r!_VQyWI}5)=|U?' );

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
