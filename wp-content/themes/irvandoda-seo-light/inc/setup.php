<?php

declare(strict_types=1);

/**
 * Theme Setup - PHP 8.4 Optimized
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

/**
 * Theme setup
 */
function ida_setup(): void {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    add_theme_support('automatic-feed-links');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    
    // Image sizes - using named arguments for clarity
    add_image_size(
        name: 'ida-featured',
        width: 720,
        height: 405,
        crop: true
    );
    
    add_image_size(
        name: 'ida-related',
        width: 360,
        height: 203,
        crop: true
    );
    
    // Register nav menus
    register_nav_menus([
        'primary' => esc_html__('Primary Menu', 'irvandoda-seo-light'),
        'footer' => esc_html__('Footer Menu', 'irvandoda-seo-light')
    ]);
    
    // Content width
    $GLOBALS['content_width'] = 720;
}
add_action('after_setup_theme', 'ida_setup');

/**
 * Register widget areas
 */
function ida_widgets_init(): void {
    register_sidebar([
        'name'          => esc_html__('Sidebar', 'irvandoda-seo-light'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'irvandoda-seo-light'),
        'before_widget' => '<section id="%1$s" class="ida-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="ida-widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'ida_widgets_init');
