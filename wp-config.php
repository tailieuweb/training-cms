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
define( 'AUTH_KEY',         '2.2B tQZdQ(L~o=Z:1GO%h]Vt=t{]#0c}D`Uu8J]}w/iwPuL5(gcFGV;?@]&kBgo' );
define( 'SECURE_AUTH_KEY',  '7W$$4?5hzo9pSi(OY~_rdm>_R_=kAAx#`9:r?f+ec5hI00DqX*ypzacwp/JIjZP%' );
define( 'LOGGED_IN_KEY',    'j%L):Cltpm[HG2`=+Fj]- 1,nX/eA;8Wd7C9^e{Y#]/g/[^;T>fOthWdc|PcB>n|' );
define( 'NONCE_KEY',        'smEeDBq35A:LQt[C;d=*k|*0c+O=(NG^b=sGBz!G?P/7(T}vNpeb*%2B-jE}jy<W' );
define( 'AUTH_SALT',        'e/N-3-K51zVYW*}66>D{vgZu&6ZR.aKPE:@Umc&!)DPC5#N(wJzT,K=}5*lco8O:' );
define( 'SECURE_AUTH_SALT', '.$`m;7T%0WT5u>cd+]Jy$9/@hOB-YiacT kLSY3x9j(:gUg.HB!FZQf xA9Zf!`f' );
define( 'LOGGED_IN_SALT',   'Oq>5uV<8AG(#INl%F)BO( m}A9V<mOQp!$&x.97 =3I*wX%fkf.{$?O6Lg|0E6=V' );
define( 'NONCE_SALT',       '9![dzc6,k`OuIVPKz;QKF^06zK]-Lh)<7tZWKjh/P2){:`fYs !m3n$yP;0659EF' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp581_';

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
