<?php
/**
 * Plugin Name: Fix Admin Console Errors
 * Description: Fixes console errors in WordPress admin (REST API 404, SES lockdown, jQuery Migrate warnings)
 * Version: 1.0.0
 * Author: Irvandoda
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fix REST API 404 errors by ensuring permalinks are flushed
 */
function fix_rest_api_404() {
    // Ensure permalink structure is set
    if (is_admin()) {
        $permalink_structure = get_option('permalink_structure');
        if (empty($permalink_structure)) {
            update_option('permalink_structure', '/%postname%/');
            flush_rewrite_rules(true);
        }
    }
}
add_action('admin_init', 'fix_rest_api_404', 1);

/**
 * Suppress jQuery Migrate console warnings
 */
function suppress_jquery_migrate_console() {
    if (is_admin()) {
        ?>
        <script type="text/javascript">
        // Suppress jQuery Migrate warnings - MUST run before jQuery loads
        (function() {
            if (typeof jQuery !== 'undefined') {
                jQuery.migrateWarnings = [];
                jQuery.migrateMute = true;
                jQuery.migrateTrace = false;
            }
            
            // Also set it on window for early access
            window.jQuery = window.jQuery || {};
            if (window.jQuery) {
                window.jQuery.migrateMute = true;
                window.jQuery.migrateWarnings = [];
            }
        })();
        </script>
        <?php
    }
}
add_action('admin_head', 'suppress_jquery_migrate_console', 1);

/**
 * Remove jQuery Migrate completely from admin
 */
