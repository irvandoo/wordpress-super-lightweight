<?php

declare(strict_types=1);

/**
 * Custom Branding - Replace WordPress Logo with Irvandoda Logo
 * 
 * @package Irvandoda_SEO_Light
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom Login Logo
 */
function ida_custom_login_logo(): void
{
    $logo_url = get_option('ida_site_logo');
    
    // Fallback to theme logo if not set
    if (empty($logo_url)) {
        // Check if PNG exists, otherwise use SVG
        $png_path = IDA_THEME_DIR . '/assets/images/irvandodalogo.png';
        $svg_path = IDA_THEME_DIR . '/assets/images/irvandodalogo.svg';
        
        if (file_exists($png_path)) {
            $logo_url = IDA_THEME_URI . '/assets/images/irvandodalogo.png';
        } else {
            $logo_url = IDA_THEME_URI . '/assets/images/irvandodalogo.svg';
        }
    }
    ?>
    <style type="text/css">
        /* ========================================
           🎨 IDA AESTHETIC LOGIN PAGE
           ======================================== */
        
        /* Main Login Container */
        .login {
            background: #ffffff !important;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        
        /* Login Form Container */
        #loginform {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            padding: 40px !important;
            margin-top: 20px !important;
            position: relative;
            overflow: hidden;
        }
        
        /* Form Background Decoration */
        #loginform::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
        }
        
        /* Logo Styling */
        #login h1 a, .login h1 a {
            background-image: url(<?php echo esc_url($logo_url); ?>);
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            width: 280px !important;
            height: 80px !important;
            margin-bottom: 30px !important;
            display: block;
        }
        
        /* Form Labels */
        .login label {
            color: #374151 !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            margin-bottom: 8px !important;
            display: block;
        }
        
        /* Input Fields */
        .login input[type="text"],
        .login input[type="password"],
        .login input[type="email"] {
            background: #f9fafb !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding: 16px 20px !important;
            font-size: 16px !important;
            line-height: 1.5 !important;
            color: #111827 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            transition: all 0.2s ease !important;
            margin-bottom: 20px !important;
        }
        
        /* Input Focus State */
        .login input[type="text"]:focus,
        .login input[type="password"]:focus,
        .login input[type="email"]:focus {
            background: #ffffff !important;
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
            outline: none !important;
        }
        
        /* Input Placeholder */
        .login input::placeholder {
            color: #9ca3af !important;
        }
        
        /* Primary Button (Login) */
        .login .button-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 16px 32px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #ffffff !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            text-shadow: none !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            width: 100% !important;
            margin-top: 10px !important;
        }
        
        /* Button Hover State */
        .login .button-primary:hover {
            background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 12px -1px rgba(0, 0, 0, 0.15) !important;
        }
        
        /* Button Active State */
        .login .button-primary:active {
            transform: translateY(0) !important;
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Remember Me Checkbox */
        .login .forgetmenot {
            margin: 20px 0 !important;
        }
        
        .login input[type="checkbox"] {
            width: 18px !important;
            height: 18px !important;
            margin-right: 8px !important;
            accent-color: #2563eb !important;
        }
        
        .login .forgetmenot label {
            font-size: 14px !important;
            color: #6b7280 !important;
            font-weight: 400 !important;
            display: inline !important;
            margin: 0 !important;
        }
        
        /* Links */
        .login #nav a,
        .login #backtoblog a {
            color: #2563eb !important;
            text-decoration: none !important;
            font-size: 14px !important;
            transition: color 0.2s ease !important;
        }
        
        .login #nav a:hover,
        .login #backtoblog a:hover {
            color: #1e40af !important;
            text-decoration: underline !important;
        }
        
        /* Navigation Links Container */
        .login #nav,
        .login #backtoblog {
            text-align: center !important;
            margin: 20px 0 !important;
        }
        
        /* Error Messages */
        .login #login_error,
        .login .message {
            border-radius: 12px !important;
            padding: 16px 20px !important;
            margin-bottom: 20px !important;
            border-left: 4px solid #dc2626 !important;
            background: #fef2f2 !important;
            color: #991b1b !important;
        }
        
        /* Success Messages */
        .login .message {
            border-left-color: #059669 !important;
            background: #f0fdf4 !important;
            color: #065f46 !important;
        }
        
        /* Form Wrapper */
        .login form {
            margin-top: 0 !important;
        }
        
        /* Language Switcher */
        .login .language-switcher {
            text-align: center !important;
            margin-top: 30px !important;
        }
        
        .login .language-switcher select {
            background: #f9fafb !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            color: #374151 !important;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 480px) {
            #loginform {
                padding: 30px 20px !important;
                margin: 20px !important;
            }
            
            #login h1 a, .login h1 a {
                width: 240px !important;
                height: 60px !important;
            }
            
            .login input[type="text"],
            .login input[type="password"],
            .login input[type="email"] {
                padding: 14px 16px !important;
                font-size: 16px !important; /* Prevent zoom on iOS */
            }
            
            .login .button-primary {
                padding: 14px 24px !important;
                font-size: 16px !important;
            }
        }
        
        /* Loading State */
        .login .button-primary:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
            transform: none !important;
        }
        
        /* Focus Visible for Accessibility */
        .login *:focus-visible {
            outline: 2px solid #2563eb !important;
            outline-offset: 2px !important;
        }
        
        /* High Contrast Mode Support */
        @media (prefers-contrast: high) {
            .login input[type="text"],
            .login input[type="password"],
            .login input[type="email"] {
                border-color: #000000 !important;
            }
            
            .login .button-primary {
                background: #000000 !important;
            }
        }
        
        /* Reduced Motion Support */
        @media (prefers-reduced-motion: reduce) {
            .login input[type="text"],
            .login input[type="password"],
            .login input[type="email"],
            .login .button-primary,
            .login #nav a,
            .login #backtoblog a {
                transition: none !important;
            }
            
            .login .button-primary:hover {
                transform: none !important;
            }
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'ida_custom_login_logo');

