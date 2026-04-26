<?php
/**
 * Set Plain Permalink
 * Fallback solution jika pretty permalink tidak bisa fix
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('Access denied. Please login as administrator first.');
}

echo "<h1>🔧 Set Plain Permalink</h1>";

// Get current structure
$current_structure = get_option('permalink_structure');
echo "<p>Current permalink structure: <strong>" . ($current_structure ?: 'Plain') . "</strong></p>";

// Set to plain
update_option('permalink_structure', '');
flush_rewrite_rules(true);

echo "<p>✅ Permalink structure changed to <strong>Plain</strong></p>";
echo "<p>✅ Rewrite rules flushed</p>";

// Test URLs
$test_posts = get_posts(['numberposts' => 3, 'post_status' => 'publish']);
if (!empty($test_posts)) {
    echo "<h2>Test URLs (Plain Format)</h2>";
    echo "<p>Artikel sekarang menggunakan format: <code>/?p=123</code></p>";
    echo "<ul>";
    
    foreach ($test_posts as $post) {
        $post_url = get_permalink($post->ID);
        $post_title = get_the_title($post->ID);
        
        echo "<li>";
        echo "<strong>" . esc_html($post_title) . "</strong><br>";
        echo "<a href='" . esc_url($post_url) . "' target='_blank'>" . esc_html($post_url) . "</a>";
        echo "</li>";
    }
    
    echo "</ul>";
}

echo "<hr>";
echo "<h2>ℹ️ Tentang Plain Permalink</h2>";
echo "<div style='background: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 5px;'>";
echo "<h3>✅ Keuntungan:</h3>";
echo "<ul>";
echo "<li>Tidak ada masalah 404</li>";
echo "<li>Tidak perlu mod_rewrite</li>";
echo "<li>Tidak perlu .htaccess</li>";
echo "<li>Selalu berfungsi di semua server</li>";
echo "</ul>";

echo "<h3>❌ Kekurangan:</h3>";
echo "<ul>";
echo "<li>URL tidak SEO-friendly (/?p=123)</li>";
echo "<li>Tidak ada slug artikel di URL</li>";
echo "<li>Kurang user-friendly</li>";
echo "</ul>";
echo "</div>";

echo "<h2>🔄 Ingin Kembali ke Pretty Permalink?</h2>";
echo "<p>Jika sudah fix Apache config (AllowOverride All), Anda bisa:</p>";
echo "<ol>";
echo "<li>Go to <a href='" . admin_url('options-permalink.php') . "'>Settings → Permalinks</a></li>";
echo "<li>Pilih 'Post name' atau struktur lain</li>";
echo "<li>Save Changes</li>";
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
h3 { color: #0073aa; }
p { line-height: 1.6; }
.button { display: inline-block; padding: 8px 16px; background: #2271b1; color: white; text-decoration: none; border-radius: 3px; margin-right: 10px; }
.button:hover { background: #135e96; color: white; }
.button-primary { background: #00a32a; }
.button-primary:hover { background: #008a20; }
ul { margin-left: 20px; }
</style>";