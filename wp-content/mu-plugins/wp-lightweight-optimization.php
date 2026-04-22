<?php
/**
 * Plugin Name: WordPress Lightweight Optimization
 * Description: Super lightweight WordPress optimization - Disables Gutenberg, embeds, emojis, and other unnecessary features
 * Version: 1.0.0
 * Author: Optimization Team
 * 
 * This is a Must-Use Plugin (mu-plugin) - automatically loaded by WordPress
 * No activation needed, just place in wp-content/mu-plugins/
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// ============================================================================
// 1. DISABLE GUTENBERG BLOCK EDITOR (Use Classic Editor)
// ============================================================================

/**
 * Disable Gutenberg editor completely
 */
function disable_gutenberg_editor() {
    // Disable for posts
    add_filter('use_block_editor_for_post', '__return_false', 10);
    
    // Disable for all post types
    add_filter('use_block_editor_for_post_type', '__return_false', 10);
}
add_action('init', 'disable_gutenberg_editor');

/**
 * Remove Gutenberg CSS and JS (FRONTEND ONLY)
 */
function remove_gutenberg_assets() {
    // Only remove on frontend, keep admin functional
    if (!is_admin()) {
        // Remove block library CSS
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style'); // WooCommerce blocks
        wp_dequeue_style('global-styles'); // Global styles
        
        // Remove classic theme styles
        wp_dequeue_style('classic-theme-styles');
        
        // Remove SVG filters
        remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    }
}
add_action('wp_enqueue_scripts', 'remove_gutenberg_assets', 100);

// ============================================================================
// 2. DISABLE EMBEDS
// ============================================================================

/**
 * Disable WordPress embeds completely
 */
function disable_embeds() {
    // Remove embed JavaScript
    wp_deregister_script('wp-embed');
    
    // Remove oEmbed discovery links from head
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove oEmbed-specific JavaScript from front-end and back-end
    remove_action('wp_head', 'wp_oembed_add_host_js');
    
    // Remove oEmbed REST API endpoint
    remove_action('rest_api_init', 'wp_oembed_register_route');
    
    // Turn off oEmbed auto discovery
    add_filter('embed_oembed_discover', '__return_false');
    
    // Remove filter for oEmbed results
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    
    // Remove oEmbed-specific rewrite rules
    add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
}
add_action('init', 'disable_embeds', 9999);

function disable_embeds_rewrites($rules) {
    foreach ($rules as $rule => $rewrite) {
        if (strpos($rewrite, 'embed=true') !== false) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}

// ============================================================================
// 3. DISABLE EMOJIS
// ============================================================================

/**
 * Disable WordPress emojis completely
 */
function disable_emojis() {
    // Remove emoji detection script from head
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    
    // Remove emoji detection script from admin
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    
    // Remove emoji styles from head
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove emoji styles from admin
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove emoji from RSS feeds
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    
    // Remove emoji from emails
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Disable emoji in TinyMCE editor
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    
    // Remove emoji DNS prefetch
    add_filter('wp_resource_hints', 'disable_emojis_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

function disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return array();
}

function disable_emojis_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
        $urls = array_diff($urls, array($emoji_svg_url));
    }
    return $urls;
}

// ============================================================================
// 4. DISABLE HEARTBEAT API
// ============================================================================

/**
 * Disable or limit WordPress Heartbeat API
 */
function modify_heartbeat() {
    // Disable on frontend
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'modify_heartbeat', 1);

/**
 * Modify heartbeat settings (if not disabled)
 */
function modify_heartbeat_settings($settings) {
    // Increase interval to 60 seconds (default is 15)
    $settings['interval'] = 60;
    return $settings;
}
add_filter('heartbeat_settings', 'modify_heartbeat_settings');

// ============================================================================
// 5. REMOVE JQUERY MIGRATE
// ============================================================================

/**
 * Remove jQuery Migrate script (not needed for modern themes)
 */
function remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate');

/**
 * Suppress jQuery Migrate warnings in console
 */
function suppress_jquery_migrate_warnings() {
    if (!is_admin()) {
        wp_add_inline_script('jquery-migrate', 'jQuery.migrateMute = true;', 'before');
    }
}
add_action('wp_enqueue_scripts', 'suppress_jquery_migrate_warnings');

// ============================================================================
// 6. DISABLE DASHICONS ON FRONTEND
// ============================================================================

/**
 * Disable Dashicons on frontend (if not logged in)
 */
