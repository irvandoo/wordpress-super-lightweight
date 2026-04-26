<?php
/**
 * Irvandoda Themes - Comprehensive Admin Panel
 * Menu admin lengkap untuk semua pengaturan theme
 * 
 * @package Irvandoda_SEO_Light
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add main menu "Irvandoda Themes" to admin
 */
function ida_add_main_admin_menu() {
    // Main menu
    add_menu_page(
        'Irvandoda Themes',           // Page title
        'Irvandoda Themes',           // Menu title
        'manage_options',             // Capability
        'irvandoda-themes',           // Menu slug
        'ida_render_dashboard_page',  // Callback function
        'dashicons-admin-appearance', // Icon
        30                           // Position
    );
    
    // Submenu pages
    add_submenu_page(
        'irvandoda-themes',
        'Dashboard',
        'Dashboard',
        'manage_options',
        'irvandoda-themes',
        'ida_render_dashboard_page'
    );
    
    add_submenu_page(
        'irvandoda-themes',
        'General Settings',
        'General',
        'manage_options',
        'ida-general-settings',
        'ida_render_general_page'
    );
    
    add_submenu_page(
        'irvandoda-themes',
        'SEO Settings',
        'SEO',
        'manage_options',
        'ida-seo-settings',
        'ida_render_seo_page'
    );
    
    add_submenu_page(
        'irvandoda-themes',
        'Performance',
        'Performance',
        'manage_options',
        'ida-performance',
        'ida_render_performance_page'
    );
    
    add_submenu_page(
        'irvandoda-themes',
        'Breaking News Ticker',
        'Ticker',
        'manage_options',
        'ida-ticker-settings',
        'ida_render_ticker_page'
    );
    
    add_submenu_page(
        'irvandoda-themes',
        'Hero Section',
        'Hero',
        'manage_options',
        'ida-hero-settings',
        'ida_render_hero_page'
    );
    
    add_submenu_page(
        'irvandoda-themes',
        'Social Media',
        'Social',
        'manage_options',
        'ida-social-settings',
        'ida_render_social_page'
    );
    
    add_submenu_page(
        'irvandoda-themes',
        'Advanced Settings',
        'Advanced',
        'manage_options',
        'ida-advanced-settings',
        'ida_render_advanced_page'
    );
}
add_action('admin_menu', 'ida_add_main_admin_menu');

/**
 * Register all theme settings
 */
function ida_register_all_settings() {
    // General Settings
    register_setting('ida_general_settings', 'ida_general_options', [
        'sanitize_callback' => 'ida_sanitize_general_options'
    ]);
    
    // SEO Settings
    register_setting('ida_seo_settings', 'ida_seo_options', [
        'sanitize_callback' => 'ida_sanitize_seo_options'
    ]);
    
    // Performance Settings
    register_setting('ida_performance_settings', 'ida_performance_options', [
        'sanitize_callback' => 'ida_sanitize_performance_options'
    ]);
    
    // Ticker Settings
    register_setting('ida_ticker_settings', 'ida_ticker_options', [
        'sanitize_callback' => 'ida_sanitize_ticker_options'
    ]);
    
    // Hero Settings
    register_setting('ida_hero_settings', 'ida_hero_options', [
        'sanitize_callback' => 'ida_sanitize_hero_options'
    ]);
    
    // Social Settings
    register_setting('ida_social_settings', 'ida_social_options', [
        'sanitize_callback' => 'ida_sanitize_social_options'
    ]);
    
    // Advanced Settings
    register_setting('ida_advanced_settings', 'ida_advanced_options', [
        'sanitize_callback' => 'ida_sanitize_advanced_options'
    ]);
}
add_action('admin_init', 'ida_register_all_settings');

/**
 * Dashboard Page
 */
