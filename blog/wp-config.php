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
define('DB_NAME', 'pecan_blog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'pecan@12345');

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
define('AUTH_KEY',         'XI|fE5@W%UOvsroX,$3uBcU%(=#9n#8J+7GSBtXTV}MNziB({,NZs#fNx<&)?gGy');
define('SECURE_AUTH_KEY',  '_{h&#Brzp>#vA%H|^ntm.@t&R,o}-.BCpVICo~.{NGw9T($adb~?DIY.}$g5Dc51');
define('LOGGED_IN_KEY',    'dL.3FBK%XX}%<@Uq G0}H/(Pk68rJb2 Of5z84>mfM:a/-1uMkJB>FQM`6/nvFVK');
define('NONCE_KEY',        'W+y,k^;} QpF}+*ushuLa0uO,PmlR3,;n/TaauvS&j+R4l&#sB|H.hj8T2uXG8>W');
define('AUTH_SALT',        '|Ta:`5xTF0+4dcd/|12SBxe9io.d!x%-j*2z>EgV(aXjy.- i~PU#m,gW:<p*)SB');
define('SECURE_AUTH_SALT', 'R`,a%bC|V#,n??qU,Q6;JUM6.AP RaV+E9xib@ht`H{,c:Y.K<1@fkH((EUTSn9/');
define('LOGGED_IN_SALT',   'O>fe?x;P:/n-[w=l9(4Bf$4erHR.vE[)&CtZ0Y3A6#Jz[>P:h%LT.aQ+^LAzcpoq');
define('NONCE_SALT',       'R&w[jcr2VuRbeR--b>Cv$fR`l |Qp/&aT(u$1PkA_X;I}Z;=@7z%50 -WJZI[D e');

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

define('FS_METHOD','direct');