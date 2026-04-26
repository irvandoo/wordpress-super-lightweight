<?php
/**
 * Plugin Name: Auto Fix Permalinks
 * Description: Automatically fixes permalink issues on admin init
 * Version: 1.0.0
 * Author: Irvandoda
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fix permalinks on admin init
 */
function ida_auto_fix_permalinks() {
    // Only run once
    if (get_option('ida_permalinks_fixed')) {
        return;
    }
    
    // Set permalink structure
    $current_structure = get_option('permalink_structure');
    
    if (empty($current_structure) || $current_structure === '/?p=%post_id%') {
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules(true);
        
        // Mark as fixed
        update_option('ida_permalinks_fixed', true);
        
        // Show admin notice
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p><strong>✅ Permalinks Fixed!</strong> Struktur permalink telah diupdate ke /%postname%/</p>';
            echo '</div>';
        });
    }
}
add_action('admin_init', 'ida_auto_fix_permalinks');

/**
 * Add manual fix button in admin bar
 */
function ida_add_fix_permalink_button($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $wp_admin_bar->add_node([
        'id' => 'fix-permalinks',
        'title' => '🔧 Fix Permalinks',
        'href' => admin_url('options-permalink.php'),
        'meta' => [
            'title' => 'Fix Permalink Issues',
        ],
    ]);
}
add_action('admin_bar_menu', 'ida_add_fix_permalink_button', 999);

/**
 * Force flush rewrite rules on theme activation
 */
function ida_flush_on_theme_activation() {
    flush_rewrite_rules(true);
}
add_action('after_switch_theme', 'ida_flush_on_theme_activation');

/**
 * Add settings link to fix permalinks
 */
function ida_add_permalink_fix_notice() {
    // Check if we're on a post/page that returns 404
    if (is_admin()) {
        $test_post = get_posts(['numberposts' => 1, 'post_status' => 'publish']);
        
        if (!empty($test_post)) {
            $test_url = get_permalink($test_post[0]->ID);
            
            // Test if URL is accessible (simplified check)
            $permalink_structure = get_option('permalink_structure');
            
            if (empty($permalink_structure)) {
                add_action('admin_notices', function() {
                    echo '<div class="notice notice-warning is-dismissible">';
                    echo '<p><strong>⚠️ Permalink Warning!</strong> Struktur permalink Anda masih menggunakan Plain. ';
                    echo '<a href="' . admin_url('options-permalink.php') . '" class="button button-primary">Fix Sekarang</a></p>';
                    echo '</div>';
                });
            }
        }
    }
}
add_action('admin_init', 'ida_add_permalink_fix_notice');