function ida_render_dashboard_page() {
    ?>
    <div class="wrap ida-admin-wrap">
        <h1>🎨 Irvandoda Themes Dashboard</h1>
        
        <div class="ida-dashboard-grid">
            
            <!-- Theme Info Card -->
            <div class="ida-card">
                <h2>📊 Theme Information</h2>
                <table class="ida-info-table">
                    <tr>
                        <td><strong>Theme Name:</strong></td>
                        <td>Irvandoda Full SEO Lightweight</td>
                    </tr>
                    <tr>
                        <td><strong>Version:</strong></td>
                        <td><?php echo IDA_VERSION; ?></td>
                    </tr>
                    <tr>
                        <td><strong>PHP Version:</strong></td>
                        <td><?php echo PHP_VERSION; ?></td>
                    </tr>
                    <tr>
                        <td><strong>WordPress Version:</strong></td>
                        <td><?php echo get_bloginfo('version'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Active Posts:</strong></td>
                        <td><?php echo wp_count_posts()->publish; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Active Pages:</strong></td>
                        <td><?php echo wp_count_posts('page')->publish; ?></td>
                    </tr>
                </table>
            </div>
            
            <!-- Quick Actions -->
            <div class="ida-card">
                <h2>⚡ Quick Actions</h2>
                <div class="ida-quick-actions">
                    <a href="<?php echo admin_url('admin.php?page=ida-general-settings'); ?>" class="ida-btn ida-btn-primary">
                        ⚙️ General Settings
                    </a>
                    <a href="<?php echo admin_url('admin.php?page=ida-seo-settings'); ?>" class="ida-btn ida-btn-success">
                        🔍 SEO Settings
                    </a>
                    <a href="<?php echo admin_url('admin.php?page=ida-ticker-settings'); ?>" class="ida-btn ida-btn-info">
                        📰 Breaking News
                    </a>
                    <a href="<?php echo admin_url('admin.php?page=ida-performance'); ?>" class="ida-btn ida-btn-warning">
                        🚀 Performance
                    </a>
                </div>
            </div>
            
            <!-- System Status -->
            <div class="ida-card">
                <h2>🔧 System Status</h2>
                <div class="ida-status-list">
                    <?php
                    // Check permalink structure
                    $permalink_structure = get_option('permalink_structure');
                    $permalink_status = !empty($permalink_structure) && $permalink_structure !== '/?p=%post_id%';
                    ?>
                    <div class="ida-status-item">
                        <span class="ida-status-icon <?php echo $permalink_status ? 'success' : 'warning'; ?>">
                            <?php echo $permalink_status ? '✅' : '⚠️'; ?>
                        </span>
                        <span>Pretty Permalinks: <?php echo $permalink_status ? 'Enabled' : 'Disabled'; ?></span>
                    </div>
                    
                    <?php
                    // Check .htaccess
                    $htaccess_exists = file_exists(ABSPATH . '.htaccess');
                    ?>
                    <div class="ida-status-item">
                        <span class="ida-status-icon <?php echo $htaccess_exists ? 'success' : 'error'; ?>">
                            <?php echo $htaccess_exists ? '✅' : '❌'; ?>
                        </span>
                        <span>.htaccess File: <?php echo $htaccess_exists ? 'Found' : 'Missing'; ?></span>
                    </div>
                    
                    <?php
                    // Check PHP version
                    $php_ok = version_compare(PHP_VERSION, '8.0', '>=');
                    ?>
                    <div class="ida-status-item">
                        <span class="ida-status-icon <?php echo $php_ok ? 'success' : 'warning'; ?>">
                            <?php echo $php_ok ? '✅' : '⚠️'; ?>
                        </span>
                        <span>PHP Version: <?php echo PHP_VERSION; ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="ida-card">
                <h2>📝 Recent Posts</h2>
                <?php
                $recent_posts = get_posts([
                    'numberposts' => 5,
                    'post_status' => 'publish'
                ]);
                
                if (!empty($recent_posts)) {
                    echo '<ul class="ida-recent-list">';
                    foreach ($recent_posts as $post) {
                        echo '<li>';
                        echo '<a href="' . get_permalink($post->ID) . '" target="_blank">';
                        echo esc_html($post->post_title);
                        echo '</a>';
                        echo '<span class="ida-date">' . get_the_date('M j, Y', $post->ID) . '</span>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No posts found. <a href="' . admin_url('post-new.php') . '">Create your first post</a>!</p>';
                }
                ?>
            </div>
            
            <!-- Support & Documentation -->
            <div class="ida-card">
                <h2>📚 Support & Documentation</h2>
                <div class="ida-support-links">
                    <a href="https://github.com/irvandoo/wordpress-super-lightweight" target="_blank" class="ida-support-link">
                        📖 Documentation
                    </a>
                    <a href="https://github.com/irvandoo/wordpress-super-lightweight/issues" target="_blank" class="ida-support-link">
                        🐛 Report Bug
                    </a>
                    <a href="<?php echo home_url('/test-permalink-fix.php'); ?>" target="_blank" class="ida-support-link">
                        🔧 Fix Permalinks
                    </a>
                </div>
            </div>
            
        </div>
    </div>
    <?php
}

/**
 * General Settings Page
 */
function ida_render_general_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        check_admin_referer('ida_general_settings');
        
        $options = [
            'site_logo' => sanitize_text_field($_POST['site_logo'] ?? ''),
            'top_header_text' => sanitize_text_field($_POST['top_header_text'] ?? ''),
            'footer_tagline' => sanitize_text_field($_POST['footer_tagline'] ?? ''),
            'footer_copyright' => sanitize_textarea_field($_POST['footer_copyright'] ?? ''),
            'contact_email' => sanitize_email($_POST['contact_email'] ?? ''),
            'contact_phone' => sanitize_text_field($_POST['contact_phone'] ?? ''),
            'google_analytics' => sanitize_text_field($_POST['google_analytics'] ?? ''),
            'facebook_pixel' => sanitize_text_field($_POST['facebook_pixel'] ?? ''),
        ];
        
        update_option('ida_general_options', $options);
        echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
    }
    
    $options = get_option('ida_general_options', []);
    ?>
    <div class="wrap ida-admin-wrap">
        <h1>⚙️ General Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('ida_general_settings'); ?>
            
            <div class="ida-form-grid">
                
                <!-- Site Identity -->
                <div class="ida-card">
                    <h2>🏢 Site Identity</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Site Logo URL</th>
                            <td>
                                <input type="url" name="site_logo" value="<?php echo esc_attr($options['site_logo'] ?? ''); ?>" class="regular-text" />
                                <p class="description">URL logo untuk header (opsional)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Top Header Text</th>
                            <td>
                                <input type="text" name="top_header_text" value="<?php echo esc_attr($options['top_header_text'] ?? 'Update Algoritma Terkini: ' . date('F Y')); ?>" class="regular-text" />
                                <p class="description">Text yang muncul di top header</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Footer Tagline</th>
                            <td>
                                <input type="text" name="footer_tagline" value="<?php echo esc_attr($options['footer_tagline'] ?? 'Zero Distraction, Full Conversion.'); ?>" class="regular-text" />
                                <p class="description">Tagline di footer</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Footer Copyright</th>
                            <td>
                                <textarea name="footer_copyright" rows="3" class="large-text"><?php echo esc_textarea($options['footer_copyright'] ?? '© ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.'); ?></textarea>
                                <p class="description">Text copyright di footer</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Contact Information -->
                <div class="ida-card">
                    <h2>📞 Contact Information</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Contact Email</th>
                            <td>
                                <input type="email" name="contact_email" value="<?php echo esc_attr($options['contact_email'] ?? ''); ?>" class="regular-text" />
                                <p class="description">Email kontak utama</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Contact Phone</th>
                            <td>
                                <input type="text" name="contact_phone" value="<?php echo esc_attr($options['contact_phone'] ?? ''); ?>" class="regular-text" />
                                <p class="description">Nomor telepon kontak</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Analytics & Tracking -->
                <div class="ida-card">
                    <h2>📊 Analytics & Tracking</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Google Analytics ID</th>
                            <td>
                                <input type="text" name="google_analytics" value="<?php echo esc_attr($options['google_analytics'] ?? ''); ?>" class="regular-text" placeholder="G-XXXXXXXXXX" />
                                <p class="description">Google Analytics 4 Measurement ID</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Facebook Pixel ID</th>
                            <td>
                                <input type="text" name="facebook_pixel" value="<?php echo esc_attr($options['facebook_pixel'] ?? ''); ?>" class="regular-text" placeholder="123456789012345" />
                                <p class="description">Facebook Pixel ID untuk tracking</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
            </div>
            
            <?php submit_button('Save General Settings', 'primary', 'submit', false); ?>
        </form>
    </div>
    <?php
}

/**
 * Load admin styles
 */
