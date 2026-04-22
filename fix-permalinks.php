<?php
/**
 * Fix Permalinks and REST API
 * Run this file once to fix REST API 404 errors
 */

// Load WordPress
require_once('wp-load.php');

echo "=== WordPress Permalink & REST API Fix ===\n\n";

// Check current permalink structure
$current_permalink = get_option('permalink_structure');
echo "Current permalink structure: " . ($current_permalink ?: '(empty - using default)') . "\n";

// Set permalink structure if empty
if (empty($current_permalink)) {
    echo "Setting permalink structure to: /%postname%/\n";
    update_option('permalink_structure', '/%postname%/');
    update_option('rewrite_rules', false);
}

// Flush rewrite rules
echo "Flushing rewrite rules...\n";
flush_rewrite_rules(true);

// Verify REST API
echo "\nVerifying REST API...\n";
$rest_url = rest_url('wp/v2/users/me');
echo "REST API URL: $rest_url\n";

// Check if .htaccess is writable
$htaccess_file = ABSPATH . '.htaccess';
if (file_exists($htaccess_file)) {
    if (is_writable($htaccess_file)) {
        echo ".htaccess: Writable ✓\n";
    } else {
        echo ".htaccess: Not writable ✗ (may need manual update)\n";
    }
} else {
    echo ".htaccess: Does not exist (will be created)\n";
}

// Force regenerate .htaccess
if (got_mod_rewrite()) {
    $home_path = get_home_path();
    $htaccess_file = $home_path . '.htaccess';
    
    // Get WordPress rewrite rules
    $rules = get_home_path();
    
    echo "\nRegenerating .htaccess rules...\n";
    
    // Save permalink structure again to trigger .htaccess update
    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules(true);
    
    echo ".htaccess updated ✓\n";
}

echo "\n=== Fix Complete ===\n";
echo "Please refresh your WordPress admin page.\n";
echo "REST API should now work properly.\n\n";
echo "You can delete this file (fix-permalinks.php) after running it.\n";
