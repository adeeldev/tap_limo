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
define('DB_NAME', 'tapplimo_wp724');

/** MySQL database username */
define('DB_USER', 'tapplimo_wp724');

/** MySQL database password */
define('DB_PASSWORD', '9[S)Up6Z3x');

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
define('AUTH_KEY',         '462rhwrneeuzzhuay2nequekm9fl6plhisouz17lutk4wibiioyixjrfijsqv8gv');
define('SECURE_AUTH_KEY',  'lbj4s64l2iwppotiuxqgu8mkceuvssvxapcsnzkiizamndgxoileluoagx6kh8qv');
define('LOGGED_IN_KEY',    'rxycegejo260kdx9k8oqqwazhkmww93umyy37hpuplqxm5vhymf569bfcxmb5xhw');
define('NONCE_KEY',        'rpzj5d2sca3aqielb3noyclwwqhghqusq7fk2fehwyxv1uk1tg8cfmc3wtehmtdc');
define('AUTH_SALT',        'awoukd5fktpdhnmfluacrajitog9vgcjgraaddgvooqkvx1w1fc6r5exjpodkbzs');
define('SECURE_AUTH_SALT', '6xh618hd0rfkmpilcwdq4ba9hssst4loap0fksivii5jms8cscuaesqdrs7m8a4n');
define('LOGGED_IN_SALT',   'ermjcbufted0rdea2spbxw2l1tckob7zswumybjifbspuk6cqynvxcyxzhhxqy5g');
define('NONCE_SALT',       'rxa0x52i5dbhojaz82jj2dkrejssqiosx7isdshq505d1o3tlut8x8s1wsyoy9fm');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp3koa_';

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