function ida_admin_styles($hook) {
    // Only load on our admin pages
    if (strpos($hook, 'irvandoda-themes') === false && strpos($hook, 'ida-') === false) {
        return;
    }
    
    ?>
    <style>
    .ida-admin-wrap {
        margin: 20px 0;
    }
    
    .ida-dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .ida-form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .ida-card {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .ida-card h2 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 18px;
        color: #1d2327;
        border-bottom: 2px solid #2271b1;
        padding-bottom: 8px;
    }
    
    .ida-info-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .ida-info-table td {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f1;
    }
    
    .ida-info-table td:first-child {
        width: 40%;
        color: #646970;
    }
    
    .ida-quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
    }
    
    .ida-btn {
        display: inline-block;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
        text-align: center;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .ida-btn-primary { background: #2271b1; color: white; }
    .ida-btn-primary:hover { background: #135e96; color: white; }
    
    .ida-btn-success { background: #00a32a; color: white; }
    .ida-btn-success:hover { background: #008a20; color: white; }
    
    .ida-btn-info { background: #72aee6; color: white; }
    .ida-btn-info:hover { background: #3582c4; color: white; }
    
    .ida-btn-warning { background: #dba617; color: white; }
    .ida-btn-warning:hover { background: #c18f00; color: white; }
    
    .ida-status-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .ida-status-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        background: #f6f7f7;
        border-radius: 4px;
    }
    
    .ida-status-icon.success { color: #00a32a; }
    .ida-status-icon.warning { color: #dba617; }
    .ida-status-icon.error { color: #d63638; }
    
    .ida-recent-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .ida-recent-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f1;
    }
    
    .ida-recent-list li:last-child {
        border-bottom: none;
    }
    
    .ida-date {
        font-size: 12px;
        color: #646970;
    }
    
    .ida-support-links {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .ida-support-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px;
        background: #f6f7f7;
        border-radius: 4px;
        text-decoration: none;
        color: #1d2327;
        transition: background 0.2s;
    }
    
    .ida-support-link:hover {
        background: #dcdcde;
        color: #1d2327;
    }
    
    @media (max-width: 768px) {
        .ida-dashboard-grid {
            grid-template-columns: 1fr;
        }
        
        .ida-quick-actions {
            grid-template-columns: 1fr;
        }
    }
    </style>
    <?php
}
add_action('admin_head', 'ida_admin_styles');

/**
 * Sanitization functions
 */
function ida_sanitize_general_options($input) {
    $sanitized = [];
    
    if (isset($input['site_logo'])) {
        $sanitized['site_logo'] = esc_url_raw($input['site_logo']);
    }
    
    if (isset($input['top_header_text'])) {
        $sanitized['top_header_text'] = sanitize_text_field($input['top_header_text']);
    }
    
    if (isset($input['footer_tagline'])) {
        $sanitized['footer_tagline'] = sanitize_text_field($input['footer_tagline']);
    }
    
    if (isset($input['footer_copyright'])) {
        $sanitized['footer_copyright'] = sanitize_textarea_field($input['footer_copyright']);
    }
    
    if (isset($input['contact_email'])) {
        $sanitized['contact_email'] = sanitize_email($input['contact_email']);
    }
    
    if (isset($input['contact_phone'])) {
        $sanitized['contact_phone'] = sanitize_text_field($input['contact_phone']);
    }
    
    if (isset($input['google_analytics'])) {
        $sanitized['google_analytics'] = sanitize_text_field($input['google_analytics']);
    }
    
    if (isset($input['facebook_pixel'])) {
        $sanitized['facebook_pixel'] = sanitize_text_field($input['facebook_pixel']);
    }
    
    return $sanitized;
}

// Placeholder functions for other sanitization callbacks
function ida_sanitize_seo_options($input) { return $input; }
function ida_sanitize_performance_options($input) { return $input; }
function ida_sanitize_ticker_options($input) { return $input; }
function ida_sanitize_hero_options($input) { return $input; }
function ida_sanitize_social_options($input) { return $input; }
function ida_sanitize_advanced_options($input) { return $input; }

// Placeholder functions for other page renders (will be implemented next)
function ida_render_seo_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        check_admin_referer('ida_seo_settings');
        
        $options = [
            'meta_description' => sanitize_textarea_field($_POST['meta_description'] ?? ''),
            'meta_keywords' => sanitize_text_field($_POST['meta_keywords'] ?? ''),
            'og_image' => esc_url_raw($_POST['og_image'] ?? ''),
            'twitter_username' => sanitize_text_field($_POST['twitter_username'] ?? ''),
            'schema_organization' => sanitize_text_field($_POST['schema_organization'] ?? ''),
            'schema_logo' => esc_url_raw($_POST['schema_logo'] ?? ''),
            'breadcrumb_enable' => isset($_POST['breadcrumb_enable']) ? 1 : 0,
            'sitemap_enable' => isset($_POST['sitemap_enable']) ? 1 : 0,
            'robots_txt' => sanitize_textarea_field($_POST['robots_txt'] ?? ''),
            'canonical_enable' => isset($_POST['canonical_enable']) ? 1 : 0,
        ];
        
        update_option('ida_seo_options', $options);
        echo '<div class="notice notice-success"><p>SEO Settings saved successfully!</p></div>';
    }
    
    $options = get_option('ida_seo_options', []);
    ?>
    <div class="wrap ida-admin-wrap">
        <h1>🔍 SEO Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('ida_seo_settings'); ?>
            
            <div class="ida-form-grid">
                
                <!-- Basic SEO -->
                <div class="ida-card">
                    <h2>📝 Basic SEO</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Default Meta Description</th>
                            <td>
                                <textarea name="meta_description" rows="3" class="large-text" maxlength="160"><?php echo esc_textarea($options['meta_description'] ?? get_bloginfo('description')); ?></textarea>
                                <p class="description">Meta description default untuk homepage (max 160 karakter)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Meta Keywords</th>
                            <td>
                                <input type="text" name="meta_keywords" value="<?php echo esc_attr($options['meta_keywords'] ?? ''); ?>" class="large-text" />
                                <p class="description">Keywords default, pisahkan dengan koma</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Open Graph & Social -->
                <div class="ida-card">
                    <h2>📱 Open Graph & Social Media</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Default OG Image</th>
                            <td>
                                <input type="url" name="og_image" value="<?php echo esc_attr($options['og_image'] ?? ''); ?>" class="large-text" />
                                <p class="description">URL gambar default untuk social sharing (1200x630px)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Twitter Username</th>
                            <td>
                                <input type="text" name="twitter_username" value="<?php echo esc_attr($options['twitter_username'] ?? ''); ?>" class="regular-text" placeholder="@username" />
                                <p class="description">Username Twitter untuk Twitter Cards</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Schema Markup -->
                <div class="ida-card">
                    <h2>🏢 Schema Markup</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Organization Name</th>
                            <td>
                                <input type="text" name="schema_organization" value="<?php echo esc_attr($options['schema_organization'] ?? get_bloginfo('name')); ?>" class="regular-text" />
                                <p class="description">Nama organisasi untuk schema markup</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Organization Logo</th>
                            <td>
                                <input type="url" name="schema_logo" value="<?php echo esc_attr($options['schema_logo'] ?? ''); ?>" class="large-text" />
                                <p class="description">URL logo organisasi untuk schema markup</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Technical SEO -->
                <div class="ida-card">
                    <h2>⚙️ Technical SEO</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Breadcrumb Navigation</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="breadcrumb_enable" value="1" <?php checked($options['breadcrumb_enable'] ?? 1); ?> />
                                    Enable breadcrumb navigation
                                </label>
                                <p class="description">Tampilkan breadcrumb di single post dan pages</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">XML Sitemap</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="sitemap_enable" value="1" <?php checked($options['sitemap_enable'] ?? 1); ?> />
                                    Enable XML sitemap generation
                                </label>
                                <p class="description">Generate XML sitemap otomatis</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Canonical URLs</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="canonical_enable" value="1" <?php checked($options['canonical_enable'] ?? 1); ?> />
                                    Enable canonical URLs
                                </label>
                                <p class="description">Tambahkan canonical URL di setiap halaman</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Robots.txt -->
                <div class="ida-card">
                    <h2>🤖 Robots.txt</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Custom Robots.txt</th>
                            <td>
                                <textarea name="robots_txt" rows="8" class="large-text" placeholder="User-agent: *&#10;Disallow: /wp-admin/&#10;Allow: /wp-admin/admin-ajax.php&#10;&#10;Sitemap: <?php echo home_url('/sitemap.xml'); ?>"><?php echo esc_textarea($options['robots_txt'] ?? ''); ?></textarea>
                                <p class="description">Custom robots.txt content (kosongkan untuk default WordPress)</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
            </div>
            
            <?php submit_button('Save SEO Settings', 'primary', 'submit', false); ?>
        </form>
    </div>
    <?php
}
function ida_render_performance_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        check_admin_referer('ida_performance_settings');
        
        $options = [
            'minify_css' => isset($_POST['minify_css']) ? 1 : 0,
            'minify_js' => isset($_POST['minify_js']) ? 1 : 0,
            'defer_js' => isset($_POST['defer_js']) ? 1 : 0,
            'lazy_load' => isset($_POST['lazy_load']) ? 1 : 0,
            'remove_emojis' => isset($_POST['remove_emojis']) ? 1 : 0,
            'remove_jquery_migrate' => isset($_POST['remove_jquery_migrate']) ? 1 : 0,
            'disable_embeds' => isset($_POST['disable_embeds']) ? 1 : 0,
            'disable_xmlrpc' => isset($_POST['disable_xmlrpc']) ? 1 : 0,
            'preload_fonts' => sanitize_textarea_field($_POST['preload_fonts'] ?? ''),
            'critical_css' => sanitize_textarea_field($_POST['critical_css'] ?? ''),
            'cache_expire' => absint($_POST['cache_expire'] ?? 86400),
            'gzip_compression' => isset($_POST['gzip_compression']) ? 1 : 0,
        ];
        
        update_option('ida_performance_options', $options);
        echo '<div class="notice notice-success"><p>Performance Settings saved successfully!</p></div>';
    }
    
    $options = get_option('ida_performance_options', []);
    ?>
    <div class="wrap ida-admin-wrap">
        <h1>🚀 Performance Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('ida_performance_settings'); ?>
            
            <div class="ida-form-grid">
                
                <!-- Asset Optimization -->
                <div class="ida-card">
                    <h2>📦 Asset Optimization</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Minify CSS</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="minify_css" value="1" <?php checked($options['minify_css'] ?? 1); ?> />
                                    Minify CSS files
                                </label>
                                <p class="description">Kompres file CSS untuk mengurangi ukuran</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Minify JavaScript</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="minify_js" value="1" <?php checked($options['minify_js'] ?? 1); ?> />
                                    Minify JavaScript files
                                </label>
                                <p class="description">Kompres file JavaScript untuk mengurangi ukuran</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Defer JavaScript</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="defer_js" value="1" <?php checked($options['defer_js'] ?? 1); ?> />
                                    Defer non-critical JavaScript
                                </label>
                                <p class="description">Tunda loading JavaScript yang tidak penting</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Lazy Load Images</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="lazy_load" value="1" <?php checked($options['lazy_load'] ?? 1); ?> />
                                    Enable lazy loading for images
                                </label>
                                <p class="description">Load gambar hanya saat diperlukan</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- WordPress Cleanup -->
                <div class="ida-card">
                    <h2>🧹 WordPress Cleanup</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Remove Emojis</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="remove_emojis" value="1" <?php checked($options['remove_emojis'] ?? 1); ?> />
                                    Disable WordPress emoji scripts
                                </label>
                                <p class="description">Hapus script emoji yang tidak perlu</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Remove jQuery Migrate</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="remove_jquery_migrate" value="1" <?php checked($options['remove_jquery_migrate'] ?? 1); ?> />
                                    Remove jQuery Migrate
                                </label>
                                <p class="description">Hapus jQuery Migrate untuk mengurangi ukuran</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Disable Embeds</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="disable_embeds" value="1" <?php checked($options['disable_embeds'] ?? 0); ?> />
                                    Disable WordPress embeds
                                </label>
                                <p class="description">Nonaktifkan fitur embed WordPress</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Disable XML-RPC</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="disable_xmlrpc" value="1" <?php checked($options['disable_xmlrpc'] ?? 1); ?> />
                                    Disable XML-RPC
                                </label>
                                <p class="description">Nonaktifkan XML-RPC untuk keamanan dan performa</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Advanced Optimization -->
                <div class="ida-card">
                    <h2>⚡ Advanced Optimization</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Preload Fonts</th>
                            <td>
                                <textarea name="preload_fonts" rows="4" class="large-text" placeholder="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"><?php echo esc_textarea($options['preload_fonts'] ?? ''); ?></textarea>
                                <p class="description">URL font yang akan di-preload (satu per baris)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Critical CSS</th>
                            <td>
                                <textarea name="critical_css" rows="6" class="large-text" placeholder="/* Critical CSS above-the-fold */"><?php echo esc_textarea($options['critical_css'] ?? ''); ?></textarea>
                                <p class="description">CSS critical yang akan di-inline di head</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Cache Expire Time</th>
                            <td>
                                <select name="cache_expire">
                                    <option value="3600" <?php selected($options['cache_expire'] ?? 86400, 3600); ?>>1 Hour</option>
                                    <option value="86400" <?php selected($options['cache_expire'] ?? 86400, 86400); ?>>1 Day</option>
                                    <option value="604800" <?php selected($options['cache_expire'] ?? 86400, 604800); ?>>1 Week</option>
                                    <option value="2592000" <?php selected($options['cache_expire'] ?? 86400, 2592000); ?>>1 Month</option>
                                </select>
                                <p class="description">Waktu cache browser untuk static assets</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Gzip Compression</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="gzip_compression" value="1" <?php checked($options['gzip_compression'] ?? 1); ?> />
                                    Enable Gzip compression
                                </label>
                                <p class="description">Kompres file dengan Gzip (memerlukan server support)</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Performance Test -->
                <div class="ida-card">
                    <h2>📊 Performance Test</h2>
                    
                    <div class="ida-performance-tools">
                        <a href="https://pagespeed.web.dev/analysis?url=<?php echo urlencode(home_url()); ?>" target="_blank" class="ida-btn ida-btn-primary">
                            🔍 Google PageSpeed Insights
                        </a>
                        <a href="https://gtmetrix.com/?url=<?php echo urlencode(home_url()); ?>" target="_blank" class="ida-btn ida-btn-info">
                            📈 GTmetrix
                        </a>
                        <a href="https://tools.pingdom.com/#<?php echo urlencode(home_url()); ?>" target="_blank" class="ida-btn ida-btn-success">
                            ⚡ Pingdom
                        </a>
                    </div>
                    
                    <div class="ida-performance-tips">
                        <h4>💡 Performance Tips:</h4>
                        <ul>
                            <li>✅ Gunakan CDN untuk static assets</li>
                            <li>✅ Optimasi gambar (WebP format)</li>
                            <li>✅ Enable caching plugin</li>
                            <li>✅ Gunakan hosting yang cepat</li>
                            <li>✅ Minimalisir plugin yang tidak perlu</li>
                        </ul>
                    </div>
                </div>
                
            </div>
            
            <?php submit_button('Save Performance Settings', 'primary', 'submit', false); ?>
        </form>
    </div>
    
    <style>
    .ida-performance-tools {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .ida-performance-tips {
        background: #f0f6ff;
        border: 1px solid #bfdbfe;
        border-radius: 6px;
        padding: 15px;
    }
    
    .ida-performance-tips h4 {
        margin-top: 0;
        color: #1e40af;
    }
    
    .ida-performance-tips ul {
        margin-bottom: 0;
    }
    
    .ida-performance-tips li {
        margin-bottom: 5px;
    }
    </style>
    <?php
}
function ida_render_ticker_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        check_admin_referer('ida_ticker_settings');
        
        $options = [
            'enable' => isset($_POST['enable']) ? 1 : 0,
            'label' => sanitize_text_field($_POST['label'] ?? 'Terbaru'),
            'count' => max(1, min(20, absint($_POST['count'] ?? 5))),
            'speed' => max(10, min(200, absint($_POST['speed'] ?? 50))),
            'post_types' => array_map('sanitize_text_field', $_POST['post_types'] ?? ['post']),
            'categories' => array_map('absint', $_POST['categories'] ?? []),
            'show_icon' => isset($_POST['show_icon']) ? 1 : 0,
            'icon_text' => sanitize_text_field($_POST['icon_text'] ?? '🔥'),
            'pause_on_hover' => isset($_POST['pause_on_hover']) ? 1 : 0,
            'background_color' => sanitize_hex_color($_POST['background_color'] ?? '#f8fafc'),
            'text_color' => sanitize_hex_color($_POST['text_color'] ?? '#374151'),
        ];
        
        update_option('ida_ticker_options', $options);
        echo '<div class="notice notice-success"><p>Ticker Settings saved successfully!</p></div>';
    }
    
    $options = get_option('ida_ticker_options', []);
    ?>
    <div class="wrap ida-admin-wrap">
        <h1>📰 Breaking News Ticker Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('ida_ticker_settings'); ?>
            
            <div class="ida-form-grid">
                
                <!-- Basic Settings -->
                <div class="ida-card">
                    <h2>⚙️ Basic Settings</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Enable Ticker</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="enable" value="1" <?php checked($options['enable'] ?? 1); ?> />
                                    Show breaking news ticker
                                </label>
                                <p class="description">Tampilkan ticker di bawah navigation menu</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Ticker Label</th>
                            <td>
                                <input type="text" name="label" value="<?php echo esc_attr($options['label'] ?? 'Terbaru'); ?>" class="regular-text" />
                                <p class="description">Text label di sebelah kiri ticker</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Number of Posts</th>
                            <td>
                                <input type="number" name="count" value="<?php echo esc_attr($options['count'] ?? 5); ?>" min="1" max="20" class="small-text" />
                                <p class="description">Jumlah artikel yang ditampilkan (1-20)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Scroll Speed</th>
                            <td>
                                <input type="range" name="speed" value="<?php echo esc_attr($options['speed'] ?? 50); ?>" min="10" max="200" class="ida-range" oninput="this.nextElementSibling.value = this.value" />
                                <output><?php echo esc_attr($options['speed'] ?? 50); ?></output> px/s
                                <p class="description">Kecepatan scroll ticker (10 = lambat, 200 = cepat)</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Content Settings -->
                <div class="ida-card">
                    <h2>📝 Content Settings</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Post Types</th>
                            <td>
                                <?php
                                $post_types = get_post_types(['public' => true], 'objects');
                                $selected_types = $options['post_types'] ?? ['post'];
                                
                                foreach ($post_types as $post_type) {
                                    $checked = in_array($post_type->name, $selected_types) ? 'checked' : '';
                                    echo '<label style="display: block; margin-bottom: 5px;">';
                                    echo '<input type="checkbox" name="post_types[]" value="' . esc_attr($post_type->name) . '" ' . $checked . ' /> ';
                                    echo esc_html($post_type->label);
                                    echo '</label>';
                                }
                                ?>
                                <p class="description">Pilih jenis konten yang ditampilkan di ticker</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Categories</th>
                            <td>
                                <?php
                                $categories = get_categories(['hide_empty' => false]);
                                $selected_cats = $options['categories'] ?? [];
                                
                                if (!empty($categories)) {
                                    echo '<div style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">';
                                    foreach ($categories as $category) {
                                        $checked = in_array($category->term_id, $selected_cats) ? 'checked' : '';
                                        echo '<label style="display: block; margin-bottom: 5px;">';
                                        echo '<input type="checkbox" name="categories[]" value="' . esc_attr($category->term_id) . '" ' . $checked . ' /> ';
                                        echo esc_html($category->name) . ' (' . $category->count . ')';
                                        echo '</label>';
                                    }
                                    echo '</div>';
                                } else {
                                    echo '<p>No categories found.</p>';
                                }
                                ?>
                                <p class="description">Kosongkan untuk semua kategori, atau pilih kategori tertentu</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Visual Settings -->
                <div class="ida-card">
                    <h2>🎨 Visual Settings</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Show Icon</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="show_icon" value="1" <?php checked($options['show_icon'] ?? 1); ?> />
                                    Show icon before each post title
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Icon Text</th>
                            <td>
                                <input type="text" name="icon_text" value="<?php echo esc_attr($options['icon_text'] ?? '🔥'); ?>" class="small-text" maxlength="5" />
                                <p class="description">Icon atau emoji yang ditampilkan (max 5 karakter)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Pause on Hover</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="pause_on_hover" value="1" <?php checked($options['pause_on_hover'] ?? 1); ?> />
                                    Pause ticker when mouse hover
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Background Color</th>
                            <td>
                                <input type="color" name="background_color" value="<?php echo esc_attr($options['background_color'] ?? '#f8fafc'); ?>" />
                                <p class="description">Warna background ticker</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Text Color</th>
                            <td>
                                <input type="color" name="text_color" value="<?php echo esc_attr($options['text_color'] ?? '#374151'); ?>" />
                                <p class="description">Warna text ticker</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Preview -->
                <div class="ida-card">
                    <h2>👁️ Preview</h2>
                    <div class="ida-ticker-preview" style="background: <?php echo esc_attr($options['background_color'] ?? '#f8fafc'); ?>; color: <?php echo esc_attr($options['text_color'] ?? '#374151'); ?>; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                        <strong><?php echo esc_html($options['label'] ?? 'Terbaru'); ?>:</strong>
                        <span style="margin-left: 10px;">
                            <?php if ($options['show_icon'] ?? 1) echo esc_html($options['icon_text'] ?? '🔥') . ' '; ?>
                            Sample Article Title 1
                            <span style="margin: 0 20px;">•</span>
                            <?php if ($options['show_icon'] ?? 1) echo esc_html($options['icon_text'] ?? '🔥') . ' '; ?>
                            Sample Article Title 2
                        </span>
                    </div>
                    <p class="description">Preview tampilan ticker dengan pengaturan saat ini</p>
                </div>
                
            </div>
            
            <?php submit_button('Save Ticker Settings', 'primary', 'submit', false); ?>
        </form>
    </div>
    
    <style>
    .ida-range {
        width: 200px;
        margin-right: 10px;
    }
    
    .ida-ticker-preview {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 14px;
        overflow: hidden;
        white-space: nowrap;
    }
    </style>
    <?php
}
function ida_render_hero_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        check_admin_referer('ida_hero_settings');
        
        $options = [
            'enable' => isset($_POST['enable']) ? 1 : 0,
            'title' => sanitize_text_field($_POST['title'] ?? ''),
            'description' => sanitize_textarea_field($_POST['description'] ?? ''),
            'cta_text' => sanitize_text_field($_POST['cta_text'] ?? ''),
            'cta_link' => esc_url_raw($_POST['cta_link'] ?? ''),
            'cta_target' => sanitize_text_field($_POST['cta_target'] ?? '_self'),
            'trust_text' => sanitize_text_field($_POST['trust_text'] ?? ''),
            'badge_text' => sanitize_text_field($_POST['badge_text'] ?? ''),
            'background_color' => sanitize_hex_color($_POST['background_color'] ?? '#ffffff'),
            'text_color' => sanitize_hex_color($_POST['text_color'] ?? '#111111'),
            'cta_color' => sanitize_hex_color($_POST['cta_color'] ?? '#2563eb'),
        ];
        
        update_option('ida_hero_options', $options);
        echo '<div class="notice notice-success"><p>Hero Settings saved successfully!</p></div>';
    }
    
    $options = get_option('ida_hero_options', []);
    ?>
    <div class="wrap ida-admin-wrap">
        <h1>🎯 Hero Section Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('ida_hero_settings'); ?>
            
            <div class="ida-form-grid">
                
                <!-- Basic Settings -->
                <div class="ida-card">
                    <h2>⚙️ Basic Settings</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Enable Hero Section</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="enable" value="1" <?php checked($options['enable'] ?? 1); ?> />
                                    Show hero section on homepage
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Badge Text</th>
                            <td>
                                <input type="text" name="badge_text" value="<?php echo esc_attr($options['badge_text'] ?? 'IDA Design System v2.0'); ?>" class="regular-text" />
                                <p class="description">Text badge di atas judul hero</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Hero Title</th>
                            <td>
                                <input type="text" name="title" value="<?php echo esc_attr($options['title'] ?? 'Theme WordPress Teringan yang Mendesain Ulang Algoritma SEO Anda.'); ?>" class="large-text" />
                                <p class="description">Judul utama hero section</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Hero Description</th>
                            <td>
                                <textarea name="description" rows="4" class="large-text"><?php echo esc_textarea($options['description'] ?? 'Dibangun dengan filosofi Content-First dan Zero Distraction. Tingkatkan Dwell Time, CTR, dan dominasi SERP Google tanpa perlu plugin optimasi yang berat.'); ?></textarea>
                                <p class="description">Deskripsi di bawah judul hero</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- CTA Settings -->
                <div class="ida-card">
                    <h2>🔗 Call-to-Action</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">CTA Button Text</th>
                            <td>
                                <input type="text" name="cta_text" value="<?php echo esc_attr($options['cta_text'] ?? 'Mulai Optimasi Sekarang'); ?>" class="regular-text" />
                                <p class="description">Text tombol CTA</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">CTA Button Link</th>
                            <td>
                                <input type="url" name="cta_link" value="<?php echo esc_attr($options['cta_link'] ?? '#'); ?>" class="large-text" />
                                <p class="description">URL tujuan tombol CTA</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">CTA Target</th>
                            <td>
                                <select name="cta_target">
                                    <option value="_self" <?php selected($options['cta_target'] ?? '_self', '_self'); ?>>Same Window</option>
                                    <option value="_blank" <?php selected($options['cta_target'] ?? '_self', '_blank'); ?>>New Window</option>
                                </select>
                                <p class="description">Cara membuka link CTA</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Trust Signal Text</th>
                            <td>
                                <input type="text" name="trust_text" value="<?php echo esc_attr($options['trust_text'] ?? 'Dipercaya oleh 5.000+ SEO Specialist'); ?>" class="large-text" />
                                <p class="description">Text trust signal di bawah CTA</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Visual Settings -->
                <div class="ida-card">
                    <h2>🎨 Visual Settings</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Background Color</th>
                            <td>
                                <input type="color" name="background_color" value="<?php echo esc_attr($options['background_color'] ?? '#ffffff'); ?>" />
                                <p class="description">Warna background hero section</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Text Color</th>
                            <td>
                                <input type="color" name="text_color" value="<?php echo esc_attr($options['text_color'] ?? '#111111'); ?>" />
                                <p class="description">Warna text hero section</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">CTA Button Color</th>
                            <td>
                                <input type="color" name="cta_color" value="<?php echo esc_attr($options['cta_color'] ?? '#2563eb'); ?>" />
                                <p class="description">Warna tombol CTA</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Preview -->
                <div class="ida-card">
                    <h2>👁️ Preview</h2>
                    <div class="ida-hero-preview" style="background: <?php echo esc_attr($options['background_color'] ?? '#ffffff'); ?>; color: <?php echo esc_attr($options['text_color'] ?? '#111111'); ?>; padding: 40px 20px; text-align: center; border-radius: 8px; border: 1px solid #ddd;">
                        <div style="display: inline-block; background: #eff6ff; color: #2563eb; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 16px;">
                            <?php echo esc_html($options['badge_text'] ?? 'IDA Design System v2.0'); ?>
                        </div>
                        <h1 style="font-size: 32px; font-weight: 800; line-height: 1.2; margin: 0 0 16px 0; color: inherit;">
                            <?php echo esc_html($options['title'] ?? 'Theme WordPress Teringan yang Mendesain Ulang Algoritma SEO Anda.'); ?>
                        </h1>
                        <p style="font-size: 16px; line-height: 1.6; margin: 0 0 24px 0; max-width: 600px; margin-left: auto; margin-right: auto; color: inherit; opacity: 0.8;">
                            <?php echo esc_html($options['description'] ?? 'Dibangun dengan filosofi Content-First dan Zero Distraction. Tingkatkan Dwell Time, CTR, dan dominasi SERP Google tanpa perlu plugin optimasi yang berat.'); ?>
                        </p>
                        <a href="#" style="display: inline-block; background: <?php echo esc_attr($options['cta_color'] ?? '#2563eb'); ?>; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; margin-bottom: 16px;">
                            <?php echo esc_html($options['cta_text'] ?? 'Mulai Optimasi Sekarang'); ?>
                        </a>
                        <div style="font-size: 14px; opacity: 0.7;">
                            ⭐⭐⭐⭐⭐ <?php echo esc_html($options['trust_text'] ?? 'Dipercaya oleh 5.000+ SEO Specialist'); ?>
                        </div>
                    </div>
                    <p class="description">Preview hero section dengan pengaturan saat ini</p>
                </div>
                
            </div>
            
            <?php submit_button('Save Hero Settings', 'primary', 'submit', false); ?>
        </form>
    </div>
    <?php
}
function ida_render_social_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        check_admin_referer('ida_social_settings');
        
        $options = [
            'facebook_url' => esc_url_raw($_POST['facebook_url'] ?? ''),
            'twitter_url' => esc_url_raw($_POST['twitter_url'] ?? ''),
            'instagram_url' => esc_url_raw($_POST['instagram_url'] ?? ''),
            'linkedin_url' => esc_url_raw($_POST['linkedin_url'] ?? ''),
            'youtube_url' => esc_url_raw($_POST['youtube_url'] ?? ''),
            'tiktok_url' => esc_url_raw($_POST['tiktok_url'] ?? ''),
            'whatsapp_number' => sanitize_text_field($_POST['whatsapp_number'] ?? ''),
            'telegram_url' => esc_url_raw($_POST['telegram_url'] ?? ''),
            'show_sharing_buttons' => isset($_POST['show_sharing_buttons']) ? 1 : 0,
            'sharing_position' => sanitize_text_field($_POST['sharing_position'] ?? 'after_content'),
            'sharing_style' => sanitize_text_field($_POST['sharing_style'] ?? 'rounded'),
            'show_follow_buttons' => isset($_POST['show_follow_buttons']) ? 1 : 0,
            'follow_position' => sanitize_text_field($_POST['follow_position'] ?? 'footer'),
        ];
        
        update_option('ida_social_options', $options);
        echo '<div class="notice notice-success"><p>Social Media Settings saved successfully!</p></div>';
    }
    
    $options = get_option('ida_social_options', []);
    ?>
    <div class="wrap ida-admin-wrap">
        <h1>📱 Social Media Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('ida_social_settings'); ?>
            
            <div class="ida-form-grid">
                
                <!-- Social Media URLs -->
                <div class="ida-card">
                    <h2>🔗 Social Media URLs</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Facebook</th>
                            <td>
                                <input type="url" name="facebook_url" value="<?php echo esc_attr($options['facebook_url'] ?? ''); ?>" class="large-text" placeholder="https://facebook.com/yourpage" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Twitter</th>
                            <td>
                                <input type="url" name="twitter_url" value="<?php echo esc_attr($options['twitter_url'] ?? ''); ?>" class="large-text" placeholder="https://twitter.com/yourusername" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Instagram</th>
                            <td>
                                <input type="url" name="instagram_url" value="<?php echo esc_attr($options['instagram_url'] ?? ''); ?>" class="large-text" placeholder="https://instagram.com/yourusername" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">LinkedIn</th>
                            <td>
                                <input type="url" name="linkedin_url" value="<?php echo esc_attr($options['linkedin_url'] ?? ''); ?>" class="large-text" placeholder="https://linkedin.com/in/yourprofile" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">YouTube</th>
                            <td>
                                <input type="url" name="youtube_url" value="<?php echo esc_attr($options['youtube_url'] ?? ''); ?>" class="large-text" placeholder="https://youtube.com/c/yourchannel" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">TikTok</th>
                            <td>
                                <input type="url" name="tiktok_url" value="<?php echo esc_attr($options['tiktok_url'] ?? ''); ?>" class="large-text" placeholder="https://tiktok.com/@yourusername" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">WhatsApp</th>
                            <td>
                                <input type="text" name="whatsapp_number" value="<?php echo esc_attr($options['whatsapp_number'] ?? ''); ?>" class="regular-text" placeholder="628123456789" />
                                <p class="description">Nomor WhatsApp (format: 628123456789)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Telegram</th>
                            <td>
                                <input type="url" name="telegram_url" value="<?php echo esc_attr($options['telegram_url'] ?? ''); ?>" class="large-text" placeholder="https://t.me/yourusername" />
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Social Sharing -->
                <div class="ida-card">
                    <h2>📤 Social Sharing</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Enable Sharing Buttons</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="show_sharing_buttons" value="1" <?php checked($options['show_sharing_buttons'] ?? 1); ?> />
                                    Show social sharing buttons on posts
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Sharing Position</th>
                            <td>
                                <select name="sharing_position">
                                    <option value="before_content" <?php selected($options['sharing_position'] ?? 'after_content', 'before_content'); ?>>Before Content</option>
                                    <option value="after_content" <?php selected($options['sharing_position'] ?? 'after_content', 'after_content'); ?>>After Content</option>
                                    <option value="both" <?php selected($options['sharing_position'] ?? 'after_content', 'both'); ?>>Before & After Content</option>
                                </select>
                                <p class="description">Posisi tombol sharing di artikel</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Button Style</th>
                            <td>
                                <select name="sharing_style">
                                    <option value="rounded" <?php selected($options['sharing_style'] ?? 'rounded', 'rounded'); ?>>Rounded</option>
                                    <option value="square" <?php selected($options['sharing_style'] ?? 'rounded', 'square'); ?>>Square</option>
                                    <option value="circle" <?php selected($options['sharing_style'] ?? 'rounded', 'circle'); ?>>Circle</option>
                                </select>
                                <p class="description">Style tombol sharing</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Social Follow -->
                <div class="ida-card">
                    <h2>👥 Social Follow</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Enable Follow Buttons</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="show_follow_buttons" value="1" <?php checked($options['show_follow_buttons'] ?? 1); ?> />
                                    Show social follow buttons
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Follow Position</th>
                            <td>
                                <select name="follow_position">
                                    <option value="header" <?php selected($options['follow_position'] ?? 'footer', 'header'); ?>>Header</option>
                                    <option value="footer" <?php selected($options['follow_position'] ?? 'footer', 'footer'); ?>>Footer</option>
                                    <option value="sidebar" <?php selected($options['follow_position'] ?? 'footer', 'sidebar'); ?>>Sidebar</option>
                                    <option value="both" <?php selected($options['follow_position'] ?? 'footer', 'both'); ?>>Header & Footer</option>
                                </select>
                                <p class="description">Posisi tombol follow</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Preview -->
                <div class="ida-card">
                    <h2>👁️ Preview</h2>
                    
                    <div class="ida-social-preview">
                        <h4>Social Sharing Buttons:</h4>
                        <div class="ida-sharing-preview" style="display: flex; gap: 8px; margin-bottom: 20px;">
                            <div style="width: 40px; height: 40px; background: #1877f2; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">f</div>
                            <div style="width: 40px; height: 40px; background: #1da1f2; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">t</div>
                            <div style="width: 40px; height: 40px; background: #0077b5; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">in</div>
                            <div style="width: 40px; height: 40px; background: #25d366; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">w</div>
                        </div>
                        
                        <h4>Social Follow Buttons:</h4>
                        <div class="ida-follow-preview" style="display: flex; gap: 8px;">
                            <?php
                            $social_networks = [
                                'facebook_url' => ['name' => 'Facebook', 'color' => '#1877f2', 'icon' => 'f'],
                                'twitter_url' => ['name' => 'Twitter', 'color' => '#1da1f2', 'icon' => 't'],
                                'instagram_url' => ['name' => 'Instagram', 'color' => '#e4405f', 'icon' => 'ig'],
                                'linkedin_url' => ['name' => 'LinkedIn', 'color' => '#0077b5', 'icon' => 'in'],
                                'youtube_url' => ['name' => 'YouTube', 'color' => '#ff0000', 'icon' => 'yt'],
                            ];
                            
                            foreach ($social_networks as $key => $network) {
                                if (!empty($options[$key])) {
                                    echo '<div style="width: 40px; height: 40px; background: ' . $network['color'] . '; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: bold;">' . $network['icon'] . '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <?php submit_button('Save Social Settings', 'primary', 'submit', false); ?>
        </form>
    </div>
    
    <style>
    .ida-social-preview h4 {
        margin-bottom: 10px;
        color: #1d2327;
    }
    </style>
    <?php
}
function ida_render_advanced_page() {
    // Handle form submission
    if (isset($_POST['submit'])) {
        check_admin_referer('ida_advanced_settings');
        
        $options = [
            'custom_css' => wp_strip_all_tags($_POST['custom_css'] ?? ''),
            'custom_js' => wp_strip_all_tags($_POST['custom_js'] ?? ''),
            'header_code' => wp_kses_post($_POST['header_code'] ?? ''),
            'footer_code' => wp_kses_post($_POST['footer_code'] ?? ''),
            'maintenance_mode' => isset($_POST['maintenance_mode']) ? 1 : 0,
            'maintenance_message' => wp_kses_post($_POST['maintenance_message'] ?? ''),
            'developer_mode' => isset($_POST['developer_mode']) ? 1 : 0,
            'debug_info' => isset($_POST['debug_info']) ? 1 : 0,
            'backup_settings' => isset($_POST['backup_settings']) ? 1 : 0,
        ];
        
        update_option('ida_advanced_options', $options);
        echo '<div class="notice notice-success"><p>Advanced Settings saved successfully!</p></div>';
    }
    
    // Handle export settings
    if (isset($_POST['export_settings'])) {
        $all_settings = [
            'ida_general_options' => get_option('ida_general_options', []),
            'ida_seo_options' => get_option('ida_seo_options', []),
            'ida_performance_options' => get_option('ida_performance_options', []),
            'ida_ticker_options' => get_option('ida_ticker_options', []),
            'ida_hero_options' => get_option('ida_hero_options', []),
            'ida_social_options' => get_option('ida_social_options', []),
            'ida_advanced_options' => get_option('ida_advanced_options', []),
        ];
        
        $filename = 'irvandoda-theme-settings-' . date('Y-m-d-H-i-s') . '.json';
        
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo json_encode($all_settings, JSON_PRETTY_PRINT);
        exit;
    }
    
    $options = get_option('ida_advanced_options', []);
    ?>
    <div class="wrap ida-admin-wrap">
        <h1>⚙️ Advanced Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('ida_advanced_settings'); ?>
            
            <div class="ida-form-grid">
                
                <!-- Custom Code -->
                <div class="ida-card">
                    <h2>💻 Custom Code</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Custom CSS</th>
                            <td>
                                <textarea name="custom_css" rows="8" class="large-text code" placeholder="/* Custom CSS */&#10;.my-custom-class {&#10;    color: #333;&#10;}"><?php echo esc_textarea($options['custom_css'] ?? ''); ?></textarea>
                                <p class="description">CSS kustom yang akan ditambahkan ke theme</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Custom JavaScript</th>
                            <td>
                                <textarea name="custom_js" rows="8" class="large-text code" placeholder="// Custom JavaScript&#10;document.addEventListener('DOMContentLoaded', function() {&#10;    console.log('Custom JS loaded');&#10;});"><?php echo esc_textarea($options['custom_js'] ?? ''); ?></textarea>
                                <p class="description">JavaScript kustom (tanpa tag &lt;script&gt;)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Header Code</th>
                            <td>
                                <textarea name="header_code" rows="6" class="large-text code" placeholder="<!-- Code yang akan ditambahkan di <head> -->"><?php echo esc_textarea($options['header_code'] ?? ''); ?></textarea>
                                <p class="description">Code yang akan ditambahkan di &lt;head&gt; (tracking, meta tags, dll)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Footer Code</th>
                            <td>
                                <textarea name="footer_code" rows="6" class="large-text code" placeholder="<!-- Code yang akan ditambahkan sebelum </body> -->"><?php echo esc_textarea($options['footer_code'] ?? ''); ?></textarea>
                                <p class="description">Code yang akan ditambahkan sebelum &lt;/body&gt;</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Maintenance Mode -->
                <div class="ida-card">
                    <h2>🚧 Maintenance Mode</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Enable Maintenance Mode</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="maintenance_mode" value="1" <?php checked($options['maintenance_mode'] ?? 0); ?> />
                                    Activate maintenance mode for visitors
                                </label>
                                <p class="description">Admin tetap bisa akses, visitor akan melihat halaman maintenance</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Maintenance Message</th>
                            <td>
                                <textarea name="maintenance_message" rows="4" class="large-text"><?php echo esc_textarea($options['maintenance_message'] ?? 'Website sedang dalam maintenance. Silakan kembali lagi nanti.'); ?></textarea>
                                <p class="description">Pesan yang ditampilkan saat maintenance mode aktif</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Developer Tools -->
                <div class="ida-card">
                    <h2>🛠️ Developer Tools</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Developer Mode</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="developer_mode" value="1" <?php checked($options['developer_mode'] ?? 0); ?> />
                                    Enable developer mode
                                </label>
                                <p class="description">Disable caching, enable debug info</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Show Debug Info</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="debug_info" value="1" <?php checked($options['debug_info'] ?? 0); ?> />
                                    Show debug information in footer
                                </label>
                                <p class="description">Tampilkan info debug (queries, load time, memory usage)</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Import/Export -->
                <div class="ida-card">
                    <h2>📦 Import/Export Settings</h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Export Settings</th>
                            <td>
                                <button type="submit" name="export_settings" class="button button-secondary">
                                    📥 Export All Settings
                                </button>
                                <p class="description">Download semua pengaturan theme dalam format JSON</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Import Settings</th>
                            <td>
                                <input type="file" id="import_file" accept=".json" style="margin-bottom: 10px;" />
                                <button type="button" id="import_settings" class="button button-secondary">
                                    📤 Import Settings
                                </button>
                                <p class="description">Upload file JSON untuk import pengaturan</p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- System Information -->
                <div class="ida-card">
                    <h2>ℹ️ System Information</h2>
                    
                    <table class="ida-info-table">
                        <tr>
                            <td><strong>WordPress Version:</strong></td>
                            <td><?php echo get_bloginfo('version'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>PHP Version:</strong></td>
                            <td><?php echo PHP_VERSION; ?></td>
                        </tr>
                        <tr>
                            <td><strong>MySQL Version:</strong></td>
                            <td><?php echo $GLOBALS['wpdb']->db_version(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Server Software:</strong></td>
                            <td><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Memory Limit:</strong></td>
                            <td><?php echo ini_get('memory_limit'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Max Upload Size:</strong></td>
                            <td><?php echo ini_get('upload_max_filesize'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Theme Directory:</strong></td>
                            <td><?php echo get_template_directory(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Active Plugins:</strong></td>
                            <td><?php echo count(get_option('active_plugins', [])); ?></td>
                        </tr>
                    </table>
                </div>
                
                <!-- Reset Settings -->
                <div class="ida-card">
                    <h2>🔄 Reset Settings</h2>
                    
                    <div class="ida-reset-section">
                        <p><strong>⚠️ Warning:</strong> Tindakan ini akan menghapus semua pengaturan theme dan mengembalikan ke default.</p>
                        <button type="button" id="reset_all_settings" class="button button-secondary" style="background: #d63638; color: white; border-color: #d63638;">
                            🗑️ Reset All Settings
                        </button>
                    </div>
                </div>
                
            </div>
            
            <?php submit_button('Save Advanced Settings', 'primary', 'submit', false); ?>
        </form>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Import settings
        document.getElementById('import_settings').addEventListener('click', function() {
            const fileInput = document.getElementById('import_file');
            const file = fileInput.files[0];
            
            if (!file) {
                alert('Please select a JSON file to import.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const settings = JSON.parse(e.target.result);
                    
                    if (confirm('Are you sure you want to import these settings? This will overwrite current settings.')) {
                        // Send AJAX request to import settings
                        const formData = new FormData();
                        formData.append('action', 'ida_import_settings');
                        formData.append('settings', JSON.stringify(settings));
                        formData.append('nonce', '<?php echo wp_create_nonce('ida_import_settings'); ?>');
                        
                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Settings imported successfully!');
                                location.reload();
                            } else {
                                alert('Import failed: ' + data.data);
                            }
                        })
                        .catch(error => {
                            alert('Import failed: ' + error.message);
                        });
                    }
                } catch (error) {
                    alert('Invalid JSON file.');
                }
            };
            reader.readAsText(file);
        });
        
        // Reset all settings
        document.getElementById('reset_all_settings').addEventListener('click', function() {
            if (confirm('Are you sure you want to reset ALL theme settings? This action cannot be undone.')) {
                if (confirm('This will delete all your customizations. Are you absolutely sure?')) {
                    // Send AJAX request to reset settings
                    const formData = new FormData();
                    formData.append('action', 'ida_reset_settings');
                    formData.append('nonce', '<?php echo wp_create_nonce('ida_reset_settings'); ?>');
                    
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('All settings have been reset to default.');
                            location.reload();
                        } else {
                            alert('Reset failed: ' + data.data);
                        }
                    })
                    .catch(error => {
                        alert('Reset failed: ' + error.message);
                    });
                }
            }
        });
    });
    </script>
    
    <style>
    .code {
        font-family: 'Courier New', Courier, monospace;
        font-size: 13px;
    }
    
    .ida-reset-section {
        background: #fff2f2;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        padding: 15px;
    }
    
    .ida-reset-section p {
        margin-bottom: 10px;
        color: #721c24;
    }
    </style>
    <?php
}