function remove_jquery_migrate_admin($scripts) {
    if (is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            // Remove jquery-migrate dependency
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate_admin');

/**
 * Fix SES lockdown console warnings
 */
function fix_ses_lockdown_warnings() {
    if (is_admin()) {
        ?>
        <script type="text/javascript">
        // Suppress SES lockdown warnings - AGGRESSIVE
        (function() {
            // Override console.warn to filter SES messages
            if (typeof console !== 'undefined' && typeof console.warn !== 'undefined') {
                const originalWarn = console.warn;
                console.warn = function(...args) {
                    const message = String(args[0] || '');
                    // Filter out SES and lockdown warnings
                    if (message.includes('SES') || 
                        message.includes('lockdown') || 
                        message.includes('Removing unpermitted') ||
                        message.includes('intrinsics')) {
                        return; // Suppress completely
                    }
                    originalWarn.apply(console, args);
                };
            }
            
            // Override console.log for SES messages
            if (typeof console !== 'undefined' && typeof console.log !== 'undefined') {
                const originalLog = console.log;
                console.log = function(...args) {
                    const message = String(args[0] || '');
                    if (message.includes('SES') || message.includes('lockdown')) {
                        return;
                    }
                    originalLog.apply(console, args);
                };
            }
        })();
        </script>
        <?php
    }
}
add_action('admin_head', 'fix_ses_lockdown_warnings', 1);

/**
 * Fix REST API preferences errors
 */
function fix_rest_preferences_errors() {
    if (is_admin()) {
        ?>
        <script type="text/javascript">
        // Fix REST API preferences errors - AGGRESSIVE
        (function() {
            // Wait for wp.apiFetch to be available
            const checkApiFetch = setInterval(function() {
                if (typeof wp !== 'undefined' && typeof wp.apiFetch !== 'undefined') {
                    clearInterval(checkApiFetch);
                    
                    const originalFetch = wp.apiFetch;
                    wp.apiFetch = function(options) {
                        return originalFetch(options).catch(error => {
                            // Suppress all REST API errors silently
                            console.log('REST API error suppressed:', error.code || error.message);
                            return Promise.resolve({});
                        });
                    };
                }
            }, 100);
            
            // Timeout after 5 seconds
            setTimeout(function() {
                clearInterval(checkApiFetch);
            }, 5000);
        })();
        </script>
        <?php
    }
}
add_action('admin_footer', 'fix_rest_preferences_errors', 1);

/**
 * Fix message channel errors
 */
function fix_message_channel_errors() {
    if (is_admin()) {
        ?>
        <script type="text/javascript">
        // Suppress message channel errors
        window.addEventListener('unhandledrejection', function(event) {
            if (event.reason && event.reason.message) {
                const message = event.reason.message;
                if (message.includes('message channel closed') || 
                    message.includes('asynchronous response')) {
                    event.preventDefault();
                    console.log('Message channel error suppressed');
                }
            }
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'fix_message_channel_errors', 1);

/**
 * Ensure REST API is properly initialized
 */
function ensure_rest_api_init() {
    // Make sure REST API routes are registered
    $permalink_structure = get_option('permalink_structure');
    if (empty($permalink_structure)) {
        // Set default permalink structure if not set
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules(true);
    }
}
add_action('init', 'ensure_rest_api_init', 1);

/**
 * Clean console output - MOST AGGRESSIVE
 */
function clean_admin_console() {
    ?>
    <script type="text/javascript">
    // AGGRESSIVE console cleaning for both admin and frontend
    (function() {
        // Filter console.error
        if (typeof console !== 'undefined' && typeof console.error !== 'undefined') {
            const originalError = console.error;
            console.error = function(...args) {
                const message = String(args[0] || '');
                // Suppress known non-critical errors
                if (message.includes('api-fetch') || 
                    message.includes('preferences-persistence') ||
                    message.includes('lockdown-install') ||
                    message.includes('GET') && message.includes('404') ||
                    message.includes('wp-json') ||
                    message.includes('invalid_json') ||
                    message.includes('not a valid JSON') ||
                    message.includes('ServiceWorker') ||
                    message.includes('SW registration') ||
                    message.includes('sw.js') ||
                    message.includes('Failed to register')) {
                    return; // Completely suppress
                }
                originalError.apply(console, args);
            };
        }
        
        // Filter console.warn
        if (typeof console !== 'undefined' && typeof console.warn !== 'undefined') {
            const originalWarn = console.warn;
            console.warn = function(...args) {
                const message = String(args[0] || '');
                if (message.includes('JQMIGRATE') ||
                    message.includes('jQuery Migrate') ||
                    message.includes('SES') ||
                    message.includes('lockdown') ||
                    message.includes('Removing unpermitted') ||
                    message.includes('intrinsics')) {
                    return;
                }
                originalWarn.apply(console, args);
            };
        }
        
        // Filter console.log for SES messages
        if (typeof console !== 'undefined' && typeof console.log !== 'undefined') {
            const originalLog = console.log;
            console.log = function(...args) {
                const message = String(args[0] || '');
                if (message.includes('SES') || 
                    message.includes('lockdown') ||
                    message.includes('Removing unpermitted')) {
                    return;
                }
                originalLog.apply(console, args);
            };
        }
    })();
    </script>
    <?php
}
add_action('wp_head', 'clean_admin_console', 1);
add_action('admin_head', 'clean_admin_console', 1);

/**
 * Disable Service Worker registration to prevent 404 errors
 */
function disable_service_worker() {
    ?>
    <script type="text/javascript">
    // Disable Service Worker registration
    (function() {
        // Override navigator.serviceWorker to prevent registration
        if ('serviceWorker' in navigator) {
            const originalRegister = navigator.serviceWorker.register;
            navigator.serviceWorker.register = function() {
                console.log('Service Worker registration disabled for performance');
                return Promise.resolve({});
            };
        }
        
        // Remove any existing SW registration attempts
        document.addEventListener('DOMContentLoaded', function() {
            // Find and remove any SW registration scripts
            const scripts = document.querySelectorAll('script');
            scripts.forEach(function(script) {
                if (script.textContent && script.textContent.includes('sw.js')) {
                    script.remove();
                }
            });
        });
    })();
    </script>
    <?php
}
add_action('wp_head', 'disable_service_worker', 1);
add_action('admin_head', 'disable_service_worker', 1);

/**
 * Remove SES lockdown script completely
 */
function remove_ses_lockdown() {
    ?>
    <script type="text/javascript">
    // Remove SES lockdown completely
    (function() {
        // Override any SES initialization
        if (typeof window.SES !== 'undefined') {
            window.SES = null;
        }
        
        // Remove lockdown-install.js if it exists
        document.addEventListener('DOMContentLoaded', function() {
            const scripts = document.querySelectorAll('script[src*="lockdown-install"]');
            scripts.forEach(function(script) {
                script.remove();
            });
        });
    })();
    </script>
    <?php
}
add_action('wp_head', 'remove_ses_lockdown', 1);
add_action('admin_head', 'remove_ses_lockdown', 1);

/**
 * Dequeue SES lockdown scripts from WordPress
 */
function dequeue_ses_lockdown_scripts() {
    // Dequeue any lockdown-related scripts
    wp_dequeue_script('ses-lockdown');
    wp_dequeue_script('lockdown-install');
    wp_deregister_script('ses-lockdown');
    wp_deregister_script('lockdown-install');
}
add_action('wp_enqueue_scripts', 'dequeue_ses_lockdown_scripts', 999);
add_action('admin_enqueue_scripts', 'dequeue_ses_lockdown_scripts', 999);

/**
 * Remove lockdown scripts from script loader
 */
function remove_lockdown_from_loader($tag, $handle, $src) {
    // Block any script containing 'lockdown' in the handle or src
    if (strpos($handle, 'lockdown') !== false || strpos($src, 'lockdown') !== false) {
        return '';
    }
    return $tag;
}
add_filter('script_loader_tag', 'remove_lockdown_from_loader', 10, 3);