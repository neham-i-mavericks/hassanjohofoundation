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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_hjf');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'emhQo6zE{,Er');

/** MySQL hostname */
define('DB_HOST', '52.87.63.205');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'mFOIZ*oYlBw-a!uo  C3Ea1W)p&-0$`X0w8`^9K9G?5@3:)qUe81[_C.7Pbo/f:G');
define('SECURE_AUTH_KEY',  '24n;ts.n-l7PzF<<m3cWd2wc#u+{`LM<p7#?g-(dOY9$ t4Tl8tT Bd#.x`IPVeS');
define('LOGGED_IN_KEY',    '#>|[sWU-Kw|gFuY7t{!|8Ozv&JD~1@Ls:^QDuv#UY$8OIr=rkckMveNQsu.OU0ys');
define('NONCE_KEY',        'Ldmq-2!BftRf$}rr?(;^UqSklS>!be$u[)h9$y2lN# W$77Ia4Q8-;O?Yw(>pe.p');
define('AUTH_SALT',        '4gA28{$|JsuBB:MlON!.PxV*(Y!f,*C]JfgpyM@GiBv-[x:(JC2TF.MJpET/MIdL');
define('SECURE_AUTH_SALT', '~+d?klwhm  v`.mj+[[S+Q6j{M_|[vd05ly)R(oo#Hlz$}NRc~V0LbS4D2C*-=ph');
define('LOGGED_IN_SALT',   'E|DC;g`1Ne7VUuFp!$4`VFcS@@=E1;gQaPK{9]=Y :/}5.tU%(-OP72 >|Jl=7[w');
define('NONCE_SALT',       '&|56/0#X_%`i(2@sz()SPnA)Ab5*z8|5klj,Pk$eid$3]snt.M2`4?C ^]%,iD}S');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

define('WP_ALLOW_REPAIR', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
