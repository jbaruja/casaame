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
define( 'DB_NAME', 'u333211323_9DFcP' );

/** Database username */
define( 'DB_USER', 'u333211323_a56Fi' );

/** Database password */
define( 'DB_PASSWORD', 'yzhymYGAyD' );

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
define( 'AUTH_KEY',          '{SoOBNRyu5-BZ+sxSS8b;d#[K5.,XvRxP%bbpqq?~iMj/W73sn>2Vh~Ao!T% >#?' );
define( 'SECURE_AUTH_KEY',   'GB8b,q=4/^w`_8+gJDJ)(n5)FG}nR!K`Ijp@hA}~N}VAAr7neTG@qM}+WQ^2l6Yh' );
define( 'LOGGED_IN_KEY',     'vr[,^VqZiC/7@ #GDd}^SH{<A6#p1x37L440;t`iIe9ZNDeA/nDqxM*-GckHD>]n' );
define( 'NONCE_KEY',         '(rL$kP?6M%qDjK4<cww}Mo*VsbM|.4C_MTJGTJ>Db*u4dj_T HQmd9j<=>pKw% s' );
define( 'AUTH_SALT',         '~1*d2>~dKo9dia(1]QP}K}{8Oh{W7ghpi>BMFe8%Mb_?`AWQ5v!nt<jqIK!;`Ywi' );
define( 'SECURE_AUTH_SALT',  '0&Yit6/oo/<Y=W@j9v!2$]FGRvmU9a5VJTEysE^ltr?M=I,OzNkAczYA^MGh(*$y' );
define( 'LOGGED_IN_SALT',    ')9{-sO@m>S`RuA&$?KupGhpWF_q*+|8!7J$C8hj+E!Ju~?P>[%wj)p>Te5+5o|w/' );
define( 'NONCE_SALT',        '+|llM{F^ ;a=#;o*u>Y<$bw5gmg71H?8~q&]ZN2%J$>8rXbKN-s>EM@uE.FwP8{^' );
define( 'WP_CACHE_KEY_SALT', 'wR}>|:g;L:g05N5=T8t9 .s#OC,fXil9S]<y=p]5}1s=XAO4[Z#8It@t<;*RXgah' );


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
