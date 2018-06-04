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
define('DB_NAME', 'thanhhaijsc');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '123456');

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
define('AUTH_KEY',         'Rl;8^J,~WY>;~{h{Kt`d<mjF@=l|35NhX8=2dO>~?C&E}Zm$:5c3NmQQ#5lwkTZl');
define('SECURE_AUTH_KEY',  'EgD3cfuoeFcBF;?q{hR=!4t3P+8X*{-[IXl6>/7=n@zF~fI/@RMlac:II{-c[3P]');
define('LOGGED_IN_KEY',    'V(PSV5FrqPfX[#6qU>%R,&VaZ~C5!EPd|c;Z3IE-&*u%up2geo$gWX+.zv|0X*YG');
define('NONCE_KEY',        'Nz},c[S.N{J#>,F~^Xh8#]} 6w!yw{DuHO{fv9 Kxxs_VB!v(&&WZQMsfDbv|b-Q');
define('AUTH_SALT',        'fFI[d#%G}O&kj]]$t2N;TPTp6+*XN*Il:jq)]JM5_O:mo<$XFJ^SFY2yk,[!3pzt');
define('SECURE_AUTH_SALT', 'O=k.d`8/%g`nO]Zr>Vg1RD=?_k=za!2_UuSt^s8(DIy*q<{*C` @yYCHQ4]&$@/`');
define('LOGGED_IN_SALT',   'ne};6o6<9#bnhZjXmAp@M1n[|GhaVSuE%`c.bR]#ZAH,zsDTkR0XGlBXEx;  :q]');
define('NONCE_SALT',       'g72Tb=6Sz`m%x$N^,UB+E[htgSE}@/.ZX!S*yeAWN4f57eGz=>9NlZF!XSn7-qkK');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'xzv_';

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
