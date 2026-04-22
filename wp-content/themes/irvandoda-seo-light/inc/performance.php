<?php
declare(strict_types=1);

/**
 * Performance Optimizations
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

/**
 * Remove unnecessary WordPress features
 */
function ida_performance_cleanup(): void {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove Windows Live Writer
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove REST API links
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove generator
    remove_action('wp_head', 'wp_generator');
}
add_action('init', 'ida_performance_cleanup');

/**
 * Disable embeds
 */
function ida_disable_embeds(): void {
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'ida_disable_embeds');

/**
 * Add preconnect for external resources
 */
function ida_resource_hints(array $urls, string $relation_type): array {
    if ($relation_type === 'preconnect') {
        $urls[] = [
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        ];
    }
    return $urls;
}
add_filter('wp_resource_hints', 'ida_resource_hints', 10, 2);

/**
 * Lazy load images
 */
function ida_add_lazy_load(string $content): string {
    if (is_feed() || is_admin()) {
        return $content;
    }
    
    // Add loading="lazy" to images
    return preg_replace('/<img(.*?)>/i', '<img$1 loading="lazy">', $content) ?? $content;
}
add_filter('the_content', 'ida_add_lazy_load', 20);

/**
 * Optimize excerpt
 */
function ida_excerpt_length(int $length): int {
    return 25;
}
add_filter('excerpt_length', 'ida_excerpt_length');

function ida_excerpt_more(string $more): string {
    return '...';
}
add_filter('excerpt_more', 'ida_excerpt_more');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove query strings from static resources
 */
function ida_remove_query_strings(string $src): string {
    if (str_contains($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'ida_remove_query_strings', 10, 1);
add_filter('script_loader_src', 'ida_remove_query_strings', 10, 1);