function disable_dashicons_frontend() {
    if (!is_user_logged_in()) {
        wp_deregister_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'disable_dashicons_frontend');

// ============================================================================
// 7. REMOVE WP VERSION FROM HEAD
// ============================================================================

/**
 * Remove WordPress version from head (security)
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove version from RSS feeds
 */
add_filter('the_generator', '__return_empty_string');

// ============================================================================
// 8. REMOVE UNNECESSARY HEAD TAGS
// ============================================================================

/**
 * Clean up WordPress head
 */
function cleanup_wp_head() {
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove Windows Live Writer manifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove adjacent posts links
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    
    // Remove REST API link from frontend only
    if (!is_admin()) {
        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('template_redirect', 'rest_output_link_header', 11);
    }
}
add_action('init', 'cleanup_wp_head');

// ============================================================================
// 9. DISABLE RSS FEEDS (Optional - uncomment if not needed)
// ============================================================================

/**
 * Disable RSS feeds
 * Uncomment if you don't need RSS feeds
 */
/*
function disable_rss_feeds() {
    wp_die(__('No feed available, please visit our <a href="' . get_bloginfo('url') . '">homepage</a>!'));
}
add_action('do_feed', 'disable_rss_feeds', 1);
add_action('do_feed_rdf', 'disable_rss_feeds', 1);
add_action('do_feed_rss', 'disable_rss_feeds', 1);
add_action('do_feed_rss2', 'disable_rss_feeds', 1);
add_action('do_feed_atom', 'disable_rss_feeds', 1);
add_action('do_feed_rss2_comments', 'disable_rss_feeds', 1);
add_action('do_feed_atom_comments', 'disable_rss_feeds', 1);
*/

// ============================================================================
// 10. OPTIMIZE ADMIN
// ============================================================================

/**
 * Remove unnecessary admin widgets
 */
function remove_admin_widgets() {
    // Remove WordPress news widget
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    
    // Remove WordPress events widget
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    
    // Remove quick draft widget
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    
    // Remove activity widget
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'remove_admin_widgets');

/**
 * Remove admin footer text
 */
function remove_admin_footer() {
    return '';
}
add_filter('admin_footer_text', 'remove_admin_footer');

// ============================================================================
// 11. DISABLE COMMENTS (Optional - uncomment if not needed)
// ============================================================================

/**
 * Disable comments completely
 * Uncomment if you don't need comments
 */
/*
function disable_comments_completely() {
    // Close comments on frontend
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);
    
    // Hide existing comments
    add_filter('comments_array', '__return_empty_array', 10, 2);
    
    // Remove comments page from admin menu
    add_action('admin_menu', function() {
        remove_menu_page('edit-comments.php');
    });
    
    // Remove comments from admin bar
    add_action('admin_bar_menu', function($wp_admin_bar) {
        $wp_admin_bar->remove_node('comments');
    }, 999);
}
add_action('init', 'disable_comments_completely');
*/

// ============================================================================
// 12. LIMIT POST REVISIONS IN DATABASE
// ============================================================================

/**
 * Limit post revisions (already set in wp-config.php, but double-check)
 */
if (!defined('WP_POST_REVISIONS')) {
    define('WP_POST_REVISIONS', 3);
}

// ============================================================================
// 13. DEFER JAVASCRIPT LOADING
// ============================================================================

/**
 * Add defer attribute to scripts (FRONTEND ONLY)
 */
function defer_scripts($tag, $handle, $src) {
    // Only defer on frontend, not in admin
    if (is_admin()) {
        return $tag;
    }
    
    // Don't defer jQuery (some plugins depend on it)
    if ('jquery' === $handle || 'jquery-core' === $handle) {
        return $tag;
    }
    
    // Defer all other scripts on frontend
    if (strpos($tag, 'defer') === false) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'defer_scripts', 10, 3);

// ============================================================================
// 14. LAZY LOAD IMAGES (WordPress 5.5+)
// ============================================================================

/**
 * Enable lazy loading for images (already enabled by default in WP 5.5+)
 * This is just to ensure it's enabled
 */
add_filter('wp_lazy_loading_enabled', '__return_true');

// ============================================================================
// 15. FIX ADMIN CONSOLE ERRORS
// ============================================================================

/**
 * Fix REST API errors in admin by ensuring REST API is available for admin
 */
function ensure_rest_api_for_admin() {
    // REST API should work in admin
    if (is_admin()) {
        add_filter('rest_authentication_errors', function($result) {
            if (!empty($result)) {
                return $result;
            }
            if (!is_user_logged_in()) {
                return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', array('status' => 401));
            }
            return $result;
        });
    }
}
add_action('init', 'ensure_rest_api_for_admin');

/**
 * Disable SES lockdown warnings in console
 */
function disable_ses_lockdown() {
    if (is_admin()) {
        wp_add_inline_script('wp-polyfill', 'window.wp = window.wp || {}; window.wp.lockdown = false;', 'before');
    }
}
add_action('admin_enqueue_scripts', 'disable_ses_lockdown', 1);

/**
 * Fix preferences API errors
 */
function fix_preferences_errors() {
    if (is_admin()) {
        // Ensure user meta is available for preferences
        add_filter('rest_pre_dispatch', function($result, $server, $request) {
            if (strpos($request->get_route(), '/wp/v2/users/me') !== false) {
                if (!is_user_logged_in()) {
                    return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', array('status' => 401));
                }
            }
            return $result;
        }, 10, 3);
    }
}
add_action('rest_api_init', 'fix_preferences_errors');

// ============================================================================
// OPTIMIZATION COMPLETE
// ============================================================================

/**
 * Add admin notice to confirm optimization is active
 */
function lightweight_optimization_notice() {
    echo '<div class="notice notice-success is-dismissible">
        <p><strong>WordPress Lightweight Optimization:</strong> Active ✓ 
        (Gutenberg disabled, Embeds disabled, Emojis disabled, Performance optimized)</p>
    </div>';
}
add_action('admin_notices', 'lightweight_optimization_notice');
