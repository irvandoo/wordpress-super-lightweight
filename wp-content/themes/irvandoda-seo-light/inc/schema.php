<?php
declare(strict_types=1);

/**
 * Schema.org Structured Data
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

/**
 * Output schema
 */
function ida_schema_output(): void {
    if (is_singular('post')) {
        ida_article_schema();
    }
    
    if (!is_front_page()) {
        ida_breadcrumb_schema();
    }
    
    ida_organization_schema();
}
add_action('ida_schema', 'ida_schema_output');

/**
 * Article Schema
 */
function ida_article_schema(): void {
    global $post;
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title(),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'author' => [
            '@type' => 'Person',
            'name' => get_the_author(),
            'url' => get_author_posts_url(get_the_author_meta('ID'))
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => get_site_icon_url()
            ]
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => get_permalink()
        ]
    ];
    
    // Add image
    if (has_post_thumbnail()) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        if ($image) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => $image[0],
                'width' => $image[1],
                'height' => $image[2]
            ];
        }
    }
    
    // Add description
    if (has_excerpt()) {
        $schema['description'] = get_the_excerpt();
    }
    
    // Add word count
    $content = strip_tags($post->post_content);
    $word_count = str_word_count($content);
    $schema['wordCount'] = $word_count;
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}

/**
 * BreadcrumbList Schema
 */
function ida_breadcrumb_schema(): void {
    $items = [];
    $position = 1;
    
    // Home
    $items[] = [
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'Home',
        'item' => home_url('/')
    ];
    
    // Category/Archive
    if (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $term->name,
            'item' => get_term_link($term)
        ];
    }
    
    // Single post
    if (is_singular('post')) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $category->name,
                'item' => get_category_link($category->term_id)
            ];
        }
        
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink()
        ];
    }
    
    if (count($items) > 1) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}

/**
 * Organization Schema
 */
function ida_organization_schema(): void {
    if (!is_front_page()) {
        return;
    }
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'logo' => [
            '@type' => 'ImageObject',
            'url' => get_site_icon_url()
        ]
    ];
    
    if (get_bloginfo('description')) {
        $schema['description'] = get_bloginfo('description');
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
