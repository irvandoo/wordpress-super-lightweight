<?php
/**
 * Test Admin Access
 */

echo "<h1>WordPress Admin Test</h1>";

// Test 1: Check if WordPress loads
echo "<h2>Test 1: Load WordPress</h2>";
if (file_exists('wp-load.php')) {
    echo "✓ wp-load.php exists<br>";
    require_once('wp-load.php');
    echo "✓ WordPress loaded successfully<br>";
} else {
    echo "✗ wp-load.php not found<br>";
    exit;
}

// Test 2: Check constants
echo "<h2>Test 2: WordPress Constants</h2>";
echo "ABSPATH: " . ABSPATH . "<br>";
echo "WP_SITEURL: " . (defined('WP_SITEURL') ? WP_SITEURL : 'Not defined') . "<br>";
echo "WP_HOME: " . (defined('WP_HOME') ? WP_HOME : 'Not defined') . "<br>";
echo "WP_CONTENT_DIR: " . WP_CONTENT_DIR . "<br>";

// Test 3: Check database connection
echo "<h2>Test 3: Database Connection</h2>";
global $wpdb;
if ($wpdb) {
    echo "✓ Database connected<br>";
    echo "Database: " . DB_NAME . "<br>";
    echo "Prefix: " . $wpdb->prefix . "<br>";
    
    // Test query
    $result = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts}");
    echo "✓ Posts count: " . $result . "<br>";
} else {
    echo "✗ Database not connected<br>";
}

// Test 4: Check site URLs from database
echo "<h2>Test 4: Site URLs from Database</h2>";
$siteurl = get_option('siteurl');
$home = get_option('home');
echo "siteurl option: " . $siteurl . "<br>";
echo "home option: " . $home . "<br>";

// Test 5: Check if user is logged in
echo "<h2>Test 5: User Status</h2>";
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    echo "✓ User logged in: " . $current_user->user_login . "<br>";
    echo "User ID: " . $current_user->ID . "<br>";
    echo "User roles: " . implode(', ', $current_user->roles) . "<br>";
} else {
    echo "✗ User not logged in<br>";
}

// Test 6: Check admin URL
echo "<h2>Test 6: Admin URL</h2>";
$admin_url = admin_url();
echo "Admin URL: " . $admin_url . "<br>";
echo '<a href="' . $admin_url . '">Try accessing admin</a><br>';

// Test 7: Check .htaccess
echo "<h2>Test 7: .htaccess Check</h2>";
if (file_exists('.htaccess')) {
    echo "✓ .htaccess exists<br>";
    $htaccess = file_get_contents('.htaccess');
    echo "<pre>" . htmlspecialchars($htaccess) . "</pre>";
} else {
    echo "✗ .htaccess not found<br>";
}

// Test 8: Check permalink structure
echo "<h2>Test 8: Permalink Structure</h2>";
$permalink_structure = get_option('permalink_structure');
echo "Permalink structure: " . ($permalink_structure ?: '(default)') . "<br>";

// Test 9: Check rewrite rules
echo "<h2>Test 9: Rewrite Rules</h2>";
$rewrite_rules = get_option('rewrite_rules');
if ($rewrite_rules) {
    echo "✓ Rewrite rules exist (" . count($rewrite_rules) . " rules)<br>";
} else {
    echo "✗ No rewrite rules found<br>";
}

// Test 10: Try to load admin
echo "<h2>Test 10: Load Admin Files</h2>";
if (file_exists('wp-admin/admin.php')) {
    echo "✓ wp-admin/admin.php exists<br>";
} else {
    echo "✗ wp-admin/admin.php not found<br>";
}

if (file_exists('wp-admin/index.php')) {
    echo "✓ wp-admin/index.php exists<br>";
} else {
    echo "✗ wp-admin/index.php not found<br>";
}

echo "<hr>";
echo "<p><strong>If all tests pass, try accessing:</strong></p>";
echo '<p><a href="wp-admin/">wp-admin/</a></p>';
echo '<p><a href="wp-login.php">wp-login.php</a></p>';
