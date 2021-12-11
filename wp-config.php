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
define( 'AUTH_KEY',         'P>e-Fm$Db+y$Mk96_x1e~W)+Qry?(YB;([+[]c&CU6SCZu9u?@f-lGqjU0n(kq~,' );
define( 'SECURE_AUTH_KEY',  'MZOc30QX 2pYM5+_qMt1)^(OSNN0/xi6Y?J}spXB5kUPaBhm7(||b`wKbiJKw]U=' );
define( 'LOGGED_IN_KEY',    'J$:XgjChuH]o]oIGJQ/]O$)XeE<gwZ$QGN_a{KLnTSk^Kc`!T4wc1S?XYu@.H;]r' );
define( 'NONCE_KEY',        'fC>9N#n;+-41GnJFs[NNyk86yCGf?]s]Mz0l#xAd~@5xls .Z uP*Qq>ST|v:bW6' );
define( 'AUTH_SALT',        'ExH?`zC7vMb3sI4<2Oo*!)MBL`EKsnrmPTMZ_/qZ>+^#kY=rn(O<E* B/DF~UHih' );
define( 'SECURE_AUTH_SALT', 'Jm*=I,~N]2z~QMPsmChAn5Z#C0UM0z4ByCmF`4r[/=HSO[-/gAb>c5=Sq}cRBF}i' );
define( 'LOGGED_IN_SALT',   'x^s{_?$+(=U29V83#8cK{EDi}=1<597]J:,{Ps9SR^r^&-s#Y[ebV=pHqGYJ.O~p' );
define( 'NONCE_SALT',       'N|@.U@lH5/x:0TNBl]dUQ_k]=}ez[-Rp9hVSel~JN!4=ZUFZQ-o_k9X+P&- }k;o' );

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
