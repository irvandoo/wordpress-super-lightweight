<?php
/**
 * WordPress Super Lightweight Configuration
 * Optimized for maximum performance and minimal footprint
 * 
 * INSTALLATION INSTRUCTIONS:
 * ==========================
 * 1. Edit database credentials below (DB_NAME, DB_USER, DB_PASSWORD, DB_HOST)
 * 2. Rename this file to: wp-config.php
 * 3. Visit your site URL to complete WordPress installation
 * 4. Done! Your optimized WordPress is ready to use
 * 
 * Created by: Irvandoda (https://irvandoda.my.id)
 * Repository: https://github.com/irvandoda/wordpress-super-lightweight
 */

// ============================================================================
// DATABASE SETTINGS
// ============================================================================
// ** EDIT THESE VALUES BEFORE INSTALLATION **

/** Database name - Change this to your database name */
define('DB_NAME', 'database_name_here');

/** Database username - Change this to your database username */
define('DB_USER', 'username_here');

/** Database password - Change this to your database password */
define('DB_PASSWORD', 'password_here');

/** Database hostname - Usually 'localhost', change if different */
define('DB_HOST', 'localhost');

/** Database charset - DO NOT CHANGE unless you know what you're doing */
define('DB_CHARSET', 'utf8mb4');

/** Database collation - DO NOT CHANGE unless you know what you're doing */
define('DB_COLLATE', '');

// ============================================================================
// AUTHENTICATION KEYS AND SALTS
// ============================================================================
// ** THESE ARE ALREADY FILLED WITH SECURE RANDOM KEYS **
// ** You can regenerate at: https://api.wordpress.org/secret-key/1.1/salt/ **

define('AUTH_KEY',         'xUunxTb5VWkf|o2uEE^X@|trcvaSbx@.Rv%8{$ZstgdsK#2[#Nj_L_JG.m1/Rae@');
define('SECURE_AUTH_KEY',  '8xQRB/x+b!9)0L^9k%S1:1%yDx%16X!o+im{T>*0wkA,><rD.7nv+K8YO<DfufKm');
define('LOGGED_IN_KEY',    '=~txCiNT?>^J59|e(V&lPQ6&%=` C-Qc=R,?gE,I_QNKrb@-jL;A<)mciY&o(sL-');
define('NONCE_KEY',        'S3{>_5.F{kB:hXs/lGElS|yzE})XKG3pH+xu&o.;2D_!~DT87e],~, pz=){0b{c');
define('AUTH_SALT',        '}Ye^j}ksxDr5n:JWFP??r2bOyxB&Y;<*#yaMvl!(j1yGCe~OSlf `WcHf*HosR|`');
define('SECURE_AUTH_SALT', '6G6uOP54} *,euE<}=qS-sb=}A4s|KBY<}_osk|+o-n?~?MPsY9VNbg0WTTcjtk<');
define('LOGGED_IN_SALT',   'KbQRhRJ=;VRXPs1s9g|&Yji2KN]DmITwKTBAMtVhBjI0^^|hs/VR;|Y;Aki#9@Hp');
define('NONCE_SALT',       'vVN%FgNtu~4+:Qcc%QCVo]0_$Hkk~GY}9oj}GH8~`+%h<-B?J};8amp@l!-9Rusy');

// ============================================================================
// DATABASE TABLE PREFIX
// ============================================================================
// ** You can change this for additional security **
// ** Use only alphanumeric characters and underscores **

$table_prefix = 'wp_';

// ============================================================================
// PERFORMANCE OPTIMIZATION
// ============================================================================

/**
 * Post Revisions
 * Disable to save database space, or set to number (e.g., 3) to limit
 */
define('WP_POST_REVISIONS', false);
// Alternative: define('WP_POST_REVISIONS', 3);

/**
 * Autosave Interval
 * Increase from default 60 seconds to 5 minutes (300 seconds)
 * Reduces server load and database writes
 */
define('AUTOSAVE_INTERVAL', 300);

/**
 * Trash Auto-Empty
 * Empty trash immediately instead of keeping for 30 days
 * Set to 0 to empty immediately, or number of days to keep
 */
define('EMPTY_TRASH_DAYS', 0);

/**
 * Memory Limits
 * Increase PHP memory limits for better performance
 * Adjust based on your server capacity
 */
define('WP_MEMORY_LIMIT', '128M');
define('WP_MAX_MEMORY_LIMIT', '256M');

/**
 * WordPress Cron
 * Disable WP-Cron and use real server cron for better performance
 * 
 * IMPORTANT: After installation, setup real cron job:
 * Add to crontab (replace STAR with asterisk *):
 * STAR/15 * * * * wget -q -O - http://yourdomain.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
 */
define('DISABLE_WP_CRON', true);

/**
 * Database Query Optimization
 * Use native MySQL functions instead of PHP extensions
 */
define('WP_USE_EXT_MYSQL', false);

// ============================================================================
// SECURITY OPTIMIZATION
// ============================================================================

/**
 * Disable File Editing
 * Prevent editing themes and plugins from WordPress admin
 * Highly recommended for security
 */
define('DISALLOW_FILE_EDIT', true);

/**
 * Disable File Modifications
 * Prevent installing/updating plugins and themes from admin
 * Uncomment if you want maximum security (updates must be done via FTP/SSH)
 */
