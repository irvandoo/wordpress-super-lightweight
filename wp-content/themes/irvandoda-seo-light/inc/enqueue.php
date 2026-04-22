<?php

declare(strict_types=1);

/**
 * Enqueue Scripts and Styles - PHP 8.4 Optimized
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

/**
 * Inline critical CSS
 */
function ida_critical_css(): void {
    $critical_css = file_get_contents(IDA_THEME_DIR . '/assets/css/critical.css');
    if ($critical_css !== false) {
        echo '<style id="ida-critical-css">' . $critical_css . '</style>';
    }
}
add_action('wp_head', 'ida_critical_css', 1);

/**
 * Enqueue styles
 */
function ida_enqueue_styles(): void {
    // Main CSS - load async
    wp_enqueue_style(
        handle: 'ida-main',
        src: IDA_THEME_URI . '/assets/css/main.min.css',
        deps: [],
        ver: IDA_VERSION,
        media: 'all'
    );
    
    // Make it async
    add_filter('style_loader_tag', 'ida_async_css', 10, 2);
}
add_action('wp_enqueue_scripts', 'ida_enqueue_styles');

/**
 * Make CSS async
 */
function ida_async_css(string $html, string $handle): string {
    if ($handle === 'ida-main') {
        $html = str_replace(
            search: "rel='stylesheet'",
            replace: "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"",
            subject: $html
        );
        $html .= '<noscript><link rel="stylesheet" href="' . IDA_THEME_URI . '/assets/css/main.min.css"></noscript>';
    }
    return $html;
}

/**
 * Enqueue scripts
 */
function ida_enqueue_scripts(): void {
    // Main JS - defer
    wp_enqueue_script(
        handle: 'ida-main',
        src: IDA_THEME_URI . '/assets/js/main.min.js',
        deps: [],
        ver: IDA_VERSION,
        args: true
    );
    
    // Comment reply
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ida_enqueue_scripts');

/**
 * Add defer to scripts
 */
function ida_defer_scripts(string $tag, string $handle): string {
    return match($handle) {
        'ida-main' => str_replace(' src', ' defer src', $tag),
        default => $tag
    };
}
add_filter('script_loader_tag', 'ida_defer_scripts', 10, 2);

/**
 * Remove unnecessary scripts
 */
function ida_remove_scripts(): void {
    // Remove jQuery if not needed
    if (!is_admin()) {
        wp_deregister_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'ida_remove_scripts', 100);