/**
 * Custom Login Logo URL
 */
function ida_custom_login_logo_url(): string
{
    return home_url();
}
add_filter('login_headerurl', 'ida_custom_login_logo_url');

/**
 * Custom Login Logo Title
 */
function ida_custom_login_logo_title(): string
{
    return get_bloginfo('name') . ' - Powered by Irvandoda';
}
add_filter('login_headertext', 'ida_custom_login_logo_title');

/**
 * Custom Admin Footer Text
 */
function ida_custom_admin_footer_text(): string
{
    return sprintf(
        __('Powered by <a href="%s" target="_blank">Irvandoda SEO Light Theme</a> | Built with ❤️ by <a href="https://irvandoda.my.id" target="_blank">Irvando Demas Arifiandani</a>', 'irvandoda-seo-light'),
        'https://irvandoda.my.id'
    );
}
add_filter('admin_footer_text', 'ida_custom_admin_footer_text');

/**
 * Remove WordPress Admin Bar Menu
 */
function ida_remove_wp_logo_admin_bar(WP_Admin_Bar $wp_admin_bar): void
{
    $wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'ida_remove_wp_logo_admin_bar', 999);

/**
 * Add Custom Irvandoda Admin Bar Menu
 */
function ida_custom_admin_bar_menu(WP_Admin_Bar $wp_admin_bar): void
{
    $logo_url = get_option('ida_site_logo');
    
    // Fallback to theme logo if not set
    if (empty($logo_url)) {
        $png_path = IDA_THEME_DIR . '/assets/images/irvandodalogo.png';
        $svg_path = IDA_THEME_DIR . '/assets/images/irvandodalogo.svg';
        
        if (file_exists($png_path)) {
            $logo_url = IDA_THEME_URI . '/assets/images/irvandodalogo.png';
        } else {
            $logo_url = IDA_THEME_URI . '/assets/images/irvandodalogo.svg';
        }
    }
    
    // Add parent menu
    $wp_admin_bar->add_node([
        'id'    => 'ida-logo',
        'title' => '<span class="ab-icon ida-logo-icon"></span><span class="screen-reader-text">Irvandoda Theme</span>',
        'href'  => admin_url('themes.php?page=ida-theme-settings'),
        'meta'  => [
            'class' => 'ida-admin-bar-logo',
        ],
    ]);
    
    // Add submenu items
    $wp_admin_bar->add_node([
        'parent' => 'ida-logo',
        'id'     => 'ida-theme-settings',
        'title'  => __('Theme Settings', 'irvandoda-seo-light'),
        'href'   => admin_url('themes.php?page=ida-theme-settings'),
    ]);
    
    $wp_admin_bar->add_node([
        'parent' => 'ida-logo',
        'id'     => 'ida-performance',
        'title'  => __('Performance', 'irvandoda-seo-light'),
        'href'   => admin_url('themes.php?page=ida-theme-settings#performance'),
    ]);
    
    $wp_admin_bar->add_node([
        'parent' => 'ida-logo',
        'id'     => 'ida-seo',
        'title'  => __('SEO Settings', 'irvandoda-seo-light'),
        'href'   => admin_url('themes.php?page=ida-theme-settings#seo'),
    ]);
    
    // Separator
    $wp_admin_bar->add_node([
        'parent' => 'ida-logo',
        'id'     => 'ida-separator',
        'title'  => '<hr style="margin: 5px 0; border: none; border-top: 1px solid #464b50;">',
        'meta'   => [
            'class' => 'ida-separator',
        ],
    ]);
    
    // External links
    $wp_admin_bar->add_node([
        'parent' => 'ida-logo',
        'id'     => 'ida-website',
        'title'  => __('Irvandoda Website', 'irvandoda-seo-light'),
        'href'   => 'https://irvandoda.my.id',
        'meta'   => [
            'target' => '_blank',
        ],
    ]);
    
    $wp_admin_bar->add_node([
        'parent' => 'ida-logo',
        'id'     => 'ida-support',
        'title'  => __('Get Support', 'irvandoda-seo-light'),
        'href'   => 'mailto:irvando.d.a@gmail.com',
    ]);
    
    $wp_admin_bar->add_node([
        'parent' => 'ida-logo',
        'id'     => 'ida-whatsapp',
        'title'  => __('WhatsApp', 'irvandoda-seo-light'),
        'href'   => 'https://wa.me/6285747476308',
        'meta'   => [
            'target' => '_blank',
        ],
    ]);
}
add_action('admin_bar_menu', 'ida_custom_admin_bar_menu', 10);

