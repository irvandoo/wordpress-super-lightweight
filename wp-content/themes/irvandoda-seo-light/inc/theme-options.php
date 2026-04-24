<?php
/**
 * Theme Options Panel - IDA Design System
 * Admin panel untuk konfigurasi theme
 * 
 * @package Irvandoda_SEO_Light
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add theme options page to admin menu
 */
function ida_add_theme_options_page() {
    add_theme_page(
        'IDA Theme Options',
        'Theme Options',
        'manage_options',
        'ida-theme-options',
        'ida_render_theme_options_page'
    );
}
add_action('admin_menu', 'ida_add_theme_options_page');

/**
 * Register theme settings
 */
function ida_register_theme_settings() {
    // General Settings
    register_setting('ida_theme_options', 'ida_general_settings', [
        'sanitize_callback' => 'ida_sanitize_general_settings'
    ]);
    
    // Ticker Settings
    register_setting('ida_theme_options', 'ida_ticker_settings', [
        'sanitize_callback' => 'ida_sanitize_ticker_settings'
    ]);
    
    // Hero Settings
    register_setting('ida_theme_options', 'ida_hero_settings', [
        'sanitize_callback' => 'ida_sanitize_hero_settings'
    ]);
    
    // CTA Settings
    register_setting('ida_theme_options', 'ida_cta_settings', [
        'sanitize_callback' => 'ida_sanitize_cta_settings'
    ]);
}
add_action('admin_init', 'ida_register_theme_settings');

/**
 * Sanitize general settings
 */
function ida_sanitize_general_settings($input) {
    $sanitized = [];
    
    if (isset($input['top_header_text'])) {
        $sanitized['top_header_text'] = sanitize_text_field($input['top_header_text']);
    }
    
    if (isset($input['footer_tagline'])) {
        $sanitized['footer_tagline'] = sanitize_text_field($input['footer_tagline']);
    }
    
    return $sanitized;
}

/**
 * Sanitize ticker settings
 */
function ida_sanitize_ticker_settings($input) {
    $sanitized = [];
    
    $sanitized['enable'] = isset($input['enable']) ? 1 : 0;
    
    if (isset($input['label'])) {
        $sanitized['label'] = sanitize_text_field($input['label']);
    }
    
    if (isset($input['count'])) {
        $sanitized['count'] = absint($input['count']);
        $sanitized['count'] = max(1, min(20, $sanitized['count']));
    }
    
    if (isset($input['speed'])) {
        $sanitized['speed'] = absint($input['speed']);
        $sanitized['speed'] = max(10, min(200, $sanitized['speed']));
    }
    
    return $sanitized;
}

/**
 * Sanitize hero settings
 */
function ida_sanitize_hero_settings($input) {
    $sanitized = [];
    
    if (isset($input['title'])) {
        $sanitized['title'] = sanitize_text_field($input['title']);
    }
    
    if (isset($input['description'])) {
        $sanitized['description'] = sanitize_textarea_field($input['description']);
    }
    
    if (isset($input['cta_text'])) {
        $sanitized['cta_text'] = sanitize_text_field($input['cta_text']);
    }
    
    if (isset($input['cta_link'])) {
        $sanitized['cta_link'] = esc_url_raw($input['cta_link']);
    }
    
    if (isset($input['trust_text'])) {
        $sanitized['trust_text'] = sanitize_text_field($input['trust_text']);
    }
    
    return $sanitized;
}

/**
 * Sanitize CTA settings
 */
function ida_sanitize_cta_settings($input) {
    $sanitized = [];
    
    if (isset($input['title'])) {
        $sanitized['title'] = sanitize_text_field($input['title']);
    }
    
    if (isset($input['description'])) {
        $sanitized['description'] = sanitize_textarea_field($input['description']);
    }
    
    if (isset($input['button_text'])) {
        $sanitized['button_text'] = sanitize_text_field($input['button_text']);
    }
    
    if (isset($input['button_link'])) {
        $sanitized['button_link'] = esc_url_raw($input['button_link']);
    }
    
    return $sanitized;
}

