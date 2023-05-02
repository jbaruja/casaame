<?php
define( 'WP_CACHE', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u333211323_k5NkZ' );

/** Database username */
define( 'DB_USER', 'u333211323_qxK2Z' );

/** Database password */
define( 'DB_PASSWORD', '5mGiqOcDNg' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'bczlk}|kn|MUX.%!kWKQRlK!lvC5#B(WE~!PjYBu1_Pe=-Grr/jt817;$zTz*F*o' );
define( 'SECURE_AUTH_KEY',   'K61B_SfY/Q)y_6Y[Yh):P&!mL*jz=z0wQ*C/OAY%zf}.|wh^`]@X4 zcAA9K>Gfo' );
define( 'LOGGED_IN_KEY',     '_)mb-6V(Q%><b8c8q`@ /,z6zFGm5!tm|vB/<`^MutsU}r<&_M1~i,6lQUMw2jb8' );
define( 'NONCE_KEY',         'x}!C ProC&d@%Eu#/,OS|egD,US9*We6t SuVxI0>fxu?aPC%G:0#kZY,w]R:c9Z' );
define( 'AUTH_SALT',         'pe&%Mcy`p3>H-ntCeN>Ac[.Jg1|-Dng_sqG%#Yv@#)[MF!g?A$la%)6E:p_F>EPf' );
define( 'SECURE_AUTH_SALT',  'l%PtPIf!_3PW$bfnD4IJ}/&<MeQis&-F)-L3071~vpN9rJEsy|aOG&~1dg:2{Rm[' );
define( 'LOGGED_IN_SALT',    'b<~!FC!.>_74~gr*xfz2])SM;D^uxtJA]uU`?}C&w9C@ZK4L?19dq=h~=yIc@f` ' );
define( 'NONCE_SALT',        '@en,y{kBGOWM<=ikQurmP{viM?iTn8Xq_=X?;~0VzgF?IoF;A?H[{d)z9-|m+,U1' );
define( 'WP_CACHE_KEY_SALT', 'Z6JZe ,0V6;=36RW-,@/+$/bn~Sxd{,p^Q|,?>=U-It3SCrhNK7@Ni]h,3Z_o6Ay' );


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



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