/**
 * Custom Admin Bar Logo Styling
 */
function ida_custom_admin_bar_logo(): void
{
    $logo_url = get_option('ida_site_logo');
    
    // Fallback to theme logo if not set
    if (empty($logo_url)) {
        $png_path = IDA_THEME_DIR . '/assets/images/irvandodalogo.png';
        $svg_path = IDA_THEME_DIR . '/assets/images/irvandodalogo.svg';
        
        if (file_exists($png_path)) {
            $logo_url = IDA_THEME_URI . '/assets/images/irvandodalogo.png';
        } else {
            $logo_url = IDA_THEME_URI . '/assets/images/irvandodalogo.svg';
        }
    }
    ?>
    <style type="text/css">
        /* Custom Irvandoda Logo in Admin Bar */
        #wpadminbar #wp-admin-bar-ida-logo > .ab-item .ab-icon.ida-logo-icon:before {
            background-image: url(<?php echo esc_url($logo_url); ?>) !important;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            background-color: white;
            content: '' !important;
            width: 20px;
            height: 20px;
            display: inline-block;
            vertical-align: middle;
            border-radius: 3px;
            padding: 2px;
            box-sizing: content-box;
        }
        
        #wpadminbar #wp-admin-bar-ida-logo > .ab-item {
            padding: 0 7px;
        }
        
        #wpadminbar .ida-admin-bar-logo:hover .ab-icon.ida-logo-icon:before {
            background-color: #f0f0f0;
            opacity: 0.95;
        }
        
        /* Separator styling */
        #wpadminbar .ida-separator {
            pointer-events: none;
        }
        
        #wpadminbar .ida-separator .ab-item {
            padding: 0;
            height: auto;
        }
    </style>
    <?php
}
add_action('admin_head', 'ida_custom_admin_bar_logo');
add_action('wp_head', 'ida_custom_admin_bar_logo');

/**
 * Customize Welcome Panel
 */
function ida_custom_welcome_panel(): void
{
    remove_action('welcome_panel', 'wp_welcome_panel');
    add_action('welcome_panel', 'ida_welcome_panel');
}
add_action('load-index.php', 'ida_custom_welcome_panel');

/**
 * Custom Welcome Panel Content
 */
