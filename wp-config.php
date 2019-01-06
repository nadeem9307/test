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
define('DB_NAME', 'webcom');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '=)YCl$T92HcL@b_7rz,b@KY-?tKpBQ|XmSu$5}J9D@l}Lct[`8olXI?lS}QI0[FM');
define('SECURE_AUTH_KEY',  'tnq8h9ZmDl.s7).Ykkz-,@p8w)c]:HxTMu~{lHMGkGC9$ ;Zf+$dIeBwvAEkS6@>');
define('LOGGED_IN_KEY',    '-nCFrRQ4Z #zQnb[Zj5Q5u;V__Ic3VS?Skp.[;@6%q3q@aRKHtu/RBcg(xLCi<MY');
define('NONCE_KEY',        '5dz={`}?8ihWF#vIx;|JI1F%1;CbazAa9TGE[oMH5v%hgeU,?6LP#ii3>FM}GWr ');
define('AUTH_SALT',        'X^4?!0%ngST[IMlTGgsRu(P}nE}T[ rxTJ`M`9#_-f8GUfah{Isu-Pfl@o:}~OD]');
define('SECURE_AUTH_SALT', '/:quw0k27#/=W>YqBzcsa-)nvl{X#3QuO$3B%pfI{u<nH#<5o@~ahfvR^6hwuE]3');
define('LOGGED_IN_SALT',   '*H^EO:|]o2i+^k%A@7{v,~j1kiH]l /8qN+K@(Hn!BgxkIl|~}WArQp(l-BIJxO]');
define('NONCE_SALT',       ',%1c{y|H9gZw/~ _)/UjjP<0`eK/r$cO55TQ(YM.`6+u{km`sW)Dhjc[1:tz5>|[');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
