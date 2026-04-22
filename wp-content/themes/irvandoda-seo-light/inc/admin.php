<?php

declare(strict_types=1);

/**
 * Admin Panel & Theme Settings
 * 
 * @package Irvandoda_SEO_Light
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add theme settings page to admin menu
 */
function ida_add_admin_menu(): void
{
    add_theme_page(
        __('Irvandoda SEO Settings', 'irvandoda-seo-light'),
        __('Theme Settings', 'irvandoda-seo-light'),
        'manage_options',
        'ida-theme-settings',
        'ida_render_settings_page'
    );
}
add_action('admin_menu', 'ida_add_admin_menu');

/**
 * Register theme settings
 */
function ida_register_settings(): void
{
    // General Settings
    register_setting('ida_settings_group', 'ida_site_logo');
    register_setting('ida_settings_group', 'ida_site_description');
    register_setting('ida_settings_group', 'ida_footer_text');
    
    // SEO Settings
    register_setting('ida_settings_group', 'ida_enable_schema');
    register_setting('ida_settings_group', 'ida_enable_og_tags');
    register_setting('ida_settings_group', 'ida_enable_breadcrumb');
    register_setting('ida_settings_group', 'ida_enable_toc');
    
    // Social Media
    register_setting('ida_settings_group', 'ida_facebook_url');
    register_setting('ida_settings_group', 'ida_twitter_url');
    register_setting('ida_settings_group', 'ida_instagram_url');
    register_setting('ida_settings_group', 'ida_linkedin_url');
    register_setting('ida_settings_group', 'ida_github_url');
    register_setting('ida_settings_group', 'ida_youtube_url');
    
    // Performance Settings
    register_setting('ida_settings_group', 'ida_enable_lazy_load');
    register_setting('ida_settings_group', 'ida_defer_js');
    register_setting('ida_settings_group', 'ida_minify_html');
    
    // Author Settings
    register_setting('ida_settings_group', 'ida_show_author_box');
    register_setting('ida_settings_group', 'ida_show_related_posts');
    register_setting('ida_settings_group', 'ida_related_posts_count');
    
    // Analytics
    register_setting('ida_settings_group', 'ida_google_analytics');
    register_setting('ida_settings_group', 'ida_google_site_verification');
}
add_action('admin_init', 'ida_register_settings');

/**
 * Render settings page
 */