function ida_welcome_panel(): void
{
    $user = wp_get_current_user();
    $username = $user->display_name;
    
    $logo_url = get_option('ida_site_logo');
    
    // Fallback to theme logo if not set
    if (empty($logo_url)) {
        $png_path = IDA_THEME_DIR . '/assets/images/irvandodalogo.png';
        $svg_path = IDA_THEME_DIR . '/assets/images/irvandodalogo.svg';
        
        if (file_exists($png_path)) {
            $logo_url = IDA_THEME_URI . '/assets/images/irvandodalogo.png';
        } else {
            $logo_url = IDA_THEME_URI . '/assets/images/irvandodalogo.svg';
        }
    }
    ?>
    <div class="welcome-panel-content">
        <div class="welcome-panel-header">
            <div class="welcome-panel-header-image">
                <svg preserveAspectRatio="xMidYMin slice" fill="none" viewBox="0 0 1232 240" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <defs>
                        <linearGradient id="ida-gradient-1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="ida-gradient-2" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:#667eea;stop-opacity:0" />
                            <stop offset="50%" style="stop-color:#667eea;stop-opacity:0.3" />
                            <stop offset="100%" style="stop-color:#667eea;stop-opacity:0" />
                        </linearGradient>
                    </defs>
                    <rect width="1232" height="240" fill="url(#ida-gradient-1)"/>
                    <circle cx="200" cy="120" r="80" fill="rgba(255,255,255,0.1)"/>
                    <circle cx="400" cy="180" r="60" fill="rgba(255,255,255,0.08)"/>
                    <circle cx="600" cy="100" r="70" fill="rgba(255,255,255,0.12)"/>
                    <circle cx="800" cy="160" r="50" fill="rgba(255,255,255,0.09)"/>
                    <circle cx="1000" cy="120" r="65" fill="rgba(255,255,255,0.11)"/>
                    <rect x="0" y="200" width="1232" height="40" fill="url(#ida-gradient-2)"/>
                </svg>
            </div>
            <div class="welcome-panel-header-content">
                <img src="<?php echo esc_url($logo_url); ?>" alt="Irvandoda Logo">
                <h2><?php printf(__('Welcome back, %s!', 'irvandoda-seo-light'), esc_html($username)); ?></h2>
                <p><?php _e('Your site is powered by Irvandoda SEO Light Theme - Optimized for speed and SEO', 'irvandoda-seo-light'); ?></p>
            </div>
        </div>
        
        <div class="welcome-panel-column-container">
            <div class="welcome-panel-column">
                <div class="welcome-panel-icon-pages"></div>
                <div class="welcome-panel-column-content">
                    <h3><?php _e('Create Content', 'irvandoda-seo-light'); ?></h3>
                    <p><?php _e('Start writing SEO-optimized content', 'irvandoda-seo-light'); ?></p>
                    <a class="button button-primary button-hero" href="<?php echo admin_url('post-new.php'); ?>">
                        <?php _e('Add New Post', 'irvandoda-seo-light'); ?>
                    </a>
                </div>
            </div>
            
            <div class="welcome-panel-column">
                <div class="welcome-panel-icon-layout"></div>
                <div class="welcome-panel-column-content">
                    <h3><?php _e('Theme Settings', 'irvandoda-seo-light'); ?></h3>
                    <p><?php _e('Configure SEO, performance, and social media', 'irvandoda-seo-light'); ?></p>
                    <a class="button button-primary button-hero" href="<?php echo admin_url('themes.php?page=ida-theme-settings'); ?>">
                        <?php _e('Theme Settings', 'irvandoda-seo-light'); ?>
                    </a>
                </div>
            </div>
            
            <div class="welcome-panel-column">
                <div class="welcome-panel-icon-appearance"></div>
                <div class="welcome-panel-column-content">
                    <h3><?php _e('Performance', 'irvandoda-seo-light'); ?></h3>
                    <p><?php _e('Your site is optimized for PageSpeed 95-100', 'irvandoda-seo-light'); ?></p>
                    <ul>
                        <li>✅ <?php _e('No jQuery', 'irvandoda-seo-light'); ?></li>
                        <li>✅ <?php _e('Lightweight CSS', 'irvandoda-seo-light'); ?></li>
                        <li>✅ <?php _e('Schema.org Ready', 'irvandoda-seo-light'); ?></li>
                        <li>✅ <?php _e('PHP 8.5 Optimized', 'irvandoda-seo-light'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="welcome-panel-footer">
            <p>
                <?php 
                printf(
                    __('Need help? Contact <a href="mailto:irvando.d.a@gmail.com">irvando.d.a@gmail.com</a> or visit <a href="%s" target="_blank">irvandoda.my.id</a>', 'irvandoda-seo-light'),
                    'https://irvandoda.my.id'
                );
                ?>
            </p>
        </div>
    </div>
    
    <style>
        .welcome-panel-header {
            position: relative;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
            min-height: 240px;
        }
        
        .welcome-panel-header-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .welcome-panel-header-image svg {
            width: 100%;
            height: 100%;
            display: block;
        }
        
        .welcome-panel-header-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
            padding: 40px 20px;
        }
        
        .welcome-panel-header-content img {
            max-width: 180px;
            height: auto;
            margin: 0 auto 15px;
            display: block;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));
        }
        
        .welcome-panel-header-content h2 {
            color: white;
            font-size: 32px;
            margin: 10px 0;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
            font-weight: 600;
        }
        
        .welcome-panel-header-content p {
            color: rgba(255,255,255,0.95);
            font-size: 16px;
            text-shadow: 0 1px 4px rgba(0,0,0,0.2);
            margin: 0;
        }
        
        .welcome-panel-column-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 30px;
        }
        
        .welcome-panel-column {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .welcome-panel-column h3 {
            margin-top: 10px;
            color: #111827;
        }
        
        .welcome-panel-column ul {
            list-style: none;
            padding: 0;
        }
        
        .welcome-panel-column ul li {
            padding: 4px 0;
            color: #059669;
        }
        
        .welcome-panel-footer {
            background: #f9fafb;
            padding: 15px 30px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            border-radius: 0 0 8px 8px;
        }
        
        .welcome-panel-footer p {
            margin: 0;
            color: #6b7280;
        }
        
        .welcome-panel-footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        .welcome-panel-footer a:hover {
            text-decoration: underline;
        }
        
        /* Fix dismiss button position */
        .welcome-panel .welcome-panel-close {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 100;
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
            padding: 5px 10px;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        
        .welcome-panel .welcome-panel-close:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
    <?php
}

/**
 * Add custom dashboard CSS
 */
function ida_custom_dashboard_css(): void
{
    ?>
    <style>
        /* Custom Dashboard Styling */
        .welcome-panel {
            background: white;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        
        /* Admin Bar Custom Logo Size */
        #wpadminbar #wp-admin-bar-ida-logo > .ab-item .ab-icon {
            width: 20px !important;
            height: 20px !important;
            margin-top: 6px !important;
        }
    </style>
    <?php
}
add_action('admin_head', 'ida_custom_dashboard_css');

/**
 * Remove WordPress Generator Meta Tag (Security & Performance)
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove WordPress Version from RSS Feed (Security)
 */
add_filter('the_generator', '__return_empty_string');

/**
 * Remove WordPress Version from Scripts and Styles (Security)
 */
function ida_remove_wp_version_strings(string $src): string
{
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY) ?? '', $query);
    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'ida_remove_wp_version_strings');
