<?php
declare(strict_types=1);

/**
 * Helper Functions
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

/**
 * Calculate reading time
 */
function ida_reading_time(): int {
    global $post;
    $content = strip_tags($post->post_content);
    $word_count = str_word_count($content);
    $reading_time = (int) ceil($word_count / 200); // 200 words per minute
    
    return $reading_time;
}

/**
 * Get related posts
 */
function ida_related_posts(?int $post_id = null, int $limit = 4): \WP_Query {
    $post_id ??= get_the_ID();
    
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return new \WP_Query([]);
    }
    
    $args = [
        'category__in' => $categories,
        'post__not_in' => [$post_id],
        'posts_per_page' => $limit,
        'orderby' => 'rand',
        'ignore_sticky_posts' => 1
    ];
    
    return new \WP_Query($args);
}

/**
 * Truncate text
 */
function ida_truncate(string $text, int $length = 100, string $suffix = '...'): string {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $last_space = strrpos($text, ' ');
    
    if ($last_space !== false) {
        $text = substr($text, 0, $last_space);
    }
    
    return $text . $suffix;
}

/**
 * Get post views (simple counter)
 */
function ida_get_post_views(?int $post_id = null): int {
    $post_id ??= get_the_ID();
    
    $count = get_post_meta($post_id, 'ida_post_views', true);
    
    return $count ? (int) $count : 0;
}

/**
 * Set post views
 */
function ida_set_post_views(?int $post_id = null): void {
    $post_id ??= get_the_ID();
    
    $count = ida_get_post_views($post_id);
    $count++;
    
    update_post_meta($post_id, 'ida_post_views', $count);
}

/**
 * Track post views on single posts
 */
function ida_track_post_views(): void {
    if (is_single() && !is_user_logged_in()) {
        ida_set_post_views();
    }
}
add_action('wp_head', 'ida_track_post_views');

/**
 * Format number
 */
function ida_format_number(int|float $number): string {
    return match (true) {
        $number >= 1000000 => round($number / 1000000, 1) . 'M',
        $number >= 1000 => round($number / 1000, 1) . 'K',
        default => (string) $number
    };
}

/**
 * Get author social links
 */
function ida_author_social_links(?int $author_id = null): array {
    $author_id ??= get_the_author_meta('ID');
    
    $social = [];
    
    // Get from user meta (you can add custom fields)
    $twitter = get_the_author_meta('twitter', $author_id);
    $facebook = get_the_author_meta('facebook', $author_id);
    $linkedin = get_the_author_meta('linkedin', $author_id);
    $instagram = get_the_author_meta('instagram', $author_id);
    
    if ($twitter) $social['twitter'] = $twitter;
    if ($facebook) $social['facebook'] = $facebook;
    if ($linkedin) $social['linkedin'] = $linkedin;
    if ($instagram) $social['instagram'] = $instagram;
    
    return $social;
}

/**
 * Sanitize output
 */
function ida_sanitize_output(string $content): string {
    return wp_kses_post($content);
}