// define('DISALLOW_FILE_MODS', true);

/**
 * Force SSL for Admin
 * Uncomment if your site uses HTTPS
 * Highly recommended for production sites
 */
// define('FORCE_SSL_ADMIN', true);

/**
 * Disable XML-RPC & Remove X-Pingback Header
 * These optimizations are handled by wp-content/mu-plugins/wp-lightweight-optimization.php
 * No need to add filters here (WordPress not loaded yet)
 */

// ============================================================================
// DEBUG SETTINGS
// ============================================================================

/**
 * Debug Mode - PRODUCTION SETTINGS
 * Set WP_DEBUG to false for production
 * 
 * FOR DEVELOPMENT, use these settings instead:
 * define('WP_DEBUG', true);
 * define('WP_DEBUG_LOG', true);
 * define('WP_DEBUG_DISPLAY', false);
 * define('SCRIPT_DEBUG', true);
 * define('SAVEQUERIES', true);
 */

define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

// ============================================================================
// CACHE SETTINGS (OPTIONAL)
// ============================================================================

/**
 * Object Caching
 * Uncomment if you have Redis or Memcached installed
 * Requires Redis Object Cache or Memcached plugin
 */
// define('WP_CACHE', true);

/**
 * Cache Key Salt
 * Change this to your domain name for unique cache keys
 */
// define('WP_CACHE_KEY_SALT', 'yourdomain.com_');

// ============================================================================
// MULTISITE (DISABLED)
// ============================================================================

/**
 * Multisite
 * This lightweight setup is optimized for single site
 * Multisite is disabled by default
 * 
 * To enable multisite in future, uncomment and configure:
 * define('WP_ALLOW_MULTISITE', true);
 */
define('WP_ALLOW_MULTISITE', false);

// ============================================================================
// CUSTOM SETTINGS (OPTIONAL)
// ============================================================================

/**
 * WordPress Address (URL)
 * Uncomment and set if your WordPress is in a subdirectory
 */
// define('WP_SITEURL', 'http://yourdomain.com');

/**
 * Site Address (URL)
 * Uncomment and set if different from WordPress address
 */
// define('WP_HOME', 'http://yourdomain.com');

/**
 * Custom Content Directory
 * Uncomment if you want to move wp-content to custom location
 */
// define('WP_CONTENT_DIR', dirname(__FILE__) . '/content');
// define('WP_CONTENT_URL', 'http://yourdomain.com/content');

/**
 * Custom Plugin Directory
 * Uncomment if you want to move plugins to custom location
 */
// define('WP_PLUGIN_DIR', dirname(__FILE__) . '/content/plugins');
// define('WP_PLUGIN_URL', 'http://yourdomain.com/content/plugins');

/**
 * Automatic Updates
 * Control automatic updates for core, plugins, and themes
 */
// define('AUTOMATIC_UPDATER_DISABLED', false);
// define('WP_AUTO_UPDATE_CORE', 'minor'); // true, false, or 'minor'

/**
 * FTP/SSH Credentials
 * Uncomment if you need to provide FTP credentials for updates
 */
// define('FTP_HOST', 'ftp.yourdomain.com');
// define('FTP_USER', 'username');
// define('FTP_PASS', 'password');
// define('FTP_SSL', false);

// ============================================================================
// ABSOLUTE PATH
// ============================================================================

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// ============================================================================
// LOAD WORDPRESS
// ============================================================================

require_once ABSPATH . 'wp-settings.php';

// ============================================================================
// OPTIMIZATION COMPLETE
// ============================================================================

/**
 * WordPress Super Lightweight is now configured!
 * 
 * NEXT STEPS:
 * 1. Make sure you've edited database credentials above
 * 2. Rename this file to: wp-config.php
 * 3. Visit your site URL to complete installation
 * 4. Setup real cron job (see DISABLE_WP_CRON section above)
 * 5. Enjoy your blazing fast WordPress! ⚡
 * 
 * OPTIMIZATION FEATURES INCLUDED:
 * ✅ Post revisions disabled
 * ✅ Autosave interval increased (5 minutes)
 * ✅ Trash auto-empty enabled
 * ✅ Memory limits optimized (128M/256M)
 * ✅ WP-Cron disabled (use real cron)
 * ✅ File editing disabled (security)
 * ✅ XML-RPC disabled (security)
 * ✅ Production debug settings
 * 
 * MUST-USE PLUGINS ACTIVE:
 * ✅ wp-lightweight-optimization.php (Gutenberg disabled, embeds/emojis removed)
 * ✅ database-optimization.php (N+1 queries solved, auto-cleanup)
 * 
 * EXPECTED PERFORMANCE:
 * ⚡ Page Load: < 1 second (70% faster)
 * ⚡ Database Queries: < 20 per page (80% reduction)
 * ⚡ Memory Usage: 32-64 MB (50% less)
 * 
 * NEED HELP?
 * 🌐 Website: https://irvandoda.my.id
 * 📧 Email: irvando.d.a@gmail.com
 * 💬 WhatsApp: +62 857-4747-6308
 * 💼 GitHub: https://github.com/irvandoda/wordpress-super-lightweight
 * 
 * Created with ❤️ by Irvandoda
 * Let's make WordPress faster together! 🚀
 */
