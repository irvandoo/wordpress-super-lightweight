<?php
/**
 * WordPress Super Lightweight Configuration
 * Optimized for maximum performance and minimal footprint
 * 
 * INSTRUCTIONS:
 * 1. Copy this file to wp-config.php
 * 2. Update database credentials below
 * 3. Generate new authentication keys from: https://api.wordpress.org/secret-key/1.1/salt/
 */

// ============================================================================
// DATABASE SETTINGS
// ============================================================================
define('DB_NAME', 'database_name_here');
define('DB_USER', 'username_here');
define('DB_PASSWORD', 'password_here');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// ============================================================================
// AUTHENTICATION KEYS AND SALTS
// Generate new keys: https://api.wordpress.org/secret-key/1.1/salt/
// ============================================================================
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// ============================================================================
// DATABASE TABLE PREFIX
// ============================================================================
$table_prefix = 'wp_';

// ============================================================================
// PERFORMANCE OPTIMIZATION
// ============================================================================

// Disable post revisions (or limit to 3)
define('WP_POST_REVISIONS', false);
// Alternative: define('WP_POST_REVISIONS', 3);

// Increase autosave interval (default: 60 seconds)
define('AUTOSAVE_INTERVAL', 300); // 5 minutes

// Empty trash immediately (no 30-day retention)
define('EMPTY_TRASH_DAYS', 0);

// Increase memory limit
define('WP_MEMORY_LIMIT', '128M');
define('WP_MAX_MEMORY_LIMIT', '256M');

// Disable WordPress cron (use real cron instead)
// Add to system cron (replace STAR with *): STAR/15 * * * * wget -q -O - http://yourdomain.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
define('DISABLE_WP_CRON', true);

// Optimize database queries
define('WP_USE_EXT_MYSQL', false);

// ============================================================================
// SECURITY OPTIMIZATION
// ============================================================================

// Disable file editing from admin
define('DISALLOW_FILE_EDIT', true);

// Disable file modifications (plugin/theme install/update from admin)
// define('DISALLOW_FILE_MODS', true); // Uncomment if needed

// Force SSL for admin (if using HTTPS)
// define('FORCE_SSL_ADMIN', true); // Uncomment if using HTTPS

// ============================================================================
// FEATURE DISABLING (LIGHTWEIGHT MODE)
// ============================================================================

// Disable XML-RPC (if not needed)
add_filter('xmlrpc_enabled', '__return_false');

// Disable pingbacks
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});

// ============================================================================
// DEBUG SETTINGS (PRODUCTION)
// ============================================================================

// Set to false in production
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

// For development, use these instead:
// define('WP_DEBUG', true);
// define('WP_DEBUG_LOG', true);
// define('WP_DEBUG_DISPLAY', false);
// define('SCRIPT_DEBUG', true);
// define('SAVEQUERIES', true);

// ============================================================================
// CACHE SETTINGS
// ============================================================================

// Enable object caching (requires Redis/Memcached)
// define('WP_CACHE', true);

// Cache key salt (change this to unique value)
// define('WP_CACHE_KEY_SALT', 'yourdomain.com_');

// ============================================================================
// MULTISITE (DISABLED)
// ============================================================================
// Multisite is disabled for lightweight setup
// If needed in future, uncomment and configure:
// define('WP_ALLOW_MULTISITE', false);

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
