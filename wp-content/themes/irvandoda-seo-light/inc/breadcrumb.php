<?php
declare(strict_types=1);

/**
 * Breadcrumb Navigation
 * 
 * @package Irvandoda_SEO_Light
 */

if (!defined('ABSPATH')) exit;

/**
 * Display breadcrumb
 */
function ida_breadcrumb(): void {
    if (is_front_page()) {
        return;
    }
    
    $separator = '<span class="ida-breadcrumb-separator" aria-hidden="true">/</span>';
    
    echo '<nav class="ida-breadcrumb" aria-label="Breadcrumb">';
    echo '<ol class="ida-breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">';
    
    // Home
    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a href="' . esc_url(home_url('/')) . '" itemprop="item"><span itemprop="name">Home</span></a>';
    echo '<meta itemprop="position" content="1" />';
    echo '</li>';
    echo $separator;
    
    $position = 2;
    
    if (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html($term->name) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" itemprop="item">';
            echo '<span itemprop="name">' . esc_html($category->name) . '</span>';
            echo '</a>';
            echo '<meta itemprop="position" content="' . $position++ . '" />';
            echo '</li>';
            echo $separator;
        }
        
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_page()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_search()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">Search Results</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_404()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">404 Not Found</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}
