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
define( 'AUTH_KEY',         ')L#zW~+*`Sa7=PsWCPciJrTQ2WL~D4lF$6|M7H;WTBLKsub38 _2#8gMKIW_ZZVS' );
define( 'SECURE_AUTH_KEY',  'sDk[AB[]!l+(-][8VC5Ig,-:^*x [~<?GD z9o<lBxF{a=LM.TrSa^5(2;b w0Hj' );
define( 'LOGGED_IN_KEY',    'uML(y/%2#Pz<yL$%1n64:<j<lWmI3+v4uJ5kEIX;5]781Y[;%=]5`WuKr)b=0WA!' );
define( 'NONCE_KEY',        '(Nx9UKaXbs{v5?*<P1MNO~6#]s#%a1`[?)N+8sm-NOH1cr4P,C:coSP2wq#x[bK0' );
define( 'AUTH_SALT',        'jakl/7-PP3j_!FV[.;f@6cy.Hh<0A{)`A{:)}.*UTUH_X{L]?hz!cZ+S#=t+Nh{$' );
define( 'SECURE_AUTH_SALT', 'Uj ^izpkY]2;|%rW%SdQSqf}F|r5glxoam@gUD#]%ySL%]DK/;nE!a2{lG.GY5!T' );
define( 'LOGGED_IN_SALT',   'n*rP&ZPE(cWAjyy:`H6SFWu`F3<J+E(T6;;8w+Uh5aOjF_`yhCA*-X4EG/D#ub9d' );
define( 'NONCE_SALT',       'N8P[rG&Ru$5!6>ksYwvI5b4r`.;->ID`>7 J. >&wc]rt%+1tQIN$~vyCd?awWRx' );

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
