<?php

declare(strict_types=1);

/**
 * Custom Admin Dashboard Styling
 * Professional, Subtle & Lightweight
 * 
 * @package Irvandoda_SEO_Light
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue Custom Admin Styles
 */
function ida_custom_admin_styles(): void
{
    // Only load on admin pages
    if (!is_admin()) {
        return;
    }
    
    ?>
    <style type="text/css">
        /* ========================================
           IRVANDODA ADMIN DASHBOARD STYLING
           Professional, Subtle & Lightweight
           ======================================== */
        
        /* === COLOR VARIABLES === */
        :root {
            --ida-primary: #2271b1;
            --ida-primary-hover: #135e96;
            --ida-accent: #3582c4;
            --ida-success: #00a32a;
            --ida-warning: #dba617;
            --ida-danger: #d63638;
            --ida-gray-50: #f9fafb;
            --ida-gray-100: #f0f0f1;
            --ida-gray-200: #dcdcde;
            --ida-gray-300: #c3c4c7;
            --ida-gray-600: #646970;
            --ida-gray-700: #50575e;
            --ida-gray-800: #2c3338;
            --ida-gray-900: #1d2327;
        }
        
        /* === ADMIN BODY === */
        #wpwrap {
            background: #f0f0f1;
        }
        
        #wpcontent {
            background: #f0f0f1;
        }
        
        /* === DASHBOARD WIDGETS === */
        .wrap {
            margin: 20px 20px 0 0;
        }
        
        #dashboard-widgets-wrap {
            margin-top: 20px;
        }
        
        .postbox {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
            margin-bottom: 20px;
            transition: box-shadow 0.2s ease;
        }
        
        .postbox:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }
        
        .postbox .postbox-header {
            background: #f6f7f7;
            border-bottom: 1px solid #c3c4c7;
            border-radius: 4px 4px 0 0;
            padding: 12px 16px;
        }
        
        .postbox .postbox-header h2,
        .postbox .postbox-header .hndle {
            color: #1d2327;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
        }
        
        .postbox .inside {
            padding: 16px;
            margin: 0;
        }
        
        /* === AT A GLANCE WIDGET === */
        #dashboard_right_now ul li a {
            color: var(--ida-primary);
            text-decoration: none;
            transition: color 0.15s;
        }
        
        #dashboard_right_now ul li a:hover {
            color: var(--ida-primary-hover);
        }
        
        #dashboard_right_now .main {
            padding: 0;
        }
        
        #dashboard_right_now li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f1;
        }
        
        #dashboard_right_now li:last-child {
            border-bottom: none;
        }
        
        /* === ACTIVITY WIDGET === */
        #activity-widget #the-comment-list .comment-item {
            padding: 12px;
            background: #f9fafb;
            border-radius: 3px;
            margin-bottom: 8px;
            border-left: 2px solid #c3c4c7;
        }
        
        #activity-widget #the-comment-list .comment-item:hover {
            background: #f0f0f1;
            border-left-color: var(--ida-primary);
        }
        
        /* === QUICK DRAFT WIDGET === */
        #dashboard_quick_press .input-text-wrap input,
        #dashboard_quick_press .textarea-wrap textarea {
            border: 1px solid #8c8f94;
            border-radius: 3px;
            padding: 8px;
            transition: border-color 0.15s;
        }
        
        #dashboard_quick_press .input-text-wrap input:focus,
        #dashboard_quick_press .textarea-wrap textarea:focus {
            border-color: var(--ida-primary);
            box-shadow: 0 0 0 1px var(--ida-primary);
            outline: none;
        }
        
        /* === BUTTONS === */
        .button,
        .button-secondary {
            background: #f6f7f7;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            padding: 6px 14px;
            transition: all 0.15s;
            font-weight: 400;
            color: #2c3338;
        }
        
        .button:hover,
        .button-secondary:hover {
            background: white;
            border-color: #646970;
            color: #1d2327;
        }
        
        .button-primary {
            background: var(--ida-primary);
            border: 1px solid var(--ida-primary);
            border-radius: 3px;
            padding: 6px 14px;
            box-shadow: 0 1px 0 var(--ida-primary-hover);
            transition: all 0.15s;
            font-weight: 400;
            color: white;
        }
        
        .button-primary:hover,
        .button-primary:focus {
            background: var(--ida-primary-hover);
            border-color: var(--ida-primary-hover);
            color: white;
        }
        
        /* === ADMIN MENU === */
        #adminmenu {
            background: #1d2327;
        }
        
        #adminmenu li.menu-top {
            border-bottom: 1px solid #2c3338;
        }
        
        #adminmenu .wp-submenu {
            background: #2c3338;
        }
        
        #adminmenu li.menu-top:hover,
        #adminmenu li.opensub > a.menu-top,
        #adminmenu li > a.menu-top:focus {
            background: #2c3338;
            color: #72aee6;
        }
        
        #adminmenu li.current a.menu-top,
        #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
            background: #2c3338;
            color: white;
            font-weight: 600;
            border-left: 3px solid #72aee6;
        }
        
        #adminmenu .wp-submenu a:hover {
            color: #72aee6;
        }
        
        /* === ADMIN BAR === */
        #wpadminbar {
            background: #1d2327;
        }
        
        #wpadminbar .ab-item,
        #wpadminbar a.ab-item,
        #wpadminbar > #wp-toolbar span.ab-label,
        #wpadminbar > #wp-toolbar span.noticon {
            color: #f0f0f1;
        }
        
        #wpadminbar .ab-top-menu > li:hover > .ab-item,
        #wpadminbar .ab-top-menu > li.hover > .ab-item,
        #wpadminbar .ab-top-menu > li > .ab-item:focus {
            background: #2c3338;
            color: #72aee6;
        }
        
        /* === NOTICES === */
        .notice,
        .notice-success,
        .notice-error,
        .notice-warning,
        .notice-info {
            border-left-width: 4px;
            border-radius: 0;
            padding: 12px;
            margin: 12px 0;
            background: white;
        }
        
        .notice-success {
            border-left-color: #00a32a;
        }
        
        .notice-error {
            border-left-color: #d63638;
        }
        
        .notice-warning {
            border-left-color: #dba617;
        }
        
        .notice-info {
            border-left-color: #72aee6;
        }
        
        /* === PAGE TITLE === */
        .wrap h1,
        .wrap h2.nav-tab-wrapper {
            color: #1d2327;
            font-weight: 600;
            margin-bottom: 16px;
        }
        
        .wrap h1 .page-title-action {
            background: var(--ida-primary);
            border: 1px solid var(--ida-primary);
            color: white;
            border-radius: 3px;
            padding: 6px 14px;
            box-shadow: 0 1px 0 var(--ida-primary-hover);
            transition: all 0.15s;
            font-weight: 400;
        }
        
        .wrap h1 .page-title-action:hover {
            background: var(--ida-primary-hover);
            border-color: var(--ida-primary-hover);
        }
        
        /* === TABLES === */
        .wp-list-table {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 0;
        }
        
        .wp-list-table thead th,
        .wp-list-table tfoot th {
            background: #f6f7f7;
            border-bottom: 1px solid #c3c4c7;
            font-weight: 600;
            color: #2c3338;
        }
        
        .wp-list-table tbody tr:hover {
            background: #f6f7f7;
        }
        
        .wp-list-table tr {
            border-bottom: 1px solid #f0f0f1;
        }
        
        /* === FORMS === */
        input[type="text"],
        input[type="email"],
        input[type="url"],
        input[type="password"],
        input[type="search"],
        input[type="number"],
        textarea,
        select {
            border: 1px solid #8c8f94;
            border-radius: 3px;
            padding: 6px 10px;
            transition: border-color 0.15s;
            background: white;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="url"]:focus,
        input[type="password"]:focus,
        input[type="search"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: var(--ida-primary);
            box-shadow: 0 0 0 1px var(--ida-primary);
            outline: none;
        }
        
        /* === TABS === */
        .nav-tab {
            background: #f0f0f1;
            border: 1px solid #c3c4c7;
            border-bottom: none;
            padding: 8px 16px;
            margin-right: 4px;
            transition: background 0.15s;
            color: #50575e;
        }
        
        .nav-tab:hover {
            background: white;
            color: #2c3338;
        }
        
        .nav-tab-active {
            background: white;
            border-color: #c3c4c7;
            color: #1d2327;
            font-weight: 600;
        }
        
        /* === METABOXES === */
        .postbox-container .meta-box-sortables {
            min-height: 0;
        }
        
        .postbox .handlediv {
            color: #646970;
        }
        
        .postbox .handlediv:hover {
            color: #2c3338;
        }
        
        /* === FOOTER === */
        #wpfooter {
            padding: 16px;
            background: white;
            border-top: 1px solid #c3c4c7;
            margin-top: 20px;
            color: #646970;
        }
        
        /* === RESPONSIVE === */
        @media screen and (max-width: 782px) {
            .postbox {
                border-radius: 0;
            }
            
            .postbox .postbox-header {
                border-radius: 0;
            }
        }
        
        /* === SUBTLE IMPROVEMENTS === */
        .wp-core-ui .button-link {
            color: var(--ida-primary);
        }
        
        .wp-core-ui .button-link:hover,
        .wp-core-ui .button-link:focus {
            color: var(--ida-primary-hover);
        }
        
        /* === LOADING STATES === */
        .spinner {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath fill='%232271b1' d='M10 3a7 7 0 100 14 7 7 0 000-14zm0 12a5 5 0 110-10 5 5 0 010 10z' opacity='.3'/%3E%3Cpath fill='%232271b1' d='M10 3v2a5 5 0 010 10v2a7 7 0 000-14z'/%3E%3C/svg%3E");
        }
        
        /* === SCROLLBAR (SUBTLE) === */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f0f0f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c3c4c7;
            border-radius: 6px;
            border: 2px solid #f0f0f1;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #8c8f94;
        }
        
        /* === PROFESSIONAL ACCENTS === */
        .wp-heading-inline {
            color: #1d2327;
        }
        
        .subsubsub a {
            color: #646970;
        }
        
        .subsubsub a:hover,
        .subsubsub a.current {
            color: #1d2327;
        }
        
        /* === CLEAN CARD STYLE === */
        .card {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
        }
        
        /* === PROFESSIONAL LINKS === */
        a {
            color: var(--ida-primary);
            transition: color 0.15s;
        }
        
        a:hover,
        a:focus {
            color: var(--ida-primary-hover);
        }
    </style>
    <?php
}
add_action('admin_head', 'ida_custom_admin_styles');

/**
 * Add Custom Dashboard Welcome Message
 */
function ida_custom_dashboard_message(): void
{
    $screen = get_current_screen();
    
    if ($screen->id !== 'dashboard') {
        return;
    }
    
    $site_name = get_bloginfo('name');
    
    ?>
    <div class="notice notice-info" style="border-left-color: #2271b1;">
        <p style="margin: 10px 0;">
            <strong>🚀 <?php echo esc_html($site_name); ?></strong> - 
            Powered by <strong>Irvandoda SEO Light Theme</strong> | 
            Optimized for <strong>PageSpeed 95-100</strong> | 
            PHP <strong><?php echo PHP_VERSION; ?></strong>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'ida_custom_dashboard_message');
