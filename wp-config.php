<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'wp_assosport_db' );

/** MySQL database username */
define( 'DB_USER', 'wp_assosport_user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wp_assosport_pw' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '<oQ)E2qEs Lmnd~.$kGqi5m3G5,JL 7?_rZM!fF7Sw`mEJyS*?0*,XZf*)V>C$UL' );
define( 'SECURE_AUTH_KEY',   'GC[@haDm+VXI(I$z2a(?}YU2aiQ<)zz rloy7-1T[AE|1a2LtQP bRE Qht<}qt?' );
define( 'LOGGED_IN_KEY',     'OyoZ%sNcO`I_8j#crlf2t/YxOV^N7f~@CBGRZU4:KZNiy =>hI4Bc]]i0KM%0hqT' );
define( 'NONCE_KEY',         '7!i<If:o<vazDKvn2Pp}@v.8n*vc1TXJ8QB<RNF~bo<|>;-e&@}b6~qS-z|Qw>+O' );
define( 'AUTH_SALT',         ';x.r{xc@R_lrqHTbRMLL/C=)MA|cM-uh5gxi~abahqGla;*Zxut|~,^Q2<--jS&M' );
define( 'SECURE_AUTH_SALT',  'fnk@Q^X9mv)~!Xf((>a{d)tqm.z|(Q~j]u;dSX|N@$+mN*#T3omwhzsM$&&Z8uz)' );
define( 'LOGGED_IN_SALT',    'g>t9/OO{nH4{{pVCIT]HRC7VZxg|wP2v<|C.tV->l&+ rVu/+ezxR]-Z8p?a{2mu' );
define( 'NONCE_SALT',        '&UjQns3W+l|aj2zu7_Nr]w^rfm0}6IKEz~*B,~m`3=mY0l0u-1I_i{KIP)|dMWF3' );
define( 'WP_CACHE_KEY_SALT', 'cMlleRv>imWjyx-L` sx>?R>Vfpk9+F6/b;|K1&_ofX^Ev ~R%4B,,< M:FPzf W' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
