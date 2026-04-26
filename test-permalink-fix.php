<?php
/**
 * Test Permalink Fix
 * Verifikasi apakah permalink sudah berfungsi
 */

// Load WordPress
require_once('wp-load.php');

echo "<h1>🔧 Test Permalink Fix</h1>";

// 1. Check permalink structure
$permalink_structure = get_option('permalink_structure');
echo "<h2>1. Permalink Structure</h2>";
echo "<p>Current: <strong>" . ($permalink_structure ?: 'Plain (/?p=123)') . "</strong></p>";

if (empty($permalink_structure) || $permalink_structure === '/?p=%post_id%') {
    echo "<p style='color: orange;'>⚠️ Menggunakan Plain permalink. Tidak ada masalah 404, tapi tidak SEO-friendly.</p>";
} else {
    echo "<p style='color: green;'>✅ Menggunakan Pretty permalink: <code>" . esc_html($permalink_structure) . "</code></p>";
}

// 2. Check .htaccess
echo "<h2>2. File .htaccess</h2>";
$htaccess_file = ABSPATH . '.htaccess';
if (file_exists($htaccess_file)) {
    $htaccess_size = filesize($htaccess_file);
    $htaccess_writable = is_writable($htaccess_file);
    
    echo "<p>✅ File .htaccess ditemukan</p>";
    echo "<p>Size: <strong>" . $htaccess_size . " bytes</strong></p>";
    echo "<p>Writable: <strong>" . ($htaccess_writable ? '✅ Yes' : '❌ No') . "</strong></p>";
    
    if ($htaccess_size > 50) {
        echo "<details><summary>Lihat isi .htaccess</summary>";
        echo "<pre style='background: #f0f0f0; padding: 10px; border-radius: 5px;'>";
        echo htmlspecialchars(file_get_contents($htaccess_file));
        echo "</pre></details>";
    }
} else {
    echo "<p style='color: red;'>❌ File .htaccess TIDAK ditemukan</p>";
    echo "<p>Membuat file .htaccess...</p>";
    
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
    
    if (file_put_contents($htaccess_file, $htaccess_content)) {
        echo "<p style='color: green;'>✅ File .htaccess berhasil dibuat</p>";
    } else {
        echo "<p style='color: red;'>❌ Gagal membuat file .htaccess</p>";
    }
}

// 3. Test posts
echo "<h2>3. Test Artikel</h2>";
$test_posts = get_posts([
    'numberposts' => 3,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
]);

if (!empty($test_posts)) {
    echo "<p>Ditemukan <strong>" . count($test_posts) . "</strong> artikel untuk test:</p>";
    echo "<ul>";
    
    foreach ($test_posts as $post) {
        $post_url = get_permalink($post->ID);
        $post_title = get_the_title($post->ID);
        
        echo "<li>";
        echo "<strong>" . esc_html($post_title) . "</strong><br>";
        echo "URL: <a href='" . esc_url($post_url) . "' target='_blank'>" . esc_html($post_url) . "</a>";
        echo "</li>";
    }
    
    echo "</ul>";
    
    echo "<p><strong>📝 Cara Test:</strong></p>";
    echo "<ol>";
    echo "<li>Klik salah satu URL di atas</li>";
    echo "<li>Jika artikel terbuka → ✅ Permalink sudah fix</li>";
    echo "<li>Jika muncul 404 → ❌ Masih ada masalah</li>";
    echo "</ol>";
} else {
    echo "<p style='color: orange;'>⚠️ Tidak ada artikel untuk test. Buat artikel dulu atau jalankan seeder.</p>";
}

// 4. Server info
echo "<h2>4. Server Information</h2>";
echo "<p>Server Software: <strong>" . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</strong></p>";
echo "<p>PHP Version: <strong>" . PHP_VERSION . "</strong></p>";

// Check mod_rewrite (if possible)
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p>mod_rewrite: <strong style='color: green;'>✅ Enabled</strong></p>";
    } else {
        echo "<p>mod_rewrite: <strong style='color: red;'>❌ Disabled</strong></p>";
    }
} else {
    echo "<p>mod_rewrite: <strong style='color: orange;'>⚠️ Cannot check (not Apache module)</strong></p>";
}

// 5. Quick actions
echo "<h2>5. Quick Actions</h2>";
echo "<p>";
echo "<a href='" . admin_url('options-permalink.php') . "' class='button button-primary'>Pengaturan Permalink</a> ";
echo "<a href='" . home_url() . "' class='button'>Lihat Homepage</a> ";
echo "<a href='" . admin_url() . "' class='button'>Admin Dashboard</a>";
echo "</p>";

// 6. Troubleshooting
echo "<h2>6. Troubleshooting</h2>";
echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px;'>";
echo "<h3>Jika Artikel Masih 404:</h3>";
echo "<ol>";
echo "<li><strong>Edit Apache Config:</strong>";
echo "<ul>";
echo "<li>Buka Laragon → Apache → httpd.conf</li>";
echo "<li>Cari: <code>&lt;Directory \"D:/Installed/laragon/www\"&gt;</code></li>";
echo "<li>Pastikan ada: <code>AllowOverride All</code></li>";
echo "<li>Restart Apache</li>";
echo "</ul></li>";
echo "<li><strong>Atau gunakan Plain Permalink:</strong>";
echo "<ul>";
echo "<li>Settings → Permalinks → Pilih 'Plain'</li>";
echo "<li>Save Changes</li>";
echo "</ul></li>";
echo "</ol>";
echo "</div>";

// Add CSS
echo "<style>
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
h1 { color: #2271b1; }
h2 { color: #135e96; margin-top: 30px; }
h3 { color: #0073aa; }
p { line-height: 1.6; }
.button { display: inline-block; padding: 8px 16px; background: #2271b1; color: white; text-decoration: none; border-radius: 3px; margin-right: 10px; }
.button:hover { background: #135e96; color: white; }
.button-primary { background: #00a32a; }
.button-primary:hover { background: #008a20; }
details { margin: 10px 0; }
summary { cursor: pointer; font-weight: bold; }
ul, ol { margin-left: 20px; }
</style>";