/**
 * AJAX handler for importing settings
 */
function ida_ajax_import_settings() {
    check_ajax_referer('ida_import_settings', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }
    
    $settings = json_decode(stripslashes($_POST['settings']), true);
    
    if (!is_array($settings)) {
        wp_send_json_error('Invalid settings format');
    }
    
    // Import each setting group
    $imported = 0;
    foreach ($settings as $option_name => $option_value) {
        if (strpos($option_name, 'ida_') === 0) {
            update_option($option_name, $option_value);
            $imported++;
        }
    }
    
    wp_send_json_success("Successfully imported {$imported} setting groups");
}
add_action('wp_ajax_ida_import_settings', 'ida_ajax_import_settings');

/**
 * AJAX handler for resetting all settings
 */
function ida_ajax_reset_settings() {
    check_ajax_referer('ida_reset_settings', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }
    
    // Delete all IDA theme options
    $options_to_delete = [
        'ida_general_options',
        'ida_seo_options',
        'ida_performance_options',
        'ida_ticker_options',
        'ida_hero_options',
        'ida_social_options',
        'ida_advanced_options',
    ];
    
    $deleted = 0;
    foreach ($options_to_delete as $option_name) {
        if (delete_option($option_name)) {
            $deleted++;
        }
    }
    
    wp_send_json_success("Successfully reset {$deleted} setting groups");
}
add_action('wp_ajax_ida_reset_settings', 'ida_ajax_reset_settings');