function ida_render_settings_page(): void
{
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Save settings
    if (isset($_POST['ida_save_settings']) && check_admin_referer('ida_settings_nonce')) {
        update_option('ida_site_logo', sanitize_text_field($_POST['ida_site_logo'] ?? ''));
        update_option('ida_site_description', sanitize_textarea_field($_POST['ida_site_description'] ?? ''));
        update_option('ida_footer_text', sanitize_textarea_field($_POST['ida_footer_text'] ?? ''));
        
        update_option('ida_enable_schema', isset($_POST['ida_enable_schema']) ? '1' : '0');
        update_option('ida_enable_og_tags', isset($_POST['ida_enable_og_tags']) ? '1' : '0');
        update_option('ida_enable_breadcrumb', isset($_POST['ida_enable_breadcrumb']) ? '1' : '0');
        update_option('ida_enable_toc', isset($_POST['ida_enable_toc']) ? '1' : '0');
        
        update_option('ida_facebook_url', esc_url($_POST['ida_facebook_url'] ?? ''));
        update_option('ida_twitter_url', esc_url($_POST['ida_twitter_url'] ?? ''));
        update_option('ida_instagram_url', esc_url($_POST['ida_instagram_url'] ?? ''));
        update_option('ida_linkedin_url', esc_url($_POST['ida_linkedin_url'] ?? ''));
        update_option('ida_github_url', esc_url($_POST['ida_github_url'] ?? ''));
        update_option('ida_youtube_url', esc_url($_POST['ida_youtube_url'] ?? ''));
        
        update_option('ida_enable_lazy_load', isset($_POST['ida_enable_lazy_load']) ? '1' : '0');
        update_option('ida_defer_js', isset($_POST['ida_defer_js']) ? '1' : '0');
        update_option('ida_minify_html', isset($_POST['ida_minify_html']) ? '1' : '0');
        
        update_option('ida_show_author_box', isset($_POST['ida_show_author_box']) ? '1' : '0');
        update_option('ida_show_related_posts', isset($_POST['ida_show_related_posts']) ? '1' : '0');
        update_option('ida_related_posts_count', absint($_POST['ida_related_posts_count'] ?? 4));
        
        update_option('ida_google_analytics', sanitize_text_field($_POST['ida_google_analytics'] ?? ''));
        update_option('ida_google_site_verification', sanitize_text_field($_POST['ida_google_site_verification'] ?? ''));
        
        echo '<div class="notice notice-success"><p>' . esc_html__('Settings saved successfully!', 'irvandoda-seo-light') . '</p></div>';
    }
    
    // Get current settings
    $site_logo = get_option('ida_site_logo', '');
    $site_description = get_option('ida_site_description', '');
    $footer_text = get_option('ida_footer_text', '');
    
    $enable_schema = get_option('ida_enable_schema', '1');
    $enable_og_tags = get_option('ida_enable_og_tags', '1');
    $enable_breadcrumb = get_option('ida_enable_breadcrumb', '1');
    $enable_toc = get_option('ida_enable_toc', '1');
    
    $facebook_url = get_option('ida_facebook_url', '');
    $twitter_url = get_option('ida_twitter_url', '');
    $instagram_url = get_option('ida_instagram_url', '');
    $linkedin_url = get_option('ida_linkedin_url', '');
    $github_url = get_option('ida_github_url', '');
    $youtube_url = get_option('ida_youtube_url', '');
    
    $enable_lazy_load = get_option('ida_enable_lazy_load', '1');
    $defer_js = get_option('ida_defer_js', '1');
    $minify_html = get_option('ida_minify_html', '0');
    
    $show_author_box = get_option('ida_show_author_box', '1');
    $show_related_posts = get_option('ida_show_related_posts', '1');
    $related_posts_count = get_option('ida_related_posts_count', '4');
    
    $google_analytics = get_option('ida_google_analytics', '');
    $google_site_verification = get_option('ida_google_site_verification', '');
    
    ?>
    <div class="wrap ida-settings-wrap">
        <div class="ida-header">
            <div class="ida-header-content">
                <div class="ida-logo">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <rect width="48" height="48" rx="12" fill="url(#gradient)"/>
                        <path d="M24 12L32 20L24 28L16 20L24 12Z" fill="white" opacity="0.9"/>
                        <path d="M24 20L32 28L24 36L16 28L24 20Z" fill="white" opacity="0.7"/>
                        <defs>
                            <linearGradient id="gradient" x1="0" y1="0" x2="48" y2="48">
                                <stop offset="0%" stop-color="#667eea"/>
                                <stop offset="100%" stop-color="#764ba2"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="ida-header-text">
                    <h1>Irvandoda SEO Settings</h1>
                    <p>Ultra-lightweight theme optimized for Google PageSpeed 95-100</p>
                </div>
            </div>
            <div class="ida-header-meta">
                <span class="ida-badge">v<?php echo IDA_VERSION; ?></span>
                <span class="ida-badge ida-badge-success">PHP <?php echo PHP_VERSION; ?></span>
            </div>
        </div>
        
        <form method="post" action="" class="ida-form">
            <?php wp_nonce_field('ida_settings_nonce'); ?>
            
            <div class="ida-settings-container">
                <nav class="ida-tabs">
                    <a href="#general" class="ida-tab ida-tab-active">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        <span>General</span>
                    </a>
                    <a href="#seo" class="ida-tab">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z"/>
                        </svg>
                        <span>SEO</span>
                    </a>
                    <a href="#social" class="ida-tab">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"/>
                        </svg>
                        <span>Social Media</span>
                    </a>
                    <a href="#performance" class="ida-tab">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"/>
                        </svg>
                        <span>Performance</span>
                    </a>
                    <a href="#content" class="ida-tab">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                        </svg>
                        <span>Content</span>
                    </a>
                    <a href="#analytics" class="ida-tab">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                        <span>Analytics</span>
                    </a>
                </nav>
                
                <div class="ida-content">
                    <!-- General Settings -->
                    <div id="general" class="ida-panel" style="display: block;">
                        <div class="ida-panel-header">
                            <h2>General Settings</h2>
                            <p>Configure basic theme settings and branding</p>
                        </div>
                        <div class="ida-panel-body">
                            <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="ida_site_logo">Site Logo URL</label>
                            </th>
                            <td>
                                <input type="url" id="ida_site_logo" name="ida_site_logo" value="<?php echo esc_attr($site_logo); ?>" class="regular-text">
                                <p class="description">Enter the URL of your site logo image.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="ida_site_description">Site Description</label>
                            </th>
                            <td>
                                <textarea id="ida_site_description" name="ida_site_description" rows="3" class="large-text"><?php echo esc_textarea($site_description); ?></textarea>
                                <p class="description">Short description for your site (used in meta tags).</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="ida_footer_text">Footer Text</label>
                            </th>
                            <td>
                                <textarea id="ida_footer_text" name="ida_footer_text" rows="3" class="large-text"><?php echo esc_textarea($footer_text); ?></textarea>
                                <p class="description">Custom text to display in footer. Leave empty for default.</p>
                            </td>
                        </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- SEO Settings -->
                    <div id="seo" class="ida-panel" style="display: none;">
                        <div class="ida-panel-header">
                            <h2>SEO Settings</h2>
                            <p>Optimize your site for search engines</p>
                        </div>
                        <div class="ida-panel-body">
                            <table class="form-table">
                        <tr>
                            <th scope="row">SEO Features</th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input type="checkbox" name="ida_enable_schema" value="1" <?php checked($enable_schema, '1'); ?>>
                                        Enable Schema.org Structured Data
                                    </label><br>
                                    <label>
                                        <input type="checkbox" name="ida_enable_og_tags" value="1" <?php checked($enable_og_tags, '1'); ?>>
                                        Enable Open Graph Tags
                                    </label><br>
                                    <label>
                                        <input type="checkbox" name="ida_enable_breadcrumb" value="1" <?php checked($enable_breadcrumb, '1'); ?>>
                                        Enable Breadcrumb Navigation
                                    </label><br>
                                    <label>
                                        <input type="checkbox" name="ida_enable_toc" value="1" <?php checked($enable_toc, '1'); ?>>
                                        Enable Table of Contents (Auto-generated)
                                    </label>
                                </fieldset>
                                <p class="description">Enable/disable SEO features for better search engine visibility.</p>
                            </td>
                        </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Social Media Settings -->
                    <div id="social" class="ida-panel" style="display: none;">
                        <div class="ida-panel-header">
                            <h2>Social Media Links</h2>
                            <p>Connect your social media profiles</p>
                        </div>
                        <div class="ida-panel-body">
                            <table class="form-table">
                        <tr>
                            <th scope="row"><label for="ida_facebook_url">Facebook</label></th>
                            <td><input type="url" id="ida_facebook_url" name="ida_facebook_url" value="<?php echo esc_attr($facebook_url); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="ida_twitter_url">Twitter</label></th>
                            <td><input type="url" id="ida_twitter_url" name="ida_twitter_url" value="<?php echo esc_attr($twitter_url); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="ida_instagram_url">Instagram</label></th>
                            <td><input type="url" id="ida_instagram_url" name="ida_instagram_url" value="<?php echo esc_attr($instagram_url); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="ida_linkedin_url">LinkedIn</label></th>
                            <td><input type="url" id="ida_linkedin_url" name="ida_linkedin_url" value="<?php echo esc_attr($linkedin_url); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="ida_github_url">GitHub</label></th>
                            <td><input type="url" id="ida_github_url" name="ida_github_url" value="<?php echo esc_attr($github_url); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="ida_youtube_url">YouTube</label></th>
                            <td><input type="url" id="ida_youtube_url" name="ida_youtube_url" value="<?php echo esc_attr($youtube_url); ?>" class="regular-text"></td>
                        </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Performance Settings -->
                    <div id="performance" class="ida-panel" style="display: none;">
                        <div class="ida-panel-header">
                            <h2>Performance Optimization</h2>
                            <p>Boost your site speed and Core Web Vitals</p>
                        </div>
                        <div class="ida-panel-body">
                            <table class="form-table">
                        <tr>
                            <th scope="row">Performance Features</th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input type="checkbox" name="ida_enable_lazy_load" value="1" <?php checked($enable_lazy_load, '1'); ?>>
                                        Enable Lazy Loading for Images
                                    </label><br>
                                    <label>
                                        <input type="checkbox" name="ida_defer_js" value="1" <?php checked($defer_js, '1'); ?>>
                                        Defer JavaScript Loading
                                    </label><br>
                                    <label>
                                        <input type="checkbox" name="ida_minify_html" value="1" <?php checked($minify_html, '1'); ?>>
                                        Minify HTML Output
                                    </label>
                                </fieldset>
                                <p class="description">Enable performance optimizations for faster page loads.</p>
                            </td>
                        </tr>
                            </table>
                            
                            <div class="ida-info-box ida-info-success">
                                <h3>⚡ Current Performance Status</h3>
                                <div class="ida-features-grid">
                                    <div class="ida-feature">✅ No jQuery</div>
                                    <div class="ida-feature">✅ No Frameworks</div>
                                    <div class="ida-feature">✅ Inline Critical CSS</div>
                                    <div class="ida-feature">✅ Async CSS Loading</div>
                                    <div class="ida-feature">✅ System Fonts Only</div>
                                    <div class="ida-feature">✅ PHP 8.5 Optimized</div>
                                </div>
                                <p style="margin-top: 15px;"><strong>Target:</strong> Google PageSpeed 95-100 (Mobile & Desktop)</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Settings -->
                    <div id="content" class="ida-panel" style="display: none;">
                        <div class="ida-panel-header">
                            <h2>Content Settings</h2>
                            <p>Manage content display options</p>
                        </div>
                        <div class="ida-panel-body">
                            <table class="form-table">
                        <tr>
                            <th scope="row">Content Features</th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input type="checkbox" name="ida_show_author_box" value="1" <?php checked($show_author_box, '1'); ?>>
                                        Show Author Box (E-E-A-T)
                                    </label><br>
                                    <label>
                                        <input type="checkbox" name="ida_show_related_posts" value="1" <?php checked($show_related_posts, '1'); ?>>
                                        Show Related Posts
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="ida_related_posts_count">Related Posts Count</label>
                            </th>
                            <td>
                                <input type="number" id="ida_related_posts_count" name="ida_related_posts_count" value="<?php echo esc_attr($related_posts_count); ?>" min="1" max="12" class="small-text">
                                <p class="description">Number of related posts to display (1-12).</p>
                            </td>
                        </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Analytics Settings -->
                    <div id="analytics" class="ida-panel" style="display: none;">
                        <div class="ida-panel-header">
                            <h2>Analytics & Tracking</h2>
                            <p>Track your site performance and visitors</p>
                        </div>
                        <div class="ida-panel-body">
                            <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="ida_google_analytics">Google Analytics ID</label>
                            </th>
                            <td>
                                <input type="text" id="ida_google_analytics" name="ida_google_analytics" value="<?php echo esc_attr($google_analytics); ?>" class="regular-text" placeholder="G-XXXXXXXXXX">
                                <p class="description">Enter your Google Analytics 4 Measurement ID (e.g., G-XXXXXXXXXX).</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="ida_google_site_verification">Google Site Verification</label>
                            </th>
                            <td>
                                <input type="text" id="ida_google_site_verification" name="ida_google_site_verification" value="<?php echo esc_attr($google_site_verification); ?>" class="regular-text" placeholder="verification_code">
                                <p class="description">Enter your Google Search Console verification code.</p>
                            </td>
                        </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ida-submit-wrapper">
                <?php submit_button(__('Save All Settings', 'irvandoda-seo-light'), 'primary large', 'ida_save_settings'); ?>
            </div>
        </form>
        
        <div class="ida-footer-cards">
            <div class="ida-card ida-card-features">
                <h2>📊 Theme Features</h2>
                <div class="ida-features-grid-4">
                    <div class="ida-feature-card">
                        <div class="ida-feature-icon">⚡</div>
                        <h3>Performance</h3>
                        <ul>
                            <li>PageSpeed 95-100</li>
                            <li>LCP &lt; 1.8s</li>
                            <li>CLS = 0</li>
                            <li>INP &lt; 100ms</li>
                        </ul>
                    </div>
                    <div class="ida-feature-card">
                        <div class="ida-feature-icon">🔍</div>
                        <h3>SEO</h3>
                        <ul>
                            <li>Schema.org Data</li>
                            <li>Auto TOC</li>
                            <li>Breadcrumb</li>
                            <li>Reading Time</li>
                        </ul>
                    </div>
                    <div class="ida-feature-card">
                        <div class="ida-feature-icon">💻</div>
                        <h3>Technical</h3>
                        <ul>
                            <li>PHP 8.5 Ready</li>
                            <li>No jQuery</li>
                            <li>No Frameworks</li>
                            <li>Pure Vanilla JS</li>
                        </ul>
                    </div>
                    <div class="ida-feature-card">
                        <div class="ida-feature-icon">📱</div>
                        <h3>Design</h3>
                        <ul>
                            <li>Mobile-First</li>
                            <li>Responsive</li>
                            <li>System Fonts</li>
                            <li>Clean & Minimal</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="ida-card ida-card-help">
                <h2>🆘 Need Help?</h2>
                <p>Professional WordPress services and theme support:</p>
                <div class="ida-contact-grid">
                    <a href="mailto:irvando.d.a@gmail.com" class="ida-contact-item">
                        <span class="ida-contact-icon">📧</span>
                        <span>irvando.d.a@gmail.com</span>
                    </a>
                    <a href="https://wa.me/6285747476308" target="_blank" class="ida-contact-item">
                        <span class="ida-contact-icon">💬</span>
                        <span>+62 857-4747-6308</span>
                    </a>
                    <a href="https://irvandoda.my.id" target="_blank" class="ida-contact-item">
                        <span class="ida-contact-icon">🌐</span>
                        <span>irvandoda.my.id</span>
                    </a>
                    <a href="https://github.com/irvandoda" target="_blank" class="ida-contact-item">
                        <span class="ida-contact-icon">💼</span>
                        <span>@irvandoda</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Modern Admin Panel Styles - Lightweight & Aesthetic */
        .ida-settings-wrap {
            max-width: 1400px;
            margin: 20px auto;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, sans-serif;
        }
        
        /* Header */
        .ida-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }
        
        .ida-header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .ida-logo svg {
            display: block;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));
        }
        
        .ida-header-text h1 {
            margin: 0 0 5px 0;
            font-size: 28px;
            font-weight: 600;
            color: white;
        }
        
        .ida-header-text p {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .ida-header-meta {
            display: flex;
            gap: 10px;
        }
        
        .ida-badge {
            background: rgba(255,255,255,0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }
        
        .ida-badge-success {
            background: rgba(16, 185, 129, 0.3);
        }
        
        /* Form Container */
        .ida-form {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        /* Tabs Navigation */
        .ida-settings-container {
            display: flex;
        }
        
        .ida-tabs {
            width: 220px;
            background: #f9fafb;
            border-right: 1px solid #e5e7eb;
            padding: 20px 0;
        }
        
        .ida-tab {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            font-size: 14px;
            font-weight: 500;
        }
        
        .ida-tab:hover {
            background: #f3f4f6;
            color: #374151;
        }
        
        .ida-tab-active {
            background: white;
            color: #667eea;
            border-left-color: #667eea;
        }
        
        .ida-tab svg {
            flex-shrink: 0;
        }
        
        /* Content Area */
        .ida-content {
            flex: 1;
            padding: 30px;
        }
        
        .ida-panel {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .ida-panel-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f3f4f6;
        }
        
        .ida-panel-header h2 {
            margin: 0 0 5px 0;
            font-size: 22px;
            color: #111827;
        }
        
        .ida-panel-header p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }
        
        .ida-panel-body {
            max-width: 800px;
        }
        
        /* Form Table */
        .form-table th {
            width: 220px;
            padding: 15px 0;
            font-weight: 500;
            color: #374151;
        }
        
        .form-table td {
            padding: 15px 0;
        }
        
        .form-table input[type="text"],
        .form-table input[type="url"],
        .form-table input[type="number"],
        .form-table textarea {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .form-table input[type="text"]:focus,
        .form-table input[type="url"]:focus,
        .form-table input[type="number"]:focus,
        .form-table textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .form-table input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
        }
        
        .form-table label {
            display: inline-flex;
            align-items: center;
            margin-bottom: 8px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .form-table .description {
            color: #6b7280;
            font-size: 13px;
            margin-top: 5px;
        }
        
        /* Info Boxes */
        .ida-info-box {
            background: #f9fafb;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .ida-info-box h3 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #111827;
        }
        
        .ida-info-success {
            background: #ecfdf5;
            border-left-color: #10b981;
        }
        
        .ida-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }
        
        .ida-feature {
            font-size: 14px;
            color: #059669;
        }
        
        /* Submit Button */
        .ida-submit-wrapper {
            background: #f9fafb;
            padding: 20px 30px;
            border-top: 1px solid #e5e7eb;
            text-align: right;
        }
        
        .ida-submit-wrapper .button-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            font-size: 15px;
            font-weight: 500;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            transition: all 0.2s;
        }
        
        .ida-submit-wrapper .button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }
        
        /* Footer Cards */
        .ida-footer-cards {
            display: grid;
            gap: 20px;
            margin-top: 30px;
        }
        
        .ida-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        
        .ida-card h2 {
            margin: 0 0 20px 0;
            font-size: 20px;
            color: #111827;
        }
        
        .ida-card-features {
            border-left: 4px solid #10b981;
        }
        
        .ida-card-help {
            border-left: 4px solid #f59e0b;
        }
        
        .ida-features-grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .ida-feature-card {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .ida-feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .ida-feature-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .ida-feature-card h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #111827;
        }
        
        .ida-feature-card ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .ida-feature-card li {
            padding: 4px 0;
            color: #6b7280;
            font-size: 14px;
        }
        
        .ida-contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .ida-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            background: #f9fafb;
            border-radius: 8px;
            text-decoration: none;
            color: #374151;
            transition: all 0.2s;
            font-size: 14px;
        }
        
        .ida-contact-item:hover {
            background: #f3f4f6;
            transform: translateX(4px);
        }
        
        .ida-contact-icon {
            font-size: 20px;
        }
        
        /* Success Notice */
        .notice-success {
            border-left-color: #10b981 !important;
            background: #ecfdf5 !important;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .ida-settings-container {
                flex-direction: column;
            }
            
            .ida-tabs {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                display: flex;
                overflow-x: auto;
                padding: 0;
            }
            
            .ida-tab {
                border-left: none;
                border-bottom: 3px solid transparent;
                white-space: nowrap;
            }
            
            .ida-tab-active {
                border-left: none;
                border-bottom-color: #667eea;
            }
        }
        
        @media (max-width: 768px) {
            .ida-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            
            .ida-header-content {
                flex-direction: column;
            }
            
            .ida-features-grid-4,
            .ida-contact-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    <script>
        (function() {
            'use strict';
            
            // Pure Vanilla JS - No jQuery
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('.ida-tab');
                const panels = document.querySelectorAll('.ida-panel');
                
                tabs.forEach(function(tab) {
                    tab.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = this.getAttribute('href').substring(1);
                        
                        // Remove active class from all tabs
                        tabs.forEach(function(t) {
                            t.classList.remove('ida-tab-active');
                        });
                        
                        // Add active class to clicked tab
                        this.classList.add('ida-tab-active');
                        
                        // Hide all panels
                        panels.forEach(function(panel) {
                            panel.style.display = 'none';
                        });
                        
                        // Show target panel
                        const targetPanel = document.getElementById(target);
                        if (targetPanel) {
                            targetPanel.style.display = 'block';
                        }
                    });
                });
                
                // Smooth scroll to top on tab change
                tabs.forEach(function(tab) {
                    tab.addEventListener('click', function() {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                });
            });
        })();
    </script>
    <?php
}

/**
 * Add settings link to theme actions
 */
function ida_add_settings_link(array $links): array
{
    $settings_link = '<a href="' . admin_url('themes.php?page=ida-theme-settings') . '">' . __('Settings', 'irvandoda-seo-light') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('theme_action_links_' . get_template(), 'ida_add_settings_link');

/**
 * Add admin styles
 */
function ida_admin_styles(): void
{
    ?>
    <style>
        .theme-browser .theme.active .theme-name,
        .theme-browser .theme.active .theme-actions {
            background: #0066cc;
        }
    </style>
    <?php
}
add_action('admin_head', 'ida_admin_styles');
