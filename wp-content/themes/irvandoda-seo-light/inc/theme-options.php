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
function ida_render_hero_page() { echo '<div class="wrap"><h1>🎯 Hero Settings</h1><p>Coming soon...</p></div>'; }
function ida_render_social_page() { echo '<div class="wrap"><h1>📱 Social Settings</h1><p>Coming soon...</p></div>'; }
function ida_render_advanced_page() { echo '<div class="wrap"><h1>⚙️ Advanced Settings</h1><p>Coming soon...</p></div>'; }