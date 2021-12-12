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
define( 'DB_NAME', 'cms-project' );

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
define( 'AUTH_KEY',         ',sxt;J`vA.,pfqqh^UzZMLXcysab|e16E57gl)PQP$:rSAheq2_xA#08;Efo4c!o' );
define( 'SECURE_AUTH_KEY',  '-?#h?Txs#4bITt)E-aP H[MoKhE|)1pS.NjvXrC6M{B~!dWtGBdfWvn=V&+~lq9+' );
define( 'LOGGED_IN_KEY',    'v8Le+0Se(Gp:0YZMl2l* =S9/P+#^$[)R#,8?0x<|;`vJUdU)7B27kr.I*1hL1N1' );
define( 'NONCE_KEY',        'dmP!-KO!/;;x1KfPE*9|`1rGe`Wz:+!!x,{C~U>/<L&W-QF{,P,xzF-PuUiRX&M5' );
define( 'AUTH_SALT',        'm|Y<qDq91Jw$!>P84Xgj#`FjbkBW{{8->%,$`GUT],JePQxc5rYY-Cg*bGO-{|Or' );
define( 'SECURE_AUTH_SALT', '5=;,FnmBTaN-E{< wILgJf5o|D^~C+0WdS Onk60O?Z0#L2>U~dn0Nj,7uEtqsdq' );
define( 'LOGGED_IN_SALT',   ' <9DcG=./0Za2zC2v+cU+s_|p&o}5 UKnJ-aM@[a;_%d`;O[#7Q375.qP7m0jUIN' );
define( 'NONCE_SALT',       'wTg2luvd>4D[@ah54 *Jen/-4|K-AZ[&6PZ+h3}s1|CN_O`l$X;D1b:y6AY_y=?d' );

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
