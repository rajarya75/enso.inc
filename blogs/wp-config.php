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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ensoweb' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
// define( 'DB_PASSWORD', 'oiS-^38CP$7B' );
define( 'DB_PASSWORD', 'D311#2024' );

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
define( 'AUTH_KEY',         'a-^]L&>W7_z[Ry R`sF`:Sywh+|TslDq|Xs1L:D(qdTT<20w2uLNwcfG!J^Ah`sm' );
define( 'SECURE_AUTH_KEY',  'g6m72Sa]8@GO6g.IWN2?|JE#;-%6x,Z`k[y6PuqhJLedSuN6IJ=G$I&_/vRjCD6B' );
define( 'LOGGED_IN_KEY',    'MkaBj<!FmkF9J$!$X}Xrr`4gBjDU_C{%6-jJ)tKp{o[0!HbyD.8oZK5j`#V~WMi1' );
define( 'NONCE_KEY',        'Nl4q]|O+`}u!Aoky%Sa?YO+L/hG=}axadVaM.Z*$Sj-.i:]/KZWw-~9uK;Fi=fEL' );
define( 'AUTH_SALT',        'O?q,cHgE^0RBWcqu]r=C#+Fo( zNbkDAd5A*pjWTJz35$|tYV!y(qI0Vv65[y]Z9' );
define( 'SECURE_AUTH_SALT', 'O/q*F4~UahQX$cPi[@K UO}vUB_T*2:UnZ?YT^nx1@jc&q/|d@$Rc^:[b3q}<vo(' );
define( 'LOGGED_IN_SALT',   'PKQIR<*/34zDual%{-dTKmrj#N&t@9QGK0/;[ro%?h{NT^}?=T(@^js>b7Tm1;8|' );
define( 'NONCE_SALT',       '{5]<jN8%8uSc>23im0Fbp7o6z)5|1mF*3Vi2NrMlxY=8 >On.&Nb.(SDqSBdPSSw' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
