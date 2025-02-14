<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db_willinton' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'l#HRX% /lC&sHOWV*{YDj.gDS<&{GbUD$G9&U?J5ZP7yKd2z9q$xlmk!MZGHMg08' );
define( 'SECURE_AUTH_KEY',  'X&N>?7ux(%WM,h]Y8|=s4Ss7A$}a}QocJ{xZfWO2b2Ml+hmR$W10*<>G0 _DL.~^' );
define( 'LOGGED_IN_KEY',    'yAs=LHSa}9~RV:2xxKC1>r#X4q#3$sjFbuJHM>sN{`]HZ4denLUuY,wexe4/Rk M' );
define( 'NONCE_KEY',        '#>XG8Q@!e7zs,HQfHCm>6_?TLDw[&T%[yQs_1(k(}dwk1H#>|Ho{fn;CMh!Xw,uB' );
define( 'AUTH_SALT',        '?b2/Z8rsG{xskR(N_9elzbpL75<O}7R{~peJQX>J VimU[EMU126*<6gZ`Jt41*[' );
define( 'SECURE_AUTH_SALT', 'z?RSi5o3_%P.NHO=m%j(*)Oj#*.,g@G0*QHc~BXx^@GXYW,J7Mke{z,5?N{]S]n_' );
define( 'LOGGED_IN_SALT',   '-uM?%=uZwWAk$G:[JT9=eB0Y@#(Vvr2%APZYzaG]/Ei?CMRarlT{J[qZ,Uw<Ux]f' );
define( 'NONCE_SALT',       'WkOy3T$v>dXA=7nuLD`-H|6!jJiK{U}pOL%qL3pc*nWb[{g$hUl=w3g6z5ZDDPhp' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