/**
 * Add admin bar menu for quick access
 */
function ida_add_admin_bar_menu($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $wp_admin_bar->add_node([
        'id' => 'irvandoda-themes',
        'title' => '🎨 Irvandoda Themes',
        'href' => admin_url('admin.php?page=irvandoda-themes'),
        'meta' => [
            'title' => 'Irvandoda Themes Settings',
        ],
    ]);
    
    // Add submenu items
    $submenus = [
        'ida-general-settings' => '⚙️ General',
        'ida-seo-settings' => '🔍 SEO',
        'ida-performance' => '🚀 Performance',
        'ida-ticker-settings' => '📰 Ticker',
        'ida-hero-settings' => '🎯 Hero',
        'ida-social-settings' => '📱 Social',
        'ida-advanced-settings' => '⚙️ Advanced',
    ];
    
    foreach ($submenus as $page => $title) {
        $wp_admin_bar->add_node([
            'parent' => 'irvandoda-themes',
            'id' => $page,
            'title' => $title,
            'href' => admin_url('admin.php?page=' . $page),
        ]);
    }
}
add_action('admin_bar_menu', 'ida_add_admin_bar_menu', 999);

/**
 * Add dashboard widget
 */
function ida_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'ida_theme_dashboard',
        '🎨 Irvandoda Themes',
        'ida_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'ida_add_dashboard_widget');