/**
 * Render theme options page
 */
function ida_render_theme_options_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get current settings
    $general_settings = get_option('ida_general_settings', []);
    $ticker_settings = get_option('ida_ticker_settings', []);
    $hero_settings = get_option('ida_hero_settings', []);
    $cta_settings = get_option('ida_cta_settings', []);
    
    // Show success message
    if (isset($_GET['settings-updated'])) {
        add_settings_error('ida_messages', 'ida_message', 'Settings Saved', 'updated');
    }
    
    settings_errors('ida_messages');
    ?>
    
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div class="ida-theme-options">
            <form method="post" action="options.php">
                <?php settings_fields('ida_theme_options'); ?>
                
                <div class="ida-tabs">
                    <nav class="nav-tab-wrapper">
                        <a href="#general" class="nav-tab nav-tab-active">General</a>
                        <a href="#ticker" class="nav-tab">Breaking News Ticker</a>
                        <a href="#hero" class="nav-tab">Hero Section</a>
                        <a href="#cta" class="nav-tab">CTA Section</a>
                    </nav>
                    
                    <!-- General Tab -->
                    <div id="general" class="tab-content active">
                        <h2>General Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="top_header_text">Top Header Text</label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="top_header_text" 
                                           name="ida_general_settings[top_header_text]" 
                                           value="<?php echo esc_attr($general_settings['top_header_text'] ?? 'Update Algoritma Terkini: ' . date('F Y')); ?>" 
                                           class="regular-text">
                                    <p class="description">Text yang muncul di top header bar</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="footer_tagline">Footer Tagline</label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="footer_tagline" 
                                           name="ida_general_settings[footer_tagline]" 
                                           value="<?php echo esc_attr($general_settings['footer_tagline'] ?? 'Zero Distraction, Full Conversion.'); ?>" 
                                           class="regular-text">
                                    <p class="description">Tagline yang muncul di footer</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Ticker Tab -->
                    <div id="ticker" class="tab-content">
                        <h2>Breaking News Ticker Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Enable Ticker</th>
                                <td>
                                    <label>
                                        <input type="checkbox" 
                                               name="ida_ticker_settings[enable]" 
                                               value="1" 
                                               <?php checked(isset($ticker_settings['enable']) ? $ticker_settings['enable'] : 1, 1); ?>>
                                        Enable breaking news ticker
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="ticker_label">Ticker Label</label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="ticker_label" 
                                           name="ida_ticker_settings[label]" 
                                           value="<?php echo esc_attr($ticker_settings['label'] ?? 'Terbaru'); ?>" 
                                           class="regular-text">
                                    <p class="description">Label yang muncul di ticker (contoh: Terbaru, Breaking News, Hot News)</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="ticker_count">Number of Posts</label>
                                </th>
                                <td>
                                    <input type="number" 
                                           id="ticker_count" 
                                           name="ida_ticker_settings[count]" 
                                           value="<?php echo esc_attr($ticker_settings['count'] ?? 5); ?>" 
                                           min="1" 
                                           max="20" 
                                           class="small-text">
                                    <p class="description">Jumlah artikel terbaru yang ditampilkan (1-20)</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="ticker_speed">Ticker Speed</label>
                                </th>
                                <td>
                                    <input type="number" 
                                           id="ticker_speed" 
                                           name="ida_ticker_settings[speed]" 
                                           value="<?php echo esc_attr($ticker_settings['speed'] ?? 50); ?>" 
                                           min="10" 
                                           max="200" 
                                           step="10" 
                                           class="small-text">
                                    <span>pixels/second</span>
                                    <p class="description">Kecepatan scroll ticker. Semakin besar semakin cepat (10-200)</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Hero Tab -->
                    <div id="hero" class="tab-content">
                        <h2>Hero Section Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="hero_title">Hero Title</label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="hero_title" 
                                           name="ida_hero_settings[title]" 
                                           value="<?php echo esc_attr($hero_settings['title'] ?? 'Theme WordPress Teringan yang Mendesain Ulang Algoritma SEO Anda.'); ?>" 
                                           class="large-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="hero_description">Hero Description</label>
                                </th>
                                <td>
                                    <textarea id="hero_description" 
                                              name="ida_hero_settings[description]" 
                                              rows="3" 
                                              class="large-text"><?php echo esc_textarea($hero_settings['description'] ?? 'Dibangun dengan filosofi Content-First dan Zero Distraction. Tingkatkan Dwell Time, CTR, dan dominasi SERP Google tanpa perlu plugin optimasi yang berat.'); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="hero_cta_text">CTA Button Text</label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="hero_cta_text" 
                                           name="ida_hero_settings[cta_text]" 
                                           value="<?php echo esc_attr($hero_settings['cta_text'] ?? 'Mulai Optimasi Sekarang'); ?>" 
                                           class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="hero_cta_link">CTA Button Link</label>
                                </th>
                                <td>
                                    <input type="url" 
                                           id="hero_cta_link" 
                                           name="ida_hero_settings[cta_link]" 
                                           value="<?php echo esc_url($hero_settings['cta_link'] ?? '#'); ?>" 
                                           class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="hero_trust_text">Trust Signal Text</label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="hero_trust_text" 
                                           name="ida_hero_settings[trust_text]" 
                                           value="<?php echo esc_attr($hero_settings['trust_text'] ?? 'Dipercaya oleh 5.000+ SEO Specialist'); ?>" 
                                           class="regular-text">
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- CTA Tab -->
                    <div id="cta" class="tab-content">
                        <h2>CTA Section Settings</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="cta_title">CTA Title</label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="cta_title" 
                                           name="ida_cta_settings[title]" 
                                           value="<?php echo esc_attr($cta_settings['title'] ?? 'Siap Mendominasi Halaman Pertama?'); ?>" 
                                           class="large-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="cta_description">CTA Description</label>
                                </th>
                                <td>
                                    <textarea id="cta_description" 
                                              name="ida_cta_settings[description]" 
                                              rows="3" 
                                              class="large-text"><?php echo esc_textarea($cta_settings['description'] ?? 'Dapatkan arsitektur theme ini secara utuh dan terapkan di website WordPress Anda dalam waktu kurang dari 5 menit.'); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="cta_button_text">Button Text</label>
                                </th>
                                <td>
                                    <input type="text" 
                                           id="cta_button_text" 
                                           name="ida_cta_settings[button_text]" 
                                           value="<?php echo esc_attr($cta_settings['button_text'] ?? 'Download Versi PRO'); ?>" 
                                           class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="cta_button_link">Button Link</label>
                                </th>
                                <td>
                                    <input type="url" 
                                           id="cta_button_link" 
                                           name="ida_cta_settings[button_link]" 
                                           value="<?php echo esc_url($cta_settings['button_link'] ?? '#'); ?>" 
                                           class="regular-text">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php submit_button('Save Settings'); ?>
            </form>
        </div>
    </div>
    
    <style>
        .ida-theme-options {
            max-width: 1200px;
        }
        
        .ida-tabs {
            background: white;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            margin-top: 20px;
        }
        
        .nav-tab-wrapper {
            border-bottom: 1px solid #ccd0d4;
            padding: 0;
            margin: 0;
        }
        
        .tab-content {
            display: none;
            padding: 20px;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .tab-content h2 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
    </style>
    
    <script>
        jQuery(document).ready(function($) {
            $('.nav-tab').on('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                $('.nav-tab').removeClass('nav-tab-active');
                $('.tab-content').removeClass('active');
                
                // Add active class to clicked tab
                $(this).addClass('nav-tab-active');
                
                // Show corresponding content
                var target = $(this).attr('href');
                $(target).addClass('active');
            });
        });
    </script>
    
    <?php
}
