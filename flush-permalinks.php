<?php
/**
 * Flush Permalinks
 * Script untuk flush rewrite rules dan fix permalink
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('Access denied. Please login as administrator first.');
}

echo "<h1>🔄 Flush Permalinks</h1>";

// Get current permalink structure
$current_structure = get_option('permalink_structure');
echo "<p>Current permalink structure: <strong>" . ($current_structure ?: 'Plain') . "</strong></p>";

// Flush rewrite rules
flush_rewrite_rules(true);
echo "<p>✅ Rewrite rules flushed successfully!</p>";

// Force regenerate .htaccess
$htaccess_file = ABSPATH . '.htaccess';
if (file_exists($htaccess_file) && is_writable($htaccess_file)) {
    // Backup current .htaccess
    $backup_content = file_get_contents($htaccess_file);
    file_put_contents($htaccess_file . '.backup', $backup_content);
    echo "<p>✅ .htaccess backed up to .htaccess.backup</p>";
    
    // Regenerate .htaccess
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
    echo "<p>✅ .htaccess regenerated with correct rules</p>";
} else {
    echo "<p style='color: orange;'>⚠️ .htaccess not writable or doesn't exist</p>";
}

// Test a post URL
$test_post = get_posts(['numberposts' => 1, 'post_status' => 'publish']);
if (!empty($test_post)) {
    $test_url = get_permalink($test_post[0]->ID);
    echo "<h2>Test URL</h2>";
    echo "<p>Test artikel: <a href='" . esc_url($test_url) . "' target='_blank'>" . esc_html($test_url) . "</a></p>";
    echo "<p>Judul: <strong>" . esc_html($test_post[0]->post_title) . "</strong></p>";
}

echo "<hr>";
echo "<h2>✅ Flush Complete!</h2>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Test artikel dengan klik URL di atas</li>";
echo "<li>Jika masih 404, edit Apache config (AllowOverride All)</li>";
echo "<li>Atau gunakan Plain permalink sementara</li>";
echo "</ol>";

echo "<p>";
echo "<a href='" . admin_url('options-permalink.php') . "' class='button button-primary'>Settings → Permalinks</a> ";
echo "<a href='" . home_url() . "' class='button'>Homepage</a> ";
echo "<a href='test-permalink-fix.php' class='button'>Test Permalink</a>";
echo "</p>";

// Add CSS
echo "<style>
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
h1 { color: #2271b1; }
h2 { color: #135e96; }
p { line-height: 1.6; }
.button { display: inline-block; padding: 8px 16px; background: #2271b1; color: white; text-decoration: none; border-radius: 3px; margin-right: 10px; }
.button:hover { background: #135e96; color: white; }
.button-primary { background: #00a32a; }
.button-primary:hover { background: #008a20; }
</style>";