/**
 * Dashboard widget content
 */
function ida_dashboard_widget_content() {
    ?>
    <div class="ida-dashboard-widget">
        <p><strong>Theme:</strong> Irvandoda Full SEO Lightweight v<?php echo IDA_VERSION; ?></p>
        
        <div class="ida-widget-stats">
            <div class="ida-stat">
                <span class="ida-stat-number"><?php echo wp_count_posts()->publish; ?></span>
                <span class="ida-stat-label">Published Posts</span>
            </div>
            <div class="ida-stat">
                <span class="ida-stat-number"><?php echo wp_count_posts('page')->publish; ?></span>
                <span class="ida-stat-label">Published Pages</span>
            </div>
        </div>
        
        <div class="ida-widget-actions">
            <a href="<?php echo admin_url('admin.php?page=irvandoda-themes'); ?>" class="button button-primary">
                Open Theme Settings
            </a>
            <a href="<?php echo home_url('/test-permalink-fix.php'); ?>" target="_blank" class="button">
                Test Permalinks
            </a>
        </div>
    </div>
    
    <style>
    .ida-dashboard-widget {
        font-size: 13px;
    }
    
    .ida-widget-stats {
        display: flex;
        gap: 20px;
        margin: 15px 0;
    }
    
    .ida-stat {
        text-align: center;
        flex: 1;
    }
    
    .ida-stat-number {
        display: block;
        font-size: 24px;
        font-weight: bold;
        color: #2271b1;
    }
    
    .ida-stat-label {
        font-size: 11px;
        color: #646970;
        text-transform: uppercase;
    }
    
    .ida-widget-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .ida-widget-actions .button {
        flex: 1;
        text-align: center;
        font-size: 12px;
        padding: 6px 12px;
        height: auto;
    }
    </style>
    <?php
}