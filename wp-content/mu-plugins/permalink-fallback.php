<?php
/**
 * Plugin Name: Permalink Fallback Handler
 * Description: Handles permalink issues when mod_rewrite or .htaccess is not working
 * Version: 1.0.0
 * Author: Irvandoda
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin notice about permalink issues
 */
function ida_permalink_issue_notice() {
    // Only show to admins
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Check if .htaccess is writable
    $htaccess_file = ABSPATH . '.htaccess';
    $htaccess_writable = is_writable($htaccess_file);
    
    // Check permalink structure
    $permalink_structure = get_option('permalink_structure');
    
    if (!empty($permalink_structure) && $permalink_structure !== '/?p=%post_id%') {
        // Pretty permalinks enabled, check if working
        ?>
        <div class="notice notice-info">
            <p>
                <strong>ℹ️ Permalink Information:</strong><br>
                Struktur permalink: <code><?php echo esc_html($permalink_structure); ?></code><br>
                .htaccess status: <?php echo $htaccess_writable ? '✅ Writable' : '❌ Not writable'; ?><br>
                <br>
                <strong>Jika artikel menampilkan 404 Not Found:</strong><br>
                1. Pastikan Apache mod_rewrite aktif<br>
                2. Pastikan AllowOverride diset ke "All" di Apache config<br>
                3. Atau gunakan permalink Plain sementara<br>
                <br>
                <a href="<?php echo admin_url('options-permalink.php'); ?>" class="button button-primary">
                    Pengaturan Permalink
                </a>
                <button type="button" class="button" onclick="document.getElementById('ida-permalink-help').style.display='block'">
                    Lihat Solusi Lengkap
                </button>
            </p>
            <div id="ida-permalink-help" style="display:none; margin-top:15px; padding:15px; background:#f0f0f1; border-left:4px solid #2271b1;">
                <h3>🔧 Cara Fix Permalink 404 Error:</h3>
                
                <h4>Solusi 1: Edit Apache Config (Recommended)</h4>
                <ol>
                    <li>Buka Laragon → Menu → Apache → httpd.conf</li>
                    <li>Cari baris: <code>&lt;Directory "D:/Installed/laragon/www"&gt;</code></li>
                    <li>Tambahkan/ubah: <code>AllowOverride All</code></li>
                    <li>Restart Apache dari Laragon</li>
                </ol>
                
                <h4>Solusi 2: Gunakan Plain Permalink (Temporary)</h4>
                <ol>
                    <li>Go to Settings → Permalinks</li>
                    <li>Pilih "Plain" (/?p=123)</li>
                    <li>Save Changes</li>
                </ol>
                
                <h4>Solusi 3: Manual .htaccess</h4>
                <ol>
                    <li>Pastikan file .htaccess ada di root WordPress</li>
                    <li>Isi dengan WordPress rewrite rules</li>
                    <li>Set permission 644</li>
                </ol>
                
                <p><strong>Setelah fix, klik "Save Changes" di Permalink settings untuk flush rewrite rules.</strong></p>
            </div>
        </div>
        <script>
        function ida_toggle_help() {
            var help = document.getElementById('ida-permalink-help');
            help.style.display = help.style.display === 'none' ? 'block' : 'none';
        }
        </script>
        <?php
    }
}
add_action('admin_notices', 'ida_permalink_issue_notice');

/**
 * Add quick fix button in admin bar
 */
function ida_add_permalink_fix_admin_bar($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $wp_admin_bar->add_node([
        'id' => 'ida-permalink-fix',
        'title' => '<span style="color:#f0ad4e;">⚠️ Fix Permalinks</span>',
        'href' => admin_url('options-permalink.php'),
        'meta' => [
            'title' => 'Fix Permalink 404 Issues',
            'class' => 'ida-permalink-fix-button',
        ],
    ]);
}
add_action('admin_bar_menu', 'ida_add_permalink_fix_admin_bar', 999);

/**
 * Auto-generate .htaccess if missing
 */
function ida_auto_generate_htaccess() {
    $htaccess_file = ABSPATH . '.htaccess';
    
    // Only generate if file doesn't exist or is empty
    if (!file_exists($htaccess_file) || filesize($htaccess_file) < 100) {
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
        
        @file_put_contents($htaccess_file, $htaccess_content);
    }
}
add_action('admin_init', 'ida_auto_generate_htaccess');