add_filter('style_loader_src', 'ida_remove_wp_version_strings');

/**
 * Remove WordPress Emoji Scripts (Performance)
 */
function ida_disable_emojis(): void
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'ida_disable_emojis');

/**
 * Remove Emoji from TinyMCE
 */
function ida_disable_emojis_tinymce(array $plugins): array
{
    if (is_array($plugins)) {
        return array_diff($plugins, ['wpemoji']);
    }
    return [];
}
add_filter('tiny_mce_plugins', 'ida_disable_emojis_tinymce');

/**
 * Remove DNS Prefetch for Emoji (Performance)
 */
function ida_remove_dns_prefetch(array $urls, string $relation_type): array
{
    if ($relation_type === 'dns-prefetch') {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
        $urls = array_diff($urls, [$emoji_svg_url]);
    }
    return $urls;
}
add_filter('wp_resource_hints', 'ida_remove_dns_prefetch', 10, 2);

/**
 * Remove WordPress Embed Script (Performance)
 */
function ida_deregister_embed_script(): void
{
    wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'ida_deregister_embed_script');

/**
 * Remove jQuery Migrate (Performance - PHP 8.5 doesn't need it)
 */
function ida_remove_jquery_migrate(WP_Scripts $scripts): void
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'ida_remove_jquery_migrate');

/**
 * Remove WordPress Block Library CSS (if not using Gutenberg)
 */
function ida_remove_block_library_css(): void
{
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style'); // WooCommerce blocks
        wp_dequeue_style('global-styles'); // Global styles
    }
}
add_action('wp_enqueue_scripts', 'ida_remove_block_library_css', 100);

/**
 * Remove WordPress REST API Links (if not needed)
 */
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11);

/**
 * Remove WordPress Shortlink (Performance)
 */
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Remove RSD Link (Performance)
 */
remove_action('wp_head', 'rsd_link');

/**
 * Remove WLW Manifest Link (Performance)
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Disable XML-RPC (Security & Performance)
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove WordPress Admin Bar CSS for non-admin users (Performance)
 */
function ida_remove_admin_bar_css(): void
{
    if (!current_user_can('manage_options')) {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }
}
add_action('get_header', 'ida_remove_admin_bar_css');

