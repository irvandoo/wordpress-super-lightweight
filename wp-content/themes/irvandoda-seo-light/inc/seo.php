<?php
declare(strict_types=1);

/**
 * SEO Functions
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

/**
 * Output meta tags
 */
function ida_meta_output(): void {
    do_action('ida_meta');
    do_action('ida_og');
    do_action('ida_schema');
}
add_action('wp_head', 'ida_meta_output', 5);

/**
 * Basic meta tags
 */
function ida_basic_meta(): void {
    global $post;
    
    // Charset
    echo '<meta charset="' . esc_attr(get_bloginfo('charset')) . '">' . "\n";
    
    // Viewport
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">' . "\n";
    
    // Description
    $description = match (true) {
        is_singular() => has_excerpt() ? get_the_excerpt() : wp_trim_words(strip_tags($post->post_content), 25),
        is_category() || is_tag() || is_tax() => term_description(),
        default => get_bloginfo('description')
    };
    
    if ($description) {
        echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($description)) . '">' . "\n";
    }
    
    // Robots
    if (is_singular()) {
        echo '<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">' . "\n";
    }
}
add_action('ida_meta', 'ida_basic_meta');

/**
 * Open Graph tags
 */
function ida_og_tags(): void {
    global $post;
    
    if (!is_singular()) {
        return;
    }
    
    // OG Type
    echo '<meta property="og:type" content="article">' . "\n";
    
    // OG Title
    echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
    
    // OG Description
    $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(strip_tags($post->post_content), 25);
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    
    // OG URL
    echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
    
    // OG Image
    if (has_post_thumbnail()) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        if ($image) {
            echo '<meta property="og:image" content="' . esc_url($image[0]) . '">' . "\n";
            echo '<meta property="og:image:width" content="' . esc_attr($image[1]) . '">' . "\n";
            echo '<meta property="og:image:height" content="' . esc_attr($image[2]) . '">' . "\n";
        }
    }
    
    // OG Site Name
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    
    if (has_post_thumbnail()) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        if ($image) {
            echo '<meta name="twitter:image" content="' . esc_url($image[0]) . '">' . "\n";
        }
    }
}
add_action('ida_og', 'ida_og_tags');

/**
 * Canonical URL
 */
function ida_canonical(): void {
    if (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
    }
}
add_action('wp_head', 'ida_canonical', 1);
