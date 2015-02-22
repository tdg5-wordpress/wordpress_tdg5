<?php
/**
  * The base configurations of the WordPress *
  *
  * This file has the following configurations: MySQL settings, Table Prefix,
  * Secret Keys, WordPress Language, and ABSPATH. You can find more information
  * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
  * wp-config.php} Codex page. You can get the MySQL settings from your web host.
  *
  * This file is used by the wp-config.php creation script during the
  * installation. You don't have to use the web site, you can just copy this file
  * to "wp-config.php" and fill in the values.
  *
  * Many of the sensitive configuration values are expected to be defined via
  * Heroku environment variables.
  *
  * @package WordPress
**/

/**
  * Database settings *
  *
  * The DATABASE_URL or CLEARDB_DATABASE_URL environment variable must be set
  * via Heroku environment variables. Most database configuration is derived
  * from the provided URL.
**/

$db_url = getenv("DATABASE_URL");
$db_url != "" ?: $db_url = getenv("CLEARDB_DATABASE_URL");
$db = parse_url($db_url);

/** The name of the database for WordPress **/
define("DB_NAME", trim($db["path"],"/"));

/** Database database username **/
define("DB_USER", $db["user"]);

/** Database database password **/
define("DB_PASSWORD", $db["pass"]);

/** Database hostname **/
define("DB_HOST", $db["host"]);

/** Database Charset to use in creating database tables. **/
define("DB_CHARSET", "utf8");

/** The Database Collate type. Don't change this if in doubt. **/
define("DB_COLLATE", "");

/**#@+
  * Authentication Unique Keys and Salts. *
  *
  * Change these to different unique phrases!
  * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
  * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
  *
  * All values must be defined via Heroku environment variables!
  *
  * @since 2.6.0
**/
define("AUTH_KEY",         $_ENV["WP_AUTH_KEY"]);
define("SECURE_AUTH_KEY",  $_ENV["WP_SECURE_AUTH_KEY"]);
define("LOGGED_IN_KEY",    $_ENV["WP_LOGGED_IN_KEY"]);
define("NONCE_KEY",        $_ENV["WP_NONCE_KEY"]);
define("AUTH_SALT",        $_ENV["WP_AUTH_SALT"]);
define("SECURE_AUTH_SALT", $_ENV["WP_SECURE_AUTH_SALT"]);
define("LOGGED_IN_SALT",   $_ENV["WP_LOGGED_IN_SALT"]);
define("NONCE_SALT",       $_ENV["WP_NONCE_SALT"]);

/**
  * WordPress Database Table prefix *
  *
  * You can have multiple installations in one database if you give each a unique
  * prefix. Only numbers, letters, and underscores please!
**/
$table_prefix = getenv("DATABASE_PREFIX") ? getenv("DATABASE_PREFIX") : "wp_";

/**
  * WordPress Localized Language, defaults to English. *
  *
  * Change this to localize WordPress. A corresponding MO file for the chosen
  * language must be installed to wp-content/languages. For example, install
  * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
  * language support.
**/
define("WPLANG", "");

/**
  * For developers: WordPress debugging mode. *
  *
  * Change this to true to enable the display of notices during development.
  * It is strongly recommended that plugin and theme developers use WP_DEBUG
  * in their development environments.
**/
define("WP_DEBUG", false);

/**
  * Absolute path to the WordPress directory *
  *
  * Should not be changed unless install path used by Composer is changed.
**/
if (!defined("ABSPATH") )
  define("ABSPATH", dirname(__DIR__) . "/wordpress/");

/**
  * AWS Credentials *
  *
  * Credentials used by amazon-s3-and-cloudfront and amazon-web-services plugins
  * to enable persisting uploads to Amazon S3. Without these keys and plugins,
  * all upload files will eventually be lost due to Heroku's inner machinations.
**/
define("AWS_ACCESS_KEY_ID", $_ENV["AWS_ACCESS_KEY_ID"]);
define("AWS_SECRET_ACCESS_KEY", $_ENV["AWS_SECRET_ACCESS_KEY"]);

/**
  * Relocate wp-content folder *
  *
  * Facilitate dependency and package management with Composer.
**/
define("WP_CONTENT_DIR", dirname(__DIR__) . "/wp-content");

/**
  * Enable WP Super Cache plugin caching
**/
define("WP_CACHE", true);
define("WPCACHEHOME", WP_CONTENT_DIR . "/plugins/wp-super-cache/");
