<?php
/**
 * Fix WordPress Permalinks
 * Run this file once to fix permalink issues
 */

// Load WordPress
require_once('wp-load.php');

// Must be admin
if (!current_user_can('manage_options')) {
    die('Access denied. Please login as administrator.');
}

echo "<h1>Fixing WordPress Permalinks...</h1>";

// 1. Flush rewrite rules
flush_rewrite_rules(true);
echo "<p>✅ Rewrite rules flushed</p>";

// 2. Check permalink structure
$permalink_structure = get_option('permalink_structure');
echo "<p>Current permalink structure: <strong>" . ($permalink_structure ?: 'Plain (default)') . "</strong></p>";

// 3. Set to post name if not set
if (empty($permalink_structure) || $permalink_structure === '/?p=%post_id%') {
    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules(true);
    echo "<p>✅ Permalink structure updated to: <strong>/%postname%/</strong></p>";
}

// 4. Check .htaccess
$htaccess_file = ABSPATH . '.htaccess';
if (file_exists($htaccess_file)) {
    if (is_writable($htaccess_file)) {
        echo "<p>✅ .htaccess file is writable</p>";
    } else {
        echo "<p>⚠️ .htaccess file is NOT writable. Please set permissions to 644</p>";
    }
} else {
    echo "<p>⚠️ .htaccess file does not exist. Creating...</p>";
    
    // Create .htaccess
    $htaccess_content = "# BEGIN WordPress\n";
    $htaccess_content .= "<IfModule mod_rewrite.c>\n";
    $htaccess_content .= "RewriteEngine On\n";
    $htaccess_content .= "RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]\n";
    $htaccess_content .= "RewriteBase /active/wordpress%20super%20lightweight/\n";
    $htaccess_content .= "RewriteRule ^index\.php$ - [L]\n";
    $htaccess_content .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
    $htaccess_content .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
    $htaccess_content .= "RewriteRule . /active/wordpress%20super%20lightweight/index.php [L]\n";
    $htaccess_content .= "</IfModule>\n";
    $htaccess_content .= "# END WordPress\n";
    
    file_put_contents($htaccess_file, $htaccess_content);
    echo "<p>✅ .htaccess file created</p>";
}

// 5. Test a post URL
$test_post = get_posts(['numberposts' => 1, 'post_status' => 'publish']);
if (!empty($test_post)) {
    $test_url = get_permalink($test_post[0]->ID);
    echo "<p>Test post URL: <a href='" . esc_url($test_url) . "' target='_blank'>" . esc_html($test_url) . "</a></p>";
    echo "<p>Post title: <strong>" . esc_html($test_post[0]->post_title) . "</strong></p>";
}

// 6. Check Apache mod_rewrite
echo "<h2>Server Information:</h2>";
echo "<p>Server Software: <strong>" . $_SERVER['SERVER_SOFTWARE'] . "</strong></p>";
echo "<p>PHP Version: <strong>" . PHP_VERSION . "</strong></p>";

if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p>✅ mod_rewrite is enabled</p>";
    } else {
        echo "<p>❌ mod_rewrite is NOT enabled</p>";
    }
} else {
    echo "<p>⚠️ Cannot check mod_rewrite status (not running as Apache module)</p>";
}

echo "<hr>";
echo "<h2>✅ Permalink Fix Complete!</h2>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Go to <a href='" . admin_url('options-permalink.php') . "'>Settings → Permalinks</a></li>";
echo "<li>Click 'Save Changes' (even without changing anything)</li>";
echo "<li>Try accessing your posts again</li>";
echo "</ol>";

echo "<p><a href='" . home_url() . "' class='button button-primary'>← Back to Homepage</a></p>";
echo "<p><a href='" . admin_url() . "' class='button'>Go to Admin Dashboard</a></p>";

// Add some styling
echo "<style>
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; padding: 40px; max-width: 800px; margin: 0 auto; }
h1 { color: #2271b1; }
h2 { color: #135e96; margin-top: 30px; }
p { line-height: 1.6; }
.button { display: inline-block; padding: 10px 20px; background: #2271b1; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
.button:hover { background: #135e96; }
.button-primary { background: #00a32a; }
.button-primary:hover { background: #008a20; }
</style>";
